<?php  
class ControllerExtensionModulePreOrder extends Controller {
	public function index() {
		$this->load->language('extension/module/preorder');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			if (!$this->validate()) {
				
				if (isset($this->request->post['product_id'])) {
					$data['product_id'] = (int)$this->request->post['product_id'];			
				} else {
					$data['product_id'] = 0;
				}
				
				if (isset($this->request->post['name'])) {
					$data['name'] = $this->request->post['name'];			
				} else {
					$data['name'] = '';
				}
				
				if (isset($this->request->post['email'])) {
					$data['email'] = $this->request->post['email'];			
				} else {
					$data['email'] = '';
				}
				
				if (isset($this->request->post['phone'])) {
					$data['phone'] = (isset($this->request->post['code']) ? $this->request->post['code'] : '') . $this->request->post['phone'];			
				} else {
					$data['phone'] = '';
				}
				
				if (isset($this->request->post['product_option'])) {
					$data['product_option'] = serialize(array_filter($this->request->post['product_option']));			
				} else {
					$data['product_option'] = '';
				}
				
				if ($this->customer->isLogged()) {
					$data['customer_id'] = $this->customer->getId();
				} else {
					$data['customer_id'] = 0;
				}
					
				$this->load->model('extension/module/preorder');

				$this->model_extension_module_preorder->addPreOrder($data);
				
				$json['success'] = $this->language->get('text_success');
			} else {
				$json['error'] = $this->validate();
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function form() {
		$this->load->language('extension/module/preorder');
		
		$description = $this->config->get('module_preorder_description');
		$language_id = $this->config->get('config_language_id');
		
		$json['text_title'] = $description[$language_id]['title'];
		$json['text_bottom'] = html_entity_decode($description[$language_id]['text_bottom'], ENT_QUOTES, 'UTF-8');
		$json['text_top'] = html_entity_decode($description[$language_id]['text_top'], ENT_QUOTES, 'UTF-8');
		$json['text_agree'] = html_entity_decode($description[$language_id]['text_agree'], ENT_QUOTES, 'UTF-8');
		
		$json['entry_name'] = $this->language->get('entry_name');
		$json['entry_email'] = $this->language->get('entry_email');
		$json['entry_phone'] = $this->language->get('entry_phone');
		$json['button_submit'] = $this->language->get('button_submit');
		
		$json['field_name'] = $this->config->get('module_preorder_name');
		$json['field_email'] = $this->config->get('module_preorder_email');
		$json['field_phone'] = $this->config->get('module_preorder_phone');
		$json['field_agree'] = $this->config->get('module_preorder_agree');
		
		$json['phone_mask'] = $this->config->get('module_preorder_phone_mask');
		
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');

			$data['position'] = isset($setting['position']) ? $setting['position'] : '';
			

		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {
			$json['product'] = $product_info['name'];
			
			$this->load->model('tool/image');
			
			if ($product_info['image']) {
				$json['image'] = $this->model_tool_image->resize($product_info['image'], 200, 200);
			} else {
				$json['image'] = $this->model_tool_image->resize('placeholder.png', 200, 200);
			}
			
			$json['href'] = $this->url->link('product/product', 'product_id=' . $product_id);
		
			if (isset($this->request->post['module_id'])) {
				$module_id = (int)$this->request->post['module_id'];
			} else {
				$module_id = '';
			}
			
			if (isset($this->request->post['option' . $module_id])) {
				$json['product_option'] = array_filter($this->request->post['option' . $module_id]);
			} else {
				$json['product_option'] = array();
			}
			
			if ($this->config->get('module_preorder_name')) {
				if (isset($this->session->data['preorder_customer_data']['name']) && $this->session->data['preorder_customer_data']['name']) {
					$json['name'] = $this->session->data['preorder_customer_data']['name'];
				} elseif ($this->customer->isLogged()) {
					$json['name'] = $this->customer->getFirstName();
				} else {
					$json['name'] = '';
				}
			}
			
			if ($this->config->get('module_preorder_email')) {
				if (isset($this->session->data['preorder_customer_data']['email']) && $this->session->data['preorder_customer_data']['email']) {
					$json['email'] = $this->session->data['preorder_customer_data']['email'];
				} elseif ($this->customer->isLogged()) {
					$json['email'] = $this->customer->getEmail();
				} else {
					$json['email'] = '';
				}
			}
			
			if ($this->config->get('module_preorder_phone')) {
				if (isset($this->session->data['preorder_customer_data']['phone']) && $this->session->data['preorder_customer_data']['phone']) {
					$json['phone'] = $this->session->data['preorder_customer_data']['phone'];
				} elseif ($this->customer->isLogged()) {
					$json['phone'] = $this->customer->getTelephone();
				} else {
					$json['phone'] = '';
				}
			
				$json['preorder_countries'] = array();
				
				if ($this->config->get('module_preorder_phone_mask') && $this->config->get('module_preorder_countries')) {
					$this->load->model('extension/module/preorder');
					
					foreach ($this->config->get('module_preorder_countries') as $country) {
						
						if ($country['image']) {
							$image = $this->model_tool_image->resize($country['image'], 16, 11);
						} else {
							$image = false;
						}
						
						if ($this->customer->isLogged() && isset($this->session->data['shipping_address']['country_id']) && $this->session->data['shipping_address']['country_id'] == $country['country_id']) {
							$customer_default = ' customer_default';
							
							if ($json['phone'] && (substr($json['phone'], 0, strlen($country['code'])) == $country['code'])) {
								$json['phone'] = substr($json['phone'], strlen($country['code']));
							} else {
								$json['phone'] = '';
							}
						} else {
							$customer_default = '';
						}
						
						if ($country['status']) {
							$json['preorder_countries'][] = array(
								'code' 	           => $country['code'],
								'mask' 	           => $country['mask'],
								'image'	  	       => $image,
								'name' 	           => $this->model_extension_module_preorder->getCountryName($country['country_id']),
								'customer_default' => $customer_default,
								'default'    	   => $country['default'] ? ' default' : '',
								'sort_order'       => $country['sort_order'],
							);
						}
					}
					
					$sort_order = array();
			
					foreach ($json['preorder_countries'] as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $json['preorder_countries']);
				}
			}
			
			// Captcha
			if ($this->config->get('module_preorder_captcha') && 'captcha_' . $this->config->get($this->config->get('module_preorder_captcha') . '_status')) {
				$json['captcha'] = $this->load->controller('extension/captcha/preorder/' . $this->config->get('module_preorder_captcha'));
			} else {
				$json['captcha'] = '';
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function cron() {
		if ($this->config->get('module_preorder_cron_status')) {
			$this->load->model('extension/module/preorder');
			$this->model_extension_module_preorder->editPreOrders();
		}
	}
	
	private function validate() {
		$error = false;
		
		if ($this->config->get('module_preorder_name') == 2 && ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['phone']) > 255))) {
			$error = $this->language->get('error_name');
		}
		
		if ($this->config->get('module_preorder_email') == 2 && ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL))) {
			$error = $this->language->get('error_email');
		}
		
		$countries = array();
		
		if ($this->config->get('module_preorder_countries')) {
			foreach ($this->config->get('module_preorder_countries') as $country) {
				if ($country['status']) {
					$countries[] = array(
						'code' => $country['code'],
						'mask' => $country['mask']
					);
				}
			}
		}
		
		if ($this->config->get('module_preorder_phone') == 2) {
			if ($this->config->get('module_preorder_phone_mask') && $countries) {
				
				$error_phone_mask = true;
				
				foreach ($countries as $country) {
					$country_code = isset($this->request->post['code']) ? $this->request->post['code'] : '';
					
					if (($country_code == $country['code']) && (utf8_strlen(str_replace('_', '', $this->request->post['phone'])) == utf8_strlen($country['mask']))) {
						$error_phone_mask = false;
						break;
					}
				}
				
				if ($error_phone_mask) {
					$error = $this->language->get('error_phone_mask');
				}
			} else {
				if (((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 32))) {
					$error = $this->language->get('error_phone');
				}
			}
		}

		// Captcha
		if ($this->config->get('module_preorder_captcha') && 'captcha_' . $this->config->get($this->config->get('module_preorder_captcha') . '_status')) {
			$captcha = $this->load->controller('extension/captcha/preorder/' . $this->config->get('module_preorder_captcha') . '/validate');

			if ($captcha) {
				$error = $captcha;
			}
		}
		
		if ($this->config->get('module_preorder_agree') && !isset($this->request->post['agree'])) {
			$error = $this->language->get('error_agree');		
		}
		
		return $error;
	}
	
	public function account() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('extension/module/preorder/account', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('extension/module/preorder');

		$this->document->setTitle($this->language->get('heading_preorder_title'));
		
		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_preorder_account'),
			'href' => $this->url->link('account/account', '', true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_preorder_title'),
			'href' => $this->url->link('extension/module/preorder/account', $url, true)
		);
		
		$data['field_name'] = $this->config->get('module_preorder_name');
		$data['field_email'] = $this->config->get('module_preorder_email');
		$data['field_phone'] = $this->config->get('module_preorder_phone');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['preorders'] = array();
		
		$this->load->model('tool/image');
		
		$this->load->model('extension/module/preorder');

		$preorder_total = $this->model_extension_module_preorder->getTotalPreOrders();

		$results = $this->model_extension_module_preorder->getPreOrders(($page - 1) * 10, 10);
		
		$language_id = $this->config->get('config_language_id');
		$date_format = $this->config->get('module_preorder_date_format');

		foreach ($results as $result) {
			
			$product_options = array();
			
			foreach ($this->model_extension_module_preorder->getProductOptions($result['product_id'], $this->config->get('config_language_id')) as $product_option) {
				$product_option_value_data = array();
				
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'name'                    => $product_option_value['name'],
						'quantity' 				  => $product_option_value['quantity']
					);
				}
				
				$product_options[] = array(
				    'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'name'                 => $product_option['name']
				);
			}

			if ($result['product_image']) {
				$product_image = $this->model_tool_image->resize($result['product_image'], 50, 50);
			} else {
				$product_image = $this->model_tool_image->resize('placeholder.png', 50, 50);
			}

			$data['preorders'][] = array(
				'preorder_id'     => $result['preorder_id'],
				'product_image'   => $product_image,
				'product_name'    => $result['product_name'],
				'product_options' => $product_options,
				'product_option'  => $this->model_extension_module_preorder->convertProductOptions(unserialize($result['product_option'])),
				'product_href'    => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				'status'          => $result['status'] ? $this->language->get('text_notified') : $this->language->get('text_waiting'),
				'name'            => $result['name'],
				'email'           => $result['email'],
				'phone'           => $result['phone'],
				'date_added'      => date($date_format[$language_id], strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $preorder_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('extension/module/preorder/account', 'page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($preorder_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($preorder_total - 10)) ? $preorder_total : ((($page - 1) * 10) + 10), $preorder_total, ceil($preorder_total / 10));

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/module/preorder/preorder_list', $data));
	}
}