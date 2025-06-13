<?php
class ControllerExtensionModuleBrandList extends Controller {
    private $error = [];

    public function index() {
        $this->load->language('extension/module/brand_list');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
        $this->load->model('localisation/language');

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {

            if (isset($this->request->post['module_brand_list_items']) && is_array($this->request->post['module_brand_list_items'])) {
                uasort($this->request->post['module_brand_list_items'], function ($a, $b) {
                    return ($a['sort'] ?? 0) <=> ($b['sort'] ?? 0);
                });
            }

            $this->model_setting_setting->editSetting('module_brand_list', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['user_token'] = $this->session->data['user_token'];
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_add_item'] = $this->language->get('text_add_item');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_link'] = $this->language->get('entry_link');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['action'] = $this->url->link('extension/module/brand_list', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

        if (isset($this->request->post['module_brand_list_status'])) {
            $data['module_brand_list_status'] = $this->request->post['module_brand_list_status'];
        } else {
            $data['module_brand_list_status'] = $this->config->get('module_brand_list_status');
        }

        if (isset($this->request->post['module_brand_list_items'])) {
            $data['module_brand_list_items'] = $this->request->post['module_brand_list_items'];
        } else {
            $data['module_brand_list_items'] = $this->config->get('module_brand_list_items') ?: [];
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/brand_list', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/brand_list')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
