<?php
class ControllerExtensionModuleSalesagent extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');
		$this->model_extension_module_salesagent->createTable();
		$this->getList();
	}

	public function add() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_module_salesagent->addsalesagent($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_module_salesagent->editsalesagent($this->request->get['salesagent_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $salesagent_id) {
				$this->model_extension_module_salesagent->deletesalesagent($salesagent_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'firstname';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		$data['menu'] = $this->getMenu();

		$data['add'] = $this->url->link('extension/module/salesagent/add', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['delete'] = $this->url->link('extension/module/salesagent/delete', 'user_token=' . $this->session->data['user_token'], TRUE);
		
		$data['salesagents'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_email'             => $filter_email,
			'filter_status'            => $filter_status,
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$salesagent_total = $this->model_extension_module_salesagent->getTotalsalesagents($filter_data);

		$results = $this->model_extension_module_salesagent->getsalesagents($filter_data);

		foreach ($results as $result) {

			$data['salesagents'][] = array(
				'salesagent_id'    => $result['salesagent_id'],
				'name'           => $result['firstname']." ".$result['lastname'],
				'email'          => $result['email'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'           => $this->url->link('extension/module/salesagent/edit', 'user_token=' . $this->session->data['user_token'] . '&salesagent_id=' . $result['salesagent_id'] . $url, TRUE)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, TRUE);
		$data['sort_email'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . '&sort=c.email' . $url, TRUE);
		$data['sort_status'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . '&sort=c.status' . $url, TRUE);
		$data['sort_date_added'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . '&sort=c.date_added' . $url, TRUE);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $salesagent_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', TRUE);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($salesagent_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($salesagent_total - $this->config->get('config_limit_admin'))) ? $salesagent_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $salesagent_total, ceil($salesagent_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('user/user_group');

		$data['user_groups'] = $this->model_user_user_group->getUserGroups();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/salesagent_list', $data));
	}

	public function settings() {
		
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('text_settings'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['menu'] = $this->getMenu();

		$data['user_token'] = $this->session->data['user_token'];

		$data['salesagent_register'] = $this->config->get('salesagent_register');
		$data['salesagent_checkout'] = $this->config->get('salesagent_checkout');
		$data['salesagent_usergrouprestrictions'] = $this->config->get('salesagent_usergrouprestrictions');
		$data['salesagent_backend_checkout'] = $this->config->get('salesagent_backend_checkout');
		$data['salesagent_backend_orderedit'] = $this->config->get('salesagent_backend_orderedit');
		$data['salesagent_orderhistory'] = $this->config->get('salesagent_orderhistory');
		$data['salesagent_commissiontotal'] = $this->config->get('salesagent_commissiontotal');
		$data['salesagent_coupondiscount'] = $this->config->get('salesagent_coupondiscount');
		$data['salesagent_storecredit'] = $this->config->get('salesagent_storecredit');
		$data['salesagent_recurrsive'] = $this->config->get('salesagent_recurrsive');
		$data['salesagent_customershow'] = $this->config->get('salesagent_customershow');
		$data['salesagent_autostore'] = $this->config->get('salesagent_autostore');
		$data['salesagent_selecttype'] = $this->config->get('salesagent_selecttype');
		$data['salesagent_deleteorder'] = $this->config->get('salesagent_deleteorder');
		$data['salesagent_addorderhistory'] = $this->config->get('salesagent_addorderhistory');
		$data['salesagent_orderstatuspermission'] = $this->config->get('salesagent_orderstatuspermission');
		$data['salesagent_unpaid_color'] = $this->config->get('salesagent_unpaid_color');
		$data['salesagent_paid_color'] = $this->config->get('salesagent_paid_color');
		$data['salesagent_orderstatus_transactions'] = $this->config->get('salesagent_orderstatus_transactions');


		//codestart

		 $data['oc_licensing_home'] = 'https://www.cartbinder.com/store/'; $data['extension_id'] = 24895; $admin_support_email = 'support@cartbinder.com'; $data['license_purchase_thanks'] = sprintf($this->language->get('license_purchase_thanks'), $admin_support_email); if(isset($this->request->get['emailmal'])){ $data['emailmal'] = true; } if(isset($this->request->get['regerror'])){ if($this->request->get['regerror']=='emailmal'){ $this->error['warning'] = $this->language->get('regerror_email'); }elseif($this->request->get['regerror']=='orderidmal'){ $this->error['warning'] = $this->language->get('regerror_orderid'); }elseif($this->request->get['regerror']=='noreferer'){ $this->error['warning'] = $this->language->get('regerror_noreferer'); }elseif($this->request->get['regerror']=='localhost'){ $this->error['warning'] = $this->language->get('regerror_localhost'); }elseif($this->request->get['regerror']=='licensedupe'){ $this->error['warning'] = $this->language->get('regerror_licensedupe'); } } $domainssl = explode("//", HTTPS_SERVER); $domainnonssl = explode("//", HTTP_SERVER); $domain = ($domainssl[1] != '' ? $domainssl[1] : $domainnonssl[1]); $data['aurl'] = (HTTPS_SERVER !='' ? HTTPS_SERVER : HTTP_SERVER);$data['auri'] = (HTTPS_CATALOG !='' ? HTTPS_CATALOG : HTTP_CATALOG) . substr($_SERVER['REQUEST_URI'], 1); $data['domain'] = $domain; $data['licensed'] = @file_get_contents($data['oc_licensing_home'] . 'licensed.php?domain=' . $domain . '&extension=' . $data['extension_id']);
      if(!$data['licensed'] || $data['licensed'] == ''){ if(extension_loaded('curl')) { $post_data = array('domain' => $domain, 'extension' => $data['extension_id']); $curl = curl_init(); curl_setopt($curl, CURLOPT_HEADER, false); curl_setopt($curl, CURLINFO_HEADER_OUT, true); curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17'); $follow_allowed = ( ini_get('open_basedir') || ini_get('safe_mode')) ? false : true; if ($follow_allowed) { curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); } curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 9); curl_setopt($curl, CURLOPT_TIMEOUT, 60); curl_setopt($curl, CURLOPT_AUTOREFERER, true); curl_setopt($curl, CURLOPT_VERBOSE, 1); curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($curl, CURLOPT_FORBID_REUSE, false); curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); curl_setopt($curl, CURLOPT_URL, $data['oc_licensing_home'] . 'licensed.php'); curl_setopt($curl, CURLOPT_POST, true); curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data)); $data['licensed'] = curl_exec($curl); curl_close($curl); }else{ $data['licensed'] = 'curl'; } } $data['licensed_md5'] = md5($data['licensed']); $data['entry_free_support'] = $this->language->get('entry_free_support'); $order_details = @file_get_contents($data['oc_licensing_home'] . 'order_details.php?domain=' . $domain . '&extension=' . $data['extension_id']); $order_data = json_decode($order_details, true); if(!is_array($order_data) || $order_data == ''){ if(extension_loaded('curl')) { $post_data2 = array('domain' => $domain, 'extension' => $data['extension_id']); $curl2 = curl_init(); curl_setopt($curl2, CURLOPT_HEADER, false); curl_setopt($curl2, CURLINFO_HEADER_OUT, true); curl_setopt($curl2, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17'); $follow_allowed2 = ( ini_get('open_basedir') || ini_get('safe_mode')) ? false : true; if ($follow_allowed2) { curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, 1); } curl_setopt($curl2, CURLOPT_CONNECTTIMEOUT, 9); curl_setopt($curl2, CURLOPT_TIMEOUT, 60); curl_setopt($curl2, CURLOPT_AUTOREFERER, true); curl_setopt($curl2, CURLOPT_VERBOSE, 1); curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false); curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($curl2, CURLOPT_FORBID_REUSE, false); curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); curl_setopt($curl2, CURLOPT_URL, $data['oc_licensing_home'] . 'order_details.php'); curl_setopt($curl2, CURLOPT_POST, true); curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($post_data2)); $order_data = json_decode(curl_exec($curl2), true); curl_close($curl2); }else{ $order_data['status'] = 'disabled'; } } if(isset($order_data['status']) && $order_data['status'] == 'enabled'){ $isSecure = false; if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) { $isSecure = true; } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') { $isSecure = true; } $data['support_status'] = 'enabled'; $data['support_order_id'] = $order_data['order_id']; $data['support_extension_name'] = $order_data['extension_name']; $data['support_domain'] = $order_data['domain']; $data['support_username'] = $order_data['username']; $data['support_email'] = $order_data['email']; $data['support_registered_date'] = date('Y-m-d', $order_data['registered_date']); $data['support_order_date'] = date('Y-m-d', ($order_data['order_date'] + 31536000)); if((time() - $order_data['order_date']) > 31536000){ $data['text_free_support_remaining'] = sprintf($this->language->get('text_free_support_expired'), 1, ($isSecure ? 1 : 0), urlencode($domain) , $data['extension_id'] , $this->session->data['user_token']); }else{ $data['text_free_support_remaining'] = sprintf($this->language->get('text_free_support_remaining'), 366 - ceil((time() - $order_data['order_date']) / 86400)); } }else{ $data['support_status'] = 'disabled'; $data['text_free_support_remaining'] = sprintf($this->language->get('text_free_support_remaining'), 'unknown'); }

      //codeend

		if($this->user->getSalesAgentId()) {
			$this->response->redirect($this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] , TRUE));
		}

		$this->load->model('user/user_group');

		$data['user_groups'] = $this->model_user_user_group->getUserGroups();

		if(isset($this->request->get['debug'])) {
			$temp['salesagentdebug_status'] = $this->request->get['debug'];
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('salesagentdebug', $temp);
			$this->session->data['success'] = "Debuggin is On";
		}

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/salesagent_setting', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['salesagent_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->get['salesagent_id'])) {
			$data['salesagent_id'] = $this->request->get['salesagent_id'];
		} else {
			$data['salesagent_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		if (isset($this->request->get['salesagent_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$salesagent_info = $this->model_extension_module_salesagent->getsalesagent($this->request->get['salesagent_id']);
			if(!$salesagent_info) {
				unset($this->request->get['salesagent_id']);
			}
		}

		if (!isset($this->request->get['salesagent_id'])) {
			$data['action'] = $this->url->link('extension/module/salesagent/add', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);
		} else {
			$data['action'] = $this->url->link('extension/module/salesagent/edit', 'user_token=' . $this->session->data['user_token'] . '&salesagent_id=' . $this->request->get['salesagent_id'] . $url, TRUE);
		}

		$data['cancel'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);

		$data['users'] = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user`")->rows;

		if (isset($this->request->post['user_id'])) {
			$data['user_id'] = $this->request->post['user_id'];
		} elseif (!empty($salesagent_info)) {
			$data['user_id'] = $salesagent_info['user_id'];
		} else {
			$data['user_id'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($salesagent_info)) {
			$data['firstname'] = $salesagent_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($salesagent_info)) {
			$data['lastname'] = $salesagent_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['uniqueid'])) {
			$data['uniqueid'] = $this->request->post['uniqueid'];
		} elseif (!empty($salesagent_info)) {
			$data['uniqueid'] = $salesagent_info['uniqueid'];
		} else {
			$data['uniqueid'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($salesagent_info)) {
			$data['email'] = $salesagent_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($salesagent_info)) {
			$data['telephone'] = $salesagent_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} elseif (!empty($salesagent_info)) {
			$data['fax'] = $salesagent_info['fax'];
		} else {
			$data['fax'] = '';
		}

		if (isset($this->request->post['alertemail'])) {
			$data['alertemail'] = $this->request->post['alertemail'];
		} elseif (!empty($salesagent_info)) {
			$data['alertemail'] = $salesagent_info['alertemail'];
		} else {
			$data['alertemail'] = '1';
		}

		if (isset($this->request->post['commission'])) {
			$data['commission'] = $this->request->post['commission'];
		} elseif (!empty($salesagent_info)) {
			$data['commission'] = $salesagent_info['commission'];
		} else {
			$data['commission'] = 80;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($salesagent_info)) {
			$data['status'] = $salesagent_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($salesagent_info)) {
			$data['parent_id'] = $salesagent_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}

		if($data['parent_id']) {
			$data['parentname'] = $this->model_extension_module_salesagent->getsalesagentname($data['parent_id']);
		} else {
			$data['parentname'] = "";
		}

		if (isset($this->request->post['parent_commission'])) {
			$data['parent_commission'] = $this->request->post['parent_commission'];
		} elseif (!empty($salesagent_info)) {
			$data['parent_commission'] = $salesagent_info['parent_commission'];
		} else {
			$data['parent_commission'] = 0;
		}

		if($data['parent_id']) {
			$data['second_parentname'] = $this->model_extension_module_salesagent->getSecondParentName($data['parent_id']);
		} else {
			$data['second_parentname'] = "-";
		}

		if (isset($this->request->post['second_parent_commission'])) {
			$data['second_parent_commission'] = $this->request->post['second_parent_commission'];
		} elseif (!empty($salesagent_info)) {
			$data['second_parent_commission'] = $salesagent_info['second_parent_commission'];
		} else {
			$data['second_parent_commission'] = 0;
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($salesagent_info)) {
			$data['city'] = $salesagent_info['city'];
		} else {
			$data['city'] = "";
		}

		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (!empty($salesagent_info)) {
			$data['address'] = $salesagent_info['address'];
		} else {
			$data['address'] = "";
		}

		if (isset($this->request->post['clists'])) {
			$data['clists'] = $this->request->post['clists'];
		} elseif (!empty($salesagent_info)) {
			$data['clists'] = $this->model_extension_module_salesagent->getsalesagentclist($this->request->get['salesagent_id']);
		} else {
			$data['clists'] = array();
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

		if (isset($this->request->post['salesagent_store'])) {
			$data['salesagent_store'] = $this->request->post['salesagent_store'];
		} elseif (isset($this->request->get['salesagent_id'])) {
			$data['salesagent_store'] = $this->model_extension_module_salesagent->getAgentStores($this->request->get['salesagent_id']);
		} else {
			$data['salesagent_store'] = array(0);
		}

		if (isset($this->request->post['salesagent_customer_group'])) {
			$data['salesagent_customer_group'] = $this->request->post['salesagent_customer_group'];
		} elseif (isset($this->request->get['salesagent_id'])) {
			$data['salesagent_customer_group'] = $this->model_extension_module_salesagent->getAgentCustomerGroups($this->request->get['salesagent_id']);
		} else {
			$data['salesagent_customer_group'] = array(0);
		}
		
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$data['issalesagent'] =  $this->user->getSalesAgentId();
		$data['catalog'] =  HTTPS_CATALOG;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


        /* Додавання списку покупців */

        $data['entry_customer'] = $this->language->get('entry_customer');
        $data['text_pleaseselect'] = $this->language->get('text_select');

        $this->load->model('customer/customer');

        $customer_results = $this->model_customer_customer->getCustomers([
            'start' => 0,
            'limit' => 1000 // або скільки треба
        ]);

        $data['customers'] = [];

        foreach ($customer_results as $customer) {
            $data['customers'][] = [
                'customer_id' => $customer['customer_id'],
                'name'        => $customer['firstname'] . ' ' . $customer['lastname'] . ' (' . $customer['email'] . ')'
            ];
        }

        $data['customer_id'] = $salesagent_info['customer_id'] ?? 0;

        if ($data['customer_id']) {
            $this->load->model('customer/customer');
            $customer = $this->model_customer_customer->getCustomer($data['customer_id']);
            $data['customername'] = $customer ? $customer['firstname'] . ' ' . $customer['lastname'] . ' (' . $customer['email'] . ')' : '';
        } else {
            $data['customername'] = '';
        }

		$this->response->setOutput($this->load->view('extension/module/salesagent_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/salesagent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		$salesagent_info = $this->model_extension_module_salesagent->getsalesagentByEmail($this->request->post['email']);

		if (!isset($this->request->get['salesagent_id'])) {
			if ($salesagent_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($salesagent_info && ($this->request->get['salesagent_id'] != $salesagent_info['salesagent_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
			
			if ($this->request->get['salesagent_id'] == $this->request->post['parent_id']) {
				$this->error['warning'] = $this->language->get('error_same_parent');
			}
		}

		$this->request->post['uniqueid'] = preg_replace('/\s+/', '', $this->request->post['uniqueid']);
		$this->request->post['uniqueid'] = str_replace('&', '', $this->request->post['uniqueid']);
		$this->request->post['uniqueid'] = str_replace('?', '', $this->request->post['uniqueid']);
		$this->request->post['uniqueid'] = str_replace('%', '', $this->request->post['uniqueid']);
		if($this->request->post['uniqueid']) {
			$salesagent_unqid = $this->model_extension_module_salesagent->getsalesagentByUniqueid($this->request->post['uniqueid']);
			if (!isset($this->request->get['salesagent_id'])) {
				if ($salesagent_unqid) {
					$this->error['warning'] = $this->language->get('error_uniqueid_exists');
				}
			} else {
				if ($salesagent_unqid && ($this->request->get['salesagent_id'] != $salesagent_unqid['salesagent_id'])) {
					$this->error['warning'] = $this->language->get('error_uniqueid_exists');
				}
			}
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
		$tempclist = array();
		if(isset($this->request->post['clists'])) {
			foreach ($this->request->post['clists'] as $key => $value) {
				if(in_array($value['clist_id'], $tempclist)) {
					$this->error['warning'] = $this->language->get('error_clist');
				} else {
					$tempclist[] = $value['clist_id'];
				}
			}
		}
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/salesagent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}

			$this->load->model('extension/module/salesagent');

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_email' => $filter_email,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_extension_module_salesagent->getsalesagents($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'salesagent_id'     => $result['salesagent_id'],
					'parentname'		=> $this->model_extension_module_salesagent->getSecondParentName($result['salesagent_id']),
					'firstname'         => $result['firstname'],
					'lastname'          => $result['lastname'],
					'name'              => $result['firstname']." ".$result['lastname'],
					'email'             => $result['email'],
					'telephone'         => $result['telephone'],
					'fax'               => $result['fax']
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['firstname'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    public function autocomplete_custommer() {
        $json = [];

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('customer/customer');

            $filter_data = [
                'filter_name' => $this->request->get['filter_name'],
                'start'       => 0,
                'limit'       => 5
            ];

            $results = $this->model_customer_customer->getCustomers($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'customer_id' => $result['customer_id'],
                    'name'        => $result['firstname'] . ' ' . $result['lastname'] . ' (' . $result['email'] . ')'
                ];
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    public function savesettings() {
		$this->load->model('setting/setting');
		$temp['salesagent_installed'] =  1;
		$temp['salesagent_checkout'] =  $this->request->get['salesagent_checkout'];
		$temp['salesagent_backend_checkout'] =  $this->request->get['salesagent_backend_checkout'];
		$temp['salesagent_backend_orderedit'] =  $this->request->get['salesagent_backend_orderedit'];
		$temp['salesagent_selecttype'] =  $this->request->get['salesagent_selecttype'];
		$temp['salesagent_register'] =  $this->request->get['salesagent_register'];
		$temp['salesagent_orderhistory'] =  $this->request->get['salesagent_orderhistory'];
		$temp['salesagent_commissiontotal'] =  $this->request->get['salesagent_commissiontotal'];
		$temp['salesagent_coupondiscount'] =  $this->request->get['salesagent_coupondiscount'];
		$temp['salesagent_recurrsive'] =  $this->request->get['salesagent_recurrsive'];
		$temp['salesagent_customershow'] =  $this->request->get['salesagent_customershow'];
		$temp['salesagent_autostore'] =  $this->request->get['salesagent_autostore'];
		$temp['salesagent_deleteorder'] =  $this->request->get['salesagent_deleteorder'];
		$temp['salesagent_addorderhistory'] =  $this->request->get['salesagent_addorderhistory'];
		$temp['salesagent_orderstatuspermission'] =  isset($this->request->get['salesagent_orderstatuspermission'])?$this->request->get['salesagent_orderstatuspermission']:array();
		$temp['salesagent_orderstatus_transactions'] =  isset($this->request->get['salesagent_orderstatus_transactions'])?$this->request->get['salesagent_orderstatus_transactions']:array();
		$temp['salesagent_storecredit'] =  $this->request->get['salesagent_storecredit'];
		$temp['salesagent_unpaid_color'] =  $this->request->get['salesagent_unpaid_color'];
		$temp['salesagent_paid_color'] =  $this->request->get['salesagent_paid_color'];
		$temp['salesagent_usergrouprestrictions'] =  isset($this->request->get['salesagent_usergrouprestrictions'])?$this->request->get['salesagent_usergrouprestrictions']:array();
		
		if (!$this->user->hasPermission('modify', 'extension/module/salesagent')) {
			$json['error'] =   "No Permission to change settings. Only main admin can change this.";
		} else {
			$this->model_setting_setting->editSetting('salesagent', $temp);
			$json['success'] = "Settings has been saved";
		}
		$this->response->setOutput(json_encode($json));
	}

	public function salesagentclist() {
		
		$this->load->language('extension/module/salesagent');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/module/salesagent');
		$this->getCList();
	}

	public function addClist() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateClistForm()) {

			$this->model_extension_module_salesagent->addclist($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE));
		}

		$this->getClistForm();
	}

	public function editClist() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateClistForm()) {
			$this->model_extension_module_salesagent->editclist($this->request->get['clist_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE));
		}

		$this->getClistForm();
	}

	public function deleteClist() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/salesagent');

		if (isset($this->request->post['selected']) && $this->validateClistDelete()) {
			foreach ($this->request->post['selected'] as $clist_id) {
				$this->model_extension_module_salesagent->deleteclist($clist_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE));
		}

		$this->getCList();
	}

	protected function getCList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['menu'] = $this->getMenu();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		$data['add'] = $this->url->link('extension/module/salesagent/addClist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);
		$data['delete'] = $this->url->link('extension/module/salesagent/deleteClist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);
		$data['back'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);

		$data['salesagentclists'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$salesagentclist_total = $this->model_extension_module_salesagent->getTotalClist($filter_data);
		$results = $this->model_extension_module_salesagent->getclists($filter_data);

		foreach ($results as $result) {
			$data['salesagentclists'][] = array(
				'clist_id' => $result['clist_id'],
				'name'          => $result['name'],
				'edit'           => $this->url->link('extension/module/salesagent/editClist', 'user_token=' . $this->session->data['user_token'] . '&clist_id=' . $result['clist_id'] . $url, TRUE)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . '&sort=c.name' . $url, TRUE);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $salesagentclist_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', TRUE);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($salesagentclist_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($salesagentclist_total - $this->config->get('config_limit_admin'))) ? $salesagentclist_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $salesagentclist_total, ceil($salesagentclist_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['filter_name'] = $filter_name;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/salesagentclist_list', $data));
	}

	protected function getClistForm() {
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = !isset($this->request->get['clist_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		if (!isset($this->request->get['clist_id'])) {
			$data['action'] = $this->url->link('extension/module/salesagent/addClist', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);
		} else {
			$data['action'] = $this->url->link('extension/module/salesagent/editClist', 'user_token=' . $this->session->data['user_token'] . '&clist_id=' . $this->request->get['clist_id'] . $url, TRUE);
		}

		$data['cancel'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, TRUE);

		if (isset($this->request->get['clist_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$salesagentclist_info = $this->model_extension_module_salesagent->getclist($this->request->get['clist_id']);
		}

		if (isset($this->request->get['clist_id'])) {
			$data['clist_id'] = $this->request->get['clist_id'];
		} else {
			$data['clist_id'] =  0;
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($salesagentclist_info)) {
			$data['name'] = $salesagentclist_info['name'];
		} else {
			$data['name'] = "";
		}

		if (isset($this->request->post['products'])) {
	      $products = $this->request->post['products'];
	    } elseif (!empty($salesagentclist_info)) {
	      $products = json_decode($salesagentclist_info['product_id'],true);
	    } else {
	      $products = array();
	    }
	    $this->load->model("catalog/product");
	    $data['products'] = array();
	    foreach ($products as $key => $value) {
	        $product_info = $this->model_catalog_product->getProduct($value);

	        if ($product_info) {
	          $data['products'][] = array(
	            'product_id' => $product_info['product_id'],
	            'name'       => $product_info['name']
	          );
	        }
	    }

	    if (isset($this->request->post['categories'])) {
	      $categories = $this->request->post['categories'];
	    } elseif (!empty($salesagentclist_info)) {
	      $categories = json_decode($salesagentclist_info['category_id'],true);
	    } else {
	      $categories = array();
	    }

	    $this->load->model("catalog/category");
	    $data['categories'] = array();
	    foreach ($categories as $key => $value) {
	        $category_info = $this->model_catalog_category->getCategory($value);

	        if ($category_info) {
	          $data['categories'][] = array(
	            'category_id' => $category_info['category_id'],
	            'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
	          );
	        }
	    }

		$data['user_token'] = $this->session->data['user_token'];
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        /**
         * KM category tree
         */
        $data['tree'] = $this->model_extension_module_salesagent->getCategoryTree();

        $data['selected_ids'] = [];
        foreach ($data['categories'] as $category){
            $data['selected_ids'][] = $category['category_id'];
        }

		$this->response->setOutput($this->load->view('extension/module/salesagentclist_form', $data));
	}

	protected function validateClistForm() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/salesagent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['warning'] = $this->language->get('error_name');
		}

		if ((!isset($this->request->post['products'])) && (!isset($this->request->post['categories']))) {
			$this->error['warning'] = $this->language->get('error_catalog');
		}

		return !$this->error;
	}

	protected function validateClistDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/salesagent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocompleteClist() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/module/salesagent');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_extension_module_salesagent->getclists($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'clist_id' => $result['clist_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function install() {
      	$this->model_setting_event->addEvent("module_salesagent_customeraddform","admin/model/customer/customer/addCustomer/after","extension/module/salesagent/SalesAgentCustomerAddForm");
      	$this->model_setting_event->addEvent("module_salesagent_customereditform","admin/model/customer/customer/editCustomer/after","extension/module/salesagent/SalesAgentCustomerEditForm");
      	$this->model_setting_event->addEvent("module_salesagent_savetransaction","catalog/model/checkout/order/addOrder/after","extension/module/salesagent/saveTransactionAdd");
      	$this->model_setting_event->addEvent("module_salesagent_savetransaction","catalog/model/extension/d_quickcheckout/order/getOrder/after","extension/module/salesagent/saveTransactionAdd");
      	$this->model_setting_event->addEvent("module_salesagent_savetransaction","catalog/model/checkout/order/editOrder/before","extension/module/salesagent/saveTransactionEdit");
      	$this->model_setting_event->addEvent("module_salesagent_savetransaction","catalog/model/journal3/order/save/before","extension/module/salesagent/saveTransactionEdit");
      	$this->model_setting_event->addEvent("module_salesagent_savetransaction","catalog/controller/mpcheckout/LastConfirmButton/before","extension/module/salesagent/saveTransactionSession");
      	$this->model_setting_event->addEvent("module_salesagent_savetransaction","catalog/controller/checkout/success/before","extension/module/salesagent/unsetSalesagentSession");
      	$this->model_setting_event->addEvent("module_salesagent_addtransaction","catalog/model/checkout/order/addOrderHistory/before","extension/module/salesagent/addTransaction");
      	$temp['module_salesagent_status'] = 1;
      	$this->load->model('setting/setting');
      	$this->model_setting_setting->editSetting('module_salesagent', $temp);
	}

	public function uninstall() {
		$this->model_setting_event->deleteEventByCode("module_salesagent_customeraddform");
		$this->model_setting_event->deleteEventByCode("module_salesagent_customereditform");
		$this->model_setting_event->deleteEventByCode("module_salesagent_addtransaction");
		$this->model_setting_event->deleteEventByCode("module_salesagent_savetransaction");

		$temp['module_salesagent_status'] = 0;
      	$this->load->model('setting/setting');
      	$this->model_setting_setting->editSetting('module_salesagent', $temp);
	}

	public function SalesAgentCustomerAddForm(&$route, &$args, &$output) {
		if($this->config->get('salesagent_customershow')) {
			$customer_id = 0;
			if(isset($output) && !empty($output) && !is_array($output)) {
				$customer_id = $output;
			}
			if(isset($args[0])) {
				if(isset($args[0]['salesagent_id'])) {
					$salesagent_id = $args[0]['salesagent_id'];
					$data = $args[0];
				}
			}
		 	$this->load->model("extension/module/salesagent");
		 	$this->salesagent->salesAgentCustomer($customer_id,$salesagent_id);
			$this->model_extension_module_salesagent->newSignUp($salesagent_id, $data['firstname'], $data['lastname'], $data['email'], $data['telephone']);
		}
	}

	public function SalesAgentCustomerEditForm(&$route, &$args, &$output) {
		if($this->config->get('salesagent_customershow')) {
			$customer_id = $salesagent_id = 0;
			if (isset($args[0])) {
				$customer_id = $args[0];
			}
			if(isset($args[1])) {
				if(isset($args[1]['salesagent_id'])) {
					$salesagent_id = $args[1]['salesagent_id'];
				}
			}
		 	$this->load->model("extension/module/salesagent");
		 	$this->salesagent->salesAgentCustomer($customer_id,$salesagent_id);
		} 	
	}

	public function getMenu() {

		$data['list'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['clist'] = $this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['orderreport'] = $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['payouts'] = $this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['customerreport'] = $this->url->link('extension/report/salesagent/customerreport', 'user_token=' . $this->session->data['user_token'], TRUE);

		if(!$this->user->getSalesAgentId()) {
			$data['settings'] = $this->url->link('extension/module/salesagent/settings', 'user_token=' . $this->session->data['user_token'], TRUE);
		}	

		return $this->load->view('extension/module/salesagent_menu',$data);
	}
}