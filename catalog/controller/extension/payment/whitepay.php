<?php

class ControllerExtensionPaymentWhitepay extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->model('checkout/order');
        $this->load->model('extension/payment/whitepay');

        $this->language->load('extension/payment/whitepay');
    }

    public function index()
    {
        $order_id   = $this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($order_id);

        $data = $this->prepareCheckoutData($order_info);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/payment/whitepay')) {
            return $this->load->view($this->config->get('config_template') . '/template/extension/payment/whitepay', $data);
        } else {
            return $this->load->view('/extension/payment/whitepay', $data);
        }
    }

    public function prepareCheckoutData($order_info)
    {
        $allowed_currencies = array();
        foreach ($this->model_extension_payment_whitepay->getOrderCreationCurrencies() as $c) {
            $allowed_currencies[$c['ticker']] = array(
                'min_amount' => $c['min_amount'],
                'max_amount' => $c['max_amount']
            );
        }

        $currency   = $this->session->data['currency'];
        $amount     = number_format($order_info['total'], 2, '.', '');

        if (!$this->model_extension_payment_whitepay->checkAuth()) {
            $data['checkout_error'] = $this->language->get('error_api');
        } elseif (!array_key_exists($currency, $allowed_currencies)) {
            $data['checkout_error'] = $this->language->get('error_currency_type');
        } elseif ($amount < $allowed_currencies[$currency]['min_amount']) {
            $data['checkout_error'] = $this->language->get('error_currency_min_amount') . $allowed_currencies[$currency]['min_amount'] . ' ' . $currency;
        } elseif ($amount > $allowed_currencies[$currency]['max_amount']) {
            $data['checkout_error'] = $this->language->get('error_currency_max_amount') . $allowed_currencies[$currency]['max_amount'] . ' ' . $currency;
        } else {
            $data['button_confirm'] = $this->language->get('button_confirm');
        }

        return $data;
    }

    public function confirm()
    {
        if ($this->session->data['payment_method']['code'] == 'whitepay') {
            $order_id = $this->session->data['order_id'];
            $order_info = $this->model_checkout_order->getOrder($order_id);
            if (!$order_info) return;

            if (empty($order_info['order_id'])) {
                $order_info['order_id'] = $order_id;
            }
            $currency = $this->session->data['currency'];
            $amount = number_format($order_info['total'], 2, '.', '');

            $params = array(
                'amount' => (float)$amount,
                'currency' => $currency,
                'external_order_id' => (string)$order_info['order_id'],
            );

            $result = $this->model_extension_payment_whitepay->createOrder($params);
            $whitepay_order = $result['order'];

            $json['redirect'] = $whitepay_order['acquiring_url'];

            $comment = 'Whitepay';
            if (!empty($whitepay_order['acquiring_url'])) {
                $comment .= ' URL: ' . $whitepay_order['acquiring_url'];

                $this->clear_order_data();
            }

            if ($order_info['order_status_id'] == 0 || $order_info['order_status_id'] != $this->config->get('payment_whitepay_processed_order_status_id')) {
                $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('payment_whitepay_processed_order_status_id'), $comment, true);
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function response()
    {
        if (isset($this->request->get['fail']) && $this->request->get['fail']) {
            $this->response->redirect($this->url->link('checkout/failure', '', true));
        } else {
            //$this->cart->clear();
            $this->clear_order_data();
            $this->response->redirect($this->url->link('checkout/success', '', true));
        }
    }

    public function callback()
    {
        $payload = file_get_contents('php://input');

        $this->model_extension_payment_whitepay->logger('Payload: ' . $payload);

        if (!empty($payload) && $this->webhookSignatureValidate($payload)) {
            $data = json_decode($payload, true);
            $whitepay_order = $data['order'];

            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($whitepay_order['external_order_id']);

            if (!($order_info) || empty($order_info)) {
                exit;
            }

            $this->updateOrderStatus($order_info, $whitepay_order);
            $this->clear_order_data();
        }

        $this->response->addHeader('HTTP/1.1 200 OK');
        $this->response->addHeader('Content-Type: application/json');
    }

    /**
     * Whitepay webhook signature validation
     * @param string $payload
     */
    public function webhookSignatureValidate($payload) {
        if (!isset($_SERVER['HTTP_SIGNATURE'])) {
            return false;
        }

        $whitepay_signature = $_SERVER['HTTP_SIGNATURE'];
        $webhook_token      = $this->config->get('payment_whitepay_webhook');
        //$payload_json       = json_encode(json_decode($payload), JSON_UNESCAPED_SLASHES);
        $payload_json       = $payload;
        $signature          = hash_hmac('sha256', $payload_json, $webhook_token);

        return ($signature === $whitepay_signature) ? true : false;
    }

    /**
     * Update order status
     * @param $order
     * @param $whitepay_order
     */
    public function updateOrderStatus($order, $whitepay_order) {
        switch ($whitepay_order['status']) {
            case "COMPLETE":
                $new_status_id = $this->config->get('payment_whitepay_complete_order_status_id');
                break;
            case "PATIALLY_FULFILLED":
                $new_status_id = $this->config->get('payment_whitepay_partially_fulfilled_order_status_id');
                break;
            case "DECLINED":
                $new_status_id = $this->config->get('payment_whitepay_declined_order_status_id');
                break;
            case "CANCELED":
                $new_status_id = $this->config->get('payment_whitepay_declined_order_status_id');
                break;
        }

        if($order['order_status_id'] != $new_status_id){
            $comment = 'Whitepay Order URL: ' . $whitepay_order['acquiring_url'];
            if(!empty($whitepay_order['completed_at'])){
                $comment .= '<br/>Completed at: ' . $whitepay_order['completed_at'];
            }

            $this->model_checkout_order->addOrderHistory($order['order_id'], $new_status_id, $comment, $notify = true, $override = false);
        }
    }

    /**
     * Clear order data
     */
    public function clear_order_data() {
        if (isset($this->session->data['order_id'])) {
            $this->cart->clear();

            unset($this->session->data['order_id']);
            unset($this->session->data['payment_address']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['shipping_address']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['comment']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
        }
    }
}
