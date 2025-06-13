<?php
class ControllerPaymentUkrcreditsab extends Controller {
	
    public function index() {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$data['ukrcredits_setting'] = $this->config->get($type.'ukrcredits_settings');
        $this->language->load($dir.'/ukrcredits');
		$data['currency_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
		$data['currency_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_mounth'] = $this->language->get('text_mounth');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_payments'] = $this->language->get('text_payments');
		$data['text_per'] = $this->language->get('text_per');
		$data['text_total'] = $this->language->get('text_total');
		
		$data['text_panEnd'] = $this->language->get('text_panEnd');
		
		$data['text_success'] = $this->language->get('text_success_ab');
		$data['success'] = $this->url->link('checkout/success', '', 'SSL');	
		
        $partsCount = 24;
		foreach ($this->cart->getProducts() as $cart) {
			$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$cart['product_id'] . "'");
			if ($privat_query->row) {
				if ($privat_query->row['partscount_ab'] <= $partsCount && $privat_query->row['partscount_ab'] !=0) {
					$partsCount = (int)$privat_query->row['partscount_ab'];
				}
			}
		}
		if ($partsCount == 24) {
			$partsCount = $setting['ab_pq'];
		}
		
		$this->load->model('module/ukrcredits');
		if (!$this->model_module_ukrcredits->checklicense()) {
			return false;
		}
				
		if (version_compare(VERSION, '3.0', '>=')) {
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
		} else if (version_compare(VERSION, '2.3', '>=')) {
			// Totals
			$this->load->model('extension/extension');

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

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}
		} else if (version_compare(VERSION, '2.0', '>=')) {
			// Totals
			$this->load->model('extension/extension');
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			
			if(version_compare( VERSION, '2.2.0.0', '>=' )) {
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);
			}
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();
					$results = $this->model_extension_extension->getExtensions('total');
					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}
					array_multisort($sort_order, SORT_ASC, $results);
					foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
							if(version_compare( VERSION, '2.2.0.0', '>=' )) {
							$this->{'model_total_' . $result['code']}->getTotal($total_data);
						} else {
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
					}
				}
				$sort_order = array();
				if(version_compare( VERSION, '2.2.0.0', '>=' )) {
					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
					array_multisort($sort_order, SORT_ASC, $totals);
				} else {
					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
					array_multisort($sort_order, SORT_ASC, $total_data);
					$totals = $total_data; 
				}
			}			
		} else {
			// Totals
			$this->load->model('setting/extension');
			
			$total_data = array();					
			$total = 0;
			$taxes = $this->cart->getTaxes();
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array(); 
				
				$results = $this->model_setting_extension->getExtensions('total');
				
				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}
				
				array_multisort($sort_order, SORT_ASC, $results);
				
				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
			
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
					
					$sort_order = array(); 
				  
					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}
		
					array_multisort($sort_order, SORT_ASC, $total_data);
				}		
			}
		}

		$replace_array = array($this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));
		$data['total'] = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($total, $this->config->get('tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']));
        $data['action'] = $this->url->link('payment/ukrcredits_ab/senddatadeal', '', 'SSL');	
		
		$data['credit'] = array(
			'type' => $setting['ab_merchantType'],
			'name' => $this->language->get('text_title_'.mb_strtolower($setting['ab_merchantType'])),
			'partsCount' => $partsCount,
			'price' => $data['total'],
			'mounth' => $setting['ab_markup_custom_AB']
		);
		
		if (isset($this->session->data['ukrcredits_ab_sel'])) {
			$data['credit']['partsCountSel'] = $this->session->data['ukrcredits_ab_sel'];
		} else {
			$data['credit']['partsCountSel'] = '';
		}

		if (isset($this->session->data['panEnd'])) {
			$data['panEnd'] = $this->session->data['panEnd'];
		} else {
			$data['panEnd'] = '';
		}
		
		$data['oc15'] = false;
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$template_engine = $this->registry->get('config')->get('template_engine');
			$template_directory = $this->registry->get('config')->get('template_directory');
			$this->registry->get('config')->set('template_engine', 'template');
			if (!file_exists(DIR_TEMPLATE . $template_directory . 'payment/ukrcredits' . '.tpl')) {
				$this->registry->get('config')->set('template_directory', 'default/template/');
			}
			$template = $this->load->view('payment/ukrcredits', $data);
			
			$this->registry->get('config')->set('template_engine', $template_engine);
			$this->registry->get('config')->set('template_directory', $template_directory);
			
			return $template;
		} else if (version_compare(VERSION,'2.2','>=')) {
			return $this->load->view('payment/ukrcredits', $data); 
		} else if (version_compare(VERSION,'2.0','>=')) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ukrcredits.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/payment/ukrcredits.tpl', $data);
			} else {
				return $this->load->view('default/template/payment/ukrcredits.tpl', $data);
			}
		} else {
			$data['oc15'] = true;
			$this->data = $data;
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ukrcredits.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/ukrcredits.tpl';
			} else {
				$this->template = 'default/template/payment/ukrcredits.tpl';
			}
			$this->render();			
		}
    }
    
	public function setUkrcreditsType(){
		$json = array();
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
		$this->language->load($dir.'/ukrcredits');
		$this->session->data['payment_method']['title'] = $this->language->get('text_title_ab');
		$this->session->data['payment_method']['code'] = 'ukrcredits_ab';
		setcookie('payment_method', 'ukrcredits_ab', time() + 60 * 60 * 24 * 30);
		$this->session->data['ukrcredits_ab_sel'] = $this->request->post['partsCount'];
        $json['success'] = TRUE;
 
		if ($this->request->get['route'] != 'checkout/checkout') {
           $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		$this->response->setOutput(json_encode($json));
	}

    private function generateOrderId($orderId,$length = 16){
      $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
      $numChars = strlen($chars);
      $string = '';
      for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
      }
      
      $stringRes = substr($string,0,(int)strlen($string)-(int)strlen('_'.$orderId)).'_'.$orderId;
      
      return $stringRes;
    }
	
    public function senddatadeal(){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
        $this->load->model('checkout/order');
		$this->load->model('module/ukrcredits');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($order_info) {
			$shopId = $setting['ab_shop_id'];
			
			$shopPassword = $setting['ab_shop_password'];
			
			$data_deal['mPhone'] = str_replace(['+','(', ')', '-', ' '], '', $order_info['telephone']);
			if (substr($data_deal['mPhone'], 0, 1) == 0) {
			$data_deal['mPhone'] = '+38' . $data_deal['mPhone'];
			} else if (substr($data_deal['mPhone'], 0, 2) == 80) {
			$data_deal['mPhone'] = '+3' . $data_deal['mPhone'];
			} else {
			$data_deal['mPhone'] = '+' . $data_deal['mPhone'];	
			}
			
			$this->session->data['panEnd'] = $this->request->post['panEnd'];
			
			$data_deal['panEnd'] = $this->request->post['panEnd'];
			
			$data_deal['orderId'] = $this->generateOrderId($order_info['order_id']);
			
			$data_deal['eMailPartner'] = $this->config->get('config_email');

			$data_deal['orderTerm'] = $this->request->post['partsCount']-1;
			
			$data_deal['orderNom'] = array();
			
			if (version_compare(VERSION, '3.0', '>=')) {
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
			} else if (version_compare(VERSION, '2.3', '>=')) {

				// Totals
				$this->load->model('extension/extension');

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

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('extension/total/' . $result['code']);

							$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}
			} else if (version_compare(VERSION, '2.0', '>=')) {
				// Totals
				$this->load->model('extension/extension');
				$total_data = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();
				
				if(version_compare( VERSION, '2.2.0.0', '>=' )) {
					$total_data = array(
						'totals' => &$totals,
						'taxes'  => &$taxes,
						'total'  => &$total
					);
				}
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array();
						$results = $this->model_extension_extension->getExtensions('total');
						foreach ($results as $key => $value) {
							$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
						}
						array_multisort($sort_order, SORT_ASC, $results);
						foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);
								if(version_compare( VERSION, '2.2.0.0', '>=' )) {
								$this->{'model_total_' . $result['code']}->getTotal($total_data);
							} else {
								$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
							}
						}
					}
					$sort_order = array();
					if(version_compare( VERSION, '2.2.0.0', '>=' )) {
						foreach ($totals as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
						array_multisort($sort_order, SORT_ASC, $totals);
					} else {
						foreach ($total_data as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
						array_multisort($sort_order, SORT_ASC, $total_data);
						$totals = $total_data; 
					}
				}			
			} else {
				// Totals
				$this->load->model('setting/extension');
				
				$total_data = array();					
				$total = 0;
				$taxes = $this->cart->getTaxes();
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array(); 
					
					$results = $this->model_setting_extension->getExtensions('total');
					
					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}
					
					array_multisort($sort_order, SORT_ASC, $results);
					
					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);
				
							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
						
						$sort_order = array(); 
					  
						foreach ($total_data as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}
			
						array_multisort($sort_order, SORT_ASC, $total_data);
					}		
				}
				$totals = $total_data;
			}


			$sumtotal =0;
			$discount = 0;

			foreach ($totals as $total) {
				if (($total['code'] != 'sub_total') && ($total['code'] != 'total')) {
					if ($total['value'] > 0) {
						$data_deal['orderNom'][] = array(
							'name' => utf8_substr(strip_tags(html_entity_decode(trim($total['title']), ENT_QUOTES, 'UTF-8')), 0, 128),
							'count' => 1,
							'sum'    => (int)$this->currency->format($total['value'], 'UAH', '', false) * 100
						);
						$sumtotal += $this->currency->format($total['value'], 'UAH', '', false);
					} else {
						$discount += abs($this->currency->format($total['value'], 'UAH', '', false));
					}
				}
			}

			$productquantity = $this->cart->countProducts();
			$minus = $discount / $productquantity;

            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], 'UAH', '', false) - $minus) <= 0) {
					$productquantity = $productquantity - $product['quantity'];
					$data_deal['orderNom'][] = array(
						'name'     => utf8_substr(strip_tags(html_entity_decode(trim($product['name']), ENT_QUOTES, 'UTF-8')), 0, 128),
						'count' => $product['quantity'],
						'sum'    => (int)$this->currency->format($product['price'], 'UAH', '', false) * 100
					);
					$sumtotal += $this->currency->format($product['price'], 'UAH', '', false) * $product['quantity'];
				}
            }
			$minus = $discount / $productquantity;
            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], 'UAH', '', false) - $minus) > 0) {
					$data_deal['orderNom'][] = array(
						'name'     => utf8_substr(strip_tags(html_entity_decode(trim($product['name']), ENT_QUOTES, 'UTF-8')), 0, 128),
						'count' => $product['quantity'],
						'sum'    => (int)($this->currency->format($product['price'], 'UAH', '', false) - $minus) * 100
					);
					$sumtotal += ($this->currency->format($product['price'], 'UAH', '', false) - $minus) * $product['quantity'];
				}
            }	
			
			$data_deal['orderSum'] = (int)$sumtotal * 100;
						
			$data_deal['callBackURL'] = $this->url->link('payment/ukrcredits_ab/callback', '', 'SSL');;

			if (version_compare(phpversion(), '7.1', '>=')) {
				ini_set( 'precision', 16 );
				ini_set( 'serialize_precision', -1 ); 
			}

			$requestDial = json_encode($data_deal);
	
			$url = 'https://' . ($setting['ab_mode']?'':'retail') . 'api.sensebank.' . ($setting['ab_mode']?'kyiv':'com') . '.ua:8243/api/PartnerInstallment/v1.0/createOrder/'.$shopId;

			$responseResDeal = $this->model_module_ukrcredits->curlPostWithDataAB($url,$requestDial,$shopId,$shopPassword);
			
			if(is_array($responseResDeal)){
				if(isset($responseResDeal['orderId']) && $responseResDeal['orderId'] && $responseResDeal['orderId'] !='null') {
					$paymenttype = 'AB';
					$comment = $this->language->get('text_status_IN_PROCESSING') . ($data_deal['orderTerm']) . ' ' . $this->language->get('text_mounth');
					$this->model_checkout_order->setUkrcreditsOrderId($order_info['order_id'], $paymenttype, $responseResDeal['orderId'], 'IN_PROCESSING');
					if (version_compare(VERSION,'2.0','>=')) {
						$this->model_checkout_order->addOrderHistory($order_info['order_id'], $setting['clientwait_status_id'], $comment);
					} else {
						$this->model_checkout_order->confirm($order_info['order_id'], $setting['clientwait_status_id'], $comment, $notify = true);
					}
					
				} elseif (isset($responseResDeal['statusText']) && $responseResDeal['statusText']) {
					$this->log->write('ukrcredits_ab получен отказ ' . $responseResDeal['statusText']);
				}
			}
			echo json_encode($responseResDeal);
        }
    }

    public function callback() {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$this->language->load($dir.'/ukrcredits'); 
        $requestPostRaw = file_get_contents('php://input');        
        $requestArr = json_decode(trim($requestPostRaw),true);

        $this->load->model('checkout/order');
		
		$order_ab = $this->model_checkout_order->getOrderMb($requestArr['orderId']);

		$order_info = $this->model_checkout_order->getOrder($order_ab['order_id']);

        if ($order_info) {        
            if ($requestArr['statusCode']) {
			
				if ($requestArr['statusCode'] == 'PURCHASE_IS_OK') {
					$order_status_id = $setting['completed_status_id'];
				} else
				
				if ($requestArr['statusCode'] == 'PRE_PURCHASE_IS_OK') {
					$order_status_id = $setting['created_status_id'];
				} else
				
				if ($requestArr['statusCode'] == 'CLIENT_NO_SEND_SMS') {
					$order_status_id = $setting['canceled_status_id'];
				} else
				
				if ($requestArr['statusCode'] == 'LOW_BALANCE' || $requestArr['statusCode'] == 'INST_ALLOWED_FAIL') {
					$order_status_id = $setting['rejected_status_id'];
				} else

				{
					$order_status_id = $setting['failed_status_id'];
				}				
		
				$comment = $requestArr['statusText'];
				
				$this->model_checkout_order->updateUkrcreditsOrderPrivat($order_info['order_id'], $requestArr['statusCode']);
				if (version_compare(VERSION,'2.0','>=')) {
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $order_status_id, $comment);
				} else {
					$this->model_checkout_order->update($order_info['order_id'], $order_status_id, $comment, $notify = true);
				}                
                
            } else {
                $this->log->write('ukrcredits_ab :: Статус не получен!  ORDER_ID:'.$order_id .' RECEIVED:'. $requestArr['signature']);
            } 
        }
    }
}