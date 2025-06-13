<?php
$_['heading_title'] = 'Mono Checkout';
$_['text_edit'] = 'Налаштування';
$_['text_success'] = 'Налаштування успішно змінено!';
$_['text_apikey'] = 'Токен для підключення, ви зможете отримати <a href="https://web.monobank.ua/" rel="nofollow" target="_blank">у веб-кабінеті ФОП</a> - Еквайринг - Управління еквайрингом - Створити токен';

$_['entry_status'] = 'Статус';
$_['entry_statuses'] = 'Статуси замовлень';
$_['entry_api'] = 'API токен';
$_['entry_delivery'] = 'Види доставок';
$_['entry_payment'] = 'Типи платежів';
$_['entry_merchant'] = 'Оплата доставки магазином';
$_['entry_button'] = 'Вигляд кнопки';
$_['entry_cart_show'] = 'Відобразити в корзині';
$_['entry_cart_popup_elem'] = 'Елемент сайту, після якого виводиться кнопка в модалці корзини';
$_['entry_cart_elem'] = 'Елемент сайту, після якого виводиться кнопка на сторінці корзини';
$_['entry_product_elem'] = 'Елемент сайту, після якого виводиться кнопка на сторінці товару';
$_['entry_cart_show_size_w'] = 'Ширина кнопки в корзині (рх)';
$_['entry_cart_show_size_h'] = 'Висота кнопки в корзині (рх)';
$_['entry_cart_popup_show_size_w'] = 'Ширина кнопки в модалці корзини (рх)';
$_['entry_cart_popup_show_size_h'] = 'Висота кнопки в модалці корзини (рх)';
$_['entry_product_show'] = 'Відобразити в товарі';
$_['entry_product_show_size_w'] = 'Ширина кнопки в товарі (рх)';
$_['entry_product_show_size_h'] = 'Висота кнопки в товарі (рх)';
$_['entry_payments_number'] = 'Кількість платежів ПЧ';
$_['entry_faq'] = 'ЧаПи';

$_['help_payment'] = 'Доступні способи оплати для замовлення (якщо нічого не вибрано - доступні всі)';
$_['help_delivery'] = 'Доступні види доставок (якщо нічого не вибрано - доступні всі)';
$_['help_merchant'] = 'Оплата доставки магазином (якшо не встановлено - оплачує клієнт)';
$_['help_cart_show'] = 'Статус відображення кнопки на сторінці корзини';
$_['help_product_show'] = 'Статус відображення кнопки на сторінці товару';
$_['help_elem'] = 'Якщо кнопка не виводиться або хочете змінити її позицію, опишіть CSS селектор елемента після якого треба вивести кнопку';
$_['help_payments_number'] = 'Вкажіть мінімальне значення платежів Покупки Частинами для товарів магазину (від 3 до 25)';

$_['text_status_success'] = 'Успішний';
$_['text_status_payment_on_delivery'] = 'Оплата при доставці';
$_['text_status_not_confirmed'] = 'Створений ордер';
$_['text_status_not_authorized'] = 'Не авторизований';
$_['text_status_fail'] = 'Не успішний';

$_['delivery_pickup'] = 'Самовивіз';
$_['delivery_courier'] = 'Курʼєр';
$_['delivery_np_brnm'] = 'Нова Пошта';
$_['delivery_np_box'] = 'Поштомат Нова Пошта';
$_['payment_card'] = 'Оплата картою';
$_['payment_on_delivery'] = 'Оплата при доставці';
$_['payment_part_purchase'] = 'Покупка частинами';

$_['text_faq'] = '	<p>
1.<strong>not_authorized - Не авторизований</strong>. Пояснення: Користувач не пройшов авторизацію при вході в чекаут. Товар не відправляємо</p>
<p>

2. <strong>not_confirmed - Створений ордер</strong>. Пояснення: Користувач авторизувався в чекауті але не підтвердив покупку. Товар не відправляємо
</p>
<p>
3. <strong>payment_on_delivery - Оплата при доставці</strong>. Пояснення: Користувач вибрав оплату при отриманні та підтвердив покупку. Можна відправляти товар.</p>
<p>
4. <strong>success - Успішний</strong>. Пояснення: Користувач вибрав оплату карткою або ПЧ та підтвердив покупку. Користувач здійснив оплату успішно. Можна відправляти товар</p>
<p>
5. <strong>fail - Не успішний</strong>. Пояснення: Користувач підтвердив покупку але при платежі виникла помилка. Товар не відправляємо. Просимо користувача повторити оплату."
</p>';

$_['text_popup_faq'] = '<div class="text-left" style="float: right;">
<h5><strong>Рекомедуємі значення по шаблонам:</strong></h5>
	<ul>
	<li><strong>unishop2:</strong>   .header-cart__buttons .btn-default</li>
	<li><strong>octemplates:</strong>  .modal-cart-bottom .sc-btn.sc-btn-primary</li>
	<li><strong>moneymaker:</strong> #cart li:last-child p:last-child</li>
	<li><strong>aridius:</strong> #aridius_cart .margin_cart</li>
	<li><strong>luxsoft:</strong> .shop-cart-btn-block</li>
</ul>
</div>
';

// Error
$_['error_api'] = 'Токен обовʼязковий для заповнення. Знайдіть його в особистому кабінеті';
