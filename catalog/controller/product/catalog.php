<?php

class ControllerProductCatalog extends Controller {
	public function index() {
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['oct_lazyload'] = false;

		$data['oct_lazy_image'] = $this->config->get('theme_oct_showcase_lazyload_image') ? $this->model_tool_image->resize($this->config->get('theme_oct_showcase_lazyload_image'), 30, 30) : '/image/catalog/showcase/lazy-image.svg';

		if ($this->registry->has('oct_mobiledetect')) {
			if ($this->oct_mobiledetect->isMobile() && !$this->oct_mobiledetect->isTablet() && $this->config->get('theme_oct_showcase_lazyload_mobile')) {
				$data['oct_lazyload'] = true;
			} elseif ($this->oct_mobiledetect->isTablet() && $this->config->get('theme_oct_showcase_lazyload_tablet')) {
				$data['oct_lazyload'] = true;
			} elseif ($this->config->get('theme_oct_showcase_lazyload_desktop')) {
				$data['oct_lazyload'] = true;
			}
		} elseif ($this->config->get('theme_oct_showcase_lazyload_desktop')) {
			$data['oct_lazyload'] = true;
		}

		$use_avif = true;

		$usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}



		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home'),
		);

		$this->document->setRobots('index, follow');
		if ($this->config->get('config_language_id') == 3) {
			$this->document->setTitle('Виробники');
			$this->document->setDescription('Замовляйте онлайн в інтернет-магазині Smobile ✔ Низькі ціни ✔ Доставка по всій території України ✔ Повернення та обмін ☎️ +380678088989 | Smobile');
		} else {
			$this->document->setTitle('Производители');
			$this->document->setDescription('Заказывайте онлайн  в интернет-магазине Smobile ✔ Низкие цены ✔ Доставка по всей территории Украины ✔ Возврат и обмен ☎️ +380678088989 | Smobile');
		}




		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));



		$data['compare'] = $this->url->link('product/compare');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['thumb'] = null;
		$data['description'] = null;
		$data['categories'] = array();
		$data['button_grid'] = null;
		$data['button_list'] = null;
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['products'] = array();

		$filter_data = array(
			'filter_category_id' => 0,
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit,
		);

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {

			if ($result['image']) {
	//			$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				$image = '/image/'.$result['image'];

				if( $use_avif){
					$image = $this->model_tool_image->getAvif($result['image']);
				}else{
					$image = '/image/'.$result['image'];
				}


			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
			}


			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$special = false;
			}

			$price_for_ads = null;
			if (!$special) {
				$price_for_ads = $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'));
			} else {
				$price_for_ads = $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'));
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			$is_new = $this->model_catalog_product->getNewStatus($result['product_id']);

			$is_new_value = 0;
			if(!empty($is_new)) {
				$is_new_timestamp = strtotime($is_new['new_end_date']);
				$time_active = 0;
				if ($is_new_timestamp > time()) {
					$time_active = 1;
				}
				if ($time_active && $is_new['is_new']) {
					$is_new_value = 1;
				} else {
					$is_new_value = 0;
				}
			}else{
				if($days_passed < 31){
					$is_new_value = 1;
				}else {
					$is_new_value = 0;
				}
			}

			$price_for_usdt = 0;

			if($result['special']){
				$price_for_usdt = explode(' ', $result['special'])[0];
			}else{
				$price_for_usdt = explode(' ', $result['price'])[0];
			}

			$usdt_price = round($price_for_usdt/$usdt_rate);

			if ($result['quantity'] <= 0) {
				$stock = $result['stock_status'];
			} else {
				$stock = false;
			}

			$can_buy = true;

			if ($result['quantity'] <= 0 && !$this->config->get('config_stock_checkout')) {
				$can_buy = false;
			} elseif ($result['quantity'] <= 0 && $this->config->get('config_stock_checkout')) {
				$can_buy = true;
			}

			$oct_grayscale = ($this->config->get('theme_oct_showcase_no_quantity_grayscale') && !$can_buy) ? true : false;

			$oct_product_stickers = [];

			if ($this->config->get('oct_stickers_status')) {
				$oct_stickers = $this->config->get('oct_stickers_data');

				$data['oct_sticker_you_save'] = false;

				if ($oct_stickers) {
					$data['oct_sticker_you_save'] = isset($oct_stickers['stickers']['special']['persent']) ? true : false;
				}

				$this->load->model('octemplates/stickers/oct_stickers');
			}

			if (isset($oct_stickers) && $oct_stickers) {
				$oct_stickers_data = $this->model_octemplates_stickers_oct_stickers->getOCTStickers($result);

				$oct_product_stickers = [];

				if (isset($oct_stickers_data) && $oct_stickers_data) {
					$oct_product_stickers = $oct_stickers_data['stickers'];
				}
			}

			$this->load->model('module/ukrcredits');

			$ukrcredits_stickers = $this->model_module_ukrcredits->checkproduct($result);

			$lastIndex = 0;
			$data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
				'price'       => $price,
				'price_for_ads' => $price_for_ads,
				'special'     => $special,
				'tax'         => $tax,
				'ukrcredits_stickers' => isset($ukrcredits_stickers)?$ukrcredits_stickers:array(),
				'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating'      => $result['rating'],
				'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id'] . $url),
				'usdt_price' => $usdt_price,
				'oct_model'	  => $this->config->get('theme_oct_showcase_data_model') ? $result['model'] : '',
				'reviews'	  => $result['reviews'],
				'quantity'	  => $result['quantity'] <= 0 ? true : false,
				'stock'     => $stock,
				'can_buy' => $can_buy,
				'oct_grayscale'  => $oct_grayscale,
				'width'		  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'),
				'height'	  => $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'),
				'you_save'	  	=> $result['you_save'],
				'oct_stickers'  => $oct_product_stickers
			);

			$lastIndex = count($data['products']) - 1;
			unset( $data['products'][$lastIndex]['oct_stickers']['stickers_new']);
			if($is_new_value){
				$data['products'][$lastIndex]['oct_stickers']['stickers_new'] = 'Новинка';
			}
		}

		$url = '';

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('product/catalog', '&sort=p.sort_order&order=ASC' . $url),
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => $this->url->link('product/catalog', '&sort=pd.name&order=ASC' . $url),
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => $this->url->link('product/catalog', '&sort=pd.name&order=DESC' . $url),
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_asc'),
			'value' => 'p.price-ASC',
			'href'  => $this->url->link('product/catalog', '&sort=p.price&order=ASC' . $url),
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_price_desc'),
			'value' => 'p.price-DESC',
			'href'  => $this->url->link('product/catalog', '&sort=p.price&order=DESC' . $url),
		);

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('product/catalog', '&sort=rating&order=DESC' . $url),
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('product/catalog', '&sort=rating&order=ASC' . $url),
			);
		}

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_asc'),
			'value' => 'p.model-ASC',
			'href'  => $this->url->link('product/catalog', '&sort=p.model&order=ASC' . $url),
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href'  => $this->url->link('product/catalog', '&sort=p.model&order=DESC' . $url),
		);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = array();

//		$limits = array_unique(array($this->journal3->themeConfig('product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach ($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('product/catalog', $url . '&limit=' . $value),
			);
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['product_total'] = $product_total;
		$data['product_total_text'] = '('.$product_total.' '.$this->getProductWord($product_total).')';

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('product/catalog', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
			// $this->document->addLink($this->url->link('product/catalog'), 'canonical');

			$url = $this->url->link('product/catalog');
			$url = str_replace('http://', '', $url);
			$this->document->addLink('https://' . $url, 'canonical');
		} else {
			// $this->document->addLink($this->url->link('product/catalog', '&page=' . $page), 'canonical');

			$url = $this->url->link('product/catalog');
			$url = str_replace('http://', '', $url);
			$this->document->addLink('https://' . $url, 'canonical');
		}

		if ($page > 1) {
			$this->document->addLink($this->url->link('product/catalog', (($page - 2) ? '&page=' . ($page - 1) : '')), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
			$this->document->addLink($this->url->link('product/catalog', '&page=' . ($page + 1)), 'next');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/category', $data));
	}

	public function getProductWord($product_total) {
        $forms = ['продукт', 'продукти', 'продуктів'];

        if ($product_total % 10 == 1 && $product_total % 100 != 11) {
            return $forms[0]; // Наприклад, 1 товар
        } elseif ($product_total % 10 >= 2 && $product_total % 10 <= 4 && ($product_total % 100 < 10 || $product_total % 100 >= 20)) {
            return $forms[1]; // Наприклад, 2-4 товари
        } else {
            return $forms[2]; // Інші випадки: 5 товарів, 11 товарів і т.д.
        }
    }
}
