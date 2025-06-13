<?php
class ControllerProductCategory extends Controller
{
    public function index() {

			$data['oct_showcase_data'] = $oct_showcase_data = $this->config->get('theme_oct_showcase_data');

			if (isset($oct_showcase_data['category_view_sort_oder']) && $oct_showcase_data['category_view_sort_oder']) {
				$oct_showcase_sort_data = $this->config->get('theme_oct_showcase_sort_data');

				if (isset($oct_showcase_sort_data['deff_sort']) && $oct_showcase_sort_data['deff_sort']) {
					$sort_order = explode('-', $oct_showcase_sort_data['deff_sort']);
				}
			}

			$ikey = 1;
			

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
			

        $use_avif = true;

        $this->load->language('product/category');

        $this->load->model('catalog/category');


				$this->load->language('extension/module/preorder');
				
				if ($this->config->get('module_preorder_phone_mask')) {
					$this->document->addScript('catalog/view/javascript/preorder/inputmask/jquery.inputmask.bundle.min.js');
				}
				
				$this->document->addScript('catalog/view/javascript/preorder/preorder.js');
				$this->document->addStyle('catalog/view/javascript/preorder/preorder.css');
				$preorder_language_id = $this->config->get('config_language_id');
				
				$preorder_button = $this->config->get('module_preorder_button');
				
				if ($preorder_button['catalog']['preorder']['view'] == 2) {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['catalog']['preorder']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['catalog']['preorder']['view'] == 1) {
					$preorder_button_preorder_view['text'] = $preorder_button['catalog']['preorder']['text'][$preorder_language_id];
				} else {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i>';
					$preorder_button_preorder_view['tooltip'] = $preorder_button['catalog']['preorder']['text'][$preorder_language_id];
				}
				
				if ($preorder_button['catalog']['out_sale']['view'] == 2) {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['catalog']['out_sale']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['catalog']['out_sale']['view'] == 1) {
					$preorder_button_out_sale_view['text'] = $preorder_button['catalog']['out_sale']['text'][$preorder_language_id];
				} else {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i>';
					$preorder_button_out_sale_view['tooltip'] = $preorder_button['catalog']['out_sale']['text'][$preorder_language_id];
				}
			
        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $this->document->addScript('catalog/view/theme/oct_showcase/js/slick/slick.min.js');
        $this->document->addStyle('catalog/view/theme/oct_showcase/js/slick/slick.min.css');

        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            
			$sort = (isset($sort_order) && !empty($sort_order) && isset($sort_order[0])) ? $sort_order[0] : 'p.sort_order';
			
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            
			$order = (isset($sort_order) && !empty($sort_order) && isset($sort_order[1])) ? $sort_order[1] : 'ASC';
			
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int) $this->request->get['limit'];
        } else {
            $limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['path'])) {
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $path = '';

            $parts = explode('_', (string) $this->request->get['path']);

            $category_id = (int) array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int) $path_id;
                } else {
                    $path .= '_' . (int) $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path . $url)
                    );
                }
            }
        } else {
            $category_id = 0;
        }

        $category_info = $this->model_catalog_category->getCategory($category_id);

        $this->document->setRobots('index, follow');


        if ($category_info) {


            if ($this->config->get('config_language_id') == 3) {
                $this->document->setTitle('Купити ' . $category_info['meta_title'] . ' по вигідній ціні в інтернет-магазині Smobile');
                $this->document->setDescription('Замовляйте онлайн ' . $category_info['meta_description'] . ' в інтернет-магазині Smobile ✔ Низькі ціни ✔ Доставка по всій території України ✔ Повернення та обмін ☎️ +380678088989 | Smobile');
            } else {
                $this->document->setTitle('Купить ' . $category_info['meta_title'] . ' по выгодной цене в интернет-магазине Smobile');
                $this->document->setDescription('Заказывайте онлайн ' . $category_info['meta_description'] . ' в интернет-магазине Smobile ✔ Низкие цены ✔ Доставка по всей территории Украины ✔ Возврат и обмен ☎️ +380678088989 | Smobile');
            }

            // $this->document->setTitle($category_info['meta_title']);
            // $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);

            $data['heading_title'] = $category_info['name'];


			if ($this->config->get('theme_oct_showcase_seo_title_status')) {
				$oct_seo_title_data = $this->config->get('theme_oct_showcase_seo_title_data');

				if ((isset($oct_seo_title_data['category']['title_status']) && $oct_seo_title_data['category']['title_status']) && (isset($oct_seo_title_data['category']['title'][$this->config->get('config_language_id')]) && !empty($oct_seo_title_data['category']['title'][$this->config->get('config_language_id')]))) {
					$oct_address = (isset($oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_address'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) : '';
					$oct_phone = (isset($oct_showcase_data['contact_telephone']) && !empty($oct_showcase_data['contact_telephone'])) ? str_replace(PHP_EOL, ', ',  $oct_showcase_data['contact_telephone']) : '';
					$oct_time = (isset($oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_open'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) : '';

					$oct_replace = [
						'[name]' => strip_tags(html_entity_decode($category_info['name'], ENT_QUOTES, 'UTF-8')),
						'[address]' => $oct_address,
						'[phone]' => $oct_phone,
						'[time]' => $oct_time,
						'[store]' => $this->config->get('config_name')
					];

					$oct_seo_title = str_replace(array_keys($oct_replace), array_values($oct_replace), $oct_seo_title_data['category']['title'][$this->config->get('config_language_id')]);

					if ((isset($oct_seo_title_data['category']['title_empty']) && $oct_seo_title_data['category']['title_empty']) && empty($category_info['meta_title'])) {
						$og_seo_title = true;
						$this->document->setTitle(htmlspecialchars($oct_seo_title));
					} elseif (!isset($oct_seo_title_data['category']['title_empty'])) {
						$og_seo_title = true;
						$this->document->setTitle(htmlspecialchars($oct_seo_title));
					}
				}

				if ((isset($oct_seo_title_data['category']['description_status']) && $oct_seo_title_data['category']['description_status']) && (isset($oct_seo_title_data['category']['description'][$this->config->get('config_language_id')]) && !empty($oct_seo_title_data['category']['description'][$this->config->get('config_language_id')]))) {
					$oct_address = (isset($oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_address'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_address'][$this->config->get('config_language_id')]) : '';
					$oct_phone = (isset($oct_showcase_data['contact_telephone']) && !empty($oct_showcase_data['contact_telephone'])) ? str_replace(PHP_EOL, ', ',  $oct_showcase_data['contact_telephone']) : '';
					$oct_time = (isset($oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_open'][$this->config->get('config_language_id')])) ? str_replace(PHP_EOL, ', ', $oct_showcase_data['contact_open'][$this->config->get('config_language_id')]) : '';

					$oct_replace = [
						'[name]' => strip_tags(html_entity_decode($category_info['name'], ENT_QUOTES, 'UTF-8')),
						'[address]' => $oct_address,
						'[phone]' => $oct_phone,
						'[time]' => $oct_time,
						'[store]' => $this->config->get('config_name')
					];

					$oct_seo_description = str_replace(array_keys($oct_replace), array_values($oct_replace), $oct_seo_title_data['category']['description'][$this->config->get('config_language_id')]);

					if ((isset($oct_seo_title_data['category']['description_empty']) && $oct_seo_title_data['category']['description_empty']) && empty($category_info['meta_description'])) {
						$og_seo_description = true;
						$this->document->setDescription(htmlspecialchars($oct_seo_description));
					} elseif (!isset($oct_seo_title_data['category']['description_empty'])) {
						$og_seo_description = true;
						$this->document->setDescription(htmlspecialchars($oct_seo_description));
					}
				}
			}
			
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

            // Set the last category breadcrumb
            $data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
            );

            
			if ($category_info['image'] && (isset($oct_showcase_data['category_cat_image']) && $oct_showcase_data['category_cat_image'])) {
				$data['cat_image_width'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width');
				$data['cat_image_height'] = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height');
			
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
            } else {
                $data['thumb'] = '';
            }

            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');

			if (!isset($oct_showcase_data['category_desc_in_page']) && $page > 1) {
				$data['description'] = false;
				$data['thumb'] = false;
			} else {
				$data['description'] = str_replace("<img", "<img class='img-fluid'", html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8'));
			}

			$data['language_id'] = (int)$this->config->get('config_language_id');
			$data['categories_page'] = (isset($oct_showcase_data['category_page']) && $oct_showcase_data['category_page']) ? unserialize($category_info['page_group_links']) : [];
			
            $data['compare'] = $this->url->link('product/compare');

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['categories'] = array();

			if(isset($oct_showcase_data['category_view_subcats']) && $oct_showcase_data['category_view_subcats'] == 'on'){
			


			if(isset($this->request->server['HTTP_ACCEPT']) && strpos($this->request->server['HTTP_ACCEPT'], 'webp')) {
				$oct_webP = 1 . '-' . $this->session->data['currency'];
			} else {
				$oct_webP = 0 . '-' . $this->session->data['currency'];
			}

			$oct_categories = $this->cache->get('octemplates.sub_categories.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$category_id . '.' . $oct_webP);

			if (!$oct_categories) {
			
            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {

			if ($result['image'] && file_exists(DIR_IMAGE.$result['image'])) {
//				$cat_image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_sub_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_sub_category_height'));
				$cat_image = '/image/'.$result['image'];
			} else {
				$cat_image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_sub_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_sub_category_height'));
			}
			
                $filter_data = array(
                    'filter_category_id' => $result['category_id'],
                    'filter_sub_category' => true
                );

                $data['categories'][] = array(
//					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                    'name' => $result['name'],

			'image'		=> $cat_image,
			'width'		=> $this->config->get('theme_' . $this->config->get('config_theme') . '_image_sub_category_width'),
			'height'	=> $this->config->get('theme_' . $this->config->get('config_theme') . '_image_sub_category_height'),
			
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                );
            }

				$oct_categories = $data['categories'];

				$this->cache->set('octemplates.sub_categories.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$category_id . '.' . $oct_webP, $oct_categories);
			}

			$data['categories'] = $oct_categories;
			

				
			$this->load->model('module/ukrcredits');
			

			}
			
            $data['products'] = array();

	        $oct_showcase_data_atributes = $this->config->get('theme_oct_showcase_data_atributes');
			

			$data['oct_popup_view_status'] = $this->config->get('oct_popup_view_status');
			






            $filter_data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );


            $data['products_count'] = [];


      // OCFilter start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->useSubCategory() && $this->ocfilter->api->isSelected() && empty($filter_data['filter_sub_category'])) {
        $filter_data['filter_sub_category'] = true;
      }
      // OCFilter end
      
            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);
            $product_total_before_filter = $this->model_catalog_product->getActiveProductsCountByCategoryId($category_id);

            $data['products_count']['before_filter'] = $product_total_before_filter;
            $data['products_count']['after_filter'] = $product_total;

            $data['filter_total'] = sprintf($this->language->get('filter_count'), $data['products_count']['after_filter'], $data['products_count']['before_filter']);



            $results = $this->model_catalog_product->getProducts($filter_data);

	  // remarketing all in one  
	      $this->load->model('tool/remarketing');
	      if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot() && !empty($results)) {
		  	  if (empty($data['heading_title'])) $data['heading_title'] = $this->language->get('heading_title'); 
		  	  $data = array_merge($data, $this->model_tool_remarketing->processCategory((!empty($category_info) ? $category_info : []), $data['heading_title'], $results));
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
			
$data['hpmrr'] = $this->load->controller('extension/module/hpmrr/getFormForList', ['products' => $results, 'is_cat' => 1]);

            $counter = 0;
            foreach ($results as $key => $result) {


                if ($result['image']) {
//					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    $image = '/image/'.$result['image'];

                    if( $use_avif){
                        $image = $this->model_tool_image->getAvif($result['image']);
                    }else{
                        $image = '/image/'.$result['image'];
                    }

                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                }


			if (isset($oct_showcase_data['preload_images']) && $oct_showcase_data['preload_images'] && $ikey <= 1) {
				$this->document->setOCTPreload($image);
			}

			$ikey++;
			
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

                $price_for_ads = null;
                if (!$special) {
                    $price_for_ads = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
                } else {
                    $price_for_ads = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
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



                $date_added = strtotime($result['date_added']);
                $current_time = time();
                $difference_seconds = $current_time - $date_added;
                $days_passed = floor($difference_seconds / (60 * 60 * 24));

                $is_new = $this->model_catalog_product->getNewStatus($result['product_id']);

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

                $data['usdt_info'] = $this->language->get('usdt_info');

                $price_for_usdt = 0;

                if($result['special']){
                    $price_for_usdt = explode(' ', $result['special'])[0];
                }else{
                    $price_for_usdt = explode(' ', $result['price'])[0];
                }

                $usdt_price = round($price_for_usdt/$usdt_rate);



                $lastIndex = 0;
				
				$ukrcredits_stickers = $this->model_module_ukrcredits->checkproduct($result);
			

			if (isset($oct_stickers) && $oct_stickers) {
				$oct_stickers_data = $this->model_octemplates_stickers_oct_stickers->getOCTStickers($result);

				$oct_product_stickers = [];

				if (isset($oct_stickers_data) && $oct_stickers_data) {
					$oct_product_stickers = $oct_stickers_data['stickers'];
				}
			}
			

			$oct_atributes = false;

			if (isset($oct_showcase_data_atributes) && $oct_showcase_data_atributes) {
				$limit_attr  = $this->config->get('theme_oct_showcase_data_cat_atr_limit') ? $this->config->get('theme_oct_showcase_data_cat_atr_limit') : 5;

				$oct_atributes = $this->model_catalog_product->getOctProductAttributes(isset($product_info) ? $product_info['product_id'] : $result['product_id'], $limit_attr);
			}
			

			$result = (isset($product_info) && $product_info) ? $product_info : $result;

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
					$preorder_class = $preorder_button['catalog']['preorder']['class'];
				} elseif ($this->config->get('module_preorder_out_sale_statuses') && in_array($result['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
					$preorder_stock_status = 1;
					$preorder_view = $preorder_button_out_sale_view;
					$preorder_class = $preorder_button['catalog']['out_sale']['class'];
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
			
                    'product_id'  => $result['product_id'],

			'oct_stickers'  => $oct_product_stickers,
			'you_save'	  	=> $result['you_save'],
			
                    'thumb' => $image,
'ukrcredits_stickers' => isset($ukrcredits_stickers)?$ukrcredits_stickers:array(),
                    'name' => $result['name'],
                    'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price' => $price,
                    'price_for_ads' => $price_for_ads,
                    'special'     => $special,

			'stock'     => $stock,
			'can_buy'   => $can_buy,
			'oct_grayscale'  => $oct_grayscale,
			
                    'tax' => $tax,
                    'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating' => 
			$this->config->get('config_review_status') ? $result['rating'] : false,
			'oct_model'	  => $this->config->get('theme_oct_showcase_data_model') ? $result['model'] : '',
			'reviews'	  => $result['reviews'],
			'quantity'	  => $result['quantity'] <= 0 ? true : false,
			'width'		  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'),
			'height'	  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'),
			
                    'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url),
                    'usdt_price' => $usdt_price
                    //'is_new' => $is_new_value
                );

                $lastIndex = count($data['products']) - 1;
                unset( $data['products'][$lastIndex]['oct_stickers']['stickers_new']);
                if($is_new_value){
                    $data['products'][$lastIndex]['oct_stickers']['stickers_new'] = 'Новинка';
                }

                //$data['products'][$key]['stickers_new'] = ($is_new_value) ? 'new' : '';
                $counter++;
            }




            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }


      // OCFilter start
      if (isset($url) && $this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->isSelected()) {
        $url .= '&' . $this->ocfilter->api->getParamsIndex() . '=' . $this->ocfilter->api->getParamsString();

        if (isset($this->request->get['ocfilter_placement'])) {
          $url .= '&ocfilter_placement=' . $this->request->get['ocfilter_placement'];
        }
      }
      // OCFilter end
      
            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
            );

            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                );

                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                );
            }

            $data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc'),
                'value' => 'p.model-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc'),
                'value' => 'p.model-DESC',
                'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
            );

			if ((isset($oct_showcase_sort_data) && !empty($oct_showcase_sort_data)) && (isset($oct_showcase_sort_data['sort']) && !empty($oct_showcase_sort_data['sort']))) {
				$data['sorts'] = [];

				foreach ($oct_showcase_sort_data['sort'] as $oct_sort) {
					$sort_order = explode('-', $oct_sort);

					$sort_name = str_replace(['.','-'], ['_', '_'], $oct_sort);

					if (!$this->config->get('config_review_status') && $sort_order[0] == 'rating') {
						continue;
					}

					$data['sorts'][] = array(
						'text'  => $this->language->get('text_' . $sort_name),
						'value' => $oct_sort,
						'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=' . $sort_order[0] . '&order='. $sort_order[1] . $url)
					);
				}
			}
			

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }


      // OCFilter start
      if (isset($url) && $this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->isSelected()) {
        $url .= '&' . $this->ocfilter->api->getParamsIndex() . '=' . $this->ocfilter->api->getParamsString();

        if (isset($this->request->get['ocfilter_placement'])) {
          $url .= '&ocfilter_placement=' . $this->request->get['ocfilter_placement'];
        }
      }
      // OCFilter end
      
            $data['limits'] = array();

            $limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['product_total'] = $product_total;
            $data['product_total_text'] = '('.$product_total.' '.$this->getProductWord($product_total).')';


      // OCFilter start
      if (isset($url) && $this->registry->get('ocfilter') && $this->ocfilter->startup() && $this->ocfilter->api->isSelected()) {
        $url .= '&' . $this->ocfilter->api->getParamsIndex() . '=' . $this->ocfilter->api->getParamsString();

        if (isset($this->request->get['ocfilter_placement'])) {
          $url .= '&ocfilter_placement=' . $this->request->get['ocfilter_placement'];
        }
      }
      // OCFilter end
      

            if (isset($oct_showcase_data['open_graph']) && $oct_showcase_data['open_graph']) {
                $site_link = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

				$config_logo = file_exists(DIR_IMAGE . $this->config->get('config_logo')) ? $this->config->get('config_logo') : 'catalog/opencart-logo.png';

                $oct_ogimage = $category_info['image'] ? $category_info['image'] : $config_logo;
                $category_image = $site_link . 'image/' . $oct_ogimage;

				$image_info = getimagesize(DIR_IMAGE . $oct_ogimage);

				if ($image_info) {
					$image_width  = $image_info[0];
					$image_height = $image_info[1];
				} else {
					$image_width  = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_width') ? $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_width') : 140;
					$image_height = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_height') ? $this->config->get('theme_' . $this->config->get('config_theme') . '_image_logo_height') : 65;
				}

				$mime_type = isset($image_info['mime']) ? $image_info['mime'] : 'image/svg+xml';

                $this->document->setOCTOpenGraph('og:title', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", (isset($oct_seo_title) && $oct_seo_title) ? $oct_seo_title : $category_info['meta_title'])))))));
                $this->document->setOCTOpenGraph('og:description', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", (isset($oct_seo_description) && $oct_seo_description && empty($category_info['meta_description'])) ? $oct_seo_description : $category_info['meta_description'])))))));
                $this->document->setOCTOpenGraph('og:site_name', htmlspecialchars(strip_tags(str_replace("\r", " ", str_replace("\n", " ", str_replace("\\", "/", str_replace("\"", "", $this->config->get('config_name'))))))));
                $this->document->setOCTOpenGraph('og:url', $this->url->link('product/category', 'path=' . $category_info['category_id']));
                $this->document->setOCTOpenGraph('og:image', str_replace(" ", "%20", $category_image));

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
                $this->document->setOCTOpenGraph('og:type', 'website');
            }
			
            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            $url = $this->url->link('product/category', 'path=' . $category_info['category_id']);
            $url = str_replace('http://', '', $url);
            $this->document->addLink('https://' . $url, 'canonical');

            if ($page > 1) {
                $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . (($page - 2) ? '&page=' . ($page - 1) : '')), 'prev');
            }

            if ($limit && ceil($product_total / $limit) > $page) {
                $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1)), 'next');
            }

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;

      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductListControllerData($data, (isset($product_total) ? $product_total : null));
      }
      // OCFilter End
      

            $data['continue'] = $this->url->link('common/home');

                    if($this->FTMaster && !empty($data['products'])) {

                        $this->DataLayer->add_data('products_listed', $this->DataLayer->format_products_listed($results, $data['products']));
                    }
                

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('product/category', $data));
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
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
                'href' => $this->url->link('product/category', $url)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['continue'] = $this->url->link('common/home');

                    if($this->FTMaster && !empty($data['products'])) {

                        $this->DataLayer->add_data('products_listed', $this->DataLayer->format_products_listed($results, $data['products']));
                    }
                

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

    public function getProductWord($product_total) {
        $forms = ['продукт', 'продукти', 'продуктів'];

        if ($product_total % 10 == 1 && $product_total % 100 != 11) {
            return $forms[0];
        } elseif ($product_total % 10 >= 2 && $product_total % 10 <= 4 && ($product_total % 100 < 10 || $product_total % 100 >= 20)) {
            return $forms[1];
        } else {
            return $forms[2];
        }
    }
}