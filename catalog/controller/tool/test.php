<?php
class ControllerToolTest extends Controller
{
    public function index()
    {
        // Підвантажуємо модель замовлень
        $this->load->model('checkout/order');

        // Замінити на реальний order_id з БД
        $order_id = 1441;

        // Отримуємо дані замовлення
        $order_info = $this->model_checkout_order->getOrder($order_id);

        if (!$order_info) {
            echo 'Замовлення не знайдено';
            return;
        }

        // Підвантажуємо дані для шаблону листа
        $data['title'] = sprintf($this->language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);

        // Інші змінні, які зазвичай використовуються у листі
        $data['text_greeting'] = 'Дякуємо за замовлення';
        $data['order_id'] = $order_id;
        $data['firstname'] = $order_info['firstname'];
        $data['lastname'] = $order_info['lastname'];
        $data['email'] = $order_info['email'];
        $data['telephone'] = $order_info['telephone'];
        $data['date_added'] = date('d.m.Y', strtotime($order_info['date_added']));
        $data['payment_method'] = $order_info['payment_method'];
        $data['shipping_method'] = $order_info['shipping_method'];
        $data['comment'] = nl2br($order_info['comment']);

        // Список товарів у замовленні
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $data['products'] = [];

        $products = $this->model_checkout_order->getOrderProducts($order_id);

        foreach ($products as $product) {
            $data['products'][] = [
                'name'     => $product['name'],
                'model'    => $product['model'],
                'quantity' => $product['quantity'],
                'price'    => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
                'total'    => $this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']),
            ];
        }

        // Виводимо Twig шаблон
        echo $this->load->view('mail/order_add', $data);
    }
}
