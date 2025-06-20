<?php
class ControllerExtensionTotalCoupon extends Controller {
	public function index() {
		if ($this->config->get('total_coupon_status')) {
			$this->load->language('extension/total/coupon');

			if (isset($this->session->data['coupon'])) {
				$data['coupon'] = $this->session->data['coupon'];
			} else {
				$data['coupon'] = '';
			}

            $this->load->model('extension/total/coupon');
            if(isset($this->session->data['coupon'])) {
                $data['coupon_info'] = $this->model_extension_total_coupon->getCoupon($this->session->data['coupon']);
            }else{
                $data['coupon_info'] = [];
            }
			return $this->load->view('extension/total/coupon', $data);
		}
	}

	public function coupon() {
		$this->load->language('extension/total/coupon');

		$json = array();
        
		$this->load->model('extension/total/coupon');

		if (isset($this->request->post['coupon'])) {
			$coupon = $this->request->post['coupon'];
		} else {
			$coupon = '';
		}




		$coupon_info = $this->model_extension_total_coupon->getCoupon($coupon);

        if(empty($coupon_info['coupon_id'])) {
            $this->load->controller('product/promodecode');
            $this->load->controller('product/promodecode/indexdecode',$coupon);
        }
        
        $coupon_info = $this->model_extension_total_coupon->getCoupon($coupon);



		if (empty($this->request->post['coupon'])) {
			$json['error'] = $this->language->get('error_empty');

			unset($this->session->data['coupon']);
		} elseif ($coupon_info) {
			$this->session->data['coupon'] = $this->request->post['coupon'];

			$this->session->data['success'] = $this->language->get('text_success');

			$json['redirect'] = $this->url->link('checkout/cart');
		} else {
			$json['error'] = $this->language->get('error_coupon');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
