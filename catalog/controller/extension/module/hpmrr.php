<?php

class ControllerExtensionModuleHpmrr extends Controller
{
    private 
        $sid_by_pid = [], 
        $series_by_id = [], 
        $column_namess = [],
        $prepare_prods = [],
        $products = [],
        $is_parent = [],
        $ids = [],
        $is_product_card = false,
        $sizes = array(),
        $ptm = "extension/module/hpmrr";
        

    // public function test()
    // {
    //     $product['id'] = $_GET['pid'];
    //     $parent_id = $_GET['pa'];

    //     $check = $this->db->query("SELECT COUNT(*) as total 
    //             FROM " . DB_PREFIX . "hpmrr_links 
    //             WHERE (product_id IN (". (int) $product['id'] . ", ". (int) $parent_id . ") AND product_id != parent_id)
    //             OR (parent_id = ".(int) $product['id']." AND product_id = parent_id)
    //         ");

    //     echo $check->row['total'] == 0 ? "ADD" : "STOP";

    // }
    
    function load_lang_and_model()
    {
        $this->load->language($this->ptm);
        $this->load->model('tool/image');
        $this->load->model($this->ptm);   
    }

    function load_css_js()
    {
        $this->loadMedia();
        $this->loadModuleMedia();
    }
    function set_sort()
    {
        $sorts = explode("\r\n", $this->config->get(kjhelper::$key_prefix . 'hpmrr_sort_vals'));
        $num = 1;
        foreach ($sorts as $key)
        {
            $this->sizes[strtolower($key)] = (int) $this->config->get(kjhelper::$key_prefix . 'hpmrr_sort_offset') + $num++;
        }
    }

    public function get_result_arr()
    {
       
        $result = [];

        foreach($this->ids as $id)
        {
            $result[$id] = $this->hpm_mode($id);
        }

        return $result;
    }
    
    public function loadMedia()
    {
        if (empty($this->config->get(kjhelper::$key_prefix . 'hpmrr_include_media')))
            return;
 
        $media = explode("\r\n", $this->config->get(kjhelper::$key_prefix . 'hpmrr_include_media'));

        if ($media)
        {
            foreach ($media as $m)
            {
                if (strstr($m, '.css') !== false) 
                    $this->document->addStyle($m);
                else if (strstr($m, '.js') !== false) 
                    $this->document->addScript($m);
            }
        }
    }

    public function get_series_by_pid($pid)
    {
        if(!empty($this->sid_by_pid[$pid]) && !empty($this->series_by_id[$this->sid_by_pid[$pid]]))
        {
            return $this->series_by_id[$this->sid_by_pid[$pid]];
        }
    }
    
    public function loadModuleMedia()
    {
        $this->document->addStyle('catalog/view/javascript/hpmrr/kit-series.css');
        $this->document->addScript('catalog/view/javascript/hpmrr/script.js');
    }

    public function parse_key($key)
    {
        if(strripos($key, "attr_") !== false)
            return (int) str_replace("attr_", "", $key);
        else
            return false;
    }

    public function get_column_names($columns)
    {
        $column_names = [];

        foreach ($columns as $column)
        {
            if(empty($column['key']) || $column['key'] == 'none')
            {
                continue;
            }

            $column_key_4symb = substr($column['key'], 0, 4);

            if (empty($column['key']) || $column['key'] == 'none')
            {
                continue;
            }

            if ($column_key_4symb == "attr")
            {
                $attr_id = (int) substr($column['key'], 5);
                $column_names[$column['key']] = $this->model_extension_module_hpmrr->getAttrName($attr_id);
            }
            else if($column_key_4symb == "ocf_")
            {
                $filter_key = substr($column['key'], 4);
                $parts = explode(".", $filter_key);
                $filter_id = (int) $parts[0];
                $source = (int) $parts[1];

                $column_names[$column['key']] = $this->model_extension_module_hpmrr->get_filter_name($filter_id, $source);
            }
            else
            {
                $column_names[$column['key']] = $this->language->get($column['key']);
            }
        }

        return $column_names;
    }

    function add_to_res($key, $val, $product_id, $sort, &$res)
    {
        $key = trim($key);
        if(empty($key)) return;

        
        if(!isset($res[$key]))
        {
            $res[$key] = [
                'products' => [ $product_id ],
                'val' => $val . $this->get_price_for_btn($product_id),
                'sort' => (int) $sort,
                'key' => $key 
            ];
        }
        else
        {
            $res[$key]['products'][] = $product_id;
            $res[$key]['sort'] += (int) $sort;
        }
    }

    function set_childs_info(&$result_arr, $parent_id)
    {
        $childs_ids = $this->model_extension_module_hpmrr->get_products_by_pid2($parent_id);
        $result_arr['childs_info'] = [];

        foreach($childs_ids as $prid)
        {
            if(!isset($this->prepare_prods[$prid]))
            {
                $this->prepare_prods[$prid] = $this->prepare_product($this->model_catalog_product->getProduct($prid));
            }

            if($this->prepare_prods[$prid])
            {
                $result_arr['childs_info'][$prid] = $this->prepare_prods[$prid];
            }
        }
        
        $result_arr['min_max'] = $this->get_min_max_price($childs_ids);

        if(!empty($result_arr['childs_info'][$parent_id]))
        {
            $result_arr['parent_info'] = $result_arr['childs_info'][$parent_id];
        }
        else
        {
            $result_arr['parent_info'] = false;
        }
    }

    function set_rows($parent_id, $id, &$rows)
    {
        //$result_arr['childs_info'] = array_filter($result_arr['childs_info']);

        $split_attr_enable = $this->config->get(kjhelper::$key_prefix . 'hpmrr_split_attr_enable');
        $split_attr_delim = $this->config->get(kjhelper::$key_prefix . 'hpmrr_split_attr_delim');


        $attrs_for_img = [
            'width' => $this->serie['image_width'],
            'height' => $this->serie['image_height'],
            'class' => 'img-resp'
        ];

        foreach($this->serie['prepare_columns'] as $column)
        {
            
            $attr_id = $this->parse_key($column['key']);

            if($this->is_product_card)
            {
                $products = $this->model_extension_module_hpmrr->get_buttons($parent_id, $column['key']);
            }
            else
            {
                $grsort = $this->model_extension_module_hpmrr->get_sort($id);
                $products = $this->model_extension_module_hpmrr->get_buttons($parent_id, $column['key'], $grsort);
            }

            if($products)
            {
                $res = [];

                foreach($products as $row)
                {
                    $val = trim($row['val']);
                    
                    if(empty($val))
                    {
                        continue;
                    }

                    if($split_attr_enable && $attr_id && $split_attr_delim)
                    {
                        $gr_vals = explode($split_attr_delim, $val);
                        foreach($gr_vals as $gr_val)
                        {
                            $this->add_to_res($gr_val, $val, $row['product_id'], $row['sort'], $res);
                        }
                    }
                    else
                    {
                        $gr_val = $val;

                        if($column['key'] == 'image')
                        {
                            $src = $this->model_tool_image->resize($val, $this->serie['image_width'], $this->serie['image_height']);

                            if(!$src)
                            {
                                continue;
                            }

                            $attrs_for_img['src'] = $src;
                            $prep_val = $this->tag('img', $attrs_for_img);
                        }
                        else if($column['key'] == 'image2')
                        {
                            if (file_exists(DIR_IMAGE.$gr_val)) 
                            {
                                $gr_val = filesize(DIR_IMAGE.$gr_val); 
                            }

                            $src = $this->model_tool_image->resize($val, $this->serie['image_width'], $this->serie['image_height']);

                            if(!$src)
                            {
                                continue;
                            }

                            $attrs_for_img['src'] = $src;
                            $prep_val = $this->tag('img', $attrs_for_img);
                        }
                        else if($column['key'] == 'width' || $column['key'] == 'height' || $column['key'] == 'length')
                        {
                            $prep_val = $this->length->format($val, $row['length_class_id']);
                        }
                        else if($column['key'] == 'custom3')
                        {
                            $custom_img_src = null;

                            if(!empty($row['custom_image']))
                            {
                                $custom_img_src = $this->model_tool_image->resize($row['custom_image'], $this->serie['image_width'], $this->serie['image_height']);
                            }
                            
                            if($custom_img_src)
                            {
                                $gr_val = $row['custom_image'];
                                $attrs_for_img['src'] = $custom_img_src;
                                $prep_val = $this->tag('img', $attrs_for_img);
                            }
                            else if(!empty($row['isbn']))
                            {
                                $gr_val = $row['isbn'];
                                $prep_val = $row['isbn'];
                            }
                            else
                            {
                                continue;
                            }
                        }
                        else if($column['key'] == 'custom1')
                        {
                            continue;
                        }
                        else if($column['key'] == 'custom2')
                        {
                            continue;
                        }
                        else if($column['key'] == 'col_weight')
                        {
                            $prep_val = $this->weight->format($val, $row['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point'));
                        }
                        else if($column['key'] == 'col_size')
                        {
                            $prep_val =  $this->length->format($row['length'], $row['length_class_id']) . ' x ' . $this->length->format($row['width'], $row['length_class_id']) . ' x ' . $this->length->format($row['height'], $row['length_class_id']);
                        }
                        else if($column['key'] == 'isbn')
                        {
                            $prep_val = $val;
                        }
                        else
                        {
                            if(!empty($row['image']))
                            {

                                $attrs_for_img['src'] = $this->model_tool_image->resize($row['image'], $this->serie['image_width'], $this->serie['image_height']);
                                $gr_val = $row['image'];
                                $prep_val = $this->tag('img', $attrs_for_img);
                            }
                            else
                            {
                                $prep_val = $val;
                            }

                            if($this->config->get(kjhelper::$key_prefix . 'hpmrr_oat_enabled') && $attr_id)
                            {
                                //if($row['aimage'])
                                if(!empty($row['aimage']))
                                {
                                    $custom_img_src = $this->model_tool_image->resize($row['aimage'], 55,55);

                                    if($custom_img_src)
                                    {
                                        $prep_val = "<img class='img-responsive img-fluid' src='".$custom_img_src."'></br>".$prep_val;
                                    }
                                }
                            }
                        }
                        
                        $this->add_to_res($gr_val, $prep_val, $row['product_id'], $row['sort'], $res);
                    }
                }

                if($res)
                {
                    $rows[$column['key']] = $res;
                }
            }


        }
    }

    public function get_hpmv3($id)
    {
        $parent_id = $this->model_extension_module_hpmrr->getParent($id);
        if(!$parent_id)
        {
            return;
        }
        $result_arr = [];
        $this->set_childs_info($result_arr, $parent_id);
        $this->set_rows($parent_id, $id, $result_arr['rows']);
        $this->sort_logic($parent_id, $result_arr['rows']);
        $this->set_active($id, $result_arr['rows']);
        //$this->cache_data[$parent_id] = $result_arr;
        //refactoring 08.02.2025 
        return $result_arr;
    }

    private $cache_data;

    function set_active($id, &$rows)
    {
        if(empty($rows))
        {
            return;
        }

        foreach($rows as &$row)
        {
            foreach($row as &$btn)
            {
                $btn['is_active'] = array_search($id, $btn['products']) !== false;
            }
        }
    }

    function sort_logic($parent_id, &$rows)
    {   
        if(empty($rows))
        {
            return;
        }

        $auto_sort = $this->model_extension_module_hpmrr->is_autosort($parent_id);
        //lesgo
        if($auto_sort)
        {
            foreach($rows as &$row)
            {
                foreach($row as &$btn)
                {
                    $btn['sort'] = $btn['sort']/count($btn['products']);
                }

                usort($row, function ($item1, $item2) 
                {
                    if ($item1['sort'] == $item2['sort']) 
                    {
                        return 0;
                    }
                    return ($item1['sort'] < $item2['sort']) ? -1 : 1;
                });
            }
        }
        else
        {
            //echo "<PRE>";var_dump($rows);exit();

            foreach($rows as &$row)
            {
                usort($row, function ($item1, $item2) 
                {
                    $a = $this->size_format($item1['key']);
                    $b = $this->size_format($item2['key']);

                    if ($a == $b) 
                    {
                        return 0;
                    }
                    return ($a < $b) ? -1 : 1;
                });
            }
           
        }
    }

    function size_format($val)
    {

        if(isset($this->sizes[strtolower($val)]))
        {
            return $this->sizes[strtolower($val)];
        }
        else if(is_numeric($val))
        {
           return floatval($val);
        }
        else
        {
            return $val;
        }
    }

    function groupBy($array, $key) 
    {
        $result = [];

        foreach ($array as $item) 
        {
            $groupKey = $item[$key];
            if (!isset($result[$groupKey])) 
            {
                $result[$groupKey] = [];
            }
            $result[$groupKey][] = $item;
        }

        return $result;
    }

    function get_price_for_btn($pid)
    {
        $price_html = "";

        if($this->prepare_prods[$pid] && (($this->is_product_card && $this->serie['show_price_prdcard']) || (!$this->is_product_card && $this->serie['show_price_cat'])))
        {
            if($this->prepare_prods[$pid]['special'])
            {
                $price_html = $this->tag('div',['class' => 'hpmrr-price'], $this->prepare_prods[$pid]['special']);
            }
            else
            {
                $price_html = $this->tag('div',['class' => 'hpmrr-price'], $this->prepare_prods[$pid]['price']);
            }
        }
        
        return $price_html;
    }

    function prepare_product($result)
    {
        if(!$result)
        {
            return false;
        }
           
                if(floatval(VERSION) >= 3)
                {
                    $prefix = 'theme_' . $this->config->get('config_theme');
                }
                else if(floatval(VERSION) >= 2.3)
                {
                    $prefix = $this->config->get('config_theme');
                }
                else
                {
                    $prefix = 'config';
                }

            if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get($prefix . '_image_thumb_width'), $this->config->get($prefix . '_image_thumb_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($prefix . '_image_thumb_width'), $this->config->get($prefix . '_image_thumb_height'));
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $price_noformat = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);

                } else {
                    $price = false;
                }

                if (!is_null($result['special']) && (float)$result['special'] >= 0) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $special_noformat = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);

                    $tax_price = (float)$result['special'];

                } else {
                    $special = false;
                    $special_noformat = false;
                    $tax_price = (float)$result['price'];
                }
    
                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format($tax_price, $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }

                return array(
                    'stock_status'   => $result['stock_status'],
                    'sku'   => $result['sku'],
                    'manufacturer' => $result['manufacturer'],
                    'meta_description' => $result['meta_description'],
                    'product_id'  => $result['product_id'],
                    'thumb'       => $image,
                    'name'        => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'price_noformat' => $price_noformat,
                    'special'     => $special,
                    'special_noformat' => $special_noformat,
                    'quantity'    => $result['quantity'],
                    'tax'         => $tax,
                    'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating'      => $rating,
                    'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                );
    }

    function get_min_max_price($ids)
    {
        $min_price = PHP_INT_MAX;
        $max_price = 0;

        if($ids)
        {
            foreach($ids as $id)
            {
                if($this->prepare_prods[$id])
                {
                    $current_price = $this->prepare_prods[$id]['special_noformat'] ? $this->prepare_prods[$id]['special_noformat'] : $this->prepare_prods[$id]['price_noformat'];

                    if($current_price > $max_price)
                    {
                        $max_price = $current_price;
                    }
                    if($current_price < $min_price)
                    {
                        $min_price = $current_price;
                    }
                }
            }
        }
        
        return sprintf($this->language->get('text_min_max'), $this->currency->format($min_price, $this->session->data['currency'], 1) , $this->currency->format($max_price, $this->session->data['currency'], 1));
    }

    function all_ids_out_of_stock($ids)
    {
        if($ids)
        {
            foreach($ids as $id)
            {
                if($this->prepare_prods[$id] && $this->prepare_prods[$id]['quantity'] > 0)
                {
                    return false;
                }
            }
        }
        return true;
    }
    function hpm_links_beta($res)
    {   
        $available = [];
        $unavailable = [];

        if($res)
        {
            $active_pids = [];
            foreach($res as $column_key => $buttons)
            {
                $products = [];
                foreach($buttons as $button)
                {
                    if($button['is_active'])
                    {
                        $products = $button['products'];
                        break;
                    }
                }
                $active_pids[] = $products;
            }
            
            $filter_ids = $this->get_filter_by_line($active_pids);
               
            $i = 0;
            foreach($res as $column_key => $buttons)
            {
                foreach($buttons as $btn_key => $button)
                {

                    $ids = $button['products'];
                    $class = [];
                    if($button['is_active'])
                    {
                        $class[] = "active";
                    }

                    if($filter_ids[$i])
                    {
                        $intersect = array_intersect($filter_ids[$i], $button['products']);
                        if($intersect)
                        {
                           $ids = array_values($intersect);
                        }
                        else
                        {
                            $class[] = "disabled";
                        }
                    }

                    foreach($ids as $id)
                    {
                        if($this->prepare_prods[$id])
                        {
                            $preferred_id = $id;
                            break;
                        }
                    }

                    if($this->all_ids_out_of_stock($ids))
                    {
                        $class[] = "out-stock";
                        if($this->config->get('config_stock_display'))
                        {
                             $res[$column_key][$btn_key]['name'] = $this->prepare_prods[$preferred_id]['quantity'];
                        }
                        else
                        {
                            $res[$column_key][$btn_key]['name'] = $this->prepare_prods[$preferred_id]['stock_status'];
                        }

                    }
                    else
                    {
                        $res[$column_key][$btn_key]['name'] = $this->prepare_prods[$preferred_id]['name'];
                    }

                    $hpmrr_hover_img = $this->config->get(kjhelper::$key_prefix . 'hpmrr_hover_img');

                    if($hpmrr_hover_img == 1)
                    {
                        $res[$column_key][$btn_key]['title'] = "<div style='width:75px'><img src='".$this->prepare_prods[$preferred_id]['thumb']."' class='img-responsive img-fluid'>".$res[$column_key][$btn_key]['name']."</div>";
                    }
                    else if($hpmrr_hover_img == 0)
                    {
                        $res[$column_key][$btn_key]['title'] = $res[$column_key][$btn_key]['name'];

                        // if($column_key == 'isbn' || $column_key == 'image')
                        // {
                        //     $attribute_id = 55;

                        //     $query = $this->db->query("SELECT text FROM " . DB_PREFIX . "product_attribute 
                        //        WHERE product_id = '" . (int)$preferred_id . "' 
                        //        AND attribute_id = '" . (int)$attribute_id . "' 
                        //        AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

                        //     if ($query->num_rows) 
                        //     {
                        //         $res[$column_key][$btn_key]['title'] = $query->row['text'];
                        //     }
                        // }
                    }
                    else
                    {
                        $res[$column_key][$btn_key]['title'] = '';
                    }

                    $res[$column_key][$btn_key]['img'] = $this->prepare_prods[$preferred_id]['thumb'];
                    $res[$column_key][$btn_key]['class'] = implode(" ", $class);
                    $res[$column_key][$btn_key]['id'] = $preferred_id;
                    $res[$column_key][$btn_key]['link'] = $this->url->link('product/product', 'product_id=' . $preferred_id );
                }
                $i++;
            }
       
            //    echo "<PRE>";var_dump($this->prepare_prods[$id]);exit();
            return $res;
        }
    }
    function get_filter_by_line($data)
    {
        $allow_id_by_line = [];

        if(count($data) > 1)
        {
            for($i = 0; $i < count($data); $i++)
            {
                $cpy_data = $data;
                unset($cpy_data[$i]);

                $cpy_data = array_values(array_filter($cpy_data));

                if($cpy_data)
                {
                    $intersect = $cpy_data[0];
                    for($j = 1; $j < count($cpy_data); $j++)
                    {
                        $intersect = array_intersect($intersect, $cpy_data[$j]);
                    }
                }
                else
                {
                    $intersect = [];
                }

                $allow_id_by_line[] = $intersect;
            }
        }
        else if(count($data) == 1)
        {
            $allow_id_by_line[] = [];
        }

        return $allow_id_by_line; 
    }

    public function hpm_mode($id)
    {
        $data = [];
        $this->serie = $this->get_series_by_pid($id);
        //echo "<PRE>";var_dump($this->serie);exit();
        if(!$this->serie)
        {
            return;
        }

        
        if($this->is_product_card)
        {
            $data['schemaorg'] = $this->serie['schemaorg'];
        }
        else if($this->serie['category_variant'] !== 'ON')
        {
            return;
        }

        if(empty($this->serie['prepare_columns']))
        {
            return;
        }

        $prep_data = $this->get_hpmv3($id);
        if(empty($prep_data['rows']))
        {
            return ;
        }

        $data['product_image_width'] = $this->serie['image_width'];
        $data['product_image_height'] = $this->serie['image_height'];

        $data['show_minmax'] = $this->is_product_card ? $this->serie['minmax_price_prdcard'] : $this->serie['minmax_price_cat'];
   
        $data['product_name_as_title'] = $this->serie['name_as_title'];

        $data['title_name'] = html_entity_decode($this->serie['title'][$this->config->get('config_language_id')]);
        $data['column_names'] = $this->serie['prepare_columns_names'];
        $data['product_columns'] = $this->serie['prepare_columns'];
        $data['res'] = $this->hpm_links_beta($prep_data['rows']);


        $data['gradient_status'] = $this->config->get(kjhelper::$key_prefix . 'hpmrr_gradient_status');
        $data['gradient_color'] = $this->config->get(kjhelper::$key_prefix . 'hpmrr_gradient');
        
        $data['min_max'] = $prep_data['min_max'];
        $data['childs_info'] = $prep_data['childs_info'];
        $data['parent_info'] = $prep_data['parent_info'];

        $data['id'] = $id;
        $data['serie_id'] = $this->serie['id'];

        if($this->is_product_card)
        {
            if(floatval(VERSION) < 2.3)
            {
                return $this->load->view('default/template/extension/module/hpmrr/product_hpm.tpl', $data);
            }
            else
            {
                return $this->load->view('extension/module/hpmrr/product_hpm', $data);
            }
        }
        else
        {
            if(floatval(VERSION) < 2.3)
            {
                return $this->load->view('default/template/extension/module/hpmrr/cat_hpm.tpl', $data);
            }
            else
            {
                return $this->load->view('extension/module/hpmrr/cat_hpm', $data);
            }
        }
    }

    public function dump($res)
    {
        echo "<PRE>";
        var_dump($res);
        echo "</PRE>";
    }
    public function filter_keys($x)
    {
        return !empty($x['key']) && $x['key'] != 'none'; 
    }

    public function set_types()
    {
        $this->types = $this->model_extension_module_hpmrr->getTypes();
        foreach($this->ids as $id)
        {
            $this->sid_by_pid[$id] = $this->get_type_key($id);
        }

        if(!empty($this->sid_by_pid))
        {
            $this->series_by_id = $this->model_extension_module_hpmrr->getTypes(array_unique($this->sid_by_pid));
            foreach($this->series_by_id as $id => $serie) 
            { 
                //$this->series_by_id[$id]['prepare_column_names'] = $this->get_column_names($id);

                $pre = $this->is_product_card ? "product" : "category";
                
                $this->series_by_id[$id]['prepare_columns'] = array_filter(json_decode($serie[$pre.'_columns'], true), array($this, "filter_keys"));
                $this->series_by_id[$id]['title'] = json_decode($serie[$pre.'_title'], true);
                $this->series_by_id[$id]['name_as_title'] = $serie[$pre.'_name_as_title'];

                $this->series_by_id[$id]['prepare_columns_names'] = $this->get_column_names($this->series_by_id[$id]['prepare_columns']);

                if($this->is_product_card)
                {
                    $this->series_by_id[$id]['image_width'] = is_numeric($serie['product_image_width']) ? $serie['product_image_width'] : 50;
                    $this->series_by_id[$id]['image_height'] = is_numeric($serie['product_image_height']) ? $serie['product_image_height'] : 50;
                }
                else
                {
                    $this->series_by_id[$id]['image_width'] = is_numeric($serie['category_image_width']) ? $serie['category_image_width'] : 50;
                    $this->series_by_id[$id]['image_height'] = is_numeric($serie['category_image_height']) ? $serie['category_image_height'] : 50;
                }

            }
            
        }
    }
    
    public function get_block($data)
    {
        $this->load_lang_and_model();
        $this->is_product_card = $data['is_product_card'];
        $this->ids = [ $data['pid'] ];
        $this->set_types();
    
        return $this->hpm_mode($data['pid']);
    }

    public function get_block_ajax()
    {
        
        if(!isset($this->request->get['pid']))
        {
            return;
        }

        if(isset($this->request->get['is_product_card']))
        {
            $data['is_product_card'] = (bool) $this->request->get['is_product_card'];
        }
        else
        {
            $data['is_product_card'] = true;
        }
        
        $data['pid'] = (int) $this->request->get['pid'];
        echo $this->get_block($data);
    }

    public function product_json()
    {
        $json = [];

        if(isset($this->request->get['pid']))
        {
            $product_id = (int) $this->request->get['pid'];
            $this->load->language('product/product');
            $this->load->model('catalog/product');
            $this->load_lang_and_model();

            $result = $this->model_catalog_product->getProduct($product_id);

            if(!empty($result))
            {

                $this->ids = [ $product_id ];
                $this->is_product_card = false;
                $this->set_types();

                $this->set_sort();
                $hpm = $this->hpm_mode($product_id);

                if(floatval(VERSION) >= 3)
                {
                    $prefix = 'theme_' . $this->config->get('config_theme');
                }
                else if(floatval(VERSION) >= 2.3)
                {
                    $prefix = $this->config->get('config_theme');
                }
                else
                {
                    $prefix = 'config';
                }
            
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get($prefix . '_image_product_width'), $this->config->get($prefix . '_image_product_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($prefix . '_image_product_width'), $this->config->get($prefix . '_image_product_height'));
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $price_noformat = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);
                } else {
                    $price = false;
                    $price_noformat = false;
                }

                if (!is_null($result['special']) && (float)$result['special'] >= 0) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $special_noformat = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);
                    $tax_price = (float) $result['special'];
                } else {
                    $special = false;
                    $special_noformat = false;
                    $tax_price = (float) $result['price'];
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format($tax_price, $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }

                if ($result['quantity'] <= 0) {
                    $stock = $result['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $stock = $result['quantity'];
                } else {
                    $stock = $this->language->get('text_instock');
                }

                $json['success'] = array(
                    'product_id'  => $result['product_id'],
                    'attribute_groups' => $this->model_catalog_product->getProductAttributes($result['product_id']),
                    'thumb'       => $image,
                    'stock'       => $stock,
                    'quantity'    => $result['quantity'],
                    'model'       => $result['model'],
                    'sku'         => $result['sku'],
                    'hpm'         => $hpm,
                    'name'        => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'price_noformat' => $price_noformat,
                    'special'     => $special,
                    'special_noformat' => $special_noformat,
                    'tax'         => $tax,
                    'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating'      => $result['rating'],
                    'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] )
                );
            }
            else
            {
                $json['error'] = 'product not find';
            }
        }
        else
        {
            $json['error'] = 'request->get[product_id] not find';
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    function set_ids($results)
    {
        foreach($results as $result)
        {
            if(is_numeric($result))
            {
                $this->ids[] = (int) $result;
            }
            else if(isset($result['product_id']))
            {
                $this->ids[] = (int) $result['product_id'];
                $this->products[(int) $result['product_id']] = $result;
            }
        }
    }

    public function getFormForList($data)
    {
        $this->is_product_card = $data['is_cat'] ? 0 : 1;
        $this->load_css_js();
        $this->load_lang_and_model();
        $results = $data['products'];

        if (empty($results)) return;

        $this->set_ids($results);

        if(empty($this->ids) && !count($this->ids))
            return;

        $this->set_types();
        $this->ids = array_keys($this->sid_by_pid);

        if(empty($this->ids) && !count($this->ids))
            return;

        $this->set_sort();
        $res = $this->get_result_arr();
        $res = array_filter($res);
        if(empty($res)) { return; }

        if($this->is_product_card)
        {
            $config_data = [
                'hpmrr_custom_js' => html_entity_decode($this->serie['custom_js']),
                'hpmrr_selector' => $this->serie['product_selector'],
                'hpmrr_position' => $this->serie['product_position'],
                'hpmrr_redirect' => $this->config->get(kjhelper::$key_prefix . 'hpmrr_ajax') ? "false" : "true"
                //'is_parent' => $this->is_parent[$id]
            ];

            if(floatval(VERSION) < 2.3)
            {
                $cfg = $this->load->view('default/template/extension/module/hpmrr/prod_cssjs.tpl', $config_data);
            }
            else
            {
                $cfg = $this->load->view('extension/module/hpmrr/prod_cssjs', $config_data);
            }

            $res[$this->ids[0]] .= $cfg;
        }

        return $res;
    }

    public function tag($tag, $attrs = [] , $val = false)
    {
        $res = "<" . $tag;
        if ($attrs) foreach ($attrs as $key => $v)
            $res .= " " . $key . "=" . "'" . $v . "' ";

        $res .= ">";

        if ($val) 
            $res .= $val . "</" . $tag . ">";

        return $res;
    }
    
    public function getCanonicalUrl()
    {
        $this->load_lang_and_model();
        $this->is_product_card = true;

        $parent_id = $this->model_extension_module_hpmrr->getParent($this->request->get['product_id']);

        if ($parent_id)
        {

            $this->ids = [ $parent_id ];
            
            $this->set_types();

            $serie = $this->get_series_by_pid($parent_id);
            
            if($serie && (int) $serie['canonical'])
            {
                return $this->url->link('product/product', "product_id=" . $parent_id);
            }
        }

        return false;
    }

    function get_cart_prod($product_id, $quantity = 1, $option = array(), $recurring_id = 0) 
    {
        $option['unique'] = 'unique';
        $this->cart->add($product_id, $quantity, $option, $recurring_id);
        $query = $this->db->query("SELECT MAX(cart_id) as cart_id FROM ".DB_PREFIX."cart");
        $cart_id = $query->row['cart_id'];
        $prods = $this->cart->getProducts();
        foreach($prods as $prod)
        {
            if($prod['cart_id'] == $cart_id)
            {
                $last_prod = $prod;
                break;
            }
        }

        $this->cart->remove($cart_id);
        return $last_prod;
    }

    public function get_price()
    {
        $this->load->model('catalog/product');

        $product_id = $this->request->post['product_id'];

        $pinfo = $this->model_catalog_product->getProduct($product_id);

        if ($pinfo) 
        {
            $quantity = $this->request->post['quantity'];

            if(!empty($this->request->post['option']))
            {
                $option = $this->request->post['option'];
            }
            else
            {
                $option = [];
            }

            $data1 = $this->get_cart_prod($product_id, $quantity, $option);

            if((float) $pinfo['special'])
            {
                $this->session->data['stop_special'] = true;
                $data2 = $this->get_cart_prod($product_id, $quantity, $option);
                unset($this->session->data['stop_special']);

                $json['no_format']['old_price'] = $data2['price'];
                $json['no_format']['old_total'] = $data2['total'];
                $json['no_format']['price'] = $data1['price'];
                $json['no_format']['total'] = $data1['total'];

                $json['format']['old_price'] = $this->currency->format($this->tax->calculate($data2['price'], $pinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $json['format']['old_total'] = $this->currency->format($this->tax->calculate($data2['total'], $pinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $json['format']['price'] = $this->currency->format($this->tax->calculate($data1['price'], $pinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $json['format']['total'] = $this->currency->format($this->tax->calculate($data1['total'], $pinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

            }
            else
            {
                $json['no_format']['price'] = $data1['price'];
                $json['no_format']['total'] = $data1['total'];

                $json['format']['price'] = $this->currency->format($this->tax->calculate($data1['price'], $pinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $json['format']['total'] = $this->currency->format($this->tax->calculate($data1['total'], $pinfo['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            }
            

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function get_is($pn, $pv)
    {
        return (!empty($this->request->get[$pn]) && $this->request->get[$pn] == $pv);
    }

    public function get_type_key($id)
    {
        $product = $this->model_catalog_product->getProduct($id);


        if (empty($product)) 
        {
            return false;
        }


        foreach ($this->types as $key => $type)
        {
            if (! (int) $type['status'] || !(int) $type['id']) 
                continue;
            
            //if (! (int) $type['links'])
            //{

                if (!empty($type['products']))
                {
                    $products_ids = explode(',', $type['products']);
                    if(array_search($id, $products_ids) === false)
                    {
                        continue;
                    }
                }

                if (!empty($type['category']))
                {
                    $need_cats = explode(',', $type['category']);
                    $product_cats = [];

                    $cats = $this->model_catalog_product->getCategories($id);
                    
                    if ($this->get_is('main_cat', 'yes'))
                    {
                        foreach ($cats as $cat)
                        {
                            if((int) $cat['main_category'])
                            {
                                $product_cats[] = $cat['category_id'];
                            }
                        }
                    }
                    else
                    {
                        foreach ($cats as $cat)
                        {
                            $product_cats[] = $cat['category_id'];
                        }
                    
                    }

                    if(empty($product_cats)) 
                    {
                        continue;
                    }

                    $c = array_intersect($product_cats, $need_cats);
                    if (count($c) == 0) 
                    {
                        continue;
                    }
                }

                if (!empty($type['manufacturer']))
                {
                    $need_manuf = explode(',', $type['manufacturer']);
                    $manufacturer_id = $product['manufacturer_id'];
                    if (array_search($manufacturer_id, $need_manuf) === false) 
                        continue;
                }

                if (!empty($type['suppler']))
                {
                    $model_parts = explode("-", $product['model']);

                    if(count($model_parts) <= 1)
                    {
                        continue;
                    }

                    $need_supps = explode(',', $type['suppler']);
                    $find_intersect = false;
                    $model_last_part = $model_parts[count($model_parts) - 1];

                    if(array_search($model_last_part, $need_supps) === false)
                    {
                        continue;
                    }
                }
            //}
            return $type['id'];
        }
        return false;
    }
}