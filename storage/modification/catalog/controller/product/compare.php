<?php
class ControllerProductCompare extends Controller {
    public function index() {
        $this->load->language('product/compare');


				$this->load->language('extension/module/preorder');
				
				if ($this->config->get('module_preorder_phone_mask')) {
					$this->document->addScript('catalog/view/javascript/preorder/inputmask/jquery.inputmask.bundle.min.js');
				}
				
				$this->document->addScript('catalog/view/javascript/preorder/preorder.js');
				$this->document->addStyle('catalog/view/javascript/preorder/preorder.css');
				$preorder_language_id = $this->config->get('config_language_id');
				
				$preorder_button = $this->config->get('module_preorder_button');
				
				if ($preorder_button['compare']['preorder']['view'] == 2) {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['compare']['preorder']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['compare']['preorder']['view'] == 1) {
					$preorder_button_preorder_view['text'] = $preorder_button['compare']['preorder']['text'][$preorder_language_id];
				} else {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i>';
					$preorder_button_preorder_view['tooltip'] = $preorder_button['compare']['preorder']['text'][$preorder_language_id];
				}
				
				if ($preorder_button['compare']['out_sale']['view'] == 2) {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['compare']['out_sale']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['compare']['out_sale']['view'] == 1) {
					$preorder_button_out_sale_view['text'] = $preorder_button['compare']['out_sale']['text'][$preorder_language_id];
				} else {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i>';
					$preorder_button_out_sale_view['tooltip'] = $preorder_button['compare']['out_sale']['text'][$preorder_language_id];
				}
			
        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');


        // settings
        $data['cwc_status'] = $this->config->get('compare_with_categories_status') !== null ? $this->config->get('compare_with_categories_status') : false;
        $data['cwc_cats'] = $this->config->get('compare_with_categories_сats_status') !== null ? $this->config->get('compare_with_categories_сats_status') : false;
        $data['cwc_cats_counter'] = $this->config->get('compare_with_categories_counter') !== null ? $this->config->get('compare_with_categories_counter') : false;
        $data['cwc_group_name'] = $this->config->get('compare_with_categories_show_group_name') !== null ? $this->config->get('compare_with_categories_show_group_name') : false;

        // slides
        $data['cwc_slides_def'] = $this->config->get('compare_with_categories_items_default') !== null ? $this->config->get('compare_with_categories_items_default') : 4;
        $data['cwc_slides_1200'] = $this->config->get('compare_with_categories_items_1200') !== null ? $this->config->get('compare_with_categories_items_1200') : 4;
        $data['cwc_slides_1024'] = $this->config->get('compare_with_categories_items_1024') !== null ? $this->config->get('compare_with_categories_items_1024') : 3;
        $data['cwc_slides_600'] = $this->config->get('compare_with_categories_items_600') !== null ? $this->config->get('compare_with_categories_items_600') : 2;
        $data['cwc_slides_480'] = $this->config->get('compare_with_categories_items_480') !== null ? $this->config->get('compare_with_categories_items_480') : 1;

        // image size
        $data['cwc_img_width'] = $this->config->get('compare_with_categories_img_width') !== null ? $this->config->get('compare_with_categories_img_width') : 80;
        $data['cwc_img_height'] = $this->config->get('compare_with_categories_img_height') !== null ? $this->config->get('compare_with_categories_img_height') : 80;

        // limit
        $data['cwc_limit'] = $this->config->get('compare_with_categories_limit') !== null ? $this->config->get('compare_with_categories_limit') : 20;

        // default vals
        $data['cwc_def_vals'] = $this->config->get('compare_with_categories_def_val_status') !== null ? $this->config->get('compare_with_categories_def_val_status') : false;
        $data['cwc_model'] = $this->config->get('compare_with_categories_model') !== null ? $this->config->get('compare_with_categories_model') : false;
        $data['cwc_model_is_slider'] = $this->config->get('compare_with_categories_model_is_slider') !== null ? $this->config->get('compare_with_categories_model_is_slider') : false;
        $data['cwc_manufacturer'] = $this->config->get('compare_with_categories_manufacturer') !== null ? $this->config->get('compare_with_categories_manufacturer') : false;
        $data['cwc_manufacturer_is_slider'] = $this->config->get('compare_with_categories_manufacturer_is_slider') !== null ? $this->config->get('compare_with_categories_manufacturer_is_slider') : false;
        $data['cwc_availability'] = $this->config->get('compare_with_categories_availability') !== null ? $this->config->get('compare_with_categories_availability') : false;
        $data['cwc_availability_is_slider'] = $this->config->get('compare_with_categories_availability_is_slider') !== null ? $this->config->get('compare_with_categories_availability_is_slider') : false;
        $data['cwc_weight'] = $this->config->get('compare_with_categories_weight') !== null ? $this->config->get('compare_with_categories_weight') : false;
        $data['cwc_weight_is_slider'] = $this->config->get('compare_with_categories_weight_is_slider') !== null ? $this->config->get('compare_with_categories_weight_is_slider') : false;
        $data['cwc_dimension'] = $this->config->get('compare_with_categories_dimension') !== null ? $this->config->get('compare_with_categories_dimension') : false;
        $data['cwc_dimension_is_slider'] = $this->config->get('compare_with_categories_dimension_is_slider') !== null ? $this->config->get('compare_with_categories_dimension_is_slider') : false;
        $data['cwc_rating'] = $this->config->get('compare_with_categories_rating') !== null ? $this->config->get('compare_with_categories_rating') : false;
        $data['cwc_rating_is_slider'] = $this->config->get('compare_with_categories_rating_is_slider') !== null ? $this->config->get('compare_with_categories_rating_is_slider') : false;

        // default vals heading
        if (!empty($this->config->get('compare_with_categories_def_heading')[$this->config->get('config_language_id')])) {
            $data['cwc_heading'] = html_entity_decode($this->config->get('compare_with_categories_def_heading')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
        }else{
            $data['cwc_heading'] = $this->language->get('text_default_values');
        }

	  
        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }


        $this->document->addScript('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js');
        $this->document->addStyle('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
        $this->document->addStyle('catalog/view/theme/default/stylesheet/compare_with_categories.css');
      
        if (isset($this->request->get['remove'])) {
            $key = array_search($this->request->get['remove'], $this->session->data['compare']);

            if ($key !== false) {
                unset($this->session->data['compare'][$key]);

                $this->session->data['success'] = $this->language->get('text_remove');
            }

            if (isset($this->request->get['category_id'])) {
                $this->response->redirect($this->url->link('product/compare', 'category_id=' . $this->request->get['category_id']));
            } else {
                $this->response->redirect($this->url->link('product/compare'));
            }

        }

        $this->document->setRobots('noindex, nofollow');


        if (isset($this->request->get['remove_list'])) {
          $remove_list = explode(',', $this->request->get['remove_list']);
        
          foreach ($remove_list as $product_id) {
            $key = array_search($product_id, $this->session->data['compare']);
        
            if ($key !== false) {
              unset($this->session->data['compare'][$key]);
            }
          }
        
          $this->session->data['success'] = $this->language->get('text_remove');
          $this->response->redirect($this->url->link('product/compare'));
        }
      
        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('product/compare')
        );

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['review_status'] = $this->config->get('config_review_status');

        $data['products'] = array();

        $data['attribute_groups'] = array();

        if (!empty($this->session->data['compare'])) {
          $data['all_count'] = count($this->session->data['compare']);
          $data['remove_list'] = $this->url->link('product/compare', 'remove_list=');
        };
		    $data['categories'] = array();

        foreach ($this->session->data['compare'] as $key => $product_id) {
          $categories_query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND main_category = '1'");
          
          if ($categories_query->num_rows > 0) {
            foreach ($categories_query->rows as $row) {
              $category_id = $row['category_id'];
              
              // Check if category exists
              if (!isset($data['categories'][$category_id])) {
                $language_id = $this->config->get('config_language_id');
                $category_name_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$language_id . "'");
                
                if ($category_name_query->num_rows > 0) {
                  $category_name = $category_name_query->row['name'];
                  
                  // Create new category
                  $data['categories'][$category_id] = [
                    'id' => $category_id,
                    'name' => $category_name,
                    'count' => 0,
                    'category_products' => [],
                    'category_attributes' => []
                  ];
                }
              }
              
              // Get product info
              $prod_info = $this->model_catalog_product->getProduct($product_id);
              
              if ($prod_info) {
                if ($prod_info['image']) {
                  if ($data['cwc_status']) {
                      $width = $data['cwc_img_width'];
                      $height = $data['cwc_img_height'];
                  } else {
                      $width = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_compare_width');
                      $height = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_compare_height');
                  }

                  $image = $this->model_tool_image->resize($prod_info['image'], $width, $height);
                } else {
                  $image = false;
                }
        
                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                  $price = $this->currency->format($this->tax->calculate($prod_info['price'], $prod_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                  $price = false;
                }
        
                if (!is_null($prod_info['special']) && (float)$prod_info['special'] >= 0) {
                  $special = $this->currency->format($this->tax->calculate($prod_info['special'], $prod_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                  $special = false;
                }
        
                if ($prod_info['quantity'] <= 0) {
                  $availability = $prod_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                  $availability = $prod_info['quantity'];
                } else {
                  $availability = $this->language->get('text_instock');
                }
        
                $pattribute_data = array();
        
                $pattribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
        
                foreach ($pattribute_groups as $attribute_group) {
                  foreach ($attribute_group['attribute'] as $attribute) {
                    $pattribute_data[$attribute['attribute_id']] = $attribute['text'];
                  }
                }

                $main_category_query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$prod_info['product_id'] . "' AND main_category = '1'");
                
                $main_category_id = ($main_category_query->num_rows > 0) ? $main_category_query->row['category_id'] : '';

                if ($main_category_id == $category_id) {
                  // Add product to category_products array
                  $data['categories'][$category_id]['category_products'][] = array(
                    'product_id'   => $prod_info['product_id'],
                    'wish_id' => $product_id,
                    'name'         => $prod_info['name'],
                    'thumb'        => $image,
                    'price'        => $price,
                    'special'      => $special,
                    'description'  => utf8_substr(strip_tags(html_entity_decode($prod_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model'        => $prod_info['model'],
                    'manufacturer' => $prod_info['manufacturer'],
                    'main_category_id' => $main_category_id, //
                    'availability' => $availability,
                    'minimum'      => $prod_info['minimum'] > 0 ? $prod_info['minimum'] : 1,
                    'rating'       => (int)$prod_info['rating'],
                    'reviews'      => sprintf($this->language->get('text_reviews'), (int)$prod_info['reviews']),
                    'weight'       => $this->weight->format($prod_info['weight'], $prod_info['weight_class_id']),
                    'length'       => $this->length->format($prod_info['length'], $prod_info['length_class_id']),
                    'width'        => $this->length->format($prod_info['width'], $prod_info['length_class_id']),
                    'height'       => $this->length->format($prod_info['height'], $prod_info['length_class_id']),
                    'attribute'    => $pattribute_data,
                    'href'         => $this->url->link('product/product', 'product_id=' . $product_id),
                    'remove'       => $this->url->link('product/compare', 'remove=' . $product_id)
                  );

                  foreach ($pattribute_groups as $attribute_group) {
                    $data['categories'][$category_id]['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];
                    $data['categories'][$category_id]['attribute_groups'][$attribute_group['attribute_group_id']]['attribute_group_id'] =  $attribute_group['attribute_group_id'];
          
                    foreach ($attribute_group['attribute'] as $attribute) {
                      $data['categories'][$category_id]['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
                      $data['categories'][$category_id]['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['attribute_id'] = $attribute['attribute_id'];
                    }
                  }
                }
              }

            }
          }
        }
        
        // Update count
        foreach ($data['categories'] as &$category) {
          $category['count'] = count($category['category_products']);
        }
      

        foreach ($this->session->data['compare'] as $key => $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
                if ($product_info['image']) {
                    
          if ($data['cwc_status']) {
              $width = $data['cwc_img_width'];
              $height = $data['cwc_img_height'];
          } else {
              $width = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_compare_width');
              $height = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_compare_height');
          }

          $image = $this->model_tool_image->resize($product_info['image'], $width, $height);
      
                } else {
                    $image = false;
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

                if ($product_info['quantity'] <= 0) {
                    $availability = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $availability = $product_info['quantity'];
                } else {
                    $availability = $this->language->get('text_instock');
                }

                $price_for_usdt = 0;

                if ($product_info['special']) {
                    $price_for_usdt = explode(' ', $product_info['special'])[0];
                } else {
                    $price_for_usdt = explode(' ', $product_info['price'])[0];
                }

                $usdt_price = round($price_for_usdt/$usdt_rate);

                $attribute_data = array();

                $attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);

                foreach ($attribute_groups as $attribute_group) {
                    foreach ($attribute_group['attribute'] as $attribute) {
                        $attribute_data[$attribute['attribute_id']] = $attribute['text'];
                    }
                }


          $main_category_query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_info['product_id'] . "' AND main_category = '1'");

          $main_category_id = '';

          if ($main_category_query->num_rows > 0) {
            $main_category_id = $main_category_query->row['category_id'];
          }
      

				$preorder_info = array();
			
				if ($this->config->get('module_preorder_stock_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_stock_statuses'))) {
					$preorder_stock_status = 2;
					$preorder_view = $preorder_button_preorder_view;
					$preorder_class = $preorder_button['compare']['preorder']['class'];
				} elseif ($this->config->get('module_preorder_out_sale_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
					$preorder_stock_status = 1;
					$preorder_view = $preorder_button_out_sale_view;
					$preorder_class = $preorder_button['compare']['out_sale']['class'];
				} else {
					$preorder_stock_status = 0;
					$preorder_view = '';
					$preorder_class = '';
				}
				
				$preorder_info = array(
					'stock_status' => $preorder_stock_status,
					'quantity'     => $product_info['quantity'],
					'view'         => $preorder_view,
					'class'        => $preorder_class,
				);
			

                    if(!isset($results_temp))
                        $results_temp = array();

                    $results_temp[] = $product_info;
                
                $data['products'][$product_id] = array(

				'preorder' => $preorder_info,
			

          'wish_id' => $product_id,
          'main_category_id' => $main_category_id,
      
                    'product_id'   => $product_info['product_id'],
                    'name'         => $product_info['name'],
                    'oct_model'	   => $this->config->get('theme_oct_showcase_data_model') ? $product_info['model'] : '',
                    'thumb'        => $image,
                    'price'        => $price,
                    'usdt_price'   => $usdt_price,
                    'special'      => $special,
                    'description'  => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
                    'model'        => $product_info['model'],
                    'manufacturer' => $product_info['manufacturer'],
                    'availability' => $availability,
                    'minimum'      => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
                    'rating'       => (int)$product_info['rating'],
                    'reviews'      => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
                    //'weight'       => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
//					'length'       => $this->length->format($product_info['length'], $product_info['length_class_id']),
//					'width'        => $this->length->format($product_info['width'], $product_info['length_class_id']),
//					'height'       => $this->length->format($product_info['height'], $product_info['length_class_id']),
                    'attribute'    => $attribute_data,
                    'href'         => $this->url->link('product/product', 'product_id=' . $product_id),
                    'remove'       => $this->url->link('product/compare', '&remove=' . $product_id)
                );

                foreach ($attribute_groups as $attribute_group) {
                    $data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];

          $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute_group_id'] =  $attribute_group['attribute_group_id'];
      

                    foreach ($attribute_group['attribute'] as $attribute) {
                        $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];

          $data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['attribute_id'] = $attribute['attribute_id'];
      
                    }
                }
            } else {
                unset($this->session->data['compare'][$key]);
            }
        }

        $data['continue'] = $this->url->link('common/home');

                    if($this->FTMaster && !empty($data['products'])) {
                        $this->DataLayer->add_data('products_listed', $this->DataLayer->format_products_listed($results_temp, $data['products']));
                    }
                

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $data['current_url'] = $this->url->link('product/compare');

        $has_some_category_active_class = false;
        foreach ($data['categories'] as &$category) {
            if ( ((int)$this->request->get['category_id']) == $category['id'] ) {
                $category['active_class'] = 'active';
                $has_some_category_active_class = true;
            } else {
                $category['active_class'] = '';
            }
        }

        if (!$has_some_category_active_class) {
            $data['all_category_active_class'] = 'active';
        } else {
            $data['all_category_active_class'] = '';
        }

        $data['query_category_id'] = (int)isset($this->request->get['category_id']) ? $this->request->get['category_id'] : false;

        foreach ($data['categories'] as &$category) {
            foreach ($category['category_products'] as &$category_product) {

                $price_for_usdt = 0;
                $prod_info = $this->model_catalog_product->getProduct($category_product['product_id']);

                if ($prod_info['special']) {
                    $price_for_usdt = explode(' ', $prod_info['special'])[0];
                } else {
                    $price_for_usdt = explode(' ', $prod_info['price'])[0];
                }

                $category_product['usdt_price'] = round($price_for_usdt/$usdt_rate);
                if ($data['query_category_id']) {
                    $category_product['remove'] = $this->url->link('product/compare', 'remove=' . $product_id . '&category_id=' . $data['query_category_id']);
                }
            }
        }

        
        if ($data['cwc_status']){
          $this->response->setOutput($this->load->view('product/compare_with_categories', $data));
        } else {
          $this->response->setOutput($this->load->view('product/compare', $data));
        }
      
    }

    public function add() {
        $this->load->language('product/compare');

        $json = array();


        // settings
        $data['cwc_status'] = $this->config->get('compare_with_categories_status') !== null ? $this->config->get('compare_with_categories_status') : false;
        $data['cwc_cats'] = $this->config->get('compare_with_categories_сats_status') !== null ? $this->config->get('compare_with_categories_сats_status') : false;
        $data['cwc_cats_counter'] = $this->config->get('compare_with_categories_counter') !== null ? $this->config->get('compare_with_categories_counter') : false;
        $data['cwc_group_name'] = $this->config->get('compare_with_categories_show_group_name') !== null ? $this->config->get('compare_with_categories_show_group_name') : false;

        // slides
        $data['cwc_slides_def'] = $this->config->get('compare_with_categories_items_default') !== null ? $this->config->get('compare_with_categories_items_default') : 4;
        $data['cwc_slides_1200'] = $this->config->get('compare_with_categories_items_1200') !== null ? $this->config->get('compare_with_categories_items_1200') : 4;
        $data['cwc_slides_1024'] = $this->config->get('compare_with_categories_items_1024') !== null ? $this->config->get('compare_with_categories_items_1024') : 3;
        $data['cwc_slides_600'] = $this->config->get('compare_with_categories_items_600') !== null ? $this->config->get('compare_with_categories_items_600') : 2;
        $data['cwc_slides_480'] = $this->config->get('compare_with_categories_items_480') !== null ? $this->config->get('compare_with_categories_items_480') : 1;

        // image size
        $data['cwc_img_width'] = $this->config->get('compare_with_categories_img_width') !== null ? $this->config->get('compare_with_categories_img_width') : 80;
        $data['cwc_img_height'] = $this->config->get('compare_with_categories_img_height') !== null ? $this->config->get('compare_with_categories_img_height') : 80;

        // limit
        $data['cwc_limit'] = $this->config->get('compare_with_categories_limit') !== null ? $this->config->get('compare_with_categories_limit') : 20;

        // default vals
        $data['cwc_def_vals'] = $this->config->get('compare_with_categories_def_val_status') !== null ? $this->config->get('compare_with_categories_def_val_status') : false;
        $data['cwc_model'] = $this->config->get('compare_with_categories_model') !== null ? $this->config->get('compare_with_categories_model') : false;
        $data['cwc_model_is_slider'] = $this->config->get('compare_with_categories_model_is_slider') !== null ? $this->config->get('compare_with_categories_model_is_slider') : false;
        $data['cwc_manufacturer'] = $this->config->get('compare_with_categories_manufacturer') !== null ? $this->config->get('compare_with_categories_manufacturer') : false;
        $data['cwc_manufacturer_is_slider'] = $this->config->get('compare_with_categories_manufacturer_is_slider') !== null ? $this->config->get('compare_with_categories_manufacturer_is_slider') : false;
        $data['cwc_availability'] = $this->config->get('compare_with_categories_availability') !== null ? $this->config->get('compare_with_categories_availability') : false;
        $data['cwc_availability_is_slider'] = $this->config->get('compare_with_categories_availability_is_slider') !== null ? $this->config->get('compare_with_categories_availability_is_slider') : false;
        $data['cwc_weight'] = $this->config->get('compare_with_categories_weight') !== null ? $this->config->get('compare_with_categories_weight') : false;
        $data['cwc_weight_is_slider'] = $this->config->get('compare_with_categories_weight_is_slider') !== null ? $this->config->get('compare_with_categories_weight_is_slider') : false;
        $data['cwc_dimension'] = $this->config->get('compare_with_categories_dimension') !== null ? $this->config->get('compare_with_categories_dimension') : false;
        $data['cwc_dimension_is_slider'] = $this->config->get('compare_with_categories_dimension_is_slider') !== null ? $this->config->get('compare_with_categories_dimension_is_slider') : false;
        $data['cwc_rating'] = $this->config->get('compare_with_categories_rating') !== null ? $this->config->get('compare_with_categories_rating') : false;
        $data['cwc_rating_is_slider'] = $this->config->get('compare_with_categories_rating_is_slider') !== null ? $this->config->get('compare_with_categories_rating_is_slider') : false;

        // default vals heading
        if (!empty($this->config->get('compare_with_categories_def_heading')[$this->config->get('config_language_id')])) {
            $data['cwc_heading'] = html_entity_decode($this->config->get('compare_with_categories_def_heading')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
        }else{
            $data['cwc_heading'] = $this->language->get('text_default_values');
        }

	  
        if (!isset($this->session->data['compare'])) {
            $this->session->data['compare'] = array();
        }

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
                
        if ($data['cwc_status'] and $data['cwc_limit']){
          $shift_limit = $data['cwc_limit'];
        } else {
          $shift_limit = 4;
        }
        if (count($this->session->data['compare']) >= $shift_limit) {
      
                    array_shift($this->session->data['compare']);
                }

                $this->session->data['compare'][] = $this->request->post['product_id'];
            }

            $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('product/compare'));


		  // remarketing all in one
		  $this->load->model('tool/remarketing');
		  if ($this->config->get('remarketing_status') && $product_info && !$this->model_tool_remarketing->isBot()) {
		  	  $json['remarketing'] = $this->model_tool_remarketing->remarketingCompare($product_info);
		  }
	  
            $json['total'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			$json['total_compare'] = (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0);
			
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
