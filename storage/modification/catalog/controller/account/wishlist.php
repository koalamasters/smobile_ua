<?php
class ControllerAccountWishList extends Controller {
	public function index() {
		
			if (!$this->customer->isLogged() && !$this->config->get('theme_oct_showcase_status')) {
			
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/wishlist');

		$this->load->model('account/wishlist');


				$this->load->language('extension/module/preorder');
				
				if ($this->config->get('module_preorder_phone_mask')) {
					$this->document->addScript('catalog/view/javascript/preorder/inputmask/jquery.inputmask.bundle.min.js');
				}
				
				$this->document->addScript('catalog/view/javascript/preorder/preorder.js');
				$this->document->addStyle('catalog/view/javascript/preorder/preorder.css');
				$preorder_language_id = $this->config->get('config_language_id');
				
				$preorder_button = $this->config->get('module_preorder_button');
				
				if ($preorder_button['wishlist']['preorder']['view'] == 2) {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['wishlist']['preorder']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['wishlist']['preorder']['view'] == 1) {
					$preorder_button_preorder_view['text'] = $preorder_button['wishlist']['preorder']['text'][$preorder_language_id];
				} else {
					$preorder_button_preorder_view['text'] = '<i class="fa fa-bell"></i>';
					$preorder_button_preorder_view['tooltip'] = $preorder_button['wishlist']['preorder']['text'][$preorder_language_id];
				}
				
				if ($preorder_button['wishlist']['out_sale']['view'] == 2) {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i> <span class="hidden-xs hidden-sm hidden-md">' . $preorder_button['wishlist']['out_sale']['text'][$preorder_language_id] . '</span>';
				} elseif ($preorder_button['wishlist']['out_sale']['view'] == 1) {
					$preorder_button_out_sale_view['text'] = $preorder_button['wishlist']['out_sale']['text'][$preorder_language_id];
				} else {
					$preorder_button_out_sale_view['text'] = '<i class="fa fa-ban"></i>';
					$preorder_button_out_sale_view['tooltip'] = $preorder_button['wishlist']['out_sale']['text'][$preorder_language_id];
				}
			
		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['remove'])) {

			if ($this->customer->isLogged()) {
			
			// Remove Wishlist
			$this->model_account_wishlist->deleteWishlist($this->request->get['remove']);

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->response->redirect($this->url->link('account/wishlist'));

			} else {
				if (isset($this->session->data['wishlist'])) {
					$oct_w_key = array_keys($this->session->data['wishlist'], $this->request->get['remove']);

					if (!empty($oct_w_key) && isset($oct_w_key[0])) {
						unset($this->session->data['wishlist'][$oct_w_key[0]]);

						$this->session->data['success'] = $this->language->get('text_remove');

						$this->response->redirect($this->url->link('account/wishlist'));
					}
				}
			}
			
		}

		$this->document->setRobots('noindex, nofollow');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/wishlist')
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['products'] = array();

		
			$results = $this->customer->isLogged() ? $this->model_account_wishlist->getWishlist() : ((isset($this->session->data['wishlist']) && !empty($this->session->data['wishlist'])) ? $this->session->data['wishlist'] : []);
			
        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

		foreach ($results as $result) {
			
			$product_info = $this->model_catalog_product->getProduct(isset($result['product_id']) ? $result['product_id'] : $result);
			

			if ($product_info) {
				if ($product_info['image']) {
					$image = '/image/'.$product_info['image'];
				} else {
					$image = false;
				}

                $can_buy = true;

                if ($product_info['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
                    $can_buy = false;
                } elseif ($product_info['quantity'] <= 0 && $this->config->get('config_stock_checkout')) {
                    $can_buy = true;
                }


				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

                $price_for_ads = null;
                if (!$special) {
                    $price_for_ads = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                } else {
                    $price_for_ads = $this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                }

                $data['usdt_info'] = $this->language->get('usdt_info');

                $price_for_usdt = 0;

                if($result['special']){
                    $price_for_usdt = explode(' ', $product_info['special'])[0];
                }else{
                    $price_for_usdt = explode(' ', $product_info['price'])[0];
                }

                $usdt_price = round($price_for_usdt/$usdt_rate);




				$preorder_info = array();
			
				if ($this->config->get('module_preorder_stock_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_stock_statuses'))) {
					$preorder_stock_status = 2;
					$preorder_view = $preorder_button_preorder_view;
					$preorder_class = $preorder_button['wishlist']['preorder']['class'];
				} elseif ($this->config->get('module_preorder_out_sale_statuses') && in_array($product_info['stock_status_id'], $this->config->get('module_preorder_out_sale_statuses'))) {
					$preorder_stock_status = 1;
					$preorder_view = $preorder_button_out_sale_view;
					$preorder_class = $preorder_button['wishlist']['out_sale']['class'];
				} else {
					$preorder_stock_status = 0;
					$preorder_view = '';
					$preorder_class = '';
				}
				
				$preorder_info = array(
					'stock_status' => $preorder_stock_status,
					'quantity'     => $product_info['quantity'],
					'view'         => $preorder_view,
					'class'        => $preorder_class,
				);
			
                $data['products'][] = array(

				'preorder' => $preorder_info,
			
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'oct_model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,
					'special'    => $special,
                    'price_for_ads' => $price_for_ads,
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']),
					'can_buy'     => $can_buy,
                    'usdt_price' => $usdt_price

				);
			} else {
				$this->model_account_wishlist->deleteWishlist($result['product_id']);
			}
		}

		$data['continue'] = $this->url->link('account/account', '', true);

        $data['column_left'] = $this->load->controller('common/column_left',['wide' => 1]);
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/wishlist', $data));
	}

	public function add() {
		$this->load->language('account/wishlist');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);


                    $file = 'library/flowytracking/includes/add_to_wishlist.php';
                    $path_modification = DIR_MODIFICATION.'system/'.$file;
                    $path_temp = DIR_SYSTEM.$file;
                    require_once (is_file($path_modification) ? $path_modification : $path_temp);
                
		if ($product_info) {
			if ($this->customer->isLogged()) {
				// Edit customers cart
				$this->load->model('account/wishlist');

				$this->model_account_wishlist->addWishlist($this->request->post['product_id']);

				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				$json['total'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());

			$json['total_wishlist'] = $this->model_account_wishlist->getTotalWishlist();
			
			} else {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$this->session->data['wishlist'][] = $this->request->post['product_id'];

				$this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);

				
			$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
			

				$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));

			$json['total_wishlist'] = (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);
			
			}
		}


		  // remarketing all in one
		  $this->load->model('tool/remarketing');
		  if ($this->config->get('remarketing_status') && $product_info && !$this->model_tool_remarketing->isBot()) {
		  	  $json['remarketing'] = $this->model_tool_remarketing->remarketingWishlist($product_info);
		  }
	  
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    public function clear() {
        $json = [];

        if ($this->customer->isLogged()) {
            // Завантаження моделі
            $this->load->model('account/wishlist');

            // Очищення списку обраних
            $this->model_account_wishlist->clearWishlist();

            $json['success'] = $this->language->get('text_success_clear');
        } else {
            $json['error'] = $this->language->get('error_not_logged');
        }

        $this->response->redirect($this->url->link('account/wishlist', '', true));
    }

}
