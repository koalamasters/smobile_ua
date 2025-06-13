<?php
class ControllerCommonHeader extends Controller
{
	public function index() {

        $this->load->language('common/header');
		// Analytics
		$this->load->model('setting/extension');

		$data['analytics'] = array();

		$analytics = $this->model_setting_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get('analytics_' . $analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['robots'] = $this->document->getRobots();
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');

        foreach ($data['links'] as &$link){
            if($link['rel'] == 'canonical'){
                $link['href'] = 'https://smobile.ua'.explode('?', $_SERVER['REQUEST_URI'])[0];
            }
        }


		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['name'] = $this->config->get('config_name');
        $data['work_hours'] = $this->language->get('work_hours');
        $data['callback_btn'] = $this->language->get('callback_btn');


        $data['current_page_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


        //if( $_SERVER['REMOTE_ADDR'] == '5.58.178.186') {
            $link = $_SERVER['REQUEST_URI'];
            $curent_lang = $this->session->data['language'];
            $target_lang = ($this->session->data['language'] == 'uk-ua') ? 'ru-ru' : 'uk-ua';
            $href_langs = $this->load->controller('tool/languagelink/getLink', [$link, $curent_lang, $target_lang]);


//            if( $_SERVER['REMOTE_ADDR'] == '5.58.178.186') {
//                echo "<pre style='display: none' id='kl_look_mp'>";
//                print_r([$link, $curent_lang, $target_lang]);
//                echo "</pre>";
//            }


            $GLOBALS['href_langs'] = $href_langs;

            $data['href_langs'] = $href_langs;


            if($curent_lang == 'ru-ru'){
                $url_parts = explode('/', $_SERVER['REQUEST_URI']);
               if($url_parts[1] != 'ru'){
                   header("Location: /ru".$_SERVER['REQUEST_URI'], TRUE, 301);
               }
            }
         //}


		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
//			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
            $data['logo'] = $server . '/image/catalog/white-logo.png';
		} else {
			$data['logo'] = '';
		}


		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}
        $data['cart_link'] = $this->url->link('checkout/cart', '', true);
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
        $data['curent_url'] = $_SERVER["REQUEST_URI"];
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['menu'] = $this->load->controller('common/menu');

		// Header image
		if ($this->config->get('config_image_header')) {
            $data['custom_logo_header'] =  $server . 'image/' . $this->config->get('config_image_header');
        } else {
            $data['custom_logo_header'] = false;
        }

		// Header image mobile
		if ($this->config->get('config_image_header_mobile')) {
            $data['custom_logo_header_mobile'] = $server . 'image/' . $this->config->get('config_image_header_mobile');
        } else {
            $data['custom_logo_header_mobile'] = false;
        }

		
		if ($_SERVER['REMOTE_ADDR'] === '217.196.163.83') {
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
		}

		return $this->load->view('common/header', $data);




		// Add missing alt tags to images
		$this->load->model('tool/image');
		$language = $this->config->get('config_language');
		$images = $this->model_tool_image->getImages();
		foreach ($images as $image) {
			$alt = '';
			if (isset($image['alt'])) {
				$alt = $image['alt'];
			} else {
				$filename = basename($image['image']);
				$alt = pathinfo($filename, PATHINFO_FILENAME);
				$image['alt'] = $this->language->get('image_alt_text_' . $alt);
				if (empty($image['alt'])) {
					$image['alt'] = ucfirst(str_replace(array('-', '_'), ' ', $alt));
				}
			}
			$this->document->addImage($this->model_tool_image->resize($image['image'], 100, 100), $alt);
		}


        $product_views = [];

        if (isset($this->request->cookie['oct_product_views'])) {
            $product_views = explode(',', $this->request->cookie['oct_product_views']);
        } elseif (isset($this->session->data['oct_product_views'])) {
            $product_views = $this->session->data['oct_product_views'];
        }

        if (isset($this->request->cookie['viewed'])) {
            $product_views = array_merge($product_views, explode(',', $this->request->cookie['viewed']));
        } elseif (isset($this->session->data['viewed'])) {
            $product_views = array_merge($product_views, $this->session->data['viewed']);
        }

        $data['product_views_count'] = count($product_views);

		// running top line
		$data['top_line_info'] = $this->language->get('top_line_info');
		
		// form success text
		$data['form_success_sent_message'] = $this->language->get('form_success_sent_message');
		$data['form_success_continue_btn'] = $this->language->get('form_success_continue_btn');

	}
}