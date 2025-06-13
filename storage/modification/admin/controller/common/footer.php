<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

             $data['module_tinymce_status'] = $this->config->get('module_tinymce_status');
              $data['module_tinymce_language'] = $this->config->get('module_tinymce_language');
              if ($data['module_tinymce_status']) {
                  if (isset($this->request->get['route'])) {
                     $route = $this->request->get['route'];
                     $tinymce_route[] = 'catalog/product/edit';
                     $tinymce_route[] = 'catalog/product/add';
                     $tinymce_route[] = 'catalog/category/edit';
                     $tinymce_route[] = 'catalog/category/add';
                     $tinymce_route[] = 'catalog/manufacturer/edit';
                     $tinymce_route[] = 'catalog/manufacturer/add';
                     $tinymce_route[] = 'catalog/information/edit';
                     $tinymce_route[] = 'catalog/information/add';
                     $tinymce_route[] = 'extension/module/html';
                     $tinymce_route[] = 'blog/article/edit';
                     $tinymce_route[] = 'blog/article/add';
                     $tinymce_route[] = 'blog/category/edit';
                     $tinymce_route[] = 'blog/category/add';
                     $tinymce_route[] = 'octemplates/blog/oct_blogarticle/edit';
                     $tinymce_route[] = 'octemplates/blog/oct_blogarticle/add';
                     if (! in_array($route, $tinymce_route)) {
                         $data['module_tinymce_status'] = false;
                     }
                  }
              }
             

		if ($this->user->isLogged() && isset($this->request->get['user_token']) && ($this->request->get['user_token'] == $this->session->data['user_token'])) {
			$data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		} else {
			$data['text_version'] = '';
		}
		
		return $this->load->view('common/footer', $data);
	}
}
