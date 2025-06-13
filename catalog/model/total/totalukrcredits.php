<?php
class ModelTotalTotalukrcredits extends Model {
	public function getTotal($total) {
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$typetotal = version_compare(VERSION,'3.0','>=') ? 'total_' : '';
		$dir = version_compare(VERSION,'2.2','>=') ? 'extension/total' : 'total';
		if ($this->config->get($typetotal.'totalukrcredits_status')) {
			$this->load->language($dir.'/totalukrcredits');
			$setting = $this->config->get($type.'ukrcredits_settings');

			$products = $this->cart->getProducts();
 			$priceup = 0;
			
			foreach ($products as $product) {
				$ucmarkup = 1;
				
				if (isset($this->session->data['payment_method']['code'])) {
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_pp') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_pp']) && $ukrcredits_query->row['markup_pp'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_pp'];
							} else {
								$ucmarkup = $setting['pp_markup'];
							}
						}
						if ($setting['pp_markup_type'] == 'custom') {
							$ukrcredits_pp_sel = isset($this->session->data['ukrcredits_pp_sel'])?$this->session->data['ukrcredits_pp_sel']:1;
							$ucmarkup = ($setting['pp_markup_custom_PP'][$ukrcredits_pp_sel] + $setting['pp_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_ii') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_ii']) && $ukrcredits_query->row['markup_ii'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_ii'];
							} else {
								$ucmarkup = $setting['ii_markup'];
							}
						}
						if ($setting['ii_markup_type'] == 'custom') {
							$ukrcredits_ii_sel = isset($this->session->data['ukrcredits_ii_sel'])?$this->session->data['ukrcredits_ii_sel']:1;
							$ucmarkup = ($setting['ii_markup_custom_II'][$ukrcredits_ii_sel] + $setting['ii_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_mb') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_mb']) && $ukrcredits_query->row['markup_mb'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_mb'];
							} else {
								$ucmarkup = $setting['mb_markup'];
							}
						}
						if ($setting['mb_markup_type'] == 'custom') {
							$ukrcredits_mb_sel = isset($this->session->data['ukrcredits_mb_sel'])?$this->session->data['ukrcredits_mb_sel']:2;
							$ucmarkup = ($setting['mb_markup_custom_MB'][$ukrcredits_mb_sel] + $setting['mb_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_ab') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_ab']) && $ukrcredits_query->row['markup_ab'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_ab'];
							} else {
								$ucmarkup = $setting['ab_markup'];
							}
						}
						if ($setting['ab_markup_type'] == 'custom') {
							$ukrcredits_mb_sel = isset($this->session->data['ukrcredits_ab_sel'])?$this->session->data['ukrcredits_ab_sel']:3;
							$ucmarkup = ($setting['ab_markup_custom_MB'][$ukrcredits_ab_sel] + $setting['ab_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_aa') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_aa']) && $ukrcredits_query->row['markup_aa'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_aa'];
							} else {
								$ucmarkup = $setting['aa_markup'];
							}
						}
						if ($setting['aa_markup_type'] == 'custom') {
							$ukrcredits_aa_sel = isset($this->session->data['ukrcredits_aa_sel'])?$this->session->data['ukrcredits_aa_sel']:1;
							$ucmarkup = ($setting['aa_markup_custom_AA'][$ukrcredits_aa_sel] + $setting['aa_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_pl') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_pl']) && $ukrcredits_query->row['markup_pl'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_pl'];
							} else {
								$ucmarkup = $setting['pl_markup'];
							}
						}
						if ($setting['pl_markup_type'] == 'custom') {
							$ukrcredits_pl_sel = isset($this->session->data['ukrcredits_pl_sel'])?$this->session->data['ukrcredits_pl_sel']:1;
							$ucmarkup = ($setting['pl_markup_custom_PL'][$ukrcredits_pl_sel] + $setting['pl_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'ukrcredits_pu') {
						$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($ukrcredits_query->row)) {
							if (isset($ukrcredits_query->row['markup_pu']) && $ukrcredits_query->row['markup_pu'] != 0) {
								$ucmarkup = $ukrcredits_query->row['markup_pu'];
							} else {
								$ucmarkup = $setting['pu_markup'];
							}
						}
						if ($setting['pu_markup_type'] == 'custom') {
							$ukrcredits_pu_sel = isset($this->session->data['ukrcredits_pu_sel'])?$this->session->data['ukrcredits_pu_sel']:1;
							$ucmarkup = ($setting['pu_markup_custom_PU'][$ukrcredits_pu_sel] + $setting['pu_markup_acquiring']) / 100 + 1;
						}
						$priceup += ($product['total'] * $ucmarkup) - $product['total'];
					}
				}
			}
			
			if ($priceup > 0) {
				if (version_compare(VERSION,'2.2','>=')) {
					$total['totals'][] = array(
						'code'       => 'totalukrcredits',
						'title'      => $this->language->get('text_credit'),
						'value'      => $priceup,
						'sort_order' => $this->config->get($typetotal.'totalukrcredits_sort_order')
					);
					$total['total'] += $priceup;
				} else {
					$total_data[] = array(
						'code'       => 'totalukrcredits',
						'title'      => $this->language->get('text_credit'),
						'value'      => $priceup,
						'sort_order' => $this->config->get($typetotal.'totalukrcredits_sort_order')
					);					
					$total += $priceup;
				}
			}
		}
	}
}