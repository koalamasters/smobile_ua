<?php

class ControllerExtensionModuleMonoCheckout extends Controller
{
    private $error = array();

    public function index()
    {
        // something clear
    }

    public function getButton($path)
    {
        $status = $this->config->get('module_mono_checkout_status');
        if (!$status) return false;

        $this->load->language($this->version20() ? 'module/mono_checkout' : 'extension/module/mono_checkout');

        $data['buttonType'] = $this->config->get('module_mono_checkout_button') ?: 'black';
        $color = explode('_', $data['buttonType'])[0];
        $data['logo_color'] = $color == 'black' ? 'white' : 'black';
        $data['path'] = $path;

        switch ($path) {
            case 'product_page':
                $data['size_w'] = $this->config->get('module_mono_checkout_product_show_size_w');
                $data['size_h'] = $this->config->get('module_mono_checkout_product_show_size_h');
                break;
            case 'cart_page':
                $data['size_w'] = $this->config->get('module_mono_checkout_cart_show_size_w');
                $data['size_h'] = $this->config->get('module_mono_checkout_cart_show_size_h');
                break;
            default:
                $data['size_w'] = $this->config->get('module_mono_checkout_cart_popup_show_size_w');
                $data['size_h'] = $this->config->get('module_mono_checkout_cart_popup_show_size_h');
                break;
        }

        if ($this->version23()) {
            $data['button_text'] = $this->language->get('button_text');
        }

        if (version_compare(VERSION, '2.0.3.1', '<=')) {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/mono_checkout_button.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/module/mono_checkout_button.tpl', $data);
            } else {
                return $this->load->view('default/template/module/mono_checkout_button.tpl', $data);
            }
        } else {
            return $this->load->view($this->version20() ? '/module/mono_checkout_button' : 'extension/module/mono_checkout_button', $data);
        }

    }

    public function addOrder()
    {
        if (!$this->cart->getProducts()) return json_encode(['result' => false]);

        $path = $this->version20() ? 'module/mono_checkout' : 'extension/module/mono_checkout';
        $modelRoute = $this->version20() ? 'model_module_mono_checkout' : 'model_extension_module_mono_checkout';
        $this->load->language($path);
        $this->load->model($path);
        $this->load->model('catalog/product');


        // addOrder
        $order_data['products'] = [];
        foreach ($this->cart->getProducts() as $product) {
            $option_data = [];

            foreach ($product['option'] as $option) {
                $option_data[] = array(
                    'product_option_id' => $option['product_option_id'],
                    'product_option_value_id' => $option['product_option_value_id'],
                    'option_id' => $option['option_id'],
                    'option_value_id' => $option['option_value_id'],
                    'name' => $option['name'],
                    'value' => $option['value'],
                    'type' => $option['type']
                );
            }

            $order_data['products'][] = array(
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'model' => $product['model'],
                'option' => $option_data,
                'download' => $product['download'],
                'quantity' => $product['quantity'],
                'subtract' => $product['subtract'],
                'price' => $product['price'],
                'total' => $product['total'],
                'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                'reward' => $product['reward']
            );
        }

        if (version_compare(VERSION, '2.0.3.1', '>')) {
            $totals = [];
            $taxes = $this->cart->getTaxes();
            $total = 0;
            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            );
            if ($this->version23()) {
                $this->load->model('extension/extension');
                $sort_order = [];
                $results = $this->model_extension_extension->getExtensions('total');
            } else {
                $this->load->model('setting/extension');
                $sort_order = [];
                $results = $this->model_setting_extension->getExtensions('total');
            }


            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get(($this->version20() ? '' : 'total_') . $value['code'] . '_sort_order');
            }
            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get(($this->version23() ? '' : 'total_') . $result['code'] . '_status')) {

                    if ($this->version20()) {
                        $this->load->model('total/' . $result['code']);
                        $this->{'model_total_' . $result['code']}->getTotal($total_data);
                    } else {
                        $this->load->model('extension/total/' . $result['code']);
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }
            }
            $sort_order = [];
            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }
            array_multisort($sort_order, SORT_ASC, $totals);

            $order_data['totals'] = $totals;
            $order_data['total'] = $total_data['total'];

        } else {
            $order_data['totals'] = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('total/' . $result['code']);

                    $this->{'model_total_' . $result['code']}->getTotal($order_data['totals'], $total, $taxes);
                }
            }

            $sort_order = array();

            foreach ($order_data['totals'] as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $order_data['totals']);

            $order_data['total'] = $total;
        }

        $order_data['language_id'] = $this->config->get('config_language_id');
        $order_data['store_id'] = $this->config->get('config_store_id');
        $order_data['store_name'] = $this->config->get('config_name');
        $order_data['store_url'] = $this->config->get('config_url');
        $order_data['customer_id'] = $this->customer->isLogged() ? $this->customer->getId() : 0;
        $order_data['customer_group_id'] = $this->customer->isLogged() ? $this->customer->getGroupId() : 1;
        $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
        $order_data['currency_code'] = $this->session->data['currency'];
        $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
        $this->session->data['guest']['firstname'] = '';
        $this->session->data['guest']['lastname'] = '';
        $this->session->data['order_id'] = $this->{$modelRoute}->addOrder($order_data);

        // json for monocheckout
        $json = [];
        $json['order_ref'] = $this->session->data['order_id'] .'-'. time();
        $cart = $this->cart->getProducts();
        $products = [];
        foreach ($cart as $product) {
            $product_info = $this->model_catalog_product->getProduct($product['product_id']);
            $product_option_string = '';

            if (isset($product['option']) && count($product['option'])) {
                $product_option_string = ' -';

                foreach ($product['option'] as $option) {
                    $product_option_string .= ' ' . $option['value'];
                }
            }

            $products[] = [
                'code_product' => $product_info['sku'] ?: $product_info['model'],
                'name' => $product['name'] . $product_option_string,
                'cnt' => round($product['quantity']),
                'price' => (float)$this->tax->calculate(preg_replace('/[^0-9.]/', '', $this->currency->format($product['price'], $this->session->data['currency'])), $product['tax_class_id'], $this->config->get('config_tax'))
            ];
        }

        $json['products'] = $products;
        $json['amount'] = (float)preg_replace('/[^0-9.]/', '', $this->currency->format($order_data['total'], $this->session->data['currency']));
        $json['count'] = round($this->cart->countProducts());
        $json['payments_number'] = max(3, min(25, (int)$this->config->get('module_mono_checkout_payments_number')));

        switch ($this->session->data['currency']) {
            case 'USD':
                $json['ccy'] = 840;
                break;
            case 'EUR':
                $json['ccy'] = 978;
                break;
            default:
                $json['ccy'] = 980;
        }

        $url = HTTP_SERVER . 'index.php?route=';
        if ($this->request->server['HTTPS']) {
            $url = HTTPS_SERVER . 'index.php?route=';
        }

        $json['callback_url'] = $url . ($this->version20() ? 'module/mono_checkout/callback' : 'extension/module/mono_checkout/callback');
        $json['return_url'] = $url . 'checkout/success';
        $json['dlv_method_list'] = $this->config->get('module_mono_checkout_delivery');
        $json['dlv_pay_merchant'] = (int)$this->config->get('module_mono_checkout_merchant_user');
        $json['payment_method_list'] = $this->config->get('module_mono_checkout_payment');

		// DEBUG
		/*
		$handle = fopen(dirname(__FILE__).'/salesdrive_log.txt', "a");
		$date = date('m/d/Y h:i:s a', time());
		ob_start();
		print($date.". ".$_SERVER['REMOTE_ADDR']."\n");

		print("json:\n");
		print_r($json);

		$htmlStr = ob_get_contents()."\n";
		ob_end_clean(); 
		fwrite($handle,$htmlStr);	
		*/		

        $curl = curl_init();


        file_put_contents(DIR_ROOT.'mono_checkout_debug.log', print_r($json,1)."\n", 8);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.monobank.ua/personal/checkout/order/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_HTTPHEADER => array(
                'X-Token: ' . $this->config->get('module_mono_checkout_token'),
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (isset($response["errorDescription"])) {
            $this->log->write("Mono Checkout: " . $response["errorDescription"]);
            $response = ['result' => false, 'message' => $this->language->get('response_error')];
        } elseif (isset($response["errCode"])) {
            $this->log->write("Mono Checkout: " . $response["errText"]);
            $response = ['result' => false, 'message' => $this->language->get('response_error')];
        } elseif (isset($response["result"]) && $response["result"]['redirect_url']) {
            $this->{$modelRoute}->addMonoOrderID($this->session->data['order_id'], $response["result"]['order_id']);
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    public function prepareForItem()
    {
        $this->cart->clear();
        unset($this->session->data['order_id']);
        return true;
    }

    public function callback()
    {
        $request = file_get_contents('php://input');

        if (!$request) {
            die('No access!');
        }
        $this->log->write('Mono Checkout callback request');

        $modelRoute = $this->version20() ? 'model_module_mono_checkout' : 'model_extension_module_mono_checkout';
        $data = json_decode($request);
        $data->payment_method_desc .= ' (mono)';
        // file_put_contents('/home/smobile/public_html/mono_test.txt', print_r($data, 1) . "\n", 8);
        $this->load->model($this->version20() ? 'module/mono_checkout' : 'extension/module/mono_checkout');
        $this->load->model('checkout/order');
        $this->load->language($this->version20() ? 'module/mono_checkout' : 'extension/module/mono_checkout');

        if (isset($data->clientCallback)) {
            $data->order_comment = $data->clientCallback ? $this->language->get('comment_need_a_call') : $this->language->get('comment_not_need_a_call');
        } else {
            $data->order_comment = null;
        }
        $data->order_email = isset($data->mainClientInfo->email) && $data->mainClientInfo->email ? $data->mainClientInfo->email : $this->generateRandomEmail($this->getDomain());

        $order_mono_id = $data->orderId;
        $order_id = $this->{$modelRoute}->updateOrder($order_mono_id, $data);
        if (!$order_id) return;

        $this->load->model('extension/module/mono_checkout');
        $order_status_id = $this->config->get('module_mono_checkout_status_' . $data->generalStatus) ? $this->config->get('module_mono_checkout_status_' . $data->generalStatus) : $this->config->get('config_order_status_id');

        $this->model_checkout_order->addOrderHistory($order_id, $order_status_id);
    }

    protected function version23()
    {
        return version_compare(VERSION, '3.0', '<');
    }

    protected function version20()
    {
        return version_compare(VERSION, '2.3', '<');
    }

    protected function getDomain()
    {
        $host = $_SERVER['HTTP_HOST'];
        $parsedUrl = parse_url($host);
        return isset($parsedUrl['host']) ? $parsedUrl['host'] : $host;
    }

    protected function generateRandomEmail($domain)
    {
        $randomNumber = rand(100000000, 999999999);
        return "empty" . $randomNumber . "@" . $domain;
    }

}