<?php
class ControllerExtensionModulePreOrder extends Controller {
	private $error = array(); 
	
	public function index() {  
		$this->load->language('extension/module/preorder');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		$this->load->model('tool/image');
		
		$this->load->model('extension/module/preorder');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_preorder', $this->request->post);
			
			$this->model_extension_module_preorder->editSeoUrl($this->request->post['module_preorder_seo_url']);

			$this->session->data['success'] = $this->language->get('text_success');
			
			if ($this->request->post['module_preorder_apply']) {
				$this->response->redirect($this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'], true));
			}

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		
		$data = array();
		
		$data = $this->getList();
		
		$data['version'] = '2.0.1';
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['mail_admin_title'])) {
			$data['error_mail_admin_title'] = $this->error['mail_admin_title'];
		} else {
			$data['error_mail_admin_title'] = array();
		}
		
		if (isset($this->error['mail_admin_text'])) {
			$data['error_mail_admin_text'] = $this->error['mail_admin_text'];
		} else {
			$data['error_mail_admin_text'] = array();
		}
		
		if (isset($this->error['mail_registered_title'])) {
			$data['error_mail_registered_title'] = $this->error['mail_registered_title'];
		} else {
			$data['error_mail_registered_title'] = array();
		}
		
		if (isset($this->error['mail_registered_text'])) {
			$data['error_mail_registered_text'] = $this->error['mail_registered_text'];
		} else {
			$data['error_mail_registered_text'] = array();
		}
		
		if (isset($this->error['mail_guest_title'])) {
			$data['error_mail_guest_title'] = $this->error['mail_guest_title'];
		} else {
			$data['error_mail_guest_title'] = array();
		}
		
		if (isset($this->error['mail_guest_text'])) {
			$data['error_mail_guest_text'] = $this->error['mail_guest_text'];
		} else {
			$data['error_mail_guest_text'] = array();
		}
		
		if (isset($this->error['mail_out_sale_registered_title'])) {
			$data['error_mail_out_sale_registered_title'] = $this->error['mail_out_sale_registered_title'];
		} else {
			$data['error_mail_out_sale_registered_title'] = array();
		}
		
		if (isset($this->error['mail_out_sale_registered_text'])) {
			$data['error_mail_out_sale_registered_text'] = $this->error['mail_out_sale_registered_text'];
		} else {
			$data['error_mail_out_sale_registered_text'] = array();
		}
		
		if (isset($this->error['mail_out_sale_guest_title'])) {
			$data['error_mail_out_sale_guest_title'] = $this->error['mail_out_sale_guest_title'];
		} else {
			$data['error_mail_out_sale_guest_title'] = array();
		}
		
		if (isset($this->error['mail_out_sale_guest_text'])) {
			$data['error_mail_out_sale_guest_text'] = $this->error['mail_out_sale_guest_text'];
		} else {
			$data['error_mail_out_sale_guest_text'] = array();
		}
		
		if (isset($this->error['sms_registered_text'])) {
			$data['error_sms_registered_text'] = $this->error['sms_registered_text'];
		} else {
			$data['error_sms_registered_text'] = array();
		}
		
		if (isset($this->error['sms_guest_text'])) {
			$data['error_sms_guest_text'] = $this->error['sms_guest_text'];
		} else {
			$data['error_sms_guest_text'] = array();
		}
		
		if (isset($this->error['sms_out_sale_registered_text'])) {
			$data['error_sms_out_sale_registered_text'] = $this->error['sms_out_sale_registered_text'];
		} else {
			$data['error_sms_out_sale_registered_text'] = array();
		}
		
		if (isset($this->error['sms_out_sale_guest_text'])) {
			$data['error_sms_out_sale_guest_text'] = $this->error['sms_out_sale_guest_text'];
		} else {
			$data['error_sms_out_sale_guest_text'] = array();
		}
		
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
				
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		// General
		if (isset($this->request->post['module_preorder_mail_alert'])) {
			$data['module_preorder_mail_alert'] = $this->request->post['module_preorder_mail_alert'];
		} else {
			$data['module_preorder_mail_alert'] = $this->config->get('module_preorder_mail_alert');
		}
		
		if (isset($this->request->post['module_preorder_edit_product_alert'])) {
			$data['module_preorder_edit_product_alert'] = $this->request->post['module_preorder_edit_product_alert'];
		} else {
			$data['module_preorder_edit_product_alert'] = $this->config->get('module_preorder_edit_product_alert');
		}
		
		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['module_preorder_stock_statuses'])) {
			$data['module_preorder_stock_statuses'] = $this->request->post['module_preorder_stock_statuses'];
		} elseif ($this->config->get('module_preorder_stock_statuses')) {
			$data['module_preorder_stock_statuses'] = $this->config->get('module_preorder_stock_statuses');
		} else {
			$data['module_preorder_stock_statuses'] = array();
		}
		
		if (isset($this->request->post['module_preorder_out_sale_statuses'])) {
			$data['module_preorder_out_sale_statuses'] = $this->request->post['module_preorder_out_sale_statuses'];
		} elseif ($this->config->get('module_preorder_out_sale_statuses')) {
			$data['module_preorder_out_sale_statuses'] = $this->config->get('module_preorder_out_sale_statuses');
		} else {
			$data['module_preorder_out_sale_statuses'] = array();
		}
		
		if (isset($this->request->post['module_preorder_menu'])) {
			$data['module_preorder_menu'] = $this->request->post['module_preorder_menu'];
		} else {
			$data['module_preorder_menu'] = $this->config->get('module_preorder_menu');
		}
		
		if (isset($this->request->post['module_preorder_date_format'])) {
			$data['module_preorder_date_format'] = $this->request->post['module_preorder_date_format'];
		} elseif ($this->config->get('module_preorder_date_format')) {
			$data['module_preorder_date_format'] = $this->config->get('module_preorder_date_format');
		} else {
			$data['module_preorder_date_format'] = 'd.m.Y';
		}
		
		// Form
		if (isset($this->request->post['module_preorder_description'])) {
			$data['module_preorder_description'] = $this->request->post['module_preorder_description'];
		} else {
			$data['module_preorder_description'] = $this->config->get('module_preorder_description');
		}
		
		if (isset($this->request->post['module_preorder_name'])) {
			$data['module_preorder_name'] = $this->request->post['module_preorder_name'];
		} else {
			$data['module_preorder_name'] = $this->config->get('module_preorder_name');
		}
		
		if (isset($this->request->post['module_preorder_email'])) {
			$data['module_preorder_email'] = $this->request->post['module_preorder_email'];
		} else {
			$data['module_preorder_email'] = $this->config->get('module_preorder_email');
		}
		
		if (isset($this->request->post['module_preorder_phone'])) {
			$data['module_preorder_phone'] = $this->request->post['module_preorder_phone'];
		} else {
			$data['module_preorder_phone'] = $this->config->get('module_preorder_phone');
		}
		
		if (isset($this->request->post['module_preorder_agree'])) {
			$data['module_preorder_agree'] = $this->request->post['module_preorder_agree'];
		} else {
			$data['module_preorder_agree'] = $this->config->get('module_preorder_agree');
		}
		
		$data['captcha_list'] = array();
		
		$data['captcha_list'][] = array(
				'extension' => '0',
				'name'      => $this->language->get('text_disabled')
			);
		
		if ($this->config->get('captcha_basic_status')) {
			$data['captcha_list'][] = array(
				'extension' => 'basic',
				'name'      => $this->language->get('text_basic_captcha')
			);
		}
		
		if ($this->config->get('captcha_google_status')) {
			$data['captcha_list'][] = array(
				'extension' => 'google',
				'name'      => $this->language->get('text_google_captcha')
			);
		}
		
		if (isset($this->request->post['module_preorder_captcha'])) {
			$data['module_preorder_captcha'] = $this->request->post['module_preorder_captcha'];
		} else {
			$data['module_preorder_captcha'] = $this->config->get('module_preorder_captcha');
		}
		
		if (isset($this->request->post['module_preorder_phone_mask'])) {
			$data['module_preorder_phone_mask'] = $this->request->post['module_preorder_phone_mask'];
		} else {
			$data['module_preorder_phone_mask'] = $this->config->get('module_preorder_phone_mask');
		}
				
		$data['flag'] = $this->model_tool_image->resize('no_image.png', 30, 30);
		
		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
		
		foreach ($data['countries'] as $key => $country) {
			$data['countries'][$key]['name'] = htmlspecialchars($country['name'], ENT_QUOTES);
		}
		
		if (isset($this->request->post['module_preorder_countries'])) {
			$data['module_preorder_countries'] = $this->request->post['module_preorder_countries'];
		} elseif ($this->config->get('module_preorder_countries')) {
			$data['module_preorder_countries'] = $this->config->get('module_preorder_countries');
		} else {
			$data['module_preorder_countries'] = array();
		}
		
		// Button
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['module_preorder_button'])) {
			$data['module_preorder_button'] = $this->request->post['module_preorder_button'];
		} elseif ($this->config->get('module_preorder_button')) {
			$data['module_preorder_button'] = $this->config->get('module_preorder_button');
		} else {
			$data['module_preorder_button'] = array();
		}
		
		// SMS
		if (isset($this->request->post['module_preorder_sms_status'])) {
			$data['module_preorder_sms_status'] = $this->request->post['module_preorder_sms_status'];
		} else {
			$data['module_preorder_sms_status'] = $this->config->get('module_preorder_sms_status');
		}
		
		if (isset($this->request->post['module_preorder_smsru_api_key'])) {
			$data['module_preorder_smsru_api_key'] = $this->request->post['module_preorder_smsru_api_key'];
		} else {
			$data['module_preorder_smsru_api_key'] = $this->config->get('module_preorder_smsru_api_key');
		}
		
		if (isset($this->request->post['module_preorder_smsru_sender'])) {
			$data['module_preorder_smsru_sender'] = $this->request->post['module_preorder_smsru_sender'];
		} else {
			$data['module_preorder_smsru_sender'] = $this->config->get('module_preorder_smsru_sender');
		}
		
		if (isset($this->request->post['module_preorder_turbosms_login'])) {
			$data['module_preorder_turbosms_login'] = $this->request->post['module_preorder_turbosms_login'];
		} else {
			$data['module_preorder_turbosms_login'] = $this->config->get('module_preorder_turbosms_login');
		}
		
		if (isset($this->request->post['module_preorder_turbosms_password'])) {
			$data['module_preorder_turbosms_password'] = $this->request->post['module_preorder_turbosms_password'];
		} else {
			$data['module_preorder_turbosms_password'] = $this->config->get('module_preorder_turbosms_password');
		}
		
		if (isset($this->request->post['module_preorder_turbosms_sender'])) {
			$data['module_preorder_turbosms_sender'] = $this->request->post['module_preorder_turbosms_sender'];
		} else {
			$data['module_preorder_turbosms_sender'] = $this->config->get('module_preorder_turbosms_sender');
		}
		
		// Cron
		if (isset($this->request->post['module_preorder_cron_status'])) {
			$data['module_preorder_cron_status'] = $this->request->post['module_preorder_cron_status'];
		} else {
			$data['module_preorder_cron_status'] = $this->config->get('module_preorder_cron_status');
		}
						
		if ($this->request->server['HTTPS']) {
			$server = HTTPS_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}
		
		$data['module_preorder_cron_path'] = $this->language->get('text_cron_path') . $server . 'index.php?route=extension/module/preorder/cron';
		
		// Alert
		if (isset($this->request->post['module_preorder_mail_admin'])) {
			$data['module_preorder_mail_admin'] = $this->request->post['module_preorder_mail_admin'];
		} else {
			$data['module_preorder_mail_admin'] = $this->config->get('module_preorder_mail_admin');
		}
		
		if (isset($this->request->post['module_preorder_mail_registered'])) {
			$data['module_preorder_mail_registered'] = $this->request->post['module_preorder_mail_registered'];
		} else {
			$data['module_preorder_mail_registered'] = $this->config->get('module_preorder_mail_registered');
		}
		
		if (isset($this->request->post['module_preorder_mail_guest'])) {
			$data['module_preorder_mail_guest'] = $this->request->post['module_preorder_mail_guest'];
		} else {
			$data['module_preorder_mail_guest'] = $this->config->get('module_preorder_mail_guest');
		}
		
		if (isset($this->request->post['module_preorder_mail_out_sale_registered'])) {
			$data['module_preorder_mail_out_sale_registered'] = $this->request->post['module_preorder_mail_out_sale_registered'];
		} else {
			$data['module_preorder_mail_out_sale_registered'] = $this->config->get('module_preorder_mail_out_sale_registered');
		}
		
		if (isset($this->request->post['module_preorder_mail_out_sale_guest'])) {
			$data['module_preorder_mail_out_sale_guest'] = $this->request->post['module_preorder_mail_out_sale_guest'];
		} else {
			$data['module_preorder_mail_out_sale_guest'] = $this->config->get('module_preorder_mail_out_sale_guest');
		}
		
		if (isset($this->request->post['module_preorder_sms_registered'])) {
			$data['module_preorder_sms_registered'] = $this->request->post['module_preorder_sms_registered'];
		} else {
			$data['module_preorder_sms_registered'] = $this->config->get('module_preorder_sms_registered');
		}
		
		if (isset($this->request->post['module_preorder_sms_guest'])) {
			$data['module_preorder_sms_guest'] = $this->request->post['module_preorder_sms_guest'];
		} else {
			$data['module_preorder_sms_guest'] = $this->config->get('module_preorder_sms_guest');
		}
		
		if (isset($this->request->post['module_preorder_sms_out_sale_registered'])) {
			$data['module_preorder_sms_out_sale_registered'] = $this->request->post['module_preorder_sms_out_sale_registered'];
		} else {
			$data['module_preorder_sms_out_sale_registered'] = $this->config->get('module_preorder_sms_out_sale_registered');
		}
		
		if (isset($this->request->post['module_preorder_sms_out_sale_guest'])) {
			$data['module_preorder_sms_out_sale_guest'] = $this->request->post['module_preorder_sms_out_sale_guest'];
		} else {
			$data['module_preorder_sms_out_sale_guest'] = $this->config->get('module_preorder_sms_out_sale_guest');
		}
		
		if (isset($this->request->post['module_preorder_mail_css'])) {
			$data['module_preorder_mail_css'] = $this->request->post['module_preorder_mail_css'];
		} else {
			$data['module_preorder_mail_css'] = $this->config->get('module_preorder_mail_css');
		}
		
		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		
		if (isset($this->request->post['module_preorder_seo_url'])) {
			$data['module_preorder_seo_url'] = $this->request->post['module_preorder_seo_url'];
		} else {
			$data['module_preorder_seo_url'] = $this->config->get('module_preorder_seo_url');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/preorder/preorder', $data));
	}
	
	public function delete() {
		$this->load->language('extension/module/preorder');
		$this->load->model('extension/module/preorder');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $preorder_id) {
				$this->model_extension_module_preorder->deletePreOrder($preorder_id);
			}
		
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$this->response->redirect($this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . $url, true));
	}
	
	public function getList() {
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'po.date_added';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
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

		$data['delete'] = $this->url->link('extension/module/preorder/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['preorders'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$preorder_total = $this->model_extension_module_preorder->getTotalPreOrders();
		$data['module_preorder_total'] = $preorder_total;
		
		$results = $this->model_extension_module_preorder->getPreOrders($filter_data);
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/option');

    	foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['product_image'])) {
				$product_image = $this->model_tool_image->resize($result['product_image'], 40, 40);
			} else {
				$product_image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			
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
	
			$data['preorders'][] = array(
				'preorder_id'		      => $result['preorder_id'],
				'product_id'		      => $result['product_id'],
				'product_image'           => $product_image,
				'product_name'		      => $result['product_name'],
				'product_options'		  => $product_options,
				'product_option'	      => $this->model_extension_module_preorder->convertProductOptions(unserialize($result['product_option'])),
				'product_edit'            => $this->url->link('catalog/product/edit', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'], true),
				'product_stock_status_id' => $result['product_stock_status_id'],
				'name'			 	      => $result['name'],
				'customer_edit'		      => $result['customer_id'] ? $this->url->link('customer/customer/edit', 'user_token=' . $this->session->data['user_token'] . '&customer_id=' . $result['customer_id'], true) : '',
				'email'          	      => $result['email'],
				'phone'          	      => $result['phone'],
				'status'			      => $result['status'],
				'quantity'			      => $result['quantity'],
				'date_added' 	 	      => $result['date_added']
			);
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_product_name'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . '&sort=product_name' . $url, true);
		$data['sort_name'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . '&sort=po.name' . $url, true);
		$data['sort_email'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . '&sort=po.email' . $url, true);
		$data['sort_phone'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . '&sort=po.phone' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . '&sort=po.date_added' . $url, true);
		$data['sort_status'] = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . '&sort=po.status' . $url, true);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$data['user_token'] = $this->session->data['user_token'];

		$pagination = new Pagination();
		$pagination->total = $preorder_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/preorder', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);
		
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($preorder_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($preorder_total - $this->config->get('config_limit_admin'))) ? $preorder_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $preorder_total, ceil($preorder_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $data;
	}
	
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/preorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function editPreOrder() {
		if (isset($this->request->get['preorder_id'])) {
			$this->load->language('extension/module/preorder');
			$this->load->model('extension/module/preorder');
			$preorder_info = $this->model_extension_module_preorder->getPreOrder($this->request->get['preorder_id']);
			
			if ($preorder_info) {
				$this->model_extension_module_preorder->editPreOrder($preorder_info);
				$this->session->data['success'] = $this->language->get('text_preorder_success');
			}
		}
	}
	
	public function editPreOrders() {
		$this->load->language('extension/module/preorder');
		$this->load->model('extension/module/preorder');
		$this->model_extension_module_preorder->editPreOrders();
		$this->session->data['success'] = $this->language->get('text_preorders_success');
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/preorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['module_preorder_mail_admin'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['mail_admin_title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['text']) < 1) {
				$this->error['mail_admin_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_mail_registered'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['mail_registered_title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['text']) < 1) {
				$this->error['mail_registered_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_mail_guest'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['mail_guest_title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['text']) < 1) {
				$this->error['mail_guest_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_mail_out_sale_registered'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['mail_out_sale_registered_title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['text']) < 1) {
				$this->error['mail_out_sale_registered_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_mail_out_sale_guest'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 255)) {
				$this->error['mail_out_sale_guest_title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['text']) < 1) {
				$this->error['mail_out_sale_guest_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_sms_registered'] as $language_id => $value) {
			if (utf8_strlen($value['text']) < 1) {
				$this->error['sms_registered_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_sms_guest'] as $language_id => $value) {
			if (utf8_strlen($value['text']) < 1) {
				$this->error['sms_guest_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_sms_out_sale_registered'] as $language_id => $value) {
			if (utf8_strlen($value['text']) < 1) {
				$this->error['sms_out_sale_registered_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		foreach ($this->request->post['module_preorder_sms_out_sale_guest'] as $language_id => $value) {
			if (utf8_strlen($value['text']) < 1) {
				$this->error['sms_out_sale_guest_text'][$language_id] = $this->language->get('error_text');
			}
		}
		
		if ($this->request->post['module_preorder_seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['module_preorder_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}						
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && $seo_url['query'] != 'account/preorder') {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
								
								break;
							}
						}
					}
				}
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
	
	public function install () {
		$this->load->model('extension/module/preorder');
		$this->model_extension_module_preorder->createDatabaseTables();
	}
}