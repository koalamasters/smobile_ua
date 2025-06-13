<?php
class ControllerKmMenueditor extends Controller
{


    public function index() {

    }

    public function menulist(){
        date_default_timezone_set('Europe/Kiev'); // Set to Kyiv timezone
        $this->load->language('km/menueditor');
        $this->load->model('km/menueditor');
        $this->model_km_menueditor->checkAndCreateTable();
        $data['user_token'] = $this->request->get['user_token'];


        $menu_list = $this->model_km_menueditor->getMenuList();

        foreach ($menu_list as &$menu_item){
            $menu_item['edit'] = $this->url->link('km/menueditor/edit', 'user_token=' .  $data['user_token'] . '&menu_id=' . $menu_item['id'], true);
            $menu_item['view'] = '/?menu_id=' . $menu_item['id'].'&preview_menu='.$menu_item['id'].'&new_mega_menu=1';
            $menu_item['copy'] = $this->url->link('km/menueditor/copy_item', 'user_token=' .  $data['user_token'] . '&menu_id=' . $menu_item['id'], true);
            $menu_item['delete_link'] = $this->url->link('km/menueditor/delete_item', 'user_token=' .  $data['user_token'] . '&menu_id=' . $menu_item['id'], true);

        }

        $data['menu_list'] = $menu_list;

        $this->document->setTitle('Мегаменю - '.$data['name']);
        $data['heading_title'] = $this->language->get('heading_title');
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('km/menu_list', $data));


    }

    public function edit(){
        date_default_timezone_set('Europe/Kiev'); // Set to Kyiv timezone
        $this->load->language('km/menueditor');
        $this->load->model('km/menueditor');
        $this->model_km_menueditor->checkAndCreateTable();
        

        /**
         * Процес збереження меню
         */
        if(isset($this->request->post['name']) && $this->request->post['data_json']){

            $raw_json = trim($this->request->post['data_json']);

            $raw_json = str_replace('&quot;', '"', $raw_json);

            $json_data = json_decode($raw_json, JSON_UNESCAPED_UNICODE);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Обробка помилки, якщо JSON не валідний
                die('Невірний формат JSON');
            }

            $update_data = [
                'id' => $this->request->get['menu_id'],
                'name' => $this->request->post['name'],
                'date_edit' => date('Y-m-d H:i:s'),
                'data_json' => $raw_json
            ];

            $this->model_km_menueditor->updateMenu($update_data['id'], $update_data['name'], $update_data['date_edit'], $update_data['data_json']);
            $url = '&menu_id='.$this->request->get['menu_id'];
            $this->response->redirect($this->url->link('km/menueditor/edit', 'user_token=' . $this->session->data['user_token'] . $url, true));
            //die('Оновлено');
        }

        if(isset($this->request->get['menu_id'])){
            $menu_id = $this->request->get['menu_id'];
            $data = $this->model_km_menueditor->getMenuById($menu_id);
            $data['action'] = $this->url->link('km/menueditor/edit', 'user_token=' . $this->session->data['user_token'].'&menu_id='.$this->request->get['menu_id'], true);
            $data['menu_id'] = $menu_id;
        }



        $data['user_token'] = $this->request->get['user_token'];


        $this->document->setTitle('Мегаменю - '.$data['name']);
        $data['heading_title'] = $this->language->get('heading_title');

        $data['header'] = $this->load->controller('common/header');

        $from = "</head>";
        $to = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
        <link rel="stylesheet" href="bootstrap-iconpicker/css/bootstrap-iconpicker.min.css">
      </head>';
        //$data['header'] = str_replace($from,$to, $data['header']);



        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('km/edit_menu', $data));
    }

    public function copy_item(){
        date_default_timezone_set('Europe/Kiev'); // Set to Kyiv timezone
        $this->load->language('km/menueditor');
        $this->load->model('km/menueditor');
        $data['user_token'] = $this->request->get['user_token'];

        if(isset($this->request->get['menu_id'])) {
            $menu_id = (int)$this->request->get['menu_id'];
            $this->model_km_menueditor->copyMenuItem($menu_id);
            die();
        }

//        $this->response->redirect($this->url->link('km/menueditor/menulist', 'user_token=' . $this->session->data['user_token'], true));
//        $this->response->redirect('/admin/index.php?route=km/menueditor/menulist&user_token='.$this->session->data['user_token']);
    }

    public function delete_item(){
        date_default_timezone_set('Europe/Kiev'); // Set to Kyiv timezone
        $this->load->language('km/menueditor');
        $this->load->model('km/menueditor');

        if(isset($this->request->get['menu_id'])) {
            $menu_id = (int)$this->request->get['menu_id'];
            $res = $this->model_km_menueditor->delete_item($menu_id);
            $this->response->redirect($this->url->link('km/menueditor/menulist', 'user_token=' . $this->session->data['user_token'], true));
        }
    }

    public function update_status() {
        date_default_timezone_set('Europe/Kiev'); // Set to Kyiv timezone
        $this->load->language('km/menueditor');
        $this->load->model('km/menueditor');

        // Перевіряємо, чи передано ID через GET
        if (isset($this->request->get['menu_id'])) {
            $id = (int)$this->request->get['menu_id'];
            $this->model_km_menueditor->update_status($id);
            $this->response->redirect($this->url->link('km/menueditor/menulist', 'user_token=' . $this->session->data['user_token'], true));
        }
    }


}