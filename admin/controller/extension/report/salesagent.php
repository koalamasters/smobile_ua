<?php
class ControllerExtensionReportSalesAgent extends Controller {
	private $error = array();
	public function orderreportsummary() {

		$this->load->language('extension/module/salesagent');


		$this->document->setTitle($this->language->get('heading_title_report'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
		}

		if (isset($this->request->get['filter_paidout'])) {
			$filter_paidout = $this->request->get['filter_paidout'];
		} else {
			$filter_paidout = null;
		}


		if (isset($this->request->get['filter_salesagent'])) {
			$filter_salesagent = $this->request->get['filter_salesagent'];
		} else {
			$filter_salesagent = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$completedorders =  $this->config->get('salesagent_orderstatus_transactions');
			$filter_order_status_id = implode(",", $completedorders);
		}

		if (isset($this->request->get['filter_transactionids'])) {
			$filter_transactionids = $this->request->get['filter_transactionids'];
		} else {
			$filter_transactionids = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = $this->buildUrl();

		$data['menu'] = $this->getMenu();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_report'),
			'href' => $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		$data['cancel'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'], TRUE);

		$this->load->model('extension/report/salesagent');

		$data['orders'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_salesagent'      => $filter_salesagent,
			'filter_paidout'	     => $filter_paidout,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_transactionids' => $filter_transactionids,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_extension_report_salesagent->getTotalTransactionsSummary($filter_data);

		$data['report_results'] = $this->getOrderTransactionsSummary($filter_data);



		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('extension/module/salesagent');
        
        $data['saleagents'] = $this->model_extension_module_salesagent->getsalesagents();
        $data['salesagent_id'] =  $this->user->getSalesAgentId();
		if($data['salesagent_id']) {
			$data['salesagent_id'] = explode(",", $data['salesagent_id']);
		}        
		$url = $this->buildUrl();

		$data['makepayout'] = "";

		if ((!$filter_paidout && !is_null($filter_paidout)) || $filter_transactionids) {
			if(!empty($data['report_results'])) {
				if($filter_salesagent) {
					$data['makepayout'] = "Make Payout for below unpaid commission ";
					$data['payoutlink'] = $this->url->link('extension/report/salesagent/makepayout', 'user_token=' . $this->session->data['user_token'] . $url, true);
				}	
			}
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', TRUE);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_paidout'] = $filter_paidout;
		$data['filter_salesagent'] = $filter_salesagent;
		$data['filter_transactionids'] = $filter_transactionids;
		$data['filter_order_status_id'] = $filter_order_status_id;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/salesagent_orderreport', $data));
	}

	public function orderreport() {

		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title_report'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			//$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
			$filter_date_start = "";
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			//$filter_date_end = date('Y-m-d');
			$filter_date_end = "";
		}

		if (isset($this->request->get['filter_paidout'])) {
			$filter_paidout = $this->request->get['filter_paidout'];
		} else {
			$filter_paidout = null;
		}


		if (isset($this->request->get['filter_salesagent'])) {
			$filter_salesagent = $this->request->get['filter_salesagent'];
		} else {
			$filter_salesagent = '';
		}

		
		$completedorders =  $this->config->get('salesagent_orderstatus_transactions');
		$filter_order_status_id = implode(",", $completedorders);

		if (isset($this->request->get['filter_transactionids'])) {
			$filter_transactionids = $this->request->get['filter_transactionids'];
		} else {
			$filter_transactionids = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = $this->buildUrl();

		$data['menu'] = $this->getMenu();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_report'),
			'href' => $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		$data['cancel'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'], TRUE);

		$this->load->model('extension/report/salesagent');

		$data['orders'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_salesagent'      => $filter_salesagent,
			'filter_paidout'	     => $filter_paidout,
			'filter_transactionids' => $filter_transactionids,
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_extension_report_salesagent->getTotalTransactions($filter_data);

		$data['report_results'] = $this->getOrderTransactions($filter_data);

		$data['unpaid_color'] = $this->config->get("salesagent_unpaid_color");
		$data['paid_color'] = $this->config->get("salesagent_paid_color");

		foreach($data['report_results'] as $key => $value) {
			if($value['paidout']) {
				$data['report_results'][$key]['color'] =  $this->config->get("salesagent_paid_color");
			} else {
				$data['report_results'][$key]['color'] =  $this->config->get("salesagent_unpaid_color");
			}
		}

		$data['report_exacttotal'] = $this->model_extension_report_salesagent->getExactTotal($filter_data);

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('extension/module/salesagent');
        
        $data['saleagents'] = $this->model_extension_module_salesagent->getsalesagents();
        $data['salesagent_id'] =  $this->user->getSalesAgentId();
		if($data['salesagent_id']) {
			$data['salesagent_id'] = explode(",", $data['salesagent_id']);
		}        
		$url = $this->buildUrl();

		$data['makepayout'] = "";

		if ((!$filter_paidout && !is_null($filter_paidout)) || $filter_transactionids) {
			if(!empty($data['report_results'])) {
				if($filter_salesagent) {
					$data['makepayout'] = sprintf($this->language->get('text_make_payout'),$order_total);
					$data['payoutlink'] = $this->url->link('extension/report/salesagent/makepayout', 'user_token=' . $this->session->data['user_token'] . $url, true);
				}	
			}
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', TRUE);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_paidout'] = $filter_paidout;
		$data['filter_salesagent'] = $filter_salesagent;
		$data['filter_order_status_id'] = explode(",",$filter_order_status_id);
		$data['filter_transactionids'] = $filter_transactionids;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/module/salesagent_orderreport', $data));
	}

	function invertColor($color){
	    $color = str_replace('#', '', $color);
	    if (strlen($color) != 6){ return '000000'; }
	    $rgb = '';
	    for ($x=0;$x<3;$x++){
	        $c = 255 - hexdec(substr($color,(2*$x),2));
	        $c = ($c < 0) ? 0 : dechex($c);
	        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
	    }
	    return '#'.$rgb;
	}

	public function download() {


		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
		}

		if (isset($this->request->get['filter_paidout'])) {
			$filter_paidout = $this->request->get['filter_paidout'];
		} else {
			$filter_paidout = null;
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$filter_salesagent = $this->request->get['filter_salesagent'];
		} else {
			$filter_salesagent = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$completedorders =  $this->config->get('salesagent_orderstatus_transactions');
			$filter_order_status_id = implode(",", $completedorders);
		}

		$this->load->model('extension/report/salesagent');

		$data['orders'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_paidout'	     => $filter_paidout,
			'filter_salesagent'      => $filter_salesagent,
			'filter_paidout'	     => $filter_paidout,
			'filter_order_status_id' => $filter_order_status_id
		);

		$order_total = $this->model_extension_report_salesagent->getTotalTransactions($filter_data);

		$data['report_results'] = $this->getOrderTransactions($filter_data);

		$data['report_exacttotal'] = $this->model_extension_report_salesagent->getExactTotal($filter_data);

	}

	public function buildUrl() {
		$url = "";
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_paidout'])) {
			$url .= '&filter_paidout=' . $this->request->get['filter_paidout'];
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$url .= '&filter_salesagent=' . $this->request->get['filter_salesagent'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['filter_transactionids'])) {
			$url .= '&filter_transactionids=' . $this->request->get['filter_transactionids'];
		}
		return $url;
	}


	public function payouts() {

		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title_payouts'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = "";
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = "";
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$filter_salesagent = $this->request->get['filter_salesagent'];
		} else {
			$filter_salesagent = '';
		}

		if (isset($this->request->get['filter_transactionid'])) {
			$filter_transactionid = $this->request->get['filter_transactionid'];
		} else {
			$filter_transactionid = '';
		}

		if (isset($this->request->get['filter_amount'])) {
			$filter_amount = $this->request->get['filter_amount'];
		} else {
			$filter_amount = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = $this->buildTransactionUrl();

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/report/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_payouts'),
			'href' => $this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['back'] = $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'], true);
		$data['delete'] = $this->url->link('extension/report/salesagent/deletePayout', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$this->load->model('extension/report/salesagent');

		$data['orders'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_transactionid'	     => $filter_transactionid,
			'filter_amount'	     => $filter_amount,
			'filter_date_end'	     => $filter_date_end,
			'filter_salesagent'      => $filter_salesagent,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_extension_report_salesagent->getTotalPayouts($filter_data);
		
		$data['report_results'] = $this->model_extension_report_salesagent->getPayouts($filter_data);

		$data['catalog'] = HTTPS_CATALOG;

		foreach ($data['report_results'] as $key => $value) {
			$data['report_results'][$key]['view'] = $this->url->link('extension/report/salesagent/payouttransaction', 'user_token=' . $this->session->data['user_token'] . '&salesagent_payout_id=' . $value['salesagent_payouts_id'] . $url, true);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('extension/module/salesagent');
        
        $data['saleagents'] = $this->model_extension_module_salesagent->getsalesagents();
        $data['salesagent_id'] =  $this->user->getSalesAgentId();
		if($data['salesagent_id']) {
			$data['salesagent_id'] = explode(",", $data['salesagent_id']);
		}

		$url = $this->buildTransactionUrl();

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_salesagent'] = $filter_salesagent;
		$data['filter_transactionid'] = $filter_transactionid;
		$data['filter_amount'] = $filter_amount;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/report/salesagent_payouts', $data));
	}

	public function deletePayout() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/report/salesagent');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $salesagent_payout_id) {
				$this->model_extension_report_salesagent->deletePayouts($salesagent_payout_id);
			}

			$this->session->data['success'] = $this->language->get('text_success_delete');

			$url = $this->buildTransactionUrl();

			$this->response->redirect($this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->payouts();
	}

	public function payouttransaction() {

		$this->load->language('extension/module/salesagent');

		if (isset($this->request->get['salesagent_payout_id'])) {
			$salesagent_payout_id = $this->request->get['salesagent_payout_id'];
		} else {
			$salesagent_payout_id = 0;
		}

		$this->document->setTitle($this->language->get('heading_title_payouts'));

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = $this->buildTransactionUrl();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/report/salesagent', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_payouts'),
			'href' => $this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['back'] = $this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$this->load->model('extension/report/salesagent');

		$data['orders'] = array();

		$filter_data = array(
			'salesagent_payout_id'	     => $salesagent_payout_id,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_extension_report_salesagent->getTotalPayoutTransactions($filter_data);
		
		$data['report_results'] = $this->model_extension_report_salesagent->getPayoutTransactions($filter_data);

		$data['user_token'] = $this->session->data['user_token'];

		$url = $this->buildTransactionUrl();

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/report/salesagent/payouttransaction', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/report/salesagent_payout_transactions', $data));
	}

	public function makepayout() {

		$this->load->language('extension/module/salesagent');

		$this->load->model("extension/report/salesagent");
		$this->load->model("extension/module/salesagent");

		$this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->get['filter_salesagent'])) {
            $filter_salesagent = $this->request->get['filter_salesagent'];
            $data['salesagent_info'] = $this->model_extension_module_salesagent->getsalesagent($this->request->get['filter_salesagent']);
        } else {
            $this->response->redirect($this->url->link('extension/report/salesagent', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['partner_customer_user_id'] = $data['salesagent_info']['customer_id'];

        $data['partner_customer'] = [];

        if (!empty($data['partner_customer_user_id'])) {
            $this->load->model('customer/customer');
            $customer_info = $this->model_customer_customer->getCustomer((int)$data['partner_customer_user_id']);
            if ($customer_info) {
                $data['partner_customer'] = [
                    'name'  => $customer_info['firstname'] . ' ' . $customer_info['lastname'],
                    'email' => $customer_info['email'],
                    'id'    => $customer_info['customer_id']
                ];
            }
        }

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$data['report_results'] = $this->getOrderTransactions($this->request->post);

            $reward_mode = isset($this->request->post['reward_as_points']) ? (int)$this->request->post['reward_as_points'] : 1;

            if ($reward_mode && !empty($this->request->post['partner_customer_user_id']) && (float)$this->request->post['totalcommissionamount'] > 0) {
                $this->load->model('customer/customer');
                $description = 'Партнерська комісія';
                $this->model_customer_customer->addReward(
                    (int)$this->request->post['partner_customer_user_id'],
                    $description,
                    (float)$this->request->post['totalcommissionamount']
                );
            }

            $this->model_extension_report_salesagent->addPayout($this->request->post, $data['report_results'], $reward_mode);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'], true));
		}


		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = "";
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = "";
		}

		if (isset($this->request->get['filter_paidout']) && !$this->request->get['filter_paidout']) {
			$filter_paidout = $this->request->get['filter_paidout'];
		} elseif(isset($this->request->get['filter_transactionids'])){
			$filter_paidout = 0;
		}	else {
			$this->response->redirect($this->url->link('extension/report/salesagent', 'user_token=' . $this->session->data['user_token'], true));
		}



		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$completedorders =  $this->config->get('salesagent_orderstatus_transactions');
			$filter_order_status_id = implode(",", $completedorders);
		}

		if (isset($this->request->get['filter_transactionids'])) {
			$filter_transactionids = $this->request->get['filter_transactionids'];
		} else {
			$filter_transactionids = '';
		}

		if (isset($this->error['transaction_id'])) {
			$data['error_transaction_id'] = $this->error['transaction_id'];
		} else {
			$data['error_transaction_id'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$url = $this->buildUrl();

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/report/salesagent', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/report/salesagent/makepayout', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['back'] = $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['action'] = $this->url->link('extension/report/salesagent/makepayout', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$this->load->model('extension/report/salesagent');
		$this->load->model('tool/image');

		$data['orders'] = array();
		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_paidout'	     => $filter_paidout,
			'filter_salesagent'      => $filter_salesagent,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_transactionids' => $filter_transactionids
		);

		$data['order_total'] = $this->model_extension_report_salesagent->getTotalTransactions($filter_data);

		$data['report_results'] = $this->model_extension_report_salesagent->getTransactions($filter_data);

		$data['report_exacttotal'] = $this->model_extension_report_salesagent->getExactTotal($filter_data);

		$data['placeholder'] = $data['thumbnail'] =  $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['user_token'] = $this->session->data['user_token'];

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_paidout'] = $filter_paidout;
		$data['filter_salesagent'] = $filter_salesagent;
		$data['filter_order_status_id'] = $filter_order_status_id;
		$data['filter_transactionids'] = $filter_transactionids;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/report/salesagent_makepayout', $data));
	}

	public function buildTransactionUrl() {
		$url = "";

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$url .= '&filter_salesagent=' . $this->request->get['filter_salesagent'];
		}

		if (isset($this->request->get['filter_transactionid'])) {
			$url .= '&filter_transactionid=' . $this->request->get['filter_transactionid'];
		}

		if (isset($this->request->get['filter_amount'])) {
			$url .= '&filter_amount=' . $this->request->get['filter_amount'];
		}

		return $url;
	}

	public function customerreport() {
		$this->load->language('extension/module/salesagent');

		$this->document->setTitle($this->language->get('heading_title_customer'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			//$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
			$filter_date_start = "";
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
			$filter_date_end = "";
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$filter_salesagent = $this->request->get['filter_salesagent'];
		} else {
			$filter_salesagent = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$url .= '&filter_salesagent=' . $this->request->get['filter_salesagent'];
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
			'text' => $this->language->get('heading_title_customer'),
			'href' => $this->url->link('extension/report/salesagent/customerreport', 'user_token=' . $this->session->data['user_token'] . $url, TRUE)
		);

		$data['cancel'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'], TRUE);

		$this->load->model('extension/report/salesagent');

		$data['orders'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_salesagent'      => $filter_salesagent,
			'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_extension_report_salesagent->getTotalCustomers($filter_data);
		
		$data['report_results'] = $this->model_extension_report_salesagent->getCustomers($filter_data);

		$data['report_exacttotal'] = $order_total;

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('extension/module/salesagent');
        
        $data['saleagents'] = $this->model_extension_module_salesagent->getsalesagents();
        $data['salesagent_id'] =  $this->user->getSalesAgentId();
		if($data['salesagent_id']) {
			$data['salesagent_id'] = explode(",", $data['salesagent_id']);
		}        
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_salesagent'])) {
			$url .= '&filter_salesagent=' . $this->request->get['filter_salesagent'];
		}


		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/report/salesagent/customerreport', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', TRUE);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_salesagent'] = $filter_salesagent;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/salesagent_customerreport', $data));
	}

	public function getMenu() {
		$data['list'] = $this->url->link('extension/module/salesagent', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['clist'] = $this->url->link('extension/module/salesagent/salesagentclist', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['orderreport'] = $this->url->link('extension/report/salesagent/orderreport', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['payouts'] = $this->url->link('extension/report/salesagent/payouts', 'user_token=' . $this->session->data['user_token'], TRUE);
		$data['customerreport'] = $this->url->link('extension/report/salesagent/customerreport', 'user_token=' . $this->session->data['user_token'], TRUE);
		return $this->load->view('extension/module/salesagent_menu',$data);
	}

	public function getOrderTransactions($filter_data) {
		
		$report_results = $this->model_extension_report_salesagent->getTransactions($filter_data);

		foreach ($report_results as $key => $value) {
			$report_results[$key]['amount']	= $this->currency->format($value['amount'],$value['currency_code'],$value['currency_value']);
			$report_results[$key]['date_added']	= date($this->language->get('date_format_short'), strtotime($value['date_added']));
			$report_results[$key]['total']	= $this->currency->format($value['total'],$value['currency_code'],$value['currency_value']);
			$report_results[$key]['sub_total']	= $this->currency->format($value['sub_total'],$value['currency_code'],$value['currency_value']);
			$report_results[$key]['sub_total_amount']	= $value['sub_total'];
			$report_results[$key]['product']	= $this->model_extension_report_salesagent->getProductCount($value['order_id']);
		}
		return $report_results;
	}

	public function getOrderTransactionsSummary($filter_data) {
		$report_results = $this->model_extension_report_salesagent->getTransactionsSummary($filter_data);
		
		foreach ($report_results as $key => $value) {
			$report_results[$key]['amount']	= $this->currency->format($value['amount'],$value['currency_code'],$value['currency_value']);
			$report_results[$key]['commission']	= $this->currency->format($value['commission'],$value['currency_code'],$value['currency_value']);
		}
		return $report_results;
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/report/salesagent')) {
			$this->error['warning'] = $this->language->get('error_permission_payouts');
		}
		
		if (utf8_strlen($this->request->post['transaction_id']) < 1) {
			$this->error['transaction_id'] = $this->language->get('error_transaction_id');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->getSalesAgentId() && !$this->user->hasPermission('modify', 'extension/report/salesagent')) {
			$this->error['warning'] = $this->language->get('error_permission_payouts');
		}

		return !$this->error;
	}
}