<?php

class ControllerExtensionPaymentWhitepay extends Controller
{
    /**
     * Errors array
     * @var array
     */
    private $error = array();

    /**
     * Init Whitepay extension
     */
    public function index()
    {
        $this->load->model('setting/setting');
        $this->load->model('extension/payment/whitepay');
        $this->load->language('extension/payment/whitepay');
        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_whitepay', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token']. '&type=payment', true));
            //$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

        /* Get language variables */
        $lang_fields = array(
            "heading_title", "text_payment", "text_success", "text_pay",
            "entry_slug", "entry_token", "entry_webhook", "entry_return_url", "entry_callback_url",
            "entry_processed_order_status", "entry_complete_order_status", "entry_partially_fulfilled_order_status",
            "entry_declined_order_status", "entry_debug", "entry_sort_order", "entry_status",
            "help_slug", "help_token", "help_webhook", 'help_return_url', 'help_callback_url', 'help_debug',
            "error_permission", "error_slug", "error_token"
        );

        foreach ($lang_fields as $field) {
            $data[$field] = $this->language->get($field);
        }

        $data['button_save']    = $this->language->get('button_save');
        $data['button_cancel']  = $this->language->get('button_cancel');
        $data['text_enabled']   = $this->language->get('text_enabled');
        $data['text_disabled']  = $this->language->get('text_disabled');

        /* Errors */
        $err_array = array("warning", "permission", "slug", "token");
        foreach ($err_array as $e) {
            $data['error_' . $e] = (isset($this->error[$e])) ? $this->error[$e] : "";
        }

        /* Breadcrumbs */
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token']  . '&type=payment', true),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/whitepay', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/payment/whitepay', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        $this->load->model('localisation/order_status');

        $data['allowed_currensies'] = $this->model_extension_payment_whitepay->getOrderCreationCurrencies();
        $data['order_statuses']     = $this->model_localisation_order_status->getOrderStatuses();

        /* Request */
        $requestFields = array("payment_whitepay_slug", "payment_whitepay_token", "payment_whitepay_webhook", "payment_whitepay_return_url", "payment_whitepay_callback_url",
            "payment_whitepay_processed_order_status_id", "payment_whitepay_complete_order_status_id", "payment_whitepay_partially_fulfilled_order_status_id", "payment_whitepay_declined_order_status_id", "payment_whitepay_debug", "payment_whitepay_sort_order", "payment_whitepay_status");

        foreach ($requestFields as $f) {
            $data[$f] = (isset($this->request->post[$f])) ? $this->request->post[$f] : $this->config->get($f);
            if (defined('HTTP_CATALOG') && defined('HTTPS_CATALOG') && !isset($this->request->post[$f])) {
                if ($f == 'payment_whitepay_return_url' and empty($data[$f])) {
                    $data[$f] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=extension/payment/whitepay/response';
                } elseif ($f == 'payment_whitepay_callback_url' and empty($data[$f])) {
                    $data[$f] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) . 'index.php?route=extension/payment/whitepay/callback';
                }
            }
        }

        $data['header']         = $this->load->controller('common/header');
        $data['column_left']    = $this->load->controller('common/column_left');
        $data['footer']         = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/whitepay', $data));
    }

    /**
     * Validation
     * @return bool
     */
    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/whitepay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['payment_whitepay_slug']) {
            $this->error['slug'] = $this->language->get('error_slug');
        }

        if (!$this->request->post['payment_whitepay_token']) {
            $this->error['token'] = $this->language->get('error_token');
        }

        return (!$this->error) ? true : false;
    }
}
