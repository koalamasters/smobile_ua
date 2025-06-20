<?php class ModelExtensionReportSalesAgent extends Model
{
    public function getTransactionsSummary($data)
    {
        $sql = "SELECT DISTINCT(st.salesagent_id),st.name,sum(st.commission) as commission,sum(st.amount) as amount FROM `" . DB_PREFIX . "salesagent_transaction` st LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id = st.order_id) LEFT JOIN `" . DB_PREFIX . "salesagent` s ON (s.salesagent_id = st.salesagent_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE st.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE st.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND st.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id IN (" . $this->db->escape($data['filter_order_status_id']) . ") ";
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        $sql .= "GROUP BY st.name ORDER BY st.name ASC";
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

    public function getTotalTransactionsSummary($data)
    {
        $sql = "SELECT DISTINCT st.salesagent_id FROM `" . DB_PREFIX . "salesagent_transaction` st LEFT JOIN `" . DB_PREFIX . "order` o  ON (o.order_id = st.order_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE st.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE st.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND st.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_transactionids'])) {
            $sql .= " AND st.transaction_id  IN  (" . $this->db->escape($data['filter_transactionids']) . ") ";
        }
        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id IN (" . $this->db->escape($data['filter_order_status_id']) . ") ";
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        $query = $this->db->query($sql);
        return $query->num_rows;
    }

    public function getTransactions($data)
    {
        $sql = "SELECT st.transaction_id,st.name,st.calculationtext,st.customer_email,st.commission,st.product,st.amount,st.order_id,o.firstname,o.lastname,o.total,o.date_added,st.sub_total,o.currency_code,o.currency_value,st.paidout,o.order_status_id, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status FROM `" . DB_PREFIX . "salesagent_transaction` st LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id = st.order_id) LEFT JOIN `" . DB_PREFIX . "salesagent` s ON (s.salesagent_id = st.salesagent_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE st.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE st.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND st.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_transactionids'])) {
            $sql .= " AND st.transaction_id  IN  (" . $this->db->escape($data['filter_transactionids']) . ") ";
        }
        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id IN (" . $this->db->escape($data['filter_order_status_id']) . ") ";
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        if (isset($data['filter_paidout'])) {
            $sql .= " AND st.paidout = '" . (int)$data['filter_paidout'] . "' ";
        }
        $sql .= " ORDER BY o.date_added DESC";
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

    public function getTotalTransactions($data)
    {
        $sql = "SELECT COUNT(*) as totalnumber FROM `" . DB_PREFIX . "salesagent_transaction` st LEFT JOIN `" . DB_PREFIX . "order` o  ON (o.order_id = st.order_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE st.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE st.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND st.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id IN (" . $this->db->escape($data['filter_order_status_id']) . ") ";
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }
        if (!empty($data['filter_transactionids'])) {
            $sql .= " AND st.transaction_id  IN  (" . $this->db->escape($data['filter_transactionids']) . ") ";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        if (isset($data['filter_paidout'])) {
            $sql .= " AND st.paidout = '" . (int)$data['filter_paidout'] . "' ";
        }
        $query = $this->db->query($sql);
        return $query->row['totalnumber'];
    }

    public function getCustomers($data)
    {
        $sql = "SELECT CONCAT(s.firstname, ' ', s.lastname) AS name,c.customer_id,c.telephone,c.firstname,c.lastname,c.email,c.date_added FROM `" . DB_PREFIX . "customer` c LEFT JOIN `" . DB_PREFIX . "salesagent_customer` sc ON (c.customer_id = sc.customerid) LEFT JOIN `" . DB_PREFIX . "salesagent` s ON (s.salesagent_id = sc.salesagent_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE sc.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE sc.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND sc.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        $sql .= " AND c.status = 1 ";
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(c.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(c.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        $sql .= " ORDER BY c.date_added DESC";
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

    public function getTotalCustomers($data)
    {
        $sql = "SELECT COUNT(c.customer_id) as totalnumber FROM `" . DB_PREFIX . "customer` c LEFT JOIN `" . DB_PREFIX . "salesagent_customer` sc ON (c.customer_id = sc.customerid)  LEFT JOIN `" . DB_PREFIX . "salesagent` s ON (s.salesagent_id = sc.salesagent_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE sc.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE sc.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND sc.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        $sql .= " AND c.status = 1 ";
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(c.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(c.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        $query = $this->db->query($sql);
        return $query->row['totalnumber'];
    }

    public function getExactTotal($data)
    {
        $returndata = array("commissiontotal" => "", "ordertotal" => "");
        $returndata2 = array();
        $sql = "SELECT SUM(st.amount) as commissiontotal FROM `" . DB_PREFIX . "salesagent_transaction` st LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id = st.order_id) LEFT JOIN `" . DB_PREFIX . "salesagent` s ON (s.salesagent_id = st.salesagent_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE st.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE st.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND st.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_transactionids'])) {
            $sql .= " AND st.transaction_id  IN  (" . $this->db->escape($data['filter_transactionids']) . ") ";
        }
        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id IN (" . $this->db->escape($data['filter_order_status_id']) . ") ";
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "')";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "')";
        }
        if (isset($data['filter_paidout'])) {
            $sql .= " AND st.paidout = '" . (int)$data['filter_paidout'] . "' ";
        }
        $query = $this->db->query($sql);
        $returndata['commissiontotal'] = $this->currency->format($query->row['commissiontotal'], $this->config->get('config_currency'));
        $sql = "SELECT DISTINCT o.order_id,o.total FROM `" . DB_PREFIX . "salesagent_transaction` st LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id = st.order_id) LEFT JOIN `" . DB_PREFIX . "salesagent` s ON (s.salesagent_id = st.salesagent_id) ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE st.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE st.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND st.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_transactionids'])) {
            $sql .= " AND st.transaction_id  IN  (" . $this->db->escape($data['filter_transactionids']) . ") ";
        }
        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND o.order_status_id IN (" . $this->db->escape($data['filter_order_status_id']) . ") ";
        } else {
            $sql .= " AND o.order_status_id > '0'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= DATE('" . $this->db->escape($data['filter_date_start']) . "') ";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= DATE('" . $this->db->escape($data['filter_date_end']) . "') ";
        }
        if (isset($data['filter_paidout'])) {
            $sql .= " AND st.paidout = '" . (int)$data['filter_paidout'] . "' ";
        }
        $query2 = $this->db->query($sql);
        $total = 0;
        foreach ($query2->rows as $key2 => $value2) {
            $total += $value2['total'];
        }
        $returndata['ordertotal'] = $this->currency->format($total, $this->config->get('config_currency'));
        return $returndata;
    }

    public function getTransactionTotal($salesagent_id)
    {
        $query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "salesagent_transaction WHERE salesagent_id = '" . (int)$salesagent_id . "'");
        return $query->row['total'];
    }

    public function getTotalTransactionsByOrderId($order_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesagent_transaction WHERE order_id = '" . (int)$order_id . "'");
        return $query->row['total'];
    }

    public function getProductCount($order_id)
    {
        $query = $this->db->query("SELECT SUM(quantity) as total FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
        return $query->row['total'];
    }

    public function addPayout($data, $reportdata)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_payouts SET  transaction_id = '" . $this->db->escape($data['transaction_id']) . "', totalorders = '" . (int)$data['totalorders'] . "',amountsettled = '" . $this->db->escape($data['amountpaid']) . "', paymentdetails = '" . $this->db->escape($data['paymentdetails']) . "', image_1 = '" . $this->db->escape($data['image_1']) . "', image_2 = '" . $this->db->escape($data['image_2']) . "', notes = '" . $this->db->escape($data['notes']) . "', settleddate = NOW(), salesagent_id = '" . (int)$data['filter_salesagent'] . "',name = '" . $this->db->escape($data['name']) . "' ");
        $salesagent_payout_id = $this->db->getLastId();
        foreach ($reportdata as $key => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "salesagent_payouts_transaction SET  transaction_id = '" . $this->db->escape($data['transaction_id']) . "',original_transaction_id = '" . $this->db->escape($value['transaction_id']) . "', order_id = '" . (int)$value['order_id'] . "',orderamount = '" . $this->db->escape($value['total']) . "', commissionamount = '" . $this->db->escape($value['amount']) . "', settleddate = NOW(),salesagent_id = '" . (int)$data['filter_salesagent'] . "',salesagent_payout_id = '" . (int)$salesagent_payout_id . "',name = '" . $this->db->escape($data['name']) . "'");
            $this->db->query("UPDATE " . DB_PREFIX . "salesagent_transaction SET paidout = 1 WHERE transaction_id = '" . $value['transaction_id'] . "'");
        }
        $data['text_greetings'] = sprintf($this->language->get('text_greetings'), html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8'));
        $data['text_payout'] = sprintf($this->language->get('text_payout'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_totalorders'] = $this->language->get('text_totalorders');
        $data['text_totalpayment'] = $this->language->get('text_totalpayment');
        $data['text_transactionid'] = $this->language->get('text_paymentdetails');
        $data['text_paymentdetails'] = $this->language->get('text_paymentdetails');
        $mail = new Mail($this->config->get('config_mail_engine'));
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setTo($data['email']);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(sprintf($this->language->get('text_payoutsubject'), html_entity_decode($data['transaction_id'], ENT_QUOTES, 'UTF-8')));
        $mail->setText($this->load->view('extension/report/salesagent_payoutmail', $data));
        if ($data['image_1']) {
            $mail->addAttachment(DIR_IMAGE . $data['image_1']);
        }
        if ($data['image_2']) {
            $mail->addAttachment(DIR_IMAGE . $data['image_2']);
        }
        $mail->send();
        $mail->setTo($this->config->get('config_email'));
        $mail->send();
        $this->log->write($mail);
    }

    public function getPayouts($data)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "salesagent_payouts` sp ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE sp.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE sp.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND sp.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_transactionid'])) {
            $sql .= " AND sp.transaction_id = '" . (int)$data['filter_transactionid'] . "'";
        }
        if (!empty($data['filter_amount'])) {
            $sql .= " AND sp.amountsettled = '" . (int)$data['filter_amount'] . "'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(sp.settleddate) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(sp.settleddate) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        $sql .= " ORDER BY sp.settleddate DESC";
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

    public function getTotalPayouts($data)
    {
        $sql = "SELECT COUNT(*) as totalnumber FROM `" . DB_PREFIX . "salesagent_payouts` sp ";
        if (!empty($data['filter_salesagent'])) {
            $sql .= " WHERE sp.salesagent_id = '" . (int)$data['filter_salesagent'] . "'";
        } else {
            $sql .= " WHERE sp.salesagent_id > '0'";
        }
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND sp.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['filter_transactionid'])) {
            $sql .= " AND sp.transaction_id = '" . (int)$data['filter_transactionid'] . "'";
        }
        if (!empty($data['filter_amount'])) {
            $sql .= " AND sp.amountsettled = '" . (int)$data['filter_amount'] . "'";
        }
        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(sp.settleddate) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }
        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(sp.settleddate) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }
        $query = $this->db->query($sql);
        return $query->row['totalnumber'];
    }

    public function getPayoutTransactions($data)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "salesagent_payouts_transaction` spt WHERE 1 = 1 ";
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND spt.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['salesagent_payout_id'])) {
            $sql .= " AND spt.salesagent_payout_id = '" . (int)$data['salesagent_payout_id'] . "'";
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

    public function getTotalPayoutTransactions($data)
    {
        $sql = "SELECT COUNT(*) as totalnumber FROM `" . DB_PREFIX . "salesagent_payouts_transaction` spt WHERE 1 = 1 ";
        $salesagent_id = $this->user->getSalesAgentId();
        if ($salesagent_id) {
            $sql .= " AND spt.salesagent_id  IN  (" . $salesagent_id . ") ";
        }
        if (!empty($data['salesagent_payout_id'])) {
            $sql .= " AND spt.salesagent_payout_id = '" . (int)$data['salesagent_payout_id'] . "'";
        }
        $query = $this->db->query($sql);
        return $query->row['totalnumber'];
    }

    public function deletePayouts($salesagent_payout_id)
    {
        $query = $this->db->query("SELECT original_transaction_id FROM `" . DB_PREFIX . "salesagent_payouts_transaction` WHERE salesagent_payout_id = '" . (int)$salesagent_payout_id . "' ");
        if ($query->num_rows && $salesagent_payout_id) {
            $bit = 0;
            foreach ($query->rows as $key => $value) {
                if ($value['original_transaction_id']) {
                    $this->db->query("UPDATE " . DB_PREFIX . "salesagent_transaction SET paidout = 0 WHERE transaction_id = '" . (int)$value['original_transaction_id'] . "'");
                    $bit = 1;
                }
            }
            if ($bit) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "salesagent_payouts_transaction WHERE salesagent_payout_id = '" . (int)$salesagent_payout_id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "salesagent_payouts WHERE salesagent_payouts_id = '" . (int)$salesagent_payout_id . "'");
            }
        }
    }

    public function addCustomerRewardPoints($salesagent_id, $amount) {
        // Отримуємо customer_id по агенту
        $query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "salesagent WHERE salesagent_id = '" . (int)$salesagent_id . "'");

        if ($query->num_rows && (int)$query->row['customer_id']) {
            $customer_id = (int)$query->row['customer_id'];

            $this->load->model('customer/customer');

            $description = 'Партнерська комісія'; // Можеш винести в language

            $this->model_customer_customer->addReward($customer_id, $description, (float)$amount);

            return true;
        }

        return false;
    }

}