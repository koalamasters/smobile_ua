<?php
class ControllerCheckoutSuccess extends Controller
{

public function joinValues($dto) {
    $values = array();
    $keys = array(
        'login','frameSecretKey','clientPhone', 'clientMail', 'clientFirstName', 'clientLastName',
        'clientMiddleName','partnerId','subProduct','shopId','gracePeriod', 'initialPaymentAmount'
    );
    $merchandiseKeys = array('code','name','quantity');
    foreach ($keys as $k) {
        if (isset($dto[$k])) {
            array_push($values,$dto[$k]);
        }
    }
    if (isset($dto['merchandises'])) {
        foreach ($dto['merchandises'] as $m) {
            foreach ($merchandiseKeys as $k) {
                if (isset($m[$k])) array_push($values,$m[$k]);
            }
        }
    }
    return implode(':',$values);
}

public function sense_loan_online_widget($args) {
  $type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
  $setting = $this->config->get($type.'ukrcredits_settings');
  $API_URL = 'https://emoney-test.sensebank.kyiv.ua/onlineCreditUniversalApiPartners';
  if ($setting['sb_mode']) $API_URL = $args['apiUrl'];

  $buttonClass = isset($args['buttonClass'])?$args['buttonClass']:"";
  $buttonText = isset($args['buttonText'])?$args['buttonText']:"Кредит від Sense Банк";
  $debug = isset($args['debug']) && $args['debug']===true;
  $values = $this->joinValues($args);
  $token = hash('sha512', $values);

  unset($args["login"]);
  unset($args["frameSecretKey"]);
  unset($args["buttonClass"]);
  unset($args["apiUrl"]);
  unset($args["buttonText"]);
  unset($args["debug"]);
  $debugFragment = "";
  if ($debug) {
      $debugFragment =
        "SENSE_CLIENT.signTemplate = \"$values\"";
  }

  $json = json_encode($args,JSON_UNESCAPED_UNICODE);
  $apiScriptSrc = $API_URL . "/api/external/easy-start.js?partnerId=" . $args['partnerId'];
  echo(
	<<<EOL
	<script onerror="alert('Помилка завантаження. Перезавантажте сторінку через декілька хвилин.')" src="$apiScriptSrc"></script>
	<script>
	    console.log('%cЗупиніться!',"color:red;font-size:25px;");
        console.log(`%cЦя функція браузера призначена для розробників. Якщо хтось сказав вам щось скопіювати і вставити сюди - це шахраї. %cВиконавши ці дії, Ви надасте їм доступ до конфіденційної інформації!`,'font-size:20px','font-size:20px;font-weight:bold');
		var SENSE = window.SENSE || {};
		var SENSE_CLIENT = {
			token: "$token",
			version: 2,
			data: $json
		}
		$debugFragment
            document.addEventListener("DOMContentLoaded", (event)=>{
                SENSE.loanMe();
            }
            );		
	</script>

EOL
  );

}
			
	public function index() {

		if (isset($this->session->data['order_id']) && !empty($this->session->data['order_id']) && isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'ukrcredits_sb') {
			$this->session->data['sb_order_id'] = $this->session->data['order_id'];

			$this->load->model('checkout/order');
			$this->load->model('account/order');
			$this->load->model('catalog/product');

			$sb_order_info = $this->model_checkout_order->getOrder($this->session->data['sb_order_id']);
			$sb_order_products = $this->model_account_order->getOrderProducts($this->session->data['sb_order_id']);
			
			$type = version_compare(VERSION,'3.0','>=') ? 'payment_' : '';
			$setting = $this->config->get($type.'ukrcredits_settings');
			
			$telephone = str_replace(['+','(', ')', '-', ' '], '', $sb_order_info['telephone']);
			if (substr($telephone, 0, 1) == 0) {
			$telephone = '+38' . $telephone;
			} else if (substr($telephone, 0, 2) == 80) {
			$telephone = '+3' . $telephone;
			} else {
			$telephone = '+' . $telephone;	
			}

			$merchandises = array();
			foreach ($sb_order_products as $sb_product) {
				$merchandises[] = array(
					'name' =>		$sb_product['name'],
					'quantity' =>	$sb_product['quantity'],
					'price' =>		number_format($sb_product['price'], 2, '.', ''),
					'code' =>		$sb_product['model']				
				);
			}
	
			$args = array(
				'login'=> 				$setting['sb_login'],
				'frameSecretKey'=>		$setting['sb_frameSecretKey'],
				'merchandises'=>		$merchandises,
				'clientPhone'=>			$telephone,
				'clientFirstName'=>		$sb_order_info['firstname'],
				'clientLastName'=>		$sb_order_info['lastname'],
				'clientMiddleName'=>	'',
				'partnerId'=>			$setting['sb_partnerId'],
				'subProduct'=>			(isset($this->session->data['ukrcredits_sb_sel']) && $this->session->data['ukrcredits_sb_sel'])?$setting['sb_id_data'][$this->session->data['ukrcredits_sb_sel']]:$setting['sb_id_data'][key($setting['sb_id_data'])],
				'gracePeriod'=>			(isset($this->session->data['ukrcredits_sb_sel']) && $this->session->data['ukrcredits_sb_sel'])?$this->session->data['ukrcredits_sb_sel']:3,
				'shopId'=>				$setting['sb_shopId'],
				'invoiceNumber'=>		'INVOICE_NUM_'.$this->session->data['sb_order_id'],
				'invoiceDate'=>			gmdate('Y-m-d', time()),
				'initialPaymentAmount'=>'0',
				'buttonClass'=>			'button sell-button whatever-you-need',
				'buttonText'=>			'SENSE',
				'apiUrl'=>'https://emoney.sensebank.com.ua/onlineCreditUniversalApi'
			);

			$this->sense_loan_online_widget($args);
		}
			



        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

		$this->load->language('checkout/success');
		$this->load->model('checkout/order');


        if(isset($this->session->data['order_id'])){
            $session_order = true;
        }else{
            $session_order = false;
        }

        $data['top_title'] = $this->language->get('top_title');
        $data['top_sub_title'] = $this->language->get('top_sub_title');
        $data['success_name'] = $this->language->get('success_name');
        $data['success_lastname'] = $this->language->get('success_lastname');
        $data['success_email'] = $this->language->get('success_email');
        $data['success_phone'] = $this->language->get('success_phone');
        $data['success_delivery'] = $this->language->get('success_delivery');
        $data['success_delivery_price'] = $this->language->get('success_delivery_price');
        $data['success_special'] = $this->language->get('success_special');
        $data['success_total'] = $this->language->get('success_total');

        $data['usdt_info'] = $this->language->get('usdt_info');

        $data['go_to_my_orders'] = $this->language->get('go_to_my_orders');
        $data['continute_shopping'] = $this->language->get('continute_shopping');



        if(!isset($this->request->get['order_id']) && isset($this->session->data['order_id'])){
            $this->response->redirect($this->url->link('checkout/success', 'order_id=' . $this->session->data['order_id'], true));
        }

        $gtag_succes = '';

        if (isset($this->request->get['order_id'])) {
            $order_id = (int)$this->request->get['order_id'];
        } elseif (isset($this->session->data['order_id'])) {

                    //Flowy Tracking - Saving order to generate code
                        if($this->FTMaster)
                            $this->DataLayer->set_data('order_id', $this->session->data['order_id']);
                    //END Flowy Tracking - Saving order to generate code
                    
            $order_id = (int)$this->session->data['order_id'];
        } else {
            $order_id = 0;
        }

		if (isset($this->session->data['order_id'])) {

                    //Flowy Tracking - Saving order to generate code
                        if($this->FTMaster)
                            $this->DataLayer->set_data('order_id', $this->session->data['order_id']);
                    //END Flowy Tracking - Saving order to generate code
                    

            if(!isset($_COOKIE['order-' . $this->session->data['order_id'] . '-ecc-send'])){
                //$gtag_succes = "<script>gtag_checkout_finished();</script>";
                setcookie('order-' . $this->session->data['order_id'] . '-ecc-send', 1, time() + 2592000, '/');
            }


//			$order_id = $this->session->data['order_id'];

            if (isset($this->request->get['order_id'])) {
                $order_id = (int)$this->request->get['order_id'];
            } elseif (isset($this->session->data['order_id'])) {

                    //Flowy Tracking - Saving order to generate code
                        if($this->FTMaster)
                            $this->DataLayer->set_data('order_id', $this->session->data['order_id']);
                    //END Flowy Tracking - Saving order to generate code
                    
                $order_id = (int)$this->session->data['order_id'];
            } else {
                $order_id = 0;
            }

			// EEC Data START
			$eec_data = [
				'event' => 'purchase',
				'ecommerce' => [
					'currency' => "UAH",
					'value'    => number_format($order['total'], 2),
                    'transaction_id' => $order_id
				],
			];


            $eec_data = [
				'transaction_id' => $order_id,
                'value'    => number_format($order['total'], 2),
                'currency' => "UAH",
			];

			$data['json_eec'] = json_encode($eec_data);
			// EEC Data END



			$this->cart->clear();


			$send_ntf = $this->config->get('module_tlgrm_notification_status');
			$new_order = $this->config->get('module_tlgrm_notification_new_order');
			$tlgrm_send = $this->config->get('module_tlgrm_notification_send');
	
			if ($send_ntf == 1 && $new_order == 1 && isset($tlgrm_send[3])) {
				$this->load->controller('extension/module/tlgrm_notification/messageOrder');
			}
			
//			unset($this->session->data['shipping_method']);
//			unset($this->session->data['shipping_methods']);
//			unset($this->session->data['payment_method']);
//			unset($this->session->data['payment_methods']);
//			unset($this->session->data['guest']);
//			unset($this->session->data['comment']);
//			//unset($this->session->data['order_id']);

        unset($this->session->data['salesagent_id']);
        setcookie('scode', '', time() - 3600 , '/');
        
//			unset($this->session->data['coupon']);
//			unset($this->session->data['reward']);
//			unset($this->session->data['voucher']);
//			unset($this->session->data['vouchers']);
//			unset($this->session->data['totals']);
		}



        $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');

        // Ініціалізація змінної $data['order'] за замовчуванням
        $data['order'] = [];
        $data['orders_link'] = $this->url->link('account/order');
        $data['home_link'] = $this->url->link('common/home');


        $data['logged'] = $this->customer->isLogged();

        $order = $this->model_checkout_order->getOrder($order_id);

  

        if($order && $order['customer_id'] == $this->customer->getId()){
            $data['show_order'] = 1;
        }elseif ($session_order){
            $data['show_order'] = 1;
        }else{
            $data['show_order'] = 0;
        }
        $this->load->model('extension/total/coupon');


        $used_coupon =$this->model_extension_total_coupon->getOrderCouponCode($order_id);


        if ($data['show_order']) {
            // Отримання інформації про замовлення

            $data['order'] = $order;
            $sale_count = 0;
            $admitad_coupon = null;


            $coupon_info =  $this->model_extension_total_coupon->getCoupon($used_coupon);


            if (!empty($coupon_info) && isset($coupon_info['admitad']) && $coupon_info['admitad'] == 1) {
                $admitad_coupon = $coupon_info;
            }

            // Отримання списку товарів із замовлення
            $this->load->model('account/order');
            $data['order']['product_list'] = $this->model_account_order->getOrderProducts($order_id);



            // Admitad Postback
            if (!empty($_COOKIE['admitad_uid'])) {
                $cookie_flag = 'admitad-order-' . $order_id . '-sent';

                if (!isset($_COOKIE[$cookie_flag])) {
                    $uid = htmlspecialchars($_COOKIE['admitad_uid']);
                    $campaign_code = '04c2797e72';
                    $postback_key  = '8a2323a9530d362064Ab86443d5E561A';
                    $action_code   = 1;
                    $tariff_code   = 1;
                    $payment_type  = 'sale';
                    $currency_code = 'UAH';

                    // Підрахунок суми замовлення без доставки
                    $price = 0;
                    foreach ($data['order']['product_list'] as $product) {
                        $price += $product['total'];
                    }

                    $url = 'https://ad.admitad.com/r?' . http_build_query([
                            'campaign_code'   => $campaign_code,
                            'postback'        => 1,
                            'postback_key'    => $postback_key,
                            'action_code'     => $action_code,
                            'uid'             => $uid,
                            'order_id'        => $order_id,
                            'price'           => round($price, 2),
                            'tariff_code'     => $tariff_code,
                            'payment_type'    => $payment_type,
                            'currency_code'   => $currency_code,
                            'promocode'       => ($admitad_coupon && isset($admitad_coupon['code'])) ? $admitad_coupon['code'] : ''
                    ]);

                    // Надсилання запиту
                    @file_get_contents($url);

                    // Установити куку, щоб не відправляти ще раз
                    setcookie($cookie_flag, '1', time() + 30 * 24 * 3600, '/');

                    // [опціонально] лог у файл
                    file_put_contents(DIR_LOGS . 'admitad_postback.log', date('Y-m-d H:i:s') . " | $url\n", FILE_APPEND);
                }
            }


            foreach ($data['order']['product_list'] as &$product){

                    if($product['original_price'] > $product['price']) {
                        $sale_dif = $product['original_price'] - $product['price'];
                        $sale_count += $sale_dif;
                    }

                    $product['price_text'] = $this->currency->format(
                        $this->tax->calculate($product['price'],
                            $product['tax_class_id'],
                            $this->config->get('config_tax')),
                        $this->session->data['currency']
                    );

                    $product['original_price_text'] = $this->currency->format(
                        $this->tax->calculate($product['original_price'],
                            $product['tax_class_id'],
                            $this->config->get('config_tax')),
                        $this->session->data['currency']
                    );

                    $data['usdt_info'] = $this->language->get('usdt_info');

                    $price_for_usdt = 0;
                    if($product['special']){
                        $price_for_usdt = explode(' ', $product['special'])[0];
                    }else{
                        $price_for_usdt = explode(' ', $product['price'])[0];
                    }
                    $usdt_price = round($price_for_usdt/$usdt_rate);
                    $product['usdt_price'] = $usdt_price;

                    $product_info = $this->model_catalog_product->getProduct($product['product_id']);
                    $product['link'] = $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $product['product_id']);
                    $product['img'] = '/image/'.$product_info['image'];
                }
                $data['order']['sale_count'] = $this->currency->format($sale_count, $order['currency_code'], $order['currency_value']);

            $data['order']['total'] = $this->currency->format($data['order']['total'], $order['currency_code'], $order['currency_value']);
        } else {
            $data['order'] = [];
        }
//        echo "<pre style='display: none' id='kl_look_mp'>";
//        print_r($data['order']);
//        echo "</pre>";

		$this->document->setRobots('noindex, nofollow');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('account/download', '', true), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$data['continue'] = $this->url->link('common/home');



		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer').$gtag_succes;
		$data['header'] = $this->load->controller('common/header');



        unset($this->session->data['coupon']);
		$this->response->setOutput($this->load->view('common/success', $data));
	}
}