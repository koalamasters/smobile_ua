<?php
class ControllerExtensionFeedUnixmlBesplatka extends Controller {
  public function index() {

    $feed = 'besplatka';
    $controller = str_replace($feed, 'startup', $this->request->get['route']);
    $startup = $this->load->controller($controller, array('feed'=>$feed));
    $xml = false;

    //XML_body
      //headerXML
      $xml .= '<yml_catalog date="' . date('Y-m-d H:i', time()) . '">';
      $xml .= '<shop>';
      $xml .= '<url>' . HTTPS_SERVER . '</url>';
      $xml .= '<name>' . $this->config->get('config_name') . '</name>';
      $xml .= '<company>' . $startup['name'] . '</company>';
      $xml .= '<phone>' . $this->config->get('config_telephone') . '</phone>';

      if($startup['categories_xml']) {
        $xml .= '<categories>';
        foreach($startup['categories_xml'] as $category) {
          if($category['parent_id']){
            $xml .= '<category id="' . $category['category_id'] .'" parentId="' . $category['parent_id'] . '">' . $category['name'] .'</category>';
          } else{
            $xml .= '<category id="' . $category['category_id'] .'">' . $category['name'] .'</category>';
          }
        }
        $xml .= '</categories>';
      }

      $xml .= '<offers>';

      $xml = $this->unixml->exportToXml($startup, $xml, "start");
      //headerXML

      //generateXML
        for($startup['iteration'] = 0; 1; $startup['iteration']++){

          $controller_data = $this->load->controller($controller, $startup);
          $startup['stat'] = $controller_data['data']['stat'];

          if($controller_data['products']){

            foreach($controller_data['products'] as $product_id => $product){
              $seltype = 'r';
              if(isset($product['prices'])){$seltype = 'u';}
              $xml .= '<offer id="' . $product_id . '" available="' . ($product['stock']?'true':'false') .'" selling_type="' . $seltype .'">';
              $xml .= '<name>' . $product['name'] .  '</name>';
              $xml .= '<vendorCode>' . $product['model'] .  '</vendorCode>';
              $xml .= '<url>' . $product['url'] .  '</url>';
              $xml .= '<currencyId>UAH</currencyId>';
              $xml .= '<categoryId>' . $product['category_id'] .  '</categoryId>';

              if($product['special']){
                $xml .= '<price>' . $product['special'] .  '</price>';
                $xml .= '<oldprice>' . $product['price'] .  '</oldprice>';
              }else{
                $xml .= '<price>' . $product['price'] .  '</price>';
              }

              if(isset($product['prices'])){
                $xml .= '<prices>';
                foreach($product['prices'] as $price){
                  $xml .= '<price>';
                    $xml .= '<value>' . $price['price'] . '</value>';
                    $xml .= '<quantity>' . $price['quantity'] . '</quantity>';
                  $xml .= '</price>';
                }
                $xml .= '</prices>';
              }

              $xml .= '<picture>' . $product['image'] .  '</picture>';
              if($product['images']){
                foreach($product['images'] as $image){
                  $xml .= '<picture>' . $image .  '</picture>';
                }
              }
              $xml .= '<vendor>' . $product['manufacturer'] .  '</vendor>';
              $xml .= '<description><![CDATA[' . $product['description'] .  ']]></description>';
              $xml .= '<available>' . ($product['stock']?'true':'false') .  '</available>';
              $xml .= '<quantity_in_stock>' . $product['quantity'] .  '</quantity_in_stock>';
              foreach($product['attributes_full'] as $attribute){
                $xml .= '<' . $attribute['name'] . '>' . $attribute['text'] .  '</' . $attribute['end'] . '>';
              }
              foreach($product['attributes'] as $attribute){
                $xml .= '<param name="' . $attribute['name'] . '">' . $attribute['text'] .  '</param>';
              }
              $xml .= '</offer>';
            }
          } else {
            break;
          }

          $xml = $this->unixml->exportToXml($controller_data['data'], $xml);
        }
      //generateXML

      //footerXML
      $xml .= '</offers>';
      $xml .= '</shop>';
      $xml .= '</yml_catalog>';

      $this->unixml->exportToXml($controller_data['data'], $xml, "finish");
      //footerXML
    //XML_body

  }
}
