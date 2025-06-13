<?php
// Heading
$_['heading_title'] = 'Whitepay Крипто Платежі';

// Text 
$_['text_payment'] = 'Оплата';
$_['text_whitepay'] = '<a onclick="window.open(\'http://whitepay.com/\');"><img src="view/image/payment/whitepay.png" alt="WhitePay" title="WhitePay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_success'] = 'Налаштування оновлені';
$_['text_pay'] = 'WhitePay';

// Entry
$_['entry_slug'] = 'Slug:';
$_['entry_token'] = 'Token:';
$_['entry_webhook'] = 'Webhook:';
//$_['entry_return_url'] = 'Url для повернення :<br /><span class="help">http://{your_domain}/index.php?route=payment/whitepay/response</span>';
//$_['entry_callback_url'] = 'Url для відміни :<br /><span class="help">http://{your_domain}/index.php?route=payment/whitepay/callback</span>';
$_['entry_return_url'] = 'Url для повернення :';
$_['entry_callback_url'] = 'Url для відміни :';

$_['entry_processed_order_status'] = 'Статус замовлення в очікуванні оплати:';
$_['entry_complete_order_status'] = 'Статус замовлення після успішної оплати:';
$_['entry_partially_fulfilled_order_status'] = 'Статус замовлення після часткової оплати:';
$_['entry_declined_order_status'] = 'Статус замовлення після відхиленої оплати:';

$_['entry_debug'] = 'Лог:';
$_['entry_sort_order'] = 'Порядок сортування:';
$_['entry_status'] = 'Статус:';

// Tooltips
$_['help_slug'] = 'Ви можете отримати свій Slug створивши сторінку в розділі "Платіжні сторінки" акаунта Whitepay - https://crm.whitepay.com/payment-pages';
$_['help_token'] = 'Ви можете отримати свій Token на сторінці налаштувань токена Whitepay Settings Tokens page - https://crm.whitepay.com/settings/tokens';
$_['help_webhook'] = 'Використання вебхука дозволяє вам отримувати дані про зміну стану замовлення в системі Whitepay(сплачено, скасовано). Для отримання токена вебхука Вам потрібно копіювати з поточної сторінки Callback URL, в акаунті Whitepay у розділі Платіжні сторінки вставити його в поле Webhook address у вкладці Вебхуки і створити вебхук, після чого Ви отримаєте Webhook token.';
$_['help_return_url'] = 'Даний url використовується для повернення користувача зі сторінки еквайрингу. За замовчуванням використовувати - <b>http://{your_domain}/index.php?route=payment/whitepay/response <br/> Увага! Не вносьте правки до цього поля, якщо у вас немає кастомного оброблювача сторінки повернення.';
$_['help_callback_url'] = 'url зворотного виклику використовується для прийому даних за допомогою вебхука з боку Whitepay. За замовчуванням використовувати - <b>http://{your_domain}/index.php?route=payment/whitepay/callback</b <br/> Увага! Не вносите редагування в дане поле якщо у вас немає реалізованого обробника для прийому вебхука.';
$_['help_debug'] = 'Логування подій API';

// Error
$_['error_permission'] = "У вас немає відповідних прав!";
$_['error_slug'] = 'Поле Slug не може бути порожнім!';
$_['error_token'] = 'Поле Token не може бути порожнім!';
?>