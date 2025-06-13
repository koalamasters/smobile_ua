<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . (int)$this->config->get('config_language_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");

		$customer_id = $this->db->getLastId();

       $salesagent_id = 0;
       if(isset($this->session->data['salesagent_id']) && $this->session->data['salesagent_id']) {
          $salesagent_id = $this->session->data['salesagent_id'];
       } else if(isset($data['salesagent_id']) && $data['salesagent_id']) {
          $salesagent_id = $data['salesagent_id'];
       } else if(isset($_COOKIE['scode'])) {
          $uniqueid = $_COOKIE['scode'];
          $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent s LEFT JOIN " . DB_PREFIX . "salesagent_store ss ON (s.salesagent_id = ss.salesagent_id) WHERE s.uniqueid = '".$this->db->escape($uniqueid)."' AND s.status = 1 AND ss.store_id = '" . (int)$this->config->get('config_store_id') . "'");
          if($query->num_rows) {
            $salesagent_id = $query->row['salesagent_id'];
          }
       } else if($this->config->get('salesagent_autostore')) {
          $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent s LEFT JOIN " . DB_PREFIX . "salesagent_store ss ON (s.salesagent_id = ss.salesagent_id) WHERE s.status = 1 AND ss.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY s.salesagent_id DESC");
          if($query->num_rows) {
            $salesagent_id = $query->row['salesagent_id'];
          }
       }
       if($salesagent_id) {
          $this->session->data['salesagent_id'] = $salesagent_id;
          $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_customer SET salesagent_id = '" . (int)$salesagent_id . "', customerid = '" . (int)$customer_id . "'");
             $this->load->model("extension/module/salesagent");
             $this->model_extension_module_salesagent->newSignUp($salesagent_id, $data['firstname'], $data['lastname'], $data['email'], $data['telephone']);
       }
        

			$send_ntf = $this->config->get('module_tlgrm_notification_status');
			$new_customer = $this->config->get('module_tlgrm_notification_new_customer');
			
			if ($send_ntf == 1 && $new_customer == 1) {
				$tlgrm_ntf_id = $this->config->get('module_tlgrm_notification_id');
				if (strlen($tlgrm_ntf_id) > 0) {

					$tlgrm_ntf = array(
						'firstname',
						'lastname',
						'email',
						'telephone',
					);

					foreach ($tlgrm_ntf as $key) {
						$tlgrm_ntf[$key] = $this->config->get('module_tlgrm_notification_customer_'.$key) || 0;
					}

					$this->load->language('extension/module/tlgrm_notification');
	
					$message = $this->language->get("text_customer") . ' ' . $_SERVER['HTTP_HOST'] . PHP_EOL;
					foreach ($data as $key => $value) {
						if (isset($tlgrm_ntf[$key])) {
				   			if ($tlgrm_ntf[$key] && !empty($data[$key])) {
				   				$message .= '<b>'. $this->language->get("text_customer_$key") .': </b>'. $data[$key] . PHP_EOL;
				   			}
				   		}
					}
					$this->load->model("extension/module/tlgrm_notification");
			        $this->model_extension_module_tlgrm_notification->SendMessage($message);
				}
			}
			

	    // remarketing all in one
		$this->load->model('tool/remarketing');
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
			if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'CompleteRegistration';
				$fb_time = time();
				$facebook_data['custom_data'] = [
					'status'   => true,
					'currency' => $this->config->get('remarketing_facebook_currency'),
					'value'    => 1
				];
				$facebook_data['time'] = $fb_time;
				$this->model_tool_remarketing->sendFacebook($facebook_data);
			}
			
			if ($this->config->get('remarketing_esputnik_status') && $customer_id) {
				if (isset($data['newsletter']) && $data['newsletter']) {
					$create_contact_url = 'https://esputnik.com/api/v1/contact/subscribe';
					$json_contact_value = new stdClass();
					$contact = new stdClass();
					$contact->firstName = $data['firstname'];
					$contact->lastName = $data['lastname'];
					$contact->contactKey = $customer_id;
					$contact->id = $customer_id;
					$contact->channels = [['type'=>'email', 'value' => $data['email']], ['type'=>'sms', 'value' => $data['telephone']]];
					$contact->groups = [['name'=>'Web Site']];
					$json_contact_value->contact = $contact;
					$json_contact_value->groups = ['Subscribers'];
					$this->model_tool_remarketing->sendEsputnik($json_contact_value, $create_contact_url);
				} else {
					$create_contact_url = 'https://esputnik.com/api/v1/contact';
					$contact = new stdClass();
					$contact->firstName = $data['firstname'];
					$contact->lastName = $data['lastname'];
					$contact->contactKey = $customer_id;
					$contact->id = $customer_id;
					$contact->channels = [['type'=>'email', 'value' => $data['email']],['type'=>'sms', 'value' => $data['telephone']]];
					$contact->groups = [['name'=>'Web Site']];
					$this->model_tool_remarketing->sendEsputnik($contact, $create_contact_url);
				}
			}
			$this->session->data['remarketing_register'] = true;
		}
		

		if ($customer_group_info['approval']) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_approval` SET customer_id = '" . (int)$customer_id . "', type = 'customer', date_added = NOW()");
		}
		
		return $customer_id;
	}

	public function editCustomer($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function editPassword($email, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function editAddressId($customer_id, $address_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
	public function editCode($email, $code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getCustomerByCode($code) {
		$query = $this->db->query("SELECT customer_id, firstname, lastname, email FROM `" . DB_PREFIX . "customer` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

		return $query->row;
	}

	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query->row;
	}
	
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}

	public function addTransaction($customer_id, $description, $amount = '', $order_id = 0) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$customer_id . "', order_id = '" . (float)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
	}

	public function deleteTransactionByOrderId($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
	}

	public function getTransactionTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row['total'];
	}
	
	public function getTotalTransactionsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}
	
	public function getRewardTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row['total'];
	}

	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}

	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

		if (!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
		}
	}

	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
	
	public function addAffiliate($customer_id, $data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_affiliate SET `customer_id` = '" . (int)$customer_id . "', `company` = '" . $this->db->escape($data['company']) . "', `website` = '" . $this->db->escape($data['website']) . "', `tracking` = '" . $this->db->escape(token(64)) . "', `commission` = '" . (float)$this->config->get('config_affiliate_commission') . "', `tax` = '" . $this->db->escape($data['tax']) . "', `payment` = '" . $this->db->escape($data['payment']) . "', `cheque` = '" . $this->db->escape($data['cheque']) . "', `paypal` = '" . $this->db->escape($data['paypal']) . "', `bank_name` = '" . $this->db->escape($data['bank_name']) . "', `bank_branch_number` = '" . $this->db->escape($data['bank_branch_number']) . "', `bank_swift_code` = '" . $this->db->escape($data['bank_swift_code']) . "', `bank_account_name` = '" . $this->db->escape($data['bank_account_name']) . "', `bank_account_number` = '" . $this->db->escape($data['bank_account_number']) . "', `status` = '" . (int)!$this->config->get('config_affiliate_approval') . "'");
		
		if ($this->config->get('config_affiliate_approval')) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_approval` SET customer_id = '" . (int)$customer_id . "', type = 'affiliate', date_added = NOW()");
		}		
	}
		
	public function editAffiliate($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_affiliate SET `company` = '" . $this->db->escape($data['company']) . "', `website` = '" . $this->db->escape($data['website']) . "', `commission` = '" . (float)$this->config->get('config_affiliate_commission') . "', `tax` = '" . $this->db->escape($data['tax']) . "', `payment` = '" . $this->db->escape($data['payment']) . "', `cheque` = '" . $this->db->escape($data['cheque']) . "', `paypal` = '" . $this->db->escape($data['paypal']) . "', `bank_name` = '" . $this->db->escape($data['bank_name']) . "', `bank_branch_number` = '" . $this->db->escape($data['bank_branch_number']) . "', `bank_swift_code` = '" . $this->db->escape($data['bank_swift_code']) . "', `bank_account_name` = '" . $this->db->escape($data['bank_account_name']) . "', `bank_account_number` = '" . $this->db->escape($data['bank_account_number']) . "' WHERE `customer_id` = '" . (int)$customer_id . "'");
	}
	
	public function getAffiliate($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_affiliate` WHERE `customer_id` = '" . (int)$customer_id . "'");

		return $query->row;
	}
	
	public function getAffiliateByTracking($tracking) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_affiliate` WHERE `tracking` = '" . $this->db->escape($tracking) . "'");

		return $query->row;
	}			
}