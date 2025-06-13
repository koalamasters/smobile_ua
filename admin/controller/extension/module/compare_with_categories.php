<?php
class ControllerExtensionModuleCompareWithCategories extends Controller {
	private $error = array(); 
	
	public function index() {  
        $this->load->language('extension/module/compare_with_categories');

		$this->document->setTitle($this->language->get('page_title'));

		$this->load->model('setting/setting');
		$this->load->model('localisation/language');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('compare_with_categories', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/compare_with_categories', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/compare_with_categories', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		// STATUS
		if (isset($this->request->post['compare_with_categories_status'])) {
			$data['compare_with_categories_status'] = $this->request->post['compare_with_categories_status'];
		} else {
			$data['compare_with_categories_status'] = $this->config->get('compare_with_categories_status');
		}

		// CATEGORIES STATUS
		if (isset($this->request->post['compare_with_categories_сats_status'])) {
			$data['compare_with_categories_сats_status'] = $this->request->post['compare_with_categories_сats_status'];
		} else {
			$data['compare_with_categories_сats_status'] = $this->config->get('compare_with_categories_сats_status');
		}

		// PRODUCT COUNTER
		if (isset($this->request->post['compare_with_categories_counter'])) {
			$data['compare_with_categories_counter'] = $this->request->post['compare_with_categories_counter'];
		} else {
			$data['compare_with_categories_counter'] = $this->config->get('compare_with_categories_counter');
		}

		// SHOW GROUP NAME
		if (isset($this->request->post['compare_with_categories_show_group_name'])) {
			$data['compare_with_categories_show_group_name'] = $this->request->post['compare_with_categories_show_group_name'];
		} else {
			$data['compare_with_categories_show_group_name'] = $this->config->get('compare_with_categories_show_group_name');
		}
		
		// VISIBLE SLIDES
		if (isset($this->request->post['compare_with_categories_items_default'])) {
			$data['compare_with_categories_items_default'] = $this->request->post['compare_with_categories_items_default'];
		} else {
			$data['compare_with_categories_items_default'] = $this->config->get('compare_with_categories_items_default');
		}
		if (isset($this->request->post['compare_with_categories_items_1200'])) {
			$data['compare_with_categories_items_1200'] = $this->request->post['compare_with_categories_items_1200'];
		} else {
			$data['compare_with_categories_items_1200'] = $this->config->get('compare_with_categories_items_1200');
		}
		if (isset($this->request->post['compare_with_categories_items_1024'])) {
			$data['compare_with_categories_items_1024'] = $this->request->post['compare_with_categories_items_1024'];
		} else {
			$data['compare_with_categories_items_1024'] = $this->config->get('compare_with_categories_items_1024');
		}
		if (isset($this->request->post['compare_with_categories_items_600'])) {
			$data['compare_with_categories_items_600'] = $this->request->post['compare_with_categories_items_600'];
		} else {
			$data['compare_with_categories_items_600'] = $this->config->get('compare_with_categories_items_600');
		}
		if (isset($this->request->post['compare_with_categories_items_480'])) {
			$data['compare_with_categories_items_480'] = $this->request->post['compare_with_categories_items_480'];
		} else {
			$data['compare_with_categories_items_480'] = $this->config->get('compare_with_categories_items_480');
		}

		// IMAGE SIZE
		if (isset($this->request->post['compare_with_categories_img_width'])) {
			$data['compare_with_categories_img_width'] = $this->request->post['compare_with_categories_img_width'];
		} else {
			$data['compare_with_categories_img_width'] = $this->config->get('compare_with_categories_img_width');
		}
		if (isset($this->request->post['compare_with_categories_img_height'])) {
			$data['compare_with_categories_img_height'] = $this->request->post['compare_with_categories_img_height'];
		} else {
			$data['compare_with_categories_img_height'] = $this->config->get('compare_with_categories_img_height');
		}

		// PRODUCT LIMIT
		if (isset($this->request->post['compare_with_categories_limit'])) {
			$data['compare_with_categories_limit'] = $this->request->post['compare_with_categories_limit'];
		} else {
			$data['compare_with_categories_limit'] = $this->config->get('compare_with_categories_limit');
		}

		// DEFAULT VALUES STATUS
		if (isset($this->request->post['compare_with_categories_def_val_status'])) {
			$data['compare_with_categories_def_val_status'] = $this->request->post['compare_with_categories_def_val_status'];
		} else {
			$data['compare_with_categories_def_val_status'] = $this->config->get('compare_with_categories_def_val_status');
		}

		// DEFAULT VALUES HEADING
		if (isset($this->request->post['compare_with_categories_def_heading'])) {
			$data['compare_with_categories_def_heading'] = $this->request->post['compare_with_categories_def_heading'];
		} else {
			$data['compare_with_categories_def_heading'] = $this->config->get('compare_with_categories_def_heading');
		}

		// model
		if (isset($this->request->post['compare_with_categories_model'])) {
			$data['compare_with_categories_model'] = $this->request->post['compare_with_categories_model'];
		} else {
			$data['compare_with_categories_model'] = $this->config->get('compare_with_categories_model');
		}
		if (isset($this->request->post['compare_with_categories_model_is_slider'])) {
			$data['compare_with_categories_model_is_slider'] = $this->request->post['compare_with_categories_model_is_slider'];
		} else {
			$data['compare_with_categories_model_is_slider'] = $this->config->get('compare_with_categories_model_is_slider');
		}

		// manufacturer
		if (isset($this->request->post['compare_with_categories_manufacturer'])) {
			$data['compare_with_categories_manufacturer'] = $this->request->post['compare_with_categories_manufacturer'];
		} else {
			$data['compare_with_categories_manufacturer'] = $this->config->get('compare_with_categories_manufacturer');
		}
		if (isset($this->request->post['compare_with_categories_manufacturer_is_slider'])) {
			$data['compare_with_categories_manufacturer_is_slider'] = $this->request->post['compare_with_categories_manufacturer_is_slider'];
		} else {
			$data['compare_with_categories_manufacturer_is_slider'] = $this->config->get('compare_with_categories_manufacturer_is_slider');
		}

		// availability
		if (isset($this->request->post['compare_with_categories_availability'])) {
			$data['compare_with_categories_availability'] = $this->request->post['compare_with_categories_availability'];
		} else {
			$data['compare_with_categories_availability'] = $this->config->get('compare_with_categories_availability');
		}
		if (isset($this->request->post['compare_with_categories_availability_is_slider'])) {
			$data['compare_with_categories_availability_is_slider'] = $this->request->post['compare_with_categories_availability_is_slider'];
		} else {
			$data['compare_with_categories_availability_is_slider'] = $this->config->get('compare_with_categories_availability_is_slider');
		}

		// weight
		if (isset($this->request->post['compare_with_categories_weight'])) {
			$data['compare_with_categories_weight'] = $this->request->post['compare_with_categories_weight'];
		} else {
			$data['compare_with_categories_weight'] = $this->config->get('compare_with_categories_weight');
		}
		if (isset($this->request->post['compare_with_categories_weight_is_slider'])) {
			$data['compare_with_categories_weight_is_slider'] = $this->request->post['compare_with_categories_weight_is_slider'];
		} else {
			$data['compare_with_categories_weight_is_slider'] = $this->config->get('compare_with_categories_weight_is_slider');
		}

		// dimension
		if (isset($this->request->post['compare_with_categories_dimension'])) {
			$data['compare_with_categories_dimension'] = $this->request->post['compare_with_categories_dimension'];
		} else {
			$data['compare_with_categories_dimension'] = $this->config->get('compare_with_categories_dimension');
		}
		if (isset($this->request->post['compare_with_categories_dimension_is_slider'])) {
			$data['compare_with_categories_dimension_is_slider'] = $this->request->post['compare_with_categories_dimension_is_slider'];
		} else {
			$data['compare_with_categories_dimension_is_slider'] = $this->config->get('compare_with_categories_dimension_is_slider');
		}

		// rating
		if (isset($this->request->post['compare_with_categories_rating'])) {
			$data['compare_with_categories_rating'] = $this->request->post['compare_with_categories_rating'];
		} else {
			$data['compare_with_categories_rating'] = $this->config->get('compare_with_categories_rating');
		}
		if (isset($this->request->post['compare_with_categories_rating_is_slider'])) {
			$data['compare_with_categories_rating_is_slider'] = $this->request->post['compare_with_categories_rating_is_slider'];
		} else {
			$data['compare_with_categories_rating_is_slider'] = $this->config->get('compare_with_categories_rating_is_slider');
		}



		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/compare_with_categories', $data));
	}
	
	public function install() {
	}
	
	public function uninstall() {
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/compare_with_categories')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
}