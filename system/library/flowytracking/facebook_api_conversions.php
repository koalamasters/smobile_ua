<?php
namespace flowytracking;
class facebook_api_conversions extends master
{
    /**
     * Debug
     * 
     * @var string
     */
    private $debug;

    /**
     * Hours decrease
     * 
     * @var int
     */
    private $hours_decrease;

    /**
     * Product identification
     * 
     * @var string
     */
    private $product_id;
    
    public function __construct($registry) {
        parent::__construct($registry);
        //date_default_timezone_set("UTC");
        $this->hours_decrease = 0;
        $this->debug = '';
        $this->product_id = $this->config->get("flowy_tracking_fb_pixel_id_like_".$this->id_store);
    }

    public function fb_api_call($data) {
        if (array_key_exists('fb_api_track_info', $data)) {
            unset($data['fb_api_track_info']);
        }

        $data       = array_merge($this->api_get_basic_data($data), $data);
        $pixel_id   = !empty($data['fb_pixel_id']) ? $data['fb_pixel_id'] : '';
        $token      = !empty($data['fb_token']) ? $data['fb_token'] : '';

        unset($data['fb_pixel_id']);
        unset($data['fb_token']);

        if (!empty($data['custom_data']) && array_key_exists("extra_info", $data['custom_data'])) {
            unset($data['custom_data']['extra_info']);
        }

        if (!empty($data['custom_data']['event_source_url'])) {
            $data['event_source_url'] = $data['custom_data']['event_source_url'];
            unset($data['custom_data']['event_source_url']);
        }

        if (!empty($data['custom_data']['event_id'])) {
            unset($data['custom_data']['event_id']);
        }

        if (!empty($data['custom_data']['external_id'])) {
            unset($data['custom_data']['external_id']);
        }

        if (!empty($pixel_id) && !empty($token)) {
            $url = 'https://graph.facebook.com/v11.0/'.$pixel_id.'/events';

            if (!empty($data['event_name'])) {
                $this->insert_into_debug('FB Pixel API - API call url: ' . $url);
                $this->insert_into_debug('FB Pixel API - API call data: ' . print_r($data, true));
            }

            $fields = array();
            $fields['data'] = json_encode(array($data));
            $fields['access_token'] = $this->string_decrypt($token);

            //Test the event - TODO
            //$fields['test_event_code'] = 'TEST22638';

            $result = '';
            if(function_exists('curl_version')) {
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => http_build_query($fields),
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "Accept: application/json"
                    ),
                ));

                $result = curl_exec($ch);
                
                if (!empty($data['event_name'])) {
                    $this->insert_into_debug('FB Pixel API - API call result: '.print_r(json_decode($result, true),true));
                }

                curl_close($ch);
            } else {
                $this->insert_into_debug('Error FB Pixel API - CURL is not enabled');
            }
        }
    }

    /*
        - fb_pixel_id
        - fb_token
    */
    public function track_view($data) {
        if (empty($data['fb_api_track_info'])) {
            $this->insert_into_debug('No fb_api_track_info found');
            return $this->debug;
        }

        $data_view = $data['fb_api_track_info'];

        if (empty($data_view['event_name'])) {
            return false;
        }

        $data_view = array(
            'event_name' => $data_view['event_name'],
            'event_id' => $data_view['event_id'],
            'custom_data' => $data_view
        );

        unset($data_view['custom_data']['event_name']);
        unset($data_view['fb_api_track_info']);

        $data = array_merge($data, $data_view);

        $this->fb_api_call($data);

        return $this->debug;
    }

    public function track_add_to_cart($data) {
        if(empty($data['currency']) || empty($data['content_ids'])) {
            $this->insert_into_debug('Incomplete data: '.json_encode($data));
            return $this->debug;
        }

        $data_view = array(
            'event_name' => 'AddToCart',
            'event_id' => $data['event_id'],
            'custom_data' => array(
                "currency" => $data['currency'],
                "value" => $data['value']*$data['quantity'],
                "content_category" => $data['content_category'],
                "content_ids" => array($data['content_ids']),
                "content_name" => htmlspecialchars_decode(strip_tags($data['content_name'])),
                "content_type" => 'product',
                "contents" => array(
                    array(
                        "id" => $data['content_ids'],
                        "quantity" => $data['quantity'],
                        "item_price" => $data['value'],
                    ),
                ),
                "num_items" => $data['quantity'],
            )
        );

        $data = array_merge($data, $data_view);

        $this->fb_api_call($data);

        return $this->debug;
    }

    public function track_remove_from_cart($data) {
        if(empty($data['currency']) || empty($data['content_ids'])) {
            $this->insert_into_debug('Incomplete data: '.json_encode($data));
            return $this->debug;
        }

        $data_view = array(
            'event_name' => 'RemoveFromCart',
            'event_id' => $data['event_id'],
            'custom_data' => array(
                "currency" => $data['currency'],
                "value" => $data['value']*$data['quantity'],
                "content_category" => $data['content_category'],
                "content_ids" => array($data['content_ids']),
                "content_name" => htmlspecialchars_decode(strip_tags($data['content_name'])),
                "content_type" => 'product',
                "contents" => array(
                    array(
                        "id" => $data['content_ids'],
                        "quantity" => $data['quantity'],
                        "item_price" => $data['value'],
                    ),
                ),
                "num_items" => $data['quantity'],
            )
        );

        $data = array_merge($data, $data_view);

        $this->fb_api_call($data);

        return $this->debug;
    }

    public function track_add_to_wishlist($data) {
        if(empty($data['currency']) || empty($data['content_ids'])) {
            $this->insert_into_debug('Incomplete data: '.json_encode($data));
            return $this->debug;
        }

        $data['quantity'] = 1;
        $data_view = array(
            'event_name' => 'AddToWishlist',
            'event_id' => $data['event_id'],
            'custom_data' => array(
                "currency" => $data['currency'],
                "value" => $data['value']*$data['quantity'],
                "content_category" => $data['content_category'],
                "content_ids" => array($data['content_ids']),
                "content_name" => htmlspecialchars_decode(strip_tags($data['content_name'])),
                "content_type" => 'product',
                "contents" => array(
                    array(
                        "id" => $data['content_ids'],
                        "quantity" => $data['quantity'],
                        "item_price" => $data['value'],
                    ),
                ),
                "num_items" => $data['quantity'],
            )
        );

        $data = array_merge($data, $data_view);

        $this->fb_api_call($data);

        return $this->debug;
    }

    public function api_get_basic_data($data) {
        $user_data = array(
            "client_ip_address" => $this->get_client_ip(),
            "client_user_agent" => $_SERVER['HTTP_USER_AGENT'],
            'external_id' => $this->session->getId()
        );

        $fbc = $this->getFbc();
        if (!empty($fbc)) {
            $user_data['fbc'] = $fbc;
        }

        $fbp = $this->getFbp();
        
        if (!empty($fbp)) {
            $user_data['fbp'] = $fbp;
        }

        $customer_info = $this->get_customer_info();

        if (empty($customer_info['email']) && !empty($data['custom_data']['extra_info']['email'])) {
            $customer_info['email'] = $data['custom_data']['extra_info']['email'];
        }

        if (empty($customer_info['phone']) && !empty($data['custom_data']['extra_info']['phone'])) {
            $customer_info['phone'] = $data['custom_data']['extra_info']['phone'];
        }

        if (!empty($customer_info)) {
            if(!empty($customer_info['email']))
                $user_data['em'] = hash('sha256', $customer_info['email']);
            if(!empty($customer_info['phone']))
                $user_data['ph'] = hash('sha256', (int) filter_var($customer_info['phone'], FILTER_SANITIZE_NUMBER_INT));
            if(!empty($customer_info['firstname']))
                $user_data['fn'] = hash('sha256', $customer_info['firstname']);
            if(!empty($customer_info['lastname']))
                $user_data['ln'] = hash('sha256', $customer_info['lastname']);
            if(!empty($customer_info['postcode']))
                $user_data['zp'] = hash('sha256', strtolower($customer_info['postcode']));
            if(!empty($customer_info['city']))
                $user_data['ct'] = hash('sha256', strtolower($customer_info['city']));
            if(!empty($customer_info['zone_code']))
                $user_data['st'] = hash('sha256', strtolower($customer_info['zone_code']));
            if(!empty($customer_info['country_code']))
                $user_data['country'] = hash('sha256', strtolower($customer_info['country_code']));
        }

        $json = array(
            "event_time" => time() - ($this->hours_decrease*(60*60)),
            "event_source_url" => $this->get_page_url(),
            "action_source" => 'website',
            "user_data" => $user_data
        );

        return $json;
    }

    public function set_track_info_api($data_ft) {
        $track_info = array();

        $current_view = $this->FTMaster->get_current_view();

        //ViewContent
        if (in_array($current_view, array("product"))) {
            $product_info = array_key_exists('product_details', $data_ft) ? $data_ft['product_details']['product'] : '';

            if (empty($product_info)) {
                $product_id = $product_id_original = $this->get_current_product_id();
                $product_info = $this->model_catalog_product->getProduct($product_id);
                $price = $this->get_product_price($product_info);
            } else {
                $product_id = $product_info['product_id_fb'];
                $product_id_original = $product_info['product_id'];
                $price = $product_info['prices']['price']['price'];
            }

            $cat_tree = $this->get_product_category_name($product_id_original);
            if (!empty($product_info)) {
                $track_info = array(
                    'event_name' => 'ViewContent',
                    'content_type' => 'product',
                    'currency' => $this->currency_code,
                    'value' => $price,
                    'content_ids' => array($product_id),
                    'content_name' => htmlspecialchars_decode(strip_tags($product_info['name'])),
                    'content_category' => $cat_tree,
                    "contents" => array(
                        array(
                            "id" => $product_id,
                            "quantity" => 1,
                            "item_price" => $price,
                        ),
                    ),
                    "num_items" => 1,
                );
            }
        } elseif (in_array($current_view, array("category"))) {
            $product_listed = array_key_exists('products_listed', $data_ft) ? $data_ft['products_listed'] : '';

            if (!empty($product_listed)) {
                $cat_tree = implode (' > ', $this->get_category_names_array_category_view());
                $track_info = array(
                    'event_name' => 'ViewCategory',
                    'content_type' => 'product_group',
                    'content_category' => $cat_tree,
                    'value' => !empty($product_listed) ? $this->get_total_price_products($product_listed) : '0.00',
                    'currency' => $this->currency_code,
                    'content_ids' => $this->get_product_ids_array($product_listed, "product_id_fb"),
                    'contents' => $this->get_contents_array($product_listed),
                    'num_items' => count($product_listed),
                );
            }
        } elseif (in_array($current_view, array("search"))) {
            $product_listed = array_key_exists('products_listed', $data_ft) ? $data_ft['products_listed'] : '';

            if (!empty($product_listed)) {
                $track_info = array(
                    'event_name' => 'Search',
                    'content_type' => 'product_group',
                    'search_string' => $this->search,
                    'value' => !empty($product_listed) ? $this->get_total_price_products($product_listed) : '0.00',
                    'content_ids' => $this->get_product_ids_array($product_listed, "product_id_fb"),
                    'currency' => $this->currency_code,
                    'contents' => $this->get_contents_array($product_listed),
                    'num_items' => count($product_listed),
                );
            }
        } elseif (in_array($current_view, array("account_success", "affiliate_register"))) {
            $track_info = array(
                'event_name' => 'Customer registered',
                'currency' => $this->currency_code,
                'value' => '0.00'
            );
        } elseif ( in_array($current_view, array("checkout")) && $this->cart_products != '') {
            $quantity = 0;
            $content_ids = array();

            foreach ($this->cart_products as $key => $pro) {
                $content_ids[] = $this->get_real_product_identificator($pro, $this->product_id);
            }

            $value = $this->get_total_price_products($this->cart_products);

            $track_info = array(
                'event_name' => 'InitiateCheckout',
                'content_type' => 'product_group',
                'currency' => $this->currency_code,
                'value' => $value,
                'content_ids' => $content_ids,
                'content_type' => count($this->cart_products) > 1 ? 'product_group' : 'product',
                'contents' => $this->get_contents_array($this->cart_products),
                'num_items' => $this->cart_units,
            );
        } elseif( in_array($current_view, array("purchase")) && array_key_exists('order_data', $data_ft)) {
            $order_data = $data_ft['order_data'];

            if (!empty($order_data)) {
                $quantity = 0;
                $content_ids = array();

                foreach ($order_data['products'] as $key => $pro) {
                    $content_ids[] = $this->get_real_product_identificator($pro, $this->product_id);
                    $quantity += $pro['quantity'];
                }

                $email = !empty($order_data['customer']['general']['email']) ? $order_data['customer']['general']['email'] : '';
                $phone = !empty($order_data['customer']['general']['phone']) ? $order_data['customer']['general']['phone'] : '';

                $track_info = array(
                    'event_name' => 'Purchase',
                    'content_type' => count($order_data['products']) > 1 ? 'product_group' : 'product',
                    'currency' => $this->currency_code,
                    'value' => $order_data['order']['total'],
                    'tax' => $order_data['order']['tax'],
                    'shipping_charge' => $order_data['order']['shipping'],
                    'content_ids' => $content_ids,
                    'num_items' => $quantity,
                    'contents' => $this->get_contents_array($order_data['products'], $this->product_id),
                    'extra_info' => array('email' => $email, 'phone' => $phone)
                );
            }
        } else {
            $track_info = array(
                'event_name' => 'PageView',
                'currency' => $this->currency_code,
                'value' => '0.00'
            );
        }

        $track_info["event_source_url"] = $this->get_page_url();

        $track_info['external_id'] = $this->session->getId();
        $track_info['event_id'] = $this->FTMaster->generate_uuid();

        return $track_info;
    }

    public function get_contents_array($products) {
        $contents = array();

        foreach ($products as $prod) {
            $contents[] = array(
                "id" => !empty($prod['product']['product_id_fb']) ? $prod['product']['product_id_fb'] : $this->get_real_product_identificator($prod, $this->product_id),
                "quantity" => 1,
                "item_price" => !empty($prod['product']['prices']) ? $prod['product']['prices']['price']['price'] : $this->get_product_price($prod['product_id'], true),
            );
        }

        return $contents;
    }

    private function getFbp() {
        $fbp = '';

        if (isset($_COOKIE['_fbp']) && !empty($_COOKIE['_fbp'])) {
            $fbp = $_COOKIE['_fbp'];
        }

        return $fbp;
    }

    private function getFbc() {
        $fbc = '';

        if (isset($_COOKIE['_fbc']) && !empty($_COOKIE['_fbc'])) {
            $fbc = $_COOKIE['_fbc'];
        } else if (isset($_GET['fbclid'])) {
            $fbc =   'fb.1.' . time() . '.' . $_GET['fbclid'];
        }

        return $fbc;
    }

    public function insert_into_debug($message) {
        $debug_copy = $this->debug;
        $debug_copy .= date("Y-m-d H:i:s").' - '.$message.'<br>';
        $this->debug = $debug_copy;
    }
}
?>