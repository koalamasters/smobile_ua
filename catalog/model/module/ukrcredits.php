<?php
class ModelModuleUkrcreditsMain extends Model {

	public function checkproduct($product, $quantity = 1, $options = false, $price = false, $specialprice = false) {
		$dir = version_compare(VERSION,'2.3','>=') ? 'extension/module' : 'module';
		$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
		$setting = $this->config->get($type.'ukrcredits_settings');
		$ukrcredits_pl_data = $this->config->get($type.'ukrcredits_pl_data'); 
		$this->load->language($dir.'/ukrcredits');
		$status_pp = false;
		$status_ii = false;
		$status_mb = false;
		$status_ab = false;
		$status_sb = false;
		$status_aa = false;
		$status_pl = false;
		$status_pu = false;
		$replace_array = array($this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));
		
		if ($this->config->get($type.'ukrcredits_status')) {
			$credit_info = $this->getProductUkrcredit($product['product_id']);

			if (($setting['pp_status'] && ($setting['pp_stock'] && $product['quantity'] > 0)) || ($setting['pp_status'] && !$setting['pp_stock'])) {
				if (
					(!$setting['pp_product_allowed'] && !$setting['pp_enabled']) || 
					($setting['pp_product_allowed'] && in_array($product['product_id'], $setting['pp_product_allowed'])) ||
					($setting['pp_enabled'] && isset($credit_info['product_pp']) && $credit_info['product_pp'])
					) {
					$status_pp = true;
				}
				if ($status_pp) {
					$pp_price = $product['price'];
					if (!$setting['pp_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$pp_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['pp_special'] && (float)$product['special'] && ((isset($credit_info['special_pp']) && !$credit_info['special_pp']) || !isset($credit_info['special_pp']))) {
						$pp_price = $product['special'];
					}
					if ($setting['pp_min_total'] >= $pp_price || $setting['pp_max_total'] <= $pp_price) {
						$status_pp = false;
					}
					
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $pp_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $pp_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountpp = (isset($credit_info['partscount_pp']) && $credit_info['partscount_pp'] !=0) ? $credit_info['partscount_pp'] : (!$setting['pp_pq'] ? '24' : $setting['pp_pq']);
					$markup_pp = (isset($credit_info['markup_pp']) && $credit_info['markup_pp'] !=0) ? $credit_info['markup_pp'] : (!$setting['pp_markup'] ? '24' : $setting['pp_markup']);
					$pp_price = ($pp_price + $option_price) * $markup_pp * $quantity;
					$pp_type = $setting['pp_merchantType'];
					if ($pp_type == 'PP') {
						$mounthprice_int_pp = $pp_price*$markup_pp/($partsCountpp+1);
						if ($setting['pp_markup_type'] == 'custom') {
							$mounthprice_int_pp = $pp_price*(1+(($setting['pp_markup_acquiring']+$setting['pp_markup_custom_PP'][$partsCountpp])/100))/($partsCountpp+1); 
						}						
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_pp, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_pp = sprintf($this->language->get('text_min_pp'), $partsCountpp, $mounthprice);
						$pp_name = $this->language->get('text_title_pp');
					} else {
						$mounthprice_int_pp = $pp_price*$markup_pp/($partsCountpp+1);
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_pp, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_pp = sprintf($this->language->get('text_min_pb'), $partsCountpp, $mounthprice);
						$pp_name = $this->language->get('text_title_pb');
					}
					if ($price) {
						$pp_price = $price;
						if (!$setting['pp_special'] && $specialprice) {
							$pp_price = $specialprice;
						}						
					} else {
						$pp_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($pp_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}

			if (($setting['ii_status'] && ($setting['ii_stock'] && $product['quantity'] > 0)) || ($setting['ii_status'] && !$setting['ii_stock'])) {
				if (
					(!$setting['ii_product_allowed'] && !$setting['ii_enabled']) || 
					($setting['ii_product_allowed'] && in_array($product['product_id'], $setting['ii_product_allowed'])) ||
					($setting['ii_enabled'] && isset($credit_info['product_ii']) && $credit_info['product_ii'])
					) {
					$status_ii = true;
				}
				if ($status_ii) {
					$ii_price = $product['price'];
					if (!$setting['ii_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$ii_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['ii_special'] && (float)$product['special'] && ((isset($credit_info['special_ii']) && !$credit_info['special_ii']) || !isset($credit_info['special_ii']))) {
						$ii_price = $product['special'];
					}
					if ($setting['ii_min_total'] >= $ii_price || $setting['ii_max_total'] <= $ii_price) {
						$status_ii = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $ii_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $ii_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountii = (isset($credit_info['partscount_ii']) && $credit_info['partscount_ii'] !=0) ? $credit_info['partscount_ii'] : (!$setting['ii_pq'] ? '24' : $setting['ii_pq']);
					$markup_ii = (isset($credit_info['markup_ii']) && $credit_info['markup_ii'] !=0) ? $credit_info['markup_ii'] : (!$setting['ii_markup'] ? '24' : $setting['ii_markup']);
					$ii_price = ($ii_price + $option_price) * $markup_ii * $quantity;
					$ii_type = $setting['ii_merchantType'];
					if ($ii_type == 'II') {
						$mounthprice_int_ii = ($ii_price*$markup_ii/($partsCountii+1))+(($ii_price*$markup_ii)*(2.9/100));
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_ii, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_ii = sprintf($this->language->get('text_min_ii'), $partsCountii, $mounthprice);
						$ii_name = $this->language->get('text_title_ii');
					} else {
						$mounthprice_int_ii = ($ii_price*$markup_ii/($partsCountii+1))+(($ii_price*$markup_ii)*(0.99/100));
						if ($setting['ii_markup_type'] == 'custom') {
							$mounthprice_int_ii = ($ii_price*(1+(($setting['ii_markup_acquiring']+$setting['ii_markup_custom_II'][$partsCountii])/100))/($partsCountii+1))+(($ii_price*$markup_ii)*(0.99/100));
						}	
						$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_ii, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
						$mounthprice_text_ii = sprintf($this->language->get('text_min_ia'), $partsCountii, $mounthprice);
						$ii_name = $this->language->get('text_title_ia');
					}
					if ($price) {
						$ii_price = $price;
						if (!$setting['ii_special'] && $specialprice) {
							$ii_price = $specialprice;
						}	
					} else {
						$ii_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($ii_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
			
			if (($setting['mb_status'] && ($setting['mb_stock'] && $product['quantity'] > 0)) || ($setting['mb_status'] && !$setting['mb_stock'])) {
				if (
					(!$setting['mb_product_allowed'] && !$setting['mb_enabled']) || 
					($setting['mb_product_allowed'] && in_array($product['product_id'], $setting['mb_product_allowed'])) ||
					($setting['mb_enabled'] && isset($credit_info['product_mb']) && $credit_info['product_mb'])
					) {
					$status_mb = true;
				}
				if ($status_mb) {
					$mb_price = $product['price'];
					if (!$setting['mb_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$mb_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['mb_special'] && (float)$product['special'] && ((isset($credit_info['special_mb']) && !$credit_info['special_mb']) || !isset($credit_info['special_mb']))) {
						$mb_price = $product['special'];
					}
					if ($setting['mb_min_total'] >= $mb_price || $setting['mb_max_total'] <= $mb_price) {
						$status_mb = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $mb_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $mb_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountmb = (isset($credit_info['partscount_mb']) && $credit_info['partscount_mb'] !=0) ? $credit_info['partscount_mb'] : (!$setting['mb_pq'] ? '24' : $setting['mb_pq']);
					$markup_mb = (isset($credit_info['markup_mb']) && $credit_info['markup_mb'] !=0) ? $credit_info['markup_mb'] : (!$setting['mb_markup'] ? '24' : $setting['mb_markup']);
					$mb_price = ($mb_price + $option_price) * $markup_mb * $quantity;
					$mb_type = $setting['mb_merchantType'];
					$mounthprice_int_mb = ($mb_price*$markup_mb/($partsCountmb+1));
						if ($setting['mb_markup_type'] == 'custom') {
							$mounthprice_int_mb = $mb_price*(1+(($setting['mb_markup_acquiring']+$setting['mb_markup_custom_MB'][$partsCountmb])/100))/($partsCountmb+1); 
						}	
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_mb, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_mb = sprintf($this->language->get('text_min_mb'), $partsCountmb, $mounthprice);
					$mb_name = $this->language->get('text_title_mb');
					if ($price) {
						$mb_price = $price;
						if (!$setting['mb_special'] && $specialprice) {
							$mb_price = $specialprice;
						}
					} else {
						$mb_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($mb_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}

			if (($setting['ab_status'] && ($setting['ab_stock'] && $product['quantity'] > 0)) || ($setting['ab_status'] && !$setting['ab_stock'])) {
				if (
					(!$setting['ab_product_allowed'] && !$setting['ab_enabled']) || 
					($setting['ab_product_allowed'] && in_array($product['product_id'], $setting['ab_product_allowed'])) ||
					($setting['ab_enabled'] && isset($credit_info['product_ab']) && $credit_info['product_ab'])
					) {
					$status_ab = true;
				}
				if ($status_ab) {
					$ab_price = $product['price'];
					if (!$setting['ab_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$ab_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['ab_special'] && (float)$product['special'] && ((isset($credit_info['special_ab']) && !$credit_info['special_ab']) || !isset($credit_info['special_ab']))) {
						$ab_price = $product['special'];
					}
					if ($setting['ab_min_total'] >= $ab_price || $setting['ab_max_total'] <= $ab_price) {
						$status_ab = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $ab_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $ab_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountab = (isset($credit_info['partscount_ab']) && $credit_info['partscount_ab'] !=0) ? $credit_info['partscount_ab'] : (!$setting['ab_pq'] ? '24' : $setting['ab_pq']);
					$markup_ab = (isset($credit_info['markup_ab']) && $credit_info['markup_ab'] !=0) ? $credit_info['markup_ab'] : (!$setting['ab_markup'] ? '24' : $setting['ab_markup']);
					$ab_price = ($ab_price + $option_price) * $markup_ab * $quantity;
					$ab_type = $setting['ab_merchantType'];
					$mounthprice_int_ab = ($ab_price*$markup_ab/($partsCountab));
						if ($setting['ab_markup_type'] == 'custom') {
							$mounthprice_int_ab = $ab_price*(1+(($setting['ab_markup_acquiring']+$setting['ab_markup_custom_AB'][$partsCountab])/100))/($partsCountab); 
						}	
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_ab, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_ab = sprintf($this->language->get('text_min_ab'), $partsCountab, $mounthprice);
					$ab_name = $this->language->get('text_title_ab');
					if ($price) {
						$ab_price = $price;
						if (!$setting['ab_special'] && $specialprice) {
							$ab_price = $specialprice;
						}
					} else {
						$ab_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($ab_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}

			if (($setting['sb_status'] && ($setting['sb_stock'] && $product['quantity'] > 0)) || ($setting['sb_status'] && !$setting['sb_stock'])) {
				if (
					(!$setting['sb_product_allowed'] && !$setting['sb_enabled']) || 
					($setting['sb_product_allowed'] && in_array($product['product_id'], $setting['sb_product_allowed'])) ||
					($setting['sb_enabled'] && isset($credit_info['product_sb']) && $credit_info['product_sb'])
					) {
					$status_sb = true;
				}
				if ($status_sb) {
					$sb_price = $product['price'];
					if (!$setting['sb_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$sb_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['sb_special'] && (float)$product['special'] && ((isset($credit_info['special_sb']) && !$credit_info['special_sb']) || !isset($credit_info['special_sb']))) {
						$sb_price = $product['special'];
					}
					if ($setting['sb_min_total'] >= $sb_price || $setting['sb_max_total'] <= $sb_price) {
						$status_sb = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $sb_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $sb_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountsb = (isset($credit_info['partscount_sb']) && $credit_info['partscount_sb'] !=0) ? $credit_info['partscount_sb'] : (!$setting['sb_pq'] ? '24' : $setting['sb_pq']);
					$markup_sb = (isset($credit_info['markup_sb']) && $credit_info['markup_sb'] !=0) ? $credit_info['markup_sb'] : (!$setting['sb_markup'] ? '24' : $setting['sb_markup']);
					$sb_price = ($sb_price + $option_price) * $markup_sb * $quantity;
					$sb_type = $setting['sb_merchantType'];
					$mounthprice_int_sb = (($sb_price*$markup_sb)+($sb_price*$markup_sb*0.1364+600))/$partsCountsb;
						if ($setting['sb_markup_type'] == 'custom') {
							$mounthprice_int_sb = $sb_price*(1+(($setting['sb_markup_acquiring']+$setting['sb_markup_custom_sb'][$partsCountsb])/100))/($partsCountsb); 
						}	
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_sb, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_sb = sprintf($this->language->get('text_min_sb'), $partsCountsb, $mounthprice);
					$sb_name = $this->language->get('text_title_sb');
					if ($price) {
						$sb_price = $price;
						if (!$setting['sb_special'] && $specialprice) {
							$sb_price = $specialprice;
						}
					} else {
						$sb_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($sb_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
			
			if (($setting['aa_status'] && ($setting['aa_stock'] && $product['quantity'] > 0)) || ($setting['aa_status'] && !$setting['aa_stock'])) {
				if (
					(!$setting['aa_product_allowed'] && !$setting['aa_enabled']) || 
					($setting['aa_product_allowed'] && in_array($product['product_id'], $setting['aa_product_allowed'])) ||
					($setting['aa_enabled'] && isset($credit_info['product_aa']) && $credit_info['product_aa'])
					) {
					$status_aa = true;
				}
				if ($status_aa) {
					$aa_price = $product['price'];
					if (!$setting['aa_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$aa_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['aa_special'] && (float)$product['special'] && ((isset($credit_info['special_ab']) && !$credit_info['special_ab']) || !isset($credit_info['special_ab']))) {
						$aa_price = $product['special'];
					}
					if ($setting['aa_min_total'] >= $aa_price || $setting['aa_max_total'] <= $aa_price) {
						$status_aa = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $aa_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $aa_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountaa = (isset($credit_info['partscount_aa']) && $credit_info['partscount_aa'] !=0) ? $credit_info['partscount_aa'] : (!$setting['aa_pq'] ? '24' : $setting['aa_pq']);
					$markup_aa = (isset($credit_info['markup_aa']) && $credit_info['markup_aa'] !=0) ? $credit_info['markup_aa'] : (!$setting['aa_markup'] ? '24' : $setting['aa_markup']);
					$aa_price = ($aa_price + $option_price) * $markup_aa * $quantity;
					$aa_type = $setting['aa_merchantType'];
					$mounthprice_int_aa = ($aa_price*$markup_aa/($partsCountaa+1));
						if ($setting['aa_markup_type'] == 'custom') {
							$mounthprice_int_aa = $aa_price*(1+(($setting['aa_markup_acquiring']+$setting['aa_markup_custom_AA'][$partsCountaa])/100))/($partsCountaa+1); 
						}	
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_aa, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_aa = sprintf($this->language->get('text_min_aa'), $partsCountaa, $mounthprice);
					$aa_name = $this->language->get('text_title_aa');
					if ($price) {
						$aa_price = $price;
						if (!$setting['aa_special'] && $specialprice) {
							$aa_price = $specialprice;
						}
					} else {
						$aa_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($aa_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
			
			if (($setting['pl_status'] && ($setting['pl_stock'] && $product['quantity'] > 0)) || ($setting['pl_status'] && !$setting['pl_stock']) && $ukrcredits_pl_data) {
				if (
					(!$setting['pl_product_allowed'] && !$setting['pl_enabled']) || 
					($setting['pl_product_allowed'] && in_array($product['product_id'], $setting['pl_product_allowed'])) ||
					($setting['pl_enabled'] && isset($credit_info['product_pl']) && $credit_info['product_pl'])
					) {
					$status_pl = true;
				}
				if ($status_pl) {
					$pl_price = $product['price'];
					if (!$setting['pl_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$pl_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['pl_special'] && (float)$product['special'] && ((isset($credit_info['special_pl']) && !$credit_info['special_pl']) || !isset($credit_info['special_pl']))) {
						$pl_price = $product['special'];
					}
					if ($setting['pl_min_total'] >= $pl_price || $setting['pl_max_total'] <= $pl_price) {
						$status_pl = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $pl_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $pl_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountpl = (isset($credit_info['partscount_pl']) && $credit_info['partscount_pl'] !=0) ? $credit_info['partscount_pl'] : (!$setting['pl_pq'] ? '24' : $setting['pl_pq']);
					$markup_pl = (isset($credit_info['markup_pl']) && $credit_info['markup_pl'] !=0) ? $credit_info['markup_pl'] : (!$setting['pl_markup'] ? '24' : $setting['pl_markup']);
					$pl_price = ($pl_price + $option_price) * $markup_pl * $quantity;
					$pl_type = $setting['pl_merchantType'];
					$mounthprice_int_pl = ($pl_price*$markup_pl/($partsCountpl+1)) / $ukrcredits_pl_data['pack'.($ukrcredits_pl_data['count']-1)]['coef'];
						if ($setting['pl_markup_type'] == 'custom') {
							$mounthprice_int_pl = $pl_price*(1+(($setting['pl_markup_acquiring']+$setting['pl_markup_custom_PL'][$partsCountpl])/100))/($partsCountpl+1) / $ukrcredits_pl_data['pack'.($ukrcredits_pl_data['count']-1)]['coef']; 
						}
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_pl, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_pl = sprintf($this->language->get('text_min_pl'), $partsCountpl, $mounthprice);
					$pl_name = $this->language->get('text_title_pl');
					
					if ($price) {
						$pl_price = $price;
						if (!$setting['pl_special'] && $specialprice) {
							$pl_price = $specialprice;
						}
					} else {
						$pl_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($pl_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
			if (($setting['pu_status'] && ($setting['pu_stock'] && $product['quantity'] > 0)) || ($setting['pu_status'] && !$setting['pu_stock'])) {
				if (
					(!$setting['pu_product_allowed'] && !$setting['pu_enabled']) || 
					($setting['pu_product_allowed'] && in_array($product['product_id'], $setting['pu_product_allowed'])) ||
					($setting['pu_enabled'] && isset($credit_info['product_pu']) && $credit_info['product_pu'])
					) {
					$status_pu = true;
				}
				if ($status_pu) {
					$pu_price = $product['price'];
					if (!$setting['pu_discount'] && $quantity > 1) {
						$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						if ($product_discount_query->num_rows) {
							$pu_price = $product_discount_query->row['price'];
						}
					}			
					if (!$setting['pu_special'] && (float)$product['special'] && ((isset($credit_info['special_pu']) && !$credit_info['special_pu']) || !isset($credit_info['special_pu']))) {
						$pu_price = $product['special'];
					}
					if ($setting['pu_min_total'] >= $pu_price || $setting['pu_max_total'] <= $pu_price) {
						$status_pu = false;
					}
					$option_price = 0;		
					if ($options) {
						$option_data = array();
						$option_price_arr = array();
						foreach ($options as $product_option_id => $option_value) {
							$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_query->num_rows) {
								if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
									$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
									
									if ($option_value_query->num_rows) {
									  //знаки равно нужными первыми
									  if ($option_value_query->row['price_prefix'] == '=') {
										  $sort_key=count($option_price_arr) + 1;
									  } else {
										  $sort_key=count($option_price_arr)+10;
									  }
									  
									  $option_price_arr[$sort_key] = array(
										  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
									  );
										if ($option_value_query->row['price_prefix'] == '+') {
											$option_price += $option_value_query->row['price'];
										} elseif ($option_value_query->row['price_prefix'] == '-') {
											$option_price -= $option_value_query->row['price'];
										}
							
									}
								} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
									foreach ($option_value as $product_option_value_id) {
										$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
										
										if ($option_value_query->num_rows) {
										  //знаки равно нужными первыми
										  if ($option_value_query->row['price_prefix'] == '=') {
											  $sort_key=count($option_price_arr) + 1;
										  } else {
											  $sort_key=count($option_price_arr)+10;
										  }
										  
										  $option_price_arr[$sort_key] = array(
											  $option_value_query->row['price_prefix']=>$option_value_query->row['price'],
										  );
											if ($option_value_query->row['price_prefix'] == '+') {
												$option_price += $option_value_query->row['price'];
											} elseif ($option_value_query->row['price_prefix'] == '-') {
												$option_price -= $option_value_query->row['price'];
											}
										}
									}
								}
							}
						}
					  $new_price = $pu_price;
					  $new_option_price = 0;
					  
					  ksort($option_price_arr);
					  
					  $has_eq_mod = false;

					  foreach($option_price_arr as $operations){
						  foreach($operations as $operation=>$value){
							  if ($operation == '=') {
								  //цена опции становится основной
								  if (!$has_eq_mod){
									  $new_price = 0;
									  $new_option_price = $value;
									  $has_eq_mod = true;
								  } else {
									  $new_option_price += $value;
								  }
							  } else if ($operation == '+') {
								  $new_option_price += $value;
							  } else if ($operation == '-') {
								  $new_option_price -= $value;
							  } else if ($operation == '*') {
								  $new_price = $new_price * $value;
								  $new_option_price = $new_option_price * $value;
							  } else if ($operation == '/') {
								  $new_price = $new_price / $value;
								  $new_option_price = $new_option_price / $value;
							  } else if ($operation == 'u') {
								  $new_price = $new_price + (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price + (( $new_option_price * $value ) / 100);
							  } else if ($operation == 'd') {
								  $new_price = $new_price - (( $new_price * $value ) / 100);
								  $new_option_price = $new_option_price - (( $new_option_price * $value ) / 100);
							  }
						  }
					  }
					  $pu_price = $new_price;
					  $option_price = $new_option_price;
					}
					if ($product['special']) {
						// $option_price = $option_price - ($option_price / 100) * ($product['price'] - $product['special']) / ($product['price'] / 100);
					}
					$partsCountpu = (isset($credit_info['partscount_pu']) && $credit_info['partscount_pu'] !=0) ? $credit_info['partscount_pu'] : (!$setting['pu_pq'] ? '24' : $setting['pu_pq']);
					$markup_pu = (isset($credit_info['markup_pu']) && $credit_info['markup_pu'] !=0) ? $credit_info['markup_pu'] : (!$setting['pu_markup'] ? '24' : $setting['pu_markup']);
					$pu_price = ($pu_price + $option_price) * $markup_pu * $quantity;
					$pu_type = $setting['pu_merchantType'];
					$mounthprice_int_pu = ($pu_price*$markup_pu/($partsCountpu+1));
						if ($setting['pu_markup_type'] == 'custom') {
							$mounthprice_int_pu = $pu_price*(1+(($setting['pu_markup_acquiring']+$setting['pu_markup_custom_pu'][$partsCountpu])/100))/($partsCountpu+1); 
						}	
					$mounthprice = strip_tags($this->currency->format($this->tax->calculate($mounthprice_int_pu, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					$mounthprice_text_pu = sprintf($this->language->get('text_min_pu'), $partsCountpu, $mounthprice);
					$pu_name = $this->language->get('text_title_pu');
					if ($price) {
						$pu_price = $price;
						if (!$setting['pu_special'] && $specialprice) {
							$pu_price = $specialprice;
						}
					} else {
						$pu_price = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($pu_price, $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
					}
				}
			}
						
		}


		if ($status_pp) {
			$pp = array(
				'type' => $pp_type,
				'price' => $pp_price,
				'mounthprice_int' => $mounthprice_int_pp,
				'partsCount' => $partsCountpp,
				'partsCountSel' => isset($this->session->data['ukrcredits_pp_sel'])?$this->session->data['ukrcredits_pp_sel']:'',
				'name' => $pp_name,
				'info' => $setting['pp_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_pp,
				'sort_order' => $setting['pp_sort_order']
			);
		} else {
			$pp = false;
		}
		
		if ($status_ii) {
			$ii = array(
				'type' => $ii_type,
				'price' => $ii_price,
				'mounthprice_int' => $mounthprice_int_ii,
				'partsCount' => $partsCountii,
				'partsCountSel' => isset($this->session->data['ukrcredits_ii_sel'])?$this->session->data['ukrcredits_ii_sel']:'',
				'name' => $ii_name,
				'info' => $setting['ii_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_ii,
				'sort_order' => $setting['ii_sort_order']
			);
		} else {
			$ii = false;
		}
		
		if ($status_mb) {
			$mb = array(
				'type' => $mb_type,
				'price' => $mb_price,
				'mounthprice_int' => $mounthprice_int_mb,
				'partsCount' => $partsCountmb,
				'partsCountSel' => isset($this->session->data['ukrcredits_mb_sel'])?$this->session->data['ukrcredits_mb_sel']:'',
				'name' => $mb_name,
				'info' => $setting['mb_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_mb,
				'sort_order' => $setting['mb_sort_order']
			);
		} else {
			$mb = false;
		}

		if ($status_ab) {
			$ab = array(
				'type' => $ab_type,
				'price' => $ab_price,
				'mounthprice_int' => $mounthprice_int_ab,
				'partsCount' => $partsCountab,
				'partsCountSel' => isset($this->session->data['ukrcredits_ab_sel'])?$this->session->data['ukrcredits_ab_sel']:'',
				'name' => $ab_name,
				'info' => $setting['ab_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_ab,
				'sort_order' => $setting['ab_sort_order'],
				'mounth' => $setting['ab_markup_custom_AB']
			);
		} else {
			$ab = false;
		}

		if ($status_sb) {
			$sb = array(
				'type' => $sb_type,
				'price' => $sb_price,
				'mounthprice_int' => $mounthprice_int_sb,
				'partsCount' => $partsCountsb,
				'partsCountSel' => isset($this->session->data['ukrcredits_sb_sel'])?$this->session->data['ukrcredits_sb_sel']:'',
				'name' => $sb_name,
				'info' => $setting['sb_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_sb,
				'sort_order' => $setting['sb_sort_order'],
				'mounth' => $setting['sb_id_data']
			);
		} else {
			$sb = false;
		}
		
		if ($status_aa) {
			$aa = array(
				'type' => $aa_type,
				'price' => $aa_price,
				'mounthprice_int' => $mounthprice_int_aa,
				'partsCount' => $partsCountaa,
				'partsCountSel' => isset($this->session->data['ukrcredits_aa_sel'])?$this->session->data['ukrcredits_aa_sel']:'',
				'name' => $aa_name,
				'info' =>$setting['aa_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_aa,
				'sort_order' => $setting['aa_sort_order']
			);
		} else {
			$aa = false;
		}
		
		if ($status_pl) {
			$pl = array(
				'type' => $pl_type,
				'price' => $pl_price,
				'mounthprice_int' => $mounthprice_int_pl,
				'partsCount' => $partsCountpl,
				'partsCountSel' => isset($this->session->data['ukrcredits_pl_sel'])?$this->session->data['ukrcredits_pl_sel']:'',
				'name' => $pl_name,
				'info' => $setting['pl_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_pl,
				'sort_order' => $setting['pl_sort_order'],
				'mounth' => $setting['pl_markup_custom_PL']
			);
		} else {
			$pl = false;
		}
		
		if ($status_pu) {
			$pu = array(
				'type' => $pu_type,
				'price' => $pu_price,
				'mounthprice_int' => $mounthprice_int_pu,
				'partsCount' => $partsCountpu,
				'partsCountSel' => isset($this->session->data['ukrcredits_pu_sel'])?$this->session->data['ukrcredits_pu_sel']:'',
				'name' => $pu_name,
				'info' => $setting['pu_info'][(int)$this->config->get('config_language_id')],
				'mounthprice_text' => $mounthprice_text_pu,
				'sort_order' => $setting['pu_sort_order']
			);
		} else {
			$pu = false;
		}
		
		$credits_data = array(
			'pp' => $pp,
			'ii' => $ii,
			'mb' => $mb,
			'ab' => $ab,
			'sb' => $sb,
			'aa' => $aa,
			'pl' => $pl,
			'pu' => $pu,
		);
	
		uasort($credits_data, $this->sort_function('sort_order'));

		return $credits_data;
	}

	private function sort_function($key){
		return function ($a, $b) use ($key) {
			return !empty($a[$key]) && !empty($b[$key]) ? strnatcmp($a[$key], $b[$key]) : false;
		};
	}
}

if (version_compare(phpversion(), '7.1', '<')) {
	require_once 'uc/uc56.php';
} else {
	require_once 'uc/uc71.php';
}