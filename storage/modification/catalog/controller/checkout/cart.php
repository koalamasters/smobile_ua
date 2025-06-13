<?php
class ControllerCheckoutCart extends Controller {
    public function index() {


        ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

        $use_avif = true;

        $this->load->language('checkout/cart');

        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

        $this->document->setRobots('noindex, nofollow');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['clear_cart'] = $this->language->get('clear_cart');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home')
        );

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/cart'),
            'text' => $this->language->get('heading_title')
        );

        $data['text_delete'] = $this->language->get('delete');
        $data['text_checked'] = $this->language->get('checked');


        $data['text_off_dist'] = $this->language->get('off_dist');
        $data['text_free_delivery'] = $this->language->get('free_delivery');
        $data['text_crypto_pay'] = $this->language->get('crypto_pay');
        $data['text_part_pay'] = $this->language->get('part_pay');

        if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
            if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
                $data['error_warning'] = $this->language->get('error_stock');
            } elseif (isset($this->session->data['error'])) {
                $data['error_warning'] = $this->session->data['error'];

                unset($this->session->data['error']);
            } else {
                $data['error_warning'] = '';
            }

            if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
                $data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
            } else {
                $data['attention'] = '';
            }

            if (isset($this->session->data['success'])) {
                $data['success'] = $this->session->data['success'];

                unset($this->session->data['success']);
            } else {
                $data['success'] = '';
            }


				$this->load->model('extension/module/ex_pak');
				$data['ex_pak_status'] = $this->model_extension_module_ex_pak->load();
				if($data['ex_pak_status']){
					$data['ex_pak_setting'] = $this->model_extension_module_ex_pak->getSetting();
					$this->document->addScript('catalog/view/javascript/ex_pak/swiper/swiper-bundle.min.js');
     				$this->document->addStyle('catalog/view/javascript/ex_pak/swiper/swiper-bundle.min.css');
					$this->document->addScript('catalog/view/javascript/ex_pak/ex_pak.js');
					$this->document->addStyle('catalog/view/javascript/ex_pak/ex_pak.css');
				}
			
            $data['action'] = $this->url->link('checkout/cart/edit', '', true);


				$this->load->model('extension/module/ex_pak');
				$data['ex_pak_status'] = $this->model_extension_module_ex_pak->load();
				if($data['ex_pak_status']){
					$data['ex_pak_setting'] = $this->model_extension_module_ex_pak->getSetting();
					$this->document->addScript('catalog/view/javascript/ex_pak/swiper/swiper-bundle.min.js');
     				$this->document->addStyle('catalog/view/javascript/ex_pak/swiper/swiper-bundle.min.css');
					$this->document->addScript('catalog/view/javascript/ex_pak/ex_pak.js');
					$this->document->addStyle('catalog/view/javascript/ex_pak/ex_pak.css');
				}
			
            $data['action'] = str_replace('http:', 'https:', $data['action']);
            if ($this->config->get('config_cart_weight')) {
                $data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
            } else {
                $data['weight'] = '';
            }

            $this->load->model('tool/image');
            $this->load->model('tool/upload');

            $data['products'] = array();
            $wishlist = $this->session->data['wishlist'] ?? [];

            $products = $this->cart->getProducts();

			if (($this->config->get('config_checkout_guest') && $this->config->get('oct_popup_purchase_byoneclick_status')) && $products) {
				$oct_byoneclick_data = $this->config->get('oct_popup_purchase_byoneclick_data');
				$oct_data['oct_byoneclick_status'] = isset($oct_byoneclick_data['cart']) ? 1 : 0;
				$oct_data['oct_byoneclick_mask'] = $oct_byoneclick_data['mask'];
				$oct_data['oct_byoneclick_product_id'] = $oct_data['oct_cart_in'] = $oct_data['oct_cart_page'] = 1;
				$oct_data['oct_byoneclick_page'] = '_cart';
				$data['oct_byoneclick'] = $this->load->controller('octemplates/module/oct_popup_purchase/byoneclick', $oct_data);
			}
			

            foreach ($products as $product) {

                $product_info = $this->model_catalog_product->getProduct($product['product_id']);
                $product_total = 0;


                if($product['quantity'] > $product_info['quantity']){
                    $product['quantity'] = $product_info['quantity'];
                }

                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total += $product_2['quantity'];
                    }
                }

                if ($product['minimum'] > $product_total) {
                    $data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
                }

                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_height'));

                    if( $use_avif){
                        $image = $this->model_tool_image->getAvif($product['image']);
                    }else{
                        $image = '/image/'.$product['image'];
                    }

                } else {
                    $image = '';
                }

                $option_data = array();

				$this->load->model('catalog/product');

				$options_arr = [];

				foreach ($product['option'] as $value_opt) {
					array_push($options_arr, $value_opt['product_option_value_id']);
				}

				if ($options_arr) {
					$opt_array = [];
					
					foreach ($options_arr as $value) {
						if (is_array($value)) {
							foreach ($value as $val) {
								if ($val) {
									$opt_array[] = $this->model_catalog_product->getProductOptionValueId($product['product_id'], $val);
								}
							}
						} else {
							if ($value) {
								$opt_array[] = $this->model_catalog_product->getProductOptionValueId($product['product_id'], $value);
							}
						}
					}

					$results_opts = $this->model_catalog_product->getProductImagesByOptionValueId($product['product_id'], $opt_array);

					if (isset($results_opts[0]['image']) AND $results_opts[0]['image']) {
						$image = $this->model_tool_image->resize($results_opts[0]['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_height'));
					}
				}
	  

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $value = $upload_info['name'];
                        } else {
                            $value = '';
                        }
                    }

                    $option_data[] = array(
                        'name'  => $option['name'],
                        'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    );
                }

                // Display prices
                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));

                    $price = $this->currency->format($unit_price, $this->session->data['currency']);
                    $total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
                } else {
                    $price = false;
                    $total = false;
                }

                $recurring = '';

                if ($product['recurring']) {
                    $frequencies = array(
                        'day'        => $this->language->get('text_day'),
                        'week'       => $this->language->get('text_week'),
                        'semi_month' => $this->language->get('text_semi_month'),
                        'month'      => $this->language->get('text_month'),
                        'year'       => $this->language->get('text_year')
                    );

                    if ($product['recurring']['trial']) {
                        $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }

                    if ($product['recurring']['duration']) {
                        $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }

                if($product['old_price']){
                    $tmp_speical = $product['price'];
                    $product['price'] = $product['old_price'];
                    $product['special'] = $tmp_speical;
                }

                $price = $product['price']*$product['quantity'];
                $special = $product['special']*$product['quantity'];

                $special_price_text = $this->currency->format($this->tax->calculate($special, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $price_text = $this->currency->format($this->tax->calculate($price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);


                $data['usdt_info'] = $this->language->get('usdt_info');



                $price_for_usdt = 0;

                if($product['special']){
                    $price_for_usdt = $special;
                }else{
                    $price_for_usdt = $price;
                }

                $usdt_price = round($price_for_usdt/$usdt_rate);

                $product_in_liked = 0;
                if (in_array($product['product_id'], $wishlist)) {
                    $product_in_liked = 1;
                }


				$add_products[$product['product_id']] = $product['product_id'];
			
                $data['products'][] = array(
                    'cart_id'   => $product['cart_id'],
                    'product_id'   => $product['product_id'],
                    'thumb'     => $image,
                    'name'      => $product['name'],
                    'model'     => $product['model'],

				'has_doptovary'     => $data['ex_pak_status'] ? $this->model_extension_module_ex_pak->checkCartProductHasGroups($product) : false,
			
                    'option'    => $option_data,
                    'recurring' => $recurring,
                    'quantity'  => $product['quantity'],
                    'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
                    'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
                    'price'     => $price,
                    'total'     => $total,
                    'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                    'liked'     => $product_in_liked,
                    'special' => $special,
                    'price' => $price,
                    'special_text' => $special_price_text,
                    'price_text' => $price_text,
                    'usdt'      => $usdt_price,
                    'total_float' => $product_total*$product['quantity']
                );
            }


				$data['product_related_cart'] = array();

				if(isset($add_products)) {

				$this->load->model('catalog/product');

				foreach ($add_products as $product_id) {

					$recommended = $this->model_catalog_product->getProductRelated($product_id);

					foreach ($recommended as $rec_id => $recomend_product){
                        if(in_array($rec_id, $add_products)){
                            unset($recommended[$rec_id]);
                        }
                    }

                    if(count($recommended) > 2) {
                        $recommended_keys = array_rand($recommended, 2);
                    }else{
                        $recommended_keys = array_keys($recommended);
                    }

						foreach ($recommended as $result) {
							if ($result['image']) {
								$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
							} else {
								$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
							}

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

							$data['product_related_cart'][$result['product_id']] = array(
								'product_id'  => $result['product_id'],
								'model'  => $result['model'],
								'thumb'       => $image,
								'name'        => $result['name'],
								'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
								'price'       => $price,
								'special'     => $special,
								'tax'         => $tax,
								'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
								'rating'      => $result['rating'],
								'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
							);
						}
						unset($data['product_related_cart'][$product_id]);
					}
				}
			
            // Gift Voucher
            $data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $key => $voucher) {
                    $data['vouchers'][] = array(
                        'key'         => $key,
                        'description' => $voucher['description'],
                        'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency']),
                        'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
                    );
                }
            }

            // Totals
            $this->load->model('setting/extension');

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes'  => &$taxes,
                'total'  => &$total
            );

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $sort_order = array();

                $results = $this->model_setting_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get('total_' . $result['code'] . '_status')) {
                        $this->load->model('extension/total/' . $result['code']);

                        // We have to put the totals in an array so that they pass by reference.
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }

                $sort_order = array();

                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $totals);
            }

            $data['totals'] = array();

            foreach ($totals as $total) {
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'code' => $total['code'],
                    'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
                    'is_total_amount' => $total['code'] == 'total'
                );
            }

            $data['continue'] = $this->url->link('common/home');

            $data['checkout'] = $this->url->link('checkout/checkout', '', true);

            $this->load->model('setting/extension');

            $data['modules'] = array();

            $files = glob(DIR_APPLICATION . '/controller/extension/total/*.php');

            if ($files) {
                foreach ($files as $file) {
                    $result = $this->load->controller('extension/total/' . basename($file, '.php'));

                    if ($result) {
                        $data['modules'][] = $result;
                    }
                }
            }


                 $data['mono_checkout_button'] = $this->config->get('module_mono_checkout_cart_show') ?  str_replace("\n", '',$this->load->controller('extension/module/mono_checkout/getButton', 'cart_page')) : false;
                 $data['module_mono_checkout_cart_elem'] = $this->config->get('module_mono_checkout_cart_elem') ? $this->config->get('module_mono_checkout_cart_elem') : '.buttons .pull-right .btn-primary';
            
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $data['total_title'] = $this->language->get('total_title');


            if(isset($this->request->get['get_totals']) && $this->request->get['get_totals'] == 'y'){
                echo json_encode($data['totals']);
                die();
            }

            if(isset($this->request->get['ajax']) && $this->request->get['ajax'] == 'Y'){
                $this->response->setOutput($this->load->view('checkout/cart_ajax', $data));
                return;
            }else {
                $this->response->setOutput($this->load->view('checkout/cart', $data));
            }
        } else {
            $data['text_error'] = $this->language->get('text_empty');
            $data['text_error_2'] = $this->language->get('text_empty_2');
            $data['hide_icon'] = 1;

            $data['continue'] = $this->url->link('common/home');

            unset($this->session->data['success']);


                 $data['mono_checkout_button'] = $this->config->get('module_mono_checkout_cart_show') ?  str_replace("\n", '',$this->load->controller('extension/module/mono_checkout/getButton', 'cart_page')) : false;
                 $data['module_mono_checkout_cart_elem'] = $this->config->get('module_mono_checkout_cart_elem') ? $this->config->get('module_mono_checkout_cart_elem') : '.buttons .pull-right .btn-primary';
            
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');

            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');


            
			$this->response->setOutput($this->load->view('octemplates/checkout/cart_empty', $data));
			
        }
    }

    public function add() {
        $this->load->language('checkout/cart');

        $json = array();

        if (isset($this->request->post['product_id'])) {
            $product_id = (int)$this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            if (isset($this->request->post['quantity'])) {
                $quantity = (int)$this->request->post['quantity'];
            } else {
                $quantity = 1;
            }

            if (isset($this->request->post['option'])) {
                $option = array_filter($this->request->post['option']);
            } else {
                $option = array();
            }

            $product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);


	  $options = '';
	  
            foreach ($product_options as $product_option) {

	  	if (!empty($option[$product_option['product_option_id']]) && !is_array($option[$product_option['product_option_id']]) && is_numeric($option[$product_option['product_option_id']])) {
			$value_name = '';
			foreach ($product_option['product_option_value'] as $product_option_value) {
				if ($option[$product_option['product_option_id']] == $product_option_value['product_option_value_id']) {
					$value_name = $product_option_value['name'];
				}
			}
			$options .= $product_option['name'] . ':' . $value_name . ';';
	   }
	  
                if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                    $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
                }
            }


	  foreach ($option as $key => $val) {
		  if (!is_numeric($val) && !is_array($val)) {
			  $option_name = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN " . DB_PREFIX . "option_description od ON (po.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$key . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'")->row['name'];
			  $options .= $option_name . ':' . $val . ';';  
		  }
		  if (is_array($val)) {
		  	  $option_name = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN " . DB_PREFIX . "option_description od ON (po.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$key . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'")->row['name'];
			  foreach ($val as $opt_val) {  
				  $val_name = addslashes($this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$opt_val . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'")->row['name']);
				  $options .= $option_name . ':' . $val_name . ';'; 
			  } 
		  }
	  }
	  $options = rtrim($options, ';');
	  
            if (isset($this->request->post['recurring_id'])) {
                $recurring_id = $this->request->post['recurring_id'];
            } else {
                $recurring_id = 0;
            }

            $recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

            if ($recurrings) {
                $recurring_ids = array();

                foreach ($recurrings as $recurring) {
                    $recurring_ids[] = $recurring['recurring_id'];
                }

                if (!in_array($recurring_id, $recurring_ids)) {
                    $json['error']['recurring'] = $this->language->get('error_recurring_required');
                }
            }


			if ((!$product_info['quantity'] || ($product_info['quantity'] < $quantity)) && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				if	($product_info['quantity'] < 1) {
					$json['error']['error_warning'] = $this->language->get('error_no_stock');
				} else {
					$json['error']['error_warning'] = sprintf($this->language->get('error_limited_stock'), $product_info['quantity']);
				}
			}
			
            if (!$json) {
                $this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);

	    // remarketing all in one
		$this->load->model('tool/remarketing'); 
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$json['remarketing'] = $this->model_tool_remarketing->remarketingAddToCart($product_info, $quantity, !empty($options) ? $options : '', $option);
			$json['remarketing']['vcart'] = '511008826421513890285';
		}  
	  

                $json['success'] = sprintf($this->language->get('text_success'),
                    //$this->url->link('product/product', 'product_id=' . $this->request->post['product_id']),
                    $this->url->link('checkout/cart'),
                    $product_info['name'],
                    $this->url->link('checkout/cart')
                );

                // Unset all shipping and payment methods
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
                
			//unset($this->session->data['payment_method']);
			
                
			//unset($this->session->data['payment_methods']);
			

                // Totals
                $this->load->model('setting/extension');

                $totals = array();
                $taxes = $this->cart->getTaxes();
                $total = 0;

                // Because __call can not keep var references so we put them into an array.
                $total_data = array(
                    'totals' => &$totals,
                    'taxes'  => &$taxes,
                    'total'  => &$total
                );

                // Display prices
                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $sort_order = array();

                    $results = $this->model_setting_extension->getExtensions('total');

                    foreach ($results as $key => $value) {
                        $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                    }

                    array_multisort($sort_order, SORT_ASC, $results);

                    foreach ($results as $result) {
                        if ($this->config->get('total_' . $result['code'] . '_status')) {
                            $this->load->model('extension/total/' . $result['code']);

                            // We have to put the totals in an array so that they pass by reference.
                            $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                        }
                    }

                    $sort_order = array();

                    foreach ($totals as $key => $value) {
                        $sort_order[$key] = $value['sort_order'];
                    }

                    array_multisort($sort_order, SORT_ASC, $totals);
                }


                    $file = 'library/flowytracking/includes/add_to_cart.php';
                    $path_modification = DIR_MODIFICATION.'system/'.$file;
                    $path_temp = DIR_SYSTEM.$file;
                    require_once (is_file($path_modification) ? $path_modification : $path_temp);
				
                $json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));

			$json['oct_cart_ids'] = $this->load->controller('octemplates/events/helper/allCartProducts');
			$json['isPopup'] = ($this->config->get('theme_oct_showcase_popup_cart_status') && $this->config->get('theme_oct_showcase_isPopup')) ? 1 : 0;
			$json['total_products'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
			$json['total_amount'] = $this->currency->format($total, $this->session->data['currency']);

			} elseif (isset($json['error']['error_warning']) && $json['error']['error_warning']) {
				$json['error']['error_warning'];
			
            } else {
                $json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function edit() {
        $this->load->language('checkout/cart');

        $json = array();

        // Update
        if (!empty($this->request->post['quantity'])) {
            foreach ($this->request->post['quantity'] as $key => $value) {
                $this->cart->update($key, $value);
            }

            $this->session->data['success'] = $this->language->get('text_remove');

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            
			//unset($this->session->data['payment_method']);
			
            
			//unset($this->session->data['payment_methods']);
			
            unset($this->session->data['reward']);

            $this->response->redirect($this->url->link('checkout/cart'));
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function remove() {
        $this->load->language('checkout/cart');

        $json = array();

        // Remove

                    $file = 'library/flowytracking/includes/remove_from_cart.php';
                    $path_modification = DIR_MODIFICATION.'system/'.$file;
                    $path_temp = DIR_SYSTEM.$file;
                    require_once (is_file($path_modification) ? $path_modification : $path_temp);
                
        if (isset($this->request->post['key'])) {

		// remarketing all in one
		$this->load->model('tool/remarketing');
	    if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$this->load->model('catalog/product');
			$product_info = [];
			foreach ($this->cart->getProducts() as $product) {
				if ($product['cart_id'] == $this->request->post['key']) {
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);
					$product_info['price'] = $product['price'];
					$product_info['options'] = $product['option'];
					$quantity = $product['quantity'];
				} 
			}
		}
	  
            $this->cart->remove($this->request->post['key']);

	    if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$json['remarketing'] = $this->model_tool_remarketing->remarketingRemoveFromCart($product_info, $quantity);
		}
	  

            unset($this->session->data['vouchers'][$this->request->post['key']]);

            $json['success'] = $this->language->get('text_remove');

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            
			//unset($this->session->data['payment_method']);
			
            
			//unset($this->session->data['payment_methods']);
			
            unset($this->session->data['reward']);

            // Totals
            $this->load->model('setting/extension');

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes'  => &$taxes,
                'total'  => &$total
            );

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $sort_order = array();

                $results = $this->model_setting_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get('total_' . $result['code'] . '_status')) {
                        $this->load->model('extension/total/' . $result['code']);

                        // We have to put the totals in an array so that they pass by reference.
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }

                $sort_order = array();

                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $totals);
            }

            $json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));

			$json['oct_cart_ids'] = $this->load->controller('octemplates/events/helper/allCartProducts');
			$json['isPopup'] = ($this->config->get('theme_oct_showcase_popup_cart_status') && $this->config->get('theme_oct_showcase_isPopup')) ? 1 : 0;
			$json['total_products'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
			$json['total_amount'] = $this->currency->format($total, $this->session->data['currency']);
			
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
