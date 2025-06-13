<?php
class ControllerExtensionModuleCartSummary extends Controller {
    public function index() {
        $this->load->model('tool/image');

        // Масив даних про кошик
        $cartData = [
            'total_quantity' => 0,
            'total_price' => 0.00,
            'products' => []
        ];

        $cartProducts = $this->cart->getProducts();

        foreach ($cartProducts as $product) {
            $cartData['products'][] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'link' => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                'image' => $this->model_tool_image->resize($product['image'], 100, 100),
                'quantity' => $product['quantity'],
                'price' => $this->currency->format($product['price'], $this->session->data['currency']),
                'total' => $this->currency->format($product['total'], $this->session->data['currency']),
            ];

            $cartData['total_quantity'] += $product['quantity'];
            $cartData['total_price'] += $product['total'];
        }

        $cartData['total_price'] = $this->currency->format($cartData['total_price'], $this->session->data['currency']);

        $data['cartData'] = $cartData;

        return $this->load->view('extension/module/cart_summary', $data);
    }
}