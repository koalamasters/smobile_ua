<?php
class ModelPaymentUkrcreditspu extends Model {
	public function getMethod($address, $total) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');

		$this->load->language($dir.'/ukrcredits');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$setting['pu_geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		$status = false;

		$this->load->model('catalog/product');
		$products = $this->cart->getProducts();

		$i = 0;
		$k = 0;

		if (!$setting['pu_geo_zone_id'] || $query->num_rows) {
			foreach ($products as $product) {
				
				$temp_status = false;
				if ((!$setting['pu_product_allowed'] && !$setting['pu_enabled']) || ($setting['pu_product_allowed'] && in_array($product['product_id'], $setting['pu_product_allowed']))) {
					if (($setting['pu_min_total'] <= $total) && (($setting['pu_max_total']) >= $total)) {
						$status = true; $i++; $temp_status = true;
					}
				}
				$credit_info = $this->model_catalog_product->getProductUkrcredits($product['product_id']);
				if ($credit_info) {
					if (($setting['pu_enabled'] == 1) && $credit_info['product_pu'] == 1) {
						$status = true;
						if ($temp_status == false) {
							$i++; 
						}
					}
				}
				$k++;
					
				if (!$product['stock'] && $setting['pu_stock']) {
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
				'code'       => 'ukrcredits_pu',
				'title'      => $this->language->get('text_title_'.mb_strtolower($setting['pu_merchantType'])),
				'terms'      => '',
				'sort_order' => $this->config->get($type.'ukrcredits_pu_sort_order')
			);
		}
        
		return $method_data;
	}
}
