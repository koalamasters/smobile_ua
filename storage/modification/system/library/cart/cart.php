<?php
namespace Cart;
class Cart {
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');

		// Remove all the expired carts with no customer ID
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE (api_id > '0' OR customer_id = '0') AND date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

		if ($this->customer->getId()) {
			// We want to change the session ID on all the old items in the customers cart
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET session_id = '" . $this->db->escape($this->session->getId()) . "' WHERE api_id = '0' AND customer_id = '" . (int)$this->customer->getId() . "'");

			// Once the customer is logged in we want to update the customers cart
			$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '0' AND customer_id = '0' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

			foreach ($cart_query->rows as $cart) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart['cart_id'] . "'");

				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($cart['product_id'], $cart['quantity'], json_decode($cart['option']), $cart['recurring_id']);
			}
		}
	}

	public function getProducts() {

				$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
				$typetotal = version_compare(VERSION,'3.0','>=') ? 'total_' : '';
				$setting = $this->config->get($type.'ukrcredits_settings');
			
		$product_data = array();

		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

		foreach ($cart_query->rows as $cart) {
			$stock = true;

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

			if ($product_query->num_rows && ($cart['quantity'] > 0)) {
				$option_price = 0;
				$option_points = 0;
				$option_weight = 0;

				$option_data = array();

				foreach (json_decode($cart['option']) as $product_option_id => $value) {
					$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

					if ($option_query->num_rows) {
						if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio') {
							$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($option_value_query->num_rows) {
								if ($option_value_query->row['price_prefix'] == '+') {
									$option_price += $option_value_query->row['price'];
								} elseif ($option_value_query->row['price_prefix'] == '-') {
									$option_price -= $option_value_query->row['price'];
								}

								if ($option_value_query->row['points_prefix'] == '+') {
									$option_points += $option_value_query->row['points'];
								} elseif ($option_value_query->row['points_prefix'] == '-') {
									$option_points -= $option_value_query->row['points'];
								}

								if ($option_value_query->row['weight_prefix'] == '+') {
									$option_weight += $option_value_query->row['weight'];
								} elseif ($option_value_query->row['weight_prefix'] == '-') {
									$option_weight -= $option_value_query->row['weight'];
								}

								if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
									$stock = false;
								}

								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => $value,
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => $option_value_query->row['option_value_id'],
									'name'                    => $option_query->row['name'],
									'value'                   => $option_value_query->row['name'],
									'type'                    => $option_query->row['type'],
									'quantity'                => $option_value_query->row['quantity'],
									'subtract'                => $option_value_query->row['subtract'],
									'price'                   => $option_value_query->row['price'],
									'price_prefix'            => $option_value_query->row['price_prefix'],
									'points'                  => $option_value_query->row['points'],
									'points_prefix'           => $option_value_query->row['points_prefix'],
									'weight'                  => $option_value_query->row['weight'],
									'weight_prefix'           => $option_value_query->row['weight_prefix']
								);
							}
						} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
							foreach ($value as $product_option_value_id) {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}

									if ($option_value_query->row['points_prefix'] == '+') {
										$option_points += $option_value_query->row['points'];
									} elseif ($option_value_query->row['points_prefix'] == '-') {
										$option_points -= $option_value_query->row['points'];
									}

									if ($option_value_query->row['weight_prefix'] == '+') {
										$option_weight += $option_value_query->row['weight'];
									} elseif ($option_value_query->row['weight_prefix'] == '-') {
										$option_weight -= $option_value_query->row['weight'];
									}

									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
										$stock = false;
									}

									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $product_option_value_id,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'value'                   => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix'],
										'points'                  => $option_value_query->row['points'],
										'points_prefix'           => $option_value_query->row['points_prefix'],
										'weight'                  => $option_value_query->row['weight'],
										'weight_prefix'           => $option_value_query->row['weight_prefix']
									);
								}
							}
						} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
							$option_data[] = array(
								'product_option_id'       => $product_option_id,
								'product_option_value_id' => '',
								'option_id'               => $option_query->row['option_id'],
								'option_value_id'         => '',
								'name'                    => $option_query->row['name'],
								'value'                   => $value,
								'type'                    => $option_query->row['type'],
								'quantity'                => '',
								'subtract'                => '',
								'price'                   => '',
								'price_prefix'            => '',
								'points'                  => '',
								'points_prefix'           => '',
								'weight'                  => '',
								'weight_prefix'           => ''
							);
						}
					}
				}

				$price = $product_query->row['price'];

				// Product Discounts
				$discount_quantity = 0;

				foreach ($cart_query->rows as $cart_2) {
					if ($cart_2['product_id'] == $cart['product_id']) {
						$discount_quantity += $cart_2['quantity'];
					}
				}

				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

				if ($product_discount_query->num_rows) {
					
					if	(
							(	
								isset($this->session->data['payment_method']['code']) && 
								(
								($this->session->data['payment_method']['code'] == 'ukrcredits_pp' && !$setting['pp_discount'])
								|| 
								($this->session->data['payment_method']['code'] == 'ukrcredits_ii' && !$setting['ii_discount'])
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_mb' && !$setting['mb_discount'])
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_ab' && !$setting['ab_discount'])
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_aa' && !$setting['aa_discount'])
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_pl' && !$setting['pl_discount'])
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_pu' && !$setting['pu_discount'])
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_sb' && !$setting['sb_discount'])
								)
							)
							||
							(
								isset($this->session->data['payment_method']['code']) 
								&& 
								$this->session->data['payment_method']['code'] != 'ukrcredits_pp'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_ii'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_mb'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_ab'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_aa'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_pl'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_pu'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_sb'
							)
							||
							!isset($this->session->data['payment_method']['code'])
						)
					{
						$price = $product_discount_query->row['price'];
					}
			
				}

				// Product Specials
				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

				
            if ($product_special_query->num_rows && !isset($this->session->data['stop_special'])) {
					
					$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
					if	(
							(	
								isset($this->session->data['payment_method']['code']) && 
								(
								($this->session->data['payment_method']['code'] == 'ukrcredits_pp' && !$setting['pp_special'] && ((isset($ukrcredits_query->row['special_pp']) && !$ukrcredits_query->row['special_pp']) || !isset($ukrcredits_query->row['special_pp'])))
								|| 
								($this->session->data['payment_method']['code'] == 'ukrcredits_ii' && !$setting['ii_special'] && ((isset($ukrcredits_query->row['special_ii']) && !$ukrcredits_query->row['special_ii']) || !isset($ukrcredits_query->row['special_ii'])))
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_mb' && !$setting['mb_special'] && ((isset($ukrcredits_query->row['special_mb']) && !$ukrcredits_query->row['special_mb']) || !isset($ukrcredits_query->row['special_mb'])))
								||
								($this->session->data['payment_method']['code'] == 'ukrcredits_ab' && !$setting['ab_special'] && ((isset($ukrcredits_query->row['special_ab']) && !$ukrcredits_query->row['special_ab']) || !isset($ukrcredits_query->row['special_ab'])))
								|| 
								($this->session->data['payment_method']['code'] == 'ukrcredits_aa' && !$setting['aa_special'] && ((isset($ukrcredits_query->row['special_aa']) && !$ukrcredits_query->row['special_aa']) || !isset($ukrcredits_query->row['special_aa'])))
								|| 
								($this->session->data['payment_method']['code'] == 'ukrcredits_pl' && !$setting['pl_special'] && ((isset($ukrcredits_query->row['special_pl']) && !$ukrcredits_query->row['special_pl']) || !isset($ukrcredits_query->row['special_pl'])))
								|| 
								($this->session->data['payment_method']['code'] == 'ukrcredits_pu' && !$setting['pu_special'] && ((isset($ukrcredits_query->row['special_pu']) && !$ukrcredits_query->row['special_pu']) || !isset($ukrcredits_query->row['special_pu'])))
								|| 
								($this->session->data['payment_method']['code'] == 'ukrcredits_sb' && !$setting['sb_special'] && ((isset($ukrcredits_query->row['special_sb']) && !$ukrcredits_query->row['special_sb']) || !isset($ukrcredits_query->row['special_sb'])))

								)
							)
							||
							(
								isset($this->session->data['payment_method']['code']) 
								&& 
								$this->session->data['payment_method']['code'] != 'ukrcredits_pp'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_ii'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_mb'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_ab'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_aa'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_pl'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_pu'
								&&
								$this->session->data['payment_method']['code'] != 'ukrcredits_sb'
							)
							||
							!isset($this->session->data['payment_method']['code'])
						)
					{
						$price = $product_special_query->row['price'];
					}
			
				}

				// Reward Points
				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($product_reward_query->num_rows) {
					$reward = $product_reward_query->row['points'];
				} else {
					$reward = 0;
				}

				// Downloads
				$download_data = array();

				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$cart['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				foreach ($download_query->rows as $download) {
					$download_data[] = array(
						'download_id' => $download['download_id'],
						'name'        => $download['name'],
						'filename'    => $download['filename'],
						'mask'        => $download['mask']
					);
				}

				// Stock
				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
					$stock = false;
				}

				$recurring_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "product_recurring pr ON (r.recurring_id = pr.recurring_id) LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) WHERE r.recurring_id = '" . (int)$cart['recurring_id'] . "' AND pr.product_id = '" . (int)$cart['product_id'] . "' AND rd.language_id = " . (int)$this->config->get('config_language_id') . " AND r.status = 1 AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($recurring_query->num_rows) {
					$recurring = array(
						'recurring_id'    => $cart['recurring_id'],
						'name'            => $recurring_query->row['name'],
						'frequency'       => $recurring_query->row['frequency'],
						'price'           => $recurring_query->row['price'],
						'cycle'           => $recurring_query->row['cycle'],
						'duration'        => $recurring_query->row['duration'],
						'trial'           => $recurring_query->row['trial_status'],
						'trial_frequency' => $recurring_query->row['trial_frequency'],
						'trial_price'     => $recurring_query->row['trial_price'],
						'trial_cycle'     => $recurring_query->row['trial_cycle'],
						'trial_duration'  => $recurring_query->row['trial_duration']
					);
				} else {
					$recurring = false;
				}


				$ucmarkup = 1;	
				if (!$this->config->get($typetotal.'totalukrcredits_status')) {
					if (isset($this->session->data['payment_method']['code'])) {
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_pp') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
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
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_ii') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
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
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_mb') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
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
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_ab') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
							if (isset($ukrcredits_query->row)) {
								if (isset($ukrcredits_query->row['markup_ab']) && $ukrcredits_query->row['markup_ab'] != 0) {
									$ucmarkup = $ukrcredits_query->row['markup_ab'];
								} else {
									$ucmarkup = $setting['ab_markup'];
								}
							}
							if ($setting['ab_markup_type'] == 'custom') {
								$ukrcredits_ab_sel = isset($this->session->data['ukrcredits_ab_sel'])?$this->session->data['ukrcredits_ab_sel']:3;
								$ucmarkup = ($setting['ab_markup_custom_AB'][$ukrcredits_ab_sel] + $setting['ab_markup_acquiring']) / 100 + 1;
							}
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_aa') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
							if (isset($ukrcredits_query->row)) {
								if (isset($ukrcredits_query->row['markup_aa']) && $ukrcredits_query->row['markup_aa'] != 0) {
									$ucmarkup = $ukrcredits_query->row['markup_aa'];
								} else {
									$ucmarkup = $setting['aa_markup'];
								}
							}
							if ($setting['aa_markup_type'] == 'custom') {
								$ukrcredits_aa_sel = isset($this->session->data['ukrcredits_aa_sel'])?$this->session->data['ukrcredits_aa_sel']:3;
								$ucmarkup = ($setting['aa_markup_custom_AA'][$ukrcredits_aa_sel] + $setting['aa_markup_acquiring']) / 100 + 1;
							}
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_pl') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
							if (isset($ukrcredits_query->row)) {
								if (isset($ukrcredits_query->row['markup_pl']) && $ukrcredits_query->row['markup_pl'] != 0) {
									$ucmarkup = $ukrcredits_query->row['markup_pl'];
								} else {
									$ucmarkup = $setting['pl_markup'];
								}
							}
							if ($setting['pl_markup_type'] == 'custom') {
								$ukrcredits_pl_sel = isset($this->session->data['ukrcredits_pl_sel'])?$this->session->data['ukrcredits_pl_sel']:3;
								$ucmarkup = ($setting['pl_markup_custom_PL'][$ukrcredits_pl_sel] + $setting['pl_markup_acquiring']) / 100 + 1;
							}
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_pu') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
							if (isset($ukrcredits_query->row)) {
								if (isset($ukrcredits_query->row['markup_pu']) && $ukrcredits_query->row['markup_pu'] != 0) {
									$ucmarkup = $ukrcredits_query->row['markup_pu'];
								} else {
									$ucmarkup = $setting['pu_markup'];
								}
							}
							if ($setting['pu_markup_type'] == 'custom') {
								$ukrcredits_pu_sel = isset($this->session->data['ukrcredits_pu_sel'])?$this->session->data['ukrcredits_pu_sel']:2;
								$ucmarkup = ($setting['pu_markup_custom_PU'][$ukrcredits_pu_sel] + $setting['pu_markup_acquiring']) / 100 + 1;
							}
						}
						if ($this->session->data['payment_method']['code'] == 'ukrcredits_sb') {
							$ukrcredits_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_ukrcredits WHERE product_id = '" . (int)$product_query->row['product_id'] . "'");
							if (isset($ukrcredits_query->row)) {
								if (isset($ukrcredits_query->row['markup_sb']) && $ukrcredits_query->row['markup_sb'] != 0) {
									$ucmarkup = $ukrcredits_query->row['markup_sb'];
								} else {
									$ucmarkup = $setting['sb_markup'];
								}
							}
							if ($setting['sb_markup_type'] == 'custom') {
								$ukrcredits_sb_sel = isset($this->session->data['ukrcredits_sb_sel'])?$this->session->data['ukrcredits_sb_sel']:2;
								$ucmarkup = ($setting['sb_markup_custom_sb'][$ukrcredits_sb_sel] + $setting['sb_markup_acquiring']) / 100 + 1;
							}
						}
					}
				}
			
				$product_data[] = array(
					'cart_id'         => $cart['cart_id'],
					'product_id'      => $product_query->row['product_id'],
					'name'            => $product_query->row['name'],
					'model'           => $product_query->row['model'],
					'shipping'        => $product_query->row['shipping'],
					'image'           => $product_query->row['image'],
					'option'          => $option_data,
					'download'        => $download_data,
					'quantity'        => $cart['quantity'],
					'minimum'         => $product_query->row['minimum'],
					'subtract'        => $product_query->row['subtract'],
					'stock'           => $stock,
					'price'           => ($price + $option_price) * $ucmarkup,
					'total'           => ($price + $option_price) * $ucmarkup * $cart['quantity'],
					'reward'          => $reward * $cart['quantity'],
					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
					'tax_class_id'    => $product_query->row['tax_class_id'],
					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
					'weight_class_id' => $product_query->row['weight_class_id'],
					'length'          => $product_query->row['length'],
					'width'           => $product_query->row['width'],
					'height'          => $product_query->row['height'],
					'length_class_id' => $product_query->row['length_class_id'],
					'recurring'       => $recurring
				);
			} else {
				$this->remove($cart['cart_id']);
			}
		}


				$product_data = array_merge($product_data, $this->getDopTovary());
				$product_data = array_merge($product_data, $this->getComplectProducts());
			
		return $product_data;
	}

	public function add($product_id, $quantity = 1, $option = array(), $recurring_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");

		if (!$query->row['total']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "cart SET api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "', customer_id = '" . (int)$this->customer->getId() . "', session_id = '" . $this->db->escape($this->session->getId()) . "', product_id = '" . (int)$product_id . "', recurring_id = '" . (int)$recurring_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = (quantity + " . (int)$quantity . ") WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "' AND `option` = '" . $this->db->escape(json_encode($option)) . "'");
		}
	}

	public function update($cart_id, $quantity) {

				$this->updateDopTovar($cart_id, $quantity);
			
		$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . (int)$quantity . "' WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function remove($cart_id) {

				$this->addDopTovaryLog('remove - $cart_id:' . $cart_id);
				$this->removeDopTovar($cart_id);
				$this->removeComplect($cart_id);
			
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart_id . "' AND api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function clear() {

				if(isset($this->session->data['ex_pak_cart'])){
					unset($this->session->data['ex_pak_cart']);
				}
			
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function getRecurringProducts() {
		$product_data = array();

		foreach ($this->getProducts() as $value) {
			if ($value['recurring']) {
				$product_data[] = $value;
			}
		}

		return $product_data;
	}

	public function getWeight() {
		$weight = 0;

		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}

	public function getSubTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $product['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->getProducts());
	}

	public function hasRecurringProducts() {
		return count($this->getRecurringProducts());
	}

	public function hasStock() {
		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				return false;
			}
		}

		return true;
	}

	public function hasShipping() {
		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				return true;
			}
		}

		return false;
	}


				/*---------dop-product---------*/
				public $ex_pak = array();
				public $ex_pak_log_status = false;
				public $ex_pak_log = false;

				public function getDopTovaryLogId(){
					if(!empty($this->session->data['ex_pak_log_id'])){
						$log_id = $this->session->data['ex_pak_log_id'];
						unset($this->session->data['ex_pak_log_id']);
						return $log_id;
					}
					return false;
				}

				public function addDopTovaryLog($message = false){
					if($this->ex_pak_log_status){
						if($this->ex_pak_log == false){
							$folder = 'ex_pak';
							if(!file_exists(DIR_LOGS . $folder)){
								mkdir(DIR_LOGS . $folder, 0755);
							}
							$folder = $folder . '/' . date('Y-m-d');
							if(!file_exists(DIR_LOGS . $folder)){
								mkdir(DIR_LOGS . $folder, 0755);
							}

							require_once DIR_SYSTEM . 'library/log.php';
							$this->ex_pak_log = new \Log($folder . '/' . date('H') . '.log');
						}

						$log_message = array();
						if($message){
							$log_message[] = $message;
						}


						$log_id = $_SERVER['REMOTE_ADDR'] . time();
						if(isset($this->session->data['ex_pak_cart'])){
							$log_id .= json_encode($this->session->data['ex_pak_cart']);
						}
						$log_id = md5($log_id);
						$this->session->data['ex_pak_log_id'] = $log_id;


						$log_message[] = 'ID:' . $log_id;
						$log_message[] = 'IP:' . $_SERVER['REMOTE_ADDR'];

						$log_message[] = 'CART_PRODUCTS:' . json_encode($this->getCartProducts());

						if(isset($this->session->data['ex_pak_cart'])){
							$log_message[] = 'SESSION_DOPTOVARY_CART:' . json_encode($this->session->data['ex_pak_cart']);
						}
						if($this->ex_pak){
							$log_message[] = 'DOP_TOVARY:' . json_encode($this->ex_pak);
						}
						$this->ex_pak_log->write(implode(' ', $log_message));
					}
				}

				public function getDopTovary($products_group = 'grouped'){


					if($this->config->get('module_ex_pak_status')){
						if(!empty($this->ex_pak[$products_group])){
							return $this->ex_pak[$products_group];
						}
						if(!empty($this->session->data['ex_pak_cart'])){

							$this->ex_pak = array();
							$this->ex_pak['all'] = array();
							$this->ex_pak['grouped'] = array();

							$cart_products = array();

							foreach($this->getCartProducts() as $cart_id=>$cart){
								if(!empty($cart['product_id'])){
									$cart_products[$cart['product_id']] = $cart_id;
								}
							}

							foreach($this->session->data['ex_pak_cart'] as $main_product_id=>$group){
								foreach($group as $group_id=>$group_product){
									foreach($group_product as $group_product_id=>$dop_product_data){

										$dop_product_query = $this->db->query('SELECT dtptp.* FROM ' . DB_PREFIX . 'ex_pak_product_tab_products dtptp
																		LEFT JOIN ' . DB_PREFIX . 'ex_pak_tab dtt ON (dtptp.group_id = dtt.tab_id)
																		LEFT JOIN ' . DB_PREFIX . 'product p ON (dtptp.group_product_id = p.product_id)
																		LEFT JOIN ' . DB_PREFIX . 'product_description pd ON (dtptp.group_product_id = pd.product_id)
																		WHERE
																			dtptp.product_id = ' . (int)$main_product_id . '
																			AND dtptp.group_id = ' . (int)$group_id . '
																			AND dtptp.group_product_id = ' . (int)$group_product_id . '
																			AND (dtptp.group_product_date_from = "0000-00-00" OR DATE(dtptp.group_product_date_from) <= CURRENT_DATE())
																			AND (dtptp.group_product_date_to = "0000-00-00" OR DATE(dtptp.group_product_date_to) >= CURRENT_DATE())
																			AND dtt.status = 1
																			AND p.status = 1
																			AND p.quantity > 0
																			AND pd.language_id = ' . (int)$this->config->get('config_language_id'));

										if($dop_product_query->row){

											$price = $dop_product_query->row['group_product_price'];

											$quantity = $dop_product_data['quantity'];

											if(isset($dop_product_data['option'])){
												$option = $dop_product_data['option'];
											} else {
												$option = array();
											}

											$ex_pak_cart_key_query = $this->db->query('SELECT MAX(product_id) + 1 as max_product_id FROM ' . DB_PREFIX . 'product');
											if(!empty($this->ex_pak['all'])){
												$ex_pak_count = count($this->ex_pak['all']);
											} else {
												$ex_pak_count = 0;
											}
											$cart_id = $ex_pak_cart_key_query->row['max_product_id'] + ($ex_pak_count + 1);

											if($option){
												foreach($option as $key=>$value){
													if(is_array($value)){
														$cart_id .= (int)$key;
														foreach($value as $v){
															$cart_id .= (int)$v;
														}
													} else {
														$cart_id .= (int)$key.(int)$value;
													}
												}
											}

											$product_data = $this->getProductData($group_product_id, $quantity, $option);

											foreach($product_data['option'] as $option){
												if($option['price']){
													if($option['price_prefix'] == '+'){
														$price += $option['price'];
													} else {
														$price -= $option['price'];
													}
												}
											}

											$product_data['cart_id'] = $cart_id;
											$product_data['single'] = $dop_product_data['single'];
											$product_data['product_key'] = $product_data['product_id'] . '-' . ($price * 100);

											if(!$product_data['single']){
												$product_data['product_key'] = $main_product_id . '-' . $product_data['product_key'];
											}

											$product_data['group_id'] = $group_id;
											$product_data['main_product_id'] = $main_product_id;
											$product_data['main_cart_id'] = isset($cart_products[$main_product_id]) ? $cart_products[$main_product_id] : false;
											$product_data['price'] = $price;
											$product_data['total'] = $price * $quantity;
											$grouped_product_status = true;
											if($product_data['single']){
												foreach($this->ex_pak['all'] as $dop_product){
													if($dop_product['product_key'] == $product_data['product_key']){
														$grouped_product_status = false;
													}
												}
											}

											$this->ex_pak['all'][$cart_id] = $product_data;
											if($grouped_product_status){
												$this->ex_pak['grouped'][$cart_id] = $product_data;
											}
										}
									}
								}
							}
						}
					}

					return !empty($this->ex_pak[$products_group]) ? $this->ex_pak[$products_group] : array();
				}

				public function addDopTovar($main_product_id, $group_id, $group_product_id, $options = array(), $single = false){
					$this->session->data['ex_pak_cart'][$main_product_id][$group_id][$group_product_id] = array(
						'quantity' => 1,
						'single' => $single,
						'option' => $options,
					);
					$this->ex_pak = array();

      				if(method_exists($this, 'setCartCookie')){
        				$this->setCartCookie();
       				}

       				if(isset($this->products)){
         				$this->products = false;
       				}

					foreach($this->getDopTovary('all') as $dop_tovar){
						if(($dop_tovar['main_product_id'] == $main_product_id) && ($dop_tovar['group_id'] == $group_id) && ($dop_tovar['product_id'] == $group_product_id)){
							return $dop_tovar;
						}
					}

				}

				public function setDopTovaryInCart($products, $ignore_main_product = false){
					$ex_pak = $this->getDopTovary('all');
					foreach($products as $key=>$product){
						if(!empty($product['product_key'])){
							if($ignore_main_product){
								$product['product_key'] = $this->removeDopTovarMainProductKey($product['product_key']);
							}
							$cart_product = array();
							foreach($ex_pak as $dop_tovar){
								if(($dop_tovar['main_product_id'] == $product['main_product_id']) && ($dop_tovar['group_id'] == $product['group_id']) && ($dop_tovar['product_id'] == $product['product_id'])){
									//$cart_product = $dop_tovar;

									if($product['special_raw']){
										$product_price = $product['special_raw'];
									} else {
										$product_price = $product['price_raw'];
									}
									if(!$ignore_main_product || ($dop_tovar['price'] == $product_price)){
										$cart_product = $dop_tovar;
									}
								} else {
									$cart_product_key = $dop_tovar['product_key'];

									if($ignore_main_product){
										$cart_product_key = $this->removeDopTovarMainProductKey($dop_tovar['product_key']);
									}

									if($cart_product_key == $product['product_key']){
										if(($product['single'] && $dop_tovar['single']) || ($product['main_product_id'] == $dop_tovar['main_product_id']) || $ignore_main_product){
											$cart_product =  $dop_tovar;
										}
									}
								}
							}
							if($cart_product){
								$product['cart_product_key'] = $cart_product['product_key'];
								$product['in_cart'] = true;
							} else {
								$product['in_cart'] = false;
							}

							$products[$key] = $product;
						}
					}
					return $products;
				}

				public function removeDopTovarMainProductKey($product_key){
					$product_key_explode = explode('-', $product_key);
					if(count($product_key_explode) == 3){
						unset($product_key_explode[0]);
						$product_key = implode('-', $product_key_explode);
					}
					return $product_key;
				}
				public function removeDopTovar($cart_id){
					$this->addDopTovaryLog('removeDopTovar - $cart_id:' . $cart_id);
					$this->ex_pak = array();
					$to_removes = array();

					$cart_products = $this->getCartProducts();
					if(isset($cart_products[$cart_id])){
						$this->addDopTovaryLog('removeDopTovar - delete by main');
						// delete by main product
						$main_product_id = $cart_products[$cart_id]['product_id'];
						if(isset($this->session->data['ex_pak_cart'][$main_product_id])){
							$isset_another_main_product = false;
							foreach($cart_products as $c_id=>$product){
								if(!empty($product['product_id'])){
									if(($c_id != $cart_id) && ($product['product_id'] == $main_product_id) && !isset($product['options']['complect'])){
										$isset_another_main_product = true;
									}
								}
							}
							// delete subproducts if not isset another main product and subproduct not single
							if(!$isset_another_main_product){
								foreach($this->getDopTovary('all') as $dop_tovar){
									if(!$dop_tovar['single'] && ($dop_tovar['main_product_id'] == $main_product_id)){
										$to_removes[] = $dop_tovar['product_key'];
									}
								}
							}
						}
					} else {
						// delete directly subproduct
						$ex_pak = $this->getDopTovary('all');
						$this->addDopTovaryLog('removeDopTovar - delete by subproduct $ex_pak' . json_encode($ex_pak));
						foreach($ex_pak as $dop_tovar){
							if($dop_tovar['cart_id'] == $cart_id){
								$to_removes[] = $dop_tovar['product_key'];
							}
						}
					}

					$this->addDopTovaryLog('removeDopTovar - $to_removes:' . json_encode($to_removes));
					if($to_removes){
						foreach($to_removes as $to_remove){
							$this->removeDopTovarByKey($to_remove, false);
						}
						$this->dopTovaryClear();
					}
					$this->addDopTovaryLog('removeDopTovar - after');
				}

				public function removeDopTovarByKey($product_key, $clear = true){
					$ex_pak = $this->getDopTovary('all');
					$this->addDopTovaryLog('removeDopTovarByKey - $product_key:' . $product_key . ' $ex_pak: ' . json_encode($ex_pak));
					foreach($ex_pak as $dop_tovar){
						if($dop_tovar['product_key'] == $product_key){
							$this->removeDopTovarSession($dop_tovar['main_product_id'], $dop_tovar['group_id'], $dop_tovar['product_id']);
						}
					}
					if($clear){
						$this->dopTovaryClear();
					}
					$this->addDopTovaryLog('removeDopTovarByKey - after');
				}

				public function removeDopTovarSession($main_product_id, $group_id, $group_product_id){
					$this->addDopTovaryLog('removeDopTovarSession - $main_product_id:' . $main_product_id . ' $group_id: ' . $group_id . ' $group_product_id: ' . $group_product_id);
					if(!empty($this->session->data['ex_pak_cart'][$main_product_id][$group_id][$group_product_id])){
						unset($this->session->data['ex_pak_cart'][$main_product_id][$group_id][$group_product_id]);
						if(isset($this->session->data['ex_pak_cart'][$main_product_id][$group_id]) && empty($this->session->data['ex_pak_cart'][$main_product_id][$group_id])){
							unset($this->session->data['ex_pak_cart'][$main_product_id][$group_id]);
						}
						if(isset($this->session->data['ex_pak_cart'][$main_product_id]) && empty($this->session->data['ex_pak_cart'][$main_product_id])){
							unset($this->session->data['ex_pak_cart'][$main_product_id]);
						}
					}
					$this->addDopTovaryLog('removeDopTovarSession - after');
				}
				public function updateDopTovar($cart_id, $quantity){
					foreach($this->getDopTovary() as $product){
						if(($product['cart_id'] == $cart_id)){
							if(isset($this->session->data['ex_pak_cart'][$product['main_product_id']][$product['group_id']][$product['product_id']])){
								$this->session->data['ex_pak_cart'][$product['main_product_id']][$product['group_id']][$product['product_id']]['quantity'] = $quantity;
								$this->dopTovaryClear();
							}
						}
					}
				}

				public function dopTovaryClear(){
					$this->ex_pak = array();
					if(method_exists($this, 'deleteEmptyOrder')){
						$this->deleteEmptyOrder();
					}
					if(method_exists($this, 'setCartCookie')){
						$this->setCartCookie();
					}
					if(isset($this->products)){
						$this->products = false;
					}
				}

				public function getComplectProducts(){
					$complect_products = array();

					foreach($this->getCartProducts() as $main_cart_id=>$cart_product) {
						if(!empty($cart_product['option']['complect']['complect_id']) && !empty($cart_product['option']['complect']['complect_product_id'])){
							$complect_product_query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'ex_pak_product_complect_products pcp
											LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_complect pc ON (pc.complect_id = pcp.complect_id)
											LEFT JOIN ' . DB_PREFIX . 'ex_pak_product_complect_description pcd ON (pcp.complect_id = pcd.complect_id)
											WHERE
												pc.product_id = ' . (int)$cart_product['product_id'] . '
												AND pc.complect_id = ' . (int)$cart_product['option']['complect']['complect_id'] . '
												AND pcp.complect_product_id = ' . (int)$cart_product['option']['complect']['complect_product_id'] . '
												AND pcd.language_id = ' . $this->config->get('config_language_id') . '
												AND (pc.date_from = "0000-00-00" OR DATE(pc.date_from) <= CURRENT_DATE())
												AND (pc.date_to = "0000-00-00" OR DATE(pc.date_to) >= CURRENT_DATE()) ');

							if($complect_product_query->num_rows){

								$quantity = $cart_product['quantity'];
								if(isset($cart_product['option']['complect']['option'])){
									$option = $cart_product['option']['complect']['option'];
								} else {
									$option = array();
								}

								$product_data = $this->getProductData($complect_product_query->row['complect_product_id'], $quantity, $option);

								$price = $product_data['price'];

								foreach($product_data['option'] as $option){
									if($option['price']){
										if($option['price_prefix'] == '+'){
											$price += $option['price'];
										} else {
											$price -= $option['price'];
										}
									}
								}

								$discount = 0;
								if($complect_product_query->row['complect_discount_type'] == 'procent'){
									$discount = $product_data['price'] * $complect_product_query->row['complect_discount_value'] / 100;
								} elseif($complect_product_query->row['complect_discount_type'] == 'sum') {
									$discount = $complect_product_query->row['complect_discount_value'];
								}

								$price -= $discount;

								$ex_pak_cart_key_query = $this->db->query('SELECT MAX(product_id) + 1 as max_product_id FROM ' . DB_PREFIX . 'product');


								if(!empty($this->ex_pak['all'])){
									$ex_pak_count = count($this->ex_pak['all']);
								} else {
									$ex_pak_count = 0;
								}

								$cart_id = $main_cart_id + $ex_pak_cart_key_query->row['max_product_id'] + ($ex_pak_count + 1) + (count($complect_products) + 1);

								$product_data['cart_id'] = $cart_id;
								$product_data['product_key'] = $cart_product['product_id'] . '-' . $complect_product_query->row['complect_id'] . '-' . $complect_product_query->row['complect_product_id'];
								$product_data['complect_id'] = $complect_product_query->row['complect_id'];
								$product_data['main_product_id'] = $cart_product['product_id'];
								$product_data['main_cart_id'] = $main_cart_id;
								$product_data['price'] = $price;
								$product_data['total'] = $price * $quantity;

								$complect_products[] = $product_data;
							}
						}
					}


					return $complect_products;
				}

				public function removeComplect($cart_id){
					$this->addDopTovaryLog('removeComplect - $cart_id:' . $cart_id);
					foreach($this->getComplectProducts() as $complect_product){
						if($complect_product['cart_id'] == $cart_id){
							$this->addDopTovaryLog('removeComplect finded $cart_id:' . $cart_id);
							$this->remove($complect_product['main_cart_id']);
							$this->dopTovaryClear();
						}
					}
					$this->addDopTovaryLog('removeComplect - after');
				}

				public function removeComplectByKey($product_key){
					$this->addDopTovaryLog('removeComplectByKey - $product_key:' . $product_key);
					foreach($this->getComplectProducts() as $product){
						if($product['product_key'] == $product_key){
							$this->remove($product['main_cart_id']);
							$this->dopTovaryClear();
						}
					}
					$this->addDopTovaryLog('removeComplectByKey - after');
				}

				public function getComplectDiscount(){
					$complect_discount = 0;
					foreach($this->getComplectProducts() as $product){
						$complect_discount += $product['old_total'] - $product['total'];
					}
					return $complect_discount;
				}

				public function getCartProducts(){
					$cart_products = array();
					$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE api_id = '" . (isset($this->session->data['api_id']) ? (int)$this->session->data['api_id'] : 0) . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

					foreach ($cart_query->rows as $cart) {
						$cart['option'] = json_decode($cart['option'], true);
						$cart_products[$cart['cart_id']] = $cart;
					}

					return $cart_products;
				}

				public function getProductData($product_id, $quantity = 1, $option = array()){
					$stock = true;
					$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s
																				LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id)
																				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
																				WHERE
																					p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
																					AND p2s.product_id = '" . (int)$product_id . "'
																					AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
																					AND p.date_available <= NOW() AND p.status = '1'");


					if ($product_query->num_rows) {
						$option_price = 0;
						$option_points = 0;
						$option_weight = 0;

						$option_data = array();

						foreach ($option as $product_option_id => $value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type
																					FROM " . DB_PREFIX . "product_option po
																					LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id)
																					LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id)
																					WHERE
																						po.product_option_id = '" . (int)$product_option_id . "'
																						AND po.product_id = '" . (int)$product_id . "'
																						AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio') {
									$option_value_query = $this->db->query("SELECT
																					pov.option_value_id,
																					ovd.name,
																					pov.quantity,
																					pov.subtract,
																					pov.price,
																					pov.price_prefix,
																					pov.points,
																					pov.points_prefix,
																					pov.weight,
																					pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov
																				LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id)
																				LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
																				WHERE
																					pov.product_option_value_id = '" . (int)$value . "'
																					AND pov.product_option_id = '" . (int)$product_option_id . "'
																					AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

									if ($option_value_query->num_rows) {
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}

										if ($option_value_query->row['points_prefix'] == '+') {
											$option_points += $option_value_query->row['points'];
										} elseif ($option_value_query->row['points_prefix'] == '-') {
											$option_points -= $option_value_query->row['points'];
										}

										if ($option_value_query->row['weight_prefix'] == '+') {
											$option_weight += $option_value_query->row['weight'];
										} elseif ($option_value_query->row['weight_prefix'] == '-') {
											$option_weight -= $option_value_query->row['weight'];
										}

										if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
											$stock = false;
										}

										$option_data[] = array(
											'product_option_id'       => $product_option_id,
											'product_option_value_id' => $value,
											'option_id'               => $option_query->row['option_id'],
											'option_value_id'         => $option_value_query->row['option_value_id'],
											'name'                    => $option_query->row['name'],
											'value'                   => $option_value_query->row['name'],
											'type'                    => $option_query->row['type'],
											'quantity'                => $option_value_query->row['quantity'],
											'subtract'                => $option_value_query->row['subtract'],
											'price'                   => $option_value_query->row['price'],
											'price_prefix'            => $option_value_query->row['price_prefix'],
											'points'                  => $option_value_query->row['points'],
											'points_prefix'           => $option_value_query->row['points_prefix'],
											'weight'                  => $option_value_query->row['weight'],
											'weight_prefix'           => $option_value_query->row['weight_prefix']
										);
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
									foreach ($value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, ovd.name FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (pov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

										if ($option_value_query->num_rows) {
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}

											if ($option_value_query->row['points_prefix'] == '+') {
												$option_points += $option_value_query->row['points'];
											} elseif ($option_value_query->row['points_prefix'] == '-') {
												$option_points -= $option_value_query->row['points'];
											}

											if ($option_value_query->row['weight_prefix'] == '+') {
												$option_weight += $option_value_query->row['weight'];
											} elseif ($option_value_query->row['weight_prefix'] == '-') {
												$option_weight -= $option_value_query->row['weight'];
											}

											if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
												$stock = false;
											}

											$option_data[] = array(
												'product_option_id'       => $product_option_id,
												'product_option_value_id' => $product_option_value_id,
												'option_id'               => $option_query->row['option_id'],
												'option_value_id'         => $option_value_query->row['option_value_id'],
												'name'                    => $option_query->row['name'],
												'value'                   => $option_value_query->row['name'],
												'type'                    => $option_query->row['type'],
												'quantity'                => $option_value_query->row['quantity'],
												'subtract'                => $option_value_query->row['subtract'],
												'price'                   => $option_value_query->row['price'],
												'price_prefix'            => $option_value_query->row['price_prefix'],
												'points'                  => $option_value_query->row['points'],
												'points_prefix'           => $option_value_query->row['points_prefix'],
												'weight'                  => $option_value_query->row['weight'],
												'weight_prefix'           => $option_value_query->row['weight_prefix']
											);
										}
									}
								} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => '',
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => '',
										'name'                    => $option_query->row['name'],
										'value'                   => $value,
										'type'                    => $option_query->row['type'],
										'quantity'                => '',
										'subtract'                => '',
										'price'                   => '',
										'price_prefix'            => '',
										'points'                  => '',
										'points_prefix'           => '',
										'weight'                  => '',
										'weight_prefix' 	          => ''
									);
								}
							}
						}


						$price = $product_query->row['price'];


						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

						if ($product_discount_query->num_rows) {
							$price = $product_discount_query->row['price'];
						}

						// Product Specials
						$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

						if ($product_special_query->num_rows) {
							$price = $product_special_query->row['price'];
						}


						return array(
							'product_id'      => $product_query->row['product_id'],
							'name'            => $product_query->row['name'],
							'model'           => $product_query->row['model'],
							'shipping'        => $product_query->row['shipping'],
							'image'           => $product_query->row['image'],
							'option'          => $option_data,
							'download'        => array(),
							'quantity'        => $quantity,
							'minimum'         => $product_query->row['minimum'],
							'subtract'        => $product_query->row['subtract'],
							'stock'           => $stock,
							'price'           => $price,
							'total'           => $price * $quantity,
							'old_price'       => $product_query->row['price'],
							'old_total'       => $product_query->row['price'] * $quantity,
							'reward'          => 0,
							'points'          => ($product_query->row['points'] ? ($product_query->row['points']) * $quantity : 0),
							'tax_class_id'    => $product_query->row['tax_class_id'],
							'weight'          => ($product_query->row['weight'] + $option_weight) * $quantity,
							'weight_class_id' => $product_query->row['weight_class_id'],
							'length'          => $product_query->row['length'],
							'width'           => $product_query->row['width'],
							'height'          => $product_query->row['height'],
							'length_class_id' => $product_query->row['length_class_id'],
							'recurring'       => false
						);
					}
				}
				/*---------/dop-product---------*/
			
	public function hasDownload() {
		foreach ($this->getProducts() as $product) {
			if ($product['download']) {
				return true;
			}
		}

		return false;
	}
}
