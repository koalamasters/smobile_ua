<?php
class ControllerProductSearch extends Controller {
	public function index() {

			$data['oct_showcase_data'] = $oct_showcase_data = $this->config->get('theme_oct_showcase_data');

			if (isset($oct_showcase_data['category_view_sort_oder']) && $oct_showcase_data['category_view_sort_oder']) {
				$oct_showcase_sort_data = $this->config->get('theme_oct_showcase_sort_data');

				if (isset($oct_showcase_sort_data['deff_sort']) && $oct_showcase_sort_data['deff_sort']) {
					$sort_order = explode('-', $oct_showcase_sort_data['deff_sort']);
				}
			}

			$ikey = 1;
			

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
			

        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

		$this->load->language('product/search');

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

		if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		}

        $data['hide_search'] = 0;
        if(isset($this->request->get['ocf_custom_route'])){
            $data['hide_search'] = 1;
        }
        

		if (isset($this->request->get['tag'])) {
			$tag = $this->request->get['tag'];
		} elseif (isset($this->request->get['search'])) {
			$tag = $this->request->get['search'];
		} else {
			$tag = '';
		}

		if (isset($this->request->get['description'])) {
			$description = $this->request->get['description'];
		} else {
			$description = '';
		}

		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}

		if (isset($this->request->get['sub_category'])) {
			$sub_category = $this->request->get['sub_category'];
		} else {
			$sub_category = '';
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
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}
		
		$this->document->setRobots('noindex, nofollow');


            if (isset($this->request->get['search'])) {
                $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['search']);
            } elseif (isset($this->request->get['tag'])) {
                $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
            } else {
                $this->document->setTitle($this->language->get('heading_title'));
            }




		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$url = '';

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/search', $url)
		);

		if (isset($this->request->get['search'])) {
			$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['search'];
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}

        if($tag){
            $data['heading_title'] = $tag;
            $this->document->setTitle($tag);
            $data['hide_search'] = 1;
        }

		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

		$data['compare'] = $this->url->link('product/compare');

		$this->load->model('catalog/category');

		// 3 Level Category Search
		$data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['category_id'],
						'name'        => $category_3['name'],
					);
				}

				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);
			}

			$data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}

				
			$this->load->model('module/ukrcredits');
			
		$data['products'] = array();

	        $oct_showcase_data_atributes = $this->config->get('theme_oct_showcase_data_atributes');
			

			$data['oct_popup_view_status'] = $this->config->get('oct_popup_view_status');
			

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$filter_data = array(
				'filter_name'         => $search,
				'filter_tag'          => $tag,
				'filter_description'  => $description,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => $sub_category,
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

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

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                    $image = '/image/'.$result['image'];
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

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
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
			
					'thumb'       => $image,

			'oct_atributes'       => $oct_atributes,
			
'ukrcredits_stickers' => isset($ukrcredits_stickers)?$ukrcredits_stickers:array(),
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,

			'stock'     => $stock,
			'can_buy'   => $can_buy,
			'oct_grayscale'  => $oct_grayscale,
			
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => 
			$this->config->get('config_review_status') ? $result['rating'] : false,
			'oct_model'	  => $this->config->get('theme_oct_showcase_data_model') ? $result['model'] : '',
			'reviews'	  => $result['reviews'],
			'quantity'	  => $result['quantity'] <= 0 ? true : false,
			'width'		  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'),
			'height'	  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'),
			
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url),
					'is_new'        => $is_new_value,
                    'usdt_price' => $usdt_price
				);
			}


			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/search', 'sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/search', 'sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/search', 'sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/search', 'sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/search', 'sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/search', 'sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/search', 'sort=p.model&order=DESC' . $url)
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
						'href'  => $this->url->link('product/search', '&sort=' . $sort_order[0] . '&order='. $sort_order[1] . $url)
					);
				}
			}
			

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/search', $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
      
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = str_replace('http://','https://',$this->url->link('product/search', $url . '&page={page}'));

			$data['pagination'] = $pagination->render();
            $data['pagination'] = str_replace('http://', 'https://',$data['pagination']);


			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			if (isset($this->request->get['search']) && $this->config->get('config_customer_search')) {
				$this->load->model('account/search');

				if ($this->customer->isLogged()) {
					$customer_id = $this->customer->getId();
				} else {
					$customer_id = 0;
				}

				if (isset($this->request->server['REMOTE_ADDR'])) {
					$ip = $this->request->server['REMOTE_ADDR'];
				} else {
					$ip = '';
				}

				$search_data = array(
					'keyword'       => $search,
					'category_id'   => $category_id,
					'sub_category'  => $sub_category,
					'description'   => $description,
					'products'      => $product_total,
					'customer_id'   => $customer_id,
					'ip'            => $ip
				);

				$this->model_account_search->addSearch($search_data);
			}
		}

       

		$data['search'] = $search;
		$data['description'] = $description;
		$data['category_id'] = $category_id;
		$data['sub_category'] = $sub_category;

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

      // OCFilter Start
      if ($this->registry->get('ocfilter') && $this->ocfilter->startup()) {
        $this->ocfilter->api->setProductListControllerData($data, (isset($product_total) ? $product_total : null));
      }
      // OCFilter End
      


                    if($this->FTMaster && !empty($data['products'])) {
                        $this->DataLayer->add_data('products_listed', $this->DataLayer->format_products_listed($results, $data['products']));
                    }
                
		$data['column_left'] = $this->load->controller('common/column_left');

		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');



		$this->response->setOutput($this->load->view('product/search', $data));
	}
}
