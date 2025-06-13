<?php
class ModelPaymentUkrcreditsab extends Model {
	public function getMethod($address, $total) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');

		$this->load->language($dir.'/ukrcredits');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$setting['ab_geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		$status = false;

		$this->load->model('catalog/product');
		$products = $this->cart->getProducts();

		$i = 0;
		$k = 0;

		if (!$setting['ab_geo_zone_id'] || $query->num_rows) {
			foreach ($products as $product) {
				
				$temp_status = false;
				if ((!$setting['ab_product_allowed'] && !$setting['ab_enabled']) || ($setting['ab_product_allowed'] && in_array($product['product_id'], $setting['ab_product_allowed']))) {
					if (($setting['ab_min_total'] <= $total) && (($setting['ab_max_total']) >= $total)) {
						$status = true; $i++; $temp_status = true;
					}
				}
				$credit_info = $this->model_catalog_product->getProductUkrcredits($product['product_id']);
				if ($credit_info) {
					if (($setting['ab_enabled'] == 1) && $credit_info['product_ab'] == 1) {
						$status = true;
						if ($temp_status == false) {
							$i++; 
						}
					}
				}
				$k++;
					
				if (!$product['stock'] && $setting['ab_stock']) {
					$status = false;
				}
			}
		}
		
		if ($k > $i) {
			$status = false;
		}

		$method_data = array();

		if (!$this->currency->has('UAH')) {
			$status = false;
		}

		if ($status) {
			$method_data = array(
				'code'       => 'ukrcredits_ab',
				'title'      => $this->language->get('text_title_'.mb_strtolower($setting['ab_merchantType'])),
				'terms'      => '',
				'sort_order' => $this->config->get($type.'ukrcredits_ab_sort_order')
			);
		}
        
		return $method_data;
	}
}
