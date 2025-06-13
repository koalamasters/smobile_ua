<?php
class ControllerKmMenueditor extends Controller {

    public function index() {
        // Завантажуємо модель
        $this->load->model('km/menueditor');
        // Отримуємо меню з моделі
        $menu_id = $this->model_km_menueditor->getActiveMenu();

        if(isset($this->request->get['preview_menu'])){
            $menu_id = $this->request->get['preview_menu'];
        }

        $menu = $this->model_km_menueditor->getMenuById($menu_id);
        $menu = $menu_data = json_decode($menu['data_json'], true); // Декодуємо JSON
        foreach ($menu as $key =>  &$menu_item){
            // Використання іконки, як основного зображення
            $menu_item['img_link'] = $menu_item['icon_link'];

            if($menu_item['status'] == 0){
                unset($menu[$key]);
                continue;
            }

            $menu_item = $this->refactormenu($menu_item);
            $menu_item['view'] = 2;
            $menu_item['column'] = 1;
            $menu_item['width'] = 32;
            $menu_item['height'] = 32;
        };



//        if($_SERVER['REMOTE_ADDR'] == '31.148.150.46'){
//            echo "<pre style='display:block' id='kl_look_mp'>";
//            print_r($menu);
//            echo "</pre>";
//        }

       return $menu;
    }

    function refactormenu($menu_item)
    {

        $curent_lang = $this->session->data['language'];
        if($curent_lang == 'uk-ua'){
            $menu_item['name'] = html_entity_decode($menu_item['text']);
            $menu_item['href'] = $menu_item['url'];
            $menu_item['width'] = 100;
            $menu_item['height'] = 100;
            $menu_item['oct_pages'] = [];
//            $menu_item['href'] = '/';
            $menu_item['type'] = 'category';

        }else{
            $menu_item['name'] = html_entity_decode($menu_item['text_ru']);
            $menu_item['href'] = $menu_item['url_ru'];
            $menu_item['width'] = 100;
            $menu_item['height'] = 100;
            $menu_item['oct_pages'] = [];
//            $menu_item['href'] = '/';
            $menu_item['type'] = 'category';
        }
        $menu_item['oct_image'] = $menu_item['img_link'];
        $menu_item['icon_link'] = $menu_item['icon_link'];

        if($menu_item['name'] == 'Бренди') {

        }

        unset($menu_item['text']);
        unset($menu_item['text_ru']);
//        unset($menu_item['img_link']);
        unset($menu_item['url']);
        unset($menu_item['url_ru']);
//        unset($menu_item['icon_link']);
        unset($menu_item['icon']);
//        unset($menu_item['target']);
        unset($menu_item['title']);


        if(isset($menu_item['children'])){
            foreach ($menu_item['children'] as $key2 => &$child){

                if($child['status'] == 0){
                    unset($menu_item['children'][$key2]);
                    continue;
                }

                $child = $this->refactormenu($child);
            }
        }
        return $menu_item;
    }
}
