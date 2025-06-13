<?php
namespace Cart;
class Salesagent {

	private $db;
	
	public function __construct($registry) {
		$this->db = $registry->get('db');
	}

	public function salesAgentCustomer($customer_id, $salesagent_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesagent_customer WHERE customerid = '" . (int)$customer_id . "'");
        if($salesagent_id) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_customer SET salesagent_id = '" . (int)$salesagent_id . "', customerid = '" . (int)$customer_id . "'");
        }
	}
}