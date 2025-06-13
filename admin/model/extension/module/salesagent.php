<?php
class ModelExtensionModuleSalesagent extends Model {
    public function addsalesagent($data) {
        if (empty($data['states'])) {
            $data['states'] = array();
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent SET 
		firstname = '" . $this->db->escape($data['firstname']) . "', 
		lastname = '" . $this->db->escape($data['lastname']) . "', 
		email = '" . $this->db->escape($data['email']) . "', 
		telephone = '" . $this->db->escape($data['telephone']) . "', 
		fax = '" . $this->db->escape($data['fax']) . "', 
		address = '" . $this->db->escape($data['address'])  . "', 
		uniqueid = '" . $this->db->escape($data['uniqueid'])  . "', 
		city = '" . $this->db->escape($data['city']) . "', 
		commission = '" . (float)$data['commission'] . "', 
		parent_commission = '" . (float)$data['parent_commission'] . "', 
		second_parent_commission = '" . (float)$data['second_parent_commission'] . "', 
		user_id = '" . (int)$data['user_id'] . "', 
		parent_id = '" . (int)$data['parent_id'] . "', 
		alertemail = '" . (int)$data['alertemail'] . "', 
		zoneids = '" . $this->db->escape(implode(",", $data['states'])) . "', 
		status = '" . (int)$data['status'] . "', 
		customer_id = '" . (int)$data['customer_id'] . "', 
		date_added = NOW()
	");

        $salesagent_id = $this->db->getLastId();

        if (isset($data['clists']) && !empty($data['clists'])) {
            foreach ($data['clists'] as $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_clist SET 
				clist_id = '" . (int)$value['clist_id'] . "', 
				salesagent_id = '" . (int)$salesagent_id . "', 
				commission = '" . (float)$value['commission'] . "', 
				parent_commission = '" . (float)$value['parent_commission'] . "', 
				second_parent_commission = '" . (float)$value['second_parent_commission'] . "'
			");
            }
        }

        if (isset($data['salesagent_store'])) {
            foreach ($data['salesagent_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_store SET 
				salesagent_id = '" . (int)$salesagent_id . "', 
				store_id = '" . (int)$store_id . "'
			");
            }
        }

        if (isset($data['salesagent_customer_group'])) {
            foreach ($data['salesagent_customer_group'] as $customer_group_id => $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_customer_group SET 
				salesagent_id = '" . (int)$salesagent_id . "', 
				commission = '" . (float)$value . "', 
				customer_group_id = '" . (int)$customer_group_id . "'
			");
            }
        }
    }


    public function editsalesagent($salesagent_id, $data) {
        if (empty($data['states'])) {
            $data['states'] = array();
        }

        $this->db->query("UPDATE " . DB_PREFIX . "salesagent SET 
		firstname = '" . $this->db->escape($data['firstname']) . "', 
		lastname = '" . $this->db->escape($data['lastname']) . "', 
		email = '" . $this->db->escape($data['email']) . "', 
		telephone = '" . $this->db->escape($data['telephone']) . "', 
		fax = '" . $this->db->escape($data['fax']) . "', 
		address = '" . $this->db->escape($data['address']) . "', 
		uniqueid = '" . $this->db->escape($data['uniqueid']) . "', 
		city = '" . $this->db->escape($data['city']) . "', 
		commission = '" . (float)$data['commission'] . "', 
		parent_commission = '" . (float)$data['parent_commission'] . "', 
		second_parent_commission = '" . (float)$data['second_parent_commission'] . "', 
		user_id = '" . (int)$data['user_id'] . "', 
		parent_id = '" . (int)$data['parent_id'] . "', 
		alertemail = '" . (int)$data['alertemail'] . "', 
		zoneids = '" . $this->db->escape(implode(",", $data['states'])) . "', 
		status = '" . (int)$data['status'] . "',
		customer_id = '" . (int)$data['customer_id'] . "'
		WHERE salesagent_id = '" . (int)$salesagent_id . "'
	");

        $this->db->query("DELETE FROM " . DB_PREFIX . "salesagent_clist WHERE salesagent_id = '" . (int)$salesagent_id . "'");
        if (isset($data['clists']) && !empty($data['clists'])) {
            foreach ($data['clists'] as $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_clist SET 
				clist_id = '" . (int)$value['clist_id'] . "', 
				salesagent_id = '" . (int)$salesagent_id . "', 
				commission = '" . (float)$value['commission'] . "', 
				parent_commission = '" . (float)$value['parent_commission'] . "', 
				second_parent_commission = '" . (float)$value['second_parent_commission'] . "'
			");
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "salesagent_store WHERE salesagent_id = '" . (int)$salesagent_id . "'");
        if (isset($data['salesagent_store'])) {
            foreach ($data['salesagent_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_store SET 
				salesagent_id = '" . (int)$salesagent_id . "', 
				store_id = '" . (int)$store_id . "'
			");
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "salesagent_customer_group WHERE salesagent_id = '" . (int)$salesagent_id . "'");
        if (isset($data['salesagent_customer_group'])) {
            foreach ($data['salesagent_customer_group'] as $customer_group_id => $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_customer_group SET 
				salesagent_id = '" . (int)$salesagent_id . "', 
				commission = '" . (float)$value . "', 
				customer_group_id = '" . (int)$customer_group_id . "'
			");
            }
        }
    }


	public function editToken($salesagent_id, $token) {
		$this->db->query("UPDATE " . DB_PREFIX . "salesagent SET token = '" . $this->db->escape($token) . "' WHERE salesagent_id = '" . (int)$salesagent_id . "'");
	}

	public function deletesalesagent($salesagent_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '" . (int)$salesagent_id . "'");
	}

	public function getsalesagent($salesagent_id) {
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '" . (int)$salesagent_id . "' ";

		$salesagent_id =  $this->user->getSalesAgentId();
		if($salesagent_id) {
			$sql .= " AND salesagent_id  IN  (" . $salesagent_id . ") ";
		}
		$query = $this->db->query($sql);
		if($query->num_rows) {
			return $query->row;
		} else {
			return 0;
		}
		
	}

	public function getsalesagentname($salesagent_id) {
		$query = $this->db->query("SELECT CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '" . (int)$salesagent_id . "'");
		if($query->num_rows) {
			return $query->row['name'];
		} else {
			return "";
		}
		
	}

	public function getSecondParentName($salesagent_id) {
		$query = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '" . (int)$salesagent_id . "'");
		if($query->num_rows && $query->row['parent_id']) {
			return $this->getsalesagentname($query->row['parent_id']);
		} else {
			return "-";
		}
		
	}

	public function getAgentName($order_id) {
		$name = "";
		$query = $this->db->query("SELECT st.name FROM " . DB_PREFIX . "salesagent_transaction st LEFT JOIN " . DB_PREFIX . "salesagent_order o ON (st.salesagent_id = o.salesagent_id) WHERE o.order_id = '" . (int)$order_id . "' LIMIT 1");
		if($query->num_rows) {
			$name = ucwords($query->row['name']);
		}
		return $name;
	}

	public function getAgentId($order_id) {
		$query = $this->db->query("SELECT st.salesagent_id FROM " . DB_PREFIX . "salesagent_transaction st LEFT JOIN " . DB_PREFIX . "salesagent_order o ON (st.salesagent_id = o.salesagent_id) WHERE o.order_id = '" . (int)$order_id . "' LIMIT 1");
		if($query->num_rows) {
			$salesagent_id = $query->row['salesagent_id'];
		} else {
			$salesagent_id = 0;
		}
		return $salesagent_id;
	}

	public function getsalesagentByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesagent WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row;
	}

	public function getsalesagentByUniqueid($uniqueid) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesagent WHERE uniqueid = '" . $this->db->escape($uniqueid) . "'");

		return $query->row;
	}

	public function getCustomerCheck($customer_id) {
		 $salesagent_id =  $this->user->getSalesAgentId();
		 if($salesagent_id) {
          	$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "' AND  salesagent_id IN (".$salesagent_id.") ");
         	if($query->num_rows) {
         		return 0;
         	} else {
         		return 1;
         	}
         } else {
         	return 0;
         }
	}

	public function getOrderCheck($order_id) {
		 $salesagent_id =  $this->user->getSalesAgentId();
		 if($salesagent_id) {
          	$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesagent_order WHERE order_id = '" . (int)$order_id . "' AND  salesagent_id IN (".$salesagent_id.") ");
         	if($query->num_rows) {
         		return 0;
         	} else {
         		return 1;
         	}
         } else {
         	return 0;
         }
	}

	public function getsalesagents($data = array()) {
		$sql = "SELECT *, CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "salesagent WHERE 1  ";

		$salesagent_id =  $this->user->getSalesAgentId();
		if($salesagent_id) {
			$sql .= " AND salesagent_id  IN  (" . $salesagent_id . ") ";
		}

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'firstname',
			'email',
			'status',
			'date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY firstname";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAgentStores($salesagent_id) {
		$agent_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent_store WHERE salesagent_id = '" . (int)$salesagent_id . "'");

		foreach ($query->rows as $result) {
			$agent_store_data[] = $result['store_id'];
		}

		return $agent_store_data;
	}

	public function getAgentCustomerGroups($salesagent_id) {
		$agent_customergroup_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent_customer_group WHERE salesagent_id = '" . (int)$salesagent_id . "'");

		foreach ($query->rows as $result) {
			$agent_customergroup_data[$result['customer_group_id']] = $result['commission'];
		}

		return $agent_customergroup_data;
	}

	

	
	public function getTotalsalesagents($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesagent WHERE 1 ";

		$salesagent_id =  $this->user->getSalesAgentId();
		if($salesagent_id) {
			$sql .= " AND salesagent_id  IN  (" . $salesagent_id . ") ";
		}

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getsalesagentadmin($customer_id) {
		$salesagent_id = 0;
		if($customer_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent_customer WHERE customerid = '".(int)$customer_id."' LIMIT 1");
			if($query->num_rows) {
				$salesagent_id = $query->row['salesagent_id'];
			}
		}
		return $salesagent_id;
	}

	public function getsalesagentadminlogin($customer_id) {
		$salesagent_id = 0;
		if($customer_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent_customer WHERE customerid = '".(int)$customer_id."' LIMIT 1");
			if($query->num_rows) {
				$salesagent_id = $query->row['salesagent_id'];
				$query2 = $this->db->query("SELECT DISTINCT *, CONCAT(firstname, ' ', lastname) AS name FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '".(int)$salesagent_id."'");
				if($query2->num_rows) {	
					$this->session->data['salesagent_id'] = $salesagent_id;
					$this->session->data['salesagent_name'] = $query2->row['name'];
				}
			}
		}
	}



	public function addclist($data) {
		if(!isset($data['products'])) {
			$data['products'] = array();
		}
		if(!isset($data['categories'])) {
			$data['categories'] = array();
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "clist SET name = '" . $this->db->escape($data['name']) . "', product_id = '" . $this->db->escape(json_encode($data['products']))  . "', category_id = '" . $this->db->escape(json_encode($data['categories'])) . "'");
	}

	public function editclist($clist_id, $data) {
		
		if(!isset($data['products'])) {
			$data['products'] = array();
		}
		if(!isset($data['categories'])) {
			$data['categories'] = array();
		}
		
		$this->db->query("UPDATE " . DB_PREFIX . "clist SET name = '" . $this->db->escape($data['name']) . "', product_id = '" . $this->db->escape(json_encode($data['products']))  . "', category_id = '" . $this->db->escape(json_encode($data['categories'])) . "' WHERE clist_id = '".(int)$clist_id."'");
	}

	public function deleteclist($clist_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "clist WHERE clist_id = '" . (int)$clist_id . "'");
	}

	public function getclist($clist_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "clist WHERE clist_id = '" . (int)$clist_id . "'");

		return $query->row;
	}

	public function getsalesagentclist($salesagent_id) {
		$returndata = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent_clist sc LEFT JOIN " . DB_PREFIX . "clist c ON (sc.clist_id = c.clist_id) WHERE sc.salesagent_id = '" . (int)$salesagent_id . "'");
		// foreach ($query->rows as $key => $value) {
		// 	$returndata[$value['clist_id']]['name'] = $value['name'];
		// 	$comm_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent_clist  WHERE salesagent_id = '" . (int)$salesagent_id . "' AND clist_id = '".(int)$value['clist_id']."'");
		// 	$commission_data = array();
		// 	foreach ($comm_query->rows as $key => $value) {
		// 		$commission_data[$key]['commission'] = $value['commission'];
		// 		$commission_data[$key]['parent_commission'] = $value['parent_commission'];
		// 		$commission_data[$key]['second_parent_commission'] = $value['second_parent_commission'];
		// 	}
		// 	$returndata[$value['clist_id']]['comm'] = $commission_data;
		// }
		// return $returndata;
		return $query->rows;
	}

	public function getclists($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "clist c WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'c.name'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}


	public function getTotalClist($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "clist c WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	

	public function createTable() {
		//$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent` (
            		  `salesagent_id` int(11) NOT NULL AUTO_INCREMENT,
					  `store_id` int(11) NOT NULL DEFAULT '0',
					  `user_id` int(11) NOT NULL,
					  `parent_id`  int(11) NOT NULL,
					  `parent_commission`  float(11) NOT NULL,
					  `second_parent_commission`  float(11) NOT NULL,
					  `firstname` varchar(32) NOT NULL,
					  `lastname` varchar(32) NOT NULL,
					  `email` varchar(256) NOT NULL,
					  `telephone` varchar(32) NOT NULL,
					  `commission` float(11) NOT NULL DEFAULT '0',
					  `fax` varchar(32) NOT NULL,
					  `address` text NOT NULL,
					  `city` varchar(40) NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `alertemail` tinyint(1) NOT NULL,
					  `uniqueid`  varchar(128) NOT NULL,
					  `date_added` datetime NOT NULL,
					  PRIMARY KEY (`salesagent_id`))
					  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
       			  $this->db->query($sql);

	       		$permission['access'][] = "user/api";
	       		$permission['access'][] = "sale/order";
	       		$permission['access'][] = "customer/customer";
	       		$permission['access'][] = "extension/report/salesagent";

       			$this->db->query("INSERT INTO " . DB_PREFIX . "user_group SET name = 'Sales Agent/Affiliate Group', permission = '" . json_encode($permission) . "'");
       			$userid = $this->db->getLastId();
       			$this->load->model("setting/setting");
       			$temp['salesagent_usergrouprestrictions'][] = $userid; 
       			$temp['salesagent_unpaid_color'] = "#ffc04c";
       			$temp['salesagent_paid_color'] = "#51b152";
       			$this->model_setting_setting->editSetting('salesagent', $temp);

        }

        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "salesagent` LIKE  'zoneids'";
        $result = $this->db->query($sql)->num_rows;
        if(!$result) {
        	$this->db->query("ALTER TABLE `" . DB_PREFIX . "salesagent` ADD `zoneids` varchar(512) NOT NULL");
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_transaction`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_transaction'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_transaction` (
            		  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
            		  `salesagent_id` int(11) NOT NULL,
            		  `name` varchar(128) NOT NULL,
					  `order_id` int(11) NOT NULL,
					  `customer_id` int(11) NOT NULL,
					  `customer_email`   varchar(255) NOT NULL,
					  `commission` float(11) NOT NULL,
					  `sub_total`   float(11) NOT NULL,
					  `calculationtext` text NOT NULL,
					  `product` int(11) NOT NULL,
					  `amount` varchar(32) NOT NULL,
					  `date_added` datetime NOT NULL,
					   PRIMARY KEY (`transaction_id`))
					  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
       		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'salesagent', `key` = 'salesagent_installed', `value` = '1'");
        }

        if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "salesagent_transaction` LIKE  'paidout'")->num_rows) {
	    	$this->db->query("ALTER TABLE `" . DB_PREFIX . "salesagent_transaction` ADD  `paidout`  tinyint(1) NOT NULL");
	  	}

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_order`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_order'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_order` (
					  `order_id` int(11) NOT NULL,
        		      `salesagent_id` int(11) NOT NULL)
  					  ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
       			  $this->db->query($sql);

       		$query = $this->db->query("SELECT salesagent_id,order_id FROM `" . DB_PREFIX . "order`");
       		foreach ($query->rows as $key => $value) {
       			$this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_order SET salesagent_id = '" . (int)$value['salesagent_id'] . "', order_id = '".(int)$value['order_id']."'");
       		}
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_customer`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_customer'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_customer` (
					  `customerid` int(11) NOT NULL,
        		      `salesagent_id` int(11) NOT NULL)
  					 ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
        }

        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "salesagent_customer` LIKE  'customer_id'";
        $result = $this->db->query($sql)->num_rows;
        if($result) {
        	$this->db->query("ALTER TABLE ". DB_PREFIX ."salesagent_customer CHANGE customer_id customerid int(11) NOT NULL");
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_customer_group`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_customer_group'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_customer_group` (
					  `customer_group_id` int(11) NOT NULL,
					  `commission` float(11) NOT NULL,
        		      `salesagent_id` int(11) NOT NULL)
  					 ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."clist`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."clist'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "clist` (
            		  `clist_id` int(11) NOT NULL AUTO_INCREMENT,
            		  `name` varchar(128) NOT NULL,
            		  `product_id` text NOT NULL,
            		  `category_id` text NOT NULL,
					   PRIMARY KEY (`clist_id`))
					  ENGINE=MyISAM COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
        }
        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_clist`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_clist'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_clist` (
            		  `salesagent_clist_id` int(11) NOT NULL AUTO_INCREMENT,
            		  `clist_id` int(11) NOT NULL,
            		  `salesagent_id` int(11) NOT NULL,
            		  `commission` float(11) NOT NULL,
            		  `parent_commission` float(11) NOT NULL,
            		  `second_parent_commission` float(11) NOT NULL,
					   PRIMARY KEY (`salesagent_clist_id`))
					  ENGINE=MyISAM COLLATE=utf8_general_ci";
       			  $this->db->query($sql);
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_temporder`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_temporder'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_temporder` (
            	`salesagent_temporder_id` int(11) NOT NULL AUTO_INCREMENT,
			    `order_id` int(11) NOT NULL,
			    `extra1` int(11) NOT NULL,
		        `salesagent_id` int(11) NOT NULL,
		        PRIMARY KEY (`salesagent_temporder_id`))
				ENGINE=MyISAM COLLATE=utf8_general_ci";
       		$this->db->query($sql);
        }

        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "salesagent_temporder` LIKE  'extra1'";
        $result = $this->db->query($sql)->num_rows;
        if(!$result) {
        	$this->db->query("ALTER TABLE `" . DB_PREFIX . "salesagent_temporder` ADD `extra1` int(11) NOT NULL");
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_store`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_store'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_store` (
			     `salesagent_id` int(11) NOT NULL,
  				 `store_id` int(11) NOT NULL DEFAULT '0',
  				 PRIMARY KEY (`salesagent_id`,`store_id`))
				ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
       		$this->db->query($sql);

       		//By default assigning to default store
       		$query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE 1 = 1");
       		foreach ($query->rows as $key => $value) {
       			$this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_store SET salesagent_id = '" . (int)$value['salesagent_id'] . "', store_id = '0'");
       		}
        }

         //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_payouts_transaction`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_payouts_transaction'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_payouts_transaction` (
            	`salesagent_payouts_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
			    `transaction_id` varchar(128) NOT NULL,
			    `original_transaction_id` int(11) NOT NULL,
		        `order_id` int(11) NOT NULL,
		        `orderamount` varchar(64) NOT NULL,
		        `commissionamount` varchar(64) NOT NULL,
		        `settleddate` datetime NOT NULL,
		        `salesagent_id` int(11) NOT NULL,
		        `salesagent_payout_id` int(11) NOT NULL,
		        `name` varchar(128) NOT NULL,
		        PRIMARY KEY (`salesagent_payouts_transaction_id`))
				ENGINE=MyISAM COLLATE=utf8_general_ci";
       		$this->db->query($sql);
        }

        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "salesagent_payouts_transaction` LIKE  'original_transaction_id'";
        $result = $this->db->query($sql)->num_rows;
        if(!$result) {
        	$this->db->query("ALTER TABLE `" . DB_PREFIX . "salesagent_payouts_transaction` ADD `original_transaction_id` int(11) NOT NULL");
        }

        //$this->db->query("DROP TABLE `". DB_PREFIX ."salesagent_payouts`");
	    if ($this->db->query("SHOW TABLES LIKE '". DB_PREFIX ."salesagent_payouts'")->num_rows == 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "salesagent_payouts` (
            	`salesagent_payouts_id` int(11) NOT NULL AUTO_INCREMENT,
			    `transaction_id` varchar(128) NOT NULL,
		        `totalorders` int(11) NOT NULL,
		        `amountsettled` varchar(255) NOT NULL,
		        `paymentdetails` float(11) NOT NULL,
		        `image_1` varchar(255) NOT NULL,
		        `image_2` varchar(255) NOT NULL,
		        `notes` varchar(512) NOT NULL,
		        `settleddate` datetime NOT NULL,
		        `salesagent_id` int(11) NOT NULL,
		        `name` varchar(128) NOT NULL,
		        PRIMARY KEY (`salesagent_payouts_id`))
				ENGINE=MyISAM COLLATE=utf8_general_ci";
       		$this->db->query($sql);
        }
    }

    public function getStates($data = array()) {
		$sql = "SELECT zone_id,name FROM " . DB_PREFIX . "zone WHERE 1 = 1 ";

		if(!empty($data['filter_name'])) {
			$sql .= " AND (name LIKE '".$this->db->escape($data['filter_name'])."%' OR code = '".$this->db->escape($data['filter_name'])."') ";
		}

		$sql .= " ORDER BY name";

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCommissionDetails() {
		$returndata = array();
		$salesagent_query = $this->db->query("SELECT salesagent_id FROM " . DB_PREFIX . "salesagent WHERE user_id = '" . (int)$this->user->getId() . "'");
	    if($salesagent_query->num_rows) {
	        foreach($salesagent_query->rows as $key => $value) {
	        	$salesagent_info = $this->getsalesagent($value['salesagent_id']);
	        	if($salesagent_info){
	        		$returndata['default'] = $salesagent_info['commission'];
	        		$clists = $this->getsalesagentclist($value['salesagent_id']);
	        		foreach ($clists as $key => $value) {
	        			$returndata[$value['name']] = $value['commission'];
	        		}
	        	}
	    	}
	    }
	    return $returndata;
	}
    
	public function newSignUp($salesagent_id,$firstname,$lastname,$email,$telephone) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '" . (int)$salesagent_id . "'");
		if($query->num_rows && $query->row['email'] && $query->row['alertemail']) {
			$salesagent_name = $query->row['firstname'];
			$this->load->language('extension/module/salesagent');

			$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message = sprintf($this->language->get('text_congrats'), $salesagent_name, html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

			$message .= $this->language->get('text_firstname') . ' ' . $firstname . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $lastname . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $email . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $telephone . "\n";

			$mail = new Mail($this->config->get('config_mail_engine'));
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($query->row['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setText($message);
			$mail->send();
		}
	}

    public function getCategoryTree() {
        $this->load->model('catalog/category');
        $categories = $this->model_catalog_category->getCategories();

        $cats_by_parent = [];
        foreach ($categories as &$category) {
            $category['full_name'] = $category['name'];
            $name_parts = explode('&gt;', $category['full_name']);

            $category['full_name'] = str_replace('&nbsp;', ' ', $category['full_name']);
            $category['name'] = str_replace('&nbsp;', ' ', end($name_parts));

            $cats_by_parent[$category['parent_id']][] = $category;
        }
        return $this->buildCategoryTree($cats_by_parent);
    }

    public function buildCategoryTree($cats_by_parent, $parent_id = 0) {
        $tree = [];

        if (!isset($cats_by_parent[$parent_id])) {
            return [];
        }

        foreach ($cats_by_parent[$parent_id] as $category) {
            $children = $this->buildCategoryTree($cats_by_parent, $category['category_id']);

            $tree[] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'full_name'   => $category['full_name'],
                'sort_order'  => $category['sort_order'],
                'children'    => $children
            ];
        }

        return $tree;
    }

}
