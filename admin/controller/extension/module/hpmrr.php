<?php
    
class ControllerExtensionModuleHpmrr extends Controller
{
    
    private $error        = array();

    protected $_type  = array('type_unique', 'type_parent', 'type_related', 'type_multiple', 'type_multiple_plus');
    protected $_types = array('type_add', 'type_adding', 'type_check_plus', 'type_table_attrs', 'type_images', 'type_img_slide', 'type_ajax');
    protected $_box   = array('none', 'image', 'name', 'meta_h1', 'meta_keyword', 'sku', 'model', 'ean', 'upc', 'jan', 'isbn', 'mpn', 'location', 'col_size', 'col_weight');
    protected $_type_sample = array('OFF', 'ON');
    protected $_h_titles    = array('none', 'name', 'sku', 'meta_h1', 'description', 'meta_title', 'meta_keyword', 'sku', 'model', 'ean', 'upc',
        'jan', 'isbn', 'mpn', 'brand', 'location', 'col_size', 'col_weight', 'stock_status', 'quantity', 'price_special', 'reward');
    
    protected $_positions = array('insertBefore', 'insertAfter', 'prepend', 'append');
    
    protected $_columns   = array('none', 'image', 'image2', 'name', 'meta_h1', 'meta_title', 'meta_keyword', 'sku', 'model', 'ean', 'upc', 'jan', 'isbn', 'mpn', 'man', 'location', 'quantity', 'rew',  'col_size', 'col_weight', 'custom1', 'custom2', 'custom3');

    protected $_columns_type = [
        'button' => 'button',
        'select' => 'select',
        'select_img' => 'select з зображенням',
        'color_circle' => 'кружечок з колорьом'
    ];


    protected $_lang_keys = ['heading_titles', 'heading_title', 'name_kit_series', 'name_kj_series', 'name_series', 'add_name_series', 'name_kit', 'btn_documentation', 'title_name', 'title_cat_html', 'title_prod_html', 'text_name', 'text_name_title', 'text_comment', 'text_edit', 'text_enabled', 'text_disabled', 'sample_status_title', 'entry_sample_title', 'entry_width', 'entry_width_title', 'after_that', 'entry_types_column', 'entry_column_title', 'entry_type', 'entry_type_title', 'entry_types', 'entry_types_title', 'entry_links', 'entry_links_title', 'entry_titles', 'entry_status', 'entry_status_name', 'entry_position', 'entry_position_title', 'entry_selector', 'entry_selector_title', 'entry_suppler', 'entry_brand', 'entry_category', 'entry_view_title', 'col_sku_search', 'col_name_search', 'add_sku_product', 'add_name_product', 'col_add', 'none', 'name', 'name_img', 'description', 'image', 'sku', 'sku_img', 'meta_h1', 'meta_h1_img', 'meta_title', 'meta_description', 'meta_keyword', 'meta_keyword_img', 'model', 'model_img', 'ean', 'ean_img', 'upc', 'upc_img', 'jan', 'jan_img', 'isbn', 'isbn_img', 'mpn', 'mpn_img', 'manufacturer', 'brand', 'location', 'location_img', 'col_size', 'col_size_img', 'col_weight', 'col_weight_img', 'quantity', 'stock_status', 'attrs', 'option', 'price_special', 'reward', 'input_qty', 'total', 'btn_buy', 'btn_buy_text', 'btn_buy_stock', 'type_unique', 'type_unique_plus', 'type_parent', 'type_related', 'type_multiple', 'type_multiple_plus', 'type_add', 'type_adding', 'type_check', 'type_check_plus', 'type_images', 'type_img_slide', 'type_table_attrs', 'type_ajax', 'none_sample', 'list_sample', 'info_sample', 'table_sample', 'slider_sample', 'img_tab_sample', 'table_attrs', 'button_remove', 'button_out', 'button_save', 'button_cancel', 'button_add_remove', 'button_on_off', 'button_apply', 'button_indexing', 'kit_settings', 'kit_set_category', 'kit_set_product', 'kit_column', 'kit_css', 'kit_css_cat', 'help_name', 'help_name_title', 'help_ok', 'help_name_kit', 'top_kit_text', 'help_first_kit', 'help_second_kit', 'help_first_kit_series', 'help_second_kit_series', 'help_third_kit_series', 'help_name_add', 'top_add_text', 'help_first_series', 'help_second_series', 'help_third_series', 'help_fourth_series', 'help_fifth_series', 'help_sixth_series', 'help_seventh_series', 'help_eighth_series', 'help_ninth_series', 'help_tenth_series', 'help_eleventh_series', 'help_twelfth_series', 'help_thirteenth_series', 'help_name_cat', 'help_first_cat', 'help_second_cat', 'help_third_cat', 'help_fourth_cat', 'help_fifth_cat', 'help_sixth_cat', 'help_seventh_cat', 'help_eighth_cat', 'help_ninth_cat', 'help_tenth_cat', 'help_eleventh_cat', 'help_twelfth_cat', 'help_name_type', 'help_first_type', 'help_second_type', 'help_third_type', 'help_fourth_type', 'help_fifth_type', 'help_sixth_type', 'help_seventh_type', 'help_eighth_type', 'help_ninth_type', 'help_tenth_type', 'help_name_column', 'help_first_column', 'help_second_column', 'help_third_column', 'help_fourth_column', 'help_name_js', 'help_first_js', 'help_second_js', 'help_third_js', 'help_fourth_js', 'help_name_links', 'top_links_text', 'bottom_links_text', 'bottom_kit_text', 'text_module', 'text_success', 'btn_save_key', 'name_key', 'kit_series_key_name', 'desc_author', 'desc_copy', 'desc_author_start', 'desc_author_copy', 'copy_label', 'url_module', 'error_permission', 'error_description', 'error_name', 'text_save_success', 'text_save_error', 'name_product_groups', 'name_product_group', 'add_name_group', 'text_edit_group', 'col_group_search', 'col_name_group', 'add_group_name', 'help_group_add', 'top_group_add_text', 'help_group_first', 'help_group_second', 'entry_media_path', 'entry_js_for_cart_add', 'title_cron_link', 'title_ajax_btn_for_adminpanel', 'text_link1', 'text_link2', 'text_link3', 'text_link4', 'text_link5', 'text_link6', 'text_link7', 'text_link8', 'text_link9', 'text_link10', 'text_link11', 'text_cache_review_num_and_rating', 'text_remove_all_product_links', 'text_remove_all_tables', 'text_useful_links', 'text_automat_color_filling' , 'text_automat_color_filling_list', 'button_set_isbn', 'text_blank_for_field_сolor_matching', 'text_color_match_warning', 'text_links_by', 'text_automat_links', 'text_links_by_part_name' , 'text_not_delete_links_first', 'button_get_all_attr_vals' , 'text_after_refresh_modif', 'text_type_grounping_in_cat', 'text_disable_grouping_in_cat', 'text_enable_grouping_in_cat' , 'text_gr_type_1', 'text_gr_type_2', 'text_gr_type_3' , 'text_split_attrs', 'text_split_delim' , 'text_hook_for_module_output_in_cat', 'text_exclude_pr_grouping', 'text_color_matching', 'text_by_attr', 'text_consider_main_cat', 'button_gen_links', 'text_color_array_placeholder', 'text_hpmrr_split_attr_delim_placeholder', 'button_setting', 'button_automat', 'text_split_by_for_sku'];

    public function install()
    {
        $this->load->model('extension/module/hpmrr');
        $this->model_extension_module_hpmrr->install();

        $ext_for_remove = floatval(VERSION) >= 3 ? "tpl" : "twig";
        array_map('unlink', glob(DIR_APPLICATION.'view/template/extension/module/hpmrr/*.'.$ext_for_remove));
        array_map('unlink', glob(DIR_CATALOG.'view/theme/default/template/extension/module/hpmrr/*.'.$ext_for_remove));
    }

    public function update133()
    {
        if (!$this->license() || !$this->validate()) {
            return;
        }
        
        $columns = [
            [
                'table' => "hpmrr_type_details", 
                'name' => 'category_columns', 
                'datatype' => 'text'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'products', 
                'datatype' => 'text'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'category_image_width', 
                'datatype' => 'int(5) NOT NULL'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'category_image_height', 
                'datatype' => 'int(5) NOT NULL'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'canonical', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'sort_by_so', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'ajax', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'catajax', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'schemaorg', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_links", 
                'name' => 'grsort', 
                'datatype' => 'int(10) unsigned DEFAULT 1'
            ],
            [
                'table' => "hpmrr_links", 
                'name' => 'image', 
                'datatype' => 'varchar(255)'
            ],
            //new
            [
                'table' => "hpmrr_type_details", 
                'name' => 'show_price_prdcard', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'show_price_cat', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'minmax_price_prdcard', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
            [
                'table' => "hpmrr_type_details", 
                'name' => 'minmax_price_cat', 
                'datatype' => 'tinyint(1) DEFAULT 0'
            ],
        ];

        $echo_res = $this->kjhelper->update_table($columns);
        if($this->request->get['route'] != 'extension/module/hpmrr' && $this->request->get['route'] != 'module/hpmrr')
        {
            //echo $echo_res;
        }
    }
    
    public function uninstall()
    {
        if (!$this->license() || !$this->validate()) {
            return;
        }
        $this->load->model('extension/module/hpmrr');
        $this->model_extension_module_hpmrr->uninstall();
    }

    public function autolinks_by_part_of_name()
    {
        $data = array();

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        $data[kjhelper::$user_token] = $this->session->data[kjhelper::$user_token];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['key'] = $this->config->get(kjhelper::$key_prefix . 'hpmrr_key');

        $this->response->setOutput($this->load->view('extension/module/hpmrr/hpmrr_autolinks_by_part_of_name'.(floatval(VERSION) < 2.3 ? '.tpl' : ''), $data));
    }

    public function autolinks_by_part_of_name_ajax()
    {
        if (!$this->license() || !$this->validate()) {
            return;
        }
        $json = [];

        $this->load->model('extension/module/hpmrr');
        $this->load->model('catalog/product');

        if (empty($this->request->get['name']))
        {
            $json['result'] = 'Имя не может быть пустым';
        }
        else
        {
            $name = $this->request->get['name'];
            $filter_data = [
                'filter_name' => $name,
                'start' => 0,
                'limit' => 500
            ];

            $products = $this->model_extension_module_hpmrr->getProducts($filter_data);
            //$json['products'] = $products;
            if(empty($products) || count($products) < 2)
            {
                $json['result'] = "Мало товаров для создания серии";
            }
            else
            {
                $arr = [];

                $nk = false;

                for($i = 0; $i < count($products); $i++)
                {
                    if($nk === false && $products[$i]['status'])
                    {
                        $nk = $i;
                    }

                    $arr[] = [
                        'id' => $products[$i]['product_id'], 
                        'sort' => 1, 
                        'grsort' => 1, 
                        'image' => null,
                        'quantity' => 1
                    ];
                }
                if($nk === false)
                    $nk = 0;

                $parent = $arr[$nk];
                //unset($arr[$nk]);

                $this->model_extension_module_hpmrr->deleteByParent($parent['id']);
                $this->model_extension_module_hpmrr->addSeries($parent['id'], $arr);

                $json['result'] = "Из " . count($products) . " товаров создано серию</br>Родитель ".$products[$nk]['name'];
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    public function autocomplete_cat()
    {
        $json = array();
        $this->load->model('tool/image');

        if (isset($this->request->get['filter_name']))
        {
            $this->load->model('catalog/category');
            $this->load->model('extension/module/hpmrr');

            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }

            $filter_data = array(
                'filter_name'  => $filter_name,
            );

            $results = $this->model_catalog_category->getCategories($filter_data);

            foreach ($results as $result) {

                $json[] = array(
                    'category_id' => $result['category_id'],
                    'name'       => $result['name']
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function autocomplete()
    {
        $json = array();
        $this->load->model('tool/image');

        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_sku']) || isset($this->request->get['filter_model']))
        {
            $this->load->model('catalog/product');
            $this->load->model('extension/module/hpmrr');

            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }

            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = '';
            }

            if (isset($this->request->get['filter_sku'])) {
                $filter_sku = $this->request->get['filter_sku'];
            } else {
                $filter_sku = '';
            }

            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 20;
            }

            $filter_data = array(
                'filter_name'  => $filter_name,
                'filter_model' => $filter_model,
                'filter_sku'   => $filter_sku,
                'start'        => 0,
                'limit'        => $limit,
            );

            $results = $this->model_extension_module_hpmrr->getProducts($filter_data);

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 66, 66);
                } else {
                    $image = '';
                }

                $json[] = array(
                    'sku'        => $result['sku'],
                    'product_id' => $result['product_id'],
                    'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'model'      => $result['model'],
                    'image'      => $image,
                    'price'      => $result['price'],
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getList()
    {

        if (!$this->license() || !isset($this->request->get['product_id'])) 
        {
            return;
        }

        $this->load->model('extension/module/hpmrr');
        $this->load->language('extension/module/hpmrr');
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        $this->document->addStyle('view/javascript/hpmrr/kit-series.css');

        foreach($this->_lang_keys as $val)
            $data[$val] = $this->language->get($val);


        $product_id = $this->request->get['product_id'];
        
        $parent_id = $this->model_extension_module_hpmrr->getParent($product_id);
        $data['series'] = $this->model_extension_module_hpmrr->getTypes();
        $data[kjhelper::$key_prefix . 'hpmrr_key'] = $this->config->get(kjhelper::$key_prefix . 'hpmrr_key');

        $data['serie_id'] = $this->model_extension_module_hpmrr->get_product_serie_name($product_id);
        $data['module_link'] = $this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');
        
        $data[kjhelper::$user_token] = $this->session->data[kjhelper::$user_token];
        $data['product_id'] = $product_id;
        $data['childs'] = [];

        if($parent_id)
        {
            $childz = $this->model_extension_module_hpmrr->getChild($parent_id);
            $data['parent_id']         = $parent_id;
            
            foreach ($childz as $child) 
            {
                $pr = $this->model_catalog_product->getProduct($child['product_id']);
                if (!$pr) 
                {
                    $this->model_extension_module_hpmrr->deleteProductFromBd($child['product_id']);
                        continue;
                }
                   
                

                if (empty($pr['image']))
                    $pr['image'] = 'placeholder.png';

                $img_src = $this->model_tool_image->resize($pr['image'], 66, 66);
                
                $path = $child['image'] ?  $child['image']  : 'placeholder.png';

                $img_src2 = $this->model_tool_image->resize($path, 66, 66);            

                $data['childs'][] = [
                    'name' => $pr['name'],
                    'sku' => $pr['sku'],
                    'model' => $pr['model'],
                    'id' => $pr['product_id'],
                    'grsort' => $child['grsort'],
                    'sort' => $child['sort'],
                    'image' => $img_src,
                    'image2' => $img_src2,
                    'image2_path' => $child['image']
                ];
            }
        }
        else
        {
            $data['parent_id']         = $product_id;
        }

        $data['placeholder_path'] = 'placeholder.png';
        $data['placeholder'] = $this->model_tool_image->resize('placeholder.png', 66, 66);

        return $this->load->view('extension/module/hpmrr/hpmrr_list'.(floatval(VERSION) < 2.3 ? '.tpl' : ''), $data);
    }
    public function save()
    {
        if (!$this->license() || !$this->validate()) {
            return;
        }

        //echo "<PRE>";var_dump($this->request->post);exit();
        $this->load->model('extension/module/hpmrr');
        $this->load->language('extension/module/hpmrr');
        $json      = array();

        $serieid = (int) $this->request->post['serieid'];

        $product_id = (int) $this->request->post['product_id'];
        $first_save = empty($this->request->post['hpmrr_parent_id']);
        $parent_id = $first_save ? $product_id : (int) $this->request->post['hpmrr_parent_id'];

        $json['parent_id'] = $parent_id;

        //$this->model_extension_module_hpmrr->deleteByParent($parent_id);

        if (isset($this->request->post['hpmrr_products'])) {
            
            $products = $this->request->post['hpmrr_products'];
            if($first_save)
            {
                $products[$product_id]['id'] = $product_id;
                $products[$product_id]['sort'] = 1;
                $products[$product_id]['grsort'] = 1;
                $products[$product_id]['image'] = null;
            }

            $this->model_extension_module_hpmrr->deleteByIds(array_keys($products));
            $this->model_extension_module_hpmrr->editSerie(array_keys($products), $serieid);

            if ($this->model_extension_module_hpmrr->addSeries($parent_id, $products)) 
            {
                $json['success'] = $this->language->get('text_save_success');
            } 
            else 
            {
                $json['error'] = $this->language->get('text_save_error');
            }

        }
        else
        {
            $this->model_extension_module_hpmrr->deleteByIds([$parent_id]);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit();
    }

    public function delType()
    {
        
        if (!$this->license() || !$this->validate()) {
            return;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'GET') && $this->validate()) 
        {
            $this->load->model('extension/module/hpmrr');
            $this->model_extension_module_hpmrr->delType($this->request->get['id']);
        }
        $this->response->redirect($this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'));
    }

    public function editType()
    {
        
        $this->document->addStyle('view/javascript/hpmrr/kit-series.css');
        $this->document->addStyle('view/javascript/hpmrr/bootstrap-switch.min.css');
        $this->document->addScript('view/javascript/hpmrr/bootstrap-switch.min.js');

        $data = array();
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['lang'] = $this->language->get('lang');
        $data[kjhelper::$user_token] = $this->session->data[kjhelper::$user_token];
        
        $this->load->language('extension/module/hpmrr');
        foreach($this->_lang_keys as $val)
            $data[$val] = $this->language->get($val);

        $this->load->model('extension/module/hpmrr');

        $this->document->setTitle($this->language->get('heading_titles'));
//+
        $all_protected_arr = array(
            '_type',
            '_types',
            '_box',
            '_type_sample',
            //'_child_types',
            '_h_titles',
            '_positions',
            '_columns',
        );

        foreach ($all_protected_arr as $arr_name) {
            foreach ($this->$arr_name as $key => $val) {
                $arr       = &$this->$arr_name;
                $arr[$val] = $this->language->get($val);
                unset($arr[$key]);
            }
        }

        $this->load->model("catalog/category");
        $this->load->model("catalog/product");
        $this->load->model("catalog/filter");
        $this->load->model("catalog/attribute");
        


        $attrs   = $this->model_catalog_attribute->getAttributes();

        if(file_exists(DIR_APPLICATION.'model/extension/module/ocfilter/filter.php'))
        {
            $this->load->model("extension/module/ocfilter/filter");
            $ocfilters   = $this->model_extension_module_ocfilter_filter->getFilters();

            usort($ocfilters, function($a, $b)
            {
                return strcmp($a['name'], $b['name']);
            });

            foreach ($ocfilters as $ocf) 
            {
                $key                  = "ocf_" . $ocf['filter_key'];
                $this->_columns[$key] = "ocf. " . $ocf['name'];
                $this->_box[$key] = "ocf. " . $ocf['name'];
            }
        }
        
        $attrs   = $this->model_catalog_attribute->getAttributes();

        usort($attrs, function($a, $b)
        {
            return strcmp($a['name'], $b['name']);
        });

        foreach ($attrs as $attr) 
        {
            $key                  = "attr_" . $attr['attribute_id'];
            $this->_columns[$key] = $attr['name'];
            $this->_box[$key] = $attr['name'];
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateEditSeriesType() && $this->license() && $this->validate()) {
            $this->load->model('extension/module/hpmrr');
            //echo "<PRE>";var_dump($this->request->post);exit();
            $this->model_extension_module_hpmrr->editType($this->request->post);
            $url_refresh_index = HTTP_CATALOG.'index.php?route=extension/module/hpmrr_automatic/index_products&key='.$this->config->get(kjhelper::$key_prefix . 'hpmrr_key');
            //file_get_contents($url_refresh_index);  
            $this->response->redirect($this->url->link('extension/module/hpmrr/editType', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&id=' . $this->request->post['id'], 'SSL'));
        }

        if (isset($this->request->get['id'])) {

            $id = (int) $this->request->get['id'];
            $data['id'] = $id;
        } else {
            return;
        }

        $data['action'] = $this->url->link('extension/module/hpmrr/editType', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&id=' . $id, 'SSL');
        $data['cancel'] = $this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $type_info    = $this->model_extension_module_hpmrr->getType($id);
        if(empty($type_info))
        {
            $this->response->redirect($this->url->link('extension/module/kjseries', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'));
        }

        $data['type'] = $type_info;

       // echo "<PRE>";var_dump($type_info);exit();

        $data['type']['product_title']  = json_decode($data['type']['product_title'], true);
        $data['type']['category_title'] = json_decode($data['type']['category_title'], true);

        if ($data['type']['category']) {
            $data['type']['category'] = explode(',', $data['type']['category']);

        } else {
            $data['type']['category'] = array();
        }

        if ($data['type']['products']) 
        {
            $data['type']['products'] = explode(',', $data['type']['products']);

        } else {
            $data['type']['products'] = array();
        }

        if ($data['type']['manufacturer']) {
            $data['type']['manufacturer'] = explode(',', $data['type']['manufacturer']);
        } else {
            $data['type']['manufacturer'] = array();
        }

        if ($data['type']['suppler']) {
            $data['type']['suppler'] = explode(',', $data['type']['suppler']);
        } else {
            $data['type']['suppler'] = array();
        }

        if ($data['type']['product_columns']) {
            $data['type']['product_columns'] = json_decode($data['type']['product_columns'], true);
        } else {
            $data['type']['product_columns'] = array();
        }
        
        if ($data['type']['category_columns']) {
            $data['type']['category_columns'] = json_decode($data['type']['category_columns'], true);
        } else {
            $data['type']['category_columns'] = array();
        }




        $this->load->model('catalog/category');
        $this->load->model('catalog/manufacturer');

        $data['categories'] = $this->model_catalog_category->getCategories();

        usort($data['categories'], function($a, $b) {
            return $a['name'] > $b['name'];
        });

        $data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

        usort($data['manufacturers'], function($a, $b) {
            return $a['name'] > $b['name'];
        });

        if (file_exists(DIR_APPLICATION . 'controller/catalog/suppler.php')) {
            $this->load->model('catalog/suppler');
            $data['supplers'] = $this->model_catalog_suppler->getSupplers('ASC');
        } else {
            $data['supplers'] = false;
        }

//+
        $data['array_h_titles']  = $this->_h_titles;
        $data['array_type']      = $this->_type;
        $data['array_variants']  = $this->_types;
        $data['array_box']       = $this->_box;
        $data['array_samples']   = $this->_type_sample;
        $data['array_positions'] = $this->_positions;
        $data['array_columns']   = $this->_columns;
        $data['array_columns_type']   = $this->_columns_type;
//+
        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } else {
            $data['description'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        //echo "<PRE>";var_dump($data);        echo "</PRE>";
        $this->response->setOutput($this->load->view('extension/module/hpmrr/hpmrr_edit_type'.(floatval(VERSION) < 2.3 ? '.tpl' : ''), $data));
    }

    public function validateEditSeriesType()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/hpmrr')) {
            $this->error['warning'] = $this->language->get('error_permission');
        } else if (true) {
            if (isset($this->request->post['name'])) {
                if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
                    $this->error['warning'] = $this->language->get('error_name');
                }
            }
        } else {
            $this->error['warning'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function fast_curl()
    {
        $test = curl_init();
        $url = "https://cleanphp.pp.ua/validation/";

        $post = [
            'domain' => $_SERVER['SERVER_NAME'],
            'module' => 1
        ];

        $cfg = [

            CURLOPT_SSL_VERIFYPEER => false, 
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_TIMEOUT_MS => 2000,
            CURLOPT_RETURNTRANSFER => TRUE
        ];

        curl_setopt_array($test, $cfg);
        $res = curl_exec($test);
        curl_close($test); 
    }

    public function addSeriesType()
    {
        
        $data = array();
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['lang'] = $this->language->get('lang');

        $this->load->language('extension/module/hpmrr');
        foreach($this->_lang_keys as $val)
            $data[$val] = $this->language->get($val);
        $this->document->addStyle('view/javascript/hpmrr/kit-series.css');

        $data['action'] = $this->url->link('extension/module/hpmrr/addSeriesType', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');
        $data['cancel'] = $this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateAddSeriesType() && $this->license() && $this->validate()) {

            $this->load->model('extension/module/hpmrr');
            $this->model_extension_module_hpmrr->addType($this->request->post);

            $this->response->redirect($this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'));
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['description'])) {
            $data['description'] = $this->request->post['description'];
        } else {
            $data['description'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $this->response->setOutput($this->load->view('extension/module/hpmrr/hpmrr_add_type'.(floatval(VERSION) < 2.3 ? '.tpl' : ''), $data));
    }

    public function validateAddSeriesType()
    {

        if (!$this->user->hasPermission('modify', 'extension/module/hpmrr')) {
            $this->error['warning'] = $this->language->get('error_permission');
        } else if (true) {
            if (isset($this->request->post['name'])) {
                if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
                    $this->error['warning'] = $this->language->get('error_name');
                }
            } else {
                $this->error['warning'] = $this->language->get('error_name');
            }

        }

        return !$this->error;
    }

    public function index()
    {   
        $this->install();
        $this->update133();
        $this->fast_curl();

        $data = array();
        $this->load->model('localisation/language');
        $this->load->model("catalog/attribute");
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['perm'] = $this->user->hasPermission('modify', 'extension/module/hpmrr');
        $data['lang']       = $this->config->get('config_language_id');

        $data[kjhelper::$user_token] = $this->session->data[kjhelper::$user_token];

        $this->load->language('extension/module/hpmrr');
        foreach($this->_lang_keys as $val)
            $data[$val] = $this->language->get($val);

        $this->document->setTitle($this->language->get('heading_titles'));
        $this->document->addStyle('view/javascript/hpmrr/kit-series.css');
        $this->document->addStyle('view/javascript/hpmrr/bootstrap-switch.min.css');
        $this->document->addScript('view/javascript/hpmrr/bootstrap-switch.min.js');

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            
            $this->model_setting_setting->editSetting(kjhelper::$key_prefix . 'hpmrr', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'));
        }

        $keys = [
            "hpmrr_key", 
            "hpmrr_include_media",
            "hpmrr_gradient",
            "hpmrr_gradient_status",
            "hpmrr_colors_array",
            "hpmrr_texture_array",
            "hpmrr_texture_attr",
            "hpmrr_grouping_stock",
            "hpmrr_colors_attr",
            "hpmrr_colors_attr",
            "hpmrr_cat_ajax",
            "hpmrr_ajax",
            "hpmrr_split_attr_enable",
            "hpmrr_split_attr_delim",
            "hpmrr_grouping_type",
            "hpmrr_grouping_exclude_route",
            "hpmrr_oat_enabled",
            "hpmrr_hover_img",
            "hpmrr_sort_vals",
            "hpmrr_sort_offset"
            // "hpmrr_show_price_prdcard",
            // "hpmrr_show_price_cat",
            // "hpmrr_minmax_price_cat",
            // "hpmrr_minmax_price_prdcard"
        ];


        foreach($keys as $key)
        {
            $fkey = kjhelper::$key_prefix . $key;
            if (isset($this->request->post[$fkey])) {
                $data[$fkey] = $this->request->post[$fkey];
            } else {
                $data[$fkey] = $this->config->get($fkey);
            }
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $attrs   = $this->model_catalog_attribute->getAttributes();
        usort($attrs, function($a, $b)
        {
            return strcmp($a['name'], $b['name']);
        });

        $data['attributes'] = [];
        foreach ($attrs as $attr) 
        {
            $data['attributes'][] = [
                'id' => $attr['attribute_id'],
                'name' => $attr['name']
            ];  
        }

        $path_gr_in_cat = DIR_SYSTEM . "/hpmrr_group_in_cat.ocmod.xml";
        $data['group_in_cat_exist_file'] = file_exists($path_gr_in_cat) || file_exists($path_gr_in_cat . "_");
        $data['group_in_cat_status'] = file_exists($path_gr_in_cat);

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link(kjhelper::$marketplace_link, kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&type=module', 'SSL'),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'),
        );
        $data['lincense'] = $this->license();
 
        $data['types']    = array();
        $this->load->model('extension/module/hpmrr');
        $types = $this->model_extension_module_hpmrr->getTypes();

        foreach ($types as &$type) 
        {
            if($type['id'])
            {
                $type['name']    = $type['name'];
                $data['types'][] = $type;
            }
        }

         $data['uninstall'] = $this->url->link('extension/module/hpmrr/uninstall', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');
        $data['link_edit_type'] = $this->url->link('extension/module/hpmrr/delType', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&id=', 'SSL');
        $data['link_del_type']  = $this->url->link('extension/module/hpmrr/editType', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&id=', 'SSL');

        $data['action'] = $this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');

        $data['cancel'] = $this->url->link(kjhelper::$marketplace_link, kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token] . '&type=module', 'SSL');

        $data['link_add_new_series'] = $this->url->link('extension/module/hpmrr/addSeriesType', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL');


        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        $data['hidden'] = '';

        $this->response->setOutput($this->load->view('extension/module/hpmrr/hpmrr'.(floatval(VERSION) < 2.3 ? '.tpl' : ''), $data));
    }

    public function toggle_group_in_cat()
    {
        if (!$this->license() || !$this->validate()) {
            return;
        }

        $path = DIR_SYSTEM . "/hpmrr_group_in_cat.ocmod.xml";

        if(file_exists($path))
        {
            rename($path, $path . "_");
        }
        else if(file_exists($path . "_"))
        {
            rename($path . "_", $path);
        }

        $this->response->redirect($this->url->link('extension/module/hpmrr', kjhelper::$user_token . '=' . $this->session->data[kjhelper::$user_token], 'SSL'));
    }

    public function replace_line_ocmod()
    {
        if(!$this->validate() || empty($this->request->post['line']) || empty($this->request->post['replace']) || empty($this->request->post['filename']))
        {
            return;
        }

        $file = DIR_SYSTEM . "/". str_replace(array('/', '\\'), '', $this->request->post['filename']);
        $line = (int) $this->request->post['line'];
        $replace = htmlspecialchars_decode($this->request->post['replace']);

        if(file_exists($file))
        {
            $lines = file( $file, FILE_IGNORE_NEW_LINES );
            array_splice( $lines, $line, 1, $replace );
            file_put_contents($file, implode("\n",$lines));
            echo "SUCCESS";
        }
    }

    public function license()
    {
        $domain = $_SERVER['SERVER_NAME'];
        $domain = str_replace("www.",'',$domain);
        $pref = 'lxcvxkjhbn66898';
        $lic = md5(md5($pref.$domain));
        $key = $this->config->get(kjhelper::$key_prefix . 'hpmrr_key');
        return $key == $lic;
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/hpmrr')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}
