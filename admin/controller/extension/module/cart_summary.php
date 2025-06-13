<?php
class ControllerExtensionModuleCartSummary extends Controller {
    public function index() {
        $this->load->language('extension/module/cart_summary');

        $this->document->setTitle('Нагадування про товари в кошику');

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            ],
            [
                'text' => $this->language->get('Нагадування про товари в кошику'),
                'href' => $this->url->link('extension/module/cart_summary', 'user_token=' . $this->session->data['user_token'], true)
            ]
        ];

        $data['action'] = $this->url->link('extension/module/cart_summary', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['user_token'] = $this->session->data['user_token'];

        $this->response->setOutput($this->load->view('extension/module/cart_summary', $data));
    }

    public function install() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('module_cart_summary', ['module_cart_summary_status' => 1]);
    }

    public function uninstall() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('module_cart_summary');
    }
}