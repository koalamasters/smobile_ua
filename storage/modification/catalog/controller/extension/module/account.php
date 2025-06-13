<?php
class ControllerExtensionModuleAccount extends Controller {
    public function index() {
        $this->load->language('extension/module/account');

        $this->load->model('account/customer');
        if ($this->customer->isLogged()) {
            $data['customer_info'] = $this->model_account_customer->getCustomer($this->customer->getId());
        }else{
            $data['customer_info'] = [];
        }

        $this->load->model('account/address');
        $data['count_of_addresses'] = count($this->model_account_address->getAddresses());


        $this->load->model('account/order');
        $data['order_count'] = 0;

        // Перевірка, чи користувач авторизований
        if ($this->customer->isLogged()) {
            // Отримання ID користувача
            $customer_id = $this->customer->getId();

            // Виклик методу моделі для отримання кількості замовлень
            $data['order_count'] = $this->model_account_order->getTotalOrders();
        }
        $this->load->model('octemplates/module/oct_stock_notifier');
        $data['stock_notifier_count'] = $this->model_octemplates_module_oct_stock_notifier->getTotalUserRequests($this->customer->getId());

        $this->load->model('account/wishlist');
        if ($this->customer->isLogged()) {
            $this->load->model('account/wishlist');
            $data['wishlist_count'] = count($this->model_account_wishlist->getWishlist());
        } else {
            $data['wishlist_count'] = 0;
        }

        // Визначення поточної сторінки
        $current_route = isset($this->request->get['route']) ? $this->request->get['route'] : 'common/home';
        $data['current_page'] = $current_route;

        // Встановлення прапорів для сторінок
        $data['is_account_page'] = ($current_route === 'account/account');
        $data['is_address_page'] = ($current_route === 'account/address');
        $data['is_order_page'] = ($current_route === 'account/order');
        $data['is_wishlist_page'] = ($current_route === 'account/wishlist');

        $data['is_login_page'] = ($current_route === 'account/login');
        $data['is_register_page'] = ($current_route === 'account/register');
        $data['is_notif_page'] = ($current_route === 'account/oct_stock_notifier');
        $data['is_password_page'] = ($current_route === 'account/password');



        $data['logged'] = $this->customer->isLogged();
        $data['register'] = $this->url->link('account/register', '', true);
        $data['login'] = $this->url->link('account/login', '', true);
        $data['logout'] = $this->url->link('account/logout', '', true);
        $data['forgotten'] = $this->url->link('account/forgotten', '', true);
        $data['account'] = $this->url->link('account/account', '', true);
        $data['edit'] = $this->url->link('account/edit', '', true);
        $data['password'] = $this->url->link('account/password', '', true);
        $data['address'] = $this->url->link('account/address', '', true);
        $data['wishlist'] = $this->url->link('account/wishlist');
        $data['order'] = $this->url->link('account/order', '', true);
        $data['download'] = $this->url->link('account/download', '', true);
        $data['reward'] = $this->url->link('account/reward', '', true);
        $data['return'] = $this->url->link('account/return', '', true);
        $data['transaction'] = $this->url->link('account/transaction', '', true);
        $data['newsletter'] = $this->url->link('account/newsletter', '', true);
        $data['recurring'] = $this->url->link('account/recurring', '', true);

				$this->load->language('extension/module/preorder');
				$data['text_preorder'] = $this->language->get('text_preorder');
				$data['preorder'] = $this->url->link('extension/module/preorder/account', '', true);
			

        return $this->load->view('extension/module/account', $data);
    }
}