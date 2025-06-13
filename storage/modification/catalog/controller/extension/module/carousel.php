<?php
class ControllerExtensionModuleCarousel extends Controller {
	public function index($setting) {

            $data['oct_lazyload'] = false;

            $this->load->model('tool/image');

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
			
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
		
		
			//$this->document->addStyle('catalog/view/javascript/jquery/swiper/css/swiper.min.css');
			
		
			//$this->document->addStyle('catalog/view/javascript/jquery/swiper/css/opencart.css');
			
//$this->document->addScript('catalog/view/javascript/jquery/swiper/js/swiper.jquery.js');
			$this->document->addScript('catalog/view/theme/oct_showcase/js/slick/slick.min.js');
			$this->document->addStyle('catalog/view/theme/oct_showcase/js/slick/slick.min.css');


			$data['heading_title'] = (isset($setting['title'][(int)$this->config->get('config_language_id')]) && !empty($setting['title'][(int)$this->config->get('config_language_id')])) ? $setting['title'][(int)$this->config->get('config_language_id')] : '';
			
		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(

                    'result_copy' => $result,
                
					'title' => $result['title'],
					'link'  => $result['link'],

			'width'		=> $setting['width'],
			'height'	=> $setting['height'],
			
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

                    if($this->FTMaster && !empty($data['banners'])) {
                        $this->DataLayer->add_data('promotions_listed', $this->DataLayer->format_promotions_listed($data['banners'], $setting['name']));
                    }
                

		return $this->load->view('extension/module/carousel', $data);
	}
}