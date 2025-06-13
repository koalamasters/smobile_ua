<?php

class ModelExtensionModuleExPak extends Model
{

    private $data = [];
    private $setting = false;

    public function load()
    {
        if ($this->config->get('module_ex_pak_status')) {
            $this->load->language('product/product');
            $this->load->language('checkout/cart');
            $this->load->language('extension/module/ex_pak');
            $this->load->model('catalog/product');
            $this->load->model('catalog/category');
            $this->load->model('tool/image');
            return true;
        } else {
            return false;
        }
    }

    public function getSetting($value = false)
    {
        if ($this->setting === false) {
            $this->setting = $this->config->get('module_ex_pak_setting');
        }
        if ($value) {
            if (isset($this->setting[$value])) {
                return $this->setting[$value];
            } else {
                return false;
            }
        } else {
            return $this->setting;
        }
    }

    public function getProductGroups($product_id, $groups_position = false, $group_products_position = false)
    {
        $product_group_key = $product_id;
        if ($groups_position) {
            $product_group_key .= '.' . $groups_position;
        }
        if (empty($this->data['products'][$product_group_key])) {
            $groups = [];
            $groups_sql = 'SELECT dtpt.*, dtpt.description_limit, dtt.limit_tab_description, dtt.current_price, dtt.limit_tab, dtt.limit_main, dtt.limit_checkout, dttd.name, dttd.name_tab FROM ' . DB_PREFIX . 'ex_pak_product_tab dtpt LEFT JOIN ' . DB_PREFIX . 'ex_pak_tab dtt ON (dtpt.group_id = dtt.tab_id) LEFT JOIN ' . DB_PREFIX . 'ex_pak_tab_description dttd ON (dtpt.group_id = dttd.tab_id) WHERE dtpt.product_id = ' . (int)$product_id . ' AND dtt.status = 1 AND dttd.language_id = ' . (int)$this->config->get('config_language_id');
            if ($groups_position) {
                $groups_sql .= ' AND dtpt.show_in_' . $groups_position . ' = 1';
            }
            $groups_sql .= ' ORDER BY dtpt.sort_order ASC';
            $groups_query = $this->db->query($groups_sql);
            foreach ($groups_query->rows as $group_row) {
                //$group_products_sql = 'SELECT dtpt.*, dtptp.*, dtptp.group_product_sort_order as sort_order, p.price, pd.name, pd.description, p.model, p.image, p.quantity, viewed FROM ' . DB_PREFIX . 'ex_pak_product_tab_products dtptp LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_tab dtpt ON (dtpt.group_id = dtptp.group_id) LEFT JOIN ' . DB_PREFIX . 'product p ON (dtptp.group_product_id = p.product_id) LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (dtptp.group_product_id = pd.product_id) WHERE dtpt.product_id = ' . (int)$product_id . ' AND dtptp.product_id = ' . (int)$product_id . ' AND dtptp.group_id = ' . (int)$group_row['group_id'] . ' AND (dtptp.group_product_date_from = "0000-00-00" OR DATE(dtptp.group_product_date_from) <= CURRENT_DATE()) AND (dtptp.group_product_date_to = "0000-00-00" OR DATE(dtptp.group_product_date_to) >= CURRENT_DATE()) AND p.status = 1 AND p.quantity > 0 AND pd.language_id = ' . (int)$this->config->get('config_language_id');
                $group_products_sql = 'SELECT dtpt.*, dtptp.*, dtptp.group_product_sort_order as sort_order, p.price, pd.name, pd.description, p.model, p.image, p.quantity, p.viewed, (SELECT price FROM ' . DB_PREFIX . 'product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = ' . (int)$this->config->get('config_customer_group_id') . ' AND ((ps.date_start = "0000-00-00" OR ps.date_start < NOW()) AND (ps.date_end = "0000-00-00" OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM ' . DB_PREFIX . 'ex_pak_product_tab_products dtptp LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_tab dtpt ON (dtpt.group_id = dtptp.group_id) LEFT JOIN ' . DB_PREFIX . 'product p ON (dtptp.group_product_id = p.product_id) LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (dtptp.group_product_id = pd.product_id) WHERE dtpt.product_id = ' . (int)$product_id . ' AND dtptp.product_id = ' . (int)$product_id . ' AND dtptp.group_id = ' . (int)$group_row['group_id'] . ' AND (dtptp.group_product_date_from = "0000-00-00" OR DATE(dtptp.group_product_date_from) <= CURRENT_DATE()) AND (dtptp.group_product_date_to = "0000-00-00" OR DATE(dtptp.group_product_date_to) >= CURRENT_DATE()) AND p.status = 1 AND p.quantity > 0 AND pd.language_id = ' . (int)$this->config->get('config_language_id');
                if ($group_products_position) {
                    $group_products_sql .= ' AND dtptp.group_show_in_' . $group_products_position . ' = 1';
                }
                $group_products_sql .= ' ORDER BY dtptp.group_product_sort_order ASC, pd.name';
                $group_products_query = $this->db->query($group_products_sql);
                $group_products = [];
                foreach ($group_products_query->rows as $group_product_row) {
                    $group_products[] = $this->setGroupProduct($group_product_row);
                }
                if ($group_products) {
                    $group_row['products'] = $group_products;
                    $groups[] = $group_row;
                }
            }
            $this->data['products'][$product_group_key] = $groups;
        }
        if (isset($this->data['products'][$product_group_key])) {
            return $this->data['products'][$product_group_key];
        } else {
            return [];
        }
    }

    public function getGroupProduct($product_id, $group_id, $group_product_id)
    {
        $group_product_query = $this->db->query('SELECT *, p.price as price, dtptp.group_product_sort_order as sort_order, dtptp.product_id FROM ' . DB_PREFIX . 'ex_pak_product_tab_products dtptp LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_tab dtpt ON (dtpt.group_id = dtptp.group_id) LEFT JOIN ' . DB_PREFIX . 'ex_pak_tab dtt ON (dtpt.group_id = dtt.tab_id) LEFT JOIN ' . DB_PREFIX . 'product p ON (p.product_id = dtptp.group_product_id) LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (dtptp.group_product_id = pd.product_id) WHERE dtptp.product_id = ' . (int)$product_id . ' AND dtpt.product_id = ' . (int)$product_id . ' AND dtptp.group_id = ' . (int)$group_id . ' AND (dtptp.group_product_date_from = "0000-00-00" OR DATE(dtptp.group_product_date_from) <= CURRENT_DATE()) AND (dtptp.group_product_date_to = "0000-00-00" OR DATE(dtptp.group_product_date_to) >= CURRENT_DATE()) AND dtptp.group_product_id = ' . (int)$group_product_id . ' AND pd.language_id = ' . (int)$this->config->get('config_language_id'));
        if ($group_product_query->row) {
            return $this->setGroupProduct($group_product_query->row);
        } else {
            return false;
        }
    }

    public function checkActualPrice() {
        //Check toogler

        //Check toogler
    }

    public function setGroupProduct($product)
    {
        //MainPrice
        $this->log->write($product);
        //MainPrice
        //$product['group_product_price'] = $product['group_product_price'] + 999;
        if ($product['image']) {
            $image = $product['image'];
        } else {
            $image = 'placeholder.png';
        }
        if ($product['group_product_price'] < $product['price']) {
            $special = $product['group_product_price'];
            $price = $product['price'];
        } else {
            $price = $product['group_product_price'];
            $special = false;
        }
        if ($product['show_description']) {
            $description = $this->setDescriptionLimit(html_entity_decode($product['description']), $product['description_limit']);
        } else {
            $description = '';
        }
        $product_key = $product['group_product_id'] . '-' . ($product['group_product_price'] * 100);
        if (empty($product['add_with_main'])) {
            $single = true;
        } else {
            $single = false;
            $product_key = $product['product_id'] . '-' . $product_key;
        }

        if ($special > 0 && $price > 0) {
            $discount_procent = round((1 - ($special / $price)) * 100);
        } else {
            $discount_procent = 123;
        }
        return [
            'product_id' => $product['group_product_id'],
            'main_product_id' => $product['product_id'],
            'group_id' => $product['group_id'],
            'product_key' => $product_key,
            'group_product_price' => $product['group_product_price'],
            'add_with_main' => $product['add_with_main'],
            'single' => $single,
            'price' => $this->currency->format($price, $this->session->data['currency']),
            'price_raw' => $price,
            'special' => $special ? $this->currency->format($special, $this->session->data['currency']) : false,
            'special_raw' => $special,
            'discount_procent' => $discount_procent,
            'name' => $product['name'],
            'description' => $description,
            'image' => $this->model_tool_image->resize($image, 230, 230),
            'quantity' => $product['quantity'],
            'viewed' => $product['viewed'],
            'sort_order' => $product['sort_order'],
            'href' => $this->url->link('product/product', 'product_id=' . $product['group_product_id'])
        ];
    }

    public function getProductByCategories($products)
    {
        $product_by_categories = [];
        if ($products) {
            $products_id = [];
            foreach ($products as $product) {
                $products_id[] = $product['product_id'];
            }
            $categories_id = [];
            $product_categories = [];
            $product_category_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'product_to_category WHERE product_id IN (' . implode(', ', $products_id) . ')');
            foreach ($product_category_query->rows as $row) {
                $product_categories[$row['product_id']][] = $row['category_id'];
                $categories_id[$row['category_id']] = $row['category_id'];
            }
            $categories = [];
            if ($categories_id) {
                $category_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'category c LEFT JOIN ' . DB_PREFIX . 'category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id IN (' . implode(', ', $categories_id) . ') AND cd.language_id = "' . $this->config->get('config_language_id') . '" AND c.status = 1 ORDER BY c.sort_order, LCASE(cd.name)');
                foreach ($category_query->rows as $row) {
                    $categories[$row['category_id']] = $row;
                }
            }
            foreach ($products as $product) {
                if (!empty($product_categories[$product['product_id']])) {
                    foreach ($product_categories[$product['product_id']] as $product_category) {
                        if (isset($categories[$product_category])) {
                            if (empty($product_by_categories[$product_category])) {
                                $product_by_categories[$product_category] = [
                                    'category_id' => $product_category,
                                    'name' => $categories[$product_category]['name'],
                                    'products' => [],
                                ];
                            }
                            $product_by_categories[$product_category]['products'][] = $product;
                        }
                    }
                }
            }
        }
        return $product_by_categories;
    }

    public function sortProducts($products)
    {
        $sort_popular = true;
        foreach ($products as $product) {
            if (!empty($product['sort_order'])) {
                $sort_popular = false;
            } else {
                $product['sort_order'] = 0;
            }
        }
        if ($sort_popular) {
            $products = $this->sortProductsDefault($products);
        } else {
            uasort($products, array('self', 'sortProductsSortOrder'));
        }
        return $products;
    }

    public function sortProductsSortOrder($a, $b)
    {
        if ($a['sort_order'] == $b['sort_order']) {
            return 0;
        }
        return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
    }

    public function sortProductsDefault($products)
    {
        $sort = 'order';
        $order = 'desc';
        if ($default_sort = $this->getSetting('default_sort')) {
            $explode = explode('.', $default_sort);
            if (count($explode) == 2) {
                $sort = $explode[0];
                $order = $explode[1];
            }
        }
        $keys = $this->getSortKeys($sort, $products);
        if ($keys) {
            if ($order == 'asc') {
                array_multisort($keys, SORT_ASC, $products);
            } else {
                array_multisort($keys, SORT_DESC, $products);
            }
        }
        return $products;
    }

    private function getSortKeys($key, $products)
    {
        $keys = [];
        switch ($key) {
            case 'quantity':
            case 'viewed':
                foreach ($products as $product) {
                    $keys[] = $product[$key];
                }
                break;
            case 'rating':
                foreach ($products as $product) {
                    $query = $this->db->query("SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r WHERE r.product_id = " . $product['product_id'] . " AND r.status = '1' GROUP BY r.product_id");
                    $keys[] = $query->row['total'];
                }
                break;
            case 'order':
                foreach ($products as $product) {
                    $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "order_product op WHERE op.product_id = " . $product['product_id'] . " GROUP BY op.product_id");
                    if (isset($query->row['total'])) {
                        $keys[] = $query->row['total'];
                    } else {
                        $keys[] = 0;
                    }
                }
                break;
        }
        return $keys;
    }

    public function setDescriptionLimit($description, $description_limit)
    {
        if (utf8_strlen($description) > $description_limit) {
            $description = mb_strimwidth(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8'), ''), 0, $description_limit, "...");
        } else {
            $description = '';
        }
        return $description;
    }


    public function getLimits($group_limit = '')
    {
        if ($default_product_limit = $this->getSetting('default_product_limit')) {
            $default_product_limit = explode('/', $default_product_limit);
        } else {
            $default_product_limit = [];
        }
        $limits = array(
            'desktop' => isset($default_product_limit[0]) ? $default_product_limit[0] : 10,
            'tablet' => isset($default_product_limit[1]) ? $default_product_limit[1] : 6,
            'mobile' => isset($default_product_limit[2]) ? $default_product_limit[2] : 6,
        );
        if ($group_limit) {
            $explode = explode('/', $group_limit);
            if (!empty($explode[0])) {
                $limits['desktop'] = $explode[0];
            }
            if (!empty($explode[1])) {
                $limits['tablet'] = $explode[1];
            }
            if (!empty($explode[2])) {
                $limits['mobile'] = $explode[2];
            }
        }
        return $limits;
    }

    public function getCartProductById($product_id)
    {
        foreach ($this->cart->getProducts() as $product) {
            if (($product['product_id'] == $product_id) && empty($product['main_product_id'])) {
                return $product;
            }
        }
    }

    public function setProductsLimits($products, $limits, $slice = false)
    {
        if ($slice) {
            $max_limit = max($limits);
            $products = array_slice($products, 0, $max_limit);
        }
        $i = 0;
        foreach ($products as $product_key => $product) {
            $i++;
            foreach ($limits as $key => $value) {
                if ($i > $value) {
                    $products[$product_key]['hide_' . $key] = true;
                }
            }
        }
        return $products;
    }

    public function setProductsCartStatus($products, $ignore_main_product = false)
    {
        return $this->cart->setDopTovaryInCart($products, $ignore_main_product);
    }

    public function setProductsHtml($products)
    {
        foreach ($products as $key => $product) {
            $products[$key]['html'] = $this->load->view('extension/module/ex_pak/product_item', $product);
        }
        return $products;
    }

    public function getProductComplects($product_info)
    {
        $complects = [];
        $complects_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_complect pc LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_complect_description pcd ON (pc.complect_id = pcd.complect_id) WHERE pc.product_id = ' . (int)$product_info['product_id'] . ' AND pcd.language_id = ' . $this->config->get('config_language_id') . ' AND (pc.date_from = "0000-00-00" OR DATE(pc.date_from) <= CURRENT_DATE()) AND (pc.date_to = "0000-00-00" OR DATE(pc.date_to) >= CURRENT_DATE()) ORDER BY pc.sort_order');
        if ($complects_query->num_rows) {
            $cart_complects = [];
            foreach ($this->cart->getComplectProducts() as $complect_product) {
                if ($complect_product['main_product_id'] == $product_info['product_id']) {
                    $cart_complects[$complect_product['complect_id']][$complect_product['product_id']] = $complect_product;
                }
            }
            foreach ($complects_query->rows as $complect_row) {
                $complect_products_query = $this->db->query('SELECT *, pcp.product_id as main_product_id, (SELECT price FROM ' . DB_PREFIX . 'product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = "' . (int)$this->config->get('config_customer_group_id') . '" AND pd2.quantity = "1" AND ((pd2.date_start = "0000-00-00" OR pd2.date_start < NOW()) AND (pd2.date_end = "0000-00-00" OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM ' . DB_PREFIX . 'product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = "' . (int)$this->config->get('config_customer_group_id') . '" AND ((ps.date_start = "0000-00-00" OR ps.date_start < NOW()) AND (ps.date_end = "0000-00-00" OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM ' . DB_PREFIX . 'ex_pak_product_complect_products pcp LEFT JOIN ' . DB_PREFIX . 'product p ON (p.product_id = pcp.complect_product_id) LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (pd.product_id = pcp.complect_product_id) LEFT JOIN ' . DB_PREFIX . 'product_to_store p2s ON (p2s.product_id = pcp.complect_product_id) WHERE pcp.complect_id = ' . $complect_row['complect_id'] . ' AND pcp.product_id = ' . (int)$product_info['product_id'] . ' AND pcp.complect_quantity > 0 AND p.status = 1 AND p.quantity > 0 AND p.date_available <= NOW() AND pd.language_id = ' . $this->config->get('config_language_id') . ' AND p2s.store_id = ' . (int)$this->config->get('config_store_id') . ' ORDER BY pcp.complect_sort_order');
                if ($complect_products_query->num_rows) {
                    $complect_row['products'] = [];
                    foreach ($complect_products_query->rows as $complect_product_row) {
                        $product = $this->setComplectProduct($product_info, $complect_product_row);
                        if (isset($cart_complects[$complect_product_row['complect_id']][$complect_product_row['complect_product_id']])) {
                            $product['in_cart'] = true;
                            $product['cart_product_key'] = $cart_complects[$complect_product_row['complect_id']][$complect_product_row['complect_product_id']]['product_key'];
                        }
                        $complect_row['products'][] = $product;
                    }
                    $complects[] = $complect_row;
                }
            }
        }
        return $complects;
    }

    public function getProductComplectProduct($product_info, $complect_id, $complect_product_id)
    {
        $complect_product = [];
        $complect_products_query = $this->db->query('SELECT *, pcp.product_id as main_product_id, (SELECT price FROM ' . DB_PREFIX . 'product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = "' . (int)$this->config->get('config_customer_group_id') . '" AND pd2.quantity = "1" AND ((pd2.date_start = "0000-00-00" OR pd2.date_start < NOW()) AND (pd2.date_end = "0000-00-00" OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM ' . DB_PREFIX . 'product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = "' . (int)$this->config->get('config_customer_group_id') . '" AND ((ps.date_start = "0000-00-00" OR ps.date_start < NOW()) AND (ps.date_end = "0000-00-00" OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM ' . DB_PREFIX . 'ex_pak_product_complect_products pcp LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_complect pc ON (pc.complect_id = pcp.complect_id) LEFT JOIN ' . DB_PREFIX . 'product p ON (p.product_id = pcp.complect_product_id) LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (pd.product_id = pcp.complect_product_id) LEFT JOIN ' . DB_PREFIX . 'product_to_store p2s ON (p2s.product_id = pcp.complect_product_id) WHERE pcp.complect_product_id = ' . $complect_product_id . ' AND pcp.complect_id = ' . $complect_id . ' AND pcp.product_id = ' . (int)$product_info['product_id'] . ' AND pcp.complect_quantity > 0 AND (pc.date_from = "0000-00-00" OR DATE(pc.date_from) <= CURRENT_DATE()) AND (pc.date_to = "0000-00-00" OR DATE(pc.date_to) >= CURRENT_DATE()) AND p.status = 1 AND p.quantity > 0 AND p.date_available <= NOW() AND pd.language_id = ' . $this->config->get('config_language_id') . ' AND p2s.store_id = ' . (int)$this->config->get('config_store_id') . ' ORDER BY pcp.complect_sort_order');
        if ($complect_products_query->num_rows) {
            $complect_product = $this->setComplectProduct($product_info, $complect_products_query->row);
        }
        return $complect_product;
    }

    public function setComplectProduct($product_info, $product)
    {
        $main_product_price = $product_info['price'];
        if ($product_info['special']) {
            $main_product_special = $product_info['special'];
        } else {
            $main_product_special = false;
        }
        if ($product['image']) {
            $image = $product['image'];
        } else {
            $image = 'placeholder.png';
        }
        if ($product['special']) {
            $product_price = $product['special'];
        } elseif ($product['discount']) {
            $product_price = $product['discount'];
        } else {
            $product_price = $product['price'];
        }
        $discount = 0;
        if ($product['complect_discount_type'] == 'procent') {
            $discount = $product_price * $product['complect_discount_value'] / 100;
        } elseif ($product['complect_discount_type'] == 'sum') {
            $discount = $product['complect_discount_value'];
        }
        $complect_price = $main_product_price + $product_price;
        if ($main_product_special) {
            $complect_special = $main_product_special + $product_price - $discount;
        } else {
            $complect_special = $complect_price - $discount;
        }
        if ($discount) {
            $product_special = $product_price - $discount;
            $complect_discount_procent = round(($discount * 100 / $complect_price));
            $discount_procent = round(($discount * 100 / $product_price));
        } else {
            $product_special = false;
            $discount_procent = false;
            $complect_discount_procent = false;
        }
        return array(
            'product_id' => $product['complect_product_id'],
            'main_product_id' => $product['main_product_id'],
            'complect_id' => $product['complect_id'],
            'product_key' => $product['main_product_id'] . '-' . $product['complect_id'] . '-' . $product['complect_product_id'],
            'name' => $product['name'],
            'image' => $this->model_tool_image->resize($image, 230, 230),
            'price' => $this->currency->format($product_price, $this->session->data['currency']),
            'price_raw' => $product_price,
            'special' => $product_special ? $this->currency->format($product_special, $this->session->data['currency']) : false,
            'special_raw' => $product_special,
            'discount_price' => $this->currency->format($discount, $this->session->data['currency']),
            'discount_procent' => $discount_procent,
            'complect_price' => $this->currency->format(($complect_price), $this->session->data['currency']),
            'complect_special' => ($complect_special < $complect_price) ? $this->currency->format($complect_special, $this->session->data['currency']) : false,
            'complect_discount_procent' => $complect_discount_procent,
            'href' => $this->url->link('product/product', 'product_id=' . $product['complect_product_id']),
            'no_button_cart' => true,
        );
    }

    public function checkCartProductHasGroups($product)
    {
        if (empty($product['main_product_id'])) {
            $groups = $this->getProductGroups($product['product_id'], 'checkout');
            if ($groups) {
                return $product['product_id'];
            }
        }
        return false;
    }

    public function addComplectOrder($order_id, $products = [])
    {
        foreach ($products as $product) {
            if (!empty($product['complect_id']) && !empty($product['main_product_id'])) {
                $this->db->query('REPLACE INTO ' . DB_PREFIX . 'ex_pak_product_complect_order SET order_id = ' . (int)$order_id . ', product_id = ' . (int)$product['main_product_id'] . ', complect_id = ' . (int)$product['complect_id'] . ', complect_product_id = ' . (int)$product['product_id'] . ', quantity = ' . (int)$product['quantity']);
            }
        }
    }

    public function processComplectOrder($order_id, $type)
    {
        $query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_complect_order WHERE order_id = ' . (int)$order_id);
        foreach ($query->rows as $row) {
            $this->db->query('UPDATE ' . DB_PREFIX . 'ex_pak_product_complect_products SET complect_quantity = (complect_quantity ' . ($type == 'minus' ? '-' : '+') . ' ' . (int)$row['quantity'] . ') WHERE complect_id = ' . $row['complect_id'] . ' AND product_id = ' . $row['product_id'] . ' AND complect_product_id = ' . $row['complect_product_id']);
        }
    }
}