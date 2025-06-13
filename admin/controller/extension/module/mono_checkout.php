<?php

class ControllerExtensionModuleMonoCheckout extends Controller
{

    private $error = array();

    private $name = 'module_mono_checkout';
    private $token = 'user_token';
    private $ext_path = 'marketplace/extension';
    private $url_path = 'extension/module/mono_checkout';

    public function index()
    {
        if($this->version23() || $this->version20()) {
            $this->token = 'token';
        }

        $this->ext_path = $this->version20() ? 'extension/module' : ($this->version23() ? 'extension/extension' : 'marketplace/extension');
        $this->url_path = $this->version20() ? 'module/mono_checkout' : $this->url_path;

        $this->load->model('setting/setting');
        $this->load->language($this->url_path);

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->request->post[$this->name . '_payments_number'] = max(3, min(25, $this->request->post[$this->name . '_payments_number']));
            $this->model_setting_setting->editSetting($this->name, $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link($this->ext_path, $this->token . '=' . $this->session->data[$this->token] . '&type=module', true));
        }

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api'])) {
            $data['error_api'] = $this->error['api'];
        } else {
            $data['error_api'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', $this->token . '=' . $this->session->data[$this->token] . '&type=module', true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link($this->url_path, $this->token . '=' . $this->session->data[$this->token] . '&type=module', true),
        );

        $data['action'] = $this->url->link($this->url_path, $this->token . '=' . $this->session->data[$this->token], true);
        $data['cancel'] = $this->url->link($this->ext_path, $this->token . '=' . $this->session->data[$this->token] . '&type=module', true);

        if (isset($this->request->post[$this->name . '_status'])) {
            $data[$this->name . '_status'] = $this->request->post[$this->name . '_status'];
        } else {
            $data[$this->name . '_status'] = $this->config->get($this->name . '_status');
        }

        if (isset($this->request->post[$this->name . '_token'])) {
            $data[$this->name . '_token'] = $this->request->post[$this->name . '_token'];
        } else {
            $data[$this->name . '_token'] = $this->config->get($this->name . '_token');
        }

        if (isset($this->request->post[$this->name . '_payment'])) {
            $data['payments'] = $this->request->post[$this->name . '_payment'];
        } else {
            $data['payments'] = $this->config->get($this->name . '_payment') ?: [];
        }

        if (isset($this->request->post[$this->name . '_delivery'])) {
            $data['deliveries'] = $this->request->post[$this->name . '_delivery'];
        } else {
            $data['deliveries'] = $this->config->get($this->name . '_delivery') ?: [];
        }

        if (isset($this->request->post[$this->name . '_merchant_user'])) {
            $data[$this->name . '_merchant_user'] = $this->request->post[$this->name . '_merchant_user'];
        } else {
            $data[$this->name . '_merchant_user'] = $this->config->get($this->name . '_merchant_user');
        }

        if (isset($this->request->post[$this->name . '_cart_show'])) {
            $data[$this->name . '_cart_show'] = $this->request->post[$this->name . '_cart_show'];
        } else {
            $data[$this->name . '_cart_show'] = $this->config->get($this->name . '_cart_show');
        }

        if (isset($this->request->post[$this->name . '_payments_number'])) {
            $data[$this->name . '_payments_number'] = $this->request->post[$this->name . '_payments_number'];
        } elseif($this->config->get($this->name . '_payments_number')) {
            $data[$this->name . '_payments_number'] = $this->config->get($this->name . '_payments_number');
        } else {
            $data[$this->name . '_payments_number'] = 3;
        }

        if (isset($this->request->post[$this->name . '_cart_elem'])) {
            $data[$this->name . '_cart_elem'] = $this->request->post[$this->name . '_cart_elem'];
        } else {
            $data[$this->name . '_cart_elem'] = $this->config->get($this->name . '_cart_elem') ? $this->config->get($this->name . '_cart_elem') : '.buttons .pull-right .btn-primary';
        }

        if (isset($this->request->post[$this->name . '_cart_popup_elem'])) {
            $data[$this->name . '_cart_popup_elem'] = $this->request->post[$this->name . '_cart_popup_elem'];
        } else {
            $data[$this->name . '_cart_popup_elem'] = $this->config->get($this->name . '_cart_popup_elem') ? $this->config->get($this->name . '_cart_popup_elem') : '#cart p.text-right a:last-child';
        }

        if (isset($this->request->post[$this->name . '_product_elem'])) {
            $data[$this->name . '_product_elem'] = $this->request->post[$this->name . '_product_elem'];
        } else {
            $data[$this->name . '_product_elem'] = $this->config->get($this->name . '_product_elem') ? $this->config->get($this->name . '_product_elem') : '#button-cart';
        }

        if (isset($this->request->post[$this->name . '_cart_show_size_w'])) {
            $data[$this->name . '_cart_show_size_w'] = $this->request->post[$this->name . '_cart_show_size_w'];
        } else {
            $data[$this->name . '_cart_show_size_w'] = $this->config->get($this->name . '_cart_show_size_w');
        }

        if (isset($this->request->post[$this->name . '_cart_show_size_h'])) {
            $data[$this->name . '_cart_show_size_h'] = $this->request->post[$this->name . '_cart_show_size_h'];
        } else {
            $data[$this->name . '_cart_show_size_h'] = $this->config->get($this->name . '_cart_show_size_h');
        }

        if (isset($this->request->post[$this->name . '_cart_popup_show_size_w'])) {
            $data[$this->name . '_cart_popup_show_size_w'] = $this->request->post[$this->name . '_cart_popup_show_size_w'];
        } else {
            $data[$this->name . '_cart_popup_show_size_w'] = $this->config->get($this->name . '_cart_popup_show_size_w');
        }

        if (isset($this->request->post[$this->name . '_cart_popup_show_size_h'])) {
            $data[$this->name . '_cart_popup_show_size_h'] = $this->request->post[$this->name . '_cart_popup_show_size_h'];
        } else {
            $data[$this->name . '_cart_popup_show_size_h'] = $this->config->get($this->name . '_cart_popup_show_size_h');
        }

        if (isset($this->request->post[$this->name . '_product_show'])) {
            $data[$this->name . '_product_show'] = $this->request->post[$this->name . '_product_show'];
        } else {
            $data[$this->name . '_product_show'] = $this->config->get($this->name . '_product_show');
        }

        if (isset($this->request->post[$this->name . '_product_show_size_w'])) {
            $data[$this->name . '_product_show_size_w'] = $this->request->post[$this->name . '_product_show_size_w'];
        } else {
            $data[$this->name . '_product_show_size_w'] = $this->config->get($this->name . '_product_show_size_w');
        }

        if (isset($this->request->post[$this->name . '_product_show_size_h'])) {
            $data[$this->name . '_product_show_size_h'] = $this->request->post[$this->name . '_product_show_size_h'];
        } else {
            $data[$this->name . '_product_show_size_h'] = $this->config->get($this->name . '_product_show_size_h');
        }

        if (isset($this->request->post[$this->name . '_button'])) {
            $data[$this->name . '_button'] = $this->request->post[$this->name . '_button'];
        } else {
            $data[$this->name . '_button'] = $this->config->get($this->name . '_button');
        }

        if (isset($this->request->post[$this->name . '_status_success'])) {
            $data[$this->name . '_status_success'] = $this->request->post[$this->name . '_status_success'];
        } else {
            $data[$this->name . '_status_success'] = $this->config->get($this->name . '_status_success');
        }

        if (isset($this->request->post[$this->name . '_status_payment_on_delivery'])) {
            $data[$this->name . '_status_payment_on_delivery'] = $this->request->post[$this->name . '_status_payment_on_delivery'];
        } else {
            $data[$this->name . '_status_payment_on_delivery'] = $this->config->get($this->name . '_status_payment_on_delivery');
        }

        if (isset($this->request->post[$this->name . '_status_not_confirmed'])) {
            $data[$this->name . '_status_not_confirmed'] = $this->request->post[$this->name . '_status_not_confirmed'];
        } else {
            $data[$this->name . '_status_not_confirmed'] = $this->config->get($this->name . '_status_not_confirmed');
        }

        if (isset($this->request->post[$this->name . '_status_not_authorized'])) {
            $data[$this->name . '_status_not_authorized'] = $this->request->post[$this->name . '_status_not_authorized'];
        } else {
            $data[$this->name . '_status_not_authorized'] = $this->config->get($this->name . '_status_not_authorized');
        }

        if (isset($this->request->post[$this->name . '_status_fail'])) {
            $data[$this->name . '_status_fail'] = $this->request->post[$this->name . '_status_fail'];
        } else {
            $data[$this->name . '_status_fail'] = $this->config->get($this->name . '_status_fail');
        }

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = [];
        $results = $this->model_localisation_order_status->getOrderStatuses();

        foreach ($results as $result) {
            $data['order_statuses'][] = array(
                'order_status_id' => $result['order_status_id'],
                'name'            => $result['name'],
                'default'         => $result['order_status_id'] === $this->config->get('config_order_status_id')
            );
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        if ($this->version23()) {
            $data['heading_title'] = $this->language->get('heading_title');
            $data['text_edit'] = $this->language->get('text_edit');
            $data['text_apikey'] = $this->language->get('text_apikey');
            $data['text_enabled'] = $this->language->get('text_enabled');
            $data['text_disabled'] = $this->language->get('text_disabled');
            $data['entry_status'] = $this->language->get('entry_status');
            $data['entry_api'] = $this->language->get('entry_api');
            $data['entry_delivery'] = $this->language->get('entry_delivery');
            $data['entry_faq'] = $this->language->get('entry_faq');
            $data['entry_merchant'] = $this->language->get('entry_merchant');
            $data['entry_payment'] = $this->language->get('entry_payment');
            $data['entry_cart_show'] = $this->language->get('entry_cart_show');
            $data['entry_cart_popup_elem'] = $this->language->get('entry_cart_popup_elem');
            $data['entry_cart_elem'] = $this->language->get('entry_cart_elem');
            $data['entry_payments_number'] = $this->language->get('entry_payments_number');
            $data['entry_product_elem'] = $this->language->get('entry_product_elem');
            $data['entry_cart_show_size_w'] = $this->language->get('entry_cart_show_size_w');
            $data['entry_cart_show_size_h'] = $this->language->get('entry_cart_show_size_h');
            $data['entry_cart_popup_show_size_w'] = $this->language->get('entry_cart_popup_show_size_w');
            $data['entry_cart_popup_show_size_h'] = $this->language->get('entry_cart_popup_show_size_h');
            $data['entry_product_show'] = $this->language->get('entry_product_show');
            $data['entry_product_show_size_w'] = $this->language->get('entry_product_show_size_w');
            $data['entry_product_show_size_h'] = $this->language->get('entry_product_show_size_h');
            $data['entry_button'] = $this->language->get('entry_button');
            $data['help_payment'] = $this->language->get('help_payment');
            $data['help_delivery'] = $this->language->get('help_delivery');
            $data['help_merchant'] = $this->language->get('help_merchant');
            $data['help_cart_show'] = $this->language->get('help_cart_show');
            $data['help_product_show'] = $this->language->get('help_product_show');
            $data['help_elem'] = $this->language->get('help_elem');
            $data['help_payments_number'] = $this->language->get('help_payments_number');
            $data['delivery_pickup'] = $this->language->get('delivery_pickup');
            $data['delivery_courier'] = $this->language->get('delivery_courier');
            $data['delivery_np_brnm'] = $this->language->get('delivery_np_brnm');
            $data['delivery_np_box'] = $this->language->get('delivery_np_box');
            $data['payment_card'] = $this->language->get('payment_card');
            $data['payment_on_delivery'] = $this->language->get('payment_on_delivery');
            $data['payment_part_purchase'] = $this->language->get('payment_part_purchase');
            $data['text_faq'] = $this->language->get('text_faq');
            $data['text_popup_faq'] = $this->language->get('text_popup_faq');
            $data['button_save'] = $this->language->get('button_save');
            $data['button_cancel'] = $this->language->get('button_cancel');
            $data['text_select'] = $this->language->get('text_select');
            $data['entry_statuses'] = $this->language->get('entry_statuses');
            $data['text_status_success'] = $this->language->get('text_status_success');
            $data['text_status_payment_on_delivery'] = $this->language->get('text_status_payment_on_delivery');
            $data['text_status_not_confirmed'] = $this->language->get('text_status_not_confirmed');
            $data['text_status_not_authorized'] = $this->language->get('text_status_not_authorized');
            $data['text_status_fail'] = $this->language->get('text_status_fail');
        }


        if($this->version20()) {
            $this->response->setOutput($this->load->view($this->url_path.'.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view($this->url_path, $data));
        }
    }

    public function install()
    {
        $this->load->model($this->url_path);
        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $this->model_extension_module_mono_checkout->install($languages);
    }

    public function uninstall()
    {
        $this->load->model($this->url_path);
        $this->model_extension_module_mono_checkout->uninstall();
    }

    protected function version23() {
        return version_compare(VERSION, '3.0', '<');
    }
    protected function version20() {
        return version_compare(VERSION, '2.3', '<');
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', $this->url_path)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!strlen($this->request->post[$this->name . '_token'])) {
            $this->error['api'] = $this->language->get('error_api');
        }

        return !$this->error;
    }
}
