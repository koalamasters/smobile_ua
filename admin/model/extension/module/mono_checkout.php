<?php
class ModelExtensionModuleMonoCheckout extends Model {
    public function install($languages) {
        $query = $this->db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='". DB_DATABASE ."' AND `TABLE_NAME`= '`".DB_PREFIX."order`' AND `COLUMN_NAME`='mono_id'");
        if(!$query->num_rows) $this->db->query("ALTER TABLE `".DB_PREFIX."order` ADD COLUMN mono_id varchar(255) AFTER order_id");
    }

    public function uninstall() {
        $this->db->query("DELETE FROM ".DB_PREFIX."order_status WHERE mono_code IS NOT NULL");
    }
}