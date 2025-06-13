<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once('config.php');
    require_once(DIR_SYSTEM . 'startup.php');
    $registry = new Registry();
    $config = new Config();
    $registry->set('config', $config);
    $db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    $query = $db->query("SELECT * FROM oc_product WHERE status = '1' AND stock_status_id = 8;");

    $preorder_products = [];
    foreach ($query->rows as $product){
        $preorder_products[$product['model']] = [
            'product_id' => $product['product_id'],
            'model' => $product['model'],
            'sku' => $product['sku']
        ];
    }
    /*
    $preorder_products['1654265955'] = [
        product_id => ''
        model => ''
        sku => ''
    ];
    */

$input_xml = file_get_contents('https://smobile.salesdrive.me/export/yml/export.yml?publicKey=BcjIQ3B080HA2Led_yWO0psR2ieoDl-dKIRaA7mmS5H4OUV63Mpxb6B7194c');


$xml = new SimpleXMLElement($input_xml);

// Внести зміни до XML
foreach ($xml->xpath('//offer') as $key => &$offer) {

    $offerId = (string) $offer['id'];

    if (isset($offer->oldprice)) {

        if($offer->price != 0) {
            // Створити новий елемент <sale_price> і скопіювати в нього значення з <price>
            $salePrice = $offer->addChild('sale_price', $offer->price);
        }
        // Видалити старий елемент <price>
        unset($offer->price[0]);

        // Перенести значення з <oldprice> до нового елемента <price>
        $newPrice = $offer->addChild('price', $offer->oldprice);
//        $newPrice = $offer->addChild('price_clear', '');

        // Видалити старий елемент <oldprice>
        unset($offer->oldprice[0]);

    }else{
        $salePrice = $offer->addChild('sale_price', '');
    }

    /*
     * Встановлюємо залишок 100 для товарів "передзамовлення"
     */

    if($_GET['q'] == 'q') {
        if ($preorder_products[$offerId]) {
          if($offer->quantity_in_stock == 0){
              $offer->quantity_in_stock = 1003;
          }
        }
    }

    if(isset($offer->note)){
        $note = (string) $offer->note; // Отримання інформації з тегу <note>

        // attribute_group_name:attribute_name:value
        $attr_sale_type = [];
        $attr_sale_type_ru = [];
        if(strpos($note, 'Распродажа') !== false){
            $attr_sale_type[] = "Розпродаж";
            $attr_sale_type_ru[] = "Распродажа";
        }

        if(strpos($note, 'Акционный') !== false){
            $attr_sale_type[] = "Акція";
            $attr_sale_type_ru[] = "Акция";
        }

        if(strpos($note, 'Хит') !== false){
            $attr_sale_type[] = "Хіт";
            $attr_sale_type_ru[] = "Хит";
        }

        if(strpos($note, 'Новый') !== false){
            $attr_sale_type[] = "Новий";
            $attr_sale_type_ru[] = "Новый";
        }

        if(strpos($note, 'Активный') !== false){
            $attr_sale_type[] = "Активний";
            $attr_sale_type_ru[] = "Активный";
        }

        if(strpos($note, 'Архивный') !== false){
            $attr_sale_type[] = "Архівний";
            $attr_sale_type_ru[] = "Архивный";
        }




        $attr_sale_type_txt = implode(', ', $attr_sale_type);
        $attr_sale_type_ru_txt = implode(', ', $attr_sale_type_ru);
        $offer->addChild('sale_type', $attr_sale_type_txt);
        $offer->addChild('sale_type_ru', $attr_sale_type_ru_txt);

    }else{
        $offer->addChild('sale_type', "");
        $offer->addChild('sale_type_ru', "");
    }
}
header('Content-Type: application/xml');
echo $xml->asXML();