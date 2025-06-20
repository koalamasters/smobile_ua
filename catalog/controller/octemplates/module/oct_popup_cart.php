<?php
/**
 * @copyright    OCTemplates
 * @support      https://octemplates.net/
 * @license      LICENSE.txt
 */

class ControllerOCTemplatesModuleOctPopupCart extends Controller {
    public function index() {
        if ($this->config->get('theme_oct_showcase_popup_cart_status') && isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data = [];
            $usdt_rate = file_get_contents(DIR_ROOT.'usdt_rates.txt');
            $this->load->language('octemplates/module/oct_popup_cart');





            $data['text_go_to_cart'] = $this->language->get('go_to_cart');
            $data['text_delete'] = $this->language->get('delete');
            $data['text_checked'] = $this->language->get('checked');
            $data['text_product_code'] = $this->language->get('product_code');
            $data['total'] = $this->language->get('total');

            if (isset($this->request->request['remove'])) {
                $this->cart->remove($this->request->request['remove']);
                unset($this->session->data['vouchers'][$this->request->request['remove']]);
            }

            if (isset($this->request->request['update'])) {
                $this->cart->update($this->request->request['update'], $this->request->request['quantity']);
            }

            if (isset($this->request->request['add'])) {
                $this->cart->add($this->request->request['add'], $this->request->request['quantity']);
            }

            if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
                $data['error_warning'] = $this->language->get('error_stock');
            } elseif (isset($this->session->data['error'])) {
                $data['error_warning'] = $this->session->data['error'];

                unset($this->session->data['error']);
            } else {
                $data['error_warning'] = '';
            }

            if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
                $data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
            } else {
                $data['attention'] = '';
            }

            if (isset($this->session->data['success'])) {
                $data['success'] = $this->session->data['success'];

                unset($this->session->data['success']);
            } else {
                $data['success'] = '';
            }

            $this->load->model('tool/image');
            $this->load->model('tool/upload');
            $this->load->model('catalog/product');

            $data['isPopup'] = $oct_data['isPopup'] = (isset($this->request->get['isPopup']) && $this->request->get['isPopup']) ? true : false;

            $data['products'] = [];

            $products = $this->cart->getProducts();


            if (($this->config->get('config_checkout_guest') && $this->config->get('oct_popup_purchase_byoneclick_status')) && $products) {
                $oct_byoneclick_data = $this->config->get('oct_popup_purchase_byoneclick_data');
                $oct_data['oct_byoneclick_status'] = isset($oct_byoneclick_data['popup_cart']) ? 1 : 0;
                $oct_data['oct_byoneclick_mask'] = $oct_byoneclick_data['mask'];
                $oct_data['oct_byoneclick_product_id'] = $oct_data['oct_cart_in'] = $oct_data['oct_popup_cart'] = 1;
                $oct_data['oct_byoneclick_page'] = '_popup_cart';
                $data['oct_byoneclick'] = $this->load->controller('octemplates/module/oct_popup_purchase/byoneclick', $oct_data);
            }


            $data['related_product'] = [];

            $this->load->model('catalog/product');

            foreach ($products as $product) {
                $product_id = (int)$product['product_id'];
                $related_products = $this->model_catalog_product->getProductRelated($product_id);
                foreach ($related_products as $related_product) {
                    $data['related_product'][] = (int)$related_product['product_id'];
                }
            }

            $data['related_product'] = array_unique($data['related_product']);

            shuffle($data['related_product']);


            if (count($data['related_product']) > 10) {
                $data['related_product'] = array_slice($data['related_product'], 0, 10);
            }

            foreach ($data['related_product'] as $related_product_id){
                $data['product_related_cart'][] = $this->model_catalog_product->getProduct($related_product_id);
            }

            foreach ( $data['product_related_cart'] as &$related_product){
                $related_product['thumb'] = $image = $this->model_tool_image->resize($related_product['image'], 266, 192);

                $can_buy = true;

                var_dump($this->config->get('config_stock_checkout'));
                if ($related_product['quantity'] > 0 ) {
                    $related_product['can_buy'] = true;
                }

                $related_product['href'] = $this->url->link('product/product', 'product_id=' . $related_product['product_id'], true);

            }



            foreach ($products as $product) {
                $product_total = 0;

                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total += $product_2['quantity'];
                    }
                }

                if ($product['minimum'] > $product_total) {
                    $data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
                }

                if ($product['image']) {
                    $image = $this->model_tool_image->resize($product['image'], 200, 200);
                } else {
                    $image = $this->model_tool_image->resize("placeholder.png", 200, 200);
                }

                $option_data = [];

                $options_arr = [];

                foreach ($product['option'] as $value_opt) {
                    array_push($options_arr, $value_opt['product_option_value_id']);
                }

                if ($options_arr) {
                    $opt_array = [];

                    foreach ($options_arr as $value) {
                        if (is_array($value)) {
                            foreach ($value as $val) {
                                if ($val) {
                                    $opt_array[] = $this->model_catalog_product->getProductOptionValueId($product['product_id'], $val);
                                }
                            }
                        } else {
                            if ($value) {
                                $opt_array[] = $this->model_catalog_product->getProductOptionValueId($product['product_id'], $value);
                            }
                        }
                    }

                    $results_opts = $this->model_catalog_product->getProductImagesByOptionValueId($product['product_id'], $opt_array);

                    if (isset($results_opts[0]['image']) AND $results_opts[0]['image']) {
                        $image = $this->model_tool_image->resize($results_opts[0]['image'], 200, 200);
                    }
                }

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $value = $upload_info['name'];
                        } else {
                            $value = '';
                        }
                    }

                    $option_data[] = [
                        'name' => $option['name'],
                        'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    ];
                }

                $product_info = $this->model_catalog_product->getProduct($product['product_id']);

                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $p_price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $p_price = false;
                }

                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $p_special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $p_special = false;
                }


                $product_total = 0;
                $product_total = $product_totlal + $product['price'];
                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $p_total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']);
                } else {
                    $p_total = false;
                }

                $recurring = '';

                if ($product['recurring']) {
                    $frequencies = [
                        'day' => $this->language->get('text_day'),
                        'week' => $this->language->get('text_week'),
                        'semi_month' => $this->language->get('text_semi_month'),
                        'month' => $this->language->get('text_month'),
                        'year' => $this->language->get('text_year')
                    ];

                    if ($product['recurring']['trial']) {
                        $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }

                    if ($product['recurring']['duration']) {
                        $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }



                $price = $product_info['price']*$product['quantity'];
                $special = $product_info['special']*$product['quantity'];

                $special_price_text = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                $price_text = $this->currency->format($this->tax->calculate($price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

                $data['usdt_info'] = $this->language->get('usdt_info');

                $price_for_usdt = 0;

                if($product_info['special']){
                    $price_for_usdt = $special;
                }else{
                    $price_for_usdt = $price;
                }

                $usdt_price = round($price_for_usdt/$usdt_rate);

                $data['products'][] = [
                    'key'          => $product['cart_id'],
                    'product_id'   => $product['product_id'],
                    'thumb'        => $image,
                    'width'        => 100,
                    'height'       => 100,
                    'name'         => $product['name'],
                    'model'        => $product['model'],
                    'option'       => $option_data,
                    'recurring'    => $recurring,
                    'quantity'     => $product['quantity'],
                    'quantity_product' => $product_info['quantity'],

                    'special' => $special,
                    'price' => $price,

                    'special_text' => $special_price_text,
                    'price_text' => $price_text,

                    'stock'        => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
                    'reward'       => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
                    'total'        => $p_total,
                    'minimum'      => $product['minimum'],
                    'usdt'      => $usdt_price,
                    'href'         => $this->url->link('product/product', 'product_id=' . $product['product_id'], true),
                    'total_float' => $product_total*$product['quantity']
                ];
            }

            $data['cart_total'] = 0;

            foreach ($data['products'] as $product){
                $data['cart_total'] =  $data['cart_total'] + $product['total_float'];
            }

            $data['cart_total'] = $this->cart->getTotal();

            // Gift Voucher
            $data['vouchers'] = [];

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $key => $voucher) {
                    $data['vouchers'][] = [
                        'key' => $key,
                        'description' => $voucher['description'],
                        'amount' => $this->currency->format($voucher['amount'], $this->session->data['currency']),
                        'remove' => $this->url->link('checkout/cart', 'remove=' . $key, true)
                    ];
                }
            }

            // Totals
            $this->load->model('setting/extension');

            $totals = [];
            $taxes  = $this->cart->getTaxes();
            $total  = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = [
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            ];

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $sort_order = [];

                $results = $this->model_setting_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get('total_' . $result['code'] . '_status')) {
                        $this->load->model('extension/total/' . $result['code']);

                        // We have to put the totals in an array so that they pass by reference.
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }

                $sort_order = [];

                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $totals);
            }

            $data['totals'] = [];

            foreach ($totals as $total_value) {
                if ($total_value['code'] == 'shipping') {
                    $data['totals'][] = [
                        'title' => $total_value['title'],
                        'text' => $this->currency->format($total_value['value'], $this->session->data['currency'])
                    ];
                }
            }

            $data['checkout_link']   = $this->url->link('checkout/checkout', '', true);
            $data['cart_link']		 = $this->url->link('checkout/cart', '', true);
            $data['heading_title']   = $this->language->get('cart_title');
            $data['clear_cart']   = $this->language->get('clear_cart');
            $data['text_cart_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));

            $data['product_stock_checkout'] = $this->config->get('config_stock_checkout');

            $this->response->setOutput($this->load->view('octemplates/module/oct_popup_cart', $data));
        } else {
            $this->response->redirect($this->url->link('error/not_found', '', true));
        }
    }

    public function status_cart() {
        if ($this->config->get('theme_oct_showcase_popup_cart_status') && isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $json = [];

            $this->load->language('octemplates/module/oct_popup_cart');

            // Totals
            $this->load->model('setting/extension');

            $totals = [];
            $taxes  = $this->cart->getTaxes();
            $total  = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = [
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            ];

            // Display prices
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $sort_order = [];

                $results = $this->model_setting_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get('total_' . $result['code'] . '_status')) {
                        $this->load->model('extension/total/' . $result['code']);

                        // We have to put the totals in an array so that they pass by reference.
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }

                $sort_order = [];

                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }

                array_multisort($sort_order, SORT_ASC, $totals);
            }

            $json['total']           = sprintf($this->language->get('text_cart_items'), $this->currency->format($total, $this->session->data['currency']), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0));
            $json['text_items']      = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
            $json['text_cart_items'] = sprintf($this->language->get('text_cart_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
            $json['total_products'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
            $json['total_amount'] = $this->currency->format($total, $this->session->data['currency']);
            $json['oct_cart_ids'] = $this->load->controller('octemplates/events/helper/allCartProducts');

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            $this->response->redirect($this->url->link('error/not_found', '', true));
        }
    }
    public function clearcart() {
        $this->load->language('octemplates/module/oct_popup_cart');

        $this->cart->clear(); // очищення кошика

        $clear_cart_success  = $this->language->get('clear_cart_success');

        // Якщо треба видалити також купони, ваучери і т.п.:
        unset($this->session->data['vouchers']);
        unset($this->session->data['coupon']);
        unset($this->session->data['reward']);
        unset($this->session->data['gift_card']); // якщо використовуєте

        $json = ['success' => $clear_cart_success];
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
