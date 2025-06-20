<?php
class ControllerExtensionModuleFlowyTracking extends Controller
{
    private $error = array();

    private $data_to_view = array();

    public function __construct($registry)
    {
        //Call to parent __construct
            parent::__construct($registry);

        //<editor-fold desc="Fix for old configuration">
            $code = version_compare(VERSION, '2', '>=') ? 'code' : 'group';
            $old_settings = $this->db->query('SELECT * FROM '.DB_PREFIX.'setting WHERE `'.$code.'` = "google"');
            if($old_settings->num_rows) {
                foreach ($old_settings->rows as $key => $setting) {
                    $key = $setting['key'];
                    $new_key = explode('_', $key);
                    $new_key[0] = 'flowy_tracking';
                    $new_key = implode('_', $new_key);
                    $this->db->query('UPDATE '.DB_PREFIX.'setting SET `'.$code.'` = "flowy_tracking", `key` = "'.$new_key.'" WHERE setting_id = '.$setting['setting_id']);
                }
            }
        //</editor-fold>

        //<editor-fold desc="Load basic data">
            $this->is_mijoshop = class_exists('MijoShop');

            if($this->is_mijoshop) {
                $app = JFactory::getApplication();
                $prefix = $app->get('dbprefix');
                $this->db_prefix = $prefix . 'mijoshop_';
            }
            else
                $this->db_prefix = DB_PREFIX;

            $this->extension_type = 'module';
            $this->real_extension_type = (version_compare(VERSION, '2.3', '>=') ? 'extension/':'').$this->extension_type;

            $this->extension_url_cancel_oc_15x = 'common/home';
            $this->extension_url_cancel_oc_2x = 'common/dashboard';

            $this->extension_name = 'flowy_tracking';
            $this->extension_group_config = 'flowy_tracking';

            $this->oc_version = version_compare(VERSION, '3.0.0.0', '>=') ? 3 : (version_compare(VERSION, '2.0.0.0', '>=') ? 2 : 1);
            $this->is_oc_3x = $this->oc_version >= 3;
            $this->is_ocstore = is_dir(DIR_APPLICATION . 'controller/octeam_tools');

            $this->data_to_view = array(
                'button_apply_allowed' => true,
                'button_save_allowed' => false,
                'extension_name' => $this->extension_name,
                'license_id' => $this->config->get($this->extension_group_config.'_license_id') ? $this->config->get($this->extension_group_config.'_license_id') : '',
                'oc_version' => $this->oc_version
            );

            $this->license_id = $this->config->get($this->extension_group_config.'_license_id') ? $this->config->get($this->extension_group_config.'_license_id') : '';
            $this->form_file_path = str_replace('system/', '', DIR_SYSTEM).$this->extension_name.'_form.txt';
            $this->form_file_url = HTTP_CATALOG.$this->extension_name.'_form.txt';

            $this->token_name = version_compare(VERSION, '3.0.0.0', '<') ? 'token' : 'user_token';

            $this->token = $this->session->data[$this->token_name];
            $this->extension_view = version_compare(VERSION, '3.0.0.0', '<') ? $this->extension_name.'.tpl' : $this->extension_name;

            $this->api_url = defined('FLOWYTRACKING_SERVER_TEST') ? FLOWYTRACKING_SERVER_TEST : 'https://dash.flowytracking.com/';
            $this->isdemo =  strpos($_SERVER['HTTP_HOST'], 'flowytracking.com') !== false;
            $this->hasFilters = version_compare(VERSION, '1.5.4', '>');
            $this->hasCustomerDescriptions = version_compare(VERSION, '1.5.2.1', '>');
            $this->table_seo = $this->is_oc_3x ? 'seo_url' : 'url_alias';
            $this->image_path = version_compare(VERSION, '2', '<') ? 'data/' : 'catalog/';

            $this->load->language($this->real_extension_type.'/'.$this->extension_name);
            $this->load->language($this->real_extension_type.'/'.$this->extension_name.'_general_texts');

            $this->load->model('extension/flowytracking/tools');

            $this->load->model('extension/module/'.$this->extension_name);
            $this->load->model('extension/module/'.$this->extension_name.'_tab_general');
            $this->main_model = 'model_extension_module_'.$this->extension_name;
            $this->load->language($this->real_extension_type.'/'.$this->extension_name.'_tab_general');

        //</editor-fold>

        //<editor-fold desc="Load form basic data">
            $this->use_session_form = !$this->is_oc_3x;
            $this->form_token_name = 'flowytracking_form_token_'.$this->extension_group_config;
            $this->form_session_name = 'flowytracking_form_'.$this->extension_group_config;

            //Is the first time that configure extension?
                $this->setting_group_code = version_compare(VERSION, '2.0.1.0', '>=') ? 'code' : '`group`';
                $results = $this->db->query('SELECT setting_id FROM '. $this->db_prefix . 'setting WHERE '.$this->setting_group_code.' = "'.$this->extension_group_config.'" AND `key` NOT LIKE "%license_id%" LIMIT 1');
                $this->first_configuration = empty($results->row['setting_id']);
            //END

            $this->load->model('extension/flowytracking/tools');

            //Devman Extensons - info@flowytracking.com - 2016-10-09 19:39:52 - Load languages
                $this->load->model('localisation/language');
                $languages = $this->model_localisation_language->getLanguages();
                $this->langs = $this->model_extension_flowytracking_tools->formatLanguages($languages);
            //END

            //Devman Extensions - info@flowytracking.com - 2017-08-29 19:25:03 - Get customer groups
                $customer_groups = $this->model_extension_flowytracking_tools->getCustomerGroups();
                $this->cg = $customer_groups;
            //END

            $this->stores = $this->model_extension_flowytracking_tools->getStores();

            $this->multistore_config = true;

            $this->oc_2 = version_compare(VERSION, '2.0.0.0', '>=') || version_compare(VERSION, '2.0.0.0', '<');
            $this->oc_3 = version_compare(VERSION, '3.0.0.0', '>=');

            $form_basic_datas = array(
                'is_ocstore' => $this->is_ocstore,
                'tab_changelog' => true,
                'tab_help' => true,
                //'tab_faq' => true,
                'first_configuration' => $this->first_configuration,
                'positions' => $this->positions,
                'statuses' => $this->statuses,
                'stores' => $this->stores,
                'layouts' => $this->layouts,
                'languages' => $this->langs,
                'oc_version' => $this->oc_version,
                'oc_2' => $this->oc_2,
                'oc_3' => $this->oc_3,
                'customer_groups' => $this->cg,
                'version' => version_compare(VERSION, '2', '<') ? 2 : VERSION,
                'extension_version' => $this->language->get('extension_version'),
                'token' => $this->token,
                'extension_group_config' => $this->extension_group_config,
                'no_image_thumb' => $this->no_image_thumb,
                'lang' => array(
                    'choose_store' => $this->language->get('choose_store'),
                    'text_browse' => $this->language->get('text_browse'),
                    'text_clear' => $this->language->get('text_clear'),
                    'text_sort_order' => $this->language->get('text_sort_order'),
                    'text_clone_row' => $this->language->get('text_clone_row'),
                    'text_remove' => $this->language->get('text_remove'),
                    'text_add_module' => $this->language->get('text_add_module'),
                    'tab_help' => $this->language->get('tab_help'),
                    'tab_changelog' => $this->language->get('tab_changelog'),
                    'tab_faq' => $this->language->get('tab_faq'),
                ),
            );

            $this->form_basic_datas = $form_basic_datas;
        //</editor-fold>

        if ($this->request->get['route'] == $this->real_extension_type.'/'.$this->extension_name)
            $this->form_array = $this->_construct_view_form();
    }

    public function index(){
        $this->install();
        $this->_check_ajax_function();
        $this->document->setTitle($this->language->get('heading_title_2'));
        $this->_get_breadcrumbs();
        $this->_check_post_data();

        //Send token to view
            $this->data_to_view['token'] = $this->session->data[$this->token_name];
            $this->data_to_view['action'] = $this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL');
            $this->data_to_view['cancel'] = $this->url->link(version_compare(VERSION, '2.0.0.0', '>=') ? $this->extension_url_cancel_oc_2x : $this->extension_url_cancel_oc_15x, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL');

        $this->_load_basic_languages();
        $this->data_to_view['form'] = $this->model_extension_flowytracking_tools->_get_form_in_settings();

        $this->_check_errors_to_send();
        $this->_send_custom_variables_to_view();

        if(version_compare(VERSION, '2.0.0.0', '>='))
        {
            $data = $this->data_to_view;
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view($this->real_extension_type.'/'.$this->extension_view, $data));
        }
        else
        {
            $document_scripts = $this->document->getScripts();
            $scripts = array();
            foreach ($document_scripts as $key => $script)
                $scripts[] = $script;
            $this->data_to_view['scripts'] = $scripts;

            $document_styles = $this->document->getStyles();
            $styles = array();
            foreach ($document_styles as $key => $style)
                $styles[] = $style;
            $this->data_to_view['styles'] = $styles;

            $this->data = $this->data_to_view;
            $this->template = $this->real_extension_type.'/'.$this->extension_view;

            $this->response->setOutput($this->render());
        }
    }

    public function _check_post_data() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->{$this->main_model}->validate_permiss()) {
            $no_exit = !empty($this->request->post['no_exit']) ? 1 : 0;
            $this->session->data['error'] = '';

            //Devman Extensions - info@flowytracking.com - 2016-10-21 18:57:30 - Custom functions
                if(
                    !empty($this->request->post['force_function']) || !empty($this->request->get['force_function'])
                    ||
                    !empty($this->request->post[$this->extension_group_config.'_force_function']) || !empty($this->request->get[$this->extension_group_config.'force_function'])
                )
                {
                    if(!empty($this->request->post['force_function']) || !empty($this->request->get['force_function']))
                        $index = 'force_function';
                    else
                        $index = $this->extension_group_config.'_force_function';

                    $post_get = !empty($this->request->post[$index]) ? 'post' : 'get';
                    $this->{$this->request->{$post_get}[$index]}();
                }
            //END

            unset($this->request->post['no_exit']);

            //Serialize multiples field from table inputs
                foreach ($this->request->post as $input_name => $data_post) {
                    if(is_array($data_post) && isset($data_post['replace_by_number']))
                    {
                        unset($data_post['replace_by_number']);

                        if(empty($data_post))
                            $this->request->post[$input_name] = '';
                        else
                            $this->request->post[$input_name] = base64_encode(serialize(array_values($data_post)));
                    }
                }
            //END Serialize multiples field from table inputs

            $error = $this->_test_before_save();

            if(!$error)
            {
                $this->load->model('setting/setting');
                $this->model_setting_setting->editSetting($this->extension_group_config, $this->request->post);

                if(!empty($no_exit))
                {
                    $array_return = array(
                        'error' => false,
                        'message' => $this->language->get('text_success')
                    );
                    echo json_encode($array_return); die;
                }
                else
                    $this->session->data['success'] = $this->language->get('text_success');

                $after_save_temp = version_compare(VERSION, '2.0.0.0', '>=') ? $this->extension_url_after_save_oc_20x : $this->extension_url_after_save_oc_15x;
                $after_save_temp = version_compare(VERSION, '2.3.0.0', '>=') ? $this->extension_url_after_save_oc_23x : $after_save_temp;

                if(version_compare(VERSION, '2.0.0.0', '>='))
                    $this->response->redirect($this->url->link($after_save_temp, $this->token_name.'=' . $this->token, 'SSL'));
                else
                    $this->redirect($after_save_temp, $this->token_name.'=' . $this->token, 'SSL');
            }
            else
            {
                if(!empty($no_exit))
                {
                    $array_return = array(
                        'error' => true,
                        'message' => $error
                    );
                    echo json_encode($array_return); die;
                }
                else
                    $this->session->data['error'] = $error;

                if(version_compare(VERSION, '2.0.0.0', '>='))
                    $this->response->redirect($this->url->link($this->extension_url_after_save_error, $this->token_name.'=' . $this->token, 'SSL'));
                else
                    $this->redirect($this->extension_url_after_save_error, $this->token_name.'=' . $this->token, 'SSL');
            }
        }
    }

    public function _check_ajax_function() {
        if(
            !empty($this->request->post['ajax_function']) || !empty($this->request->get['ajax_function'])
            ||
            !empty($this->request->post[$this->extension_group_config.'_ajax_function']) || !empty($this->request->get[$this->extension_group_config.'ajax_function'])
        )
        {
            if(!empty($this->request->post['ajax_function']) || !empty($this->request->get['ajax_function']))
                $index = 'ajax_function';
            else
                $index = $this->extension_group_config.'_force_function';

            $post_get = !empty($this->request->post[$index]) ? 'post' : 'get';
            $function_name = $this->request->{$post_get}[$index];

            if($function_name == 'xxxxx') {

            }

            $this->model_extension_module_flowy_tracking_tab_general->_check_ajax_function($function_name);
            $this->{$function_name}();
        }
    }

    public function _get_breadcrumbs() {
        $this->data_to_view['breadcrumbs'] = array();
        $this->data_to_view['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'),
            'separator' => false
        );

        $this->data_to_view['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_2'),
            'href'      => $this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'),
            'separator' => ' :: '
        );
    }

    public function _add_css_js_to_document() {
        //Add scripts and css
            if(version_compare(VERSION, '2.0.0.0', '<'))
            {
                $this->document->addScript($this->api_url.'resources/opencart/common/js/jquery-2.1.1.min.js?'.date('Ymdhis'));
                $this->document->addScript($this->api_url.'resources/opencart/common/js/bootstrap.min.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'resources/opencart/common/css/bootstrap.min.css?'.date('Ymdhis'));

                $this->document->addScript($this->api_url.'resources/opencart/common/js/datetimepicker/moment.js?'.date('Ymdhis'));
                $this->document->addScript($this->api_url.'resources/opencart/common/js/datetimepicker/bootstrap-datetimepicker.min.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'resources/opencart/common/css/bootstrap-datetimepicker.min.css?'.date('Ymdhis'));
            }

            $this->document->addStyle($this->api_url.'resources/opencart/common/css/colpick.css?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'resources/opencart/common/css/bootstrap-select.min.css?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'resources/opencart/common/js/colpick.js?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'resources/opencart/common/js/bootstrap-select.min.js?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'resources/opencart/common/js/tools.js?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'resources/opencart/common/css/license_form.css?'.date('Ymdhis'));

            $this->document->addStyle($this->api_url.'resources/opencart/common/js/remodal/remodal.css?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'resources/opencart/common/js/remodal/remodal-default-theme.css?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'resources/opencart/common/js/remodal/remodal-default-theme-override.css?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'resources/opencart/common/js/remodal/remodal.min.js?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'resources/opencart/common/js/remodal/remodal-improve.js?'.date('Ymdhis'));

            if(version_compare(VERSION, '2.0.0.0', '>='))
            {
                $this->document->addScript($this->api_url.'resources/opencart/common/js/oc2x.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'resources/opencart/common/css/oc2x.css?'.date('Ymdhis'));
            }
            else
            {
                $this->document->addScript($this->api_url.'resources/opencart/common/js/oc2x.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'resources/opencart/common/css/oc2x.css?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'resources/opencart/common/css/oc15x.css?'.date('Ymdhis'));
                $this->document->addScript('view/javascript/ckeditor/ckeditor.js?'.date('Ymdhis'));
                $this->document->addStyle('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?'.date('Ymdhis'));
            }

            if(version_compare(VERSION, '2.0.0.0', '>=')) {
                $this->document->addScript('view/javascript/summernote/summernote.js');
                $this->document->addStyle('view/javascript/summernote/summernote.css');
                $this->document->addScript('view/javascript/summernote/opencart.js');
            } else if(version_compare(VERSION, '2', '<')) {
                $this->document->addScript($this->api_url.'resources/opencart/common/js/common_oc2x_compatibility.js');
                $this->document->addScript($this->api_url.'resources/opencart/common/summernote/summernote.js');
                $this->document->addStyle($this->api_url.'resources/opencart/common/summernote/summernote.css');
                $this->document->addScript($this->api_url.'resources/opencart/common/summernote/opencart.js');
            }
        //END Add scripts and css

        $this->document->addStyle($this->api_url.'resources/opencart/css/general.css?'.date('Ymdhis'));
    }

    public function _check_errors_to_send() {
        if(version_compare(VERSION, '3.0.0.0', '>='))
        {
            if(!empty($this->session->data['error']))
            {
                $this->data_to_view['error_warning_2'] = $this->session->data['error'];
                unset($this->session->data['error']);
            }

            if(array_key_exists('new_version', $this->session->data) && !empty($this->session->data['new_version']))
            {
                $this->data_to_view['new_version'] = $this->session->data['new_version'];
                unset($this->session->data['new_version']);
            }

            if(!empty($this->session->data['error_expired']))
            {
                $this->data_to_view['error_warning_expired'] = $this->session->data['error_expired'];
                unset($this->session->data['error_expired']);
            }

            if(!empty($this->session->data['success']))
            {
                $this->data_to_view['success_message'] = $this->session->data['success'];
                unset($this->session->data['success']);
            }

            if(!empty($this->session->data['info']))
            {
                $this->data_to_view['info_message'] = $this->session->data['info'];
                unset($this->session->data['info']);
            }
        }
    }

    public function _load_basic_languages() {
        $lang_array = array(
            'heading_title_2',
            'button_save',
            'button_cancel',
            'apply_changes',
            'text_image_manager',
            'text_browse',
            'text_clear',
            'image_upload_description',
            'text_validate_license',
            'text_license_id',
            'text_send',
        );

        foreach ($lang_array as $key => $value) {
            $this->data_to_view[$value] = $this->language->get($value);
        }

        $this->data_to_view['heading_title'] = $this->language->get('heading_title');
    }

    public  function _redirect($url) {
        if(version_compare(VERSION, '2.0.0.0', '>='))
            $this->response->redirect($this->url->link($url, $this->token_name.'=' . $this->session->data[$this->token_name]));
        else
            $this->redirect($this->url->link($url, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
    }

    public function _send_custom_variables_to_view() {
        $jquery_variables = array();

        $jquery_variables = array(
            'token' => $this->session->data[$this->token_name],
            'token_name' => $this->token_name,
            'action' => html_entity_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'link_ajax_get_form' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=ajax_get_form', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
        );

        $jquery_variables = $this->model_extension_module_flowy_tracking_tab_general->_send_custom_variables_to_view($jquery_variables);

        $this->data_to_view['jquery_variables'] = $jquery_variables;
    }

    public function _construct_view_form() {
        $this->_add_css_js_to_document();


        $endpoint = 'https://dash.flowytracking.com/domains/check';
        $jsonData = '{"domain": "'.HTTPS_CATALOG.'"}';

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        $domain_valid = curl_exec($ch);
        curl_close($ch);

        $form_view = array(
            'action' => $this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'),
            'id' => $this->extension_name,
            'extension_name' => $this->extension_name,
            'columns' => 1,
            'multi_store' => $domain_valid ? $this->multistore_config : false,
            'tabs' => array(
                $this->language->get('tab_general') => array(
                    'icon' => '<i class="fa fa-cog"></i>',
                    'fields' => $domain_valid ? $this->model_extension_module_flowy_tracking_tab_general->get_fields() : $this->model_extension_module_flowy_tracking_tab_general->get_no_valid_domain_text(),
                ),
            )
        );

        
        $form_view = $this->model_extension_flowytracking_tools->_get_form_values($form_view);
        

        return $form_view;
    }

    public function _test_before_save() {
        if(version_compare(VERSION, '3', '>=')) {
            if($this->multistore_config) {
                foreach ($this->stores as $key => $store) {
                    $this->insert_module_status_oc3x($store['store_id']);
                }
            } else {
                $this->insert_module_status_oc3x();
            }
        }

        foreach ($this->request->post as $key => $data) {
            if (strpos($key, 'flowy_tracking_feed_config_') !== false)
                unset($this->request->post[$key]);
        }

        return false;
    }

    function insert_module_status_oc3x($store_id = false) {
        $status = '_tag_manager_status'.(is_numeric($store_id) ? '_'.$store_id : '');
        $status_post_index = $this->extension_group_config.$status;
        $status = array_key_exists($status_post_index, $this->request->post) && !empty($this->request->post[$status_post_index]);
        $code = 'module_' . $this->extension_name;
        $key = $code . '_status';
        $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE `code` = '" . $code . "' AND `key` = '" . $key . "'".(is_numeric($store_id) ? " AND `store_id` = ".$store_id : '').";");

        if ($status) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET `code` = '" . $code . "', `key` = '" . $key . "', `value` = 1".(is_numeric($store_id) ? " , `store_id` = ".$store_id  : '' ).";");
        }
    }

    public function ajax_get_form($license_id = '') {
        $this->model_extension_flowytracking_tools->ajax_get_form($license_id);
    }

    public function install() {
        if (!$this->model_extension_flowytracking_tools->checkColumnExists( 'order', 'ft_tracking'))
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD COLUMN `ft_tracking` tinyint(1) NOT NULL DEFAULT '1';");
    }
}
