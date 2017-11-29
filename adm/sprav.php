<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php";

$sprav=
    [
        'pages'=>'Страницы','blocks'=>'Блоки(шаблоны)',
        'user'=>'Пользователи',
        'ac_company'=>'Компании',
        'ac_bank'=>'Банки',
        'ac_packing_list'=>'Накладная',
        'ac_act'=>'АКТ',
        'ac_invoice'=>'Счет-фактура',
        'ac_item'=>'Товары'
    ]; // используется и в ChoiceSprav

$sprav_field=[];
$sprav_field['pages']=[
    'name'=>'Название(h1)',
    'parent'=>'Родитель',
    'menu_name'=>'Меню',
    'title'=>'Заголовок(title)',
    'content'=>'Текст',
    'url'=>'url от parent',
    'sort'=>'Сортировка',
    'description'=>'Seo описание',
    'keywords'=>'Ключевые слова',
    'services'=>['name'=>'Атрибуты', 'type'=>'bit', 'value'=>[/*'0'=>'page', */'1'=>' не выводить в меню', '2'=>'не выводить в карту сайта']],
    'image'=>1,'Order'=>'parent,sort,name'];
// todo поменять сортировку на sort,name, а в sort учесть чтобы подразделы после разделов

$sprav_field['blocks']=[
    'name'=>'Название(h1)',
    'key'=>'Ключ',
    'content'=>'Текст'];

$sprav_field['schedule']=[
    'manager'=>'Тренер',
    'pages'=>['name'=>'Описание занятия','where'=>'parent=10'/*Тренировки*/],
    'name'=>'-',
    'size'=>'Количество мест',
    'day'=>['name'=>'День недели', 'value'=>$_DayOfWeek],
    'hour'=>'Время начала',
    /*'hours'=>'Кол-во часов',*/
    'tovar'=>['name'=>'Услуга','where'=>'type='.tTYPE_USLUGA],
    'date0'=>'С',
    'date_end'=>'По',
    'Order'=>'day,hour'];

$sprav_field['tovar']=[
    'brand'=>'Бренд',
    //'collection'=>"Колекция",
    //'type'=>['name'=>'Вид','value'=>Tovar::$ar_type],
    //'gr'=>['name'=>'Группа','sprav'=>'category'],
    'price'=>"цена",
    //'price1'=>"Мелкий опт",
    //'price2'=>"Опт",
    //'price0'=>"цена для сотрудников",
    //'maxdiscount'=>"максимальная скидка",
    //'kod_prodact'=>"Артикул",
    //'ean'=>"Штрих-код" ,
    'description'=>"Описание",
    //'tovar'=>['name'=>"ссылка на tovar для абонементов", 'where'=>'type='.tTYPE_USLUGA],
    //'kol'=>"Количество услуг, объем мл, если=1-то только по одной",
    'kol'=>"объем, мл",
    //'srok'=>"срок действия, мес / заказ",
    'ost'=>"Остаток",
    'ed'=>"единица измерения количества",
    /*'info'=>"json",*/
    'image'=>1
];

$sprav_field['brand']=[/*'content'=>'Описание','image'=>1*/];
$sprav_field['category']=['keywords'=>'Ключевые слова',/*'content'=>'Описание','image'=>1*/];
$sprav_field['collection']=['brand'=>'Бренд',/*'content'=>'Описание','image'=>1*/];
$sprav_field['shop']=['address'=>'Адрес','content'=>'Описание'];
$sprav_field['config']=['name'=>'Наименование','from'=>'действует с','value'=>'Значение'];
$sprav_field['user']=['name'=>'Логин','fullname'=>'ФИО','kart'=>'Карта','mail'=>'e-mail','tel'=>'Телефон(обязательно)', 'adm'=>['name'=>"Права",'value'=>User::$_adm],
    /*'date0'=>"Дата регистрации",'time'=>"Время последнего входа в систему",*/
    /*'city'=>'Город',*/ 'comment'=>'О пользователе', 'onEdit'=>'/user/?ajax&id=','image'=>1];
$sprav_field['payment']=['name'=>'-','time'=>"Дата",'user'=>"Пользователь", 'zakaz'=>'Заказ', 'summ'=>'Сумма','deliver'=>'Кошелек', 'status'=>'Статус'];

$sprav_field['ac_company']=[
    'name'=>'-',
    'shortName'=>'Краткое название',
    'fullName'=>'Полное название',
    'INN'=>'ИНН',
    'KPP'=>'КПП',
    'OGRN'=>'ОГРН',
    'OKPO'=>'ОКПО',
    'address'=>'Адрес',
    'chiefName'=>'Руководитель',
    'accountant'=>'Главный бухгалтер',
    'tel'=>'Телефон',
    'rs'=>'Расчетный счет'];

$sprav_field['ac_packing_list']=[
    'name'=>'-',
    'id_company'=>'Продавец',
    'id_client'=>'Покупатель',
    'bank_company'=>'Банк продавца',
    'bank_client'=>'Банк покупателя',
    'consignee'=>'Грузоотправитель',
    'consignor'=>'Грузополучатель',
    'bank_consignee'=>'Банк грузоотправителя',
    'bank_consignor'=>'Банк грузополучателя',
    'number'=>'Расходная накладная №',
    'date0'=>'Дата',
    'base'=>'Основание'];

$sprav_field['ac_bank']=[
    'BIC'=>'БИК',
    'name'=>'Название банка',
    'adress'=>'Адрес банка',
    'ks'=>'корр/счет'];

$sprav_field['ac_act']=[
    'date0'=>'Дата',
    'condition'=>'Условие',
    'number'=>'Номер акта'];

$sprav_field['ac_invoice']=[
    'number'=>'Номер счет-фактура',
    'date0'=>'Дата',
    'number_correction'=>'Номер изменения',
    'date_correction'=>'Дата изменения'];

$sprav_field['ac_item']=[
    'name'=>'Название',
    'unit'=>'Единица измерения',
    'price'=>'Цена',
    'NDS'=>'НДС'];

$sprav_field['ac_item_packing']=[
    'number'=>'Количество'];

Sprav::Init($sprav,$sprav_field);
