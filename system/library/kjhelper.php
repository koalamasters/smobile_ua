<?php

class kjhelper {
	public static $key_prefix;
	public static $user_token;
	public static $marketplace_link;
	protected $registry;

	public function __get($key) 
    {
		return $this->registry->get($key);
	}

    public function kjseries_select_id($als = "p")
    {
        $type = $this->config->get(self::$key_prefix . 'kjseries_grouping_type');
                
        if($type == "type 3")
        {
            return "IF(kl.parent_id IS NOT NULL AND kl.parent_status > 0, kl.parent_id, ".$als.".product_id) as product_id"; 
        }
        else
        {
            return $als.".product_id";
        }
    }

    public function hpmr_select_id($als = "p")
    {
        $type = $this->config->get(self::$key_prefix . 'hpmrr_grouping_type');

        if($type == "type 3")
        {
            return "IF(hl.parent_id IS NOT NULL AND hl.parent_status > 0, hl.parent_id, ".$als.".product_id) as product_id"; 
        }
        else
        {
            return $als.".product_id";
        }
    }

    public function hpmr_group_by()
    {
        $gr_by_stock = $this->config->get(self::$key_prefix . "hpmrr_grouping_stock") ? ", IF(p.quantity > 0, '-1', '-0')" : "";
        return "IF(hl.parent_id IS NOT NULL, CONCAT(hl.parent_id, '-', hl.grsort" . $gr_by_stock . "), p.product_id)";
    }

	public function __construct($registry) 
	{
		$this->registry = $registry;
		if(floatval(VERSION) < 3)
		{
			self::$key_prefix = "";
        	self::$user_token = "token";
        	self::$marketplace_link = 'extension/extension';
        }
        else 
        {
        	self::$key_prefix = "module_";
        	self::$user_token = "user_token";
        	self::$marketplace_link = 'marketplace/extension';
        }
	}

    public function get_disc_price($pid, $qty)
    {

        $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$pid . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$qty . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

        if ($product_discount_query->num_rows) 
        {
            return $product_discount_query->row['price'];
        }
        else
        {
            return false;
        }
    }

	public function update_table($columns)
	{
		$res = "";

		foreach($columns as $column)
        {
        	$table_name = DB_PREFIX . $column['table'];

        	$exist_table_query = $this->db->query("SHOW TABLES LIKE '". $table_name . "'");
        	if($exist_table_query->num_rows == 0)
        	{
        		$res .= "DONT EXIST TABLE " . $table_name . " <br/>";
        		continue;
        	}

            $check = $this->db->query("SHOW COLUMNS FROM `" . $table_name. "` 
            LIKE '" . $column['name'] . "'");

            if($check->num_rows == 0)
            {
                $this->db->query("ALTER TABLE  `" . $table_name . "` 
                ADD COLUMN " . $column['name']." ".$column['datatype']);

                $res .= $column['table'] . ": ADD COLUMN ".$column['name']." <br/>";
            }
            else
            {
            	$res .= $column['table'].": COLUMN ALREDY EXIST ".$column['name']." <br/>";
            }
        }

        return $res;
	}
}