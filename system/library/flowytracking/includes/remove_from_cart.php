<?php
    if($this->FTMaster && $this->FTMaster->ft_is_enabled()) {
        if (version_compare(VERSION, '2.1.0.2.1', '>=')) {
            $query = "SELECT * FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$this->request->post['key'] . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'";

            if (version_compare(VERSION, '2.3.0.0', '>='))
                $query .= " AND api_id = " . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0);

            $result = $this->db->query($query);

            $product_removed = $result->row;
        } else {
            if (!is_numeric($this->request->post['key']))
                $product_removed = unserialize(base64_decode($this->request->post['key']));
            else
                $product_removed['product_id'] = $this->request->post['key'];

            $product_removed['quantity'] = 1;

            //Devman Extensions - info@flowytracking.com - 2017-05-31 16:07:38 - Get quantity removed
            $cart_products = $this->cart->getProducts();
            foreach ($cart_products as $key => $prod) {
                if ($prod['product_id'] == $product_removed['product_id']) {
                    $product_removed['quantity'] = $prod['quantity'];
                    break;
                }
            }
            //END
        }

        if (!empty($product_removed['product_id'])) {
            $product_id = $product_removed['product_id'];
            $quantity = $product_removed['quantity'];

            $this->load->model('catalog/product');
            $product_info = $this->model_catalog_product->getProduct($product_id);
            $product_info = array_merge($product_info, $this->DataLayer->_add_alternative_product_ids($product_info));
            $manufacturer = $this->FTMaster->get_product_manufacturer($product_info['product_id']);
            $category_name = $this->FTMaster->get_product_category_name($product_info['product_id']);
            $price = $this->FTMaster->format_price($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), true);

            $json['gtm_id'] = $product_info['product_id'];
            $json['gtm_id_ee'] = $product_info['product_id_ee'];
            $json['gtm_id_gdr_1'] = $product_info['product_id_gdr_1'];
            $json['gtm_id_gdr_2'] = $product_info['product_id_gdr_2'];
            $json['gtm_id_fb'] = $product_info['product_id_fb'];
            $json['gtm_name'] = $product_info['name'];
            $json['gtm_brand'] = $manufacturer;
            $json['gtm_category'] = $category_name;
            $json['gtm_quantity'] = $quantity;
            $json['gtm_price'] = $price;

            $json['gtm_variant'] = '';

            //Variants
            $option = '';

            if (!empty($product_removed['option']) && is_array($product_removed['option']))
                $option = $product_removed['option'];
            elseif (!empty($product_removed['option']))
                $option = json_decode($product_removed['option']);

            if (!empty($option))
                $json['gtm_variant'] = $this->FTMaster->get_product_variant($product_info['product_id'], $option);
            //END
        }
    }
?>