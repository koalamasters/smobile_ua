<?php
// Heading
$_['heading_title'] = 'Whitepay Крипто Платежи';

// Text 
$_['text_payment'] = 'Оплата';
$_['text_whitepay'] = '<a onclick="window.open(\'http://whitepay.com/\');"><img src="view/image/payment/whitepay.png" alt="WhitePay" title="WhitePay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_success'] = 'Настройки обновлены';
$_['text_pay'] = 'WhitePay';

// Entry
$_['entry_slug'] = 'Slug:';
$_['entry_token'] = 'Token:';
$_['entry_webhook'] = 'Webhook:';
//$_['entry_return_url'] = 'Url для возврата :<br /><span class="help">http://{your_domain}/index.php?route=payment/whitepay/response</span>';
//$_['entry_callback_url'] = 'Url для отмены :<br /><span class="help">http://{your_domain}/index.php?route=payment/whitepay/callback</span>';
$_['entry_return_url'] = 'Url для возврата :';
$_['entry_callback_url'] = 'Url для отмены :';

$_['entry_processed_order_status'] = 'Статус заказа в ожидании оплаты:';
$_['entry_complete_order_status'] = 'Статус заказа после успешной оплаты:';
$_['entry_partially_fulfilled_order_status'] = 'Статус заказа после частичной оплаты:';
$_['entry_declined_order_status'] = 'Статус заказа после отклоненной оплаты:';

$_['entry_debug'] = 'Лог:';
$_['entry_sort_order'] = 'Порядок сортировки:';
$_['entry_status'] = 'Статус:';

// Tooltips
$_['help_slug'] = 'Вы можете получить свой Slug создав страницу в разделе "Платежные страницы" аккаунта Whitepay - https://crm.whitepay.com/payment-pages';
$_['help_token'] = 'Вы можете получить свой Token на странице настроек токена Whitepay Settings Tokens page - https://crm.whitepay.com/settings/tokens';
$_['help_webhook'] = 'Использование вебхука позволяет вам получать данные об изменении состояния заказа в системе Whitepay(оплачен, отменен). Для получения токена вебхука Вам нужно копировать с текущей страницы Callback URL, в аккаунте Whitepay в разделе Платежные страницы вставить его в поле Webhook address во вкладке Вебхуки и создать вебхук, после чего Вы получите Webhook token.';
$_['help_return_url'] = 'Данный url используется для возврата пользователя со страницы эквайринга. По умолчанию использовать - <b>http://{your_domain}/index.php?route=payment/whitepay/response</b> <br/> Внимание! Не вносите правки в данное поле если у вас нет кастомного обработчика страницы возврата.';
$_['help_callback_url'] = 'url обратного вызова используется для приема данных посредством вебхука со стороны Whitepay. По умолчанию использовать - <b>http://{your_domain}/index.php?route=payment/whitepay/callback</b> <br/> Внимание! Не вносите правки в данное поле если у вас нет реализованого обработчика для приема вебхука.';
$_['help_debug'] = 'Логирование API событий';

// Error
$_['error_permission'] = "У вас нет соответствующих прав!";
$_['error_slug'] = 'Поле Slug не может быть пустым!';
$_['error_token'] = 'Поле Token не может быть пустым!';
?>