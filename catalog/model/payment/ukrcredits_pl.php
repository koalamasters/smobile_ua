<?php
class ModelPaymentUkrcreditsPl extends Model {
	public function getMethod($address, $total) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/module' : 'module';
		$setting = $this->config->get($type.'ukrcredits_settings');

		$this->load->language($dir.'/ukrcredits');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$setting['pl_geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		$status = false;

		$this->load->model('catalog/product');
		$products = $this->cart->getProducts();

		$i = 0;
		$k = 0;

		if (!$setting['pl_geo_zone_id'] || $query->num_rows) {
			foreach ($products as $product) {
				
				$temp_status = false;
				if ((!$setting['pl_product_allowed'] && !$setting['pl_enabled']) || ($setting['pl_product_allowed'] && in_array($product['product_id'], $setting['pl_product_allowed']))) {
					if (($setting['pl_min_total'] <= $total) && (($setting['pl_max_total']) >= $total)) {
						$status = true; $i++; $temp_status = true;
					}
				}
				$credit_info = $this->model_catalog_product->getProductUkrcredits($product['product_id']);
				if ($credit_info) {
					if (($setting['pl_enabled'] == 1) && $credit_info['product_pl'] == 1) {
						$status = true;
						if ($temp_status == false) {
							$i++; 
						}
					}
				}
				$k++;
					
				if (!$product['stock'] && $setting['pl_stock']) {
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
				'code'       => 'ukrcredits_pl',
				'title'      => $this->language->get('text_title_'.mb_strtolower($setting['pl_merchantType'])),
				'terms'      => '',
				'sort_order' => $this->config->get($type.'ukrcredits_pl_sort_order')
			);
		}
        
		return $method_data;
	}
}
