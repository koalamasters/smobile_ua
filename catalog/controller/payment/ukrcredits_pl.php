<?php
class ControllerPaymentUkrcreditsPl extends Controller {
	
    public function index() {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$data['ukrcredits_setting'] = $this->config->get($type.'ukrcredits_settings');
		$data['ukrcredits_pl_data'] = $this->config->get($type.'ukrcredits_pl_data'); 
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
		
		$data['text_f'] = $this->language->get('text_f');
		$data['text_i'] = $this->language->get('text_i');
		$data['text_o'] = $this->language->get('text_o');
		$data['text_bd'] = $this->language->get('text_bd');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_phoned'] = $this->language->get('text_phoned');
		$data['text_madr'] = $this->language->get('text_madr');
		$data['text_inn'] = $this->language->get('text_inn');
		$data['text_sp'] = $this->language->get('text_sp');
		$data['text_psp'] = $this->language->get('text_psp');
		$data['text_god'] = $this->language->get('text_god');
		$data['text_psp_dv'] = $this->language->get('text_psp_dv');
		$data['text_pkv'] = $this->language->get('text_pkv');
		$data['text_radr'] = $this->language->get('text_radr');
		$data['text_ladr'] = $this->language->get('text_ladr');
		$data['text_ind'] = $this->language->get('text_ind');
		$data['text_obr'] = $this->language->get('text_obr');
		$data['text_vuz'] = $this->language->get('text_vuz');
		$data['text_rab'] = $this->language->get('text_rab');
		$data['text_rabt'] = $this->language->get('text_rabt');
		$data['text_raba'] = $this->language->get('text_raba');
		$data['text_char'] = $this->language->get('text_char');
		$data['text_spol'] = $this->language->get('text_spol');
		$data['text_det'] = $this->language->get('text_det');
		$data['text_vdet'] = $this->language->get('text_vdet');
		$data['text_soj'] = $this->language->get('text_soj');
		$data['text_comentar'] = $this->language->get('text_comentar');
		$data['text_tfio'] = $this->language->get('text_tfio');
		$data['text_ttel'] = $this->language->get('text_ttel');
		$data['text_tsot']		 = $this->language->get('text_tsot');
		
		$data['text_success'] = $this->language->get('text_success_pl');
		$data['success'] = $this->url->link('checkout/success', '', 'SSL');	
		
        $partsCount = 24;
		foreach ($this->cart->getProducts() as $cart) {
			$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$cart['product_id'] . "'");
			if ($privat_query->row) {
				if ($privat_query->row['partscount_pl'] <= $partsCount && $privat_query->row['partscount_pl'] !=0) {
					$partsCount = (int)$privat_query->row['partscount_pl'];
				}
			}
		}
		if ($partsCount == 24) {
			$partsCount = $setting['pl_pq'];
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
        $data['action'] = $this->url->link('payment/ukrcredits_pl/senddatadeal', '', 'SSL');	
		
		$data['credit'] = array(
			'type' => $setting['pl_merchantType'],
			'name' => $this->language->get('text_title_'.mb_strtolower($setting['pl_merchantType'])),
			'partsCount' => $partsCount,
			'price' => $data['total'],
			'mounth' => $setting['pl_markup_custom_PL']
		);
		
		if (isset($this->session->data['ukrcredits_pl_sel'])) {
			$data['credit']['partsCountSel'] = $this->session->data['ukrcredits_pl_sel'];
		} else {
			$data['credit']['partsCountSel'] = '';
		}

		if (isset($this->session->data['panEnd'])) {
			$data['panEnd'] = $this->session->data['panEnd'];
		} else {
			$data['panEnd'] = '';
		}
		
		if (isset($this->session->data['pldata']['f'])) {
			$data['f'] = $this->session->data['pldata']['f'];
		} else {
			$data['f'] = '';
		}

		if (isset($this->session->data['pldata']['i'])) {
			$data['i'] = $this->session->data['pldata']['i'];
		} else {
			$data['i'] = '';
		}

		if (isset($this->session->data['pldata']['o'])) {
			$data['o'] = $this->session->data['pldata']['o'];
		} else {
			$data['o'] = '';
		}

		if (isset($this->session->data['pldata']['bd'])) {
			$data['bd'] = $this->session->data['pldata']['bd'];
		} else {
			$data['bd'] = '';
		}

		if (isset($this->session->data['pldata']['phone'])) {
			$data['phone'] = $this->session->data['pldata']['phone'];
		} else {
			$data['phone'] = '';
		}

		if (isset($this->session->data['pldata']['phoned'])) {
			$data['phoned'] = $this->session->data['pldata']['phoned'];
		} else {
			$data['phoned'] = '';
		}

		if (isset($this->session->data['pldata']['madr'])) {
			$data['madr'] = $this->session->data['pldata']['madr'];
		} else {
			$data['madr'] = '';
		}

		if (isset($this->session->data['pldata']['inn'])) {
			$data['inn'] = $this->session->data['pldata']['inn'];
		} else {
			$data['inn'] = '';
		}

		if (isset($this->session->data['pldata']['sp'])) {
			$data['sp'] = $this->session->data['pldata']['sp'];
		} else {
			$data['sp'] = '';
		}

		if (isset($this->session->data['pldata']['psp'])) {
			$data['psp'] = $this->session->data['pldata']['psp'];
		} else {
			$data['psp'] = '';
		}

		if (isset($this->session->data['pldata']['god'])) {
			$data['god'] = $this->session->data['pldata']['god'];
		} else {
			$data['god'] = '';
		}

		if (isset($this->session->data['pldata']['psp_dv'])) {
			$data['psp_dv'] = $this->session->data['pldata']['psp_dv'];
		} else {
			$data['psp_dv'] = '';
		}

		if (isset($this->session->data['pldata']['pkv'])) {
			$data['pkv'] = $this->session->data['pldata']['pkv'];
		} else {
			$data['pkv'] = '';
		}

		if (isset($this->session->data['pldata']['radr'])) {
			$data['radr'] = $this->session->data['pldata']['radr'];
		} else {
			$data['radr'] = '';
		}

		if (isset($this->session->data['pldata']['ladr'])) {
			$data['ladr'] = $this->session->data['pldata']['ladr'];
		} else {
			$data['ladr'] = '';
		}

		if (isset($this->session->data['pldata']['ind'])) {
			$data['ind'] = $this->session->data['pldata']['ind'];
		} else {
			$data['ind'] = '';
		}

		if (isset($this->session->data['pldata']['obr'])) {
			$data['obr'] = $this->session->data['pldata']['obr'];
		} else {
			$data['obr'] = '';
		}

		if (isset($this->session->data['pldata']['vuz'])) {
			$data['vuz'] = $this->session->data['pldata']['vuz'];
		} else {
			$data['vuz'] = '';
		}

		if (isset($this->session->data['pldata']['rab'])) {
			$data['rab'] = $this->session->data['pldata']['rab'];
		} else {
			$data['rab'] = '';
		}

		if (isset($this->session->data['pldata']['rabt'])) {
			$data['rabt'] = $this->session->data['pldata']['rabt'];
		} else {
			$data['rabt'] = '';
		}

		if (isset($this->session->data['pldata']['raba'])) {
			$data['raba'] = $this->session->data['pldata']['raba'];
		} else {
			$data['raba'] = '';
		}

		if (isset($this->session->data['pldata']['char'])) {
			$data['char'] = $this->session->data['pldata']['char'];
		} else {
			$data['char'] = '';
		}

		if (isset($this->session->data['pldata']['spol'])) {
			$data['spol'] = $this->session->data['pldata']['spol'];
		} else {
			$data['spol'] = '';
		}

		if (isset($this->session->data['pldata']['det'])) {
			$data['det'] = $this->session->data['pldata']['det'];
		} else {
			$data['det'] = '';
		}

		if (isset($this->session->data['pldata']['vdet'])) {
			$data['vdet'] = $this->session->data['pldata']['vdet'];
		} else {
			$data['vdet'] = '';
		}

		if (isset($this->session->data['pldata']['soj'])) {
			$data['soj'] = $this->session->data['pldata']['soj'];
		} else {
			$data['soj'] = '';
		}

		if (isset($this->session->data['pldata']['comentar'])) {
			$data['comentar'] = $this->session->data['pldata']['comentar'];
		} else {
			$data['comentar'] = '';
		}

		if (isset($this->session->data['pldata']['tfio'])) {
			$data['tfio'] = $this->session->data['pldata']['tfio'];
		} else {
			$data['tfio'] = '';
		}

		if (isset($this->session->data['pldata']['ttel'])) {
			$data['ttel'] = $this->session->data['pldata']['ttel'];
		} else {
			$data['ttel'] = '';
		}

		if (isset($this->session->data['pldata']['tsot'])) {
			$data['tsot'] = $this->session->data['pldata']['tsot'];
		} else {
			$data['tsot'] = '';
		}

		if (isset($this->session->data['pldata']['o'])) {
			$data['o'] = $this->session->data['pldata']['o'];
		} else {
			$data['o'] = '';
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
		$this->session->data['payment_method']['title'] = $this->language->get('text_title_pl');
		$this->session->data['payment_method']['code'] = 'ukrcredits_pl';
		setcookie('payment_method', 'ukrcredits_pl', time() + 60 * 60 * 24 * 30);
		$this->session->data['ukrcredits_pl_sel'] = $this->request->post['partsCount'];
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
			$shopId = $setting['pl_shop_id'];
			
			$shopPassword = $setting['pl_shop_password'];
			
			$data_deal['mPhone'] = str_replace(['+','(', ')', '-', ' '], '', $order_info['telephone']);
			if (substr($data_deal['mPhone'], 0, 1) == 0) {
			$data_deal['mPhone'] = '+38' . $data_deal['mPhone'];
			} else if (substr($data_deal['mPhone'], 0, 2) == 80) {
			$data_deal['mPhone'] = '+3' . $data_deal['mPhone'];
			} else {
			$data_deal['mPhone'] = '+' . $data_deal['mPhone'];	
			}
			
			$this->session->data['pldata'] = $this->request->post['pldata'];
			
			$data_deal['orderId'] = $this->generateOrderId($order_info['order_id']);
			
			$data_deal['eMailPartner'] = $this->config->get('config_email');

			$data_deal['orderTerm'] = $this->request->post['partsCount'];
			
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
			$i = 1;
			foreach ($totals as $total) {
				if (($total['code'] != 'sub_total') && ($total['code'] != 'total')) {
					if ($total['value'] > 0) {
						$data_deal['orderNom']['prod'.$i] = array(
							'brand' => utf8_substr(strip_tags(html_entity_decode(trim($total['title']), ENT_QUOTES, 'UTF-8')), 0, 128),
							'count' => 1,
							'price'    => (int)$this->currency->format($total['value'], 'UAH', '', false)
						);
						$sumtotal += $this->currency->format($total['value'], 'UAH', '', false);
					} else {
						$discount += abs($this->currency->format($total['value'], 'UAH', '', false));
					}
				}
				$i++;
			}

			$productquantity = $this->cart->countProducts();
			$minus = $discount / $productquantity;

            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], 'UAH', '', false) - $minus) <= 0) {
					$productquantity = $productquantity - $product['quantity'];
					$data_deal['orderNom']['prod'.$i] = array(
						'brand'     => utf8_substr(strip_tags(html_entity_decode(trim($product['name']), ENT_QUOTES, 'UTF-8')), 0, 128),
						'count' => $product['quantity'],
						'price'    => (int)$this->currency->format($product['price'], 'UAH', '', false)
					);
					$sumtotal += $this->currency->format($product['price'], 'UAH', '', false) * $product['quantity'];
				}
				$i++;
            }
			$minus = $discount / $productquantity;
            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], 'UAH', '', false) - $minus) > 0) {
					$data_deal['orderNom']['prod'.$i] = array(
						'brand'     => utf8_substr(strip_tags(html_entity_decode(trim($product['name']), ENT_QUOTES, 'UTF-8')), 0, 128),
						'count' => $product['quantity'],
						'price'    => (int)($this->currency->format($product['price'], 'UAH', '', false) - $minus)
					);
					$sumtotal += ($this->currency->format($product['price'], 'UAH', '', false) - $minus) * $product['quantity'];
				}
				$i++;
            }	
			
			$data_deal['orderSum'] = (int)$sumtotal * 100;
						
			$data_deal['callBackURL'] = $this->url->link('payment/ukrcredits_pl/callback', '', 'SSL');

			if (version_compare(phpversion(), '7.1', '>=')) {
				ini_set( 'precision', 16 );
				ini_set( 'serialize_precision', -1 ); 
			}
			
			if ($this->validate()) {

				$url = 'https://api.paylate.com.ua/gettoken.php?token='.$shopId;

				$request_token_array = $this->model_module_ukrcredits->asktokenPLget($url);

				if($request_token_array){

					if(isset($request_token_array['status']) && $request_token_array['status'] == 2) {

						$id_data = $this->config->get($type.'ukrcredits_pl_id_data');
					
						$url = 'https://api.paylate.com.ua/insert_data_json.php?token='.$request_token_array['token'].'&tarif=' . $id_data[$data_deal['orderTerm']-1];

						$pl_data_deal = $this->request->post['pldata'];
						$pl_data_deal['token'] = $request_token_array['token'];
						$pl_data_deal['ask'] = 'add';
						$pl_data_deal['tarif'] = $id_data[$data_deal['orderTerm']-1]; 
						$pl_data_deal['prod'] = $data_deal['orderNom'];

						$requestDial = json_encode($pl_data_deal);
						$responseResDeal = $this->model_module_ukrcredits->curlPostWithDataPL($url,$requestDial);

					} else {
						echo json_encode($request_token_array);
					}
					
					if(is_array($responseResDeal)){
						if(isset($responseResDeal['status']) && $responseResDeal['status'] == 2) {
							$paymenttype = 'PL';
							$comment = $this->language->get('text_status_IN_PROCESSING') . ($data_deal['orderTerm']-1) . ' ' . $this->language->get('text_mounth');
							$this->model_checkout_order->setUkrcreditsOrderId($order_info['order_id'], $paymenttype, $responseResDeal['id'], 'IN_PROCESSING');
							if (version_compare(VERSION,'2.0','>=')) {
								$this->model_checkout_order->addOrderHistory($order_info['order_id'], $setting['clientwait_status_id'], $comment);
							} else {
								$this->model_checkout_order->confirm($order_info['order_id'], $setting['clientwait_status_id'], $comment, $notify = true);
							}
							
						} elseif (isset($responseResDeal['data']) && $responseResDeal['data']) {
							$this->log->write('ukrcredits_pl получен отказ ' . $responseResDeal['data']);
						}
					}
					echo json_encode($responseResDeal);
					
				} else {
					$json['error']['token'] = $this->language->get('error_token');
					echo json_encode($json);
				}
			}
        }
    }
	
    public function validate() {
		
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$this->language->load($dir.'/ukrcredits'); 
		
        $json = array();
		
		if ((utf8_strlen($this->request->post['pldata']['f']) < 3) || (utf8_strlen($this->request->post['pldata']['f']) > 64)) {
			$json['error']['f'] = $this->language->get('error_f');
		}
		if ((utf8_strlen($this->request->post['pldata']['i']) < 3) || (utf8_strlen($this->request->post['pldata']['i']) > 64)) {
			$json['error']['i'] = $this->language->get('error_i');
		}
		if ((utf8_strlen($this->request->post['pldata']['o']) < 3) || (utf8_strlen($this->request->post['pldata']['o']) > 64)) {
			$json['error']['o'] = $this->language->get('error_o');
		}
		if (utf8_strlen($this->request->post['pldata']['inn']) != 10) {
			$json['error']['inn'] = $this->language->get('error_inn');
		}
		if (utf8_strlen($this->request->post['pldata']['phone']) != 13) {
			$json['error']['phone'] = $this->language->get('error_phone');
		}		
/*		
		if (utf8_strlen($this->request->post['pldata']['sp']) != 2) {
			$json['error']['sp'] = $this->language->get('error_sp');
		}
*/		

		if (!empty($json)) {
			$json['error']['all'] = $this->language->get('error_all');
			echo json_encode($json);
		} else {
			return true;
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
		
		$order_pl = $this->model_checkout_order->getOrderMb($requestArr['orderId']);

		$order_info = $this->model_checkout_order->getOrder($order_pl['order_id']);

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
                $this->log->write('ukrcredits_pl :: Статус не получен!  ORDER_ID:'.$order_id .' RECEIVED:'. $requestArr['signature']);
            } 
        }
    }
}