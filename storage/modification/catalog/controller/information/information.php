<?php
class ControllerInformationInformation extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('information/information');
        $this->load->language('information/contact');
        $this->load->model('catalog/information');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['information_id'])) {
            $information_id = (int) $this->request->get['information_id'];
        } else {
            $information_id = 0;
        }

        $information_info = $this->model_catalog_information->getInformation($information_id);

        $this->document->setRobots('index, follow');

        // $this->document->addLink($this->url->link('information/information', 'information_id=' . $information_id), 'canonical');
        $url = $this->url->link('information/information', 'information_id=' . $information_id);
        $url = str_replace('http://', '', $url);
        $this->document->addLink('https://' . $url, 'canonical');

        if ($information_info) {
            $this->document->setTitle($information_info['meta_title']);
            $this->document->setDescription($information_info['meta_description']);
            $this->document->setKeywords($information_info['meta_keyword']);

            $data['breadcrumbs'][] = array(
                'text' => $information_info['title'],
                'href' => $this->url->link('information/information', 'information_id=' . $information_id)
            );

            $data['heading_title'] = $information_info['title'];

            
			$info_description = str_replace("<img", "<img class='img-fluid'", html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8'));

			$data['description'] = $info_description;
			

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');


            $data['manufacturers'][] = array(
                'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . 24)
            );
            $data['manufacturers'][] = array(
                'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . 40)
            );
            $data['manufacturers'][] = array(
                'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . 31)
            );
            $data['manufacturers'][] = array(
                'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . 35)
            );
            $data['manufacturers'][] = array(
                'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . 32)
            );
            $data['manufacturer_page_link'] = $this->url->link('product/manufacturer');
            $data['product_special_page_link'] = $this->url->link('product/special');


            if($information_id == 13) {

                $oct_showcase_data = $this->config->get('theme_oct_showcase_data');

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


                $url = $this->url->link('information/information', 'information_id=' . $information_id);
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

                    $this->response->redirect($this->url->link('information/contact/success'));
                }


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

                if (isset($this->error['company'])) {
                    $data['error_company'] = $this->error['company'];
                } else {
                    $data['error_company'] = '';
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

                $data['action'] =  $this->url->link('information/information', 'information_id=' . $information_id, true);





                $data['store'] = $this->config->get('config_name');
                $data['address'] = nl2br($this->config->get('config_address'));
                $data['geocode'] = $this->config->get('config_geocode');
                $data['geocode_hl'] = $this->config->get('config_language');
                $data['telephone'] = $this->config->get('config_telephone');
                $data['fax'] = $this->config->get('config_fax');
                $data['open'] = nl2br($this->config->get('config_open'));
                $data['comment'] = $this->config->get('config_comment');
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

                if (isset($this->request->post['company'])) {
                    $data['company'] = $this->request->post['company'];
                } else {
                    $data['company'] = '';
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

                $data['entry_name_placeholder'] = $this->language->get('entry_name_placeholder');
                $data['entry_email_placeholder'] = $this->language->get('entry_email_placeholder');
                $data['entry_company_placeholder'] = $this->language->get('entry_company_placeholder');
                $data['entry_manager_contact'] = $this->language->get('entry_manager_contact');
                $data['entry_detail_about_coop'] = $this->language->get('entry_detail_about_coop');

                $data['external_link'] = $this->language->get('external_link');


                $this->response->setOutput($this->load->view('information/coop', $data));
            } elseif ($information_id == 4) {
                $this->response->setOutput($this->load->view('information/information_new', $data));
            } elseif ($information_id == 6) {
                $this->load->language('information/delivery_and_payment');
                $this->response->setOutput($this->load->view('information/information_delivery_and_payment', $data));
            } elseif ($information_id == 9) {
                $this->load->language('information/return');
                $this->response->setOutput($this->load->view('information/return', $data));
            } else {
                $this->response->setOutput($this->load->view('information/information', $data));
            }

        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('information/information', 'information_id=' . $information_id)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }

    }


    public function agree()
    {
        $this->load->model('catalog/information');

        if (isset($this->request->get['information_id'])) {
            $information_id = (int) $this->request->get['information_id'];
        } else {
            $information_id = 0;
        }

        $output = '';

        $information_info = $this->model_catalog_information->getInformation($information_id);

        if ($information_info) {
            $output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
        }

        $this->response->setOutput($output);
    }

    protected function validate() {
        $this->load->language('information/contact');

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['company']) < 1) || (utf8_strlen($this->request->post['company']) > 32)) {
            $this->error['company'] = $this->language->get('error_company');
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


        return !$this->error;
    }
}