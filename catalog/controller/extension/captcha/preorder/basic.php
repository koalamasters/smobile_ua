<?php
class ControllerExtensionCaptchaPreorderBasic extends Controller {
	public function index() {
		$this->load->language('extension/captcha/preorder/basic');

		$data['entry_captcha'] = $this->language->get('entry_captcha');

		if (isset($this->request->get['route'])) {
			$data['route'] = $this->request->get['route']; 
		} else {
			$data['route'] = 'common/home';
		}

		return $this->load->view('extension/captcha/preorder/basic', $data);
	}

	public function validate() {
		$this->load->language('extension/captcha/preorder/basic');

		if (empty($this->session->data['preorder_captcha']) || ($this->session->data['preorder_captcha'] != $this->request->post['captcha'])) {
			return $this->language->get('error_captcha');
		}
	}

	public function captcha() {
		$this->session->data['preorder_captcha'] = substr(sha1(mt_rand()), 17, 6);

		$image = imagecreatetruecolor(100, 20);

		$width = imagesx($image);
		$height = imagesy($image);

		$black = imagecolorallocate($image, 0, 0, 0);
		$white = imagecolorallocate($image, 255, 255, 255);
		$red = imagecolorallocatealpha($image, 255, 0, 0, 75);
		$green = imagecolorallocatealpha($image, 0, 255, 0, 75);
		$blue = imagecolorallocatealpha($image, 0, 0, 255, 75);

		imagefilledrectangle($image, 0, 0, $width, $height, $white);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue);
		imagefilledrectangle($image, 0, 0, $width, 0, $black);
		imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black);
		imagefilledrectangle($image, 0, 0, 0, $height - 1, $black);
		imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black);

		imagestring($image, 10, intval(($width - (strlen($this->session->data['preorder_captcha']) * 9)) / 2), intval(($height - 15) / 2), $this->session->data['preorder_captcha'], $black);

		header('Content-type: image/jpeg');

		imagejpeg($image);

		imagedestroy($image);
		exit();
	}
}
