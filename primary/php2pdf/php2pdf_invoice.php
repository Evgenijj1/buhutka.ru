<?php
header('Content-type: text/html; charset=utf-8');
include_once 'num2str.php';
$rub=[1=>'рубль',2=>'рубля',5=>'рублей'];
$kop=[1=>'копейка',2=>'копейки',5=>'копеек'];
foreach($_POST['name_item'] as $key=>$val){
    $table.='
    <tr>
        <td style="width:13mm;">'.($key+1).'</td>
        <td style="width:20mm;"></td>
        <td>'.$val.'</td>
        <td style="width:20mm;">'.$_POST['kol_item'][$key].'</td>
        <td style="width:17mm;">'.$_POST['ed_item'][$key].'</td>
        <td style="width:27mm;">'.$_POST['price_item'][$key].'</td>
        <td style="width:27mm;text-align:right;">'.$_POST['sum_item'][$key].'</td>
    </tr>';
    $count=$key+1;
}
$html='<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<table width="100%">
    <tr>
        <td>&nbsp;</td>
        <td style="width: 155mm;">
            <div style="width:155mm; ">Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате  обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.</div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div style="text-align:center;  font-weight:bold;">

            </div>
        </td>
    </tr>
</table>
<table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
    <tr>
        <td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
            <table class="border_non" width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                <tr>
                    <td valign="top">
                        <div>'.(!empty($_POST['name_bank_client'])?$_POST['name_bank_client']:'').'</div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 3mm;">
                        <div style="font-size:10pt;">Банк получателя</div>
                    </td>
                </tr>
            </table>
        </td>
        <td style="min-height:7mm;height:auto; width: 25mm;">
            <div>БИK</div>
        </td>
        <td rowspan="2" style="vertical-align: top; width: 60mm;">
            <div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">'.(!empty($_POST['BIC_client'])?$_POST['BIC_client']:'').'</div>
            <div>'.(!empty($_POST['ks_bank_client'])?$_POST['ks_bank_client']:'').'</div>
        </td>
    </tr>
    <tr>
        <td style="width: 25mm;">
            <div>Сч. №</div>
        </td>
    </tr>
    <tr>
        <td style="min-height:6mm; height:auto; width: 50mm;">
            <div>ИНН '.(!empty($_POST['INN_client'])?$_POST['INN_client']:'').'</div>
        </td>
        <td style="min-height:6mm; height:auto; width: 55mm;">
            <div>КПП '.(!empty($_POST['kpp_client'])?$_POST['kpp_client']:'').'</div>
        </td>
        <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
            <div>Сч. №</div>
        </td>
        <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
            <div>'.(!empty($_POST['rs_client'])?$_POST['rs_client']:'').'</div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="min-height:13mm; height:auto;">

            <table class="border_non" border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
                <tr>
                    <td valign="top">
                        <div>'.(!empty($_POST['shortName_client'])?$_POST['shortName_client']:'').'</div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 3mm;">
                        <div style="font-size: 10pt;">Получатель</div>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<br/>

<div style="font-weight: bold; font-size: 16pt; padding-left:5px;">
    Счет № '.(!empty($_POST['number'])?$_POST['number']:'1').' от '.(!empty($_POST['date'])?$_POST['date']:date('d.m.Y')).'</div>
<br/>

<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>

<table width="100%">
    <tr>
        <td style="width: 30mm;">
            <div style=" padding-left:2px;">Поставщик:    </div>
        </td>
        <td>
            <div style="font-weight:bold;  padding-left:2px;">'.(!empty($_POST['fullName_comp'])?$_POST['fullName_comp']:'').'</div>
        </td>
    </tr>
    <tr>
        <td style="width: 30mm;">
            <div style=" padding-left:2px;">Покупатель:    </div>
        </td>
        <td>
            <div style="font-weight:bold;  padding-left:2px;">'.(!empty($_POST['fullName_client'])?$_POST['fullName_client']:'').'</div>
        </td>
    </tr>
</table>


<table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
    <thead>
    <tr>
        <th style="width:13mm;">№</th>
        <th style="width:20mm;">Код</th>
        <th>Товар</th>
        <th style="width:20mm;">Кол-во</th>
        <th style="width:17mm;">Ед.</th>
        <th style="width:27mm;">Цена</th>
        <th style="width:27mm;">Сумма</th>
    </tr>
    </thead>
    <tbody >
'.(!empty($table)?$table:'').'
</tbody>
</table>

<table border="0" width="100%" cellpadding="1" cellspacing="1">
    <tr>
        <td></td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">'.(!empty($_POST['itog'])?$_POST['itog']:'0.00').'</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight:bold;  text-align:right;">В том числе НДС:</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">'.(!empty($_POST['itog_nds'])?$_POST['itog_nds']:'0.00').'</td>
    </tr>
</table>

<br />
<div>
Всего наименований '.(!empty($count)?$count:'0').' на сумму '.(!empty($_POST['itog'])?$_POST['itog']:'0.00').' рублей.<br />
'.(!empty($_POST['itog'])?mb_ucfirst(written_number((integer)$_POST['itog'])).' '.$rub[num_125((integer)$_POST['itog'])].' '.substr($_POST['itog'],-2,2).' '.$kop[num_125((integer)substr($_POST['itog'],-2,2))]:'ноль рублей 00 копеек').'</div>
<br /><br />
<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
<br/>

<div>Руководитель '.(!empty($_POST['chiefName_comp'])?$_POST['chiefName_comp']:'______________________ (Фамилия И.О.)').'</div>
<br/>

<div>Главный бухгалтер '.(!empty($_POST['accountant_comp'])?$_POST['accountant_comp']:'______________________ (Фамилия И.О.)').'</div>
<br/>

<div style="width: 85mm;text-align:center;">М.П.</div>
<br/>


<div style="width:800px;text-align:left;font-size:10pt;">Счет действителен к оплате в течении трех дней.</div>

</body>
</html>
';

include $_SERVER['DOCUMENT_ROOT'] . '/include/MPDF/mpdf.php';

$mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/css/document.css'); /*подключаем css*/
$mpdf->WriteHTML($stylesheet, 1);

$mpdf->list_indent_first_level = 0;
$mpdf->WriteHTML($html, 2); /*формируем pdf*/
$mpdf->Output('mpdf.pdf', 'I');
?>