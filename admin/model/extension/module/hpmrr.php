<?php

class ModelExtensionModuleHpmrr extends Model
{

        public function install()
    {

        $sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "hpmrr_reviews_cache
        (
            product_id int(10) unsigned NOT NULL,
            total int(10) unsigned DEFAULT NULL,
            avg float(5,2) unsigned DEFAULT NULL,
            PRIMARY KEY (product_id)
        ) CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;";
        $this->db->query($sql);


        $sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "hpmrr_links
        (
            id int(11) NOT NULL AUTO_INCREMENT,
            parent_id int(10) unsigned NOT NULL,
            product_id int(10) unsigned NOT NULL,
            sort int(10) unsigned DEFAULT 1,
            grsort int(10) unsigned DEFAULT 1,
            image varchar(255) DEFAULT NULL,
            PRIMARY KEY (id),
            UNIQUE (product_id,parent_id)
        ) CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;";
        $this->db->query($sql);

         $sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "hpmrr_product_index
        (
            product_id int(10) unsigned NOT NULL,
            serie_id int(10) unsigned NOT NULL,
            PRIMARY KEY ( product_id)
        ) CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "hpmrr_type (
  id int(11) NOT NULL AUTO_INCREMENT,
  name text,
  description text,
  status tinyint(1) DEFAULT NULL,
  PRIMARY KEY (id)) CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS  " . DB_PREFIX . "hpmrr_type_details (
          id int(11) NOT NULL,
          products text NOT NULL,
          category text NOT NULL,
          suppler text NOT NULL,
          manufacturer text NOT NULL,
          product_position text NOT NULL,
          product_selector text NOT NULL,
          product_columns text NOT NULL,
          category_columns text NOT NULL,
          custom_css text NOT NULL,
          links tinyint(1) NOT NULL,
          hidden_if_null tinyint(1) NOT NULL,
          custom_js text NOT NULL,
          product_name_as_title tinyint(1) NOT NULL,
          category_name_as_title tinyint(1) NOT NULL,
          category_title text NOT NULL,
          product_title text NOT NULL,

          category_image_width int(5) NOT NULL,
          category_image_height int(5) NOT NULL,

          product_image_width int(5) NOT NULL,
          product_image_height int(5) NOT NULL,
          category_variant varchar(100) NOT NULL,

          canonical tinyint(1) NOT NULL,
          sort_by_so tinyint(1) NOT NULL,
          ajax tinyint(1) DEFAULT 0,
          catajax tinyint(1) DEFAULT 0,
          schemaorg tinyint(1) DEFAULT 0,

          show_price_prdcard tinyint(1) DEFAULT 0,
          show_price_cat tinyint(1) DEFAULT 0,
          minmax_price_prdcard tinyint(1) DEFAULT 0,
          minmax_price_cat tinyint(1) DEFAULT 0,

          PRIMARY KEY (id)
      ) CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;";

        try {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "hpmrr_links ADD INDEX `idx_parent_id` (`parent_id`);");
        } catch (Exception $e) {  }

        try {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "hpmrr_links ADD INDEX `idx_product_id` (`product_id`);");
        } catch (Exception $e) {  }

        try {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "hpmrr_links ADD INDEX `idx_sort` (`sort`);");
        } catch (Exception $e) {  }

         try {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "hpmrr_links ADD INDEX `idx_grsort` (`grsort`)");
        } catch (Exception $e) {  }

         try {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "hpmrr_product_index ADD INDEX `idx_serie_id` (`serie_id`)");
        } catch (Exception $e) {  }

         try {
            $this->db->query("ALTER TABLE " . DB_PREFIX . "hpmrr_type ADD INDEX `idx_status` (`status`);");
        } catch (Exception $e) {  }

        $this->db->query($sql);
    }

    public function uninstall()
    {
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "hpmrr_reviews_cache;";
        $this->db->query($sql);
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "hpmrr_links;";
        $this->db->query($sql);
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "hpmrr_type;";
        $this->db->query($sql);
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "hpmrr_type_details;";
        $this->db->query($sql);
        $sql = "DROP TABLE IF EXISTS " . DB_PREFIX . "hpmrr_product_index;";
        $this->db->query($sql);
    }

    public function deleteProductFromBd($product_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_reviews_cache 
            WHERE product_id = '" . (int) $product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links 
            WHERE product_id = '" . (int) $product_id . "' 
            OR parent_id = '" . (int) $product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_product_index 
            WHERE product_id = '" . (int) $product_id . "'");
    }
    
    public function clearModuleTable()
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_type");
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_type_details");
    }

    public function get_product_serie_name($product_id)
    {
        $query = $this->db->query("SELECT serie_id FROM " . DB_PREFIX . "hpmrr_product_index
                WHERE product_id = '" . $product_id . "'");

        if($query->num_rows)
        {
            return $query->row['serie_id'];
        }
        else
        {
            return false;
        }
    
    }

    public function getProducts($data = array())
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "product p 
        LEFT JOIN " . DB_PREFIX . "product_description pd 
        ON p.product_id = pd.product_id
        WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_model'])) {
            $sql .= " AND p.model LIKE '%" . $this->db->escape($data['filter_model']) . "%'";
        }

        if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
            $sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
        }

        if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
            $sql .= " AND p.quantity = '" . (int) $data['filter_quantity'] . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $sql .= " AND p.status = '" . (int) $data['filter_status'] . "'";
        }

        if (!empty($data['filter_sku'])) {
            $sql .= " AND p.sku LIKE '%" . $this->db->escape($data['filter_sku']) . "%'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.price',
            'p.quantity',
            'p.status',
            'p.sort_order',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY pd.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function addType($data)
    {
        $names = $this->db->escape($data['name']);
        $descr = $this->db->escape($data['description']);
        
        $sql = "INSERT INTO " . DB_PREFIX . "hpmrr_type(name, description, status) VALUES ";
        $sql .= "('$names', '$descr', '1')";

        $this->db->query($sql);

        $id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "hpmrr_type_details(id, links, category, suppler, manufacturer, product_position, product_selector, product_columns, category_columns, custom_css,  hidden_if_null, custom_js, product_name_as_title, category_title, product_title, product_image_width, product_image_height, category_image_width, category_image_height, category_variant, canonical, sort_by_so, ajax, catajax, schemaorg, show_price_prdcard, show_price_cat, minmax_price_prdcard, minmax_price_cat) "
            . "    VALUES ('$id','1','','','','insertBefore','#product','','','','','','','','','30','30','30','30','','','','0','0','0','0','0','0','0')");
    }
    public function getParents()
    {
        $query = $this->db->query("SELECT parent_id as id 
            FROM " . DB_PREFIX . "hpmrr_links");
        return $query->rows;
    }

    public function getParent($id)
    {
        $query = $this->db->query("SELECT parent_id 
            FROM " . DB_PREFIX . "hpmrr_links 
            WHERE product_id = '" . (int)  $id . "'
            OR parent_id = '" . (int)  $id . "'");

        if($query->num_rows)
            return $query->row['parent_id'];
        else
            return false;
    }
    public function getTypes()
    {
        $query = $this->db->query("SELECT *
        FROM " . DB_PREFIX . "hpmrr_type kt 
        LEFT JOIN " . DB_PREFIX . "hpmrr_type_details ktd 
        ON kt.id = ktd.id ");
        return $query->rows;
    }

    public function delType($id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_type 
            WHERE id = '" . (int) $id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_type_details 
            WHERE id = '" . (int) $id . "'");
    }

    public function getType($id)
    {
        $query = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "hpmrr_type kt 
            LEFT JOIN " . DB_PREFIX . "hpmrr_type_details ktd 
            ON kt.id = ktd.id 
            WHERE kt.id = '" . (int) $id . "'");
        return $query->row;
    }

    public function getChild($parent_id)
    {
        $query = $this->db->query("SELECT *
            FROM " . DB_PREFIX . "hpmrr_links 
            WHERE parent_id = '" . (int) $parent_id . "'");

        return $query->rows;
    }

    public function deleteByParent($parent_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links 
            WHERE parent_id = '" . (int) $parent_id . "'");
    }
    
    public function deleteByIds($ids)
    {
        $ids = array_filter($ids, 'is_numeric');
        if($ids)
        {
            $ids_list = implode(",", $ids);

            $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links 
            WHERE product_id IN (" . $ids_list . ") OR 
            parent_id IN (" . $ids_list . ")");
        }
    }

    public function addSeries($parent_id, $products)
    {
        $result    = true;

        foreach ($products as $product) 
        {
            $id   = (int) $product['id'];
            $sort = (int) $product['sort'];
            $grsort = (int) $product['grsort'];
            $image = $this->db->escape($product['image']);
            
            $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_links 
                 WHERE (parent_id = '". (int) $parent_id . "'
                 AND product_id = '". (int) $id . "')
            ");
                 
            $sql = "INSERT INTO " . DB_PREFIX . "hpmrr_links 
                (parent_id, product_id, sort, image, grsort) 
                VALUES 
                ('$parent_id', '$id', '$sort', '$image', '$grsort');";
            
            $this->db->query($sql);

        }
        return $result;
    }

    public function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit();
    }
    public function editSerie($ids, $serie_id)
    {
        if($ids)
        {
            $sql = "DELETE FROM `" . DB_PREFIX . "hpmrr_product_index` WHERE product_id IN (".implode(",", $ids).")";
            $this->db->query($sql);

            if($serie_id)
            {
                $sql = "INSERT INTO `" . DB_PREFIX . "hpmrr_product_index`(`product_id`, `serie_id`) VALUES ";
                $arr = [];
                $format = "(%d, %d)";

                foreach($ids as $id)
                {
                    $arr[] = sprintf($format, $id, $serie_id);
                }
                $sql .= implode(",", $arr);
                $this->db->query($sql);
            }
        }

    }
    public function editType($data)
    {

        $id          = (int) $data['id'];
        $name        = $this->db->escape($data['name']);
        $description = $this->db->escape($data['description']);

        $status                 = null;
        $hidden_if_null         = null;
        $links                  = null;
        $product_name_as_title  = null;
        $category_name_as_title = null;
        $canonical              = null;
        $sort_by_so             = null;
        $ajax = isset($data['ajax']) ? 1 : 0;
        $catajax = isset($data['catajax']) ? 1 : 0;
        $schemaorg = isset($data['schemaorg']) ? 1 : 0;
        
        $show_price_prdcard = isset($data['show_price_prdcard']) ? 1 : 0;
        $show_price_cat = isset($data['show_price_cat']) ? 1 : 0;
        $minmax_price_prdcard = isset($data['minmax_price_prdcard']) ? 1 : 0;
        $minmax_price_cat = isset($data['minmax_price_cat']) ? 1 : 0;

        if (isset($data['status'])) {
            $status = $this->db->escape($data['status']);
        }

        if (isset($data['hidden_if_null'])) {
            $hidden_if_null = 1;
        }

        if (isset($data['canonical'])) {
            $canonical = 1;
        }


        if (isset($data['sort_by_so'])) {
            $sort_by_so = 1;
        }


        if (isset($data['links'])) {
            $links = $this->db->escape($data['links']);
        }

        if (isset($data['product_name_as_title'])) {
            $product_name_as_title = $this->db->escape($data['product_name_as_title']);
        }

        if (isset($data['category_name_as_title'])) {
            $category_name_as_title = $this->db->escape($data['category_name_as_title']);
        }

        $custom_css = "";//$this->db->escape($data['custom_css']);
        $custom_js  = $this->db->escape($data['custom_js']);

        $suppler         = null;
        $manufacturer    = null;
        $category        = null;
        $products        = null;

        if (isset($data['products']) && $data['products']) {
            $products = implode(',', array_unique($data['products']));
        }

        if (isset($data['suppler']) && $data['suppler']) {
            $suppler = implode(',', $data['suppler']);
        }

        if (isset($data['manufacturer']) && $data['manufacturer']) {
            $manufacturer = implode(',', $data['manufacturer']);
        }

        if (isset($data['category']) && $data['category']) {
            $category = implode(',', $data['category']);
        }

        $product_position      = $this->db->escape($data['product_position']);
        $product_selector      = $this->db->escape($data['product_selector']);
        
        $product_columns           = $this->db->escape(json_encode($data['product_columns']));
        $category_columns           = $this->db->escape(json_encode($data['category_columns']));

        $category_title        = $this->db->escape(json_encode($data['category_title']));
        $product_title        = $this->db->escape(json_encode($data['product_title']));

        $product_image_width   = $this->db->escape($data['product_image_width']);
        $product_image_height  = $this->db->escape($data['product_image_height']);
        $category_image_width   = $this->db->escape($data['category_image_width']);
        $category_image_height  = $this->db->escape($data['category_image_height']);

        $category_variant      = $this->db->escape($data['category_variant']);

        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_type WHERE id='$id'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmrr_type_details WHERE id='$id'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "hpmrr_type(id,name, description, status) "
            . "VALUES ('$id','$name','$description','$status');");

        $this->db->query("INSERT INTO " . DB_PREFIX .
            "hpmrr_type_details(id, category, products, suppler, manufacturer, product_position, product_selector, product_columns, category_columns, custom_css, links, hidden_if_null, custom_js, product_name_as_title, category_name_as_title, category_title, product_title, product_image_width, product_image_height, category_image_width, category_image_height, category_variant, canonical, sort_by_so, ajax, catajax, schemaorg, show_price_prdcard, show_price_cat, minmax_price_prdcard, minmax_price_cat)
        VALUES (
            '$id',
            '$category',
            '$products',
            '$suppler',
            '$manufacturer',
            '$product_position',
            '$product_selector',
            '$product_columns',
            '$category_columns',
            '$custom_css',
            '$links',
            '$hidden_if_null',
            '$custom_js',
            '$product_name_as_title',
            '$category_name_as_title',
            '$category_title',
            '$product_title',
            '$product_image_width',
            '$product_image_height',
            '$category_image_width',
            '$category_image_height',
            '$category_variant',
            '$canonical',
            '$sort_by_so',
            '$ajax',
            '$catajax',
            '$schemaorg',
            '$show_price_prdcard', 
            '$show_price_cat', 
            '$minmax_price_prdcard', 
            '$minmax_price_cat'
        )");
    }
}