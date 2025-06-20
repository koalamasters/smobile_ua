<?php
// Text
$_['text_title_pp']				= 'Оплата частинами (ПриватБанк)';
$_['text_title_pb']				= 'Оплата частинами. Гроші в періоді (ПриватБанк)';
$_['text_title_ii']				= 'Миттєва розстрочка (ПриватБанк)';
$_['text_title_ia']				= 'Миттєва розстрочка. Акційна (ПриватБанк)';
$_['text_title_mb']				= 'Покупка частинами (МоноБанк)';
$_['text_title_ab']				= 'Легка розстрочка (Sense bank)';
$_['text_title_sb']				= 'Кредит (Sense bank)';
$_['text_title_aa']				= 'Плати частинами (А-Банк)';
$_['text_title_pl']				= 'Плати пізніше';
$_['text_title_pu']				= 'Оплата частинами (ПУМБ)';

$_['text_credithead']			= 'Кредитні пропозиції';
$_['text_payments']				= "'платіж на ','платежі на ','платежів на '";
$_['text_total']				= ' = ';
$_['text_per']					= 'по';
$_['text_mounth']				= 'міс';
$_['text_submit']				= 'Оформити';

$_['text_min']					= 'від %s у місяць';
$_['text_min_pp']				= 'Оплата частинами (ПриватБанк) до %s місяців від %s/міс.';
$_['text_min_pb']				= 'Оплата частинами. Гроші в періоді (ПриватБанк) до %s місяців від %s/міс.';
$_['text_min_ii']				= 'Миттєва розстрочка (ПриватБанк) до %s місяців від %s/міс.';
$_['text_min_ia']				= 'Миттєва розстрочка. Акційна (ПриватБанк) до %s місяців від %s/міс.';
$_['text_min_mb']				= 'Покупка частинами (МоноБанк) до %s місяців від %s/міс.';
$_['text_min_ab']				= 'Легка розстрочка (Sense bank) до %s місяців від %s/мес.';
$_['text_min_sb']				= 'Кредит (Sense bank) до %s месяцев от %s/мес.';
$_['text_min_aa']				= 'Плати частинами (А-Банк) до %s місяців від %s/міс.';
$_['text_min_pl']				= 'Плати пізніше до %s місяців від %s/міс.';
$_['text_min_pu']				= 'Плата частинами (ПУМБ) до %s місяців від %s/міс.';

$_['text_panEnd']				= '4 останніх цифри номера картки';

$_['text_success_mb']				= 'Вашу заявку отримано, запустіть додаток MONO та підтвердіть оформлення';
$_['text_success_aa']			= 'Вашу заявку отримано, запустіть додаток ABank24 та підтвердіть оформлення';
$_['text_success_pu']			= 'Вашу заявку отримано, запустіть додаток PUMB та підтвердіть оформлення';
$_['text_success_ab']			= 'Вашу заявку отримано! Підтвердіть згоду на оформлення кредиту відповівши на СМС яке незабором прийде на Ваш телефон.';
$_['text_success_sb']			= 'Вашу заявку отримано! Підтвердьте згоду на оформлення кредиту на наступній сторінці.';
$_['text_success_pl']			= 'Вашу заявку отримано!';

$_['text_error_mb']			= 'При підключенні до сервера банку сталася помилка 403';

// Text Error
$_['error_curl']                = 'Сервіс тимчасово недоступний( Спробуйте пізніше.';

$_['credit_text']				= 'Для уточнения Вашого кредитного лиміту відправте смс з текстом Chast на номер 10060 або зателефонуйте на 3700';

$_['text_status_CLIENT_WAIT']							= 'очікування підтвердження від клієнта кредитного договору на сайті Приватбанк';

$_['text_substatus_ACTIVE']								= 'заявка успішна, товар передано клієнту, гроші відправлено магазину. Фінальний статус по заявці';
$_['text_substatus_DONE']								= 'заявка успішна, товар передано клієнту, гроші відправлено магазину, ПЧ погашено клієнтом.';
$_['text_substatus_SUCCESS']							= 'магазином принято повернення товару, гроші перераховано клієнту';

$_['text_substatus_WAITING_FOR_CLIENT']					= 'очікування підтвердження від клієнта кредитного договору в додатку ';
$_['text_substatus_WAITING_FOR_STORE_CONFIRM']			= 'кредитна угода ПЧ підтверджена клієнтом. <b>Важливо!</b> ключовий статус, після отримання якого необхідно передати товар клієнту';

$_['text_substatus_CLIENT_NOT_FOUND']					= 'Клієнта не знайдено. Варіанти: не клієнт монобанку; вказано не фінансовий номер';
$_['text_substatus_EXCEEDED_SUM_LIMIT']					= 'Клієнт перевищив доступний ліміт на ПЧ. Ліміт можна переглянути в додатку монобанк в меню Кредити.';
$_['text_substatus_EXISTS_OTHER_OPEN_ORDER']			= 'У клієнта є інша відкрита заявка на ПЧ. Рішення: відмінити відкриту заявку в додатку клієнтом або магазином методом reject; зачекати 15 хв, заявка перейде в статус CLIENT_PUSH_TIMEOUT';
$_['text_substatus_FAIL']								= 'Внутрішея помилка на стороні Банку. Рекомендуємо повторити подачу заявки через 5 хв.';
$_['text_substatus_NOT_ENOUGH_MONEY_FOR_INIT_DEBIT']	= 'Недостатньо коштів для першого списання. Рішення: поповнити картку монобанку на суму першого платежу.';
$_['text_substatus_REJECTED_BY_CLIENT']					= 'Клієнт відмовився від здійснення покупки';
$_['text_substatus_CLIENT_PUSH_TIMEOUT']				= 'Клієнт не прйняв рішення по кредитному договору ПЧ в додатку монобанку. Кредитний договір активний 15 хв. Рішення: сконтактувати з клієнтом; повторити заявку';
$_['text_substatus_REJECTED_BY_STORE']					= 'Магазин відмовився від продажу';

$_['text_status_IN_PROCESSING']							= 'Замовлення в обробці! Термін розстрочки - ';

$_['text_f']				= 'Прізвище';
$_['text_i']				= 'Ім&#39;я';
$_['text_o']				= 'По-батькові';
$_['text_bd']				= 'Дата народження у форматі (ДД-ММ-РРРР)';
$_['text_phone']			= 'Мобільний номер телефону у форматі (+380XXXXXXXXX)';
$_['text_phoned']			= 'Домашній номер телефону у форматі (+380XXXXXXXXX)';
$_['text_madr']				= 'Емейл у форматі (xxxx@xxxx.xxx)';
$_['text_inn']				= 'ІПН у форматі (XXXXXXXXXX)';
$_['text_sp']				= 'Серія паспорту у форматі (XX)';
$_['text_psp']				= 'Номер паспорта у форматі (XXXXXX)';
$_['text_god']				= 'Паспорт, дійсний до у форматі (ДД-ММ-РРРР)';
$_['text_psp_dv']			= 'Паспорт, дата видачі у форматі (ДД-ММ-РРРР)';
$_['text_pkv']				= 'Ким виданий паспорт';
$_['text_radr']				= 'Адреса реєстрації';
$_['text_ladr']				= 'Адреса проживання';
$_['text_ind']				= 'Поштовий індекс';
$_['text_obr']				= 'Освіта';
$_['text_vuz']				= 'ВНЗ (Вищий навчальний заклад)';
$_['text_rab']				= 'Місце роботи';
$_['text_rabt']				= 'Телефон робочий у форматі (+380XXXXXXXXX)';
$_['text_raba']				= 'Адреса роботи';
$_['text_char']				= 'Посада';
$_['text_spol']				= 'Сімейний стан';
$_['text_det']				= 'Кількість дітей';
$_['text_vdet']				= 'Вік усіх дітей';
$_['text_soj']				= 'Кількість осіб у квартирі / будинку';
$_['text_comentar']			= 'Коментар';
$_['text_tfio']				= 'П.І.Б. третьої особи';
$_['text_ttel']				= 'Контактний телефон третьої особи';
$_['text_tsot']				= 'Ступінь відносин із клієнтом, третьої особи';

$_['error_f']				= 'Прізвище повинно бути від 3 до 64 символів!';
$_['error_i']				= 'Ім&#39;я повинно бути від 3 до 64 символів!';
$_['error_o']				= 'По-батькові повинно бути від 3 до 64 символів!';
$_['error_inn']				= 'ІПН повинен бути 10 символів!';
$_['error_sp']				= 'Серія паспорта повинна бути 2 символи!';
$_['error_phone']			= 'Телефон повинен бути 13 символів!';
$_['error_all']				= 'Перевірте форму на помилки!';
$_['error_token']			= 'При підключенні до сервера Платі пізніше сталася помилка!';

$_['parts']			= 'Частинами';