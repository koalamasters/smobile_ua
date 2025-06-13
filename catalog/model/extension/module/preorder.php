<?php
class ModelExtensionModulePreOrder extends Model {
	public function addPreOrder($data) {
		if ($this->request->server['HTTPS']) {
			$store_url = $this->config->get('config_ssl');
		} else {
			$store_url = $this->config->get('config_url');
		}
						
		$product_info = $this->getProduct($data['product_id'], $this->config->get('config_language_id'));
		
		if ($product_info) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "preorder SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', phone = '" . $this->db->escape($data['phone']) . "', product_id = '" . (int)$data['product_id'] . "', product_option = '" . $this->db->escape($data['product_option']) . "', language_id = '" . (int)$this->config->get('config_language_id') . "', store_name = '" . $this->db->escape($this->config->get('config_name')) . "', store_url = '" . $this->db->escape($store_url) . "', customer_id = '" . (int)$data['customer_id'] . "', status = '0', date_added = NOW()");
			
			$preorder_id = $this->db->getLastId();
			
			$this->session->data['preorder_customer_data']['name'] = $data['name'];
			$this->session->data['preorder_customer_data']['email'] = $data['email'];
			$this->session->data['preorder_customer_data']['phone'] = $data['phone'];
			
			// E-mail
			if ($this->config->get('module_preorder_mail_alert')) {
				$language_id = $this->config->get('config_language_id');
				$date_format = $this->config->get('module_preorder_date_format');
				
				$tag_value['preorder_id'] = $preorder_id;
				$tag_value['date_added'] = date($date_format[$language_id], strtotime(date('Y-m-d')));
				$tag_value['store_name'] = $this->config->get('config_name');
				$tag_value['store_logo'] = $store_url . 'image/' . $this->config->get('config_logo');
				$tag_value['store_url'] = $store_url;
				$tag_value['customer_id'] = $data['customer_id'];
				$tag_value['name'] = $data['name'];
				$tag_value['email'] = $data['email'];
				$tag_value['phone'] = $data['phone'];
				$tag_value['product_id'] = $data['product_id'];
				$tag_value['product_name'] = $product_info['name'];
				$tag_value['product_image'] = $product_info['image'];
				$tag_value['language_id'] = $this->config->get('config_language_id');

				if ($product_info['keyword']) {
					$tag_value['product_url'] = $store_url . $product_info['keyword'];
				} else {
					$tag_value['product_url'] = $store_url . 'index.php?route=product/product&product_id=' . $data['product_id'];
				}
				
				$data['product_option'] = $this->convertProductOptions(unserialize($data['product_option']));
				$tag_value['product_option'] = '';
				
				if ($data['product_option']) {
					
					foreach ($this->getProductOptions($data['product_id'], $this->config->get('config_language_id')) as $option) {
						if (isset($data['product_option'][$option['product_option_id']])) {
							$option_value_data = array();
							
							foreach ($option['product_option_value'] as $option_value) {
								
								$option_value_data[] = array(
									'product_option_value_id' => $option_value['product_option_value_id'],
									'name'                    => $option_value['name'],
									'quantity'                => $option_value['quantity'],
								);
							}
							
							foreach ($option_value_data as $option_value) {
								if (!is_array($data['product_option'][$option['product_option_id']])) {
									if ($data['product_option'][$option['product_option_id']] == $option_value['product_option_value_id']) {
										$tag_value['product_option'] .=  '<span class="option-name">' . $option['name'] . ':</span> <span class="option">' . $option_value['name'] . '</span><br>';
									}
								} else {
									foreach ($data['product_option'][$option['product_option_id']] as $value) {
										if ($value == $option_value['product_option_value_id']) {
											$tag_value['product_option'] .= '<span class="option-name">' . $option['name'] . ':</span> <span class="option">' . $option_value['name'] . '</span><br>';										
										}
									}					
								}
							}
						}
					}
				}
				
				$mail_admin = $this->config->get('module_preorder_mail_admin');
				
				$subject = strip_tags($this->replaceTag(html_entity_decode($mail_admin[$language_id]['title'], ENT_QUOTES, 'UTF-8'), $tag_value));
				
				$html['mail_css'] = $this->config->get('module_preorder_mail_css');
				$html['title'] = $subject;
				$html['text'] = $this->replaceTag(html_entity_decode($mail_admin[$language_id]['text'], ENT_QUOTES, 'UTF-8'), $tag_value);
				
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($this->load->view('extension/module/preorder/mail', $html));
				$mail->send();
				
				// Send to additional alert emails
				$emails = explode(',', $this->config->get('config_mail_alert_email'));
		
				foreach ($emails as $email) {
					if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$mail->setTo($email);
						$mail->send();
					}
				}
			}
		}
	}
	
	public function getCountryName($country_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "' AND status = '1'");

		if ($query->num_rows) {
			return $query->row['name'];
		} else {
			return 0;
		}
	}
	
	private function editPreOrder($data = array()) {
		$product_info = $this->getProduct($data['product_id'], $data['language_id']);
		
		if ($data && $product_info) {
			$submit = true;
			$data['product_option'] = $this->convertProductOptions(unserialize($data['product_option']));
			
			if ($this->config->get('module_preorder_out_sale_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
				$out_sale = true;
			} else {
				$out_sale = false;
				
				if ($product_info['quantity'] > 0) {
					if ($data['product_option']) {
						foreach ($this->getProductOptions($data['product_id'], $data['language_id']) as $option) {
							if (isset($data['product_option'][$option['product_option_id']])) {
								foreach ($option['product_option_value'] as $product_option_value) {
									if (!is_array($data['product_option'][$option['product_option_id']])) {
										if ($data['product_option'][$option['product_option_id']] == $product_option_value['product_option_value_id']) {
											if ($product_option_value['quantity'] <= 0) {
												$submit = false;
												break 2;
											}
										}
									} else {
										foreach ($data['product_option'][$option['product_option_id']] as $option_value) {
											if ($option_value == $product_option_value['product_option_value_id']) {
												if ($product_option_value['quantity'] <= 0) {
													$submit = false;
													break 3;
												}
											}
										}					
									}
								}
							}
						}
					}
				} else {
					$submit = false;
				}
			}
			
			if ($submit) {
				$this->db->query("UPDATE " . DB_PREFIX . "preorder SET status = '1' WHERE preorder_id = '" . (int)$data['preorder_id'] . "' AND status = '0'");
				
				$date_format = $this->config->get('module_preorder_date_format');
					
				$tag_value['preorder_id'] = $data['preorder_id'];
				$tag_value['date_added'] = date($date_format[$data['language_id']], strtotime($data['date_added']));
				$tag_value['store_name'] = $data['store_name'];
				$tag_value['store_logo'] = $data['store_url'] . 'image/' . $this->config->get('config_logo');
				$tag_value['store_url'] = $data['store_url'];
				$tag_value['customer_id'] = $data['customer_id'];
				$tag_value['name'] = $data['name'];
				$tag_value['email'] = $data['email'];
				$tag_value['phone'] = $data['phone'];
				$tag_value['product_id'] = $data['product_id'];
				$tag_value['product_name'] = $product_info['name'];
				$tag_value['product_image'] = $product_info['image'];
				
				if ($product_info['keyword']) {
					$tag_value['product_url'] = $data['store_url'] . $product_info['keyword'];
				} else {
					$tag_value['product_url'] = $data['store_url'] . 'index.php?route=product/product&product_id=' . $data['product_id'];
				}
				
				$tag_value['product_option'] = '';
				
				if ($data['product_option']) {
					foreach ($this->getProductOptions($data['product_id'], $data['language_id']) as $option) {
						if (isset($data['product_option'][$option['product_option_id']])) {
							$product_option_value_data = array();
							
							foreach ($option['product_option_value'] as $option_value) {
								
								$product_option_value_data[] = array(
									'product_option_value_id' => $option_value['product_option_value_id'],
									'name'                    => $option_value['name'],
								);
							}
							
							foreach ($product_option_value_data as $product_option_value) {
								if (!is_array($data['product_option'][$option['product_option_id']])) {
									if ($data['product_option'][$option['product_option_id']] == $product_option_value['product_option_value_id']) {
										$tag_value['product_option'] .=  '<span class="option-name">' . $option['name'] . ':</span>  <span class="option">' . $product_option_value['name'] . '</span><br>';
									}
								} else {
									foreach ($data['product_option'][$option['product_option_id']] as $option_value) {
										if ($option_value == $product_option_value['product_option_value_id']) {
											$tag_value['product_option'] .= '<span class="option-name">' . $option['name'] . ':</span>  <span class="option">' . $product_option_value['name'] . '</span><br>';										
										}
									}					
								}
							}
						}
					}
				}
				
				// Mail
				if ($data['email'] && $this->config->get('module_preorder_email')) {
					
					if ($out_sale) {
						$mail_customer = $data['customer_id'] ? $this->config->get('module_preorder_mail_out_sale_registered') : $this->config->get('module_preorder_mail_out_sale_guest');
					} else {
						$mail_customer = $data['customer_id'] ? $this->config->get('module_preorder_mail_registered') : $this->config->get('module_preorder_mail_guest');
					}
				
					$subject = strip_tags($this->replaceTag(html_entity_decode($mail_customer[$data['language_id']]['title'], ENT_QUOTES, 'UTF-8'), $tag_value));
					
					$html['mail_css'] = $this->config->get('module_preorder_mail_css');
					$html['title'] = $subject;
					$html['text'] = $this->replaceTag(html_entity_decode($mail_customer[$data['language_id']]['text'], ENT_QUOTES, 'UTF-8'), $tag_value);
					
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($data['email']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender(html_entity_decode($data['store_name'], ENT_QUOTES, 'UTF-8'));
					$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
					$mail->setHtml($this->load->view('extension/module/preorder/mail', $html));
					$mail->send();
				}
				
				// SMS
				if ($this->config->get('module_preorder_sms_status') && $data['phone']) {
					if (($this->config->get('module_preorder_sms_status') == 'smsru') && $this->config->get('module_preorder_smsru_api_key') && $this->config->get('module_preorder_smsru_sender')) {
						$this->smsru($data, $tag_value);
					} elseif (($this->config->get('module_preorder_sms_status') == 'turbosms') && $this->config->get('module_preorder_turbosms_login') && $this->config->get('module_preorder_turbosms_password') && $this->config->get('module_preorder_turbosms_sender')) {
						$this->turbosms($data, $tag_value);
					}
				}
			}
		}
	}
	
	private function smsru($data, $tag_value) {
		$sms_customer = $data['customer_id'] ? $this->config->get('module_preorder_sms_registered') : $this->config->get('module_preorder_sms_guest');
		
		$param = array(
			"api_id"	 =>	$this->config->get('module_preorder_smsru_api_key'),
			"to"		 =>	$data['phone'],
			"text"		 =>	$this->replaceTag($sms_customer[$data['language_id']]['text'], $tag_value),
			"from"		 =>	$this->config->get('module_preorder_smsru_sender')
		);
					
		$ch = curl_init("http://sms.ru/sms/send");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	
	private function turbosms($data, $tag_value) {
		try {
			// Подключаемся к серверу   
			$client = new SoapClient('http://turbosms.in.ua/api/wsdl.html'); 

			// Данные авторизации   
			$auth = [
				'login'    => $this->config->get('module_preorder_turbosms_login'),   
				'password' => $this->config->get('module_preorder_turbosms_password')  
			];   

			// Авторизируемся на сервере   
			$result = $client->Auth($auth);       

			// Отправляем сообщение
			$sms_customer = $data['customer_id'] ? $this->config->get('module_preorder_sms_registered') : $this->config->get('module_preorder_sms_guest');
			$sms = [   
				'sender'      => $this->config->get('module_preorder_turbosms_sender'),   
				'destination' => $data['phone'],   
				'text'        => $this->replaceTag($sms_customer[$data['language_id']]['text'], $tag_value)   
			];
			
			$client->SendSMS($sms);

		} catch(Exception $e) {  
			error_log($e->getMessage() . PHP_EOL);  
		} 
	}
	
	public function editPreOrders() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "preorder WHERE status = '0'");
		
		foreach ($query->rows as $result) {
			$this->editPreOrder($result);
		}
	}
	
	private function replaceTag($text, $tag_value) {
		$find = array(
			'{preorder_id}',
			'{date_added}',
			'{store_name}',
			'{store_logo}',
			'{store_url}',
			'{customer_id}',
			'{name}',
			'{email}',
			'{phone}',
			'{product_id}',
			'{product_name}',
			'{product_image}',
			'{product_url}',
			'{product_option}',
			'{account_preorder}'
		);
		
		$seo_url = $this->config->get('module_preorder_seo_url');
		
		if ($this->config->get('config_seo_url') && $seo_url[$tag_value['language_id']]) {
			$account_preorder = $seo_url[$tag_value['language_id']];
		} else {
			$account_preorder = 'index.php?route=account/preorder';
		}
		
		$this->load->model('tool/image');
		
		if ($tag_value['product_image']) {
			$product_image = $this->model_tool_image->resize($tag_value['product_image'], 100, 100);
		} else {
			$product_image = $this->model_tool_image->resize('placeholder.png', 100, 100);
		}

		$replace = array(
			'preorder_id' 		=> $tag_value['preorder_id'],
			'date_added' 		=> $tag_value['date_added'],
			'store_name' 		=> $tag_value['store_name'],
			'store_logo' 		=> '<img src="' . $tag_value['store_logo'] . '" alt="' . $tag_value['store_name'] . '"/>',
			'store_url' 		=> $tag_value['store_url'],
			'customer_id' 	    => $tag_value['customer_id'],
			'name'  			=> $tag_value['name'],
			'email'				=> $tag_value['email'],
			'phone' 			=> $tag_value['phone'],
			'product_id' 		=> $tag_value['product_id'],
			'product_name' 		=> $tag_value['product_name'],
			'product_image' 	=> '<img src="' . $product_image . '" alt="' . $tag_value['name'] . '"/>',
			'product_url' 		=> $tag_value['product_url'],
			'product_option' 	=> $tag_value['product_option'],
			'account_preorder' 	=> $tag_value['store_url'] . $account_preorder,
		);
		
		return str_replace($find, $replace, $text);
	}
	
	private function getProduct($product_id, $language_id) {
		$query = $this->db->query("SELECT DISTINCT pd.name, p.image, p.quantity, p.stock_status_id, (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = 'product_id=" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$language_id . "'");

		return $query->row;
	}
	
	public function getProductOptions($product_id, $language_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT po.product_option_id, od.name FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$language_id . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT pov.product_option_value_id, pov.option_value_id, pov.quantity, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON(pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON(pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$language_id . "' ORDER BY ov.sort_order ASC");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'name'                	  => $product_option_value['name']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'name'                 => $product_option['name']
			);
		}

		return $product_option_data;
	}
	
	public function convertProductOptions($product_option) {
		if ($product_option) {
			foreach ($product_option as $key => $option) {
				if (strpbrk($option, ',')) {
					$product_option[$key] = explode(',', $option);
				}
			}
			
			return $product_option;
		} else {
			return false;
		}
	}
	
	public function getPreOrders($start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 1;
		}
		
		$query = $this->db->query("SELECT po.preorder_id, po.product_id, po.name, po.email, po.phone, po.date_added, po.status, po.product_option, pd.name AS product_name, p.image AS product_image FROM " . DB_PREFIX . "preorder po LEFT JOIN " . DB_PREFIX . "product p ON (po.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (po.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND po.customer_id = '" . (int)$this->customer->getId() . "' AND po.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY po.preorder_id DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}
	
	public function getTotalPreOrders() {
		$query = $this->db->query("SELECT COUNT(DISTINCT preorder_id) AS total FROM " . DB_PREFIX . "preorder WHERE store_id = '" . (int)$this->config->get('config_store_id') . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
			
		return $query->row['total'];
	}
}