<?php
    class ModelExtensionModuleFlowyTrackingTabGeneral extends ModelExtensionModuleFlowyTracking
    {
        public function __construct($registry) {
            parent::__construct($registry);
            $this->load->language($this->real_extension_type.'/flowy_tracking_tab_general');

            $this->actions_ee_multichannel = array(
                '' => '',
                'visit_product_page' => $this->_lang('multichannel_funnel_action_visit_product_page'),
                'add_to_cart' => $this->_lang('multichannel_funnel_action_add_to_cart'),
                'visit_cart_page' => $this->_lang('multichannel_funnel_action_visit_cart_page'),
                'visit_checkout_page' => $this->_lang('multichannel_funnel_action_visit_checkout_page'),
                'finish_order' => $this->_lang('multichannel_funnel_action_finish_order'),
            );

            $this->load->model('localisation/order_status');
            $order_statuses = array();
            $order_statuses_temp = $this->model_localisation_order_status->getOrderStatuses();
            foreach ($order_statuses_temp as $key => $ord) {
                $order_statuses[$ord['order_status_id']] = $ord['name'];
            }
            $this->order_statuses = $order_statuses;

            $this->product_identificators = array(
                'product_id' => 'Product ID',
                'model' => 'Model',
                'sku' => 'SKU',
                'upc' => 'UPC',
                'ean' => 'EAN',
                'jan' => 'JAN',
                'isbn' => 'ISBN',
                'mpn' => 'MPN'
            );
        }

        public function get_no_valid_domain_text() {
            $this->document->addStyle($this->api_url.'resources/opencart/css/tab_general.css?'.date('Ymdhis'));

            $fields = array(
                array(
                    'type' => 'html_hard',
                    'html_code' => '<div style="max-width: 550px; margin: 0 auto;"><div style="text-align: center">
            <img style="max-width: 250px" src="https://dash.flowytracking.com/resources/logo.svg" alt="FlowyTracking Logo">
            <h2 style="color: #8052EC; margin-top: 0px; font-size: 29px;">Welcome to FlowyTracking!</h2>
        </div>
        <p>Hello, how are you? We hope the installation of our module has been successful. =)</p>
        <p>You are just one step away from enjoying FlowyTracking. We have detected that your domain <b>'.HTTPS_CATALOG.'</b> is not added to our system.</p>
        <p>If you don\'t have a FlowyTracking account yet, <a href="https://dash.flowytracking.com/user/register" target="_blank">complete the registration</a> to later add your domain. Once done, <b>refresh this page</b>, and you will be able to see the module administration.</p>
        <p>Within your FlowyTracking account, in the domain administration, you can do things like:</p>
        <ul>
            <li>Add a development domain.</li>
            <li>Generate your <b>Google Tag Manager Workspace</b> ready to be imported.</li>
            <li>Configure the <b>Google Consent</b>.</li>
            <li><b>Send lost conversions</b> through our server.</li>
            <li>Visit the "<b>Tutorial</b>" section, where you will find all the information to get FlowyTracking working perfectly.</li>
            <li>And, of course, if you need additional help, you can open a <b>support ticket</b> from the "<b>Support</b>" section.</li>
        </ul>
        <p>Remember that FlowyTracking operates under a small monthly payment, but you have <b>15 days completely free and with no obligation</b> from the creation of your domain. We are confident that you will love our product and quickly see the value it will bring to your store.</p>
        <p><b>We are open</b> to any <b>suggestions</b>, <b>improvements</b>, or <b>feedback</b> you can provide as a customer. Together, we will make FlowyTracking the best SEM product on the market!</p></div>',
                )
            );

            return $fields;

        }
        public function get_fields() {
            $this->document->addStyle($this->api_url.'resources/opencart/css/tab_general.css?'.date('Ymdhis'));
            //$this->document->addScript($this->api_url.'resources/opencart/js/tab_general.js?'.date('Ymdhis'));

            $fields = array(
                array(
                    'text' => '<img class="tag_icon_legend" src="'.$this->api_url.'resources/opencart/img/icons/gtm.png">'.$this->_lang('legend_general'),
                    'type' => 'legend',
                ),

                array(
                    'label' => $this->_lang('status'),
                    'type' => 'boolean',
                    'help_bottom' => $this->_lang('help'),
                    'name' => 'tag_manager_status',
                    'class_container' => 'toogle_main_field',
                    'after' => '<input type="hidden" name="flowy_tracking_google_version" value="'.$this->_lang('extension_version').'">',
                ),

                array(
                    'label' => $this->_lang('container_id'),
                    'help' => $this->_lang('container_id_help'),
                    'type' => 'text',
                    'class_container' => 'toogle_seconday_field '.$this->extension_group_config.'_tag_manager_status',
                    'name' => 'container_id',
                ),

                array(
                    'text' => '<img class="tag_icon_legend" src="'.$this->api_url.'resources/opencart/img/icons/gaee.png">'.$this->_lang('google_analytics_ee_legend'),
                    'type' => 'legend',
                ),

                array(
                    'label' => $this->_lang('google_ee_product_id_like'),
                    'help' => $this->_lang('google_ee_product_id_like_help'),
                    'type' => 'select',
                    'options' => $this->product_identificators,
                    'name' => 'google_ee_product_id_like',
                ),

                /*array(
                    'label' => $this->_lang('multichannel_funnel'),
                    'help_bottom' => $this->_lang('multichannel_funnel_help'),
                    'type' => 'boolean',
                    'name' => 'multichannel_funnel_status',
                    'class_container' => 'toogle_main_field',
                ),

                array(
                    'label' => $this->_lang('multichannel_step_1'),
                    'type' => 'select',
                    'options' => $this->actions_ee_multichannel,
                    'name' => 'multichannel_step_1',
                    'default' => 'visit_product_page',
                    'class_container' => 'toogle_seconday_field '.$this->extension_group_config.'_multichannel_funnel_status',
                ),

                array(
                    'label' => $this->_lang('multichannel_step_2'),
                    'type' => 'select',
                    'options' => $this->actions_ee_multichannel,
                    'name' => 'multichannel_step_2',
                    'default' => 'add_to_cart',
                    'class_container' => 'toogle_seconday_field '.$this->extension_group_config.'_multichannel_funnel_status',
                ),

                array(
                    'label' => $this->_lang('multichannel_step_3'),
                    'type' => 'select',
                    'options' => $this->actions_ee_multichannel,
                    'name' => 'multichannel_step_3',
                    'default' => 'visit_cart_page',
                    'class_container' => 'toogle_seconday_field '.$this->extension_group_config.'_multichannel_funnel_status',
                ),

                array(
                    'label' => $this->_lang('multichannel_step_4'),
                    'type' => 'select',
                    'options' => $this->actions_ee_multichannel,
                    'name' => 'multichannel_step_4',
                    'default' => 'visit_checkout_page',
                    'class_container' => 'toogle_seconday_field '.$this->extension_group_config.'_multichannel_funnel_status',
                ),

                array(
                    'label' => $this->_lang('multichannel_step_5'),
                    'type' => 'select',
                    'options' => $this->actions_ee_multichannel,
                    'name' => 'multichannel_step_5',
                    'default' => 'finish_order',
                    'class_container' => 'toogle_seconday_field '.$this->extension_group_config.'_multichannel_funnel_status',
                ),*/

                array(
                    'text' => '<img class="tag_icon_legend" src="'.$this->api_url.'resources/opencart/img/icons/gads.png">'.$this->_lang('google_ads_legend'),
                    'type' => 'legend',
                ),

                array(
                    'label' => $this->_lang('google_product_id_like'),
                    'help' => $this->_lang('google_product_id_like_help'),
                    'type' => 'select',
                    'options' => $this->product_identificators,
                    'name' => 'google_product_id_like',
                ),

                array(
                    'label' => $this->_lang('dynamic_remarketing_dynx2'),
                    'type' => 'select',
                    'options' => array(
                        'product_id' => $this->_lang('dynamic_remarketing_dynx2_product_id'),
                        'model' => $this->_lang('dynamic_remarketing_dynx2_model'),
                        'sku' => $this->_lang('dynamic_remarketing_dynx2_sku'),
                        'upc' => $this->_lang('dynamic_remarketing_dynx2_upc'),
                        'ean' => $this->_lang('dynamic_remarketing_dynx2_ean'),
                        'jan' => $this->_lang('dynamic_remarketing_dynx2_jan'),
                        'isbn' => $this->_lang('dynamic_remarketing_dynx2_isbn'),
                        'mpn' => $this->_lang('dynamic_remarketing_dynx2_mpn'),
                        'location' => $this->_lang('dynamic_remarketing_dynx2_location'),
                    ),
                    'value' => $this->config->get('google_dynamic_remarketing_dynx2'),
                    'name' => 'dynamic_remarketing_dynx2',
                ),

                array(
                    'text' => '<img class="tag_icon_legend" src="'.$this->api_url.'resources/opencart/img/icons/greviews.png">'.$this->_lang('google_reviews_legend'),
                    'type' => 'legend',
                ),
                array(
                    'label' => $this->_lang('google_reviews_gtin'),
                    'help' => $this->_lang('google_reviews_gtin_help'),
                    'type' => 'select',
                    'options' => array(
                        '' => $this->_lang('google_reviews_gtin_none'),
                        'mpn' => $this->_lang('google_reviews_gtin_mpn'),
                        'model' => $this->_lang('google_reviews_gtin_model'),
                        'ean' => $this->_lang('google_reviews_gtin_ean'),
                        'upc' => $this->_lang('google_reviews_gtin_upc'),
                    ),
                    'name' => 'google_reviews_gtin'
                ),

                array(
                    'text' => '<img class="tag_icon_legend" src="'.$this->api_url.'resources/opencart/img/icons/facebook_pixel.jpg">'.$this->_lang('fb_pixel_legend'),
                    'type' => 'legend',
                ),

                array(
                    'label' => $this->_lang('google_product_id_like'),
                    'help' => $this->_lang('google_product_id_like_help'),
                    'type' => 'select',
                    'options' => $this->product_identificators,
                    'name' => 'fb_pixel_id_like',
                ),


                array(
                    'text' => '<img class="tag_icon_legend" src="'.$this->api_url.'resources/opencart/img/logo_negative.png">'.$this->_lang('another_configuration_legend'),
                    'type' => 'legend',
                ),

                array(
                    'label' => $this->_lang('positive_conversion_status_id'),
                    'help_bottom' => $this->_lang('positive_conversion_status_id_help'),
                    'type' => 'select',
                    'multiple' => true,
                    'options' => $this->order_statuses,
                    'name' => 'positive_conversion_status_id'
                ),

                array(
                    'label' => $this->_lang('custom_url_checkout_cart'),
                    'help_bottom' => $this->_lang('custom_url_checkout_cart_help'),
                    'type' => 'text',
                    'name' => 'custom_url_checkout_cart',
                ),

                array(
                    'label' => $this->_lang('custom_url_checkout_checkout'),
                    'help_bottom' => $this->_lang('custom_url_checkout_checkout_help'),
                    'type' => 'text',
                    'name' => 'custom_url_checkout_checkout',
                ),

                array(
                    'label' => $this->_lang('custom_url_checkout_success'),
                    'help_bottom' => $this->_lang('custom_url_checkout_success_help'),
                    'type' => 'text',
                    'name' => 'custom_url_checkout_success',
                ),

            );

            return $fields;
        }

        public function _send_custom_variables_to_view($variables) {
            return $variables;
        }

        public function _check_ajax_function($function_name) {
            if($function_name == 'ajax_generate_conversion') {
                $this->ajax_generate_conversion();
            }
        }

    }
?>