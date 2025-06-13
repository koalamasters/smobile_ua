<?php
/**
 * @copyright    OCTemplates
 * @support      https://octemplates.net/
 * @license      LICENSE.txt
 */

class ControllerExtensionModuleOctProductBestsellers extends Controller {
    public function index($setting) {
        if ($this->registry->has('oct_mobiledetect')) {
            if ($this->oct_mobiledetect->isMobile() && !$this->oct_mobiledetect->isTablet()) {
                $data['oct_isMobile'] = $this->oct_mobiledetect->isMobile();
            }

            if ($this->oct_mobiledetect->isTablet()) {
                $data['oct_isTablet'] = $this->oct_mobiledetect->isTablet();
            }
        }

        static $module = 0;

        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

        $this->load->language('octemplates/module/oct_product_bestsellers');
        $this->load->model('catalog/product');

			$data['position'] = isset($setting['position']) ? $setting['position'] : '';
			
        $this->load->model('octemplates/module/oct_product_bestsellers');
        $this->load->model('tool/image');

        $data['heading_title'] = (isset($setting['heading'][(int)$this->config->get('config_language_id')]) && !empty($setting['heading'][(int)$this->config->get('config_language_id')])) ? $setting['heading'][(int)$this->config->get('config_language_id')] : $this->language->get('heading_title');

        $data['position'] = isset($setting['position']) ? $setting['position'] : '';
        $data['show_type'] = isset($setting['show_type']) ? $setting['show_type'] : '';
        $data['oct_lazyload'] = false;
        $data['oct_lazy_image'] = $this->config->get('theme_oct_showcase_lazyload_image') ? $this->model_tool_image->resize($this->config->get('theme_oct_showcase_lazyload_image'), 30, 30) : '/image/catalog/showcase/lazy-image.svg';

        if ($this->registry->has('oct_mobiledetect')) {
            if ($this->oct_mobiledetect->isMobile() && !$this->oct_mobiledetect->isTablet() && $this->config->get('theme_oct_showcase_lazyload_mobile')) {
                $data['oct_lazyload'] = true;
            } elseif ($this->oct_mobiledetect->isTablet() && $this->config->get('theme_oct_showcase_lazyload_tablet')) {
                $data['oct_lazyload'] = true;
            } elseif ($this->config->get('theme_oct_showcase_lazyload_desktop')) {
                $data['oct_lazyload'] = true;
            }
        } elseif ($this->config->get('theme_oct_showcase_lazyload_desktop')) {
            $data['oct_lazyload'] = true;
        }

        $data['oct_popup_view_status'] = $this->config->get('oct_popup_view_status');

        $data['products'] = $products =  [];

        $customer_group_id = $this->customer->isLogged() ? $this->customer->getGroupId() : $this->config->get('config_customer_group_id');

        $baseCacheName = 'oct.product.bestsellers';
        $languageId = (int) $this->config->get('config_language_id');
        $storeId = (int) $this->config->get('config_store_id');
        $productLimit = (int) $this->config->get('config_product_limit');

        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = (int)array_pop($parts);
        } else {
            $category_id = 0;
        }

        $manufacturer_id = isset($this->request->get['manufacturer_id']) ? (int)$this->request->get['manufacturer_id'] : 0;

        $categoryCacheSuffix = $category_id ? '.c-' . $category_id : '';
        $manufacturerCacheSuffix = $manufacturer_id ? '.m-' . $manufacturer_id : '';

        $cache_name = sprintf(
            "%s.%d.%d.%d.%d%s%s",
            $baseCacheName,
            $languageId,
            $storeId,
            $customer_group_id,
            $productLimit,
            $categoryCacheSuffix,
            $manufacturerCacheSuffix
        );

        $category_id = ($category_id != 0) ? $category_id : null;
        $manufacturer_id = ($manufacturer_id != 0) ? $manufacturer_id : null;

        $cached_data = $this->cache->get($cache_name);

        if (!$cached_data) {
        
            $filter_data = array(
                'category_id' => $category_id,
                'manufacturer_id' => $manufacturer_id,
                'subcategories' => isset($setting['subcategories']) ? true : false,
                'limit' => $setting['limit']
            );

            $results = $this->model_octemplates_module_oct_product_bestsellers->getBestsellers($filter_data);

            foreach ($results as $result) {
                $products[] = $this->model_catalog_product->getProduct($result['product_id']);
            }

            $this->cache->set($cache_name, $products);
        } else {
            $products = $cached_data;
        }

        $oct_product_stickers = [];

        if ($this->config->get('oct_stickers_status')) {
            $oct_stickers = $this->config->get('oct_stickers_data');

            $data['oct_sticker_you_save'] = false;

            if ($oct_stickers) {
                $data['oct_sticker_you_save'] = isset($oct_stickers['stickers']['special']['persent']) ? true : false;
            }

            $this->load->model('octemplates/stickers/oct_stickers');
        }

        foreach ($products as $product_info) {

            $date_added = strtotime($product_info['date_added']);
            $current_time = time();
            $difference_seconds = $current_time - $date_added;
            $days_passed = floor($difference_seconds / (60 * 60 * 24));

            $is_new = $this->model_catalog_product->getNewStatus($product_info['product_id']);

            $is_new_value = 0;
            if(!empty($is_new)) {
                $is_new_timestamp = strtotime($is_new['new_end_date']);
                $time_active = 0;
                if ($is_new_timestamp > time()) {
                    $time_active = 1;
                }
                if ($time_active && $is_new['is_new']) {
                    $is_new_value = 1;
                } else {
                    $is_new_value = 0;
                }
            }else{
                if($days_passed < 31){
                    $is_new_value = 1;
                }else {
                    $is_new_value = 0;
                }
            }

                if (isset($oct_stickers) && $oct_stickers) {
                    $oct_stickers_data = $this->model_octemplates_stickers_oct_stickers->getOCTStickers($product_info);

                    $oct_product_stickers = [];

                    if ($oct_stickers_data) {
                        $oct_product_stickers = $oct_stickers_data['stickers'];
                    }
                }

                unset($oct_product_stickers['stickers_new']);
                if($is_new_value){
                    $oct_product_stickers['stickers_new'] = 'Новинка';
                }

                $width = (isset($setting['width']) && !empty($setting['width'])) ? $setting['width'] : $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width');
                $height = (isset($setting['height']) && !empty($setting['height'])) ? $setting['height'] : $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height');

                if ($product_info['image'] && file_exists(DIR_IMAGE.$product_info['image'])) {
                    $image = $this->model_tool_image->resize($product_info['image'], $width, $height);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $width, $height);
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                $price_for_ads = null;
                if (!$special) {
                    $price_for_ads = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                } else {
                    $price_for_ads = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$product_info['rating'];
                } else {
                    $rating = false;
                }

                if ($product_info['quantity'] <= 0) {
                    $stock = $product_info['stock_status'];
                } else {
                    $stock = false;
                }

                $can_buy = true;

                if ($product_info['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
                    $can_buy = false;
                } elseif ($product_info['quantity'] <= 0 && $this->config->get('config_stock_checkout')) {
                    $can_buy = true;
                }

                $oct_grayscale = ($this->config->get('theme_oct_showcase_no_quantity_grayscale') && !$can_buy) ? true : false;

                $oct_atributes = false;

                if (isset($oct_showcase_data_atributes) && $oct_showcase_data_atributes) {
                    $limit_attr  = $this->config->get('theme_oct_showcase_data_cat_atr_limit') ? $this->config->get('theme_oct_showcase_data_cat_atr_limit') : 5;

                    $oct_atributes = $this->model_catalog_product->getOctProductAttributes(isset($product_info) ? $product_info['product_id'] : $result['product_id'], $limit_attr);
                }

            $data['usdt_info'] = $this->language->get('usdt_info');

            $price_for_usdt = 0;

            if($product_info['special']){
                $price_for_usdt = explode(' ', $product_info['special'])[0];
            }else{
                $price_for_usdt = explode(' ', $product_info['price'])[0];
            }

            $usdt_price = round($price_for_usdt/$usdt_rate);

                $data['products'][] = [
                    'product_id'  => $product_info['product_id'],
                    'thumb'       => $image,
                    'width'       => $width,
                    'height'      => $height,
                    'name'        => $product_info['name'],
                    'oct_model'	  => $this->config->get('theme_oct_showcase_data_model') ? $product_info['model'] : '',
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price'       => $price,
                    'usdt_price'       => $usdt_price,
                    'special'     => $special,
                    'price_for_ads' => $price_for_ads,
                    'stock'       => $stock,
                    'can_buy'     => $can_buy,
                    'oct_grayscale'  => $oct_grayscale,
                    'oct_atributes'  => $oct_atributes,
                    'oct_stickers'  => $oct_product_stickers,
                    'you_save'  	=> $product_info['you_save'],
                    'tax'         => $tax,
                    'minimum'     => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
                    'rating'      => $rating,
                    'reviews'	  => $product_info['reviews'],
                    'quantity'	  => $product_info['quantity'] <= 0 ? true : false,
                    'quantity_show'	  => $can_buy ? 1 : 0,
                    'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
                ];
        }

        $data['module'] = $module++;
        return $this->load->view('octemplates/module/oct_products_modules', $data);

    }
}
