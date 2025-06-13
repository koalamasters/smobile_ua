<?php
    if($this->FTMaster && $this->FTMaster->ft_is_enabled()) {
        $manufacturer = $this->FTMaster->get_product_manufacturer($product_info['product_id']);
        $category_name = $this->FTMaster->get_product_category_name($product_info['product_id']);

        $base_price = !empty($product_info['special']) ? $product_info['special'] : $product_info['price'];

        $price = $this->FTMaster->format_price($this->tax->calculate($base_price, $product_info['tax_class_id'], $this->config->get('config_tax')), true);
        $price_eur = $this->FTMaster->format_price($this->tax->calculate($base_price, $product_info['tax_class_id'], $this->config->get('config_tax')), true, false, 'EUR');

        $product_info = array_merge($product_info, $this->DataLayer->_add_alternative_product_ids($product_info));

        $json['gtm_id'] = $product_info['product_id'];
        $json['gtm_id_ee'] = $product_info['product_id_ee'];
        $json['gtm_id_gdr_1'] = $product_info['product_id_gdr_1'];
        $json['gtm_id_gdr_2'] = $product_info['product_id_gdr_2'];
        $json['gtm_id_fb'] = $product_info['product_id_fb'];
        $json['gtm_name'] = $product_info['name'];
        $json['gtm_brand'] = $manufacturer;
        $json['gtm_category'] = $category_name;
        $json['gtm_price'] = $price;
        $json['gtm_price_eur'] = $price_eur;
    }
?>