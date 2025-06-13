<?php
class ControllerPaymentUkrCredits extends Controller {
	protected $version = '1.3.1.2';

    public function index() {

		$token = version_compare(VERSION,'3.0','>=') ? 'user_' : '';
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/payment' : 'payment';

		$payments_page = version_compare(VERSION,'3.0','>=') ? 'marketplace/extension' : (version_compare(VERSION,'2.3','>=') ? 'extension/extension' : 'extension/payment');
		
		$data = array();
		
		$prevbank = 'pp';
		foreach ($this->banks as $bank) {
			$query_[$bank] = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_ukrcredits` LIKE 'product_".$bank."'");
			if (!$query_[$bank]->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_ukrcredits` ADD `product_".$bank."` INT(1) NOT NULL AFTER `product_".$prevbank."`;");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_ukrcredits` ADD `partscount_".$bank."` INT(2) NOT NULL AFTER `partscount_".$prevbank."`;");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_ukrcredits` ADD `markup_".$bank."` decimal(15,4) NOT NULL AFTER `markup_".$prevbank."`;");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_ukrcredits` ADD `special_".$bank."` INT(1) NOT NULL AFTER `special_".$prevbank."`;");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_ukrcredits` ADD `discount_".$bank."` INT(1) NOT NULL AFTER `discount_".$prevbank."`;");
			}
			$prevbank = $bank;
		}

		$data += $this->load->language($dir.'/ukrcredits');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$data += $this->request->post;
			if (isset($this->request->post['sb_credit_sub_products']) && $this->request->post['sb_credit_sub_products']) {
				foreach ($this->request->post['sb_credit_sub_products'] as $sub_product) {
					$this->request->post['sb_id_data'][$sub_product['gracePeriod']] = $sub_product['subproduct'];
				}
			}
		} elseif ($this->config->get($type.'ukrcredits_settings')) {
			$data += $this->config->get($type.'ukrcredits_settings');
		} else {
			$data['pp_shop_id'] = '';
			$data['pp_shop_password'] = '';
			$data['pp_status'] = 0;
			$data['pp_info'] = array();
			$data['pp_sort_order'] = 10;
			$data['pp_hold'] = 0;
			$data['pp_discount'] = 0;
			$data['pp_special'] = 0;
			$data['pp_stock'] = 0;
			$data['pp_pq'] = 24;
			$data['pp_min_total'] = '';
			$data['pp_max_total'] = 100000;
			$data['pp_merchantType'] = 'PP';
			$data['pp_markup_type'] = 'fixed';			
			$data['pp_markup_custom_PP'] = array(1 => 1.5, 2 => 2.5, 3 => 4.5, 4 => 7, 5 => 9, 6 => 11.5, 7 => 13.5, 8 => 15.5, 9 => 16.5, 10 => 17, 11 => 17.5, 12 => 19, 13 => 20.5, 14 => 22, 15 => 23.5, 16 => 24.5, 17 => 26, 18 => 27, 19 => 28.5, 20 => 29.5, 21 => 31, 22 => 32, 23 => 33, 24 => 34.5); 
			$data['pp_markup_acquiring'] = '2.0';			
			$data['pp_markup'] = 1.000;
			$data['pp_enabled'] = 0;
			$data['pp_product_allowed'] = array();
			$data['pp_geo_zone_id'] = 0;

			$data['ii_shop_id'] = '';
			$data['ii_shop_password'] = '';
			$data['ii_status'] = 0;
			$data['ii_info'] = array();
			$data['ii_sort_order'] = 11;
			$data['ii_hold'] = 0;
			$data['ii_discount'] = 0;
			$data['ii_special'] = 0;
			$data['ii_stock'] = 0;
			$data['ii_pq'] = 24;
			$data['ii_min_total'] = '';
			$data['ii_max_total'] = 100000;
			$data['ii_merchantType'] = 'II';
			$data['ii_markup_type'] = 'fixed';			
			$data['ii_markup_custom_II'] = array(1 => 1.5, 2 => 2.5, 3 => 4.5, 4 => 6.4, 5 => 7.6, 6 => 8.2, 7 => 8.7, 8 => 9.7, 9 => 10.6, 10 => 11.6, 11 => 12.2, 12 => 12.5, 13 => 12.8, 14 => 13.1, 15 => 13.4, 16 => 13.7, 17 => 14, 18 => 14.3, 19 => 14.7, 20 => 15.5, 21 => 16.2, 22 => 17, 23 => 17.6, 24 => 18.3); 
			$data['ii_markup_acquiring'] = '0';			
			$data['ii_markup'] = 1.000;
			$data['ii_enabled'] = 0;
			$data['ii_product_allowed'] = array();
			$data['ii_geo_zone_id'] = 0;
			
			$data['mb_shop_id'] = '';
			$data['mb_shop_password'] = '';
			$data['mb_status'] = 0;
			$data['mb_info'] = array();
			$data['mb_mode'] = 0;
			$data['mb_sort_order'] = 12;
			$data['mb_discount'] = 0;
			$data['mb_special'] = 0;
			$data['mb_stock'] = 0;
			$data['mb_pq'] = 24;
			$data['mb_min_total'] = 500;
			$data['mb_max_total'] = 100000;
			$data['mb_merchantType'] = 'MB';
			$data['mb_markup_type'] = 'fixed';
			$data['mb_markup_custom_MB'] = array(2 => 2.9, 3 => 4.1, 4 => 5.9, 5 => 7.2, 6 => 8.3, 7 => 9.5, 8 => 10.8, 9 => 12, 10 => 13.2, 11 => 14.3, 12 => 15.5, 13 => 16.6, 14 => 17.7, 15 => 18.8, 16 => 19.8, 17 => 20.9, 18 => 21.9, 19 => 23, 20 => 24, 21 => 29.4, 22 => 25.9, 23 => 26.8, 24 => 27.8); 
			$data['mb_markup_acquiring'] = '0';
			$data['mb_markup'] = 1.000;
			$data['mb_enabled'] = 0;
			$data['mb_product_allowed'] = array();
			$data['mb_geo_zone_id'] = 0;
			
			$data['ab_shop_id'] = '';
			$data['ab_shop_password'] = '';
			$data['ab_status'] = 0;
			$data['ab_info'] = array();
			$data['ab_mode'] = 0;
			$data['ab_sort_order'] = 13;
			$data['ab_discount'] = 0;
			$data['ab_special'] = 0;
			$data['ab_stock'] = 0;
			$data['ab_pq'] = 24;
			$data['ab_min_total'] = 500;
			$data['ab_max_total'] = 200000;
			$data['ab_merchantType'] = 'AB';
			$data['ab_markup_type'] = 'fixed';
			$data['ab_markup_custom_AB'] = array(3 => 4.5, 6 => 6, 9 => 10, 10 => 11, 12 => 12, 15 => 16, 20 => 21, 24 => 25); 
			$data['ab_markup_acquiring'] = '0';
			$data['ab_markup'] = 1.000;
			$data['ab_enabled'] = 0;
			$data['ab_product_allowed'] = array();
			$data['ab_geo_zone_id'] = 0;
			
			$data['aa_shop_id'] = '';
			$data['aa_shop_password'] = '';
			$data['aa_status'] = 0;
			$data['aa_info'] = array();
			$data['aa_mode'] = 0;
			$data['aa_sort_order'] = 14;
			$data['aa_discount'] = 0;
			$data['aa_special'] = 0;
			$data['aa_stock'] = 0;
			$data['aa_pq'] = 24;
			$data['aa_min_total'] = 500;
			$data['aa_max_total'] = 100000;
			$data['aa_merchantType'] = 'AA';
			$data['aa_markup_type'] = 'fixed';
			$data['aa_markup_custom_AA'] = array(1 => 3.0, 2 => 3.5, 3 => 5.5, 4 => 7.5, 5 => 10.0, 6 => 12.5, 7 => 14.5, 8 => 16.5, 9 => 17.5, 10 => 18.0, 11 => 18.5, 12 => 20.0, 13 => 21.5, 14 => 23.0, 15 => 24.5, 16 => 25.5, 17 => 27.0, 18 => 28.0, 19 => 29.5, 20 => 30.5, 21 => 32.0, 22 => 33.0, 23 => 34.0, 24 => 35.5); 
			$data['aa_markup_acquiring'] = '0';
			$data['aa_markup'] = 1.000;
			$data['aa_enabled'] = 0;
			$data['aa_product_allowed'] = array();
			$data['aa_geo_zone_id'] = 0;
			
			$data['pl_shop_id'] = '';
			$data['pl_shop_password'] = '';
			$data['pl_status'] = 0;
			$data['pl_info'] = array();
			$data['pl_mode'] = 0;
			$data['pl_sort_order'] = 15;
			$data['pl_discount'] = 0;
			$data['pl_special'] = 0;
			$data['pl_stock'] = 0;
			$data['pl_pq'] = 9;
			$data['pl_min_total'] = 500;
			$data['pl_max_total'] = 200000;
			$data['pl_merchantType'] = 'PL';
			$data['pl_markup_type'] = 'fixed';
			$data['pl_markup_custom_PL'] = array(2 => 8, 5 => 15, 9 => 25); 
			$data['pl_markup_acquiring'] = '0';
			$data['pl_markup'] = 1.000;
			$data['pl_enabled'] = 0;
			$data['pl_product_allowed'] = array();
			$data['pl_geo_zone_id'] = 0;
			
			$data['pu_shop_id'] = '';
			$data['pu_shop_name'] = '';
			$data['pu_shop_password'] = '';
			$data['pu_point_of_sale_code'] = '';
			$data['pu_status'] = 0;
			$data['pu_info'] = array();
			$data['pu_mode'] = 0;
			$data['pu_sort_order'] = 16;
			$data['pu_discount'] = 0;
			$data['pu_special'] = 0;
			$data['pu_stock'] = 0;
			$data['pu_pq'] = 24;
			$data['pu_min_total'] = 500;
			$data['pu_max_total'] = 100000;
			$data['pu_merchantType'] = 'PU';
			$data['pu_markup_type'] = 'fixed';
			$data['pu_markup_custom_PU'] = array(2 => 2.9, 3 => 4.1, 4 => 5.9, 5 => 7.2, 6 => 8.3, 7 => 9.5, 8 => 10.8, 9 => 12, 10 => 13.2, 11 => 14.3, 12 => 15.5, 13 => 16.6, 14 => 17.7, 15 => 18.8, 16 => 19.8, 17 => 20.9, 18 => 21.9, 19 => 23, 20 => 24, 21 => 29.4, 22 => 25.9, 23 => 26.8, 24 => 27.8); 
			$data['pu_markup_acquiring'] = '0';
			$data['pu_markup'] = 1.000;
			$data['pu_enabled'] = 0;
			$data['pu_product_allowed'] = array();
			$data['pu_geo_zone_id'] = 0;

			$data['sb_login'] = '';
			$data['sb_frameSecretKey'] = '';			
			$data['sb_partnerId'] = '';
			$data['sb_shopId'] = '';
			$data['sb_credit_sub_products'] = array(
				3 => array
					(
						'subproduct' => 'Onl_CSF_0_3_9_new',
						'gracePeriod' => 3,
					),

				5 => array
					(
						'subproduct' => 'Onl_CSF_0-5-9_new',
						'gracePeriod' => 5
					),

				10 => array
					(
						'subproduct' => 'Onl_CSF_0-10-15_new',
						'gracePeriod' => 10
					),

				12 => array
					(
						'subproduct' => 'Onl_CSF_0-12-18_new',
						'gracePeriod' => 12
					),
				);
			$data['sb_status'] = 0;
			$data['sb_info'] = array();
			$data['sb_mode'] = 0;
			$data['sb_sort_order'] = 16;
			$data['sb_discount'] = 0;
			$data['sb_special'] = 0;
			$data['sb_stock'] = 0;
			$data['sb_pq'] = 12;
			$data['sb_min_total'] = 500;
			$data['sb_max_total'] = 100000;
			$data['sb_merchantType'] = 'SB';
			$data['sb_markup_acquiring'] = '0';
			$data['sb_markup'] = 1.000;
			$data['sb_enabled'] = 0;
			$data['sb_product_allowed'] = array();
			$data['sb_geo_zone_id'] = 0;

			$data['ib_shop_id'] = '';
			$data['ib_shop_password'] = '';
			$data['ib_status'] = 0;
			$data['ib_info'] = array();
			$data['ib_mode'] = 0;
			$data['ib_sort_order'] = 13;
			$data['ib_discount'] = 0;
			$data['ib_special'] = 0;
			$data['ib_stock'] = 0;
			$data['ib_pq'] = 24;
			$data['ib_min_total'] = 500;
			$data['ib_max_total'] = 200000;
			$data['ib_merchantType'] = 'IB';
			$data['ib_markup_type'] = 'fixed';
			$data['ib_markup_custom_IB'] = array(3 => 4.5, 6 => 6, 9 => 10, 10 => 11, 12 => 12, 15 => 16, 20 => 21, 24 => 25); 
			$data['ib_markup_acquiring'] = '0';
			$data['ib_markup'] = 1.000;
			$data['ib_enibled'] = 0;
			$data['ib_product_allowed'] = array();
			$data['ib_geo_zone_id'] = 0;

			$data['ot_shop_id'] = '';
			$data['ot_shop_password'] = '';
			$data['ot_status'] = 0;
			$data['ot_info'] = array();
			$data['ot_mode'] = 0;
			$data['ot_sort_order'] = 13;
			$data['ot_discount'] = 0;
			$data['ot_special'] = 0;
			$data['ot_stock'] = 0;
			$data['ot_pq'] = 24;
			$data['ot_min_total'] = 500;
			$data['ot_max_total'] = 200000;
			$data['ot_merchantType'] = 'OT';
			$data['ot_markup_type'] = 'fixed';
			$data['ot_markup_custom_OT'] = array(3 => 4.5, 6 => 6, 9 => 10, 10 => 11, 12 => 12, 15 => 16, 20 => 21, 24 => 25); 
			$data['ot_markup_acquiring'] = '0';
			$data['ot_markup'] = 1.000;
			$data['ot_enotled'] = 0;
			$data['ot_product_allowed'] = array();
			$data['ot_geo_zone_id'] = 0;

			$data['np_shop_id'] = '';
			$data['np_shop_password'] = '';
			$data['np_status'] = 0;
			$data['np_info'] = array();
			$data['np_mode'] = 0;
			$data['np_sort_order'] = 13;
			$data['np_discount'] = 0;
			$data['np_special'] = 0;
			$data['np_stock'] = 0;
			$data['np_pq'] = 24;
			$data['np_min_total'] = 500;
			$data['np_max_total'] = 200000;
			$data['np_merchantType'] = 'NP';
			$data['np_markup_type'] = 'fixed';
			$data['np_markup_custom_NP'] = array(3 => 4.5, 6 => 6, 9 => 10, 10 => 11, 12 => 12, 15 => 16, 20 => 21, 24 => 25); 
			$data['np_markup_acquiring'] = '0';
			$data['np_markup'] = 1.000;
			$data['np_ennpled'] = 0;
			$data['np_product_allowed'] = array();
			$data['np_geo_zone_id'] = 0;
			
			$data['completed_status_id'] = 0;
			$data['canceled_status_id'] = 0;
			$data['clientwait_status_id'] = 0;
			$data['created_status_id'] = 0;
			$data['failed_status_id'] = 0;
			$data['rejected_status_id'] = 0;
			
			$data['button_name'][1] = 'Купить в кредит';
			$data['button_name'][2] = 'Купить в кредит';
			$data['button_name'][3] = 'Купить в кредит';
			$data['button_name'][4] = 'Купить в кредит';
			$data['button_name'][5] = 'Купить в кредит';
			$data['icons_size'] = '25';
			$data['css_button'] = 'btn btn-primary btn-lg btn-block';
			$data['selector_button'] = '#button-cart';
			$data['selector_block'] = '#product';
			$data['show_icons'] = 1;
			$data['css_custom'] = '';
		}

		if (!isset($data['ab_shop_id'])) {
			$data['ab_shop_id'] = '';
			$data['ab_shop_password'] = '';
			$data['ab_status'] = 0;
			$data['ab_info'] = array();
			$data['ab_mode'] = 0;
			$data['ab_sort_order'] = 13;
			$data['ab_discount'] = 0;
			$data['ab_special'] = 0;
			$data['ab_stock'] = 0;
			$data['ab_pq'] = 24;
			$data['ab_min_total'] = 500;
			$data['ab_max_total'] = 200000;
			$data['ab_merchantType'] = 'AB';
			$data['ab_markup_type'] = 'fixed';
			$data['ab_markup_custom_AB'] = array(3 => 4.5, 6 => 6, 9 => 10, 10 => 11, 12 => 12, 15 => 16, 20 => 21, 24 => 25); 
			$data['ab_markup_acquiring'] = '0';
			$data['ab_markup'] = 1.000;
			$data['ab_enabled'] = 0;
			$data['ab_product_allowed'] = array();
			$data['ab_geo_zone_id'] = 0;
			
			if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
				$this->load->model('extension/extension');
				$this->model_extension_extension->install('payment', 'ukrcredits_ab');
			} else {
				$this->load->model('setting/extension');
				$this->model_setting_extension->install('payment', 'ukrcredits_ab');
			}			
		}

		if (!isset($data['aa_shop_id'])) {
			$data['aa_shop_id'] = '';
			$data['aa_shop_password'] = '';
			$data['aa_status'] = 0;
			$data['aa_info'] = array();
			$data['aa_mode'] = 0;
			$data['aa_sort_order'] = 14;
			$data['aa_discount'] = 0;
			$data['aa_special'] = 0;
			$data['aa_stock'] = 0;
			$data['aa_pq'] = 24;
			$data['aa_min_total'] = 500;
			$data['aa_max_total'] = 100000;
			$data['aa_merchantType'] = 'AA';
			$data['aa_markup_type'] = 'fixed';
			$data['aa_markup_custom_AA'] = array(1 => 3.0, 2 => 3.5, 3 => 5.5, 4 => 7.5, 5 => 10.0, 6 => 12.5, 7 => 14.5, 8 => 16.5, 9 => 17.5, 10 => 18.0, 11 => 18.5, 12 => 20.0, 13 => 21.5, 14 => 23.0, 15 => 24.5, 16 => 25.5, 17 => 27.0, 18 => 28.0, 19 => 29.5, 20 => 30.5, 21 => 32.0, 22 => 33.0, 23 => 34.0, 24 => 35.5); 
			$data['aa_markup_acquiring'] = '0';
			$data['aa_markup'] = 1.000;
			$data['aa_enabled'] = 0;
			$data['aa_product_allowed'] = array();
			$data['aa_geo_zone_id'] = 0;
			
			if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
				$this->load->model('extension/extension');
				$this->model_extension_extension->install('payment', 'ukrcredits_aa');
			} else {
				$this->load->model('setting/extension');
				$this->model_setting_extension->install('payment', 'ukrcredits_aa');
			}			
		}
		
		if (!isset($data['pl_shop_id'])) {
			$data['pl_shop_id'] = '';
			$data['pl_shop_password'] = '';
			$data['pl_status'] = 0;
			$data['pl_info'] = array();
			$data['pl_mode'] = 0;
			$data['pl_sort_order'] = 15;
			$data['pl_discount'] = 0;
			$data['pl_special'] = 0;
			$data['pl_stock'] = 0;
			$data['pl_pq'] = 9;
			$data['pl_min_total'] = 500;
			$data['pl_max_total'] = 200000;
			$data['pl_merchantType'] = 'PL';
			$data['pl_markup_type'] = 'fixed';
			$data['pl_markup_custom_PL'] = array(2 => 8, 5 => 15, 9 => 25); 
			$data['pl_markup_acquiring'] = '0';
			$data['pl_markup'] = 1.000;
			$data['pl_enabled'] = 0;
			$data['pl_product_allowed'] = array();
			$data['pl_geo_zone_id'] = 0;
			
			if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
				$this->load->model('extension/extension');
				$this->model_extension_extension->install('payment', 'ukrcredits_pl');
			} else {
				$this->load->model('setting/extension');
				$this->model_setting_extension->install('payment', 'ukrcredits_pl');
			}			
		}

		if (!isset($data['pu_shop_id'])) {
			$data['pu_shop_id'] = '';
			$data['pu_shop_name'] = '';
			$data['pu_shop_password'] = '';
			$data['pu_point_of_sale_code'] = '';
			$data['pu_status'] = 0;
			$data['pu_info'] = array();
			$data['pu_mode'] = 0;
			$data['pu_sort_order'] = 16;
			$data['pu_discount'] = 0;
			$data['pu_special'] = 0;
			$data['pu_stock'] = 0;
			$data['pu_pq'] = 24;
			$data['pu_min_total'] = 500;
			$data['pu_max_total'] = 100000;
			$data['pu_merchantType'] = 'PU';
			$data['pu_markup_type'] = 'fixed';
			$data['pu_markup_custom_PU'] = array(2 => 2.9, 3 => 4.1, 4 => 5.9, 5 => 7.2, 6 => 8.3, 7 => 9.5, 8 => 10.8, 9 => 12, 10 => 13.2, 11 => 14.3, 12 => 15.5, 13 => 16.6, 14 => 17.7, 15 => 18.8, 16 => 19.8, 17 => 20.9, 18 => 21.9, 19 => 23, 20 => 24, 21 => 29.4, 22 => 25.9, 23 => 26.8, 24 => 27.8); 
			$data['pu_markup_acquiring'] = '0';
			$data['pu_markup'] = 1.000;
			$data['pu_enabled'] = 0;
			$data['pu_product_allowed'] = array();
			$data['pu_geo_zone_id'] = 0;
			
			if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
				$this->load->model('extension/extension');
				$this->model_extension_extension->install('payment', 'ukrcredits_pu');
			} else {
				$this->load->model('setting/extension');
				$this->model_setting_extension->install('payment', 'ukrcredits_pu');
			}			
		}

		if (!isset($data['sb_login'])) {		
			$data['sb_login'] = '';
			$data['sb_frameSecretKey'] = '';			
			$data['sb_partnerId'] = '';
			$data['sb_shopId'] = '';
			
			$data['sb_credit_sub_products'] = array(
				3 => array
					(
						'subproduct' => 'Onl_CSF_0_3_9_new',
						'gracePeriod' => 3,
					),

				5 => array
					(
						'subproduct' => 'Onl_CSF_0-5-9_new',
						'gracePeriod' => 5
					),

				10 => array
					(
						'subproduct' => 'Onl_CSF_0-10-15_new',
						'gracePeriod' => 10
					),

				12 => array
					(
						'subproduct' => 'Onl_CSF_0-12-18_new',
						'gracePeriod' => 12
					),
				);
			
			$data['sb_status'] = 0;
			$data['sb_info'] = array();
			$data['sb_mode'] = 0;
			$data['sb_sort_order'] = 16;
			$data['sb_discount'] = 0;
			$data['sb_special'] = 0;
			$data['sb_stock'] = 0;
			$data['sb_pq'] = 12;
			$data['sb_min_total'] = 500;
			$data['sb_max_total'] = 75000;
			$data['sb_merchantType'] = 'SB';
			$data['sb_markup_acquiring'] = '0';
			$data['sb_markup'] = 1.000;
			$data['sb_enabled'] = 0;
			$data['sb_product_allowed'] = array();
			$data['sb_geo_zone_id'] = 0;
			
			if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
				$this->load->model('extension/extension');
				$this->model_extension_extension->install('payment', 'ukrcredits_sb');
			} else {
				$this->load->model('setting/extension');
				$this->model_setting_extension->install('payment', 'ukrcredits_sb');
			}			
		}
		
		$data['pl_data'] = $this->config->get($type.'ukrcredits_pl_data');

		$data['pl_savedata'] = $this->url->link($dir.'/ukrcredits/savepldata', $token.'token=' . $this->session->data[$token.'token'], true);
		
		if (version_compare(phpversion(), '7.1', '<')) {
			require_once 'uc/ucadm56.php';
		} else {
			require_once 'uc/ucadm71.php';
		}
		
		$data['token'] = $this->session->data[$token.'token'];
		$data['text_token'] = $token.'token';
		
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['shop_id_pp'])) {
            $data['error_shop_id_pp'] = $this->error['shop_id_pp'];
        } else {
            $data['error_shop_id_pp'] = '';
        }
        
        if (isset($this->error['shop_password_pp'])) {
            $data['error_shop_password_pp'] = $this->error['shop_password_pp'];
        } else {
            $data['error_shop_password_pp'] = '';
        }                
        
        if (isset($this->error['pq_pp'])) {
            $data['error_pq_pp'] = $this->error['pq_pp'];
        } else {
            $data['error_pq_pp'] = '';
        }  

        if (isset($this->error['shop_id_ii'])) {
            $data['error_shop_id_ii'] = $this->error['shop_id_ii'];
        } else {
            $data['error_shop_id_ii'] = '';
        }
        
        if (isset($this->error['shop_password_ii'])) {
            $data['error_shop_password_ii'] = $this->error['shop_password_ii'];
        } else {
            $data['error_shop_password_ii'] = '';
        }                
        
        if (isset($this->error['pq_ii'])) {
            $data['error_pq_ii'] = $this->error['pq_ii'];
        } else {
            $data['error_pq_ii'] = '';
        }  		

        if (isset($this->error['shop_id_mb'])) {
            $data['error_shop_id_mb'] = $this->error['shop_id_mb'];
        } else {
            $data['error_shop_id_mb'] = '';
        }
        
        if (isset($this->error['shop_password_mb'])) {
            $data['error_shop_password_mb'] = $this->error['shop_password_mb'];
        } else {
            $data['error_shop_password_mb'] = '';
        }                
        
        if (isset($this->error['pq_mb'])) {
            $data['error_pq_mb'] = $this->error['pq_mb'];
        } else {
            $data['error_pq_mb'] = '';
        }  

        if (isset($this->error['shop_id_ab'])) {
            $data['error_shop_id_ab'] = $this->error['shop_id_ab'];
        } else {
            $data['error_shop_id_ab'] = '';
        }
        
        if (isset($this->error['shop_password_ab'])) {
            $data['error_shop_password_ab'] = $this->error['shop_password_ab'];
        } else {
            $data['error_shop_password_ab'] = '';
        }                
        
        if (isset($this->error['pq_ab'])) {
            $data['error_pq_ab'] = $this->error['pq_ab'];
        } else {
            $data['error_pq_ab'] = '';
        }  

        if (isset($this->error['shop_id_aa'])) {
            $data['error_shop_id_aa'] = $this->error['shop_id_aa'];
        } else {
            $data['error_shop_id_aa'] = '';
        }
        
        if (isset($this->error['shop_password_aa'])) {
            $data['error_shop_password_aa'] = $this->error['shop_password_aa'];
        } else {
            $data['error_shop_password_aa'] = '';
        }                
        
        if (isset($this->error['pq_aa'])) {
            $data['error_pq_aa'] = $this->error['pq_aa'];
        } else {
            $data['error_pq_aa'] = '';
        }
		
        if (isset($this->error['shop_id_pl'])) {
            $data['error_shop_id_pl'] = $this->error['shop_id_pl'];
        } else {
            $data['error_shop_id_pl'] = '';
        }
        
        if (isset($this->error['shop_password_pl'])) {
            $data['error_shop_password_pl'] = $this->error['shop_password_pl'];
        } else {
            $data['error_shop_password_pl'] = '';
        }                
        
        if (isset($this->error['pq_pl'])) {
            $data['error_pq_pl'] = $this->error['pq_pl'];
        } else {
            $data['error_pq_pl'] = '';
        }
 
        if (isset($this->error['shop_id_pu'])) {
            $data['error_shop_id_pu'] = $this->error['shop_id_pu'];
        } else {
            $data['error_shop_id_pu'] = '';
        }
        
        if (isset($this->error['shop_password_pu'])) {
            $data['error_shop_password_pu'] = $this->error['shop_password_pu'];
        } else {
            $data['error_shop_password_pu'] = '';
        }                
        
        if (isset($this->error['pq_pu'])) {
            $data['error_pq_pu'] = $this->error['pq_pu'];
        } else {
            $data['error_pq_pu'] = '';
        }
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $token.'token=' . $this->session->data[$token.'token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($payments_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=payment', true)
		);

        $data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($dir.'/ukrcredits', $token.'token=' . $this->session->data[$token.'token'], true)
        );
                
        $data['action'] = $this->url->link($dir.'/ukrcredits', $token.'token=' . $this->session->data[$token.'token'], true);
        $data['cancel'] = $this->url->link($payments_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=payment', true);

		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

        $this->load->model('catalog/product');
		
		$data['pp_products_allowed'] = array();
		if (!isset($data['pp_product_allowed'])) {
			$data['pp_product_allowed'] = array();
		}
		foreach ($data['pp_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['pp_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}
		
		$data['ii_products_allowed'] = array();
		if (!isset($data['ii_product_allowed'])) {
			$data['ii_product_allowed'] = array();
		}		
		foreach ($data['ii_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['ii_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['mb_products_allowed'] = array();
		if (!isset($data['mb_product_allowed'])) {
			$data['mb_product_allowed'] = array();
		}		
		foreach ($data['mb_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['mb_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['ab_products_allowed'] = array();
		if (!isset($data['ab_product_allowed'])) {
			$data['ab_product_allowed'] = array();
		}		
		foreach ($data['ab_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['ab_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['aa_products_allowed'] = array();
		if (!isset($data['aa_product_allowed'])) {
			$data['aa_product_allowed'] = array();
		}		
		foreach ($data['aa_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['aa_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}
		
		$data['pl_products_allowed'] = array();
		if (!isset($data['pl_product_allowed'])) {
			$data['pl_product_allowed'] = array();
		}		
		foreach ($data['pl_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['pl_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['pu_products_allowed'] = array();
		if (!isset($data['pu_product_allowed'])) {
			$data['pu_product_allowed'] = array();
		}		
		foreach ($data['pu_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['pu_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}
		$data['callback_pu_url'] = HTTPS_CATALOG . 'index.php?route=payment/ukrcredits_pu/callback';
		
		$data['sb_products_allowed'] = array();
		if (!isset($data['sb_product_allowed'])) {
			$data['sb_product_allowed'] = array();
		}		
		foreach ($data['sb_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['sb_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['ib_products_allowed'] = array();
		if (!isset($data['ib_product_allowed'])) {
			$data['ib_product_allowed'] = array();
		}		
		foreach ($data['ib_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['ib_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['ot_products_allowed'] = array();
		if (!isset($data['ot_product_allowed'])) {
			$data['ot_product_allowed'] = array();
		}		
		foreach ($data['ot_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['ot_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['np_products_allowed'] = array();
		if (!isset($data['np_product_allowed'])) {
			$data['np_product_allowed'] = array();
		}		
		foreach ($data['np_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['np_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}
		
		if (version_compare(VERSION,'2.0','>=')) {
			$data['oc15'] = false;
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
		} else {
			$data['oc15'] = true;
			$this->document->addScript('view/javascript/jquery/uctabs.js');
			$this->document->addStyle('view/stylesheet/bootstrap.css');
			$data['column_left'] = false;
			$this->data = $data;
			$this->template = 'payment/ukrcredits.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);		
		}

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

			$this->response->setOutput($template);
		} else if (version_compare(VERSION,'2.3','>=')) {
			$this->response->setOutput($this->load->view('payment/ukrcredits', $data));
		} else if (version_compare(VERSION,'2.0','>=')) {
			$this->response->setOutput($this->load->view('payment/ukrcredits.tpl', $data));
		} else {
			$this->response->setOutput($this->render());
		}
    }
	
	public function license() {
		
		$token = version_compare(VERSION,'3.0','>=') ? 'user_' : '';
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/payment' : 'payment';
		$payments_page = version_compare(VERSION,'3.0','>=') ? 'marketplace/extension' :
			(version_compare(VERSION,'2.3','>=') ? 'extension/extension' : 'extension/payment');
		
		$data = array();
		$data += $this->load->language($dir.'/ukrcredits');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->install();
		
        if ($this->request->server["REQUEST_METHOD"] == "POST") {
			$this->load->model('setting/setting');
			if ($this->config->get($type.'ukrcredits_status')) {
				$setting[$type.'ukrcredits_status'] = $this->config->get($type.'ukrcredits_status');
			}
			if ($this->config->get($type.'ukrcredits_pp_status')) {
				$setting[$type.'ukrcredits_pp_status'] = $this->config->get($type.'ukrcredits_pp_status');
			}
			if ($this->config->get($type.'ukrcredits_ii_status')) {
				$setting[$type.'ukrcredits_ii_status'] = $this->config->get($type.'ukrcredits_ii_status');
			}
			if ($this->config->get($type.'ukrcredits_mb_status')) {
				$setting[$type.'ukrcredits_mb_status'] = $this->config->get($type.'ukrcredits_mb_status');
			}
			if ($this->config->get($type.'ukrcredits_ab_status')) {
				$setting[$type.'ukrcredits_ab_status'] = $this->config->get($type.'ukrcredits_ab_status');
			}
			if ($this->config->get($type.'ukrcredits_aa_status')) {
				$setting[$type.'ukrcredits_aa_status'] = $this->config->get($type.'ukrcredits_aa_status');
			}			
			if ($this->config->get($type.'ukrcredits_pl_status')) {
				$setting[$type.'ukrcredits_pl_status'] = $this->config->get($type.'ukrcredits_pl_status');
			}
			if ($this->config->get($type.'ukrcredits_pu_status')) {
				$setting[$type.'ukrcredits_pu_status'] = $this->config->get($type.'ukrcredits_pu_status');
			}		
			if ($this->config->get($type.'ukrcredits_sb_status')) {
				$setting[$type.'ukrcredits_sb_status'] = $this->config->get($type.'ukrcredits_sb_status');
			}	
			if ($this->config->get($type.'ukrcredits_ib_status')) {
				$setting[$type.'ukrcredits_ib_status'] = $this->config->get($type.'ukrcredits_ib_status');
			}
			if ($this->config->get($type.'ukrcredits_ot_status')) {
				$setting[$type.'ukrcredits_ot_status'] = $this->config->get($type.'ukrcredits_ot_status');
			}
			if ($this->config->get($type.'ukrcredits_np_status')) {
				$setting[$type.'ukrcredits_np_status'] = $this->config->get($type.'ukrcredits_np_status');
			}
			$setting[$type.'ukrcredits_pp_sort_order'] = $this->config->get($type.'ukrcredits_pp_sort_order');
			$setting[$type.'ukrcredits_ii_sort_order'] = $this->config->get($type.'ukrcredits_ii_sort_order');
			$setting[$type.'ukrcredits_mb_sort_order'] = $this->config->get($type.'ukrcredits_mb_sort_order');
			$setting[$type.'ukrcredits_ab_sort_order'] = $this->config->get($type.'ukrcredits_ab_sort_order');
			$setting[$type.'ukrcredits_aa_sort_order'] = $this->config->get($type.'ukrcredits_aa_sort_order');
			$setting[$type.'ukrcredits_pl_sort_order'] = $this->config->get($type.'ukrcredits_pl_sort_order');
			$setting[$type.'ukrcredits_pu_sort_order'] = $this->config->get($type.'ukrcredits_pu_sort_order');
			$setting[$type.'ukrcredits_sb_sort_order'] = $this->config->get($type.'ukrcredits_sb_sort_order');
			
			$setting[$type.'ukrcredits_ib_sort_order'] = $this->config->get($type.'ukrcredits_ib_sort_order');
			$setting[$type.'ukrcredits_ot_sort_order'] = $this->config->get($type.'ukrcredits_ot_sort_order');
			$setting[$type.'ukrcredits_np_sort_order'] = $this->config->get($type.'ukrcredits_np_sort_order');
			$setting[$type.'ukrcredits_settings'] = $this->config->get($type.'ukrcredits_settings');
			$setting[$type.'ukrcredits_pl_data'] = $this->config->get($type.'ukrcredits_pl_data');
			$setting[$type.'ukrcredits_pl_id_data'] = $this->config->get($type.'ukrcredits_pl_id_data');
			$setting[$type.'ukrcredits_license'] = $this->request->post['ukrcredits_license'];
            $this->model_setting_setting->editSetting($type.'ukrcredits', $setting);
			if (version_compare(VERSION,'2.0','>=')) {
				$this->response->redirect($this->url->link($dir.'/ukrcredits', $token.'token=' . $this->session->data[$token.'token'], true));
			} else {
				$this->redirect($this->url->link($dir.'/ukrcredits', 'token=' . $this->session->data['token'], 'SSL'));
			}			
        }
		
        $data['action'] = $this->url->link('payment/ukrcredits/license', $token.'token=' . $this->session->data[$token.'token'], true);
        $data['cancel'] = $this->url->link($payments_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=payment', true);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $token.'token=' . $this->session->data[$token.'token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($payments_page, $token.'token=' . $this->session->data[$token.'token'] . '&type=payment', true)
		);

        $data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($dir.'/ukrcredits', $token.'token=' . $this->session->data[$token.'token'], true)
        );

		$this->error['error_license'] = $this->language->get('text_ukrcredits_license_error');	

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['error_license'])) {
            $data['error_license'] = $this->error['error_license'];
        } else {
            $data['error_license'] = '';
        }
		
		if (version_compare(VERSION,'2.0','>=')) {
			$data['oc15'] = false;
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
		} else {
			$data['oc15'] = true;
			$this->document->addStyle('view/stylesheet/bootstrap.css');
			$data['column_left'] = false;
			$this->data = $data;
			$this->template = 'payment/ukrcredits_license.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);		
		}
		
		if (version_compare(VERSION, '3.0.0', '>=')) {
			$template_engine = $this->registry->get('config')->get('template_engine');
			$template_directory = $this->registry->get('config')->get('template_directory');
			$this->registry->get('config')->set('template_engine', 'template');
			if (!file_exists(DIR_TEMPLATE . $template_directory . 'payment/ukrcredits_license' . '.tpl')) {
				$this->registry->get('config')->set('template_directory', 'default/template/');
			}
			$template = $this->load->view('payment/ukrcredits_license', $data);
			
			$this->registry->get('config')->set('template_engine', $template_engine);
			$this->registry->get('config')->set('template_directory', $template_directory);
			$this->response->setOutput($template);
		} else if (version_compare(VERSION,'2.3','>=')) {
			$this->response->setOutput($this->load->view('payment/ukrcredits_license', $data));
		} else if (version_compare(VERSION,'2.0','>=')) {
			$this->response->setOutput($this->load->view('payment/ukrcredits_license.tpl', $data));
		} else {
			$this->response->setOutput($this->render());
		}
	}
    
    public function validate() {
        if (!$this->user->hasPermission('modify', 'payment/ukrcredits')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
        if (!$this->request->post['pp_shop_id'] && $this->request->post['pp_status']) {
            $this->error['shop_id_pp'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['pp_shop_password'] && $this->request->post['pp_status']) {
            $this->error['shop_password_pp'] = $this->language->get('error_shop_password');
        }

        if (($this->request->post['pp_pq'] > 24 || $this->request->post['pp_pq'] <= 0) && $this->request->post['pp_status']) {
            $this->error['pq_pp'] = $this->language->get('error_pq');
        }
		
        if (!$this->request->post['ii_shop_id'] && $this->request->post['ii_status']) {
            $this->error['shop_id_ii'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['ii_shop_password'] && $this->request->post['ii_status']) {
            $this->error['shop_password_ii'] = $this->language->get('error_shop_password');
        }

        if (($this->request->post['ii_pq'] > 24 || $this->request->post['ii_pq'] <= 0) && $this->request->post['ii_status']) {
            $this->error['pq_ii'] = $this->language->get('error_pq');
        }
		
        if (!$this->request->post['mb_shop_id'] && $this->request->post['mb_status']) {
            $this->error['shop_id_mb'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['mb_shop_password'] && $this->request->post['mb_status']) {
            $this->error['shop_password_mb'] = $this->language->get('error_shop_password');
        }

        if (($this->request->post['mb_pq'] > 24 || $this->request->post['mb_pq'] <= 1) && $this->request->post['mb_status']) {
            $this->error['pq_mb'] = $this->language->get('error_pq');
        }

        if (!$this->request->post['ab_shop_id'] && $this->request->post['ab_status']) {
            $this->error['shop_id_ab'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['ab_shop_password'] && $this->request->post['ab_status']) {
            $this->error['shop_password_ab'] = $this->language->get('error_shop_password');
        }
		
        if (!$this->request->post['aa_shop_id'] && $this->request->post['aa_status']) {
            $this->error['shop_id_aa'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['aa_shop_password'] && $this->request->post['aa_status']) {
            $this->error['shop_password_aa'] = $this->language->get('error_shop_password');
        }

        if (($this->request->post['aa_pq'] > 24 || $this->request->post['aa_pq'] <= 1) && $this->request->post['aa_status']) {
            $this->error['pq_aa'] = $this->language->get('error_aa');
        }
		
        if (!$this->request->post['pl_shop_id'] && $this->request->post['pl_status']) {
            $this->error['shop_id_pl'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['pl_shop_password'] && $this->request->post['pl_status']) {
//            $this->error['shop_password_pl'] = $this->language->get('error_shop_password');
        }

        if (($this->request->post['pl_pq'] > 24 || $this->request->post['pl_pq'] <= 1) && $this->request->post['pl_status']) {
            $this->error['pq_pl'] = $this->language->get('error_pl');
        } 
		
        if (!$this->request->post['pu_shop_id'] && $this->request->post['pu_status']) {
            $this->error['shop_id_pu'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['pu_shop_password'] && $this->request->post['pu_status']) {
            $this->error['shop_password_pu'] = $this->language->get('error_shop_password');
        }

        if (($this->request->post['pu_pq'] > 24 || $this->request->post['pu_pq'] < 1) && $this->request->post['pu_status']) {
            $this->error['pq_pu'] = $this->language->get('error_pu');
        }
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
        return !$this->error;
    }

	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_ukrcredits` (
		  `product_id` int(11) NOT NULL,
		  `product_pp` int(1) NOT NULL,
		  `product_ii` int(1) NOT NULL,
		  `product_mb` int(1) NOT NULL,
		  `product_ab` int(1) NOT NULL,
		  `product_aa` int(1) NOT NULL,
		  `product_pl` int(1) NOT NULL,
		  `product_pu` int(1) NOT NULL,
		  `product_sb` int(1) NOT NULL,
		  `partscount_pp` int(2) NOT NULL,
		  `partscount_ii` int(2) NOT NULL,
		  `partscount_mb` int(2) NOT NULL,
		  `partscount_ab` int(2) NOT NULL,
		  `partscount_aa` int(2) NOT NULL,
		  `partscount_pl` int(2) NOT NULL,
		  `partscount_pu` int(2) NOT NULL,
		  `partscount_sb` int(2) NOT NULL,
		  `markup_pp` decimal(15,4) NOT NULL,
		  `markup_ii` decimal(15,4) NOT NULL,
		  `markup_mb` decimal(15,4) NOT NULL,
		  `markup_ab` decimal(15,4) NOT NULL,
		  `markup_aa` decimal(15,4) NOT NULL,
		  `markup_pl` decimal(15,4) NOT NULL,
		  `markup_pu` decimal(15,4) NOT NULL,
		  `markup_sb` decimal(15,4) NOT NULL,
		  `special_pp` int(1) NOT NULL,
		  `special_ii` int(1) NOT NULL,
		  `special_mb` int(1) NOT NULL,
		  `special_ab` int(1) NOT NULL,
		  `special_aa` int(1) NOT NULL,
		  `special_pl` int(1) NOT NULL,
		  `special_pu` int(1) NOT NULL,
		  `special_sb` int(1) NOT NULL,
		  `discount_pp` int(1) NOT NULL,
		  `discount_ii` int(1) NOT NULL,
		  `discount_mb` int(1) NOT NULL,
		  `discount_ab` int(1) NOT NULL,
		  `discount_aa` int(1) NOT NULL,
		  `discount_pl` int(1) NOT NULL,
		  `discount_pu` int(1) NOT NULL,
		  `discount_sb` int(1) NOT NULL,
		  PRIMARY KEY (`product_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "order_ukrcredits` (
		  `order_id` int(11) NOT NULL,
		  `ukrcredits_payment_type` varchar(2) NOT NULL,
		  `ukrcredits_order_id` varchar(64) NOT NULL,
		  `ukrcredits_order_status` varchar(64) NOT NULL,
		  `ukrcredits_order_substatus` varchar(64) NOT NULL,
		  PRIMARY KEY (`order_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

		if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
			$this->load->model('extension/extension');
			$this->model_extension_extension->install('payment', 'ukrcredits_pp');
			$this->model_extension_extension->install('payment', 'ukrcredits_ii');
			$this->model_extension_extension->install('payment', 'ukrcredits_mb');
			$this->model_extension_extension->install('payment', 'ukrcredits_ab');
			$this->model_extension_extension->install('payment', 'ukrcredits_aa');
			$this->model_extension_extension->install('payment', 'ukrcredits_pl');
			$this->model_extension_extension->install('payment', 'ukrcredits_pu');
			$this->model_extension_extension->install('payment', 'ukrcredits_sb');
		} else {
			$this->load->model('setting/extension');
			$this->model_setting_extension->install('payment', 'ukrcredits_pp');
			$this->model_setting_extension->install('payment', 'ukrcredits_ii');
			$this->model_setting_extension->install('payment', 'ukrcredits_mb');
			$this->model_setting_extension->install('payment', 'ukrcredits_ab');
			$this->model_setting_extension->install('payment', 'ukrcredits_aa');
			$this->model_setting_extension->install('payment', 'ukrcredits_pl');
			$this->model_setting_extension->install('payment', 'ukrcredits_pu');
			$this->model_setting_extension->install('payment', 'ukrcredits_sb');
		}
		if (version_compare(VERSION,'2.3','>=') && version_compare(VERSION,'3.0','<')) {
			$this->load->model('extension/event');
			$this->model_extension_event->addEvent('payment_ukrcredits', 'catalog/controller/extension/payment/*/before', 'module/ukrcredits/controller', 1, 0);
		}
	}
	
	public function uninstall() {
		if (version_compare(VERSION,'2.0','>=') && version_compare(VERSION,'3.0','<')) {
			$this->load->model('extension/extension');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_pp');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_ii');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_mb');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_ab');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_aa');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_pl');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_pu');
			$this->model_extension_extension->uninstall('payment', 'ukrcredits_sb');
		} else {
			$this->load->model('setting/extension');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_pp');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_ii');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_mb');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_ab');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_aa');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_pl');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_pu');
			$this->model_setting_extension->uninstall('payment', 'ukrcredits_sb');
		}
		if (version_compare(VERSION,'2.3','>=') && version_compare(VERSION,'3.0','<')) {
			$this->load->model('extension/event');
			$this->model_extension_event->deleteEvent('payment_ukrcredits');
		}
	}
	
	public function controller(&$route) {
		if ($route == 'extension/payment/ukrcredits' || $route == 'extension/total/totalukrcredits') {

			$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			list($base, $folder, $extension) = array_pad(explode('/', $route), 3, NULL);
			
			if (($base == 'extension') && !is_file(DIR_APPLICATION.'controller/'.$route.'.php') && (!is_null($folder) && !is_null($extension) && is_file(DIR_APPLICATION.'controller/'.$folder.'/'.$extension.'.php'))) {
				$route = $folder.'/'.$extension;
			}
		}
	}
	
    public function askstatus_ab (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$signature = base64_encode($setting['ab_shop_id'].':'.$setting['ab_shop_password']);
		$url = 'https://' . ($setting['ab_mode']?'':'retail') . 'api.sensebank.kyiv.ua:8243/api/PartnerInstallment/v1.0/getOrder/'.$setting['ab_shop_id'].'?orderId='.$ukrcredits_order_id;
		$responseResDeal = $this->curlPostWithDataABget($url, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['messageId']) && $responseResDeal['messageId']) {
				$this->log->write('ukrcredits_mb успешный запрос состояния заказа ' . $responseResDeal['orderId']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['statusCode']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['statusText']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['orderId']) . "'");
			} elseif (isset($responseResDeal['message']) && $responseResDeal['message']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['statusCode'] . ' / ' . $responseResDeal['statusText']);
			}
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function cancelhold_ab (){ 
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}

		$data_deal['orderId'] = $ukrcredits_order_id;
		$data_deal['cancelId'] = rand(10000, 99999);
		$request = json_encode($data_deal);
		$url = 'https://' . ($setting['ab_mode']?'':'retail') . 'api.sensebank.kyiv.ua:8243/api/PartnerInstallment/v1.0/cancelOrder/'.$setting['ab_shop_id'];
		$responseResDeal = $this->curlPostWithDataABpost($url, $request);
	
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['statusCode']) && $responseResDeal['statusCode'] == 'CANCEL_IS_OK') {
				$this->log->write('ukrcredits_mb успешная отмена заказа ' . $responseResDeal['orderId']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['statusCode']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['statusText']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['orderId']) . "'");
				$responseResDeal['order_status_id'] = $setting['canceled_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_canceled');
			
			} elseif (isset($responseResDeal['statusText']) && $responseResDeal['statusText']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['statusText']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function confirmhold_ab (){ 
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}

		$data_deal['orderId'] = $ukrcredits_order_id;
		$data_deal['messageId'] = rand(10000, 99999);
		$request = json_encode($data_deal);
		$url = 'https://' . ($setting['ab_mode']?'':'retail') . 'api.sensebank.kyiv.ua:8243/api/PartnerInstallment/v1.0/confirmOrder/'.$setting['ab_shop_id'];
		$responseResDeal = $this->curlPostWithDataABpost($url, $request);
	
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['statusCode']) && $responseResDeal['statusCode'] == 'CONFIRM_IS_OK') {
				$this->log->write('ukrcredits_mb успешное подтверждение заказа ' . $responseResDeal['orderId']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['statusCode']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['statusText']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['orderId']) . "'");
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_confirmed');
			
			} elseif (isset($responseResDeal['statusText']) && $responseResDeal['statusText']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['statusText']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function askstatus_mb (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['mb_shop_password'], true));
		$url = 'https://' . ($setting['mb_mode']?'u2.monobank.com.ua':'u2-demo-ext.mono.st4g3.com') . '/api/order/state';
		$responseResDeal = $this->curlPostWithDataMB($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['order_id']) && $responseResDeal['order_id']) {
				$this->log->write('ukrcredits_mb успешный запрос состояния заказа ' . $responseResDeal['order_id']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['order_id']) . "'");
			} elseif (isset($responseResDeal['message']) && $responseResDeal['message']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['message']);
			}
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function cancelhold_mb (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['mb_shop_password'], true));
		$url = 'https://' . ($setting['mb_mode']?'u2.monobank.com.ua':'u2-demo-ext.mono.st4g3.com') . '/api/order/reject';
		$responseResDeal = $this->curlPostWithDataMB($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['order_id']) && $responseResDeal['order_id']) {
				$this->log->write('ukrcredits_mb успешная отмена заказа ' . $responseResDeal['order_id']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['order_id']) . "'");
				$responseResDeal['order_status_id'] = $setting['canceled_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_canceled');
			
			} elseif (isset($responseResDeal['message']) && $responseResDeal['message']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['message']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function confirmhold_mb (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['mb_shop_password'], true));
		$url = 'https://' . ($setting['mb_mode']?'u2.monobank.com.ua':'u2-demo-ext.mono.st4g3.com') . '/api/order/confirm';
		$responseResDeal = $this->curlPostWithDataMB($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['order_id']) && $responseResDeal['order_id']) {
				$this->log->write('ukrcredits_mb успешное подтверждение заказа ' . $responseResDeal['order_id']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['order_id']) . "'");
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_confirmed');
			
			} elseif (isset($responseResDeal['message']) && $responseResDeal['message']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['message']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}	
	
	public function return_mb (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		if (isset($this->request->get['summ'])) {
			$summ = $this->request->get['summ'];
		} else {
			$summ = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$data_deal['return_money_to_card'] = true;
		$data_deal['store_return_id'] = rand(1000000, 9999999);
		$data_deal['sum'] = $summ;
	
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['mb_shop_password'], true));
		$url = 'https://' . ($setting['mb_mode']?'u2.monobank.com.ua':'u2-demo-ext.mono.st4g3.com') . '/api/order/return';
		$responseResDeal = $this->curlPostWithDataMB($url, $requestDial, $signature);

        if(is_array($responseResDeal)){
			if(isset($responseResDeal['status']) && $responseResDeal['status']) {
				$this->log->write('ukrcredits_mb успешное подтверждение возврата ' . $responseResDeal['status']);
				$responseResDeal['comment'] = $this->language->get('text_order_returned') . $summ;
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
			} elseif (isset($responseResDeal['message']) && $responseResDeal['message']) {
				$this->log->write('ukrcredits_mb по время запроса произошла ошибка ' . $responseResDeal['message']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}

    public function askstatus_aa (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$data_deal['store'] = $setting['aa_shop_id'];
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['aa_shop_password'], true));
		$url = 'https://' . ($setting['aa_mode']?'midgard.a-bank.com.ua/partpay/common':'midgard.a-bank.com.ua/partpay/common') . '/getLoanStatus';
		$responseResDeal = $this->curlPostWithDataAA($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state'])) {
				$this->log->write('ukrcredits_aa успешный запрос состояния заказа ' . $ukrcredits_order_id);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");
				$responseResDeal['order_id'] = $ukrcredits_order_id;
			} elseif (isset($responseResDeal['error']) && $responseResDeal['error']) {
				$this->log->write('ukrcredits_aa по время запроса произошла ошибка ' . $responseResDeal['error']['status'] . ' '. $responseResDeal['error']['title']);
			}
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function confirmhold_aa (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$data_deal['store'] = $setting['aa_shop_id'];
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['aa_shop_password'], true));
		$url = 'https://' . ($setting['aa_mode']?'midgard.a-bank.com.ua/partpay/common':'midgard.a-bank.com.ua/partpay/common') . '/confirmLoan';
		$responseResDeal = $this->curlPostWithDataAA($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state'])) {
				$this->log->write('ukrcredits_mb успешное подтверждение заказа ' . $ukrcredits_order_id);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_confirmed');
				$responseResDeal['order_id'] = $ukrcredits_order_id;
			} elseif (isset($responseResDeal['error']) && $responseResDeal['error']) {
				$this->log->write('ukrcredits_aa по время запроса произошла ошибка ' . $responseResDeal['error']['status'] . ' '. $responseResDeal['error']['title']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function cancelhold_aa (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$data_deal['store'] = $setting['aa_shop_id'];
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['aa_shop_password'], true));
		$url = 'https://' . ($setting['aa_mode']?'midgard.a-bank.com.ua/partpay/common':'midgard.a-bank.com.ua/partpay/common') . '/cancelLoan';
		$responseResDeal = $this->curlPostWithDataAA($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state'])) {
				$this->log->write('ukrcredits_mb успешная отмена заказа ' . $ukrcredits_order_id);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");
				$responseResDeal['order_status_id'] = $setting['canceled_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_canceled');
				$responseResDeal['order_id'] = $ukrcredits_order_id;
			} elseif (isset($responseResDeal['error']) && $responseResDeal['error']) {
				$this->log->write('ukrcredits_aa по время запроса произошла ошибка ' . $responseResDeal['error']['status'] . ' '. $responseResDeal['error']['title']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function return_aa (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		if (isset($this->request->get['summ'])) {
			$summ = $this->request->get['summ'];
		} else {
			$summ = 0;
		}
		
		$data_deal['order_id'] = $ukrcredits_order_id;
		$data_deal['store'] = $setting['aa_shop_id'];
		$data_deal['return_money_to_card'] = true;
		$data_deal['store_return_id'] = rand(1000000, 9999999);
		$data_deal['sum'] = $summ;
		
		$requestDial = json_encode($data_deal);
		$signature = base64_encode(hash_hmac("sha256", $requestDial, $setting['aa_shop_password'], true));
		$url = 'https://' . ($setting['aa_mode']?'midgard.a-bank.com.ua/partpay/common':'midgard.a-bank.com.ua/partpay/common') . '/Refund';
		$responseResDeal = $this->curlPostWithDataAA($url, $requestDial, $signature);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state'])) {
				$this->log->write('ukrcredits_aa успешное подтверждение возврата ' . $ukrcredits_order_id);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");
				$responseResDeal['comment'] = $this->language->get('text_order_returned') . $summ;
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
				$responseResDeal['order_id'] = $ukrcredits_order_id;
			} elseif (isset($responseResDeal['status']) && $responseResDeal['status']) {
				$this->log->write('ukrcredits_aa по время запроса произошла ошибка ' . $responseResDeal['status'] . ' '. $responseResDeal['message']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function askstatus_pp (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
			$payment_code = $this->request->get['payment_code'];
		} else {
			$ukrcredits_order_id = 0;
			$payment_code = 0;
		}
		
		$data_deal['storeId'] = $setting[substr($payment_code, -2) . '_shop_id'];
		$data_deal['orderId'] = $ukrcredits_order_id;
		$data_deal['showRefund'] = true;
		$data_deal['showAmount'] = true;
		$data_deal['signature'] = $this->generateSignature($payment_code, $data_deal);

        $requestDial = json_encode($data_deal);       
        $url = 'https://payparts2.privatbank.ua/ipp/v2/payment/state';     
		
		$responseResDeal = $this->curlPostWithData($url,$requestDial);

        if(is_array($responseResDeal)){
            if(strcmp($responseResDeal['state'], 'FAIL') == 0){
                $this->log->write('PRIVATBANK_PAYMENTPARTS :: REFRESH STATUS failed: ' . json_encode($responseResDeal));                
            }            
            if(strcmp($responseResDeal['state'], 'SUCCESS') == 0){
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['paymentState']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");				
            }   
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}	
	
    public function confirmhold_pp (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
			$payment_code = $this->request->get['payment_code'];
		} else {
			$ukrcredits_order_id = 0;
			$payment_code = 0;
		}
		
		$data_deal['storeId'] = $setting[substr($payment_code, -2) . '_shop_id'];
		$data_deal['orderId'] = $ukrcredits_order_id;
		$data_deal['signature'] = $this->generateSignature($payment_code, $data_deal);

        $requestDial = json_encode($data_deal);       
        $url = 'https://payparts2.privatbank.ua/ipp/v2/payment/confirm';     
		
		$responseResDeal = $this->curlPostWithData($url,$requestDial);

        if(is_array($responseResDeal)){
            if(strcmp($responseResDeal['state'], 'FAIL') == 0){
                $this->log->write('PRIVATBANK_PAYMENTPARTS :: CONFIRM failed: ' . json_encode($responseResDeal));                
            }            
            if(strcmp($responseResDeal['state'], 'SUCCESS') == 0){
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = 'SUCCESS' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");				
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_confirmed');
            }   
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function cancelhold_pp (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['ukrcredits_order_id'])) {
			$ukrcredits_order_id = $this->request->get['ukrcredits_order_id'];
			$payment_code = $this->request->get['payment_code'];
		} else {
			$ukrcredits_order_id = 0;
			$payment_code = 0;
		}
		
		$data_deal['storeId'] = $setting[substr($payment_code, -2) . '_shop_id'];
		$data_deal['orderId'] = $ukrcredits_order_id;
		$data_deal['signature'] = $this->generateSignature($payment_code, $data_deal);

        $requestDial = json_encode($data_deal);       
        $url = 'https://payparts2.privatbank.ua/ipp/v2/payment/cancel';     
		
		$responseResDeal = $this->curlPostWithData($url,$requestDial);

        if(is_array($responseResDeal)){
            if(strcmp($responseResDeal['state'], 'FAIL') == 0){
                $this->log->write('PRIVATBANK_PAYMENTPARTS :: CANCEL failed: ' . json_encode($responseResDeal));                
            }            
            if(strcmp($responseResDeal['state'], 'SUCCESS') == 0){
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = 'CANCELED' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");				
				$responseResDeal['order_status_id'] = $setting['canceled_status_id'];
				$responseResDeal['comment'] = $this->language->get('text_order_canceled');
            }   

            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    private function generateSignature ($payment_code, $dataAnsweArr){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
        $passwordStore = $setting[substr($payment_code, -2) . '_shop_password'];
        
        $signatureAnswerStr = $passwordStore.
							  $dataAnsweArr['storeId'].
                              $dataAnsweArr['orderId'].
                              $passwordStore;
                              
        $signatureAnswer = base64_encode(SHA1($signatureAnswerStr, true));
		
        return $signatureAnswer;
        
    }
	
    private function curlPostWithData($url, $request) {
		try {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','Accept-Encoding: UTF-8','Content-Type: application/json; charset=UTF-8'));
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			$curl_errno = curl_errno($curl);
			$curl_error = curl_error($curl);
			$aInfo = @curl_getinfo($curl);            
			//close curl
			curl_close($curl);          
			//analysis of the information received
	   
			if($curl_errno!=0){
				$this->log->write('PRIVATBANK_PAYMENTPARTS :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
				return 'error';
			} 
			if($aInfo["http_code"]!='200'){
				$this->log->write('PRIVATBANK_PAYMENTPARTS :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')');  
				return 'error';
			} 
			return json_decode($response,true);
		   
		} catch(Exception $e){
			return false;
		}
    }
	
    private function curlPostWithDataMB($url, $requestDial, $signature) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDial);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Accept: application/json',
				'Accept-Encoding: UTF-8',
				'Content-Type: application/json; charset=UTF-8',
				'store-id: '.$setting['mb_shop_id'],
				'signature: '.$signature
			));

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   
			if($curl_errno!=0){
				$this->log->write('ukrcredits_mb :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
				return $this->language->get('error_curl');
			} 
			return json_decode($response,true);
		   
		} catch(Exception $e){
			return false;
		}
    }
	
    private function curlPostWithDataAA($url, $requestDial, $signature) { 
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDial);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Accept: application/json',
				'Accept-Encoding: UTF-8',
				'Content-Type: application/json; charset=UTF-8',
				'store-id: '.$setting['aa_shop_id'],
				'signature: '.$signature
			));

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   
			if($curl_errno!=0){
				$this->log->write('ukrcredits_mb :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
				return $this->language->get('error_curl');
			} 
			return json_decode($response,true);
		   
		} catch(Exception $e){
			return false;
		}
    }
	
    private function curlPostWithDataABget($url, $signature) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$signature));

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   
			if($curl_errno!=0){
				$this->log->write('ukrcredits_ab :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
				return $this->language->get('error_curl');
			} 
			return json_decode($response,true);
		   
		} catch(Exception $e){
			return false;
		}
    }
	
    private function curlPostWithDataABpost($url, $request) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		$shopId = $setting['ab_shop_id'];

		$shopPassword = $setting['ab_shop_password'];	
		try{
			$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_USERPWD, $shopId . ":" . $shopPassword);

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   
			if($curl_errno!=0){
				$this->log->write('ukrcredits_ab :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
				return $this->language->get('error_curl');
			} 
			return json_decode($response,true);
		   
		} catch(Exception $e){
			return false;
		}
    }
	
    public function asktokenPLget() {
		$json = array();
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		if (isset($this->request->get['shopid'])) {
			$shopid = $this->request->get['shopid'];
		} else {
			$shopid = $setting['pl_shop_id'];
		}

		$url = 'https://api.paylate.com.ua/gettoken.php?token=' . $shopid;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          

			if ($aInfo && $aInfo['http_code'] == 200) {
				$json['success'] = json_decode($response,true);
			} else {
				$json['error'] = $aInfo;
			}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    } 
	
    public function askPacketsPLget() {

		$url = 'https://api.paylate.com.ua/get_data.php?token=' . $this->request->get['tokenpl'] . '&ask=packets';
		
		$responseResDeal = $this->curlGetDataPL($url);

        if(is_array($responseResDeal)){
            echo json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
    }

    public function askStatusPLget (){
		$url = 'https://api.paylate.com.ua/get_data.php?token=' . $this->request->get['tokenpl'] . '&ask=on_id&ids=' . $this->request->get['id'];
		
		$responseResDeal = $this->curlGetDataPL($url);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['status']) && $responseResDeal['status'] == 5) {
				$this->log->write('ukrcredits_pl успешный запрос состояния заказа ' . $responseResDeal['inv0']['id']);
				$this->log->write($responseResDeal);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['inv0']['state_utf']) . "', ukrcredits_order_substatus = '' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['inv0']['id']) . "'");
			} elseif (isset($responseResDeal['status']) && $responseResDeal['status']) {
				$this->log->write('ukrcredits_pl по время запроса произошла ошибка ' . $responseResDeal['status'] . ' / ' . $responseResDeal['data']);
			}
            echo json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}

    public function inser_dataPLpost (){
		$url = 'https://api.paylate.com.ua/inser_data.php?token=' . $this->request->get['tokenpl'];
		
		$data_deal['token'] = $this->request->get['token'];
		$data_deal['ask'] = 'request';
		$data_deal['claimId'] = $this->request->get['id'];
		$data_deal['actionCode'] = $this->request->get['action'];
		$data_deal['comment'] = $this->request->get['action'];

        $requestDial = json_encode($data_deal); 
		
		$responseResDeal = $this->curlPostWithDataPL($url, $requestDial);
		
        if(is_array($responseResDeal)){
            echo json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
	public function curlGetDataPL($url) {
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   
			if($curl_errno!=0){
				$this->log->write('ukrcredits_pl :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
				return $this->language->get('error_curl');
			} 
			return json_decode($response,true);
		   
		} catch(Exception $e){
			return false;
		}		
	}
	
    public function curlPostWithDataPL($url, $request) {

			try {
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
				
				//execute curl
				$response = curl_exec($curl);
			
				//get execute result
				$curl_errno = curl_errno($curl);
				$curl_error = curl_error($curl);
				$aInfo = @curl_getinfo($curl);            
				//close curl
				curl_close($curl);          
				//analysis of the information received
				$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
				$this->language->load($dir.'/ukrcredits');  
				if($curl_errno!=0){
					$this->log->write('ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
					$response = array (
						'errorMessage' => 'ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')',
						'state' => 'FAIL'
					);
					return $response;
				} 
				if($aInfo["http_code"]!='200'){
					$this->log->write('ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')');  
					$responsem = array (
						'errorMessage' => 'ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')',
						'state' => 'FAIL'
					);
					return $responsem;
				} 

				return json_decode($response,true);
			   
			} catch(Exception $e){
				return false;
			}

    }
	
	public function savepldata() {
		
		$json = array();		
		if (isset($this->request->post['packets'])) {
			$this->load->model('setting/setting');			
			$packets = $this->request->post['packets'];
			
			for ($i = 0; $i <= ($packets['count']-1); $i++) {
				$shortpackets[$packets['pack'.$i]['count']-1] = $packets['pack'.$i]['coef'];
			}
			
			for ($i = 0; $i <= ($packets['count']-1); $i++) {
				$idpackets[$packets['pack'.$i]['count']-1] = $packets['pack'.$i]['id'];
			}
			
			$packets['data'] = $shortpackets;
			$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
			$setting = $this->model_setting_setting->getSetting($type.'ukrcredits');
			$setting[$type.'ukrcredits_pl_data'] = $packets;
			$setting[$type.'ukrcredits_pl_id_data'] = $idpackets;
			$this->model_setting_setting->editSetting($type.'ukrcredits', $setting);
			$json['success'] = true;
			$json['data'] = $shortpackets;
		} else {
			$json['error'] = true;	
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
    public function asktokenPUpost() {
		$json = array();
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		
		$requestTokenurl = 'https://' . ($setting['pu_mode']?'authsrv.pumb.ua/auth/realms/pumb_ext/protocol/openid-connect':'auth.dts.fuib.com/auth/realms/pumb_ext/protocol/openid-connect') . '/token';
			
		$request['client_id'] = 'EXT_OIC';
		$request['username'] = $setting['pu_shop_id'];
		$request['password'] = $setting['pu_shop_password'];
		$request['grant_type'] = 'password';	

			$curl = curl_init($requestTokenurl);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($request));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			
			//execute curl
			$response = curl_exec($curl);
		
			//get execute result
			$curl_errno = curl_errno($curl);
			$curl_error = curl_error($curl);
			$aInfo = @curl_getinfo($curl);            
			//close curl
			curl_close($curl);                 

			if ($aInfo && $aInfo['http_code'] == 200) {
				$json['success'] = json_decode($response,true);
			} else {
				$json['error'] = $response;
			}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }
	
    public function askStatusPUget (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		$url = 'https://' . ($setting['pu_mode']?'apiext.pumb.ua/ext-oic/galadriel/v1/sf-credits/':'api.dts.fuib.com/ext-oic/galadriel/v1/sf-credits/') . $this->request->get['id'];
		
		$access_token = $this->request->get['tokenpu'];
		
		$responseResDeal = $this->curlGetDataPU($url, $access_token);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state']) && $responseResDeal['state'] && isset($responseResDeal['id']) && $responseResDeal['id']) {
				$this->log->write('ukrcredits_pl успешный запрос состояния заказа ' . $responseResDeal['state']);
				$this->log->write($responseResDeal);
				if(isset($responseResDeal['guarantee_letter']) && $responseResDeal['guarantee_letter']) {
					$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['guarantee_letter']['content']['customer_agreement']['number']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['id']) . "'");
				} else {
					$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['id']) . "'");
				}
			} elseif (isset($responseResDeal['status']) && $responseResDeal['status']) {
				$this->log->write('ukrcredits_pl по время запроса произошла ошибка ' . $responseResDeal['status'] . ' / ' . $responseResDeal['data']);
			}
            echo json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
	public function curlGetDataPU($url,$access_token) {
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer ' . $access_token,
				'Cache-Control: no-cache',
				'Connection: keep-alive',
				'Content-Type: application/json',
				'Host: ' . parse_url($url, PHP_URL_HOST),
			//	'Postman-Token: ' . $responseToken['session_state'],
				'User-Agent: PostmanRuntime/7.15.0',
				'X-Flow-ID: 1',
				'accept-encoding: gzip, deflate',
			));

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   

				if($curl_errno!=0){
					$this->log->write('ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
					$response = array (
						'errorMessage' => 'ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')',
						'state' => 'FAIL'
					);
					return $response;
				} 
				if($aInfo["http_code"]!='200'){
					$this->log->write('ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')');  
					$responsem = array (
						'errorMessage' => 'ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')',
						'state' => 'FAIL'
					);
					return $responsem;
				} 

				return json_decode($response,true);			

		} catch(Exception $e){
			return false;
		}		
	}

    public function confirmhold_PU (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		$url = 'https://' . ($setting['pu_mode']?'apiext.pumb.ua/ext-oic/galadriel/v1/sf-credits/':'api.dts.fuib.com/ext-oic/galadriel/v1/sf-credits/') . $this->request->get['id'];
		$access_token = $this->request->get['tokenpu'];
		
		$request['method'] = 'UPDATE';
		$request['goods_shipped'] = true;
		$request['flow']['type'] = 'DIGITAL_SF';
		
		$responseResDeal = $this->curlPatchDataPU($url, $access_token, $request);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state']) && $responseResDeal['state'] && isset($responseResDeal['id']) && $responseResDeal['id']) {
				$this->log->write('ukrcredits_pl успешный запрос состояния заказа ' . $responseResDeal['state']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['id']) . "'");
			} elseif (isset($responseResDeal['status']) && $responseResDeal['status']) {
				$this->log->write('ukrcredits_pl по время запроса произошла ошибка ' . $responseResDeal['status'] . ' / ' . $responseResDeal['data']);
			}
            echo json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function cancelhold_PU (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		$url = 'https://' . ($setting['pu_mode']?'apiext.pumb.ua/ext-oic/galadriel/v1/sf-credits/':'api.dts.fuib.com/ext-oic/galadriel/v1/sf-credits/') . $this->request->get['id'];
		
		$access_token = $this->request->get['tokenpu'];
		
		$request['method'] = 'CLOSE';
		$request['cancel_reason'] = 'CancelLead50';
		$request['flow']['type'] = 'DIGITAL_SF';
		
		$responseResDeal = $this->curlPatchDataPU($url, $access_token, $request);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['state']) && $responseResDeal['state'] && isset($responseResDeal['id']) && $responseResDeal['id']) {
				$this->log->write('ukrcredits_pl успешный запрос отмены заказа ' . $responseResDeal['state']);
				$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '' WHERE ukrcredits_order_id = '" . $this->db->escape($responseResDeal['id']) . "'");
			} elseif (isset($responseResDeal['status']) && $responseResDeal['status']) {
				$this->log->write('ukrcredits_pl по время запроса произошла ошибка ' . $responseResDeal['status'] . ' / ' . $responseResDeal['data']);
			}
            echo json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
	public function curlPatchDataPU($url,$access_token, $request) {
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer ' . $access_token,
				'Cache-Control: no-cache',
				'Connection: keep-alive',
				'Content-Type: application/json',
				'Host: ' . parse_url($url, PHP_URL_HOST),
			//	'Postman-Token: ' . $responseToken['session_state'],
				'User-Agent: PostmanRuntime/7.15.0',
				'X-Flow-ID: 1',
				'accept-encoding: gzip, deflate',
			));

			//execute curl
			$response = curl_exec($ch);

			//get execute result
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			$aInfo = @curl_getinfo($ch);            
			//close curl
			curl_close($ch);          
			//analysis of the information received
			$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
			$this->language->load($dir.'/ukrcredits');   

				if($curl_errno!=0){
					$this->log->write('ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
					$response = array (
						'errorMessage' => 'ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')',
						'state' => 'FAIL'
					);
					return $response;
				} 
				if($aInfo["http_code"]!='200'){
					$this->log->write('ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')');  
					$responsem = array (
						'errorMessage' => 'ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')',
						'state' => 'FAIL'
					);
					return $responsem;
				} 

				return json_decode($response,true);			

		} catch(Exception $e){
			return false;
		}		
	}

    public function return_PU (){
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$this->language->load('sale/ukrcreditsorder');
		
		if (isset($this->request->get['id'])) {
			$ukrcredits_order_id = $this->request->get['id'];
		} else {
			$ukrcredits_order_id = 0;
		}
		
		if (isset($this->request->get['ukrcredits_order_substatus'])) {
			$ukrcredits_order_substatus = $this->request->get['ukrcredits_order_substatus'];
		} else {
			$ukrcredits_order_substatus = '';
		}
		
		if (isset($this->request->get['summ'])) {
			$summ = $this->request->get['summ'];
		} else {
			$summ = 0;
		}
		
		$data_deal['id'] = $ukrcredits_order_id;
		$data_deal['agreement_number'] = $ukrcredits_order_substatus;
		$data_deal['refund'] = true;
		
		
		$data_deal['store_user_login'] = $setting['pu_shop_id'];
		$data_deal['point_of_sale_code'] = $setting['pu_point_of_sale_code'];
		
		
		$data_deal['flow']['type'] = 'DIGITAL_SF';
		$data_deal['amount'] = (int)$summ;
		
		$requestDial = json_encode($data_deal);
 	 
		$access_token = $this->request->get['tokenpu'];

		$url = 'https://' . ($setting['pu_mode']?'apiext.pumb.ua/ext-oic/galadriel/v1/sf-credits':'api.dts.fuib.com/ext-oic/galadriel/v1/sf-credits');
		$responseResDeal = $this->curlPostWithDataPU($url, $access_token, $requestDial);
		
        if(is_array($responseResDeal)){
			if(isset($responseResDeal['id'])) {
				$this->log->write('ukrcredits_pu успешное подтверждение возврата ' . $ukrcredits_order_id);
			//	$this->db->query("UPDATE " . DB_PREFIX . "order_ukrcredits SET ukrcredits_order_status = '" . $this->db->escape($responseResDeal['state']) . "', ukrcredits_order_substatus = '" . $this->db->escape($responseResDeal['order_sub_state']) . "' WHERE ukrcredits_order_id = '" . $this->db->escape($ukrcredits_order_id) . "'");
				$responseResDeal['comment'] = $this->language->get('text_order_returned') . $summ;
				$responseResDeal['order_status_id'] = $setting['completed_status_id'];
				$responseResDeal['order_id'] = $ukrcredits_order_id;
			} elseif (isset($responseResDeal['state']) && $responseResDeal['state']) {
				$this->log->write('ukrcredits_pu по время возврата произошла ошибка ' . $responseResDeal['state'] . ' '. $responseResDeal['errorMessage']);
			}
            echo  json_encode($responseResDeal);
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }
	}
	
    public function curlPostWithDataPU($url, $access_token, $data_deal) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
        $setting = $this->config->get($type.'ukrcredits_settings');
		
			try {
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_deal);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer ' . $access_token,
					'Cache-Control: no-cache',
					'Connection: keep-alive',
					'Content-Type: application/json',
					'Host: ' . parse_url($url, PHP_URL_HOST),
				//	'Postman-Token: ' . $access_token['session_state'],
					'User-Agent: PostmanRuntime/7.15.0',
					'X-Flow-ID: 1',
					'accept-encoding: gzip, deflate',
				));
				
				//execute curl
				$response = curl_exec($curl);
			
				//get execute result
				$curl_errno = curl_errno($curl);
				$curl_error = curl_error($curl);
				$aInfo = @curl_getinfo($curl);            
				//close curl
				curl_close($curl);           
				//analysis of the information received
				$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
				$this->language->load($dir.'/ukrcredits');  
				if($curl_errno!=0){
					$this->log->write('ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
					$response = array (
						'errorMessage' => 'ukrcredits_privat :: CURL failed ' . $curl_error . '(' . $curl_errno . ')',
						'state' => 'FAIL'
					);
					return $response;
				} 
				if($aInfo["http_code"]!='201'){
					$this->log->write('ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')');  
					$responsem = array (
						'errorMessage' => 'ukrcredits_privat :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')',
						'state' => 'FAIL'
					);
					return $responsem;
				} 

				return json_decode($response,true);
			   
			} catch(Exception $e){
				return false;
			}
    }
	
//	protected $banks = array('pp','ii','mb','ab','sb','aa','pl','pu','ib','ot','np');
	protected $banks = array('pp','ii','mb','ab','sb','aa','pl','pu');
    private $error = array();
}