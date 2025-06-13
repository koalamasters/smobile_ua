<?php
class ControllerProductProduct extends Controller
{
    private $error = array();

    public function index()	{

			if ($this->registry->has('oct_mobiledetect')) {
		        if ($this->oct_mobiledetect->isMobile() && !$this->oct_mobiledetect->isTablet()) {
		            $data['oct_isMobile'] = $this->oct_mobiledetect->isMobile();
		        }

		        if ($this->oct_mobiledetect->isTablet()) {
		            $data['oct_isTablet'] = $this->oct_mobiledetect->isTablet();
		        }
		    }
			

            $data['oct_lazyload'] = false;

            $this->load->model('tool/image');

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
			

			$this->document->addScript ('catalog/view/javascript/jquery/jquery-ui/jquery-ui.min.js');
			$this->document->addScript ('catalog/view/javascript/jquery/jquery-ui/jquery.ui.touch-punch.min.js');
			$this->document->addStyle ('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			$this->document->addScript ('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			
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

				$this->load->language('extension/module/preorder');
				
				if ($this->config->get('module_preorder_phone_mask')) {
					$this->document->addScript('catalog/view/javascript/preorder/inputmask/jquery.inputmask.bundle.min.js');
				}
				
				$this->document->addScript('catalog/view/javascript/preorder/preorder.js');
				$this->document->addStyle('catalog/view/javascript/preorder/preorder.css');
				$preorder_language_id = $this->config->get('config_language_id');
				
				$preorder_button = $this->config->get('module_preorder_button');
				
				if ($preorder_button['module']['preorder']['view'] == 2) {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['module']['preorder']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['module']['preorder']['view'] == 1) {
					$preorder_button_preorder_view['text'] = $preorder_button['module']['preorder']['text'][$preorder_language_id];
				} else {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i>';
					$preorder_button_preorder_view['tooltip'] = $preorder_button['module']['preorder']['text'][$preorder_language_id];
				}
				
				if ($preorder_button['module']['out_sale']['view'] == 2) {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['module']['out_sale']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['module']['out_sale']['view'] == 1) {
					$preorder_button_out_sale_view['text'] = $preorder_button['module']['out_sale']['text'][$preorder_language_id];
				} else {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i>';
					$preorder_button_out_sale_view['tooltip'] = $preorder_button['module']['out_sale']['text'][$preorder_language_id];
				}
			
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

        
                $is_kjajax = isset($this->request->get['kjajax']);
                if ($product_info) {

				$data['ex_pak_status'] = $this->config->get('module_ex_pak_status');
				$data['ex_pak_style'] = $this->config->get('module_ex_pak_style');
				$data['ex_pak_btn_color'] = isset($data['ex_pak_style']['btn_color']) ? $data['ex_pak_style']['btn_color'] : null;
				$data['ex_pak_btn_color_hover'] = isset($data['ex_pak_style']['btn_color_hover']) ? $data['ex_pak_style']['btn_color_hover'] : null;
				if ($data['ex_pak_status']) {
					$ocex_css_js_version = 1;
					$this->load->model('extension/module/ex_pak');
					$data['ex_pak_setting'] = $this->model_extension_module_ex_pak->getSetting();
     				$this->document->addScript('catalog/view/javascript/ex_pak/swiper/swiper-bundle.min.js'); //?version=' . $ocex_css_js_version);
     				$this->document->addStyle('catalog/view/javascript/ex_pak/swiper/swiper-bundle.min.css'); //?version=' . $ocex_css_js_version);
					$this->document->addScript('catalog/view/javascript/ex_pak/ex_pak.js'); //?version=' . $ocex_css_js_version);
					$this->document->addStyle('catalog/view/javascript/ex_pak/ex_pak.css'); //?version=' . $ocex_css_js_version);
				}
			

			$data['oct_product_stickers'] = [];
			$data['you_save'] = $product_info['you_save'];
			$data['you_save_price'] = $this->currency->format($this->tax->calculate($product_info['you_save_price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

			if ($this->config->get('oct_stickers_status')) {
				$oct_stickers = $this->config->get('oct_stickers_data');

				$data['oct_sticker_you_save'] = false;

				if ($oct_stickers) {
					$data['oct_sticker_you_save'] = isset($oct_stickers['stickers']['special']['persent']) ? true : false;
				}

				$this->load->model('octemplates/stickers/oct_stickers');

				$oct_stickers_data = $this->model_octemplates_stickers_oct_stickers->getOCTStickers($product_info);

				if ($oct_stickers_data) {
					$data['oct_product_stickers'] = $oct_stickers_data['stickers'];
				}
			}
			
                $data['hpmrr'] = $this->load->controller('extension/module/hpmrr/getFormForList', ['products' => [$product_info], 'is_cat' => 0]);
                
				
			$this->load->model('module/ukrcredits');
			$data['ukrcredits_stickers'] = $this->model_module_ukrcredits->checkproduct($product_info);
			
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

            
			//$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			
            $this->document->addScript('catalog/view/theme/journal3/lib/swiper/swiper.min.js');
            
			//$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			
            
			//$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
			
            
			//$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
			
            
			//$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			
            
			//$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
			

            $data['heading_title'] = $product_info['name'];


			if ($this->config->get('theme_oct_showcase_seo_title_status')) {
				$oct_seo_title_data = $this->config->get('theme_oct_showcase_seo_title_data');

				$oct_price = ($this->customer->isLogged() || !$this->config->get('config_customer_price')) ? $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : '';
				$oct_special = ((float)$product_info['special']) ? $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : '';

				if ((isset($oct_seo_title_data['product']['title_status']) && $oct_seo_title_data['product']['title_status']) && (isset($oct_seo_title_data['product']['title'][$this->config->get('config_language_id')]) && !empty($oct_seo_title_data['product']['title'][$this->config->get('config_language_id')]))) {
					$oct_address = (isset($oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_address'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) : '';
					$oct_phone = (isset($oct_showcase_data['contact_telephone']) && !empty($oct_showcase_data['contact_telephone'])) ? str_replace(PHP_EOL, ', ',  $oct_showcase_data['contact_telephone']) : '';
					$oct_time = (isset($oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_open'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) : '';

					$oct_replace = [
						'[name]' => strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')),
						'[price]' => $oct_price ? $oct_special ? strip_tags($oct_special) : strip_tags($oct_price) : '',
						'[model]' => !empty($product_info['model']) ? strip_tags(html_entity_decode($product_info['model'], ENT_QUOTES, 'UTF-8')) : '',
						'[sku]' => !empty($product_info['sku']) ? strip_tags(html_entity_decode($product_info['sku'], ENT_QUOTES, 'UTF-8')) : '',
						'[category]' => (isset($category_info) && $category_info) ? strip_tags(html_entity_decode($category_info['name'], ENT_QUOTES, 'UTF-8')) : '',
						'[manufacturer]' => !empty($product_info['manufacturer']) ? strip_tags(html_entity_decode($product_info['manufacturer'], ENT_QUOTES, 'UTF-8')) : '',
						'[address]' => $oct_address,
						'[phone]' => $oct_phone,
						'[time]' => $oct_time,
						'[store]' => $this->config->get('config_name')
					];

					$oct_seo_title = str_replace(array_keys($oct_replace), array_values($oct_replace), $oct_seo_title_data['product']['title'][$this->config->get('config_language_id')]);

					if ((isset($oct_seo_title_data['product']['title_empty']) && $oct_seo_title_data['product']['title_empty']) && empty($product_info['meta_title'])) {
						$og_seo_title = true;

						$this->document->setTitle(htmlspecialchars($oct_seo_title));
					} elseif (!isset($oct_seo_title_data['product']['title_empty'])) {
						$og_seo_title = true;

						$this->document->setTitle(htmlspecialchars($oct_seo_title));
					}
				}

				if ((isset($oct_seo_title_data['product']['description_status']) && $oct_seo_title_data['product']['description_status']) && (isset($oct_seo_title_data['product']['description'][$this->config->get('config_language_id')]) && !empty($oct_seo_title_data['product']['description'][$this->config->get('config_language_id')]))) {
					$oct_address = (isset($oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_address'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) : '';
					$oct_phone = (isset($oct_showcase_data['contact_telephone']) && !empty($oct_showcase_data['contact_telephone'])) ? str_replace(PHP_EOL, ', ',  $oct_showcase_data['contact_telephone']) : '';
					$oct_time = (isset($oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_open'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) : '';

					$oct_replace = [
						'[name]' => strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')),
						'[price]' => $oct_price ? $oct_special ? strip_tags($oct_special) : strip_tags($oct_price) : '',
						'[model]' => !empty($product_info['model']) ? strip_tags(html_entity_decode($product_info['model'], ENT_QUOTES, 'UTF-8')) : '',
						'[sku]' => !empty($product_info['sku']) ? strip_tags(html_entity_decode($product_info['sku'], ENT_QUOTES, 'UTF-8')) : '',
						'[category]' => (isset($category_info) && $category_info) ? strip_tags(html_entity_decode($category_info['name'], ENT_QUOTES, 'UTF-8')) : '',
						'[manufacturer]' => !empty($product_info['manufacturer']) ? strip_tags(html_entity_decode($product_info['manufacturer'], ENT_QUOTES, 'UTF-8')) : '',
						'[address]' => $oct_address,
						'[phone]' => $oct_phone,
						'[time]' => $oct_time,
						'[store]' => $this->config->get('config_name')
					];

					$oct_seo_description = str_replace(array_keys($oct_replace), array_values($oct_replace), $oct_seo_title_data['product']['description'][$this->config->get('config_language_id')]);

					if ((isset($oct_seo_title_data['product']['description_empty']) && $oct_seo_title_data['product']['description_empty']) && empty($product_info['meta_description'])) {
						$og_seo_description = true;
						$this->document->setDescription(htmlspecialchars($oct_seo_description));
					} elseif (!isset($oct_seo_title_data['product']['description_empty'])) {
						$og_seo_description = true;
						$this->document->setDescription(htmlspecialchars($oct_seo_description));
					}
				}
			}
			
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

			if (isset($oct_showcase_data['preload_images']) && $oct_showcase_data['preload_images'] && $product_info['image'] && is_file(DIR_IMAGE . $product_info['image'])) {
				$this->document->setOCTPreload($this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height')));
			}
			if (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')) {
				$data['max_quantity'] = $product_info['quantity'];
			}
			

            
			$data['text_oct_popup_found_cheaper'] = $this->language->get('oct_product_cheaper');
       		$data['out_of_stock'] = false;


				$data['preorder'] = array();
				
				if ($preorder_button['product']['preorder']['view'] == 2) {
					$preorder_button_preorder_view_product['text'] = '<i class="fa fa-bell"></i> ' . $preorder_button['product']['preorder']['text'][$preorder_language_id];
				} elseif ($preorder_button['product']['preorder']['view'] == 1) {
					$preorder_button_preorder_view_product['text'] = $preorder_button['product']['preorder']['text'][$preorder_language_id];
				} else {
					$preorder_button_preorder_view_product['text'] = '<i class="fa fa-bell"></i>';
					$preorder_button_preorder_view_product['tooltip'] = $preorder_button['product']['preorder']['text'][$preorder_language_id];
				}
				
				if ($preorder_button['product']['out_sale']['view'] == 2) {
					$preorder_button_out_sale_view_product['text'] = '<i class="fa fa-ban"></i> ' . $preorder_button['product']['out_sale']['text'][$preorder_language_id];
				} elseif ($preorder_button['product']['out_sale']['view'] == 1) {
					$preorder_button_out_sale_view_product['text'] = $preorder_button['product']['out_sale']['text'][$preorder_language_id];
				} else {
					$preorder_button_out_sale_view_product['text'] = '<i class="fa fa-ban"></i>';
					$preorder_button_out_sale_view_product['tooltip'] = $preorder_button['product']['out_sale']['text'][$preorder_language_id];
				}
				
				if ($this->config->get('module_preorder_stock_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_stock_statuses'))) {
					$data['preorder']['stock_status'] = 2;
					$data['preorder']['view'] = $preorder_button_preorder_view_product;
					$data['preorder']['class'] = $preorder_button['product']['preorder']['class'];
				} elseif ($this->config->get('module_preorder_out_sale_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
					$data['preorder']['stock_status'] = 1;
					$data['preorder']['view'] = $preorder_button_out_sale_view_product;
					$data['preorder']['class'] = $preorder_button['product']['out_sale']['class'];
				} else {
					$data['preorder']['stock_status'] = 0;
					$data['preorder']['view'] = '';
					$data['preorder']['class'] = '';
				}
				
				$data['preorder']['outstock'] = $product_info['stock_status'];
				$data['preorder']['quantity'] = $product_info['quantity'];
			
			if ($product_info['quantity'] <= 0) {
				$data['out_of_stock'] = true;
			
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
                
			$data['popup'] = $this->model_tool_image->resize('no-thumb.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			
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
                
			$data['thumb'] = $this->model_tool_image->resize('no-thumb.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
			
            }


			$data['popup_width'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width');
			$data['popup_height'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height');
			$data['thumb_width'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width');
			$data['thumb_height'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height');
			
            $data['images'] = array();

            $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);

			if ($data['popup'] && $data['thumb'] && !empty($results)) {
				$data['images'][0] = array(
					'popup' => $data['thumb'],
					'popup_fancy' => $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height')),
					'images_width' => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'),
					'images_height' => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'),
				);
			}
			

            foreach ($results as $result) {

                $img = '';
                if( $use_avif){
                    $img =  $this->model_tool_image->getAvif($result['image']);
                }else{
                    $img = '/image/'.$result['image'];
                }


                $data['images'][] = array(
                   // 
			'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height')),
			'popup_fancy' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
			'images_width' => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'),
			'images_height' => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'),
			
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



				$data['preorder'] = array();
				
				if ($preorder_button['product']['preorder']['view'] == 2) {
					$preorder_button_preorder_view_product['text'] = '<i class="fa fa-bell"></i> ' . $preorder_button['product']['preorder']['text'][$preorder_language_id];
				} elseif ($preorder_button['product']['preorder']['view'] == 1) {
					$preorder_button_preorder_view_product['text'] = $preorder_button['product']['preorder']['text'][$preorder_language_id];
				} else {
					$preorder_button_preorder_view_product['text'] = '<i class="fa fa-bell"></i>';
					$preorder_button_preorder_view_product['tooltip'] = $preorder_button['product']['preorder']['text'][$preorder_language_id];
				}
				
				if ($preorder_button['product']['out_sale']['view'] == 2) {
					$preorder_button_out_sale_view_product['text'] = '<i class="fa fa-ban"></i> ' . $preorder_button['product']['out_sale']['text'][$preorder_language_id];
				} elseif ($preorder_button['product']['out_sale']['view'] == 1) {
					$preorder_button_out_sale_view_product['text'] = $preorder_button['product']['out_sale']['text'][$preorder_language_id];
				} else {
					$preorder_button_out_sale_view_product['text'] = '<i class="fa fa-ban"></i>';
					$preorder_button_out_sale_view_product['tooltip'] = $preorder_button['product']['out_sale']['text'][$preorder_language_id];
				}
				
				if ($this->config->get('module_preorder_stock_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_stock_statuses'))) {
					$data['preorder']['stock_status'] = 2;
					$data['preorder']['view'] = $preorder_button_preorder_view_product;
					$data['preorder']['class'] = $preorder_button['product']['preorder']['class'];
				} elseif ($this->config->get('module_preorder_out_sale_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
					$data['preorder']['stock_status'] = 1;
					$data['preorder']['view'] = $preorder_button_out_sale_view_product;
					$data['preorder']['class'] = $preorder_button['product']['out_sale']['class'];
				} else {
					$data['preorder']['stock_status'] = 0;
					$data['preorder']['view'] = '';
					$data['preorder']['class'] = '';
				}
				
				$data['preorder']['outstock'] = $product_info['stock_status'];
				$data['preorder']['quantity'] = $product_info['quantity'];
			
			if ($product_info['quantity'] <= 0) {
				$data['is_stock'] = $product_info['stock_status'];
			} else {
				$data['is_stock'] = false;
			}

			$data['can_buy'] = true;

			if ($product_info['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
				$data['can_buy'] = false;
			} elseif ($product_info['quantity'] <= 0 && $this->config->get('config_stock_checkout')) {
				$data['can_buy'] = true;
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
                    if (true ||  ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float) $option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                        } else {
                            $price = false;
                        }

                        $product_option_value_data[] = array(

				'preorder_quantity' => $option_value['quantity'],
			
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

			$data['oct_reviews_list'] = $data['review_status'] ? $this->review() : '';
			

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



			$this->document->addScript('catalog/view/theme/oct_showcase/js/slick/slick.min.js');
			$this->document->addStyle('catalog/view/theme/oct_showcase/js/slick/slick.min.css');

			$this->document->addScript('catalog/view/theme/oct_showcase/js/fancybox/jquery.fancybox.min.js');
			$this->document->addStyle('catalog/view/theme/oct_showcase/js/fancybox/jquery.fancybox.min.css');

			if (isset($oct_showcase_data['product_zoom']) && $oct_showcase_data['product_zoom']) {
	            $this->document->addScript('catalog/view/theme/oct_showcase/js/zoom/jquery.zoom.js');
        	}

        	$data['sku'] = $product_info['sku'];
			$data['upc'] = $product_info['upc'];
			$data['ean'] = $product_info['ean'];
			$data['mpn'] = $product_info['mpn'];

			$data['total_reviews'] = (int)$product_info['reviews'];

			$oct_review = $this->model_catalog_review->getOCTReviewsByProductId($product_id);

			$data['oct_rating'] = isset($oct_review['sum']) ? round((float)$oct_review['sum'] / $data['total_reviews'], 1) : 0;

			$data['oct_raiting_stats'][5] = [
				'raiting' => isset($oct_review['rating'][5]) ? round(count($oct_review['rating'][5])/$data['total_reviews']*100) : 0,
				'sum' => isset($oct_review['rating'][5]) ? (int)count($oct_review['rating'][5]) : 0
			];

			$data['oct_raiting_stats'][4] = [
				'raiting' => isset($oct_review['rating'][4]) ? round(count($oct_review['rating'][4])/$data['total_reviews']*100) : 0,
				'sum' => isset($oct_review['rating'][4]) ? (int)count($oct_review['rating'][4]) : 0
			];

			$data['oct_raiting_stats'][3] = [
				'raiting' => isset($oct_review['rating'][3]) ? round(count($oct_review['rating'][3])/$data['total_reviews']*100) : 0,
				'sum' => isset($oct_review['rating'][3]) ? (int)count($oct_review['rating'][3]) : 0
			];

			$data['oct_raiting_stats'][2] = [
				'raiting' => isset($oct_review['rating'][2]) ? round(count($oct_review['rating'][2])/$data['total_reviews']*100) : 0,
				'sum' => isset($oct_review['rating'][2]) ? (int)count($oct_review['rating'][2]) : 0
			];

			$data['oct_raiting_stats'][1] = [
				'raiting' => isset($oct_review['rating'][1]) ? round(count($oct_review['rating'][1])/$data['total_reviews']*100) : 0,
				'sum' => isset($oct_review['rating'][1]) ? (int)count($oct_review['rating'][1]) : 0
			];
			
            $data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

				
			$this->load->model('module/ukrcredits');
			
            $data['products'] = array();

			$data['oct_popup_view_status'] = $this->config->get('oct_popup_view_status');
			

            $results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);

			$oct_product_stickers = [];

			if ($this->config->get('oct_stickers_status')) {
				$oct_stickers = $this->config->get('oct_stickers_data');

				$data['oct_sticker_you_save'] = false;

				if ($oct_stickers) {
					$data['oct_sticker_you_save'] = isset($oct_stickers['stickers']['special']['persent']) ? true : false;
				}

				$this->load->model('octemplates/stickers/oct_stickers');
			}
			

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

				
				$ukrcredits_stickers = $this->model_module_ukrcredits->checkproduct($result);
			

			if (isset($oct_stickers) && $oct_stickers) {
				$oct_stickers_data = $this->model_octemplates_stickers_oct_stickers->getOCTStickers($result);

				$oct_product_stickers = [];

				if (isset($oct_stickers_data) && $oct_stickers_data) {
					$oct_product_stickers = $oct_stickers_data['stickers'];
				}
			}
			

			if ($result['quantity'] <= 0) {
				$stock = $result['stock_status'];
			} else {
				$stock = false;
			}

			$can_buy = true;

			if ($result['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
				$can_buy = false;
			} elseif ($result['quantity'] <= 0 && $this->config->get('config_stock_checkout')) {
				$can_buy = true;
			}

			$oct_grayscale = ($this->config->get('theme_oct_showcase_no_quantity_grayscale') && !$can_buy) ? true : false;
			

				$preorder_info = array();
			
				if ($this->config->get('module_preorder_stock_statuses') && in_array($result['stock_status_id'], $this->config->get('module_preorder_stock_statuses'))) {
					$preorder_stock_status = 2;
					$preorder_view = $preorder_button_preorder_view;
					$preorder_class = $preorder_button['module']['preorder']['class'];
				} elseif ($this->config->get('module_preorder_out_sale_statuses') && in_array($result['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
					$preorder_stock_status = 1;
					$preorder_view = $preorder_button_out_sale_view;
					$preorder_class = $preorder_button['module']['out_sale']['class'];
				} else {
					$preorder_stock_status = 0;
					$preorder_view = '';
					$preorder_class = '';
				}
				
				$preorder_info = array(
					'stock_status' => $preorder_stock_status,
					'quantity'     => $result['quantity'],
					'view'         => $preorder_view,
					'class'        => $preorder_class,
				);
			
                $data['products'][] = array(

				'preorder' => $preorder_info,
			
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
'ukrcredits_stickers' => isset($ukrcredits_stickers)?$ukrcredits_stickers:array(),
                    'name' => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price' => $price,
                    'special'     => $special,

			'stock'     => $stock,
			'can_buy'   => $can_buy,
			'oct_grayscale'  => $oct_grayscale,
			
                    'tax' => $tax,
                    'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating' => $rating,

			'reviews'	  => $result['reviews'],
			'oct_model'	  => $this->config->get('theme_oct_showcase_data_model') ? $result['model'] : '',
			'quantity'	  => $result['quantity'] <= 0 ? true : false,
			'width'		  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'),
			'height'	  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'),
			
                    'usdt_price' => $usdt_price,
                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                );
            }


            $data['products'] = $this->load->controller('octemplates/module/oct_products_modules', $data);
			
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


            if (isset($oct_showcase_data['open_graph']) && $oct_showcase_data['open_graph']) {
                $site_link = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

				$config_logo = file_exists(DIR_IMAGE . $this->config->get('config_logo')) ? $this->config->get('config_logo') : 'catalog/opencart-logo.png';

                $oct_ogimage = $product_info['image'] ? $product_info['image'] : $config_logo;
                $product_image = $site_link . 'image/' . $oct_ogimage;

				$image_info = getimagesize(DIR_IMAGE . $oct_ogimage);

				if ($image_info) {
					$image_width  = $image_info[0];
					$image_height = $image_info[1];
				} else {
					$image_width  = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_width') ? $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_width') : 140;
					$image_height = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_height') ? $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_height') : 65;
				}

				$mime_type = isset($image_info['mime']) ? $image_info['mime'] : 'image/svg+xml';

                $this->document->setOCTOpenGraph('og:title', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", (isset($oct_seo_title) && $oct_seo_title) ? $oct_seo_title : $product_info['meta_title'])))))));
                $this->document->setOCTOpenGraph('og:description', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", (isset($oct_seo_description) && $oct_seo_description && empty($product_info['meta_description'])) ? $oct_seo_description : $product_info['meta_description'])))))));
                $this->document->setOCTOpenGraph('og:site_name', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", $this->config->get('config_name'))))))));
                $this->document->setOCTOpenGraph('og:url', $this->url->link('product/product', 'product_id=' . $product_info['product_id']));
                $this->document->setOCTOpenGraph('og:image', str_replace(" ", "%20", $product_image));

				if (isset($mime_type) && $mime_type) {
                	$this->document->setOCTOpenGraph('og:image:type', $mime_type);
				}

				if (isset($image_width) && $image_width) {
                	$this->document->setOCTOpenGraph('og:image:width', $image_width);
				}

				if (isset($image_height) && $image_height) {
					$this->document->setOCTOpenGraph('og:image:height', $image_height);
				}

                $this->document->setOCTOpenGraph('og:image:alt', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", $data['heading_title'])))))));
                $this->document->setOCTOpenGraph('og:type', 'product');
            }
			

	    // remarketing all in one
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			if (empty($category_info)) $category_info = []; 
			$data = array_merge($data, $this->model_tool_remarketing->processProduct($product_info, $category_info));
		}   
	  
            $this->model_catalog_product->updateViewed($this->request->get['product_id']);

                    if($this->FTMaster && !empty($product_info)) {
                        $this->DataLayer->set_data('product_details', $this->DataLayer->format_product_details($product_info));
                        $this->DataLayer->add_data('products_listed', $this->DataLayer->format_products_listed($results, $data['products'], "product: ".$data['heading_title'].' - Related products'));
                    }
                


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


      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductItemControllerData($data);
      }
      // OCFilter End
      

                 $data['module_mono_checkout_cart_show'] = $this->config->get('module_mono_checkout_cart_show') ? $this->config->get('module_mono_checkout_cart_show') : false;
                  $data['mono_checkout_button'] = $this->config->get('module_mono_checkout_product_show') ?  str_replace("\n", '', $this->load->controller('extension/module/mono_checkout/getButton', 'product_page')) : false;
                  $data['module_mono_checkout_product_elem'] = $this->config->get('module_mono_checkout_product_elem') ? $this->config->get('module_mono_checkout_product_elem') : '#button-cart';
                
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');

	if (version_compare(VERSION,'3.0','>=')) {
		if ($this->config->get('payment_ukrcredits_status')) {
			$data['ukrcredits_status'] = true;
			$data['ukrcredits'] = str_replace("\n", '', $this->load->controller('module/ukrcredits'));
			$data['ukrcredits_selector_button'] = strip_tags(html_entity_decode($this->config->get('payment_ukrcredits_settings')['selector_button'],ENT_QUOTES,'UTF-8'));
			$data['ukrcredits_selector_block'] = $this->config->get('payment_ukrcredits_settings')['selector_block'];
			$data['ukrcredits_css_custom'] = $this->config->get('payment_ukrcredits_settings')['css_custom'];
		} else {
			$data['ukrcredits_status'] = false;
		}
	} else {
		if ($this->config->get('ukrcredits_status')) {
			$data['ukrcredits_status'] = true;
			$data['ukrcredits'] = str_replace("\n", '', $this->load->controller('module/ukrcredits'));
			$data['ukrcredits_selector_button'] = strip_tags(html_entity_decode($this->config->get('ukrcredits_settings')['selector_button'],ENT_QUOTES,'UTF-8'));
			$data['ukrcredits_selector_block'] = $this->config->get('ukrcredits_settings')['selector_block'];
			$data['ukrcredits_css_custom'] = $this->config->get('ukrcredits_settings')['css_custom'];
		} else {
			$data['ukrcredits_status'] = false;
		}	
	}
			
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


      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductItemControllerData($data);
      }
      // OCFilter End
      
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');

	if (version_compare(VERSION,'3.0','>=')) {
		if ($this->config->get('payment_ukrcredits_status')) {
			$data['ukrcredits_status'] = true;
			$data['ukrcredits'] = str_replace("\n", '', $this->load->controller('module/ukrcredits'));
			$data['ukrcredits_selector_button'] = strip_tags(html_entity_decode($this->config->get('payment_ukrcredits_settings')['selector_button'],ENT_QUOTES,'UTF-8'));
			$data['ukrcredits_selector_block'] = $this->config->get('payment_ukrcredits_settings')['selector_block'];
			$data['ukrcredits_css_custom'] = $this->config->get('payment_ukrcredits_settings')['css_custom'];
		} else {
			$data['ukrcredits_status'] = false;
		}
	} else {
		if ($this->config->get('ukrcredits_status')) {
			$data['ukrcredits_status'] = true;
			$data['ukrcredits'] = str_replace("\n", '', $this->load->controller('module/ukrcredits'));
			$data['ukrcredits_selector_button'] = strip_tags(html_entity_decode($this->config->get('ukrcredits_settings')['selector_button'],ENT_QUOTES,'UTF-8'));
			$data['ukrcredits_selector_block'] = $this->config->get('ukrcredits_settings')['selector_block'];
			$data['ukrcredits_css_custom'] = $this->config->get('ukrcredits_settings')['css_custom'];
		} else {
			$data['ukrcredits_status'] = false;
		}	
	}
			
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