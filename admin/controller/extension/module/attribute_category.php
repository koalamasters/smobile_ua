<?php
class ControllerExtensionModuleAttributeCategory extends Controller {
	private $error = array();
	private $path_module = 'extension/module/attribute_category';
	private $module_name ='attribute_category';
	private $my_model ='model_extension_module_attribute_category';

	public function index() {
		$this->load->language($this->path_module);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model($this->path_module);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->getList();
	}		

	public function getTemplate() {
		$json = array();
		$this->load->model($this->path_module);
		$attribute_categories = $this->registry->get($this->my_model)->getAttributeCategories(array());
		$data['attribute_categories'] = array();
		foreach ($attribute_categories as $attribute_category) {
			$data['attribute_categories'][] = array(
				'attr_cat_id' =>$attribute_category['attr_cat_id'],
				'name' => $attribute_category['name'],
			);
		}
		
		if ($data['attribute_categories']) {
			$json['options'] = $data['attribute_categories'];
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	public function getTemplateAttr() {
		$json = array();
		$this->load->model($this->path_module);
		$attribute_category_values = $this->registry->get($this->my_model)->getAttributeCategoryValue($this->request->get['template_id']);
		
		$data['attributes'] = array();
		foreach ($attribute_category_values as $value) {
			$attribute_info = $this->registry->get($this->my_model)->getAttribute($value['attribute_id'],$value['language_id']);
			if ($value['language_id'] == $this->config->get('config_language_id')) {
				$data['attributes'][$value['attribute_id']]['name'] = $attribute_info['name'];
			}
			$data['attributes'][$value['attribute_id']]['attribute_id'] = $value['attribute_id'];
			$data['attributes'][$value['attribute_id']]['language_id'][$value['language_id']] = array(
				'text' => $value['text'],
				'language_id' => $value['language_id']
			);
		}
		if ($data['attributes']) {
			$json = $data;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	public function add() {
		$this->load->language($this->path_module);
		$this->document->setTitle($this->language->get('heading_title_add'));

		$this->load->model($this->path_module);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->registry->get($this->my_model)->addAttributeCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->makeUrl($this->path_module, $url));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language($this->path_module);
		$this->document->setTitle($this->language->get('heading_title_edit'));
		$this->load->model($this->path_module);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

//            if($this->request->get['attr_cat_id'] == 4){
//                echo "<pre style='display: block' id='kl_look_mp'>";
//                print_r($this->request->post);
//                echo "</pre>";
//                die();
//            }
			$this->registry->get($this->my_model)->editAttributeCategory($this->request->get['attr_cat_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->makeUrl($this->path_module, $url));
		}

		$this->getForm();
	}


	public function delete() {
		$this->load->language($this->path_module);
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model($this->path_module);

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $attr_cat_id) {
				$this->registry->get($this->my_model)->deleteAttributeCategory($attr_cat_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->makeUrl($this->path_module, $url));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->makeUrl('common/dashboard')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->makeUrl($this->path_module, $url)
		);

		$data['add'] = $this->makeUrl($this->path_module . '/add', $url);
		$data['delete'] = $this->makeUrl($this->path_module . '/delete', $url);

		$data['attribute_category'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$attribute_category_total = $this->registry->get($this->my_model)->getTotalAttrubuteCategories($filter_data);
		$data['attribute_categories'] = array();
		$attribute_categories = $this->registry->get($this->my_model)->getAttributeCategories($filter_data);
		foreach ($attribute_categories as $attribute_category) {
			$data['attribute_categories'][] = array(
				'attr_cat_id' =>$attribute_category['attr_cat_id'],
				'name' => $attribute_category['name'],
				'edit' => $this->makeUrl($this->path_module . '/edit', 'attr_cat_id=' . $attribute_category['attr_cat_id'])
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		$pagination = new Pagination();
		$pagination->total = $attribute_category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->makeUrl($this->path_module, $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($attribute_category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($attribute_category_total - $this->config->get('config_limit_admin'))) ? $attribute_category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $attribute_category_total, ceil($attribute_category_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->path_module . '_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title_edit');

		$data['text_form'] = !isset($this->request->get['attr_cat_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_attributes'] = $this->language->get('entry_attributes');
		$data['entry_attribute'] = $this->language->get('entry_attribute');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->makeUrl('common/dashboard')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->makeUrl($this->path_module, $url)
		);

		if (!isset($this->request->get['attr_cat_id'])) {
			$data['action'] = $this->makeUrl($this->path_module . '/add', $url);
		} else {
			$data['action'] = $this->makeUrl($this->path_module . '/edit', 'attr_cat_id=' . $this->request->get['attr_cat_id'] . $url);
		}

		$data['cancel'] = $this->makeUrl($this->path_module, $url);

		if (isset($this->request->get['attr_cat_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$attribute_category_info = $this->registry->get($this->my_model)->getAttributeCategory($this->request->get['attr_cat_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
			$data['text_form'] = $data['text_form'] . ' ' . $data['name'];
		} elseif (!empty($attribute_category_info)) {
			$data['name'] = $attribute_category_info['name'];
			$data['text_form'] = $data['text_form'] . ' ' . $data['name'];
		} else {
			$data['name'] = '';
		}
		
		$attribute_category_values = array();
		if (isset($this->request->get['attr_cat_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			if (!empty($attribute_category_info)) {
				$attribute_category_values = $this->registry->get($this->my_model)->getAttributeCategoryValue($this->request->get['attr_cat_id']);
			}
		} else {
			if (isset($this->request->post['attribute_values'])) {
				$attribute_category_values = $this->request->post['attribute_values'];
			}
		}


		$data['attributes'] = array();
		foreach ($attribute_category_values as $value) {
			$attribute_info = $this->registry->get($this->my_model)->getAttribute($value['attribute_id'],$value['language_id']);
			if ($value['language_id'] == $this->config->get('config_language_id')) {
				$data['attributes'][$value['attribute_id']]['name'] = $attribute_info['name'];
			}
			$data['attributes'][$value['attribute_id']][$value['language_id']] = array(
				'attribute_id' => $value['attribute_id'],
				'language_id'  => $value['language_id'],
				'name'         => $attribute_info['name'],
				'group_name'   => $attribute_info['group_name'],
				'text'         => $value['text'],
				'base_attr'         => $value['base_attr']
			);
		}

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$data['languages'] = array();
		foreach ($languages as $language) {
			$data['languages'][$language['language_id']] = array (
				'language_id' => $language['language_id'],
				'code'        => $language['code'],
				'name'        => $language['name'],
				'image'       => 'language/' . $language['code'] . '/' . $language['code'] . '.png',
			
			);
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->path_module . '_form', $data));
	}

	public function uninstall() {
		$sql = "DROP TABLE IF EXISTS `" . DB_PREFIX . "attribute_category`";
		$this->db->query($sql);
		$sql = "DROP TABLE IF EXISTS `" . DB_PREFIX . "attribute_category_value`";
		$this->db->query($sql);
		$events = $this->getEvents();
		$this->load->model('setting/event');
		foreach ($events as $code=>$value) {
			$this->model_setting_event->deleteEventByCode($code);
		}				
	}


	private function getEvents() {
		$events = array(
			'ac_Menu' => array(
				'trigger' => 'admin/view/common/column_left/before',
				'action'  => $this->path_module . '/column_left_before',
			),
		);
		return $events;
	}

	public function install() {

		$sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "attribute_category` (
				`attr_cat_id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) COLLATE utf8_bin NOT NULL,
				`attribute_ids` text COLLATE utf8_bin NOT NULL,
				PRIMARY KEY (`attr_cat_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		$this->db->query($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "attribute_category_value` (
				`attribute_category_value_id` int(11) NOT NULL AUTO_INCREMENT,
				`attr_cat_id` int(11) NOT NULL,
				`attribute_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`text` varchar(256) NOT NULL,
				PRIMARY KEY (`attribute_category_value_id`),
				KEY `attr_cat_id` (`attr_cat_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		$this->db->query($sql);

		$events = $this->getEvents();
		$this->load->model('setting/event');
		foreach ($events as $code=>$value) {
			$this->model_setting_event->deleteEventByCode($code);
			$this->model_setting_event->addEvent($code, $value['trigger'], $value['action'], 1,9999);
		}
		
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', $this->path_module)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	private function validateDelete(){
		if (!$this->user->hasPermission('modify', $this->path_module)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	private function makeUrl($route, $arg=''){
		if ($arg) {
			$arg = '&' . ltrim($arg,'&');
		}
		return $this->url->link($route, 'user_token=' . $this->session->data['user_token'] . $arg, true);
	}

	public function column_left_before($route, &$data) {
		$this->load->language($this->path_module);
		$find_url = $this->makeUrl('catalog/attribute');
		$find = false;
		foreach ($data['menus'] as &$menus) {
			if ($menus['children']) {
				foreach ($menus['children'] as &$menu) {
					if ($menu['children']) {
						foreach ($menu['children'] as &$menu2) {
							if ($menu2['href'] == $find_url) {
								$find = true;
								break;
							}
						}
						if ($find) {
							if ($this->user->hasPermission('access', $this->path_module)) {
								$menu['children'][] = array(
									'name'	   => $this->language->get('text_menu'),
									'href'     => $this->makeUrl($this->path_module),
									'children' => array()
								);
							}
							break;
						}
					}
				}
				if ($find) {
					break;
				}
			}
		}
	}
}