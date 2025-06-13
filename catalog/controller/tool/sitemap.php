<?

class ControllerToolSitemap extends Controller
{
    public function index()
    {
        $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
        $output .= '  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"  xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\r\n";
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $products = $this->model_catalog_product->getProducts();
        foreach ($products as $key => $product) {
            $links = $this->model_catalog_product->getUrlsWithLang($product['product_id']);

            $ua_product_link = '';
            $ru_product_link = '';


            foreach ($links as $link){
                if($link['language_id'] == 2){
                    $ru_product_link = $link['keyword'];
                }elseif ($link['language_id'] == 3){
                    $ua_product_link = $link['keyword'];
                }
            }

            if (!empty($links[1]['keyword']))
                //$ua_product_link = $links[1]['keyword'];

            if (!empty($links[0]['keyword']))
                //$ru_product_link = $links[0]['keyword'];

            if (empty($ua_product_link)) {
                continue;
            }
            if (empty($ru_product_link)) {
                continue;
            }
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/product/' . $ua_product_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/product/' . $ru_product_link . '" />' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/product/' . $ua_product_link . '" />' . "\r\n";
            $output .= '<changefreq>daily</changefreq>';
            $output .= '<priority>1</priority>';



            $output .= '</url>' . "\r\n";
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/ru/product/' . $ru_product_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/product/' . $ua_product_link . '" />' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/product/' . $ru_product_link . '" />' . "\r\n";
            $output .= '<changefreq>daily</changefreq>';
            $output .= '<priority>1</priority>';
            $output .= '</url>' . "\r\n";
        }
        $this->load->model('catalog/category');
        $output .= $this->getCategories(0);




        $this->load->model('catalog/manufacturer');
        $manufacturers = $this->model_catalog_manufacturer->getManufacturers();
        foreach ($manufacturers as $manufacturer) {
            $man_links = $this->model_catalog_manufacturer->getManufacturersURL($manufacturer['manufacturer_id']);

            $ua_man_link = '';
            $ru_man_link = '';

            foreach ($man_links as $link){
                if($link['language_id'] == 2){
                    $ru_man_link = $link['keyword'];
                }elseif ($link['language_id'] == 3){
                    $ua_man_link = $link['keyword'];
                }
            }

            //if (!empty($man_links[1]['keyword']))
                //$ua_man_link = $man_links[1]['keyword'];

            //if (!empty($man_links[0]['keyword']))
                //$ru_man_link = $man_links[0]['keyword'];

            if (empty($ua_man_link)) {
                continue;
            }
            if (empty($ru_man_link)) {
                continue;
            }
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/' . $ua_man_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/' . $ru_man_link . '" />' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/' . $ua_man_link . '" />' . "\r\n";
            $output .= '<changefreq>weekly</changefreq>';
            $output .= '<priority>0,7</priority>';
            $output .= '</url>' . "\r\n";
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/' . $ru_man_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/' . $ua_man_link . '" />' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/' . $ru_man_link . '" />' . "\r\n";
            $output .= '<changefreq>weekly </changefreq>';
            $output .= '<priority>0,7</priority>';
            $output .= '</url>' . "\r\n";
        }



        $this->load->model('catalog/information');
        $informations = $this->model_catalog_information->getInformations();
;

        foreach ($informations as $information) {


            $inf_links = $this->model_catalog_information->getInfUrlsWithLang($information['information_id']);
            

            $ua_inf_link = '';
            $ru_inf_link = '';

            if (!empty($inf_link[1]['keyword']))
                $ua_inf_link = $inf_links[1]['keyword'];

            if (!empty($inf_link[0]['keyword']))
                $ru_inf_link = $inf_links[0]['keyword'];

            if (empty($ua_inf_link)) {
                continue;
            }
            if (empty($ru_inf_link)) {
                continue;
            }
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/' . $ua_inf_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/' . $ru_inf_link . '" />' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/' . $ua_inf_link . '" />' . "\r\n";
            $output .= '<changefreq>monthly</changefreq>';
            $output .= '<priority>0,5</priority>';
            $output .= '</url>' . "\r\n";
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/' . $ru_inf_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/' . $ua_inf_link . '" />' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/' . $ru_inf_link . '" />' . "\r\n";
            $output .= '<changefreq>monthly</changefreq>';
            $output .= '<priority>0,5</priority>';
            $output .= '</url>' . "\r\n";
        }
        $output .= '</urlset>' . "\r\n";
//        $this->response->addHeader('Content-Type: application/xml');
//        $this->response->setOutput($output);
        header("Content-type: text/xml");
        echo $output;
    }


    protected function getCategories($parent_id, $current_path = '')
    {
        $output = '';
        $results = $this->model_catalog_category->getCategories($parent_id);
        foreach ($results as $result) {
            $cat_links = $this->model_catalog_category->getCategoryUrlsWithLang($result['category_id']);

            $ua_cat_link = '';
            $ru_cat_link = '';


            foreach ($cat_links as $link){
                if($link['language_id'] == 2){
                    $ru_cat_link = $link['keyword'];
                }elseif ($link['language_id'] == 3){
                    $ua_cat_link = $link['keyword'];
                }
            }

            //if (!empty($cat_links[1]['keyword']))
                //$ua_cat_link = $cat_links[1]['keyword'];


            //if (!empty($cat_links[0]['keyword']))
                //$ru_cat_link = $cat_links[0]['keyword'];

            if (empty($ua_cat_link)) {
                continue;
            }
            if (empty($ru_cat_link)) {
                continue;
            }
            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/' . $ua_cat_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="ru" href="https://smobile.ua/ru/' . $ru_cat_link . '" />' . "\r\n";
            $output .= '<changefreq>daily</changefreq>';
            $output .= '<priority>0,9</priority>';
            $output .= '</url>' . "\r\n";


            $output .= '<url>' . "\r\n";
            $output .= '  <loc>https://smobile.ua/' . $ru_cat_link . '</loc>' . "\r\n";
            $output .= '  <xhtml rel="alternate" hreflang="uk" href="https://smobile.ua/' . $ua_cat_link . '" />' . "\r\n";
            $output .= '<changefreq>daily</changefreq>';
            $output .= '<priority>0,9</priority>';
            $output .= '</url>';
        }
        return $output;
    }
}