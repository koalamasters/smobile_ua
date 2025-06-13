<?php

class ControllerExtensionModuleExPak extends Controller
{
    public function productMain()
    {
        $json = [];
        $this->load->model('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            if (!empty($this->request->post['product_id'])) {

                $product_id = $this->request->post['product_id'];
                $product_info = $this->model_catalog_product->getProduct($product_id);

                if ($product_info) {

                    $data['product_id'] = $product_id;

                    $data['tabs'] = [];
                    foreach ($this->model_extension_module_ex_pak->getProductGroups($product_id, 'main') as $group) {
                        $tab_data['limits'] = $this->model_extension_module_ex_pak->getLimits($group['limit_main']);
                        $max_limit = max($tab_data['limits']);
                        $show_more = false;

                        if (count($group['products']) > $max_limit) {
                            if ($group['show_in_tab']) {
                                $show_more = true;
                            }
                        }

                        $products = $this->model_extension_module_ex_pak->sortProducts($group['products']);
                        $products = $this->model_extension_module_ex_pak->setProductsLimits($products, $tab_data['limits'], true);
                        $products = $this->model_extension_module_ex_pak->setProductsCartStatus($products);
                        $products = $this->model_extension_module_ex_pak->setProductsHtml($products);
                        $data['tabs'][] = [
                            'group_id' => $group['group_id'],
                            'name' => $group['name'],
                            'show_description' => $group['show_description'],
                            'products' => $products,
                            'show_more' => $show_more
                        ];
                    }

                    $data['ex_pak_show_more'] = $this->language->get('ex_pak_show_more');

                    $json['html'] = $this->load->view('extension/module/ex_pak/product_main', $data);
                }
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function productTabs()
    {
        $json = [];
        $this->load->model('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            if (!empty($this->request->post['product_id'])) {
                $product_id = $this->request->post['product_id'];
                $product_info = $this->model_catalog_product->getProduct($product_id);
                if ($product_info) {
                    $tabs = [];
                    foreach ($this->model_extension_module_ex_pak->getProductGroups($product_id, 'tab') as $group) {
                        $tab_data['group_id'] = $group['group_id'];
                        $tab_data['product_id'] = $product_id;
                        $tab_data['show_description'] = $group['show_description'];
                        if ($tab_data['show_description']) {
                            $limits = $group['limit_tab_description'];
                        } else {
                            $limits = $group['limit_tab'];
                        }
                        $tab_data['limits'] = $this->model_extension_module_ex_pak->getLimits($limits);
                        $products = $group['products'];
                        if ($tab_data['show_description']) {
                            $products = $this->model_extension_module_ex_pak->sortProducts($products);
                            $products = $this->model_extension_module_ex_pak->setProductsCartStatus($group['products']);
                            $products = $this->model_extension_module_ex_pak->setProductsLimits($products, $tab_data['limits']);
                            $products = $this->model_extension_module_ex_pak->setProductsHtml($products);
                            $tab_data['products'] = $products;
                        } else {
                            $categories_data = [
                                [
                                    'category_id' => 'popular',
                                    'name' => $this->language->get('ex_pak_popular'),
                                    'products' => $products,
                                ],
                            ];
                            $categories_data += $this->model_extension_module_ex_pak->getProductByCategories($products);
                            foreach ($categories_data as $category_id => $category) {
                                if ($category_id == 'popular') {
                                    $products = $this->model_extension_module_ex_pak->sortProductsDefault($category['products']);
                                } else {
                                    $products = $this->model_extension_module_ex_pak->sortProducts($category['products']);
                                }
                                $products = $this->model_extension_module_ex_pak->setProductsLimits($products, $tab_data['limits']);
                                $products = $this->model_extension_module_ex_pak->setProductsCartStatus($products);
                                $products = $this->model_extension_module_ex_pak->setProductsHtml($products);
                                $categories_data[$category_id]['products'] = $products;
                            }
                            $tab_data['categories'] = $categories_data;
                        }
                        $tabs[] = [
                            'group_id' => $group['group_id'],
                            'name' => $group['name'],
                            'name_tab' => $group['name_tab'],
                            'html' => $this->load->view('extension/module/ex_pak/product_tabs', $tab_data),
                        ];
                    }
                    $json['tabs'] = $tabs;
                }
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function productComplects()
    {
        $json = [];
        $this->load->model('extension/module/ex_pak');
        $this->load->language('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            if (!empty($this->request->post['product_id'])) {
                $product_id = $this->request->post['product_id'];
                $product_info = $this->model_catalog_product->getProduct($product_id);
                if ($product_info) {
                    $data['complects'] = $this->model_extension_module_ex_pak->getProductComplects($product_info);
                    if ($data['complects']) {
                        foreach ($data['complects'] as $complect_key => $complect) {
                            $products = $this->model_extension_module_ex_pak->setProductsHtml($complect['products']);
                            $categories = array(
                                array(
                                    'category_id' => 'all',
                                    'name' => $this->language->get('ex_pak_all'),
                                    'products' => $products,
                                )
                            );
                            $categories += $this->model_extension_module_ex_pak->getProductByCategories($products);
                            $data['complects'][$complect_key]['categories'] = $categories;
                        }
                        if ($product_info['image']) {
                            $image = $product_info['image'];
                        } else {
                            $image = 'placeholder.png';
                        }
                        $price = $this->currency->format($product_info['price'], $this->session->data['currency']);
                        if (!is_null($product_info['special']) && (float)$product_info['special'] >= 0) {
                            $special = $this->currency->format($product_info['special'], $this->session->data['currency']);
                        } else {
                            $special = false;
                        }
                        $main_product = array(
                            'product_id' => $product_info['product_id'],
                            'name' => $product_info['name'],
                            'price' => $price,
                            'special' => $special,
                            'image' => $this->model_tool_image->resize($image, 150, 150),
                            'no_button_cart' => 1,
                        );
                        $main_product = $this->model_extension_module_ex_pak->setProductsHtml(array($main_product));
                        $data['main_product'] = $main_product[0];
                        $data['ex_pak_to_cart'] = $this->language->get('ex_pak_to_cart');
                    }
                    $json['html'] = $this->load->view('extension/module/ex_pak/product_complects', $data);
                }
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function productInfo()
    {
        $json = [];
        $this->load->model('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            if (isset($this->request->post['main_product_id'])) {
                $main_product_info = $this->model_catalog_product->getProduct($this->request->post['main_product_id']);
                $product_info = [];
                if (isset($this->request->post['group_id']) && isset($this->request->post['group_product_id'])) {
                    $product_info = $this->model_catalog_product->getProduct($this->request->post['group_product_id']);
                    $group_product_info = $this->model_extension_module_ex_pak->getGroupProduct($this->request->post['main_product_id'], $this->request->post['group_id'], $this->request->post['group_product_id']);
                } elseif (isset($this->request->post['complect_id']) && isset($this->request->post['complect_product_id'])) {
                    $product_info = $this->model_catalog_product->getProduct($this->request->post['complect_product_id']);
                    $complect_product_info = $this->model_extension_module_ex_pak->getProductComplectProduct($main_product_info, $this->request->post['complect_id'], $this->request->post['complect_product_id']);
                }
                if ($main_product_info && $product_info) {
                    $data['main_product_id'] = $this->request->post['main_product_id'];
                    if (isset($this->request->post['group_id'])) {
                        $data['group_id'] = $this->request->post['group_id'];
                    }
                    if (isset($this->request->post['group_product_id'])) {
                        $data['group_product_id'] = $this->request->post['group_product_id'];
                    }
                    if (isset($this->request->post['complect_id'])) {
                        $data['complect_id'] = $this->request->post['complect_id'];
                    }
                    if (isset($this->request->post['complect_product_id'])) {
                        $data['complect_product_id'] = $this->request->post['complect_product_id'];
                    }
                    $data['heading_title'] = $product_info['name'];
                    $data['model'] = $product_info['model'];
                    if ($product_info['image']) {
                        $data['thumb'] = $this->model_tool_image->resize($product_info['image'], 500, 500);
                    } else {
                        $data['thumb'] = $this->model_tool_image->resize('placeholder.png', 500, 500);
                    }
                    $data['description'] = html_entity_decode($product_info['description']);
                    $data['rating'] = (int)$product_info['rating'];
                    if (isset($product_info['rating_percent'])) {
                        $data['rating_percent'] = round((float)$product_info['rating_percent'] / 5 * 100);
                    } elseif (isset($product_info['rating'])) {
                        $data['rating_percent'] = round((float)$product_info['rating'] / 5 * 100);
                    } else {
                        $data['rating_percent'] = 0;
                    }
                    $data['in_cart'] = false;
                    if (!empty($complect_product_info)) {
                        if ($complect_product_info['special']) {
                            $data['special'] = $this->currency->format($complect_product_info['special_raw'], $this->session->data['currency']);
                        }
                        $data['price'] = $this->currency->format($complect_product_info['price_raw'], $this->session->data['currency']);
                        $data['default_product_key'] = $complect_product_info['product_key'];
                        foreach ($this->cart->getComplectProducts() as $complect_product) {
                            if (($complect_product['main_product_id'] == $data['main_product_id']) && ($complect_product['complect_id'] == $complect_product_info['complect_id']) && ($complect_product['product_id'] == $complect_product_info['product_id'])) {
                                $data['in_cart'] = true;

                                $data['cart_product_key'] = $complect_product['product_key'];
                            }
                        }
                    } elseif (!empty($group_product_info)) {
                        if ($group_product_info['group_product_price'] != $product_info['price']) {
                            $data['special'] = $this->currency->format($group_product_info['group_product_price'], $this->session->data['currency']);
                            $data['price'] = $this->currency->format($product_info['price'], $this->session->data['currency']);
                            if ($group_product_info['group_product_price'] != $product_info['price']) {
                                if ($group_product_info['group_product_price'] > 0) {
                                    $data['discount_procent'] = round((($product_info['price'] - $group_product_info['group_product_price']) / $product_info['price']) * 100, 0);
                                }
                            }
                        } else {
                            $data['price'] = $this->currency->format($product_info['price'], $this->session->data['currency']);
                        }

                        $data['default_product_key'] = $group_product_info['product_key'];
                        $products[] = array(
                            'product_key' => $group_product_info['product_key'],
                            'single' => $group_product_info['single'],
                            'special_raw' => $group_product_info['special_raw'],
                            'price_raw' => $group_product_info['price_raw'],
                            'main_product_id' => $this->request->post['main_product_id'],
                            'product_id' => $this->request->post['group_product_id'],
                            'group_id' => $this->request->post['group_id'],
                        );
                        $products = $this->model_extension_module_ex_pak->setProductsCartStatus($products);
                        if (!empty($products[0]['in_cart'])) {
                            $data['in_cart'] = true;
                            $data['cart_product_key'] = $products[0]['cart_product_key'];
                        }
                    } else {
                        $data['price'] = $this->currency->format($product_info['price'], $this->session->data['currency']);
                    }
                    $data['options'] = $this->model_catalog_product->getProductOptions($product_info['product_id']);
                    $data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($product_info['product_id']);
                    $data['to_product'] = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);
                    $json['html'] = $this->load->view('extension/module/ex_pak/product_info', $data);
                }
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function productCheckout()
    {
        $json = [];
        $this->load->model('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            $data['products'] = [];
            $data['show_more'] = true;
            $data['ex_pak_show_more'] = $this->language->get('ex_pak_show_more');
            $data['ex_pak_checkout_title'] = $this->language->get('ex_pak_checkout_title');
            $processed_products = [];
            foreach ($this->cart->getProducts() as $cart_product) {
                if (!in_array($cart_product['product_id'], $processed_products) && empty($cart_product['main_product_id'])) {
                    $processed_products[] = $cart_product['product_id'];
                    foreach ($this->model_extension_module_ex_pak->getProductGroups($cart_product['product_id'], 'checkout', 'checkout') as $group) {
                        if (!$group['show_description']) {
                            $limits = $this->model_extension_module_ex_pak->getLimits($group['limit_checkout']);
                            $products = $this->model_extension_module_ex_pak->sortProducts($group['products']);
                            $products = $this->model_extension_module_ex_pak->setProductsLimits($products, $limits, true);
                            $products = $this->model_extension_module_ex_pak->setProductsCartStatus($products, true);
                            $products = $this->model_extension_module_ex_pak->setProductsHtml($products);
                            foreach ($products as $product) {
                                $poduct_price = $product['special_raw'] ? $product['special_raw'] : $product['price_raw'];
                                $product_key = $product['product_id'] . '.' . round($poduct_price, 2);
                                $data['products'][$product_key] = $product;
                            }

                        }
                    }
                }
            }
            if ($data['products']) {
                shuffle($data['products']);
                $json['html'] = $this->load->view('extension/module/ex_pak/product_checkout', $data);
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function productSidebar()
    {
        $json = [];
        $this->load->model('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            $data = [];
            $data['products'] = [];
            $data['ex_pak_product_sidebar_to_product'] = $this->language->get('ex_pak_product_sidebar_to_product');
            $data['ex_pak_product_sidebar_to_title'] = $this->language->get('ex_pak_product_sidebar_to_title');
            $processed_products = [];
            foreach ($this->cart->getProducts() as $cart_product) {
                if (!in_array($cart_product['product_id'], $processed_products) && empty($cart_product['main_product_id'])) {
                    $processed_products[] = $cart_product['product_id'];
                    $categories_data = [];
                    $groups_data = [];
                    foreach ($this->model_extension_module_ex_pak->getProductGroups($cart_product['product_id'], 'checkout') as $group) {
                        $products = $group['products'];
                        if ($group['show_description']) {
                            if (empty($groups_data[$group['group_id']])) {
                                $groups_data[$group['group_id']] = array(
                                    'name' => $group['name'],
                                    'products' => [],
                                );
                            }
                            $products = $this->model_extension_module_ex_pak->sortProducts($products);
                            $products = $this->model_extension_module_ex_pak->setProductsCartStatus($products, true);
                            $products = $this->model_extension_module_ex_pak->setProductsHtml($products);
                            $groups_data[$group['group_id']]['products'] = $products;
                        } else {
                            $limits = $this->model_extension_module_ex_pak->getLimits($group['limit_main']);
                            if (!isset($categories_data['popular'])) {
                                $categories_data['popular'] = array(
                                    'category_id' => 'popular',
                                    'name' => $this->language->get('ex_pak_popular'),
                                    'products' => [],
                                );
                            }
                            $categories_data['popular']['products'] += $products;
                            foreach ($this->model_extension_module_ex_pak->getProductByCategories($products) as $category) {
                                if (!isset($categories_data[$category['category_id']])) {
                                    $categories_data[$category['category_id']] = array(
                                        'category_id' => $category['category_id'],
                                        'name' => $category['name'],
                                        'products' => [],
                                    );
                                }
                                $categories_data[$category['category_id']]['products'] += $category['products'];
                            }
                        }
                    }
                    if ($categories_data || $groups_data) {
                        foreach ($categories_data as $category_id => $category) {
                            $products = $this->model_extension_module_ex_pak->sortProducts($category['products']);
                            $products = $this->model_extension_module_ex_pak->setProductsLimits($products, $limits, true);
                            $products = $this->model_extension_module_ex_pak->setProductsCartStatus($products, true);
                            $products = $this->model_extension_module_ex_pak->setProductsHtml($products);
                            $categories_data[$category_id]['products'] = $products;
                        }
                        if ($cart_product['image']) {
                            $image = $cart_product['image'];
                        } else {
                            $image = 'placeholder.png';
                        }
                        $data['products'][$cart_product['product_id']] = array(
                            'product_id' => $cart_product['product_id'],
                            'name' => $cart_product['name'],
                            'thumb' => $this->model_tool_image->resize($image, 150, 150),
                            'categories' => $categories_data,
                            'groups' => $groups_data,
                        );
                    }
                }
            }
            if (!empty($this->request->post['product_id']) && isset($data['products'][$this->request->post['product_id']])) {
                $data['active_product_id'] = $this->request->post['product_id'];
            } else {
                $data['active_product_id'] = key($data['products']);
            }
            $json['html'] = $this->load->view('extension/module/ex_pak/product_sidebar', $data);
        }
        $this->response->setOutput(json_encode($json));
    }

    public function addToCart()
    {
        $json = [];
        $success = false;
        $this->load->model('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            if (isset($this->request->post['main_product_id'])) {
                $main_product_info = $this->model_catalog_product->getProduct($this->request->post['main_product_id']);
                if ($main_product_info) {
                    $main_product_id = $this->request->post['main_product_id'];
                    $json['main_product_id'] = $main_product_id;
                    if (isset($this->request->post['default_product_key'])) {
                        $default_product_key = $this->request->post['default_product_key'];
                        $json['default_product_key'] = $this->request->post['default_product_key'];
                    } else {
                        $default_product_key = false;
                    }
                    $type = false;
                    $sub_product_info = [];
                    if (!empty($this->request->post['complect_id']) && !empty($this->request->post['complect_product_id'])) {
                        $sub_product_id = $this->request->post['complect_product_id'];
                        $sub_product_info = $this->model_catalog_product->getProduct($sub_product_id);
                        $sub_product_data = $this->model_extension_module_ex_pak->getProductComplectProduct($main_product_info, $this->request->post['complect_id'], $sub_product_id);
                        $json['complect_id'] = $this->request->post['complect_id'];
                        $json['complect_product_id'] = $sub_product_id;
                        $type = 'complect_product';
                    } elseif (isset($this->request->post['group_id']) && isset($this->request->post['group_product_id'])) {
                        $sub_product_id = $this->request->post['group_product_id'];
                        $sub_product_info = $this->model_catalog_product->getProduct($sub_product_id);
                        $sub_product_data = $this->model_extension_module_ex_pak->getGroupProduct($main_product_id, $this->request->post['group_id'], $sub_product_id);
                        $json['group_id'] = $this->request->post['group_id'];
                        $json['group_product_id'] = $sub_product_id;
                        $type = 'group_product';
                    }
                    if ($sub_product_info) {
                        if (isset($this->request->post['option'])) {
                            $option = array_filter($this->request->post['option']);
                        } else {
                            $option = [];
                        }
                        $main_product_option = isset($option[$main_product_id]) ? $option[$main_product_id] : [];
                        $sub_product_option = isset($option[$sub_product_id]) ? $option[$sub_product_id] : [];
                        $check_products = [];
                        $cart_main_product = $this->model_extension_module_ex_pak->getCartProductById($main_product_id);
                        if (($type == 'complect_product') || (!$cart_main_product && !empty($sub_product_data['add_with_main']))) {
                            $check_products[] = $main_product_info;
                        }
                        $check_products[] = $sub_product_info;
                        $data['total_price'] = false;
                        $data['total_special'] = false;
                        $data['total_discount_procent'] = false;
                        $data['products'] = [];
                        foreach ($check_products as $product_info) {
                            $price = $product_info['price'];
                            $special = false;
                            if ($product_info['product_id'] == $main_product_id) {
                                if (!is_null($product_info['special']) && (float)$product_info['special'] >= 0) {
                                    $special = $product_info['special'];
                                }
                            } elseif ($product_info['product_id'] == $sub_product_id) {
                                if (!empty($sub_product_data['special_raw'])) {
                                    $special = $sub_product_data['special_raw'];
                                }
                            }
                            $product_options_errors = [];
                            $product_options = $this->model_catalog_product->getProductOptions($product_info['product_id']);
                            if ($product_options) {
                                $option_discount = 0;
                                foreach ($product_options as $product_option) {
                                    if ($product_option['required'] && empty($option[$product_info['product_id']][$product_option['product_option_id']])) {
                                        $product_options_errors[$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
                                    } else {
                                        foreach ($product_option['product_option_value'] as $value) {
                                            if ($value['product_option_value_id'] == $option[$product_info['product_id']][$product_option['product_option_id']]) {
                                                if ($value['price']) {
                                                    if ($value['price_prefix'] == '+') {
                                                        $option_discount += $value['price'];
                                                    } else {
                                                        $option_discount -= $value['price'];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $price += $option_discount;
                                $data['total_price'] += $price;
                                if ($special) {
                                    $special += $option_discount;
                                    $data['total_special'] += $special;
                                } else {
                                    $data['total_special'] += $price;
                                }
                            }
                            if ($product_options_errors) {
                                $json['error']['option'][$product_info['product_id']] = $product_options_errors;
                                if ($product_info['image']) {
                                    $image = $product_info['image'];
                                } else {
                                    $image = 'placeholder.png';
                                }
                                $product_data = array(
                                    'product_id' => $product_info['product_id'],
                                    'name' => $product_info['name'],
                                    'image' => $this->model_tool_image->resize($image, 150, 150),
                                    'price' => $this->currency->format($price, $this->session->data['currency']),
                                    'special' => $special ? $this->currency->format($special, $this->session->data['currency']) : false,
                                    'options' => $product_options,
                                    'errors' => $product_options_errors,
                                );
                                $data['products'][] = $product_data;
                            }
                        }
                        if ($data['total_special'] < $data['total_price']) {
                            $data['total_discount_procent'] = 100 - round(($data['total_special'] * 100 / $data['total_price']));
                            $data['total_special'] = $this->currency->format($data['total_special'], $this->session->data['currency']);
                        } else {
                            $data['total_special'] = false;
                        }
                        $data['total_price'] = $this->currency->format($data['total_price']+999, $this->session->data['currency']);
                        // Calc option prices
                        if (isset($this->request->post['calculate_price'])) {
                            $type = 'calculate_price';
                            $data['products'] = [];
                            $json['total_special'] = $data['total_special'];
                            $json['total_price'] = $data['total_price'];
                            $json['total_discount_procent'] = $data['total_discount_procent'];
                        }
                        if ($data['products']) {
                            // Show options popup
                            $data['main_product_id'] = $main_product_id;
                            $data['default_product_key'] = $default_product_key;
                            if ($type == 'complect_product') {
                                $data['complect_id'] = $this->request->post['complect_id'];
                                $data['complect_product_id'] = $sub_product_id;
                            } elseif ($type == 'group_product') {
                                $data['group_id'] = $this->request->post['group_id'];
                                $data['group_product_id'] = $sub_product_id;
                            }
                            $data['text_option_title'] = $this->language->get('ex_pak_text_option');
                            $data['text_button_add'] = $this->language->get('ex_pak_button_add');
                            $json['html'] = $this->load->view('extension/module/ex_pak/product_options', $data);
                        } elseif ($type == 'complect_product') {
                            // Add complect product
                            $main_product_option['complect'] = array(
                                'complect_id' => $this->request->post['complect_id'],
                                'complect_product_id' => $this->request->post['complect_product_id'],
                                'option' => isset($option[$sub_product_id]) ? $option[$sub_product_id] : [],
                            );
                            $this->cart->add($this->request->post['main_product_id'], 1, $main_product_option);
                            foreach ($this->cart->getComplectProducts() as $complect_product) {
                                if (($complect_product['main_product_id'] == $main_product_id) && ($complect_product['complect_id'] == $this->request->post['complect_id']) && ($complect_product['product_id'] == $this->request->post['complect_product_id'])) {
                                    $json['cart_product_key'] = $complect_product['product_key'];
                                }
                            }
                            //$json['product_key'] = $sub_product_data['product_key'];
                            $success = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['main_product_id']), $main_product_info['name'], $this->url->link('checkout/cart'));;
                        } elseif ($type == 'group_product') {
                            // Add group product
                            if (!empty($sub_product_data['add_with_main'])) {
                                if (!$cart_main_product) {
                                    $this->cart->add($main_product_id, 1, $main_product_option);
                                }
                                $result = $this->cart->addDopTovar($main_product_id, $this->request->post['group_id'], $sub_product_id, $sub_product_option);
                                $success = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $sub_product_id), $product_info['name'], $this->url->link('checkout/cart'));
                            } else {
                                $result = $this->cart->addDopTovar($main_product_id, $this->request->post['group_id'], $sub_product_id, $sub_product_option, true);
                                $success = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $sub_product_id), $product_info['name'], $this->url->link('checkout/cart'));
                            }
                            if (!empty($result['product_key'])) {
                                $json['cart_product_key'] = $result['product_key'];
                                $json['cart_product_key_without_main'] = $this->cart->removeDopTovarMainProductKey($result['product_key']);
                            }
                        }
                    }
                }
            }
        }
        if ($success) {
            $count_products = $this->cart->countProducts();
            // Totals
            $this->load->model('setting/extension');
            $totals = [];
            $taxes = $this->cart->getTaxes();
            $total = 0;
            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            );
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
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }
                $sort_order = [];
                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                }
                array_multisort($sort_order, SORT_ASC, $totals);
            }
            $json['success'] = $success;
            $json['action'] = 'add';
            $json['total'] = sprintf($this->language->get('text_items'), $count_products + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
            $json['total_products'] = $count_products + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
            $json['total_amount'] = $this->currency->format($this->cart->getTotal(), $this->session->data['currency']);
        }
        $this->response->setOutput(json_encode($json));
    }

    public function removeFromCart()
    {
        $json = [];
        $success = false;
        $this->load->model('extension/module/ex_pak');
        $this->load->language('extension/module/ex_pak');
        if ($this->model_extension_module_ex_pak->load()) {
            if (isset($this->request->post['cart_product_key'])) {
                $json['cart_product_key'] = $this->request->post['cart_product_key'];
                if (isset($this->request->post['complect_id']) && isset($this->request->post['complect_product_id'])) {
                    $this->cart->removeComplectByKey($this->request->post['cart_product_key']);
                    $success = $this->language->get('ex_pak_remove_product');
                } elseif (isset($this->request->post['group_id']) && isset($this->request->post['group_product_id'])) {
                    $this->cart->removeDopTovarByKey($this->request->post['cart_product_key']);
                    $success = $this->language->get('ex_pak_remove_product');
                }
            }
        }
        if ($success) {
            $json['success'] = $success;
            $json['action'] = 'remove';
            $json['total_products'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
            $json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($this->cart->getTotal(), $this->session->data['currency']));
            $json['total_amount'] = $this->currency->format($this->cart->getTotal(), $this->session->data['currency']);
        }
        $this->response->setOutput(json_encode($json));
    }
}