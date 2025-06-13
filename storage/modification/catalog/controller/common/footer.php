<?php
class ControllerCommonFooter extends Controller {
	public function index() {

                 $data['module_mono_checkout_cart_show'] = $this->config->get('module_mono_checkout_cart_show') ? $this->config->get('module_mono_checkout_cart_show') : false;
                 if($data['module_mono_checkout_cart_show']) {
                 $data['mono_checkout_button'] = $this->config->get('module_mono_checkout_cart_show') ?   str_replace("\n", '',$this->load->controller('extension/module/mono_checkout/getButton', 'cart_modal')) : false;
                 $data['module_mono_checkout_cart_popup_elem'] = $this->config->get('module_mono_checkout_cart_popup_elem') ? $this->config->get('module_mono_checkout_cart_popup_elem') : '#cart p.text-right a:last-child';
                 }
            
		$this->load->language('common/footer');

        if (isset($this->request->get['scode'])) {
          setcookie('scode', $this->request->get['scode'], time() + 3600 * 24 * 1000, '/');
        }
        

                $data_for_hpmrr['hpmrr_cat_redirect'] = $this->config->get(kjhelper::$key_prefix . 'hpmrr_cat_ajax') ? "false" : "true";

                if(floatval(VERSION) < 2.3)
                {
                    $data['hpmrr_cat_cfg'] = $this->load->view('default/template/extension/module/hpmrr/config_cat.tpl', $data_for_hpmrr);
                }
                else
                {
                    $data['hpmrr_cat_cfg'] = $this->load->view('extension/module/hpmrr/config_cat', $data_for_hpmrr);
                }
                

		$this->load->model('catalog/information');

		$data['informations'] = array();
        $information_pages = $this->model_catalog_information->getInformations();

		foreach ($information_pages as $result) {
            $information_pages_by_id[$result['information_id']] = $result['title'];
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

        if($_SERVER['REMOTE_ADDR'] == '5.58.178.186') {

            if (isset($_GET['scode']) && isset($_GET['scode']) && $this->session->data['coupon']) {
                $data['coupon_info'] = $this->model_extension_total_coupon->getCoupon($this->session->data['coupon']);
                $data['coupon_info']['discount_round'] = number_format($data['coupon_info']['discount'],0);
                $data['show_discount_banner'] = 1;
            }else{
                $data['coupon_info'] = [];
                $data['show_discount_banner'] = 0;
            }

            if(isset($_COOKIE['dont_show_hello_discount'])){
                if($_COOKIE['dont_show_hello_discount'] == 1){
                    $data['show_discount_banner'] = 0;
                }
            }
        }

        $data['show_discount_banner'] = 0;

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));


        $informations_1[] = [
            'title' => $information_pages_by_id[4],
            'href' => $this->url->link('information/information', 'information_id=' . 4)
        ];
        $informations_1[] = [
            'title' => $this->language->get('text_sitemap'),
            'href' => $data['sitemap']
        ];
        $informations_1[] = [
            'title' => $this->language->get('text_brands'),
            'href' => $data['manufacturer']
        ];
        $informations_1[] = [
            'title' => $information_pages_by_id[13],
            'href' => $this->url->link('information/information', 'information_id=' . 13)
        ];



        $informations_2[] = [
            'title' => $information_pages_by_id[6],
            'href' => $this->url->link('information/information', 'information_id=' . 6)
        ];

        $informations_2[] = [
            'title' => $information_pages_by_id[5],
            'href' => $this->url->link('information/information', 'information_id=' . 5)
        ];
        $informations_2[] = [
            'title' => $information_pages_by_id[3],
            'href' => $this->url->link('information/information', 'information_id=' . 3)
        ];
        $informations_2[] = [
            'title' => $information_pages_by_id[9],
            'href' => $this->url->link('information/information', 'information_id=' . 9)
        ];



        $data['informations_1'] = $informations_1;
        $data['informations_2'] = $informations_2;
        $data['text_information_2'] = $this->language->get('text_information_2');


			// remarketing all in one 
			$this->load->model('tool/remarketing');
			if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot()) {
				$data['remarketing_footer'] = $this->load->controller('common/remarketing/footer');
				$data['remarketing_status'] = $this->config->get('remarketing_status');	
			}
			
		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		$data['scripts'] = $this->document->getScripts('footer');


		// Footer image
		if ($this->config->get('config_image_footer')) {
            $data['custom_logo_footer'] = '/image/' . $this->config->get('config_image_footer');
        } else {
            $data['custom_logo_footer'] = false;
        }
		
		return $this->load->view('common/footer', $data);
	}
}
