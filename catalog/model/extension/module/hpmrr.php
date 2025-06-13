<?php

class ModelExtensionModuleHpmrr extends Model
{
    private $column_key_fixer;

    function __construct($registry) 
    {
        $this->registry = $registry;

        $lang_id = (int) $this->config->get('config_language_id');

        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getGroupId();
        } else {
           $customer_group_id = $this->config->get('config_customer_group_id');
        }   

        $pd_where = "AND pd.language_id = '". $lang_id . "' ";

        $pd_lj = "LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id ";
        $man_lj = "LEFT JOIN " . DB_PREFIX . "manufacturer m ON p.manufacturer_id = m.manufacturer_id ";

        $this->column_key_fixer = [
            'image' => [
                "select"    => "p.image as val"
            ],
            'location' => [
                "select"    => "p.location as val"
            ],
            'sku'  => [
                "select"    => "p.sku as val"
            ],
            'model' => [
                "select"    => "p.model as val "
            ],
            'ean' => [
                "select"    => "p.ean as val "
            ],
            'upc' => [
                "select"    => "p.upc as val " 
            ],
            'jan' => [
                "select"    => "p.jan as val ", 
            ],
            'isbn' => [
                "select"    => "p.isbn as val "
            ],
            'mpn' => [
                "select"    => "p.mpn as val "
            ],
            'quantity' => [
                "select"    => "p.quantity as val"
            ],
            'rew' => [
                "select"    => "pr.points as val", 
                "where"     => "AND pr.customer_group_id = '". (int) $customer_group_id . "' ",
                "left join" => "LEFT JOIN " . DB_PREFIX . "product_reward pr ON pr.product_id = p.product_id "
            ],
            //pd
            'name' => [
                "select"    => "pd.name as val", 
                "left join" => $pd_lj,
                "where"     => $pd_where
                
            ],
            'meta_h1' => [
                "select"    => "pd.meta_h1 as val", 
                "left join" => $pd_lj,
                "where"     => $pd_where
                
            ],
            'meta_title' => [
                "select"    => "pd.meta_title as val", 
                "left join" => $pd_lj,
                "where"     => $pd_where
                
            ],
            'meta_keyword'  => [
                "select"    => "pd.meta_keyword as val", 
                "left join" => $pd_lj,
                "where"     => $pd_where
            ],
            //size weight
            'col_size' => [
                "select"    => "(p.width * p.height * p.length) as val, p.width, p.height, p.length, p.length_class_id"
            ], 
            'col_weight' => [
                "select"    => "p.weight as val, p.weight_class_id", 
            ], 
            //man and custom
            'man' => [
                "select"    => "m.name as val", 
                "left join" => $man_lj
            ],
            "custom1" => [ 
                "select"    => "'test' as val, hl.image as custom_image, p.image, p.isbn"
            ],
            "custom2" => [ 
                "select"    => "'test' as val, hl.image as custom_image, p.image, p.isbn"
            ],
            "custom3" => [
                //"select"    => "IF(hl.image IS NOT NULL AND hl.image <> '', hl.image, p.isbn) as val"
                "select"    => "'test' as val, hl.image as custom_image, p.image, p.isbn"
            ]
        ];
    }

    public function get_filter_name($filter_id, $source)
    {
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "ocfilter_filter_description 
            WHERE language_id = '". (int) $this->config->get('config_language_id') . "'
            AND filter_id = '". (int) $filter_id . "'
            AND source = '". (int) $source . "' ");

        if ($query->num_rows)
        {
            return $query->row['name'];
        }
        else
        {
            return "";
        }
    }
    public function remove_index(array $pids)
    {
        if($pids)
        {
            $implode_rows = implode(",", $pids);
            $sql = "DELETE FROM " . DB_PREFIX . "hpmrr_product_index WHERE product_id IN (".$implode_rows.")";
            $this->db->query($sql);
        }
    }
    public function batch_add_index(array $rows)
    {
        if($rows)
        {
            do
            {
                $slice = array_splice($rows, 0, 100);
                $implode_rows = implode(",", $slice);
                //$implode_rows = implode(",", $rows);
                $sql = "INSERT INTO " . DB_PREFIX . "hpmrr_product_index(product_id, serie_id) VALUES ".$implode_rows;
                $this->db->query($sql);
            }
             while($rows);
        }
    }

    public function parse_key($key)
    {
        if(strripos($key, "attr_") !== false)
            return (int) str_replace("attr_", "", $key);
        else
            return false;
    }

    public function get_buttons($parent_id, $column_key, $sort = false)
    {
        $column_key_4symb = substr($column_key, 0, 4);
            
        if($column_key_4symb == "attr")
        {
            $attr_id = (int) substr($column_key, 5);

            if($this->config->get(kjhelper::$key_prefix . 'hpmrr_oat_enabled'))
            {
                $sql = "SELECT p.product_id, hl.sort, text as val, oat.image as aimage
                FROM " . DB_PREFIX . "hpmrr_links hl 
                LEFT JOIN " . DB_PREFIX . "product p 
                ON hl.product_id = p.product_id 
            
                LEFT JOIN " . DB_PREFIX . "attribute_text_product oatp
                ON p.product_id = oatp.product_id 
                LEFT JOIN " . DB_PREFIX . "attribute_text oat
                ON oat.text_id = oatp.text_id
                LEFT JOIN " . DB_PREFIX . "attribute_text_lang oatl
                ON oatl.text_id = oatp.text_id

                WHERE parent_id = " . (int) $parent_id . "
                AND oatp.attribute_id = '" . (int) $attr_id . "'
                AND language_id = '". (int) $this->config->get('config_language_id') . "'
                AND status = 1";
            }
            else
            {
                $sql = "SELECT pa.*, hl.sort, pa.text as val
                FROM " . DB_PREFIX . "hpmrr_links hl 
                LEFT JOIN " . DB_PREFIX . "product p 
                ON hl.product_id = p.product_id 
                LEFT JOIN " . DB_PREFIX . "product_attribute pa
                ON p.product_id = pa.product_id 
                WHERE parent_id = '" . (int) $parent_id . "'
                AND attribute_id = '" . (int) $attr_id . "'
                AND language_id = '". (int) $this->config->get('config_language_id') . "'
                AND status = 1";
            }
        }
        else if($column_key_4symb == "ocf_")
        {
            $filter_key = substr($column_key, 4);
            $parts = explode(".", $filter_key);
            $filter_id = (int) $parts[0];
            $source = (int) $parts[1];

            $sql = "SELECT p.product_id, hl.sort, name as val, fv.image
            FROM " . DB_PREFIX . "hpmrr_links hl 
            LEFT JOIN " . DB_PREFIX . "product p 
            ON hl.product_id = p.product_id 
            LEFT JOIN " . DB_PREFIX . "ocfilter_filter_value_to_product vtp
            ON p.product_id = vtp.product_id 

            LEFT JOIN " . DB_PREFIX . "ocfilter_filter_value fv
            ON vtp.value_id = fv.value_id 
            
            LEFT JOIN " . DB_PREFIX . "ocfilter_filter_value_description vd
            ON vtp.value_id = vd.value_id 
            
            WHERE parent_id = '" . (int) $parent_id . "'
            AND vtp.filter_id = '". $filter_id . "'
            AND vtp.source = '". $source . "'
            AND language_id = '". (int) $this->config->get('config_language_id') . "'
            AND status = 1";
        }
        else
        {
            $sql = "SELECT p.product_id, hl.sort, " . $this->column_key_fixer[$column_key]['select'] . "
            FROM " . DB_PREFIX . "hpmrr_links hl 
            LEFT JOIN " . DB_PREFIX . "product p 
            ON hl.product_id = p.product_id ";

            if(!empty($this->column_key_fixer[$column_key]['left join']))
            {
                $sql .= $this->column_key_fixer[$column_key]['left join'];
            }

            $sql .= "WHERE parent_id = '" . (int) $parent_id . "'
            AND status = 1 ";

            if(!empty($this->column_key_fixer[$column_key]['where']))
            {
                $sql .= $this->column_key_fixer[$column_key]['where'];
            }
        }

        if($sort !== false)
        {
            $sql .= " AND hl.grsort = '" . (int) $sort . "'";
        }

        $query = $this->db->query($sql);
        //echo "<PRE>";var_dump($query->rows);echo "</pre>";
        return $query->rows;
    }

    public function getAttrNames($attr_ids)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "attribute_description 
        WHERE attribute_id IN (" . implode(',', $attr_ids) . ")
        AND language_id = '" . (int) $this->config->get('config_language_id') . "'";

        $query = $this->db->query($sql);

        $res = [];

        if ($query->num_rows) 
            foreach ($query->rows as $row) 
                $res[$row['attribute_id']] = $row['name'];

        return $res;
    }

    public function getAttrName($attr_id)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "attribute_description 
        WHERE attribute_id = '" . (int) $attr_id . "' 
        AND language_id = '" . (int) $this->config->get('config_language_id') . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows)
        {
            return $query->row['name'];
        }
        else
        {
            return "";
        }
    }

    public function getProductAttributes(array $pids, array $ids = [])
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "product_attribute 
        WHERE product_id IN (" . implode(",", $pids) . ")
        AND language_id = '" . (int) $this->config->get('config_language_id') . "'";

        if(!empty($ids) && is_array($ids))
        {
            $sql .= " AND attribute_id IN (" . implode(",", $ids) . ")";
        }

        $query = $this->db->query($sql);

        $res = [];

        if ($query->num_rows) 
            foreach ($query->rows as $row) 
                $res[$row['product_id']][$row['attribute_id']] = $row['text'];

        return $res;
    }

    public function get_total_products()
    {
        $sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "product";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    public function clear_product_index()
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_product_index WHERE 1");
    }

    public function add_product_index($pid, $typeid)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_product_index 
            WHERE product_id = '" . (int) $pid . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "hpmrr_product_index(product_id, serie_id) VALUES ('" . (int) $pid . "','" . (int) $typeid . "')");
    }

    public function update_parent_attr($uniq_vals, $attr_id, $product_id, $lang_id)
    {
        $sql = "UPDATE " . DB_PREFIX . "product_attribute 
        SET text='" . $this->db->escape($uniq_vals) . "' 
        WHERE attribute_id = '" . (int) $attr_id . "' AND 
        product_id = '" . (int) $product_id . "' AND 
        language_id = '" . (int) $lang_id . "'
        ";

        $res = $this->db->query($sql);
    }
    public function get_products_attrs($ids_str, $attr_id)
    {
        $sql = "SELECT language_id, text
        FROM " . DB_PREFIX . "product_attribute WHERE 
        product_id IN (" . $ids_str . ") AND
        attribute_id = '" . (int) $attr_id . "'";

        $res = $this->db->query($sql);

        return $res->rows;
    }

    public function get_index(array $pids)
    {
        $ids = $this->db->escape(implode(',', $pids));

        // $sql = "SELECT hl.product_id, serie_id 
        // FROM " . DB_PREFIX . "hpmrr_links hl 
        
        // LEFT JOIN " . DB_PREFIX . "hpmrr_product_index hpi 
        // ON hpi.product_id = hl.product_id 

        // WHERE hl.product_id IN (" . $ids . ")
        // AND serie_id IS NOT NULL";

        $sql = "SELECT product_id, serie_id 
        FROM " . DB_PREFIX . "hpmrr_product_index hpi
        LEFT JOIN " . DB_PREFIX . "hpmrr_type ht
        ON hpi.serie_id = ht.id
        WHERE product_id IN (" . $ids . ")
        AND serie_id IS NOT NULL
        AND status = '1'";

        $query = $this->db->query($sql);
         
        $arr = array();
        
        if ($query->num_rows) 
            foreach ($query->rows as $row) 
                $arr[$row['product_id']] = $row['serie_id'];
        
        return $arr;
    }

    public function productHaveOption($product_id)
    {
         $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "' LIMIT 1");

         return 
         $query->num_rows;
    }

    public function getProductIds()
    {
        $sql = "SELECT product_id FROM " . DB_PREFIX . "product 
        WHERE status = '1' 
        AND date_available <= NOW()
        ";

        $query = $this->db->query($sql);

        $results = [];

        if($query->num_rows)
            foreach ($query->rows as $result)
                $results[] = $result['product_id'];
            
         return $results;
    }

    public function getAllProds($select_list, $start = null, $limit = null)
    {
        $sql = "SELECT p.product_id, " . $select_list . "
        FROM " . DB_PREFIX . "product p
        LEFT JOIN " . DB_PREFIX . "product_description pd
        ON pd.product_id = p.product_id
        WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";

        $sql .= " ORDER BY product_id";

        if($start !== null)
        {
            $sql .= " LIMIT ". (int) $start;
            if($limit !== null)
            {
                $sql .= ", " . (int) $limit;
            }
        }

        $query = $this->db->query($sql);

        $results = [];

        if($query->num_rows)
            foreach ($query->rows as $result)
                $results[$result['product_id']] = $result;
            
         return $results;
    }   

    public function get_products_by_ids($ids)
    {
        $results = [];
        if($ids)
        {
            $sql = "SELECT p.product_id, name, quantity
            FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_description pd
            ON pd.product_id = p.product_id
            WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
            AND p.product_id IN (". implode(",", $ids) .")";
           
            $query = $this->db->query($sql);

            if($query->num_rows)
            {
                foreach ($query->rows as $row)
                {
                    $results[$row['product_id']] = [
                        'name' => str_replace(["&quot;", '"', "'"], "", $row['name']),
                        'qty' => $row['quantity'],
                        'product_id' => $row['product_id'],
                        'link' => $this->url->link('product/product&product_id='.$row['product_id'])
                    ];
                }
            }
        }
            
         return $results;
    }

    public function is_autosort($parent_id)
    {

        $sql = "SELECT product_id 
        FROM " . DB_PREFIX . "hpmrr_links hl
        WHERE sort <> '1' 
        AND parent_id = '" . (int) $parent_id . "'";
        $query = $this->db->query($sql);

        return $query->num_rows;
    }

    public function get_products_by_pid2($parent_id)
    {

        $sql = "SELECT product_id 
        FROM " . DB_PREFIX . "hpmrr_links hl
        WHERE parent_id = '" . (int) $parent_id . "'";
        $query = $this->db->query($sql);


        $arr = array();
        foreach ($query->rows as $row) 
            $arr[] = $row['product_id'];
        
        return $arr;

    }

    public function get_products_by_pid($parent_id)
    {
        $results = [];
        $pod_sql = "SELECT product_id 
        FROM " . DB_PREFIX . "hpmrr_links hl
        WHERE parent_id = '" . (int) $parent_id . "'";

        if($parent_id)
        {
            $sql = "SELECT p.product_id, name, quantity
            FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_description pd
            ON pd.product_id = p.product_id
            WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'
            AND p.product_id IN (". $pod_sql .")";
           
            $query = $this->db->query($sql);

            if($query->num_rows)
            {
                foreach ($query->rows as $row)
                {
                    $results[$row['product_id']] = [
                        'name' => str_replace(["&quot;", '"', "'"], "", $row['name']),
                        'qty' => $row['quantity'],
                        'product_id' => $row['product_id'],
                        'link' => $this->url->link('product/product&product_id='.$row['product_id'])
                    ];
                }
            }
        }
            
         return $results;
    }

    public function getProductWithAttribute($attribute_id, $with_cat = false)
    {
        if($with_cat)
        {
            $sql = "SELECT * FROM " . DB_PREFIX . "product_attribute pa
            LEFT JOIN " . DB_PREFIX . "product_to_category ptc
            ON pa.product_id = ptc.product_id
            WHERE pa.language_id = '" . (int) $this->config->get('config_language_id') . "' 
            AND pa.attribute_id = '$attribute_id'
            AND ptc.main_category = '1'";
        }
        else
        {
            $sql = "SELECT * FROM " . DB_PREFIX . "product_attribute pa
            WHERE pa.language_id = '" . (int) $this->config->get('config_language_id') . "' 
            AND pa.attribute_id = '$attribute_id'";
        }
        $query = $this->db->query($sql);

        return $query->rows;
    }
    public function removeLinks()
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links");
    }
    public function deleteProductFromBd($id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links 
            WHERE product_id = '" . (int) $id . "' 
            OR parent_id = '" . (int) $id . "'");
    }
    
    public function addSeries($parent_id, $products)
    {
        $result    = true;
  
        foreach ($products as $product) 
        {
            $check = $this->db->query("SELECT COUNT(*) as total 
                FROM " . DB_PREFIX . "hpmrr_links 
                WHERE (product_id IN (". (int) $product['id'] . ", ". (int) $parent_id . ") AND product_id != parent_id)
                OR (parent_id = ".(int) $product['id']." AND product_id = parent_id)
            ");

            if($check->row['total'] == 0)
            {
                $this->db->query("INSERT INTO " . DB_PREFIX . "hpmrr_links 
                    (parent_id, product_id, sort, grsort) 
                    VALUES ('". (int) $parent_id . "','" . (int) $product['id'] . "','" . (int) $product['sort'] . "', '1');");
            }
        }

        return $result;
    }

    public function changeAdminProduct($id, $val, $field)
    {
        $sql = "UPDATE " . DB_PREFIX . "product SET $field = '" . $this->db->escape($val) . "' 
        WHERE product_id= '" . (int) $id . "'";

        $this->db->query($sql);
    }

    public function getTypes(array $ids = [])
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "hpmrr_type kt 
        LEFT JOIN " . DB_PREFIX . "hpmrr_type_details ktd 
        ON kt.id = ktd.id";

        $ids = array_filter($ids, 'is_int');
        $sql .= " WHERE kt.status = '1' ";
        
        if(!empty($ids))
        {
            $sql .= " AND kt.id IN (". implode(",", $ids) .")";
        }

        $query = $this->db->query($sql);

        $arr = array();
        foreach ($query->rows as $row) 
            $arr[$row['id']] = $row;
        
        return $arr;
    }

    public function getChild($parent_id)
    {
        $query = $this->db->query("
            SELECT product_id as id, sort, image
            FROM " . DB_PREFIX . "hpmrr_links 
            WHERE parent_id = '" . (int) $parent_id . "' 
            ORDER BY sort;");
        return $query->rows;
    }

    public function get_sort($id)
    {
        $query = $this->db->query("SELECT grsort 
            FROM " . DB_PREFIX . "hpmrr_links 
            WHERE product_id = '" . (int) $id . "'");

        if($query->num_rows)
        {
            return $query->row['grsort'];
        }
        else
        {
            return false;
        }
    }

    public function getParent($child_id)
    {
        $query = $this->db->query("SELECT parent_id 
            FROM " . DB_PREFIX . "hpmrr_links 
            WHERE product_id = '" . (int) $child_id . "'
            OR parent_id = '" . (int) $child_id . "';");

        if($query->num_rows)
        {
            return $query->row['parent_id'];
        }
        else
        {
            return false;
        }
    }

    public function getDiscountPrice($id, $qty)
    {
        
        $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $id . "' AND customer_group_id = '" . (int) $this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int) $qty . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

        if ($product_discount_query->num_rows) {
            return $product_discount_query->row['price'];
        } else {
            return false;
        }

    }

    public function review_by_parent($pid)
    {
        $sql = "SELECT COUNT(*) as total, AVG(rating) as rating FROM 
            (SELECT rating FROM " . DB_PREFIX . "review r1 
            LEFT JOIN " . DB_PREFIX . "hpmrr_links hl 
            ON (r1.product_id = hl.parent_id OR r1.product_id = hl.product_id)
            WHERE hl.parent_id = '" . (int) $pid . "' AND
            r1.status = '1'
            GROUP by review_id) as subq;";

        $res = $this->db->query($sql);

        return $res->row;
    }

    public function clear_cache_reviews()
    {
        $sql = "DELETE FROM " . DB_PREFIX . "hpmrr_reviews_cache";
        $this->db->query($sql);
    }

    public function set_cache_reviews(array $rows)
    {
        if($rows)
        {
            do
            {
               
                $slice = array_splice($rows, 0, 100);
                $implode_rows = implode(",", $slice);
            
                $sql = "INSERT INTO " . DB_PREFIX . "hpmrr_reviews_cache (product_id, total, avg) VALUES ". $implode_rows;
       
                $this->db->query($sql);
            }
            while($rows);
        }
        
    }
    public function get_review_avg_ttl_single_products()
    {
        $sql = "SELECT p.product_id ,
            (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, 
            (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews 
            FROM " . DB_PREFIX . "product p 
            WHERE p.product_id NOT IN (SELECT DISTINCT product_id FROM " . DB_PREFIX . "hpmrr_links)
            AND p.product_id NOT IN (SELECT DISTINCT parent_id FROM " . DB_PREFIX . "hpmrr_links);";


        $res = $this->db->query($sql);

        return $res->rows;
    }

    public function getAllParents()
    {
        $query = $this->db->query("SELECT DISTINCT(parent_id) 
            FROM " . DB_PREFIX . "hpmrr_links;");

        return $query->rows;
    }

    public function get_serie_ids($product_id)
    {
        $series_ids = [];
        $series_ids[] = $product_id;

        $parent_id = $this->getParent($product_id);

        if($parent_id)
        {
            $series_ids[] = (int) $parent_id;
            foreach($this->getChild($parent_id) as $row)
            {
                $series_ids[] = (int) $row['id'];
            }
            $series_ids = array_unique($series_ids);
        }
        return $series_ids;
    }

}
