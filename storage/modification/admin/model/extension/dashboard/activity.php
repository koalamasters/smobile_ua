<?php
class ModelExtensionDashboardActivity extends Model {
	public function getActivities() {
		
       $salesagent_id =  $this->user->getSalesAgentId();
        if($salesagent_id) {
        $query = $this->db->query("SELECT `key`, `data`, `date_added` FROM `" . DB_PREFIX . "customer_activity` ca INNER JOIN `" . DB_PREFIX . "salesagent_customer` sc ON (ca.customer_id = sc.customerid) WHERE sc.salesagent_id IN (".$salesagent_id.") ORDER BY ca.`date_added` DESC LIMIT 0,5");
    } else {
      $query = $this->db->query("SELECT `key`, `data`, `date_added` FROM `" . DB_PREFIX . "customer_activity` ORDER BY `date_added` DESC LIMIT 0,5");
    }
        

		return $query->rows;
	}
}