<?php
// Heading
$_['heading_title'] = 'Whitepay Crypto Payments';

// Text 
$_['text_payment'] = 'Payment';
$_['text_whitepay'] = '<a onclick="window.open(\'http://whitepay.com/\');"><img src="view/image/payment/whitepay.png" alt="WhitePay" title="WhitePay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_success'] = 'Settings updated';
$_['text_pay'] = 'WhitePay';

// Entry
$_['entry_slug'] = 'Slug:';
$_['entry_token'] = 'Token:';
$_['entry_webhook'] = 'Webhook token:';
//$_['entry_return_url'] = 'Return Url refference :<br /><span class="help">http://{your_domain}/index.php?route=payment/whitepay/response</span>';
//$_['entry_callback_url'] = 'callback Url refference :<br /><span class="help">http://{your_domain}/index.php?route=payment/whitepay/callback</span>';
$_['entry_return_url'] = 'Return Url:';
$_['entry_callback_url'] = 'Callback Url:';

$_['entry_processed_order_status'] = 'Order status while pending payment:';
$_['entry_complete_order_status'] = 'Order status after completed payment:';
$_['entry_partially_fulfilled_order_status'] = 'Order status after partial payment:';
$_['entry_declined_order_status'] = 'Order status after declined payment:';

$_['entry_debug'] = 'Debug:';
$_['entry_sort_order'] = 'Ordering:';
$_['entry_status'] = 'Status:';

// Tooltips
$_['help_slug'] = 'You can get your Slug by creating a page in the "Payment Pages" section of your Whitepay account - https://crm.whitepay.com/payment-pages';
$_['help_token'] = 'You can manage your Whitepay Token within the Whitepay Settings Tokens page - https://crm.whitepay.com/settings/tokens';
$_['help_webhook'] = 'Using a webhook will allow you to receive data on changes in order status (paid, cancelled) from Whitepay. To get a webhook token you need to copy the Callback URL from the current page, in your Whitepay account under Payment Pages paste it into the Webhook address field in the Webhooks tab and create a webhook, then you will get a webhook token.';
$_['help_return_url'] = 'The customer will return to this url from the acquiring page. Use by default - <b>http://{your_domain}/index.php?route=payment/whitepay/response</b> <br/> Warning! Do not change this field if you do not have a custom handler of return url.';
$_['help_callback_url'] = 'Callback url is used to recieve data via a webhook from the Whitepay. Use by default - <b>http://{your_domain}/index.php?route=payment/whitepay/callback</b> <br/> Warning! Do not change this field if you do not have a custom callback url handler.';
$_['help_debug'] = 'Log Whitepay API events';

// Error
$_['error_permission'] = "You haven't permission !";
$_['error_slug'] = 'Slug is empty!';
$_['error_token'] = 'Token is empty!';
?>