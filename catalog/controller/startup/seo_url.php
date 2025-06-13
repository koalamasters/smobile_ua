<?php
class ControllerStartupSeoUrl extends Controller {
    public function index() {
        // Add rewrite to url class
        if ($this->config->get('config_seo_url')) {
            $this->url->addRewrite($this);
        }


        // Decode URL
        if (isset($this->request->get['_route_'])) {
            $parts = explode('/', $this->request->get['_route_']);

            // remove any empty arrays from trailing
            if (utf8_strlen(end($parts)) == 0) {
                array_pop($parts);
            }

            $lastKey = array_key_last($parts);

            foreach ($parts as $key => $part) {

                if($part == 'product'){
                    continue;
                }
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $this->db->escape($part) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

                if( $_SERVER['REMOTE_ADDR'] == '31.148.150.46') {

//                    if($query->row['language_id'] == 2){
//                        //$lang_id = $query['row']['language_id'];
//
//                        $url_parts = explode('/', $_SERVER['REQUEST_URI']);
//                        if($url_parts[1] != 'ru'){
//                            echo "<pre style='display: block' id='kl_look_mp'>";
//                            print_r(321);
//                            echo "</pre>";
//                            header("Location: /ru".$_SERVER['REQUEST_URI'], TRUE, 301);
//                        }
//                    }
                }

                if ($query->num_rows) {
                    $url = explode('=', $query->row['query']);

                    if ($url[0] == 'product_id') {
                        $this->request->get['product_id'] = $url[1];
                    }

                    if ($url[0] == 'category_id') {
                        if (!isset($this->request->get['path'])) {
                            $this->request->get['path'] = $url[1];
                        } else {
                            $this->request->get['path'] .= '_' . $url[1];
                        }
                    }

                    if ($url[0] == 'manufacturer_id') {
                        $this->request->get['manufacturer_id'] = $url[1];
                    }

                    if ($url[0] == 'information_id') {
                        $this->request->get['information_id'] = $url[1];
                    }

                    if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
                        $this->request->get['route'] = $query->row['query'];
                    }
                } else {
                    $this->request->get['route'] = 'error/not_found';

                    break;
                }

            }

            if (!isset($this->request->get['route'])) {
                if (isset($this->request->get['product_id'])) {
                    $this->request->get['route'] = 'product/product';
                } elseif (isset($this->request->get['path'])) {
                    $this->request->get['route'] = 'product/category';
                } elseif (isset($this->request->get['manufacturer_id'])) {
                    $this->request->get['route'] = 'product/manufacturer/info';
                } elseif (isset($this->request->get['information_id'])) {
                    $this->request->get['route'] = 'information/information';
                }
            }
        }
    }

    public function rewrite($link) {
        $url_info = parse_url(str_replace('&amp;', '&', $link));

        $url = '';

        $data = array();

        parse_str($url_info['query'], $data);


        foreach ($data as $key => $value) {
            if (isset($data['route'])) {
                if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

                    if ($query->num_rows && $query->row['keyword']) {

                        if($data['route'] == 'product/product' && $data['product_id'] > 1){
                            $url .= '/product/' . $query->row['keyword'];
                        }else{
                            $url .= '/' . $query->row['keyword'];
                        }
                        unset($data[$key]);
                    }
                } elseif ($data['route'] == 'product/catalog') {
                    $query = $this->db->query("
                        SELECT * FROM " . DB_PREFIX . "seo_url 
                        WHERE `query` = '" . $this->db->escape($value) . "' 
                        AND store_id = '" . (int)$this->config->get('config_store_id') . "' 
                        AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

                    if ($query->num_rows && $query->row['keyword']) {
                        $url .= '/' . $query->row['keyword'];
                        unset($data[$key]);
                    }
                } elseif ($key == 'path') {


                    if($data['route'] != 'product/product') {

                        $categories = explode('_', $value);

                        foreach ($categories as $category) {
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE `query` = 'category_id=" . (int)$category . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

                            if ($query->num_rows && $query->row['keyword']) {
                                $url .= '/' . $query->row['keyword'];
                            } else {
                                $url = '';

                                break;
                            }
                        }

                        unset($data[$key]);
                    }
                }elseif ($data['route'] == 'product/search' && isset($data['tag'])){

                    if( $_SERVER['REMOTE_ADDR'] == '5.58.178.186') {

//                        $link = 'https://' . $url_info['host'].'/tag/'.$data['tag'];
//                        return $this->url->link('product/search', 'tag=' . $data['tag']);
                    }

                }
            }
        }

        if ($url) {
            unset($data['route']);

            $query = '';

            if ($data) {
                foreach ($data as $key => $value) {
                    $query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
                }

                if ($query) {
                    $query = '?' . str_replace('&', '&amp;', trim($query, '&'));
                }
            }

//            return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
            return 'https://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
        } else {
            return $link;
        }
    }
}