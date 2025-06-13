<?php

class ModelExtensionPaymentWhitepay extends Model
{
    /** @var string Whitepay API url */
    private static $api_url = 'https://api.whitepay.com/';

    /** @var string Whitepay Slug */
    private $slug;

    /** @var string Whitepay Token */
    private $token;

    /** @var string Whitepay Webhook Token */
    private $webhook_token;

    /** @var string/array Log variable function */
    public $log;

    /**
     * Get method to avaliable in checkout page
     */
    public function getMethod($address, $total)
    {
		$this->load->language('extension/payment/whitepay');

		$method_data = array(
				'code'       => 'whitepay',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('payment_whitepay_sort_order'),
                'terms' => ''
			);
		return $method_data;
	}

    /**
     * Request to Whitepay API
     * @param string $endpoint
     * @param bool $dont_use_slug
     * @param array $data_request
     * @param string $method
     * @return array
     */
    public function sendRequest($endpoint, $dont_use_slug = false, $data_request = array(), $method = 'GET')
    {
        $this->slug      = $this->config->get('payment_whitepay_slug');
        $this->token     = $this->config->get('payment_whitepay_token');

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token
        );

        $url = self::$api_url . $endpoint;
        if (!$dont_use_slug) {
            $url .= $this->slug;
        }

        $curl = curl_init();

        if ($method == 'POST') {
            $data_request = json_encode($data_request);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_request);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $curl_info = curl_getinfo($curl);

        curl_close($curl);

        $result = json_decode($response, true);

        $response_code      = $curl_info['http_code'];
        $response_message   = !empty($result['message']) ? $result['message'] : '';

        if (in_array($response_code, array(200, 201), true)) {
            return array ("success" => true, "result" => $result);
        } else {
            $message = $this->getResponseErrorMessage($response_code, $response_message);
            $this->logger($message);

            return array ("success" => false, "result" => $message);
        }
    }

    /**
     * Check if authentication is successful
     * @return bool|string
     */
    public function checkAuth() {
        // Change the endpoint if there will be a separate method on Whitepay to check authentication
        $result = $this->sendRequest('private-api/order-statuses', true);

        if (!$result["success"]) {
            return false;
        }

        return true;
    }

    /**
     * Return response error message
     * @return string
     */
    public function getResponseErrorMessage ($response_code, $response_message) {
        $errors = array(
            400 => 'API response error: ' . $response_message,
            401 => 'Authorization error. Check your Token.',
        );

        if (array_key_exists($response_code, $errors)) {
            $message = $errors[$response_code];
        } else {
            $message = 'Unknown response error: ' . $response_code;
        }

        return $message;
    }

    /**
     * Get all applied fiat currencies for order creation
     * @return array
     */
    public function getOrderCreationCurrencies () {
        $result = $this->sendRequest('currencies/crypto-order-target-currencies', true);

        if (!$result["success"]) {
            return false;
        }

        return $result["result"]['currencies'];
    }

    /**
     * Create a new order
     * @param  array $params
     * @return array
     */
    public function createOrder ($params) 
    {
        // Return from acquiring page
        $return_url = $this->config->get('payment_whitepay_return_url');
        if ($return_url && !empty($return_url)) {
            $params['return_url'] = $return_url;
        }

        $result = $this->sendRequest('private-api/crypto-orders/', false, $params, 'POST');

        return $result["result"];
    }

    /**
     * Log
     */
    public function logger($message) {
        if ($this->config->get('payment_whitepay_debug') == 1) {
            $log = new Log('whitepay.log');
            $log->write($message);
        }
    }
}
