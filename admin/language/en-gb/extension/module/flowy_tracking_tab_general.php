<?php
$_['tab_general'] = 'General';
$_['legend_general'] = 'General status';
$_['status'] = 'Flowy Tracking status';
$_['text_extensions'] = 'Extensions';
$_['help'] = 'Insert here the GTM-XXXXX extracted from your Google tag manager account.';
$_['legend_google_tag_manager'] = 'Google Tag Manager - Configuration <b>REQUIRED</b>';
$_['container_id'] = 'GTM Container ID';
$_['container_id_help'] = '<b>REQUIRED</b>. Login into Tag Manager panel and complete the following <b>GTM-XXXXXXX</b>';
$_['google_analytics_ee_legend'] = 'GA4 Enhanced Ecommerce - Configuration';
$_['google_ee_product_id_like'] = 'Product ID';
$_['google_ee_product_id_like_help'] = 'The product identificator selected will be sent to <b>Google Analytics Enhanced ecommerce</b>. If the identificator is not found, the <b>Product ID</b> is set by default.';
$_['multichannel_funnel'] = 'GA Multichannel-Funnel status';
$_['multichannel_funnel_help'] = 'Enable this and select field to configure the conversion path for google analytics allowing you to generate custom reports on what lead to your sale';
$_['multichannel_funnel_action_visit_product_page'] = 'Visit product page';
$_['multichannel_funnel_action_add_to_cart'] = 'Add product to cart';
$_['multichannel_funnel_action_visit_cart_page'] = 'Visit cart page';
$_['multichannel_funnel_action_visit_checkout_page'] = 'Visit checkout page';
$_['multichannel_funnel_action_finish_order'] = 'Finish order';
$_['multichannel_step_1'] = 'Step 1';
$_['multichannel_step_2'] = 'Step 2';
$_['multichannel_step_3'] = 'Step 3';
$_['multichannel_step_4'] = 'Step 4';
$_['multichannel_step_5'] = 'Step 5';
$_['google_ads_legend'] = 'Google Ads / Dynamic remarketing - Configuration';
$_['google_product_id_like'] = 'Product Identification';
$_['google_product_id_like_help'] = 'Select what unique value is used to identify your products for tracking <b>Most commonly product ID</b>. If identificator not found, <b>Product ID</b> is set by default.';
$_['dynamic_remarketing_dynx2'] = 'Secondary Product Identification';
$_['dynamic_remarketing_dynx2_product_id'] = 'Product ID';
$_['dynamic_remarketing_dynx2_model'] = 'Model';
$_['dynamic_remarketing_dynx2_sku'] = 'SKU';
$_['dynamic_remarketing_dynx2_upc'] = 'UPC';
$_['dynamic_remarketing_dynx2_ean'] = 'EAN';
$_['dynamic_remarketing_dynx2_jan'] = 'JAN';
$_['dynamic_remarketing_dynx2_isbn'] = 'ISBN';
$_['dynamic_remarketing_dynx2_mpn'] = 'MPN';
$_['dynamic_remarketing_dynx2_location'] = 'Location';
$_['google_reviews_legend'] = 'Google Reviews - Configuration';
$_['google_reviews_status'] = 'Google Reviews status';
$_['google_reviews_status_help'] = 'Click this to enable and configuire Google reviews, this allows you to track and show google reviews';
$_['google_reviews_gtin'] = 'Add product GTIN';
$_['google_reviews_gtin_help'] = 'Required from some countries/feeds. Choose GTIN used in your feed.';
$_['google_reviews_gtin_none'] = 'Nothing selected';
$_['google_reviews_gtin_mpn'] = 'MPN';
$_['google_reviews_gtin_model'] = 'Model';
$_['google_reviews_gtin_ean'] = 'EAN';
$_['google_reviews_gtin_upc'] = 'UPC';
$_['fb_pixel_legend'] = 'Facebook Pixel / API conversions - Configuration';
$_['another_configuration_legend'] = 'Generic configuration';
$_['debug_mode'] = 'Debug mode';
$_['debug_mode_help'] = 'When you are logged like admin user, a popoup will appear in frontend zone, which show dataLayer sent to Google tag manager and Facebook conversions API queries';
$_['positive_conversion_status_id'] = 'Conversions: Valid order status';
$_['positive_conversion_status_id_help'] = 'When a customer finishes their order, the conversion will be triggered if their order status marked in this list (if empty, all order statuses will be considered valid). <b>IF YOU DON\'T KNOW DEFAULT ORDER STATUS AFTER ORDER IS CREATED, DO NOT SELECT ANY OPTION, CONVERSIONS WILL NOT BE TRACKED.</b>';

$_['custom_url_checkout_cart'] = 'Custom checkout/cart url';
$_['custom_url_checkout_cart_help'] = 'If your checkout/cart url is not <b>'.HTTPS_CATALOG.'index.php?route=checkout/cart</b>, you can set in this field your custom urls separated by comma, examples:<br>
    - '.HTTPS_CATALOG.'<b>view-cart</b><br><br>
    In this example, you would have to set:  "<b>view-cart</b>"
    ';

$_['custom_url_checkout_checkout'] = 'Custom checkout/checkout url';
$_['custom_url_checkout_checkout_help'] = 'If your checkout/checkout url is not <b>'.HTTPS_CATALOG.'index.php?route=checkout/checkout</b>, you can set in this field your custom urls separated by comma, examples:<br>
    - '.HTTPS_CATALOG.'<b>finish-checkout</b><br>
    In this example, you would have to set:  "<b>finish-checkout</b>"
    ';

$_['custom_url_checkout_success'] = 'Custom checkout/success url';
$_['custom_url_checkout_success_help'] = 'If your checkout/success url is not <b>'.HTTPS_CATALOG.'index.php?route=checkout/success</b>, you can set in this field your custom urls separated by comma, examples:<br>
    - '.HTTPS_CATALOG.'index.php?route=<b>visa/success</b><br>
    - '.HTTPS_CATALOG.'<b>order-success</b><br><br>
    
    In this example, you would have to set:  "<b>visa/success,order-success</b>"
    ';

?>