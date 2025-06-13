<?php

class ControllerExtensionModuleHpmrrAutomatic extends Controller
{
    private $ptm = "extension/module/hpmrr";
    private $products;
    private $types;
    private $index_portion = 50000;


    public function updater()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
            exit("ERROR KEY");
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hpmrr_type_details");
        
        foreach($query->rows as $type)
        {
            $product_columns = json_decode($type['product_columns']);
            $product_columns_type = json_decode($type['product_columns_type']);
            $res = [];

            for($i = 0; $i < count($product_columns); $i++)
            {
                $res[] = [
                    "key" => $product_columns[$i],
                    "type" => $product_columns_type[$i]
                ];
            }

            $sql = "UPDATE " . DB_PREFIX . "hpmrr_type_details
                SET product_columns = '".$this->db->escape(json_encode($res))."', 
                category_columns = '".$this->db->escape(json_encode($res))."'
                WHERE id = '".$type['id']."'";

            
            $this->db->query($sql);
            
        }
    }
    
    public function print_foo($arr)
    {
        foreach($arr as $key => $products)
        {
            echo "---------------------------------<br/>";
            foreach($products as $product)
            {
                echo $product." / " . $key . "<br/>";
            }
           
        }
    }

    public function reviews_cache()
    {   
        $this->load->model($this->ptm);  
        $parents = $this->model_extension_module_hpmrr->getAllParents();
        
        $rows = [];
        $pattern = "('%d','%d','%0.2f')";

        foreach($parents as $parent)
        {
            $childs = $this->model_extension_module_hpmrr->getChild($parent['parent_id']);
               
            if($childs)
            {
                $reviews_res = $this->model_extension_module_hpmrr->review_by_parent($parent['parent_id']);

                $rows[$parent['parent_id']] = sprintf($pattern, $parent['parent_id'], $reviews_res["total"], $reviews_res["rating"]);

                foreach($childs as $child)
                {
                    $rows[$child['id']] = sprintf($pattern, $child['id'], $reviews_res["total"], $reviews_res["rating"]);
                   
                }
            }
        }

        $review_avg_ttl_single_products = $this->model_extension_module_hpmrr->get_review_avg_ttl_single_products();
        
        if($review_avg_ttl_single_products)
        {
            foreach($review_avg_ttl_single_products as $row)
            {
                $rows[$row['product_id']] = sprintf($pattern, $row['product_id'], $row['reviews'], $row['rating']);
            }
        }

        echo "<PRE>";var_dump($rows);echo "</PRE>";
        $this->model_extension_module_hpmrr->clear_cache_reviews();
        $this->model_extension_module_hpmrr->set_cache_reviews($rows);
    }

    public function recount_parent_price()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        $this->load->model($this->ptm);  
        $this->load->model('catalog/product');
        $all_links = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hpmrr_links`");
        $types = [];

        foreach($all_links->rows as $link)
        {
            $pinfo = $this->model_catalog_product->getProduct($link['product_id']);
            if(empty($pinfo))
                continue;
            $price = (float) ($pinfo['special'] ? $pinfo['special'] : $pinfo['price']);
            if(!isset($types[$link['parent_id']]))
                $types[$link['parent_id']] = [];

            $types[$link['parent_id']][] = $price * 1;//(int) $link['quantity'];
        }

        if ($this->get_is('include_parent', 'yes'))
        {
            foreach($types as $pid => $arr)
            {
                $pinfo = $this->model_catalog_product->getProduct($pid);
                if(empty($pinfo))
                    continue;
                $price = (float) ($pinfo['special'] ? $pinfo['special'] : $pinfo['price']);
                $types[$pid][] = $price;
            }
        }

        if ($this->get_is('type', 'sum'))
        {
            foreach($types as $pid => $arr)
                $types[$pid] = array_sum($arr);
        }
        else if ($this->get_is('type', 'min'))
        {
            foreach($types as $pid => $arr)
                $types[$pid] = min($arr);   
        }
        else
        {
            foreach($types as $pid => $arr)
                $types[$pid] = max($arr);
        }

        echo "<PRE>";var_dump($types);echo "</PRE>";
        
        foreach ($types as $pid => $val)
        {
            $this->model_extension_module_hpmrr->changeAdminProduct($pid, $val, 'price');
        }

    }   
    public function recount_parent_quantity2()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        if(!isset($this->request->get['qty']))
        {
            exit("GET QTY REQUIRED");
        }

        $this->load->model($this->ptm);  
        $this->load->model('catalog/product');
        $all_links = $this->db->query("SELECT DISTINCT parent_id FROM `" . DB_PREFIX . "hpmrr_links`");
        $types = [];
        $qty = (int) $this->request->get['qty'];

         foreach($all_links->rows as $link)
        {
            $pinfo = $this->model_catalog_product->getProduct($link['parent_id']);
            if(empty($pinfo))
                continue;

            if($pinfo['quantity'] == 0)
            {
                $types[$link['parent_id']] = $qty;
            }

        }

        echo "<PRE>";var_dump($types);echo "</PRE>";
        
        foreach ($types as $pid => $val)
        {
            $this->model_extension_module_hpmrr->changeAdminProduct($pid, $val, 'quantity');
        }
    }
    public function recount_parent_quantity()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        $this->load->model($this->ptm);  
        $this->load->model('catalog/product');
        $all_links = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hpmrr_links`");
        $types = [];

        foreach($all_links->rows as $link)
        {
            $pinfo = $this->model_catalog_product->getProduct($link['product_id']);
            if(empty($pinfo))
                continue;

            if(!isset($types[$link['parent_id']]))
                $types[$link['parent_id']] = [];

            $types[$link['parent_id']][] = 1;//(int) $link['quantity'];
        }

        if ($this->get_is('include_parent', 'yes'))
        {
            foreach($types as $pid => $arr)
            {
                $pinfo = $this->model_catalog_product->getProduct($pid);
                if(empty($pinfo))
                    continue;

                $types[$pid][] = (int) $pinfo['quantity'];
            }
        }

        if ($this->get_is('type', 'sum'))
        {
            foreach($types as $pid => $arr)
                $types[$pid] = array_sum($arr);
        }
        else if ($this->get_is('type', 'min'))
        {
            foreach($types as $pid => $arr)
                $types[$pid] = min($arr);   
        }
        else
        {
            foreach($types as $pid => $arr)
                $types[$pid] = max($arr);
        }

        echo "<PRE>";var_dump($types);echo "</PRE>";
        
        foreach ($types as $pid => $val)
        {
            $this->model_extension_module_hpmrr->changeAdminProduct($pid, $val, 'quantity');
        }

    }

    public function get_is($pn, $pv)
    {
        return (!empty($this->request->get[$pn]) && $this->request->get[$pn] == $pv);
    }

    public function clear_links()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        $this->load->model($this->ptm);

        $this->model_extension_module_hpmrr->removeLinks();
    }

    public function links_by_attr()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        if (empty($this->request->get['attribute_id'])) 
            return;

        $this->load->model($this->ptm);
        if (!$this->get_is('remove', 'stop'))
        {
            $this->model_extension_module_hpmrr->removeLinks();
        }

        $attribute_id = (int) $this->request->get['attribute_id'];
        $print_arr = [];
        $products_with_attr = $this->model_extension_module_hpmrr->getProductWithAttribute($attribute_id, $this->get_is('cat', 'true'));

        $ps = $this->model_extension_module_hpmrr->getAllProds("name, price, status");
        foreach ($products_with_attr as $row)
        {
            if (empty($row['text']))
                continue;

            if ($this->get_is('cat', 'true'))
                $key = $row['text'] . $row['category_id'];
            else
                $key = $row['text'];

            $arr[$key][] = ['id' => $row['product_id'], 'sort' => 1, 'quantity' => 1];
        }

        if (empty($arr))
            return;

        foreach ($arr as $attr_text => $products)
        {
            if (count($products) <= 1)
            {
                continue;
            }

                        //find parent start with min price
            $nk = -1;
            $min = PHP_INT_MAX;
            foreach ($products as $key2 => $prod)
            {
                $pinfo = $ps[$prod['id']];
                $print_arr[$key][] = "#" . $prod['id'] .": ". $pinfo['name'];

                if($nk == -1)
                {
                    if($pinfo['status'])
                    {
                        $nk = $key2;
                        $min = $pinfo['price'];
                    }
                }
                elseif ($min > $pinfo['price'] && $pinfo['status'])
                {
                    $nk = $key2;
                    $min = $pinfo['price'];
                }
            }
            //find parent end
            if($nk == -1)
            {
                $nk = 0;
            }

            $parent_id = $products[$nk]['id'];
            //unset($products[$nk]);
            $this->model_extension_module_hpmrr->addSeries($parent_id, $products);
            
        }

        $this->print_foo($print_arr);
    }

    public function links_by_model()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        $this->load->model($this->ptm);
        if (!$this->get_is('remove', 'stop'))
        {
            $this->model_extension_module_hpmrr->removeLinks();
        }

        $sepor = "-";
        $by = 'model';
        $arr = [];
        $print_arr = [];

        if (!empty($this->request->get['sepor'])) 
            $sepor = $this->request->get['sepor'];

        if (!empty($this->request->get['by'])) 
            $by = $this->request->get['by'];

        $ps = $this->model_extension_module_hpmrr->getAllProds($by . ", name, price, status");

        if (empty($ps))
            return;

        foreach ($ps as $p)
        {

            if(!empty($p[$by]))
            {
                if ($this->get_is('explode', 'true'))
                {
                    $parts = explode($sepor, $p[$by]);
                    if(count($parts) > 1)
                    {
                        array_pop($parts);
                        $key = implode($sepor, $parts);
                    }
                    else
                    {
                        $key = $parts[0];
                    }
                }
                else
                {
                    $key = $p[$by];
                }
            }
            else
                continue;

            $arr[$key][] = ['id' => $p['product_id'], 'sort' => 1, 'quantity' => 1];
        }

        if (empty($arr))
            return;

        foreach ($arr as $key => $products)
        {
            if (count($products) <= 1)
            {
                continue;
            }

            //find parent start with min price
            $nk = -1;
            $min = PHP_INT_MAX;
            foreach ($products as $key2 => $prod)
            {
                $pinfo = $ps[$prod['id']];
                $print_arr[$key][] = "#" . $prod['id'] .": ". $pinfo['name'];

                if($nk == -1)
                {
                    if($pinfo['status'])
                    {
                        $nk = $key2;
                        $min = $pinfo['price'];
                    }
                }
                elseif ($min > $pinfo['price'] && $pinfo['status'])
                {
                    $nk = $key2;
                    $min = $pinfo['price'];
                }
            }
            //find parent end
            if($nk == -1)
            {
                $nk = 0;
            }

            $parent_id = $products[$nk]['id'];
            //unset($products[$nk]);
            $this->model_extension_module_hpmrr->addSeries($parent_id, $products);
            
        }

        $this->print_foo($print_arr);
    }

    public function removeLinks()
    {
         $this->model_extension_module_hpmrr->removeLinks();
    }

    // isbn colors functions
    public function set_texture()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        if (empty($this->request->get['attribute_id'])) 
            return;

        $colors = [];
        $sepor = " : ";
        $colors_text = $this->config->get(kjhelper::$key_prefix . 'hpmrr_texture_array');
        $lines = explode("\n", $colors_text);
        $attribute_id = (int) $this->request->get['attribute_id'];
        $lang_id = (int) $this->config->get('config_language_id');
        $sql_select_attrs = "SELECT text, product_id 
            FROM " . DB_PREFIX . "product_attribute
            WHERE attribute_id = '" . (int) $attribute_id . "'
            AND language_id = '" . (int) $lang_id . "'";

        $res = $this->db->query($sql_select_attrs);

        foreach($lines as $line)
        {
            $line_parts = explode($sepor, $line);
            if(count($line_parts) == 2)
            {
                $texture = trim($line_parts[1]);
                $key = trim($line_parts[0]);
                if($texture != "path_to_image")
                {
                    $colors[$key] = $texture;
                }
            }
        }

        foreach($res->rows as $row)
        {
            $text = str_replace(array('\'', '"'), '', $row['text']); 
  
            if(empty($colors[$text]))
            {
                echo "NOT FIND " . $text . "<br/>";
            }
            else
            {
                echo "PRODUCT " . (int) $row['product_id'] . " SET TEXTURE " . $colors[$text] . "<br/>";
                $this->db->query("UPDATE " . DB_PREFIX . "hpmrr_links 
                    SET image = '" . $colors[$text] . "'
                    WHERE product_id = '" . (int) $row['product_id'] . "'");
            }
        }
    }

    public function set_isbn()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        if (empty($this->request->get['attribute_id'])) 
            return;

        $colors = [];
        $sepor = " : ";
        $colors_text = $this->config->get(kjhelper::$key_prefix . 'hpmrr_colors_array');
        $lines = explode("\n", $colors_text);
        $attribute_id = (int) $this->request->get['attribute_id'];
        $lang_id = (int) $this->config->get('config_language_id');
        $sql_select_attrs = "SELECT text, product_id 
            FROM " . DB_PREFIX . "product_attribute
            WHERE attribute_id = '" . (int) $attribute_id . "'
            AND language_id = '" . (int) $lang_id . "'";

        $res = $this->db->query($sql_select_attrs);

        foreach($lines as $line)
        {
            $line_parts = explode($sepor, $line);
            if(count($line_parts) == 2)
            {
                $colors[trim($line_parts[0])] = trim($line_parts[1]);
            }
        }

        foreach($res->rows as $row)
        {
            $text = str_replace(array('\'', '"'), '', $row['text']); 
  
            if(empty($colors[$text]))
            {
                echo "NOT FIND " . $text . "<br/>";
            }
            else
            {
                echo "PRODUCT " . (int) $row['product_id'] . " SET COLOR " . $colors[$text] . "<br/>";
                $this->db->query("UPDATE " . DB_PREFIX . "product 
                    SET isbn = '" . $colors[$text] . "'
                    WHERE product_id = '" . (int) $row['product_id'] . "'");
            }
        }
    }
    private function get_angl_color($color_name)
    {
        $url = 'https://www.color-name.com/search/'.str_replace(' ', '+', $color_name);;
        $content = file_get_contents($url);
        $pattrent = '<div\s+class="box" style="background-color: (.*);">';
 
        preg_match_all($pattrent, $content, $res); 

        if(!empty($res[1][0]))
        {
            return $res[1][0];
        }
        else
        {
            return false;
        }
    }


    public function get_texture()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        if (empty($this->request->get['attribute_id'])) 
            return;

        $attribute_id = (int) $this->request->get['attribute_id'];
        $lang_id = (int) $this->config->get('config_language_id');
        $sepor = " : ";
        $sql = "SELECT DISTINCT(text) 
            FROM " . DB_PREFIX . "product_attribute
            WHERE attribute_id = '" . (int) $attribute_id . "'
            AND language_id = '" . (int) $lang_id . "'
        ";

        $res = $this->db->query($sql);
        $hex = "path_to_image";
        foreach($res->rows as $row)
        {
            
            //$hex = $this->get_angl_color($row['text']);

            echo $row['text'] . $sepor . $hex . "\n";
        }
    }

    public function get_color()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }

        if (empty($this->request->get['attribute_id'])) 
            return;

        $attribute_id = (int) $this->request->get['attribute_id'];
        $lang_id = (int) $this->config->get('config_language_id');
        $sepor = " : ";
        $sql = "SELECT DISTINCT(text) 
            FROM " . DB_PREFIX . "product_attribute
            WHERE attribute_id = '" . (int) $attribute_id . "'
            AND language_id = '" . (int) $lang_id . "'
        ";

        $res = $this->db->query($sql);
        $hex = "#000000";
        foreach($res->rows as $row)
        {
            
            //$hex = $this->get_angl_color($row['text']);

            echo $row['text'] . $sepor . $hex . "\n";
        }
    }

    public function links_hpmodel()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }
        //atrs
        $color_attr_id = 16;
        $size_attr_id = 20;
        $type_id = 3;
        $attribute_ids = "('".$color_attr_id."','".$size_attr_id."')";
        $by = 'model';
        $products = [];
        $attrs = [];
        $groups = [];
        $pattern = "('%d','%d','%d','%s', '" . $type_id . "')";
        $insert_vals = [];
        $start_insert = "INSERT INTO `" . DB_PREFIX . "hpmodel_links` (`parent_id`, `product_id`, `sort`, `image`, `type_id`) VALUES ";
        $lang_id = (int) $this->config->get('config_language_id');
        $color_by_def = "#000000";
        $sort_by_def = 1;
        $sql_attr = "SELECT product_id, attribute_id, text
            FROM " . DB_PREFIX . "product_attribute
            WHERE attribute_id IN " . $attribute_ids . "
            AND language_id = '" . (int) $lang_id . "'
        ";
        $sql_prd = "SELECT * FROM " . DB_PREFIX . "product WHERE status = '1'";

        //

        $query_attr = $this->db->query($sql_attr);

        foreach($query_attr->rows as $row)
        {
            $attrs[$row['product_id']][$row['attribute_id']] = $row['text'];
        }

        //get products

        $query_prds = $this->db->query($sql_prd);
        
        foreach($query_prds->rows as $row)
        {
            $products[$row['product_id']] = $row;
        }

        //

        foreach($products as $product)
        {
           if(!empty($product[$by]))
           {
            $groups[$product[$by]][] = $product['product_id'];
           }
        }

        //
    
        foreach($groups as $key => $arr)
        {
            if(count($arr) > 1)
            {
                foreach($arr as $pid)
                {
                    $color = $color_by_def;
                    $sort = $sort_by_def;

                    if(!empty($attrs[$pid][$color_attr_id]))
                    {
                        $color_name = $attrs[$pid][$color_attr_id];
                        if(!empty($this->colors[$color_name]))
                            $color = $this->colors[$color_name];

                    }

                    if(!empty($attrs[$pid][$size_attr_id]))
                        $sort = (int) $attrs[$pid][$size_attr_id];
                
                    //var_dump($color);
                    $insert_vals[] = sprintf($pattern, $arr[0], $pid, $sort, $color);
                }
            }
        }

        //
        echo "<PRE>";
        var_dump($insert_vals);

        do
        {
            $slice = array_splice($insert_vals, 0, 100);
            $implode_rows = implode(",", $slice);
            
            $sql = $start_insert . $implode_rows;
            
            //var_dump($sql);
            //$this->db->query($sql);
        }
        while($insert_vals);
    }

    public function remove_death_links()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }
        
        $res = $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links 
            WHERE CONCAT(product_id, '-', parent_id) IN (
                SELECT id FROM (
                    SELECT CONCAT(hl.product_id, '-', hl.parent_id) as id
                    FROM " . DB_PREFIX . "hpmrr_links hl
                    LEFT JOIN " . DB_PREFIX . "product p 
                    ON (hl.product_id = p.product_id OR hl.parent_id = p.product_id)
                    WHERE p.product_id is null
                ) as hl
            )
        ");

        echo "DELETED ".$this->db->countAffected();
    }

    public function add_parents()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }
        
        $i = 0;
        $res = $this->db->query("SELECT DISTINCT parent_id FROM " . DB_PREFIX . "hpmrr_links");
        foreach($res->rows as $row)
        {
            $res = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "hpmrr_links
                WHERE parent_id = '".(int) $row['parent_id']."' 
                AND product_id = '".(int) $row['parent_id']."'");
            
            if($res->row['total'] == 0)
            {
                $this->db->query("INSERT INTO `" . DB_PREFIX . "hpmrr_links`(`parent_id`, `product_id`, `sort`, `grsort`, `image`) VALUES ('".(int) $row['parent_id']."','".(int) $row['parent_id']."','1','1','')");
                $i++;
            }
            
        }
        
        echo "ADDED ".$i;
    }

    public function auto_grsort()
    {
        if (!$this->get_is('key', $this->config->get(kjhelper::$key_prefix . 'hpmrr_key')))
        {
            exit("ERROR KEY");
        }
        
        if(!empty($this->request->get['attribute_id']))
        {
            $attr_id = $this->request->get['attribute_id'];

            $res = $this->db->query("UPDATE  " . DB_PREFIX . "hpmrr_links hl
            LEFT JOIN " . DB_PREFIX . "product_attribute pa
            ON hl.product_id = pa.product_id
            SET hl.grsort = CRC32(text) % 10000
            WHERE attribute_id = '".(int) $attr_id ."' 
            AND language_id = '1'
            AND text IS NOT NULL
            ");


            echo "UPDATED ".$this->db->countAffected();
        }
    }
}