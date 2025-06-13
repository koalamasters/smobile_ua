<?php
$_['heading_title'] = 'Mono Checkout';
$_['text_edit'] = 'Settings';
$_['text_success'] = 'Settings successfully changed!';
$_['text_apikey'] = 'Token for connection, you can get <a href="https://web.monobank.ua/" rel="nofollow" target="_blank">in the FOP web cabinet</a> - Acquiring - Managing acquiring - Create token';

$_['entry_status'] = 'Status';
$_['entry_statuses'] = 'Order statuses';
$_['entry_api'] = 'API token';
$_['entry_delivery'] = 'Types of deliveries';
$_['entry_payment'] = 'Types of payments';
$_['entry_merchant'] = 'Delivery payment by store';
$_['entry_button'] = 'Button view';
$_['entry_cart_show'] = 'Show in cart';
$_['entry_cart_popup_elem'] = 'Site element, after which a button is displayed in the cart modal';
$_['entry_cart_elem'] = 'Site element, after which the button on the cart page is displayed';
$_['entry_product_elem'] = 'Site element, after which the button on the product page is displayed';
$_['entry_cart_show_size_w'] = 'Width of the button in the cart (px)';
$_['entry_cart_show_size_h'] = 'Height of the button in the cart (px)';
$_['entry_cart_popup_show_size_w'] = 'Width of the button in the cart popup (px)';
$_['entry_cart_popup_show_size_h'] = 'Height of the button in the cart popup (px)';
$_['entry_product_show'] = 'Show in product';
$_['entry_product_show_size_w'] = 'Width of the button in the product (px)';
$_['entry_product_show_size_h'] = 'Height of the button in the product (px)';
$_['entry_payments_number'] = 'Number of Purchase in Parts payments';
$_['entry_faq'] = 'FAQ';

$_['help_payment'] = 'Available payment methods for the order (if nothing is selected - all are available)';
$_['help_delivery'] = 'Available types of delivery (if nothing is selected - all are available)';
$_['help_merchant'] = 'Payment for delivery by the store (if not set - the customer pays)';
$_['help_cart_show'] = 'Display status of the button on the cart page';
$_['help_product_show'] = 'Display status of the button on the product page';
$_['help_elem'] = 'If the button is not displayed or you want to change its position, describe the CSS selector of the element after which the button should be displayed';
$_['help_payments_number'] = 'Specify the minimum value of payments for Purchase in Parts for store products (from 3 to 25)';

$_['text_status_success'] = 'Successful';
$_['text_status_payment_on_delivery'] = 'Payment upon delivery';
$_['text_status_not_confirmed'] = 'Order created';
$_['text_status_not_authorized'] = 'Not authorized';
$_['text_status_fail'] = 'Not successful';


$_['delivery_pickup'] = 'Pickup';
$_['delivery_courier'] = 'Courier';
$_['delivery_np_brnm'] = 'Nova Post';
$_['delivery_np_box'] = 'Nova Post (Post machine)';
$_['payment_card'] = 'Payment by card';
$_['payment_on_delivery'] = 'Payment on delivery';
$_['payment_part_purchase'] = 'Purchase in parts';

$_['text_faq'] = ' <p>
1.<strong>not_authorized - Not authorized</strong>. Explanation: The user was not authorized when entering the checkout. We do not ship the goods</p>
<p>

2. <strong>not_confirmed - Order created</strong>. Explanation: The user was authorized in the checkout, but did not confirm the purchase. We do not ship the product
</p>
<p>
3. <strong>payment_on_delivery - Payment upon delivery</strong>. Explanation: The user selected cash on delivery and confirmed the purchase. You can send the goods.</p>
<p>
4. <strong>success - Successful</strong>. Explanation: The user chose to pay by card or bank transfer and confirmed the purchase. The user made the payment successfully. You can send the goods</p>
<p>
5. <strong>fail - Not successful</strong>. Explanation: The user confirmed the purchase, but an error occurred during payment. We do not ship the product. Please try the payment again."
</p>';

$_['text_popup_faq'] = '<div class="text-left" style="float: right;">
<h5><strong>Recommended values according to templates:</strong></h5>
<ul>
<li><strong>unishop2:</strong> .header-cart__buttons .btn-default</li>
<li><strong>octemplates:</strong> .modal-cart-bottom .sc-btn.sc-btn-primary</li>
<li><strong>moneymaker:</strong> #cart li:last-child p:last-child</li>
<li><strong>aridius:</strong> #aridius_cart .margin_cart</li>
<li><strong>luxsoft:</strong> .shop-cart-btn-block</li>
</ul>
</div>
';

// Error
$_['error_api'] = 'The token is required. Find it in your personal account';