<?php

class ModelExtensionModuleExPak extends Model
{
    public function updateProductTabs($product_tabs)
    {
        $this->db->query('TRUNCATE TABLE ' . DB_PREFIX . 'ex_pak_tab');
        $this->db->query('TRUNCATE TABLE ' . DB_PREFIX . 'ex_pak_tab_description');
        foreach ($product_tabs as $product_tab) {
            if (empty($product_tab['tab_id'])) {
                $product_tab['tab_id'] = 0;
            }
            $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_tab SET tab_id = ' . (int)$product_tab['tab_id'] . ', status = ' . (int)$product_tab['status'] . ', `limit_tab` = "' . $this->db->escape($product_tab['limit_tab']) . '", `limit_tab_description` = "' . $this->db->escape($product_tab['limit_tab_description']) . '", `current_price` = 1, `limit_main` = "' . $this->db->escape($product_tab['limit_main']) . '", `limit_checkout` = "' . $this->db->escape($product_tab['limit_checkout']) . '"');
            $tab_id = $this->db->getLastId();
            foreach ($product_tab['description'] as $language_id => $description) {
                $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_tab_description SET tab_id = ' . (int)$tab_id . ', language_id = ' . (int)$language_id . ', name = "' . $this->db->escape($description['name']) . '", name_tab = "' . $this->db->escape($description['name_tab']) . '"');
            }
        }
    }

    public function getCategoriesByParentId($parent_id = 0)
    {
        $query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "category WHERE parent_id = c.category_id) AS children FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
        return $query->rows;
    }

    public function getProductTabsForEdit(): array
    {
        $product_tabs = [];
        $query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_tab');
        foreach ($query->rows as $row) {
            $product_tabs[$row['tab_id']] = $row;
        }
        $descriptions = [];
        $description_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_tab_description');
        foreach ($description_query->rows as $description_row) {
            $descriptions[$description_row['tab_id']][$description_row['language_id']] = array(
                'name' => $description_row['name'],
                'name_tab' => $description_row['name_tab'],
            );
        }
        foreach ($product_tabs as $product_tab) {
            $product_tabs[$product_tab['tab_id']]['description'] = isset($descriptions[$product_tab['tab_id']]) ? $descriptions[$product_tab['tab_id']] : [];
        }
        return $product_tabs;
    }

    public function getProductTabs()
    {
        $query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_tab dtt LEFT JOIN ' . DB_PREFIX . 'ex_pak_tab_description dttd ON (dtt.tab_id = dttd.tab_id) WHERE dttd.language_id = ' . (int)$this->config->get('config_language_id'));
        return $query->rows;
    }

    public function getCategories($parent_id, $parent_name = ''): array
    {
        $output = [];
        $results = $this->getCategoriesByParentId($parent_id);
        foreach ($results as $result) {
            if ($parent_name) {
                $name = $parent_name . ' > ' . $result['name'];
            } else {
                $name = $result['name'];
            }
            $output[$result['category_id']] = array(
                'category_id' => $result['category_id'],
                'name' => $name,
            );
            $output += $this->getCategories($result['category_id'], $name);
        }
        return $output;
    }

    public function getProducts($filter_data = [])
    {
        $sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "manufacturer m WHERE m.manufacturer_id = p.manufacturer_id LIMIT 1) as manufacturer FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($filter_data['category_id']) && !is_null($filter_data['category_id'])) {
            preg_match('/(.*)(WHERE pd\.language_id.*)/', $sql, $sql_crutch_matches);
            if (isset($sql_crutch_matches[2])) {
                $sql = $sql_crutch_matches[1] . " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)" . $sql_crutch_matches[2];
            } else {
                $filter_data['category_id'] = null;
            }
        }

        if (!empty($filter_data['name'])) {
            $sql .= " AND pd.name LIKE '%" . $this->db->escape($filter_data['name']) . "%'";
        }

        if (!empty($filter_data['model'])) {
            $sql .= " AND p.model LIKE '%" . $this->db->escape($filter_data['model']) . "%'";
        }

        if (!empty($filter_data['sku'])) {
            $sql .= " AND p.sku LIKE '%" . $this->db->escape($filter_data['sku']) . "%'";
        }

        if (!empty($filter_data['category_id']) && !is_null($filter_data['category_id'])) {
            if (!empty($filter_data['category_id']) && !empty($filter_data['sub_category'])) {
                $implode_data = [];

                $this->load->model('catalog/category');

                $categories = $this->model_catalog_category->getCategoriesChildren($filter_data['category_id']);

                foreach ($categories as $category) {
                    $implode_data[] = "p2c.category_id = '" . (int)$category['category_id'] . "'";
                }

                $sql .= " AND (" . implode(' OR ', $implode_data) . ")";
            } else {
                if ((int)$filter_data['category_id'] > 0) {
                    $sql .= " AND p2c.category_id = '" . (int)$filter_data['category_id'] . "'";
                } else {
                    $sql .= " AND p2c.category_id IS NULL";
                }
            }
        }

        if (!empty($filter_data['manufacturer_id']) && !is_null($filter_data['manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$filter_data['manufacturer_id'] . "'";
        }

        if (!empty($filter_data['price'])) {
            $sql .= " AND p.price LIKE '" . $this->db->escape($filter_data['price']) . "%'";
        }

        if (!empty($filter_data['price_from']) && !is_null($filter_data['price_from'])) {
            $sql .= " AND p.price >= '" . (float)$filter_data['price_from'] . "'";
        }

        if (!empty($filter_data['price_to']) && !is_null($filter_data['price_to'])) {
            $sql .= " AND p.price <= '" . (float)$filter_data['price_to'] . "'";
        }

        if (!empty($filter_data['status'])) {
            $sql .= " AND p.status = '1'";
        }

        if (!empty($filter_data['stock'])) {
            $sql .= " AND p.quantity > 0";
        }

        if (!empty($filter_data['exclude_products'])) {
            $sql .= " AND p.product_id NOT IN (" . implode(', ', $filter_data['exclude_products']) . ")";
        }

        if (!empty($filter_data['search'])) {
            $sql .= " AND (pd.name LIKE '%" . $this->db->escape($filter_data['search']) . "%' OR p.product_id LIKE '%" . $this->db->escape($filter_data['search']) . "%' OR p.sku LIKE '%" . $this->db->escape($filter_data['search']) . "%' OR p.model LIKE '%" . $this->db->escape($filter_data['search']) . "%')";
        }

        $sql .= " GROUP BY p.product_id";
        $sql .= " ORDER BY pd.name ASC";


        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function editProductGroups($product_id, $data)
    {
        // Product groups
        $this->db->query('DELETE FROM ' . DB_PREFIX . 'ex_pak_product_tab WHERE product_id = ' . (int)$product_id);
        $this->db->query('DELETE FROM ' . DB_PREFIX . 'ex_pak_product_tab_products WHERE product_id = ' . (int)$product_id);

        if (!empty($data['ex_pak']['groups'])) {
            foreach ($data['ex_pak']['groups'] as $group) {

                $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_product_tab SET product_id = ' . (int)$product_id . ', group_id = ' . (int)$group['group_id'] . ', sort_order = ' . (int)$group['sort_order'] . ', description_limit = ' . (int)$group['description_limit'] . ', show_description = ' . (!empty($group['show_description']) ? 1 : 0) . ', show_in_main = ' . (!empty($group['show_in_main']) ? 1 : 0) . ', show_in_tab = ' . (!empty($group['show_in_tab']) ? 1 : 0) . ', show_in_checkout = ' . (!empty($group['show_in_checkout']) ? 1 : 0) . ', add_with_main = ' . (!empty($group['add_with_main']) ? 1 : 0) . '');

                if (!empty($group['products'])) {
                    foreach ($group['products'] as $product) {
                        $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_product_tab_products SET product_id = ' . (int)$product_id . ', group_id = ' . (int)$group['group_id'] . ', group_product_id = ' . (int)$product['product_id'] . ', group_product_price = ' . (float)$product['group_price'] . ', group_product_date_from = "' . (!empty($product['group_date_from']) ? date('Y-m-d', strtotime($product['group_date_from'])) : '') . '", group_product_date_to = "' . (!empty($product['group_date_to']) ? date('Y-m-d', strtotime($product['group_date_to'])) : '') . '", group_product_sort_order = ' . (int)$product['group_sort_order'] . ', group_show_in_checkout = "' . (!empty($product['group_show_in_checkout']) ? 1 : 0) . '"');
                    }
                }

            }
        }

        // Product complects
        $this->db->query('DELETE FROM ' . DB_PREFIX . 'ex_pak_product_complect WHERE product_id = ' . (int)$product_id);
        $this->db->query('DELETE FROM ' . DB_PREFIX . 'ex_pak_product_complect_description WHERE product_id = ' . (int)$product_id);
        $this->db->query('DELETE FROM ' . DB_PREFIX . 'ex_pak_product_complect_products WHERE product_id = ' . (int)$product_id);

        if (!empty($data['ex_pak']['complects'])) {
            foreach ($data['ex_pak']['complects'] as $complect) {

                $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_product_complect SET complect_id = ' . (!empty($complect['complect_id']) ? $complect['complect_id'] : 0) . ', product_id = ' . (int)$product_id . ', date_from = "' . (!empty($complect['date_from']) ? date('Y-m-d', strtotime($complect['date_from'])) : '') . '", date_to = "' . (!empty($complect['date_to']) ? date('Y-m-d', strtotime($complect['date_to'])) : '') . '", sort_order = ' . (int)$complect['sort_order']);

                $complect_id = $this->db->getLastId();

                foreach ($complect['description'] as $language_id => $description) {
                    $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_product_complect_description SET complect_id = ' . $complect_id . ', language_id = ' . $language_id . ', product_id = ' . (int)$product_id . ', name = "' . $this->db->escape($description['name']) . '"');
                }

                if (!empty($complect['products'])) {
                    foreach ($complect['products'] as $product) {
                        $this->db->query('INSERT INTO ' . DB_PREFIX . 'ex_pak_product_complect_products SET complect_id = ' . $complect_id . ', product_id = ' . (int)$product_id . ', complect_product_id = ' . (int)$product['product_id'] . ', complect_discount_type = "' . $this->db->escape($product['complect_discount_type']) . '", complect_discount_value = ' . (int)$product['complect_discount_value'] . ', complect_quantity = ' . (int)$product['complect_quantity'] . ', complect_sort_order = ' . (int)$product['complect_sort_order']);
                    }
                }
            }
        }
    }

    public function getProductGroups($product_id): array
    {
        $groups = [];
        $group_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_tab dtpt WHERE dtpt.product_id = ' . (int)$product_id . ' ORDER BY dtpt.sort_order ASC');
        foreach ($group_query->rows as $group_row) {

            $date_from = false;
            $date_to = false;

            $group_product_query = $this->db->query('SELECT dtptp.* FROM ' . DB_PREFIX . 'ex_pak_product_tab_products dtptp LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (dtptp.group_product_id = pd.product_id) WHERE dtptp.product_id = ' . (int)$product_id . ' AND dtptp.group_id = ' . (int)$group_row['group_id'] . ' AND pd.language_id = ' . (int)$this->config->get('config_language_id') . ' ORDER BY dtptp.group_product_sort_order DESC, pd.name');

            $group_row['products'] = [];
            foreach ($group_product_query->rows as $row) {

                $product_date_from = strtotime($row['group_product_date_from']);
                if ($product_date_from <= 0) {
                    $date_from = 0;
                } elseif ($date_from === false) {
                    $date_from = $product_date_from;
                } elseif (($date_from != 0) && ($product_date_from < $date_from)) {
                    $date_from = $product_date_from;
                }

                $product_date_to = strtotime($row['group_product_date_to']);
                if ($product_date_to <= 0) {
                    $date_to = 0;
                } elseif ($date_to === false) {
                    $date_to = $product_date_to;
                } elseif (($date_to != 0) && ($product_date_to > $date_to)) {
                    $date_to = $product_date_to;
                }

                $group_row['products'][] = array(
                    'product_id' => $row['group_product_id'],
                    'group_price' => $row['group_product_price'],
                    'group_date_from' => $row['group_product_date_from'],
                    'group_date_to' => $row['group_product_date_to'],
                    'group_sort_order' => $row['group_product_sort_order'],
                    'group_show_in_checkout' => $row['group_show_in_checkout'],
                );
            }

            $group_row['date_from'] = $date_from ? date('d.m.Y', $date_from) : '';
            $group_row['date_to'] = $date_to ? date('d.m.Y', $date_to) : '';

            $groups[] = $group_row;
        }

        return $groups;
    }

    public function getProductComplects($product_id): array
    {
        $complects = [];
        $complect_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_complect WHERE product_id = ' . (int)$product_id);

        foreach ($complect_query->rows as $complect_row) {
            $complect_row['name'] = '';
            $complect_row['description'] = [];
            $complect_description_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_complect_description WHERE complect_id = ' . $complect_row['complect_id']);
            foreach ($complect_description_query->rows as $complect_description_row) {
                $complect_row['description'][$complect_description_row['language_id']] = $complect_description_row;
                if ($complect_description_row['language_id'] == $this->config->get('config_language_id')) {
                    $complect_row['name'] = $complect_description_row['name'];
                }
            }

            $complect_row['products'] = [];
            $complect_products_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_complect_products WHERE complect_id = ' . $complect_row['complect_id']);
            foreach ($complect_products_query->rows as $complect_product_row) {
                $complect_row['products'][] = array(
                    'product_id' => $complect_product_row['complect_product_id'],
                    'complect_discount_type' => $complect_product_row['complect_discount_type'],
                    'complect_discount_value' => $complect_product_row['complect_discount_value'],
                    'complect_quantity' => $complect_product_row['complect_quantity'],
                    'complect_sort_order' => $complect_product_row['complect_sort_order'],
                );
            }
            $complects[] = $complect_row;
        }

        return $complects;
    }

    public function getProductsData($products): array
    {
        $result = [];
        foreach ($products as $product) {
            if (empty($product['name'])) {
                if (is_array($product)) {
                    $product_id = $product['product_id'];
                } else {
                    $product_id = $product;
                    $product = [];
                }
                $product_info = $this->model_catalog_product->getProduct($product_id);
                if ($product_info) {
                    $manufacturer = '';
                    if ($product_info['manufacturer_id']) {
                        $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);
                        if ($manufacturer_info) {
                            $manufacturer = $manufacturer_info['name'];
                        }
                    }
                    $product['product_id'] = $product_info['product_id'];
                    $product['name'] = $product_info['name'];
                    $product['model'] = $product_info['model'];
                    $product['sku'] = $product_info['sku'];
                    $product['quantity'] = $product_info['quantity'];
                    $product['image'] = $product_info['image'];
                    $product['price'] = $product_info['price'];
                    $product['manufacturer'] = $manufacturer;
                } else {
                    continue;
                }
            }

            if (is_file(DIR_IMAGE . $product['image'])) {
                $image = $this->model_tool_image->resize($product['image'], 100, 100);
            } else {
                $image = $this->model_tool_image->resize('no_image.png', 40, 40);
            }

            $special = false;
            $special_raw = false;

            $product_specials = $this->model_catalog_product->getProductSpecials($product['product_id']);

            foreach ($product_specials as $product_special) {
                if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
                    $special = $this->currency->format($product_special['price'], $this->config->get('config_currency'));
                    $special_raw = $product_special['price'];
                    break;
                }
            }


            $result[$product['product_id']] = array(
                'product_id' => $product['product_id'],
                'name' => html_entity_decode($product['name']),
                'manufacturer' => html_entity_decode($product['manufacturer']),
                'model' => html_entity_decode($product['model']),
                'sku' => html_entity_decode($product['sku']),
                'image' => $image,
                'price' => $this->currency->format($product['price'], $this->config->get('config_currency')),
                'price_raw' => $product['price'],
                'special' => $special,
                'special_raw' => $special_raw,
                'quantity' => $product['quantity'],

                'group_date' => $this->getDateData($product, 'group_date_from', 'group_date_to'),
                'group_sort_order' => isset($product['group_sort_order']) ? $product['group_sort_order'] : 0,
                'group_price' => isset($product['group_price']) ? $product['group_price'] : $product['price'],
                'group_show_in_checkout' => !empty($product['group_show_in_checkout']) ? 1 : 0,

                'complect_discount_type' => isset($product['complect_discount_type']) ? $product['complect_discount_type'] : false,
                'complect_quantity' => isset($product['complect_quantity']) ? $product['complect_quantity'] : false,
                'complect_discount_value' => isset($product['complect_discount_value']) ? $product['complect_discount_value'] : false,
                'complect_sort_order' => isset($product['complect_sort_order']) ? $product['complect_sort_order'] : false,

            );
        }
        $hasGroupSortOrder = array_filter($result, function ($item) {
            return !empty($item['group_sort_order']);
        });

        $sortKey = $hasGroupSortOrder ? 'group_sort_order' : 'complect_sort_order';

        usort($result, function ($a, $b) use ($sortKey) {
            return $a[$sortKey] <=> $b[$sortKey];
        });

        return $result;
    }

    public function calcProducts($products_id, $setting)
    {
        if (empty($setting['value'])) {
            return false;
        }

        $resul_prices = [];

        foreach ($products_id as $product_id) {
            $product_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'product WHERE product_id = ' . (int)$product_id);
            if ($product_query->num_rows) {

                $result_price = $product_query->row['price'];

                if ($setting['price_type'] == 'special') {
                    $product_specials = $this->model_catalog_product->getProductSpecials($product_id);
                    foreach ($product_specials as $product_special) {
                        if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
                            $result_price = $product_special['price'];
                            break;
                        }
                    }
                }

                if ($setting['it'] == 'currency') {
                    $calc_value = $setting['value'];
                } else {
                    $calc_value = $result_price * $setting['value'] / 100;
                }

                if ($setting['opereation'] == 'plus') {
                    $result_price += $calc_value;
                } else {
                    $result_price -= $calc_value;
                }


                if ($setting['round'] == '0.1') {
                    $result_price = round($result_price, 1);
                } elseif ($setting['round'] == '0.01') {
                    $result_price = round($result_price, 2);
                } else {
                    $result_price = round($result_price);
                }

                $resul_prices[$product_id] = $result_price;
            }
        }

        return $resul_prices;
    }

    public function getDateData($date, $val_date_from = 'date_from', $val_date_to = 'date_to'): array
    {

        $result = array(
            'date_from' => '',
            'date_to' => '',
        );

        if (!empty($date[$val_date_from]) && ($date[$val_date_from] != '0000-00-00')) {
            $result['date_from'] = date('d.m.Y', strtotime($date[$val_date_from]));
        }

        if (!empty($date[$val_date_to]) && ($date[$val_date_to] != '0000-00-00')) {
            $result['date_to'] = date('d.m.Y', strtotime($date[$val_date_to]));
        }

        if ($result['date_from'] && $result['date_to']) {
            $result['text'] = $result['date_from'] . ' - ' . $result['date_to'];
            $result['status'] = true;
        } elseif ($result['date_from']) {
            $result['text'] = $result['date_from'] . ' - 00.00.0000';
            $result['status'] = true;
        } elseif ($result['date_to']) {
            $result['text'] = '00.00.0000 - ' . $result['date_to'];
            $result['status'] = true;
        } else {
            $result['text'] = 'Безстроковый';
            $result['status'] = false;
        }

        return $result;
    }

    public function checkDB()
    {
        //Table
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_tab'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_tab` (`tab_id` int(11) NOT NULL, `status` int(11) NOT NULL, `limit_tab` varchar(300) NOT NULL, `limit_tab_description` varchar(300) NOT NULL, `current_price` varchar(300) NOT NULL, `limit_main` varchar(300) NOT NULL, `limit_checkout` varchar(300) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_tab` ADD PRIMARY KEY (`tab_id`);');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_tab` MODIFY `tab_id` int(11) NOT NULL AUTO_INCREMENT');
        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_tab_description'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_tab_description` (`tab_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `name` varchar(300) NOT NULL, `name_tab` varchar(300) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_tab_description`  ADD UNIQUE KEY `tab_id` (`tab_id`,`language_id`);');
        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_product_tab'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_product_tab` (`product_id` int(11) NOT NULL, `group_id` int(11) NOT NULL, `sort_order` int(11) NOT NULL, `description_limit` int(11) NOT NULL, `show_description` int(11) NOT NULL, `show_in_main` int(11) NOT NULL, `show_in_tab` int(11) NOT NULL, `show_in_checkout` int(11) NOT NULL, `add_with_main` int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_tab`  ADD UNIQUE KEY `product_id` (`product_id`,`group_id`);');
        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_product_tab_products'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_product_tab_products` (`product_id` int(11) NOT NULL, `group_id` int(11) NOT NULL, `group_product_id` int(11) NOT NULL, `group_product_price` float(15,4) NOT NULL, `group_product_date_from` date NOT NULL DEFAULT "0000-00-00", `group_product_date_to` date NOT NULL DEFAULT "0000-00-00", `group_product_sort_order` int(11) NOT NULL, `group_show_in_checkout` int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_tab_products`  ADD UNIQUE KEY `product_id` (`product_id`,`group_id`,`group_product_id`);');
        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_product_complect'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_product_complect` (`complect_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `date_from` date NOT NULL, `date_to` date NOT NULL, `sort_order` int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_complect` ADD PRIMARY KEY (`complect_id`);');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_complect` MODIFY `complect_id` int(11) NOT NULL AUTO_INCREMENT;');
        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_product_complect_description'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_product_complect_description` (`complect_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `name` varchar(1000) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_complect_description` ADD UNIQUE KEY `complect_id` (`complect_id`,`language_id`);');
        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_product_complect_products'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_product_complect_products` (`complect_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `complect_product_id` int(11) NOT NULL, `complect_discount_type` varchar(1000) NOT NULL, `complect_discount_value` int(11) NOT NULL, `complect_quantity` int(11) NOT NULL, `complect_sort_order` int(11) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_complect_products` ADD UNIQUE KEY `complect_id` (`complect_id`,`product_id`,`complect_product_id`);');

        }
        $table_query = $this->db->query("SELECT * FROM information_schema.tables WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . "ex_pak_product_complect_order'");
        if (!$table_query->num_rows) {
            $this->db->query('CREATE TABLE `' . DB_PREFIX . 'ex_pak_product_complect_order` (`order_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `complect_id` int(11) NOT NULL, `complect_product_id` int(11) NOT NULL, `quantity` int(11) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_product_complect_order` ADD UNIQUE KEY `order_id` (`order_id`,`product_id`,`complect_id`,`complect_product_id`);');
        }
        //Add Columns
        if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "ex_pak_tab` LIKE 'current_price'")->num_rows) {
            $this->db->query('ALTER TABLE `' . DB_PREFIX . 'ex_pak_tab` ADD COLUMN `current_price`  varchar(300) NOT NULL;');
        }
    }
}