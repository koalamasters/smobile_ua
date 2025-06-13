<?php
    if($this->FTMaster && $this->FTMaster->ft_is_enabled() && !empty($product_info)) {
        $product_info = array_merge($product_info, $this->DataLayer->_add_alternative_product_ids($product_info));
        $manufacturer = $this->FTMaster->get_product_manufacturer($product_info['product_id']);
        $category_name = $this->FTMaster->get_product_category_name($product_info['product_id']);

        $base_price = !empty($product_info['special']) ? $product_info['special'] : $product_info['price'];

        //Options combinations compatibility
            if(!empty($product_info['options_combination'])) {
                $comb_special = $this->model_extension_module_options_combinations->findCustomerSpecial($product_info['options_combination']);
                if(!empty($comb_special['price'])) {
                    $base_price = $comb_special['price'];
                } else {
                    $comb_price = $this->model_extension_module_options_combinations->findCustomerPrice($product_info['options_combination']);
                    if (!empty($comb_price) && !empty($comb_price['price_prefix']) && array_key_exists('price', $comb_price)) {
                        $price_prefix = $comb_price['price_prefix'];
                        $price_value = $comb_price['price'];
                        if ($price_prefix == '+') {
                            $base_price += $price_value;
                        } elseif ($price_prefix == '-') {
                            $base_price -= $price_value;
                        } elseif ($price_prefix == '=') {
                            $base_price = $price_value;
                        }
                    }
                }
            }
        //END Options combinations compatibility

        $price = $this->FTMaster->format_price($this->tax->calculate($base_price, $product_info['tax_class_id'], $this->config->get('config_tax')), true);
        $price_eur = $this->FTMaster->format_price($this->tax->calculate($base_price, $product_info['tax_class_id'], $this->config->get('config_tax')), true, false, 'EUR');
        $json['gtm_id'] = $product_info['product_id'];
        $json['gtm_id_ee'] = $product_info['product_id_ee'];
        $json['gtm_id_gdr_1'] = $product_info['product_id_gdr_1'];
        $json['gtm_id_gdr_2'] = $product_info['product_id_gdr_2'];
        $json['gtm_id_fb'] = $product_info['product_id_fb'];
        $json['gtm_name'] = str_replace('&amp;', '&', $product_info['name']);
        $json['gtm_brand'] = $manufacturer;
        $json['gtm_category'] = $category_name;
        $json['gtm_quantity'] = $quantity;
        $json['gtm_price'] = $price;
        $json['gtm_price_eur'] = $price_eur;
        $json['gtm_variant'] = '';
        $json['gtm_extra_params'] = array();

        //Variants
        if (!empty($option)) {
            $json['gtm_variant'] = $this->FTMaster->get_product_variant($product_info['product_id'], $option);
        }
        //END
    }
?>