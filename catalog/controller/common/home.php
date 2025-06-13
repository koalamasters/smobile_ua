<?php
class ControllerCommonHome extends Controller {
	public function index() {

		if ($this->config->get('config_language_id') == 3) {
			$this->document->setTitle('Інтернет-магазин Smobile - офіційний сайт магазину техніки та аксесуарів');
			$this->document->setDescription('Smobile – Інтернет магазин техніки та аксесуарів. Купуйте в Smobile ✓ Офіційна гарантія ✓ Доставка по всій Україні 🚚 Вигідні ціни та знижки % Телефон гарячої лінії ☎️ +380678088989');
		} else {
			$this->document->setTitle('Интернет-магазин Smobile - официальный сайт магазина техники и аксессуаров');
			$this->document->setDescription('Smobile – Интернет магазин техники и аксессуаров. Покупайте у Smobile ✓ Официальная гарантия ✓ Доставка по всей Украине 🚚 Выгодные цены и скидки % Телефон горячей линии ☎️ +380678088989');
		}

		// $this->document->setTitle($this->config->get('config_meta_title'));
		// $this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));



		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$url = $this->config->get('config_url');
		$url = str_replace('http://', '', $url);
		$this->document->addLink('https://' . $url, 'canonical');


		$this->document->setRobots('index, follow');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


        if (isset($this->request->get['mail-wishlist']) && $this->request->get['mail-wishlist']) {
            $data['show_wishlist'] = true;
        }

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
