<?php
class ControllerProductProduct extends Controller
{
    private $error = array();

    public function index()	{
        $use_avif = true;
        $this->load->model('extension/xbundle');

        $data['show_compects'] = false;
        if(isset($this->request->get['show_compects']) && $this->request->get['show_compects'] == 'y'){
            $data['show_compects'] = true;
        }

        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

        if (isset($this->request->get['product_id'])) {
            $product_id = (int) $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        if (isset($this->request->get['path'])) {
            unset($this->request->get['path']);
        }
        $this->load->language('product/product');
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $product_info = $this->model_catalog_product->getProduct($product_id);
        $product_cat = $this->model_catalog_product->getCategories($product_id);


        if(isset( $this->request->get['show_bundle'])){
            $data['show_bundle'] = $this->request->get['show_bundle'];
        }else{
            $data['show_bundle'] = 0;
        }

        $data['bundles'] = [];
        $product_bundles = $this->model_extension_xbundle->getbundlebyproductid($product_id);


        $bundles = [];
        $data['bundles_count'] = count($product_bundles);


        foreach ($product_bundles as $product_bundle){
            $tmp_product = [];
            $bundle_full_price = 0;
            foreach ($product_bundle['product'] as $bundle_product_id){
                $tmp_product = $this->model_catalog_product->getProduct($bundle_product_id);
                $bundle_full_price = $bundle_full_price + $tmp_product['price'];

                $bundles[$product_bundle['xbundle_id']]['dosciunt'] = $product_bundle['discount'];
                $bundles[$product_bundle['xbundle_id']]['add_to_cart_link'] = 'index.php?route=extension/xbundle/addtocart&bundle_id='.$product_bundle['xbundle_id'];

                $price_for_usdt = 0;

                if($tmp_product['special']){
                    $price_for_usdt = explode(' ', $tmp_product['special'])[0];
                }else{
                    $price_for_usdt = explode(' ', $tmp_product['price'])[0];
                }

                $tmp_product['usdt_price'] = round($price_for_usdt/$usdt_rate);

                $tmp_product['price'] = $this->currency->format($this->tax->calculate($tmp_product['price'], $tmp_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $tmp_product['special'] = $this->currency->format($this->tax->calculate($tmp_product['special'], $tmp_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

                $tmp_product['link'] = $this->url->link('product/product', '&product_id=' . $bundle_product_id);
                $bundles[$product_bundle['xbundle_id']]['products'][] = $tmp_product ;

                $bundles[$product_bundle['xbundle_id']]['end_price'] += $tmp_product['price'];
            }

            $bundles[$product_bundle['xbundle_id']]['full_price'] = $this->currency->format($this->tax->calculate($bundle_full_price, $tmp_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);;


            $end_price = $bundle_full_price - $bundles[$product_bundle['xbundle_id']]['dosciunt'];

            $bundles[$product_bundle['xbundle_id']]['end_price'] = $this->currency->format($this->tax->calculate($end_price, $tmp_product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

            $end_price_usdt = explode(' ', $end_price)[0];
            $bundles[$product_bundle['xbundle_id']]['end_price_usdt'] = round($end_price_usdt/$usdt_rate);
            $bundles[$product_bundle['xbundle_id']]['count'] = count($bundles[$product_bundle['xbundle_id']]['products']);

        }
        $data['bundles'] = $bundles;

        $data['text_video'] = $this->language->get('video');
        $data['cart_text2'] = $this->language->get('cart_text2');
        $data['order_with'] = $this->language->get('order_with');
        $data['oct_product_quickbuy'] = $this->language->get('oct_product_quickbuy');

        $data['text_video_youtube'] = $this->language->get('video_youtube');
        $data['text_photo'] = $this->language->get('photo');

        $data['toogether_cheaper'] = $this->language->get('toogether_cheaper');
        $data['toogether_convenient'] = $this->language->get('toogether_convenient');

        $data['text_tab_description'] = $this->language->get('tab_description');

        $data['data_preorder'] = 0;
        if($product_info['quantity'] > 0 && $product_info['stock_status_id'] == 8){
            $data['data_preorder'] = 1;
            $data['preorder_text'] = $this->language->get('preorder_text');
        }

        // Шукаємо ID основної категорії
        $main_cat_id = 0;
        foreach ($product_cat as $cat){
            if($cat['main_category'] == 1){
                $main_cat_id = $cat['category_id'];
            }
        }

        // Рекурсивно проходимось від основної категорії до категорії найвищого рівня
        $counter = 0;
        $product_cat_ids = [];
        $category_id = $main_cat_id;
        do {
            $product_cat_ids[] = $category_id;
            $counter++;
            $row = $this->model_catalog_category->getCategory($category_id);
            $category_id = $row['parent_id'];
            if($counter> 5){
                break;
            }
        } while ($row['parent_id'] != 0);

        // де n - це ID категорії
        $product_cat_ids = array_reverse($product_cat_ids);
        $new_path = implode('_', $product_cat_ids);
        $this->request->get['path'] = $new_path;

        $url_parts = explode('/',$_SERVER['REQUEST_URI']);
        $url_parts = array_filter($url_parts);

        if($url_parts[1] == 'ru') {
            $product_url_part = 2;
        }else{
            $product_url_part = 1;
        }
        if ($url_parts[$product_url_part] != 'product') {
            $new_url = $this->url->link('product/product', 'product_id=' . $product_id, '', 'SSL');
            $new_url = str_replace('http:', 'https:', $new_url);
            header("Location: $new_url", TRUE, 301);
        }

        $this->document->addScript('/catalog/view/theme/journal3/lib/lightgallery/js/lightgallery-all.min.js');
        $this->document->addScript('catalog/view/theme/journal3/lib/lightgallery/js/lightgallery.js');
        $this->document->addStyle('catalog/view/theme/journal3/lib/lightgallery/css/lightgallery.min.css');
        $this->document->addStyle('catalog/view/theme/journal3/lib/lightgallery/css/lg-transitions.min.css');
        $this->document->addStyle('catalog/view/theme/journal3/lib/lightgallery/css/lg-fb-comment-box.min.css');

        $data['delivery_info'] =  $this->language->get('delivery_info');

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['path'])) {
            $path = '';

            $parts = explode('_', (string) $this->request->get['path']);

            $category_id = (int) array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path .= '_' . $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path)
                    );
                }
            }

            // Set the last category breadcrumb
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $url = '';

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }

                $data['breadcrumbs'][] = array(
                    'text' => $category_info['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
                );
            }
        }

        $this->load->model('catalog/manufacturer');

        if (isset($this->request->get['manufacturer_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_brand'),
                'href' => $this->url->link('product/manufacturer')
            );

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

            if ($manufacturer_info) {
                $data['breadcrumbs'][] = array(
                    'text' => $manufacturer_info['name'],
                    'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
                );
            }
        }

        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_search'),
                'href' => $this->url->link('product/search', $url)
            );
        }

        if (isset($this->request->get['product_id'])) {
            $product_id = (int) $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        if ($this->customer->isLogged()) {

            $data['user']['firstname'] = $this->customer->getFirstName();
            $data['user']['lastname'] = $this->customer->getLastName();
        }

        if ($product_info) {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $product_info['name'],
                'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id'])
            );


            $data['mobile_breadcrumbs'] = $data['breadcrumbs'];

            $data['mobile_breadcrumbs'] = array_reverse($data['mobile_breadcrumbs']);

            unset($data['mobile_breadcrumbs'][0]);

            $this->document->setRobots('index, follow');

            if ($this->config->get('config_language_id') == 3) {
                $this->document->setTitle('Купити ' . $product_info['meta_title'] . ' | Smobile' );
                $this->document->setDescription('Замовляйте онлайн ' . $product_info['meta_description'] . ' в інтернет-магазині Smobile ✅ Повернення та обмін ➡️ Доставка по всій Україні');
            } else {
                $this->document->setTitle('Купить ' . $product_info['meta_title'] . ' | Smobile' );
                $this->document->setDescription('Заказывайте онлайн ' . $product_info['meta_description'] . ' в интернет-магазине Smobile ✅ Возврат и обмен ➡️ Доставка по всей Украине');
            }

            $this->document->setKeywords($product_info['meta_keyword']);


            $url = $this->url->link('product/product', 'product_id=' . $this->request->get['product_id']);
            $url = str_replace('http://', '', $url);
            $this->document->addLink($url, 'canonical');

            $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
            $this->document->addScript('catalog/view/theme/journal3/lib/swiper/swiper.min.js');
            $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
            $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
            $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
            $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
            $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

            $data['heading_title'] = $product_info['name'];

            $data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
            $data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));

            $this->load->model('catalog/review');

            $data['review_count'] = sprintf($this->language->get('review_count'), $product_info['reviews']);

            $data['product_id'] = (int) $this->request->get['product_id'];
            $data['manufacturer'] = $product_info['manufacturer'];
            $data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $data['model'] = $product_info['model'];
            $data['reward'] = $product_info['reward'];
            $data['points'] = $product_info['points'];
            $data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');

            if ($product_info['quantity'] <= 0) {
                $data['stock'] = $product_info['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $data['stock'] = $product_info['quantity'];
            } else {
                $data['stock'] = $this->language->get('text_instock');
            }

            $this->load->model('tool/image');

            if ($product_info['image']) {
                $data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
                $data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
            } else {
                $data['popup'] = '';
            }


            $img_thumb = '';
            if( $use_avif){
                $img_thumb = $this->model_tool_image->getAvif($product_info['image']);
            }else{
                $img_thumb = '/image/'.$product_info['image'];
            }

            if ($product_info['image']) {
                //$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
                $data['thumb'] = $img_thumb;
            } else {
                $data['thumb'] = '';
            }

            $data['images'] = array();

            $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

            foreach ($results as $result) {

                $img = '';
                if( $use_avif){
                    $img =  $this->model_tool_image->getAvif($result['image']);
                }else{
                    $img = '/image/'.$result['image'];
                }


                $data['images'][] = array(
                   // 'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
                    'popup' => $img,
                    'thumb' => $img,
                    //'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'))
                );
            }

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $data['price'] = false;
            }

            if ((float) $product_info['special']) {
                $data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $data['special'] = false;
            }

            if (!$data['special']) {
                $data['price_for_ads'] = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
            } else {
                $data['price_for_ads'] = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
            }

            if ($this->config->get('config_tax')) {
                $data['tax'] = $this->currency->format((float) $product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
            } else {
                $data['tax'] = false;
            }

            $discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);

            $data['discounts'] = array();

            foreach ($discounts as $discount) {
                $data['discounts'][] = array(
                    'quantity' => $discount['quantity'],
                    'price' => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
                );
            }

            $data['options'] = array();

            foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
                $product_option_value_data = array();

                foreach ($option['product_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float) $option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                        } else {
                            $price = false;
                        }

                        $product_option_value_data[] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'name' => $option_value['name'],
                            'image' => $this->model_tool_image->resize($option_value['image'], 50, 50),
                            'price' => $price,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                    'product_option_id' => $option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'value' => $option['value'],
                    'required' => $option['required']
                );
            }

            if ($product_info['minimum']) {
                $data['minimum'] = $product_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }

            $data['review_status'] = $this->config->get('config_review_status');

            if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
                $data['review_guest'] = true;
            } else {
                $data['review_guest'] = false;
            }

            if ($this->customer->isLogged()) {
                $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
            } else {
                $data['customer_name'] = '';
            }

            $data['reviews'] = sprintf($this->language->get('text_reviews'), (int) $product_info['reviews']);
            $data['rating'] = (int) $product_info['rating'];

            // Captcha
            if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('review', (array) $this->config->get('config_captcha_page'))) {
                $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
            } else {
                $data['captcha'] = '';
            }

            $data['share'] = $this->url->link('product/product', 'product_id=' . (int) $this->request->get['product_id']);

            $data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

            $data['products'] = array();

            $results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float) $result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int) $result['rating'];
                } else {
                    $rating = false;
                }

                $data['usdt_info'] = $this->language->get('usdt_info');

                $price_for_usdt = 0;

                if($result['special']){
                    $price_for_usdt = explode(' ', $result['special'])[0];
                }else{
                    $price_for_usdt = explode(' ', $result['price'])[0];
                }

                $usdt_price = round($price_for_usdt/$usdt_rate);

                $data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price' => $price,
                    'special'     => $special,
                    'tax' => $tax,
                    'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating' => $rating,
                    'usdt_price' => $usdt_price,
                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                );
            }

            $data['tags'] = array();

            if ($product_info['tag']) {
                $tags = explode(',', $product_info['tag']);

                foreach ($tags as $tag) {
                    $data['tags'][] = array(
                        'tag' => trim($tag),
                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                    );
                }
            }

            /**
             * Визначаємо ID атрибутів для виведення у основній таблиці
             */
            $attr_tempalte_id = $this->model_catalog_product->getProductAttributeTemplate($product_id);
            if($attr_tempalte_id) {
                $main_attr_ids_array = $this->model_catalog_product->getBaseAttrIds($attr_tempalte_id);
                $main_attr_ids = [];
                foreach ($main_attr_ids_array as $item){
                    $main_attr_ids[] = $item['attribute_id'];
                }
            }


            $main_attributes = [];

            foreach ($data['attribute_groups'] as $attr_group_key => &$attribute_group){
                foreach ($attribute_group['attribute'] as $attr_key=>&$attribute){
                    $array_for_count = explode(', ', $attribute['text']);
                    $attr_lines = count($array_for_count);
                    if($attr_lines > 10){
                        $attribute['need_wrapper'] = 1;
                    }else{
                        $attribute['need_wrapper'] = 0;
                    }
//                    $attribute['text'] = str_replace(', ', "<br>",$attribute['text']);
                    $data['attribute_groups'][$attr_group_key]['attribute'][$attr_key]['text'] = html_entity_decode($attribute['text']);

                    if($attr_tempalte_id) {
                        if(in_array($attribute['attribute_id'], $main_attr_ids)){
                            $main_attributes[] = $attribute;
                        }
                    }
                    if(strlen($attribute['text']) == 0){
                        unset($data['attribute_groups'][$attr_group_key]['attribute'][$attr_key]);
                    }
                }

            }

            $data['show_more_text'] = $this->language->get('show_more');

            $data['usdt_info'] = $this->language->get('usdt_info');


            $data['single_review'] = $this->language->get('single_review');
            $data['single_question'] = $this->language->get('single_question');
            $data['leave_review'] = $this->language->get('leave_review');
            $data['product_code'] = $this->language->get('product_code');
            $data['reviews_and_question'] = $this->language->get('reviews_and_question');
            $data['customer_reviews_about'] = $this->language->get('customer_reviews_about');
            $data['reviews_multi'] = $this->language->get('reviews_multi');

            if($product_info['special']){
                $price_for_usdt = explode(' ', $product_info['special'])[0];
            }else{
                $price_for_usdt = explode(' ', $product_info['price'])[0];
            }

            $data['usdt_price'] = round($price_for_usdt/$usdt_rate);
            $data['main_attributes'] = $main_attributes;
            $data['main_attr_title'] = $this->language->get('main_attr');

            if($product_info['special'] != $product_info['price'] && $product_info['special'] > 0){
                $discount_percentage = (($product_info['price'] - $product_info['special']) / $product_info['price']) * 100;
                $data['custom_labels']['sale'] = '-'.round($discount_percentage).'%';
            }

            $data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);

            $this->model_catalog_product->updateViewed($this->request->get['product_id']);


            /**
             * Визначаємо кількість днів від моменту додавання товару
             */
            $date_added = strtotime($product_info['date_added']);
            $current_time = time();
            $difference_seconds = $current_time - $date_added;
            $days_passed = floor($difference_seconds / (60 * 60 * 24));

            $is_new = $this->model_catalog_product->getNewStatus($this->request->get['product_id']);

            if(!empty($is_new)) {
                $is_new_timestamp = strtotime($is_new['new_end_date']);
                $time_active = 0;
                if ($is_new_timestamp > time()) {
                    $time_active = 1;
                }
                if ($time_active && $is_new['is_new']) {
                    $data['is_new'] = 1;
                } else {
                    $data['is_new'] = 0;
                }
            }else{
                if($days_passed < 31){
                    $data['is_new'] = 1;
                }else {
                    $data['is_new'] = 0;
                }
            }


            unset( $data['oct_product_stickers']['stickers_new']);

            $data['custom_labels'] = [];
            if($data['is_new']) {
//                $data['custom_labels']['new'] = 'new';
                $data['oct_product_stickers']['stickers_new'] = 'Новинка';
            }


            if($this->customer->isLogged()){
                $data['logged'] = 1;
            }else{
                $data['logged'] = 0;
            }



            if($use_avif) {
                $description = $data['description'];
                $imageLinks = [];
                preg_match_all('/[\'"]([^\'"]+\.(?:png|jpe?g))[\'"]/i', $description, $matches);
                if (!empty($matches[1])) {
                    $imageLinks_orig = $matches[1];
                    $imageLinks = str_replace('../image/', '', $matches[1]);
                }

                $imageLinksAvif = [];
                foreach ($imageLinks as $key => $orig_image) {
                    $imageLinksAvif[$key] = $this->model_tool_image->getAvif($orig_image,1);
                }
                $description = str_replace($imageLinks_orig, $imageLinksAvif, $description);
                $data['description'] = $description;
            }

            $data['text_auth'] = $this->language->get('auth');
            $data['oct_text_no_reviews_no_auth'] = $this->language->get('oct_text_no_reviews_no_auth');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $data['text_oneclick'] = $this->language->get('1click');
            $data['text_like'] = $this->language->get('like');
            $data['text_compare2'] = $this->language->get('compare2');
            $data['text_getinfo'] = $this->language->get('getinfo');
            $data['text_off_dist'] = $this->language->get('off_dist');
            $data['text_FreeDelivery'] = $this->language->get('FreeDelivery');
            $data['text_paument_methods'] = $this->language->get('paument_methods');
            $data['part_payment'] = $this->language->get('part_payment');
            $data['text_delivery_service'] = $this->language->get('delivery_service');
            $data['text_cryptopay'] = $this->language->get('cryptopay');
            $data['tab_review_text'] = $this->language->get('tab_review_text');
            $this->response->setOutput($this->load->view('product/product', $data));

        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    public function review()
    {
        $this->load->language('product/product');

        $this->load->model('catalog/review');

        $data['text_video_review'] = $this->language->get('video_review');
        $data['text_auth'] = $this->language->get('auth');
      

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['reviews'] = array();

        $review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

        $results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

        foreach ($results as $result) {
            $attachments = $this->model_catalog_review->get_review_attachments($result['review_id']);
            $att = [];
            foreach ($attachments as $attachment){
                $att[$attachment['type']][] = $attachment['link'];
            }

            $data['reviews'][] = array(
                'review_id' => $result['review_id'],
                'author' => $result['author'],
                'text' => nl2br($result['text']),
                'rating' => (int) $result['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'video' => $att['video'][0],
                'video_code' => $this->getYoutubeVideoId($att['video'][0]),
                'images' => $att['image'],
            );
        }




        $pagination = new Pagination();
        $pagination->total = $review_total;
        $pagination->page = $page;
        $pagination->limit = 5;
        $pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));


        if(!$this->customer->isLogged()){
            $data['oct_text_no_reviews_no_auth'] = $this->language->get('oct_text_no_reviews_no_auth');
        }


        $html_review = $this->load->view('product/review', $data);
        $this->response->setOutput($html_review);
        return $html_review;
    }

    public function write()
    {
        $this->load->language('product/product');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'][] = $this->language->get('error_name');
            }

            if ((utf8_strlen($this->request->post['text']) < 5) || (utf8_strlen($this->request->post['text']) > 1000)) {
                $json['error'][] = $this->language->get('error_text');
            }

            if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
                $json['error'][] = $this->language->get('error_rating');
            }

            // Captcha
            if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('review', (array) $this->config->get('config_captcha_page'))) {
                $captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

                if ($captcha) {
                    $json['error'] = $captcha;
                }
            }


            if(isset($this->request->post['review_video']) && strlen($this->request->post['review_video']) > 0){
                if(!$this->isYoutubeLink($this->request->post['review_video'])){
                    $json['error'] = "Хибний формат посилання";
                }
            }


            if (!isset($json['error'])) {
                $this->load->model('catalog/review');

                $json['review_id'] = $review_id = $this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);


                // Додавання відео
                $this->model_catalog_review->set_review_attachment(
                    $json['review_id'],
                    "video",
                    $this->request->post['review_video']
                );

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getRecurringDescription()
    {
        $this->load->language('product/product');
        $this->load->model('catalog/product');

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        if (isset($this->request->post['recurring_id'])) {
            $recurring_id = $this->request->post['recurring_id'];
        } else {
            $recurring_id = 0;
        }

        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        $product_info = $this->model_catalog_product->getProduct($product_id);

        $recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

        $json = array();

        if ($product_info && $recurring_info) {
            if (!$json) {
                $frequencies = array(
                    'day' => $this->language->get('text_day'),
                    'week' => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month' => $this->language->get('text_month'),
                    'year' => $this->language->get('text_year'),
                );

                if ($recurring_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }

                $price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

                if ($recurring_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                }

                $json['success'] = $text;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addphotostoreview(){
        $this->load->model('catalog/product');
        $this->load->model('catalog/review');


        if(isset($this->request->get['review_id'])){
            if($this->request->get['review_id'] > 0){
                $review_id = $this->request->get['review_id'];
                $review = $this->model_catalog_review->getReviewById($review_id);
                if($review['review_id'] > 0){
                    $startDate = new DateTime($review['date_added']);
                    $currentDate = new DateTime();
                    $diffInSeconds = $currentDate->getTimestamp() - $startDate->getTimestamp();
                    if($diffInSeconds < 15){

                        if (isset($this->request->files['review_photos']) && is_array($this->request->files['review_photos']['name'])) {
                            $counter = 0;
                            foreach ($this->request->files['review_photos']['name'] as $key => $value) {

                                $counter++;

                                if($counter > 20){
                                    continue;
                                }

                                // Перевірка, чи є файл завантаженим
                                if (is_uploaded_file($this->request->files['review_photos']['tmp_name'][$key])) {

                                    // Встановлюємо обмеження на розмір файлу (наприклад, 5MB)
                                    if ($this->request->files['review_photos']['size'][$key] > 5 * 1024 * 1024) {
                                        continue; // Пропускаємо файли, що перевищують розмір
                                    }

                                    // Використовуємо finfo для перевірки MIME-типу файлу
                                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                    $mime_type = finfo_file($finfo, $this->request->files['review_photos']['tmp_name'][$key]);
                                    finfo_close($finfo);

                                    // Дозволені MIME-типи
                                    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
                                    if (!in_array($mime_type, $allowed_mime_types)) {
                                        continue; // Пропускаємо недопустимі MIME-типи
                                    }

                                    // Генеруємо безпечне ім'я файлу
                                    $new_filename = hash('sha256', uniqid(rand(), true)) . '.' . pathinfo($this->request->files['review_photos']['name'][$key], PATHINFO_EXTENSION);

                                    // Зберігаємо файл у визначену директорію
                                    move_uploaded_file($this->request->files['review_photos']['tmp_name'][$key], DIR_IMAGE . 'catalog/review/' . $new_filename);

                                    // Додаємо запис у таблицю oc_review_attachment
                                    $this->model_catalog_review->set_review_attachment($review_id, 'image', 'catalog/review/' . $new_filename);
                                }
                            }
                        }

                    }else{
                        echo 'time end';
                    }
                }
            }
        }

    }

    function isYoutubeLink($url) {
        // Регулярний вираз для перевірки YouTube посилання
        $pattern = '/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|.+\?v=)?([^&\n]+)/';
        return preg_match($pattern, $url);
    }

    function getYoutubeVideoId($url) {
        preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/", $url, $matches);
        return $matches[1];
    }

    public function getCartQuantity() {
        // Завантажуємо модель для кошика
        $this->load->model('checkout/cart');
        // Отримуємо кількість товарів у кошику
        echo $cart_quantity = $this->cart->countProducts();
    }
}