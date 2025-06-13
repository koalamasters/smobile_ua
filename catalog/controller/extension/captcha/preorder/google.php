<?php
class ControllerExtensionCaptchaPreorderGoogle extends Controller {
    public function index() {
        $this->load->language('extension/captcha/preorder/google');

		$data['entry_captcha'] = $this->language->get('entry_captcha');

		$data['site_key'] = $this->config->get('captcha_google_key');

        if (isset($this->request->get['route'])) {
			$data['route'] = $this->request->get['route']; 
		} else {
			$data['route'] = 'common/home';
		}

		return $this->load->view('extension/captcha/preorder/google', $data);
    }
	
	public function validate() {
		if (empty($this->session->data['preorder_gcapcha'])) {
			$this->load->language('extension/captcha/preorder/google');

			if (!isset($this->request->post['g-recaptcha-response'])) {
				return $this->language->get('error_captcha');
			}

			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('captcha_google_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

			$recaptcha = json_decode($recaptcha, true);

			if ($recaptcha['success']) {
				$this->session->data['gcapcha']	= true;
			} else {
				return $this->language->get('error_captcha');
			}
		}
    }
}
