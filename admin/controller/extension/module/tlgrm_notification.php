<?php
/*
@author	Artem Serbulenko
@link	http://cmsshop.com.ua
@link	https://opencartforum.com/profile/762296-bn174uk/
@email 	serfbots@gmail.com
*/  
class ControllerExtensionModuleTlgrmNotification extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('extension/module/tlgrm_notification');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting'); 

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_tlgrm_notification', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			if ($this->request->post['apply']) {
				$this->response->redirect($this->url->link('extension/module/tlgrm_notification', 'user_token=' . $this->session->data['user_token'], true));
			}
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));			
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true),
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/tlgrm_notification', 'user_token=' . $this->session->data['user_token'], true),
		);

		$data['action'] = $this->url->link('extension/module/tlgrm_notification', 'user_token=' . $this->session->data['user_token'], true);
		$data['downloadLog'] = $this->url->link('extension/module/tlgrm_notification/downloadLog', 'user_token=' . $this->session->data['user_token'], true);
		$data['clearLog'] = $this->url->link('extension/module/tlgrm_notification/clearLog', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data_mas = array(
			'id',
			'token',
			'send',
			'status',
			'log',
			'field_merger',
			'title_order',
			'title_shipping',
			'title_payment',
			'title_product',
			'title_simple',
			'separator_order',
			'separator_shipping',
			'separator_payment',
			'separator_product',
			'separator_simple',
			'status_comment',
			'new_order',
			'new_review',
			'new_customer',
			'contact_form',
			'new_order_status',
			'return_order',
			'customer_firstname',
			'customer_lastname',
			'customer_email',
			'customer_telephone',
			'review_name',
			'review_text',
			'review_rating',
			'review_product_name',
			'contact_name',
			'contact_email',
			'contact_comment',
			'return_order_id',
			'return_firstname',
			'return_lastname',
			'return_email',
			'return_telephone',
			'return_date_ordered',
			'return_product',
			'return_model',
			'return_quantity',
			'return_reason',
			'return_opened',
			'return_comment'
		);

		$data_mas_text = array(
			'order_id',
			'store_name',
			'store_url',
			'date_added',
			'firstname',
			'lastname',
			'email',
			'telephone',
			'comment',
			'total',
			'order_status',
			'customer_id',
			'payment_method',
			'shipping_method',
			'payment_firstname',
			'payment_lastname',
			'payment_company',
			'payment_address_1',
			'payment_address_2',
			'payment_postcode',
			'payment_city',
			'payment_zone',
			'payment_country',
			'shipping_firstname',
			'shipping_lastname',
			'shipping_company',
			'shipping_address_1',
			'shipping_address_2',
			'shipping_postcode',
			'shipping_city',
			'shipping_zone',
			'shipping_country',
			'product_name',
			'product_sku',
			'product_model',
			'product_id',
			'product_link',
			'product_quantity',
			'product_price',
			'product_total',
			'product_option',
			'product_upc',
			'product_ean',
			'product_jan',
			'product_isbn',
			'product_mpn',
			'product_location'
		);

		foreach ($data_mas as $key => $value) {
			if (isset($this->request->post['module_tlgrm_notification_'.$value])) {
				$data['module_tlgrm_notification_'.$value] = $this->request->post['module_tlgrm_notification_'.$value];
			} else {
				$data['module_tlgrm_notification_'.$value] = $this->config->get('module_tlgrm_notification_'.$value);
			}
		}

		foreach ($data_mas_text as $key => $value) {
			if (isset($this->request->post['module_tlgrm_notification_'.$value])) {
				$data['module_tlgrm_notification_'.$value] = $this->request->post['module_tlgrm_notification_'.$value];
			} else {
				$data['module_tlgrm_notification_'.$value] = $this->config->get('module_tlgrm_notification_'.$value);
			}
			if (isset($this->request->post['module_tlgrm_notification_text_'.$value])) {
				$data['module_tlgrm_notification_text_'.$value] = $this->request->post['module_tlgrm_notification_text_'.$value];
			} else {
				$data['module_tlgrm_notification_text_'.$value] = $this->config->get('module_tlgrm_notification_text_'.$value);
			}
			if (isset($this->request->post['module_tlgrm_notification_sort_'.$value])) {
				$data['module_tlgrm_notification_sort_'.$value] = $this->request->post['module_tlgrm_notification_sort_'.$value];
			} else {
				$data['module_tlgrm_notification_sort_'.$value] = $this->config->get('module_tlgrm_notification_sort_'.$value);
			}
		}

		$settings = json_decode($this->config->get('simple_settings'), true);
		$result = array();

		if (!empty($settings['fields'])) {
		    foreach ($settings['fields'] as $fieldSettings) {
		        if ($fieldSettings['custom']) {
		            $result[$fieldSettings['id']] = $fieldSettings;
		        }
		    }
		    foreach ($result as $key => $value) {
		    	$lang_code = str_replace('-', '_', $this->config->get('config_language'));
		    	
				if (isset($this->request->post['module_tlgrm_notification_simple'][$value['id']])) {
					$data['module_tlgrm_notification_simple'][$value['id']] = $this->request->post['module_tlgrm_notification_simple'][$value['id']];
				} else if (isset($this->config->get('module_tlgrm_notification_simple')[$value['id']])) {
					$data['module_tlgrm_notification_simple'][$value['id']] = $this->config->get('module_tlgrm_notification_simple')[$value['id']];
				}else{
					$data['module_tlgrm_notification_simple'][$value['id']] = '';
				}
				if (isset($this->request->post['module_tlgrm_notification_text_simple'][$value['id']])) {
					$data['module_tlgrm_notification_text_simple'][$value['id']] = $this->request->post['module_tlgrm_notification_text_simple'][$value['id']];
				} else if (isset($this->config->get('module_tlgrm_notification_text_simple')[$value['id']])) {
					$data['module_tlgrm_notification_text_simple'][$value['id']] = $this->config->get('module_tlgrm_notification_text_simple')[$value['id']];
				}else{
					$data['module_tlgrm_notification_text_simple'][$value['id']] = '';
				}
				if (isset($this->request->post['module_tlgrm_notification_sort_simple'][$value['id']])) {
					$data['module_tlgrm_notification_sort_simple'][$value['id']] = $this->request->post['module_tlgrm_notification_sort_simple'][$value['id']];
				} else if (isset($this->config->get('module_tlgrm_notification_sort_simple')[$value['id']])) {
					$data['module_tlgrm_notification_sort_simple'][$value['id']] = $this->config->get('module_tlgrm_notification_sort_simple')[$value['id']];
				}else{
					$data['module_tlgrm_notification_sort_simple'][$value['id']] = '';
				}
				$data['entry_'.$value['id']] = $value['label'][$lang_code];
			}
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$order_status_zero = array(
			'order_status_id' => 0,
			'name'			  => $this->language->get('text_order_status_zero'),
		);

		array_unshift($data['order_statuses'],$order_status_zero);

		foreach ($data['order_statuses'] as $order_status) {
			if (isset($this->request->post['module_tlgrm_notification_template_order_status'][$order_status['order_status_id']])) {
				$data['module_tlgrm_notification_template_order_status'][$order_status['order_status_id']] = $this->request->post['module_tlgrm_notification_template_order_status'][$order_status['order_status_id']];
			} else if (isset($this->config->get('module_tlgrm_notification_template_order_status')[$order_status['order_status_id']])) {
				$data['module_tlgrm_notification_template_order_status'][$order_status['order_status_id']] = $this->config->get('module_tlgrm_notification_template_order_status')[$order_status['order_status_id']];
			} else {
				$data['module_tlgrm_notification_template_order_status'][$order_status['order_status_id']] = '';
			}
		}

		$data['send_test'] = $this->url->link('extension/module/tlgrm_notification/sendTest', 'user_token=' . $this->session->data['user_token'], true);

		$log = $this->log();
		$data['log'] = $log['log'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/tlgrm_notification', $data));
	}

	public function sendTest() {
		$this->load->language('extension/module/tlgrm_notification');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$link = 'https://api.telegram.org/bot';

    		$chat_ids = $this->request->post['id'];
    	    $sendToTelegram = $link . $this->request->post['tk'];

    	    if ($chat_ids) {
	  			$chat_ids = explode(",", $chat_ids);
		        foreach ($chat_ids as $chat_id) {
		            $chat_id = trim($chat_id);
					$params = array(
					    'chat_id' => $chat_id,
					    'text' => $this->language->get('text_send_test') . ' '. $this->request->server['HTTP_HOST'],
					    'parse_mode' =>'html'
					);
					$ch = curl_init($sendToTelegram . '/sendMessage');
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$result = curl_exec($ch);
					$log = new Log('telegram_notification.log');
					$log->write($chat_id . ' - ' . $result);
					curl_close($ch);
		        }
			}
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput($result);
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/tlgrm_notification')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}	

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function log() {

		$data['log'] = '';

		$file = DIR_LOGS . 'telegram_notification.log';

		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}

		return $data;
	}

	public function downloadLog() {
		$this->load->language('extension/module/tlgrm_notification');

		$file = DIR_LOGS . 'telegram_notification.log';

		if (file_exists($file) && filesize($file) > 0) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename="' . $this->config->get('config_name') . '_' . date('Y-m-d_H-i-s', time()) . '_telegram_notification.log"');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		} else {
			$this->session->data['error'] = sprintf($this->language->get('error_warning'), basename($file), '0B');

			$this->response->redirect($this->url->link('extension/module/tlgrm_notification', 'user_token=' . $this->session->data['user_token'], true));
		}
	}
	
	public function clearLog() {
		$this->load->language('extension/module/tlgrm_notification');

		if (!$this->user->hasPermission('modify', 'extension/module/tlgrm_notification')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS . 'telegram_notification.log';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('extension/module/tlgrm_notification', 'user_token=' . $this->session->data['user_token'], true));
	}
}
?>