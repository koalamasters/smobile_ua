<?php
class ControllerInformationContact extends Controller {
    private $error = array();

    public function index() {

			$oct_showcase_data = $this->config->get('theme_oct_showcase_data');

			if ((isset($oct_showcase_data['contact_view_map']) && $oct_showcase_data['contact_view_map'] == 'on') && (isset($oct_showcase_data['contact_map']) && !empty($oct_showcase_data['contact_map']))) {
				$data['contact_map'] = html_entity_decode($oct_showcase_data['contact_map'], ENT_QUOTES, 'UTF-8');
			}

			if ((isset($oct_showcase_data['contact_view_socials']) && $oct_showcase_data['contact_view_socials'] == 'on') && (isset($oct_showcase_data['socials']) && !empty($oct_showcase_data['socials']))) {
				$data['contact_socials'] = $oct_showcase_data['socials'];
			}

			if ((isset($oct_showcase_data['contact_view_phone']) && $oct_showcase_data['contact_view_phone'] == 'on') && (isset($oct_showcase_data['contact_telephone']) && !empty($oct_showcase_data['contact_telephone']))) {
				$oct_contact_telephones = explode(PHP_EOL, $oct_showcase_data['contact_telephone']);

				foreach ($oct_contact_telephones as $oct_contact_telephone) {
					if (!empty($oct_contact_telephone)) {
						$data['contact_telephone'][] = html_entity_decode(trim($oct_contact_telephone), ENT_QUOTES, 'UTF-8');
					}
				}
			}

			if ((isset($oct_showcase_data['contact_view_time']) && $oct_showcase_data['contact_view_time'] == 'on') && (isset($oct_showcase_data['contact_open'][(int)$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_open'][(int)$this->config->get('config_language_id')]))) {
				$oct_contact_opens = explode(PHP_EOL, $oct_showcase_data['contact_open'][(int)$this->config->get('config_language_id')]);

				foreach ($oct_contact_opens as $oct_contact_open) {
					if (!empty($oct_contact_open)) {
						$data['contact_open'][] = html_entity_decode($oct_contact_open, ENT_QUOTES, 'UTF-8');
					}
				}
			}

			if ((isset($oct_showcase_data['contact_view_address']) && $oct_showcase_data['contact_view_address'] == 'on') && (isset($oct_showcase_data['contact_address'][(int)$this->config->get('config_language_id')]) && !empty($oct_showcase_data['contact_address'][(int)$this->config->get('config_language_id')]))) {
				$data['contact_address'] = html_entity_decode($oct_showcase_data['contact_address'][(int)$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
			}

			if (isset($oct_showcase_data['contact_view_html'][(int)$this->config->get('config_language_id')]) && !empty(strip_tags($oct_showcase_data['contact_view_html'][(int)$this->config->get('config_language_id')]))) {
				$data['contact_html'] = html_entity_decode($oct_showcase_data['contact_view_html'][(int)$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
			}

			if ($this->config->get('config_account_id')) {
	            $this->load->model('catalog/information');

				$data['scales_in'] = isset($this->request->post['scales']) ? 1 : 0;

	            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

	            if ($information_info) {
	                $data['text_terms'] = sprintf($this->language->get('text_oct_terms'), $this->url->link('information/information', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
	            } else {
	                $data['text_terms'] = '';
	            }
	        } else {
	            $data['text_terms'] = '';
	        }

			if (isset($oct_showcase_data['contact_view_locations']) && $oct_showcase_data['contact_view_locations'] == 'on') {
				$this->load->model('octemplates/widgets/oct_locations');

				$data['oct_locations'] = $this->model_octemplates_widgets_oct_locations->getOCTLocations();
			}

			if (isset($oct_showcase_data['contact_image']) && !empty($oct_showcase_data['contact_image']) && file_exists(DIR_IMAGE.$oct_showcase_data['contact_image'])) {
				$this->load->model('tool/image');

				$data['oct_contact_image'] = $this->model_tool_image->resize($oct_showcase_data['contact_image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_location_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_location_height'));
			}
			
        $this->load->language('information/contact');

        $url = $this->url->link('information/contact');
        $url = str_replace('http://', '', $url);
        $this->document->addLink('https://' . $url, 'canonical');

        $this->document->setRobots('index, follow');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $mail = new Mail($this->config->get('config_mail_engine'));
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));
            $mail->setReplyTo($this->request->post['email']);
            $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
            $mail->setText($this->request->post['enquiry']);
            $mail->send();

			$send_ntf = $this->config->get('module_tlgrm_notification_status');
			$contact_form = $this->config->get('module_tlgrm_notification_contact_form');
			
			if ($send_ntf == 1 && $contact_form == 1) {
				$tlgrm_ntf_id = $this->config->get('module_tlgrm_notification_id');
				if (strlen($tlgrm_ntf_id) > 0) {
					$tlgrm_ntf = array(
						'name',
						'email',
					);

					foreach ($tlgrm_ntf as $key) {
						$tlgrm_ntf[$key] = $this->config->get('module_tlgrm_notification_contact_'.$key) || 0;
					}

					$this->load->language('extension/module/tlgrm_notification');
	
					$message = $this->language->get("text_contact") . ' ' . $this->request->server['HTTP_HOST'] . PHP_EOL;
					foreach ($this->request->post as $key => $value) {
						if (isset($tlgrm_ntf[$key])) {
				   			if ($tlgrm_ntf[$key] && !empty($this->request->post[$key])) {
				   				$message .= '<b>'. $this->language->get("text_contact_$key") .': </b>'. $this->request->post[$key] . PHP_EOL;
				   			}
				   		}
					}
					if ($this->config->get('module_tlgrm_notification_contact_comment')) {
						$message .= '<b>'. $this->language->get("text_contact_comment") .': </b>' . PHP_EOL . strip_tags($this->request->post['enquiry']) . PHP_EOL;
					}
					$this->load->model("extension/module/tlgrm_notification");
			        $this->model_extension_module_tlgrm_notification->SendMessage($message);
				}
			}
			

		$this->load->model('tool/remarketing'); 
		if ($this->config->get('remarketing_status') && !$this->model_tool_remarketing->isBot() && $this->config->get('remarketing_telegram_status') && $this->config->get('remarketing_telegram_contact_form')) {
			$this->model_tool_remarketing->sendTelegramMsg('Contact Form' . "\n\n" . $this->request->post['name'] . "\n" . $this->request->post['email'] . "\n\n" . $this->request->post['enquiry']);
		}
		

            $this->response->redirect($this->url->link('information/contact/success'));
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contact')
        );

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        if (isset($this->error['enquiry'])) {
            $data['error_enquiry'] = $this->error['enquiry'];
        } else {
            $data['error_enquiry'] = '';
        }


			if (isset($this->error['scales'])) {
				$data['error_oct_terms'] = $this->error['scales'];
			} else {
				$data['error_oct_terms'] = '';
			}
			
        $data['button_submit'] = $this->language->get('button_submit');

        $data['action'] = $this->url->link('information/contact', '', true);

        $this->load->model('tool/image');

        if ($this->config->get('config_image')) {
            $data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_location_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_location_height'));
        } else {
            $data['image'] = false;
        }

        $data['store'] = $this->config->get('config_name');
        $data['address'] = nl2br($this->config->get('config_address'));
        $data['geocode'] = $this->config->get('config_geocode');
        $data['geocode_hl'] = $this->config->get('config_language');
        $data['telephone'] = $this->config->get('config_telephone');
        $data['fax'] = $this->config->get('config_fax');
        $data['open'] = nl2br($this->config->get('config_open'));
        $data['comment'] = $this->config->get('config_comment');

        $data['locations'] = array();

        $this->load->model('localisation/location');

        foreach((array)$this->config->get('config_location') as $location_id) {
            $location_info = $this->model_localisation_location->getLocation($location_id);

            if ($location_info) {
                if ($location_info['image']) {
                    $image = $this->model_tool_image->resize($location_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_location_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_location_height'));
                } else {
                    $image = false;
                }

                $data['locations'][] = array(
                    'location_id' => $location_info['location_id'],
                    'name'        => $location_info['name'],
                    'address'     => nl2br($location_info['address']),
                    'geocode'     => $location_info['geocode'],
                    'telephone'   => $location_info['telephone'],
                    'fax'         => $location_info['fax'],
                    'image'       => $image,
                    'open'        => nl2br($location_info['open']),
                    'comment'     => $location_info['comment']
                );
            }
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } else {
            $data['name'] = $this->customer->getFirstName();
        }

        if (isset($this->request->post['email'])) {
            $data['email'] = $this->request->post['email'];
        } else {
            $data['email'] = $this->customer->getEmail();
        }

        if (isset($this->request->post['enquiry'])) {
            $data['enquiry'] = $this->request->post['enquiry'];
        } else {
            $data['enquiry'] = '';
        }

        // Captcha
        if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
            $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
        } else {
            $data['captcha'] = '';
        }

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $data['entry_name_placeholder'] = $this->language->get('entry_name_placeholder'); // Введіть ваше Імʼя
        $data['entry_email_placeholder'] = $this->language->get('entry_email_placeholder'); // Введіть ваше Імʼя


        $this->response->setOutput($this->load->view('information/contact', $data));
    }

    protected function validate() {
        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = $this->language->get('error_email');
        }

        if ((utf8_strlen($this->request->post['enquiry']) < 3) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
            $this->error['enquiry'] = $this->language->get('error_enquiry');
        }

        // Captcha
        if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
            $captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

            if ($captcha) {
                $this->error['captcha'] = $captcha;
            }
        }


	        if ($this->config->get('config_account_id') && !isset($this->request->post['scales'])) {
	            $this->load->model('catalog/information');

	            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

	            $this->error['scales'] = sprintf($this->language->get('error_oct_terms'), $information_info['title']);
	        }
			
        return !$this->error;
    }

    public function success() {
        $this->load->language('information/contact');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contact')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('entry_mail_sent'),
            'href' => $this->url->link('information/contact')
        );


			$data['text_message'] = $this->language->get('text_message_contact');
			
        $data['continue'] = $this->url->link('common/home');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $data['entry_go_home'] = $this->language->get('entry_go_home'); // Введіть ваше Імʼя

        $this->response->setOutput($this->load->view('common/success', $data));
    }
}
