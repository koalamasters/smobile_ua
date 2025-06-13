<?php
error_reporting(E_ALL ^ E_NOTICE);
class ControllerToolGooglemerchant extends Controller {
    public function index(){

        $this->session->data['language'] = 'uk-ua';

        $google_cats = [
            "84671487" => "249",
            "81513177" => "249",
            "109430578" => "249",
            "81513067" => "249",
            "82224361" => "2345",
            "82250637" => "2345",
            "82250644" => "2345",
            "109430558" => "5466",
            "109182673" => "7530",
            "109430556" => "7530",
            "109430555" => "7530",
            "109182808" => "7530",
            "109430569" => "7530",
            "109182806" => "7530",
            "109182675" => "7530",
            "109182805" => "7530",
            "82465588" => "505295",
            "82637259" => "505295",
            "82637243" => "505295",
            "84746348" => "505295",
            "82638991" => "505771",
            "82042261" => "505771",
            "82042209" => "505771",
            "82049507" => "505771",
        ];

//        $this->language->set('uk-ua');

        $output = '<?xml version="1.0"?>'."\n";
        $output .= '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">'."\n";
        $output .= '<title>SMobile Google Merchant</title>'."\n";
        $output .= '<link rel="self" href="https://smobile.ua/"/> '."\n";
        $output .= '<description>SMobile - торгові оголошення інтернет магазину</description>'."\n";

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');

        $products_list = $this->model_catalog_product->getProducts();
        $products = [];
        foreach ($products_list as $product){
            if($product['quantity'] > 0 && $product["image"] != '')
                $products[] = $product;
        }

        $this->load->model('tool/image');
        $all_cats = [];

        foreach ($products as $key => $product) {
            if($product['product_id'] == '1654265687'){
                continue;
            }

            $description = "Замовляйте онлайн ".$product['name']." від компанії ".$product['manufacturer']." з можливістю повернення та обміну та доставкою по всій Україні. Модель - ".$product['sku'].".";

            $attribute_groups = $this->model_catalog_product->getProductAttributesUa($product['product_id']);
            $material = '';
            $color = '';
            $product_highlights = [];
            if(isset($attribute_groups[0])) {
                foreach ($attribute_groups[0]['attribute'] as $key => $attribute) {
                    if ($attribute['attribute_id'] == 61) {
                        $color = '<g:color>' . $attribute['text'] . '</g:color>';
                        continue;
                    }

                    $product_highlights[] = [
                        'name' => $attribute['name'],
                        'value' => $attribute['text'],
                    ];

                    if($attribute['attribute_id'] == 75){
                        $material = $attribute['text'];
                    }
                }
            }

            $cats = $this->model_catalog_product->getCategories($product['product_id']);
            $product_cats = [];

            foreach ($cats as $cat){
                $cat_info = $this->model_catalog_category->getCategoryUa($cat['category_id']);

                if(isset($cat_info['category_id'])) {
                    $all_cats[$cat_info['category_id']] = $cat_info['name'];

                    $product_cats[$cat_info['category_id']] = $cat_info['name'];
                }
            }

            $cats_id = array_keys($product_cats);
            $google_cat = 0;
			
            foreach ($product_cats as $cat_id=>$product_cat){
                if(isset($google_cats[$cat_id])) {
                    if ($google_cats[$cat_id] && $google_cat == 0) {
                        $google_cat = $google_cats[$cat_id];
                    }
                }
            }

            if($google_cat == 0){
                $google_cat = 222;
            }

//			Старі умови для custom_label (закоментовані в рамках завдання №20357)
            /*$custom_label_0 = 'other';
            $custom_label_1 = '';
            if(in_array(84671487,$cats_id)){
                $custom_label_0 = 'acoustics';
            }
            if(in_array(82638991,$cats_id)){
                $custom_label_0 = 'headphones';
            }
            if(in_array(83025766,$cats_id) && $material != 'MagEZ Case 5'){
                $custom_label_0 = 'iphone_case';
            }
            if(in_array(83025766,$cats_id) && $material == 'MagEZ Case 5' && $product['manufacturer'] == 'Pitaka'){ // Чохли до IPhone
                $custom_label_0 = 'iphone15_pitaka';
            }
            if(in_array(109430579,$cats_id)){
                $custom_label_1 = 'i15';
            }
            if(in_array(109430582,$cats_id)){
                $custom_label_1 = 'i15';
            }
            if(in_array(109430580,$cats_id)){
                $custom_label_1 = 'i15';
            }
            if(in_array(109430581,$cats_id)){
                $custom_label_1 = 'i15';
            }
            if(in_array(109430557,$cats_id)){
                $custom_label_0 = 'tedee';
            }*/

//			Нові умови для custom_label (додані в рамках завдання №20357 та №20677 та №20885)
            $custom_label_0 = 'other';
            if(
				$product['mpn'] == "1006262" ||
				$product['mpn'] == "1005924" ||
				$product['mpn'] == "1006059" ||
				$product['mpn'] == "1006004" ||
				$product['mpn'] == "1006010" ||
				$product['mpn'] == "1006016" 
			){
                $custom_label_0 = 'speakers';
            }elseif(
				$product['mpn'] == "1005773" ||
				$product['mpn'] == "1006127" ||
				$product['mpn'] == "1005983" ||
				$product['mpn'] == "4090939" ||
				$product['mpn'] == "4090940"
			){
                $custom_label_0 = 'headphones';
            }elseif(
				$product['mpn'] == "SL2301" ||
				$product['mpn'] == "PD1001" ||
				$product['mpn'] == "ST-TCAW7CM" ||
				$product['mpn'] == "ZEDC24W/00" ||
				$product['mpn'] == "ZEDC19B/00" ||
				$product['mpn'] == "ZEDC21B/00" ||
				$product['mpn'] == "ZEDC05BM/00" ||
				$product['mpn'] == "ZESC16B/00" ||
				$product['mpn'] == "ZESC14B/00" ||
				$product['mpn'] == "ZEAPM03/00" ||
				$product['mpn'] == "ZEAPDC01/00" ||
				$product['mpn'] == "ZEDC22B/00" ||
				$product['mpn'] == "ZEDC05W/00" ||
				$product['mpn'] == "ZEDC05BM/00" ||
				$product['mpn'] == "ZEDC19B/00" ||
				$product['mpn'] == "ZESC16B/00" ||
				$product['mpn'] == "ZEDC21B/00" ||
				$product['mpn'] == "ZEDC22W/00" ||
				$product['mpn'] == "ST-MCMWCM " ||
				$product['mpn'] == "ST-TCPDCCM"
			){
                $custom_label_0 = 'Wireless';
				/*}elseif(
					$product['mpn'] == "FAST-PD140-BLK-EU" ||
					$product['mpn'] == "FAST-PD30-2-BLK-EU" ||
					$product['mpn'] == "FAST-PD30-2-WHT-EU" ||
					$product['mpn'] == "FAST-PD35-BLK-EU" ||
					$product['mpn'] == "FAST-PD35-WHT-EU" ||
					$product['mpn'] == "FAST-PD67-BLK-INT" ||
					$product['mpn'] == "FAST-PD67-WHT-INT" ||
					$product['mpn'] == "ST-TC100GM-EU" ||
					$product['mpn'] == "ST-W145GTM" ||
					$product['mpn'] == "ST-UC165GM-EU" ||
					$product['mpn'] == "ST-C200GM-EU" ||
					$product['mpn'] == "ST-UC20WCM-EU"
				){
                $custom_label_0 = 'Wall';*/
				/*}elseif(
					$product['mpn'] == "ST-TCPDCCM" ||
					$product['mpn'] == "CM003" ||
					$product['mpn'] == "CM2303N" ||
					$product['mpn'] == "CM2302T" ||
					$product['mpn'] == "ST-MCMWCM"
				){
					$custom_label_0 = 'Car';*/
            }elseif(
				$product['mpn'] == "ST-UC4PHM" ||
				$product['mpn'] == "ST-TCENM" ||
				$product['mpn'] == "ST-UCHSEM" ||
				$product['mpn'] == "ST-TCMA2G" ||
				$product['mpn'] == "ST-CMAS" ||
				$product['mpn'] == "ST-UCMBAM" ||
				$product['mpn'] == "ST-CMAM" ||
				$product['mpn'] == "ST-SCMA2M" ||
				$product['mpn'] == "ST-UCSMA3K" ||
				$product['mpn'] == "ST-UCSMA3S" ||
				$product['mpn'] == "ST-TCUAM" ||
				$product['mpn'] == "ST-UCPHMXS" ||
				$product['mpn'] == "ST-UCPHMIS" ||
				$product['mpn'] == "ST-UCPHMXM" ||
				$product['mpn'] == "ST-HUCPHSD" ||
				$product['mpn'] == "ST-TAUCS" ||
				$product['mpn'] == "ST-SCMA2S" ||
				$product['mpn'] == "ST-TAUCM" ||
				$product['mpn'] == "ST-TCUAS" ||
				$product['mpn'] == "ST-AE25M" ||
				$product['mpn'] == "ST-UCMXAM" ||
				$product['mpn'] == "ST-UCATCM" ||
				$product['mpn'] == "ST-HUCPHSM"
			){
                $custom_label_0 = 'Adapter';
            }elseif(
				$product['mpn'] == "99MO231008" ||
				$product['mpn'] == "99MO231112" ||
				$product['mpn'] == "99MO231104" ||
				$product['mpn'] == "99MO231108" ||
				$product['mpn'] == "RECLA-BLK-NP23PM" ||
				$product['mpn'] == "RECLA-GRN-NP23PM" ||
				$product['mpn'] == "RECLE-TRA-NP23PM" ||
				$product['mpn'] == "NA54FA09" ||
				$product['mpn'] == "NA54FA01" ||
				$product['mpn'] == "NA54FA12" ||
				$product['mpn'] == "NA54FA13" ||
				$product['mpn'] == "NA54SL00" ||
				$product['mpn'] == "NA54GR09" ||
				$product['mpn'] == "NA54GR10" ||
				$product['mpn'] == "NA54GR12" ||
				$product['mpn'] == "NA54GR15" ||
				$product['mpn'] == "NA54SU11" ||
				$product['mpn'] == "NA54SU01" ||
				$product['mpn'] == "NA54SU06" ||
				$product['mpn'] == "99MO231003" ||
				$product['mpn'] == "99MO231007" ||
				$product['mpn'] == "99MO231111" ||
				$product['mpn'] == "99MO231103" ||
				$product['mpn'] == "99MO231107" ||
				$product['mpn'] == "RECLA-BLK-NP23P" ||
				$product['mpn'] == "RECLA-KFT-NP23P" ||
				$product['mpn'] == "RECLA-GRN-NP23P" ||
				$product['mpn'] == "RECLE-TRA-NP23P" ||
				$product['mpn'] == "NA53FA09" ||
				$product['mpn'] == "NA53FA01" ||
				$product['mpn'] == "NA53FA13" ||
				$product['mpn'] == "NA53SL00" ||
				$product['mpn'] == "NA53SL02" ||
				$product['mpn'] == "NA53SL01" ||
				$product['mpn'] == "NA53SL03" ||
				$product['mpn'] == "NA53GR09" ||
				$product['mpn'] == "NA53GR10" ||
				$product['mpn'] == "NA53GR12" ||
				$product['mpn'] == "NA53GR15" ||
				$product['mpn'] == "NA53SU11" ||
				$product['mpn'] == "NA53SU01" ||
				$product['mpn'] == "NA53SU06" ||
				$product['mpn'] == "99MO231001" ||
				$product['mpn'] == "99MO231005" ||
				$product['mpn'] == "99MO231109" ||
				$product['mpn'] == "99MO231101" ||
				$product['mpn'] == "99MO231105" ||
				$product['mpn'] == "RECLA-BLK-NP23" ||
				$product['mpn'] == "RECLA-KFT-NP23" ||
				$product['mpn'] == "RECLA-GRN-NP23" ||
				$product['mpn'] == "RECLE-TRA-NP23" ||
				$product['mpn'] == "NA51FA09" ||
				$product['mpn'] == "NA51FA01" ||
				$product['mpn'] == "NA51FA12" ||
				$product['mpn'] == "NA51FA13" ||
				$product['mpn'] == "NA51SL00" ||
				$product['mpn'] == "NA51SL02" ||
				$product['mpn'] == "NA51SL01" ||
				$product['mpn'] == "NA51SL03" ||
				$product['mpn'] == "NA51GR09" ||
				$product['mpn'] == "NA51GR10" ||
				$product['mpn'] == "NA51GR12" ||
				$product['mpn'] == "NA51GR15" ||
				$product['mpn'] == "NA51SU00" ||
				$product['mpn'] == "NA51SU11" ||
				$product['mpn'] == "NA51SU01" ||
				$product['mpn'] == "NA51SU06" ||
				$product['mpn'] == "NA52FA09" ||
				$product['mpn'] == "NA52FA01" ||
				$product['mpn'] == "NA52FA12" ||
				$product['mpn'] == "NA52FA13" ||
				$product['mpn'] == "NA52SL00" ||
				$product['mpn'] == "NA52SL02" ||
				$product['mpn'] == "NA52SL01" ||
				$product['mpn'] == "NA52SL03" ||
				$product['mpn'] == "NA52GR09" ||
				$product['mpn'] == "NA52GR10" ||
				$product['mpn'] == "NA52GR12" ||
				$product['mpn'] == "NA52GR15" ||
				$product['mpn'] == "NA52SU00" ||
				$product['mpn'] == "NA52SU11" ||
				$product['mpn'] == "NA52SU01" ||
				$product['mpn'] == "NA52SU06" ||
				$product['mpn'] == "NA44GL00U" ||
				$product['mpn'] == "NA44GL05U" ||
				$product['mpn'] == "NA44SL01" ||
				$product['mpn'] == "NA43GL00U" ||
				$product['mpn'] == "NA43GL05U" ||
				$product['mpn'] == "EAPP2CL-HANG-ABL" ||
				$product['mpn'] == "EAPP2CL-HANG-LV" ||
				$product['mpn'] == "EAPP2CL-HANG-LPK" ||
				$product['mpn'] == "EAPP2RH-HANG-WH" ||
				$product['mpn'] == "EAPP2SC-BA+ROSTR-JIN" ||
				$product['mpn'] == "EAPP2SC-BA+ROSTR-LV" ||
				$product['mpn'] == "EAPP2SC-BA+ROSTR-LPK" ||
				$product['mpn'] == "EAPP2SC-BA+ROSTR-MT" ||
				$product['mpn'] == "EAPP2SC-BA+ROSTR-PGR" ||
				$product['mpn'] == "EAPP2SC-ORHA-BK" ||
				$product['mpn'] == "EAPP2SC-ORHA-JIN" ||
				$product['mpn'] == "EAPP2SC-ORHA-LUBL" ||
				$product['mpn'] == "APPRO2-LTHR-KFT" ||
				$product['mpn'] == "APPRO2-ROAM-KFT-NP"
			){
                $custom_label_0 = 'iphone_case';
            }elseif(
				$product['mpn'] == "FO1501PM" ||
				$product['mpn'] == "FR1501PM" ||
				$product['mpn'] == "KI1502PMYG" ||
				$product['mpn'] == "KI1502POTH" ||
				$product['mpn'] == "KI1508PM" ||
				$product['mpn'] == "KI1501PM" ||
				$product['mpn'] == "KI1501PMA" ||
				$product['mpn'] == "KI1501BTLM" ||
				$product['mpn'] == "KI1501MOM" ||
				$product['mpn'] == "KI1501SUM" ||
				$product['mpn'] == "KI1508PMPA" ||
				$product['mpn'] == "KI1501PMP" ||
				$product['mpn'] == "KI1501PMPA" ||
				$product['mpn'] == "FO1501P" ||
				$product['mpn'] == "FR1501P" ||
				$product['mpn'] == "KI1501PMYG" ||
				$product['mpn'] == "KI1501POTH" ||
				$product['mpn'] == "KI1508P" ||
				$product['mpn'] == "KI1501P" ||
				$product['mpn'] == "KI1501PA" ||
				$product['mpn'] == "KI1501BTL" ||
				$product['mpn'] == "KI1501MO" ||
				$product['mpn'] == "KI1501SU" ||
				$product['mpn'] == "KI1508PPA" ||
				$product['mpn'] == "KI1501PP" ||
				$product['mpn'] == "KI1501PPA" ||
				$product['mpn'] == "KI1508" ||
				$product['mpn'] == "KI1501" ||
				$product['mpn'] == "KI1501MMP" ||
				$product['mpn'] == "KI1501M" ||
				$product['mpn'] == "KI1401PMA" ||
				$product['mpn'] == "FO1401P" ||
				$product['mpn'] == "FR1401P" ||
				$product['mpn'] == "KI1401PP" ||
				$product['mpn'] == "KI1401P" ||
				$product['mpn'] == "KI1401PA" ||
				$product['mpn'] == "KI1401M" ||
				$product['mpn'] == "KI1401" ||
				$product['mpn'] == "APM8001" ||
				$product['mpn'] == "APM7001"
			){
                $custom_label_0 = 'Pitaka';
				/*}elseif(
					$product['mpn'] == "KW2301A" ||
					$product['mpn'] == "KW2302A" ||
					$product['mpn'] == "KW2002A" ||
					$product['mpn'] == "KW3001A" ||
					$product['mpn'] == "AWB2307" ||
					$product['mpn'] == "AWB2311" ||
					$product['mpn'] == "AWB2308" ||
					$product['mpn'] == "AWB2303" ||
					$product['mpn'] == "AWB2302" ||
					$product['mpn'] == "AWB2306" ||
					$product['mpn'] == "AWB2305"
				){
					$custom_label_0 = 'Straps';*/
            }
			
            if(in_array(109430596, $cats_id)){
                $custom_label_0 = 'Car';
            }
            if(in_array(82637301, $cats_id)){
                $custom_label_0 = 'Stand';
            }
            if(in_array(109430590, $cats_id)){
                $custom_label_0 = 'Peripherals';
            }
            if(in_array(109430587, $cats_id)){
                $custom_label_0 = 'Straps';
            }
            if(in_array(82637243, $cats_id)){
                $custom_label_0 = 'Charger';
            }
			
            $custom_label_2 = '';
			if(
				$product['mpn'] == "1006034" ||
				$product['mpn'] == "1006262" ||
				$product['mpn'] == "1005544" ||
				$product['mpn'] == "1005924"
			){
                $custom_label_2 = 'sale28_05';
            }
//			Нові умови для custom_label (додані в рамках завдання №20357 та №20677 та №20885)
			
			
			

            $product_images = [];
            $product_images = $this->model_catalog_product->getProductImages($product['product_id']);

//            $desc = substr(strip_tags(html_entity_decode($product['description'])), 0, 4999);
//            $desc = str_replace('&nbsp', '', $desc);

            $image = 'https://smobile.ua/image/' . $product["image"];
            $product_cats = array_reverse($product_cats);
            $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            $price = str_replace([' ', 'грн'], ['', ' UAH'], $price);
			
			// Додаємо ціну зі знижкою
			$sale_price = "";
			$sale_price = $product['special'];
            $sale_price = str_replace([' ', '.0000'], ['', ' UAH'], $sale_price);

            $output .= '<entry>' . "\n";
            $output .= '<g:id>' . $product['product_id'] . '</g:id>' . "\n";

            if($product['image']){
                $output .= '<g:image_link>https://smobile.ua/image/' . $product['image'] . '</g:image_link>' . "\n";
            }

            if($product_images){
                foreach ($product_images as $product_image){
                    $output .= '<g:additional_image_link>https://smobile.ua/image/'.$product_image['image'].'</g:additional_image_link>' . "\n";

                }
            }
            $output .= '<g:title>' . $product['name'] . '</g:title>' . "\n";
            $output .= '<g:description>'.$description.'</g:description>'."\n";
            $output .= '<g:link>' . str_replace('http:', 'https:', $this->url->link('product/product', 'product_id=' . $product['product_id'])) . '</g:link>' . "\n";
            $output .= '<g:condition>new</g:condition>' . "\n";
            $output .= '<g:availability>in stock</g:availability>' . "\n";
            $output .= '<g:price>' . trim($price) . '</g:price>' . "\n";
           if($sale_price != "") {
               $output .= '<g:sale_price>' . $sale_price . '</g:sale_price>' . "\n";
           }
            $output .= '<g:brand>' . $product['manufacturer'] . '</g:brand>' . "\n";
            $output .= '<g:product_type>' . implode(' > ',$product_cats) . '</g:product_type>' . "\n";
            $output .= '<g:google_product_category>'.$google_cat.'</g:google_product_category>'. "\n";
            $output .= '<g:custom_label_0>'.$custom_label_0.'</g:custom_label_0>'. "\n";
           if($custom_label_1) {
               $output .= '<g:custom_label_1>' . $custom_label_1 . '</g:custom_label_1>' . "\n";
           }
           if($custom_label_2) {
               $output .= '<g:custom_label_2>' . $custom_label_2 . '</g:custom_label_2>' . "\n";
           }


            if($product['mpn']){
                $output .='<g:mpn>'.$product['mpn'].'</g:mpn>';
                $output .= '<g:identifier_exists>yes</g:identifier_exists>';
            }else{
                $output .= '<g:identifier_exists>no</g:identifier_exists>';
            }


            foreach ($product_highlights as $highlight){
                $output .= '<g:product_highlight>'.$highlight['name'].': '.$highlight['value'].'</g:product_highlight>'."\n";
            }

            if($color){
                $output .= $color;
            }

//            foreach ($images as $img){
//                $img_link = $this->model_tool_image->resize($img['image'], 650, 650,'product_popup');
//                $output .= '<g:additional_image_link>'.$img_link.'</g:additional_image_link>'."\n";
//            }
//            $output .= '<g:identifier_exists>no</g:identifier_exists>'."\n";

            $output .= '</entry>' . "\n";
        }

        $output .= ' </feed>' . "\n";

//        $this->response->addHeader('Content-Type: application/xml');
//        $this->response->setOutput($output);

        header("Content-type: text/xml");
        echo $output;
    }

    protected function getPath($parent_id, $current_path = '') {
        $category_info = $this->model_catalog_category->getCategory($parent_id);

        if ($category_info) {
            if (!$current_path) {
                $new_path = $category_info['category_id'];
            } else {
                $new_path = $category_info['category_id'] . '_' . $current_path;
            }

            $path = $this->getPath($category_info['parent_id'], $new_path);

            if ($path) {
                return $path;
            } else {
                return $new_path;
            }
        }
    }



    function str2url($str) {
        // переводимо в трансліт
        $str = $this->rus2translit($str);
        // в нижній регістр
        $str = strtolower($str);
        // Замінюємо все зайве на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // Чистимо '-' на початку і в кінці
        $str = trim($str, "-");

        $str = str_replace('--', '-',$str);
        $str = str_replace('--', '-',$str);
        return $str;
    }

    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            'і' => 'i',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            'І' => 'I',
        );
        return strtr($string, $converter);
    }

    public function translit($string = '') {


        return $this->str2url($string);





    }

}
