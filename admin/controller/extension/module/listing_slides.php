<?php
class ControllerExtensionModuleListingSlides extends Controller {
    private $error = [];

    public function index() {
        $this->load->language('extension/module/listing_slides');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/module');
        $this->load->model('localisation/language');

        $data['user_token'] = $this->session->data['user_token'];

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            if (isset($this->request->post['blocks']) && is_array($this->request->post['blocks'])) {
                usort($this->request->post['blocks'], function($a, $b) {
                    return (int)($a['sort'] ?? 0) <=> (int)($b['sort'] ?? 0);
                });
            }

            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('listing_slides', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['apply'])) {
                $module_id = $this->request->get['module_id'] ?? $this->model_setting_module->getLastId(); // або отримати останній ID вручну
                $this->response->redirect($this->url->link('extension/module/listing_slides',
                    'user_token=' . $this->session->data['user_token'] . '&module_id=' . $module_id, true));
            } else {
                $this->response->redirect($this->url->link('marketplace/extension',
                    'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
        }

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        $data['languages'] = $this->model_localisation_language->getLanguages();
        $data['blocks'] = $this->request->post['blocks'] ?? ($module_info['blocks'] ?? []);


        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['entry_name'] = $this->language->get('entry_name');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $data['breadcrumbs'] = [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            ],
            [
                'text' => $this->language->get('text_extension'),
                'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/listing_slides', 'user_token=' . $this->session->data['user_token'], true)
            ]
        ];

        $data['action'] = isset($this->request->get['module_id']) ?
            $this->url->link('extension/module/listing_slides',
                'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true) :
            $this->url->link('extension/module/listing_slides',
                'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension',
            'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['name'] = $this->request->post['name'] ?? ($module_info['name'] ?? '');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['rendered_blocks'] = [];

        if (!empty($data['blocks'])) {
            foreach ($data['blocks'] as $i => $block) {
                $data['rendered_blocks'][] = $this->renderBlock($i, $block);
            }
        }

        $this->response->setOutput($this->load->view('extension/module/listing_slides', $data));
    }

    protected function validate() {
        if ((utf8_strlen($this->request->post['name']) < 3) ||
            (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function blockForm() {
        $this->load->language('extension/module/listing_slides');
        $this->load->model('localisation/language');

        $data['index'] = $this->request->get['index'];
        $data['languages'] = $this->model_localisation_language->getLanguages();
        $this->response->setOutput($this->load->view('extension/module/listing_slides_block', $data));
    }

    protected function renderBlock($index, $block = []) {
        $this->load->model('localisation/language');

        $data['index'] = $index;
        $data['block'] = $block;
        $data['languages'] = $this->model_localisation_language->getLanguages();

        return $this->load->view('extension/module/listing_slides_block', $data);
    }


}
