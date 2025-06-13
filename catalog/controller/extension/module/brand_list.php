<?php
class ControllerExtensionModuleBrandList extends Controller {
    public function index() {
        $this->load->language('extension/module/brand_list');

        $data['message'] = $this->language->get('text_message');
        $data['text_all_brands'] = $this->language->get('all_brands');

        $this->load->model('setting/setting');
        $setting = $this->model_setting_setting->getSetting('module_brand_list');

        if($setting['module_brand_list_status'] == 1){



            $lang = $this->session->data['language'];


            $list = [];
            foreach ($setting['module_brand_list_items'] as $item){
                $list[$item['code']] = [
                    'link' => $item['link'][$lang],
                    'img' => $item['image'],
                    'class' => $item['css'],
                ];
            }

            $data['banners'] = $list;
        }else{
            $data['banners'] = [
                'marshall' => [
                    'link' => '/marshall_ua',
                    'img' => '/image/catalog/brand_list/marshal.png',
                    'class' => 'dark-bg'
                ],
                'pitaka' => [
                    'link' => '/pitaka_ua',
                    'img' => '/image/catalog/brand_list/pitaka.jpg'
                ],
                'native-union' => [
                    'link' => '/native-union_ua',
                    'img' => '/image/catalog/brand_list/native_union.png'
                ],
                'satechi_ua' => [
                    'link' => '/satechi_ua',
                    'img' => '/image/catalog/brand_list/satechi.jpg'
                ],

//            'moshi' => [
//                'link' => '/moshi_ua',
//                'img' => '/image/catalog/brand_list/moshi.png',
//                'class' => 'home-brnad-list-item-moshi'
//            ],

                'moshi' => [
                    'link' => '/nomad_ua',
                    'img' => '/image/catalog/brands/nomad-200x80.png',
                    'class' => 'home-brnad-list-item-nomad'
                ]
            ];
        }

        return $this->load->view('extension/module/brand_list', $data);
    }
}
