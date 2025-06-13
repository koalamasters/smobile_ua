<?php

class ModelExtensionModuleMonoCheckout extends Model
{
    private $table = 'order';

    public function addOrder($data)
    {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "$this->table` SET store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', language_id = '" . (int)$data['language_id'] . "', total = '" . (float)$data['total'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', date_added = NOW(), date_modified = NOW()");
        $order_id = $this->db->getLastId();

        // Products
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

                $order_product_id = $this->db->getLastId();

                foreach ($product['option'] as $option) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
                }
            }
        }

        if (isset($data['totals'])) {
            foreach ($data['totals'] as $total) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
            }
        }

        return $order_id;
    }

    public function updateOrder($mono_order_id, $data)
    {

        $this->db->query("UPDATE  `" . DB_PREFIX . "$this->table` SET comment = '" . $this->db->escape($data->order_comment) . "', firstname = '" . $this->db->escape($data->deliveryRecipientInfo->first_name) . "', payment_firstname = '" . $this->db->escape($data->deliveryRecipientInfo->first_name) . "', shipping_firstname = '" . $this->db->escape($data->deliveryRecipientInfo->first_name) . "', lastname = '" . $this->db->escape($data->deliveryRecipientInfo->last_name) . "', payment_lastname = '" . $this->db->escape($data->deliveryRecipientInfo->last_name) . "', shipping_lastname = '" . $this->db->escape($data->deliveryRecipientInfo->last_name) . "', email = '" . $this->db->escape($data->order_email) . "', telephone = '" . $this->db->escape($data->deliveryRecipientInfo->phoneNumber) . "', payment_address_1 = '" . $this->db->escape($data->delivery_branch_address) . "', payment_code = '" . $this->db->escape($data->payment_method) . "', payment_method = '" . $this->db->escape($data->payment_method_desc) . "', shipping_code = '" . $this->db->escape($data->delivery_method) . "', shipping_method = '" . $this->db->escape($data->delivery_method_desc) . "', shipping_address_1 = '" . $this->db->escape($data->delivery_branch_address) . "' WHERE mono_id = '" . $mono_order_id . "'");
        $query = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "$this->table` WHERE mono_id = '" . $mono_order_id . "'");

        return $query->row['order_id'];
    }

    public function addMonoOrderID($order_id, $mono_id)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "$this->table` SET mono_id = '" . $this->db->escape($mono_id) . "' WHERE order_id = '" . $order_id . "'");
    }
}