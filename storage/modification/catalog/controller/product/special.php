<?php
class ControllerProductSpecial extends Controller {
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
			
		$this->load->language('product/special');


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

		$this->document->setRobots('index, follow');
		
		$this->document->setTitle($this->language->get('heading_title')); 

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
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

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/special', $url)
		);

		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

		$data['compare'] = $this->url->link('product/compare');

				
			$this->load->model('module/ukrcredits');
			
		$data['products'] = array();

	        $oct_showcase_data_atributes = $this->config->get('theme_oct_showcase_data_atributes');
			

			$data['oct_popup_view_status'] = $this->config->get('oct_popup_view_status');
			

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);

		$product_total = $this->model_catalog_product->getTotalProductSpecials();

		$results = $this->model_catalog_product->getProductSpecials($filter_data);

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
			
				'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
			);
		}

		$url = '';

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
			'href'  => $this->url->link('product/special', 'sort=p.sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => $this->url->link('product/special', 'sort=pd.name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => $this->url->link('product/special', 'sort=pd.name&order=DESC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'ps.price-ASC',
			'href'  => $this->url->link('product/special', 'sort=ps.price&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'ps.price-DESC',
			'href'  => $this->url->link('product/special', 'sort=ps.price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/special', 'sort=rating&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('product/special', 'sort=rating&order=ASC' . $url)
			);
		}

		$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/special', 'sort=p.model&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href'  => $this->url->link('product/special', 'sort=p.model&order=DESC' . $url)
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
						'href'  => $this->url->link('product/special', '&sort=' . $sort_order[0] . '&order='. $sort_order[1] . $url)
					);
				}
			}
			

		$url = '';

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
				'href'  => $this->url->link('product/special', $url . '&limit=' . $value)
			);
		}

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
		$pagination->url = $this->url->link('product/special', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		// if ($page == 1) {
		//     $this->document->addLink($this->url->link('product/special', '', true), 'canonical');
		// } else {
		//     $this->document->addLink($this->url->link('product/special', 'page='. $page , true), 'canonical');
		// }		

		$url = $this->url->link('product/special', '', true);
		$url = str_replace('http://', '', $url);
		$this->document->addLink('https://' . $url, 'canonical');
		
		
		if ($page > 1) {
			$this->document->addLink($this->url->link('product/special', (($page - 2) ? '&page='. ($page - 1) : ''), true), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
		    $this->document->addLink($this->url->link('product/special', 'page='. ($page + 1), true), 'next');
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

		$this->response->setOutput($this->load->view('product/special', $data));
	}
}
