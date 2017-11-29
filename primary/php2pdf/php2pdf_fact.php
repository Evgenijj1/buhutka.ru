<?php
header('Content-type: text/html; charset=utf-8');
include_once 'num2str.php';
$count=0;
$rub=[1=>'рубль',2=>'рубля',5=>'рублей'];
$kop=[1=>'копейка',2=>'копейки',5=>'копеек'];
foreach ($_POST['name_item'] as $key=>$val) {
    $table.='<tr>
  <td style="width:160px;">
    <div id="name_id" class="editable_sys" edtype="text" style="width:160px;">'.$val.'</div>
  </td>
  <td style="width:45px;">
    <d  iv id="ed_id" class="editable_sys" edtype="text" style="width:45px;">'.($_POST['avans']=='No'?'':'---').'</div>
  </td>
  <td style="width:45px;">
    <div id="ed_id2" class="editable_sys" edtype="text" style="width:80px;">'.($_POST['avans']=='No'?'':'---').'</div>
  </td>
  <td style="width:60px;">
    <div id="kol_id" class="editable_sys" edtype="text" style="width:60px;">'.($_POST['avans']=='No'?$_POST['kol_item'][$key]:'---').'</div>
  </td>
  <td style="width:68px;">
    <div id="item_price_id" class="editable_sys" edtype="text" style="width:65px;">'.($_POST['avans']=='No'?number_format($_POST['price_item'][$key]/(1+$_POST['nds'][$key]/100),2):'---').'</div>
  </td>
  <td style="width:81px;text-align:right;">
    <div id="price_id" class="editable_sys" edtype="text" style="width:81px;">'.($_POST['avans']=='No'?number_format($_POST['sum_item'][$key]/(1+$_POST['nds'][$key]/100),2):'---').'</div>
  </td>
  <td style="width:54px;">
    <div id="akciz_id" class="editable_sys" edtype="text" style="width:50px;">'.($_POST['avans']=='No'?'Без акциза':'---').'</div>
  </td>
  <td style="width:60px;text-align:center;">
        <div id="nds_id" class="editable_sys" edtype="text" style="width:60px;">'.$_POST['nds'][$key].'%'.($_POST['avans']=='Yes'?'/'.(100+$_POST['nds'][$key]).'%':'').'</div>
  </td>
  <td style="width:71px;text-align:right;">
    <div id="nds_summ_id" class="editable_sys" edtype="text" style="width:67px;">'.(number_format($_POST['sum_item'][$key]-$_POST['sum_item'][$key]/(1+$_POST['nds'][$key]/100),2)).'</div>
  </td>
  <td style="width:80px;text-align:right;">
    <div id="total_summ_id" class="editable_sys" edtype="text" style="width:80px;">'.$_POST['sum_item'][$key].'</div>
  </td>
  <td style="width:50px;text-align:center;">
    <div id="country_id" class="editable_sys" edtype="text" style="width:50px;">'.($_POST['avans']=='No'?(!empty($_POST['code'][$key])?$_POST['code'][$key]:''):'---').'</div>
  </td>
  <td style="width:100px;text-align:center;">
    <div id="country_id2" class="editable_sys" edtype="text" style="width: 100px; background-color: transparent;">'.($_POST['avans']=='No'?$_POST['country'][$key]:'---').'</div>
  </td>
  <td style="width:166px;">
    <div id="gtd_id" class="editable_sys" edtype="text" style="width:166px;">'.($_POST['avans']=='Yes'?'---':!empty($_POST['custom'][$key])?$_POST['custom'][$key].'/'.($key+1):'').'</div>
  </td>
 </tr>';
}

$html='
<form id="invoice_com_form" method="post" action="/blanks/invoice_com/pdf/" target="_blank" rel="print">
<table width="100%" border="0">
<tbody><tr>
<td width="100%" align="right" style="font-size: 5pt;">
    <div style="position: absolute; margin-left: -200px; margin-top: -20px;">
            </div>
<div id="prilozenie1" class="editable" edtype="text" style="width:986px;">Приложение №1</div>
<div id="prilozenie2" class="editable" edtype="text" style="width:986px;">к постановлению Правительства Российской Федерации</div>
<div id="prilozenie3" class="editable" edtype="text" style="width:986px;">от 26 декабря 2011 г. № 1137</div>
<div id="prilozenie4" class="editable" edtype="text" style="width:986px;">(в ред. Постановления Правительства РФ от 25.05.2017 №625)</div>
</td>
</tr>
<tr>
<td>
    <div style="text-align:center;width:796px;font-size:10pt;font-weight:bold;">
&nbsp;
    </div>

</td>
</tr>
</tbody></table>

<div id="schetcom_number_date" class="editable" edtype="text" style="width: 980px; font-weight: bold; font-size: 14pt; padding-left: 5px; background-color: transparent;">СЧЕТ-ФАКТУРА № '.(!empty($_POST['number_fact'])?$_POST['number_fact']:1).' от '.(!empty($_POST['date_fact'])?$_POST['date_fact']:date('d.m.Y')).'</div>
<div id="schetcom_change_date" class="editable" edtype="text" style="width: 980px; font-weight: bold; font-size: 14pt; padding-left: 5px; background-color: transparent;">Исправление № '.($_POST['edit']=='Yes'?$_POST['number_fact_edit'].' от '.$_POST['date_fact_edit']:'--- от ---').'</div>
<table width="100%">
<tbody><tr>
<td>
    <div id="prodavec" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">Продавец: '.(!empty($_POST['shortName_comp'])?$_POST['shortName_comp']:'').'</div>
</td>
</tr>
<tr>
<td>
    <div id="address_prod" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">Адрес: '.(!empty($_POST['address_comp'])?$_POST['address_comp']:'').'</div>
</td>
</tr>
<tr>
<td>
    <div id="innkpp_prod" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">ИНН/КПП продавца: '.(!empty($_POST['INN_comp'])?$_POST['INN_comp']:'').'/'.(!empty($_POST['kpp_comp'])?$_POST['kpp_comp']:'').'</div>
</td>
</tr>
<tr>
<td>
    <div id="gruzootpr" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">Грузоотправитель и его адрес: '.($_POST['Consignor']=='Non'?$_POST['shortName_consignor'].', Адрес:'.$_POST['address_consignor']:'Он же').'</div>
</td>
</tr>
<tr>
<td>
    <div id="gruzopol" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">Грузополучатель и его адрес: '.($_POST['Consignee']=='Non'?$_POST['shortName_consignee'].', Адрес:'.$_POST['address_consignee']:'Он же').'</div>
</td>
</tr>
<tr>
<td>
    <div id="platezka" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">К платежно-расчетному документу '.($docs==''?'---':$docs).'.</div>
</td>
</tr>
<tr>
<td>
    <div id="pokupatel" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">Покупатель: '.(!empty($_POST['shortName_client'])?$_POST['shortName_client']:'').'</div>
</td>
</tr>
<tr>
<td>
    <div id="address_pokup" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">Адрес: '.(!empty($_POST['address_client'])?$_POST['address_client']:'').'</div>
</td>
</tr>
<tr>
<td>
    <div id="innkpp_pokup" class="editable" edtype="text" style="width: 980px; font-size: 8pt; padding-left: 2px; background-color: transparent;">ИНН/КПП покупателя: '.(!empty($_POST['INN_client'])?$_POST['INN_client']:'').'/'.(!empty($_POST['kpp_client'])?$_POST['kpp_client']:'').'</div>
</td>
</tr>
</tbody></table>

<div id="valuta" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">Валюта: наименование, код: Российский рубль, 643</div>
<div id="identificator" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">Идентификатор государственного контракта, договора (соглашения): </div>
<br>
<table id="items" class="invoice_com_items" border="1" width="100%" cellpadding="0" cellspacing="0">
<thead>
 <tr>
  <th style="width:160px;" rowspan="2">
    <div id="name_txt" class="editable_sys" edtype="textarea" style="width:160px;">Наименование товара (описание выполненных работ, оказанных услуг), имущественного права</div>
  </th>
  <th style="width:126px;" colspan="2">
    <div id="ed_txt" class="editable_sys" edtype="textarea" style="width:126px;">Единица<br>измерения</div>
  </th>
  <th style="width:60px;" rowspan="2">
    <div id="kol_txt" class="editable_sys" edtype="textarea" style="width:60px;">Коли-<br>чество</div>
  </th>
  <th style="width:68px;" rowspan="2">
    <div id="item_price_txt" class="editable_sys" edtype="textarea" style="width:65px;">Цена<br> (тариф) за<br> единицу<br> измерения</div>
  </th>
  <th style="width:81px;" rowspan="2">
    <div id="price_txt" class="editable_sys" edtype="textarea" style="width: 82px; background-color: transparent;">Стоимость товаров (работ, услуг), имущественных прав без налога - всего</div>
  </th>
  <th style="width:54px;" rowspan="2">
    <div id="akciz_txt" class="editable_sys" edtype="textarea" style="width:51px;">В том числе акциз</div>
  </th>
  <th style="width:60px;" rowspan="2">
    <div id="nds_txt" class="editable_sys" edtype="textarea" style="width:60px;">Налоговая ставка</div>
  </th>
  <th style="width:85px;" rowspan="2">
    <div id="nds_summ_txt" class="editable_sys" edtype="textarea" style="width: 81px; background-color: transparent;">Сумма налога,<br>предъявляемая<br>покупателю</div>
  </th>
  <th style="width:85px;" rowspan="2">
    <div id="total_summ_txt" class="editable_sys" edtype="textarea" style="width:85px;">Стоимость товаров (работ, услуг), имущественных прав с налогом - всего</div>
  </th>
  <th style="width:150px;" colspan="2">
    <div id="country_txt" class="editable_sys" edtype="textarea" style="width:152px;">Страна происхождения товара</div>
  </th>
  <th style="width:166px;" rowspan="2">
    <div id="gtd_txt" class="editable_sys" edtype="textarea" style="width: 166px; background-color: transparent;">Номер<br>таможенной<br>декларации</div>
  </th>
 </tr>
<tr>
    <th id="ed_txt_1" class="editable_sys" edtype="textarea" style="width:45px;">код</th>
    <th id="ed_txt_2" class="editable_sys" edtype="textarea" style="width:80px;">условное обозначение (национальное)</th>
    <th id="country_txt_1" class="editable_sys" edtype="textarea" style="width:50px;">цифровой <br>код</th>
    <th id="country_txt_2" class="editable_sys" edtype="textarea" style="width: 100px; background-color: transparent;">краткое<br>наименование</th>
</tr>

</thead>
<thead>
 <tr id="header">
  <th style="width:160px;">
    <div id="name_id" class="editable_sys" edtype="text" style="width:160px;">1</div>
  </th>
  <th style="width:45px;">
    <d  iv id="ed_id" class="editable_sys" edtype="text" style="width:45px;">2</div>
  </th>
  <th style="width:45px;">
    <div id="ed_id2" class="editable_sys" edtype="text" style="width:80px;">2а</div>
  </th>
  <th style="width:60px;">
    <div id="kol_id" class="editable_sys" edtype="text" style="width:60px;">3</div>
  </th>
  <th style="width:68px;">
    <div id="item_price_id" class="editable_sys" edtype="text" style="width:65px;">4</div>
  </th>
  <th style="width:81px;">
    <div id="price_id" class="editable_sys" edtype="text" style="width:81px;">5</div>
  </th>
  <th style="width:54px;">
    <div id="akciz_id" class="editable_sys" edtype="text" style="width:50px;">6</div>
  </th>
  <th style="width:60px;">
    <div id="nds_id" class="editable_sys" edtype="text" style="width:60px;">7</div>
  </th>
  <th style="width:71px;">
    <div id="nds_summ_id" class="editable_sys" edtype="text" style="width:67px;">8</div>
  </th>
  <th style="width:80px;">
    <div id="total_summ_id" class="editable_sys" edtype="text" style="width:80px;">9</div>
  </th>
  <th style="width:50px;">
    <div id="country_id" class="editable_sys" edtype="text" style="width:50px;">10</div>
  </th>
  <th style="width:100px;">
    <div id="country_id2" class="editable_sys" edtype="text" style="width: 100px; background-color: transparent;">10а</div>
  </th>
  <th style="width:166px;">
    <div id="gtd_id" class="editable_sys" edtype="text" style="width:166px;">11</div>
  </th>
 </tr>
</thead>
 <tbody>
 '.$table.'
 <tr id="last_item">
  <td colspan="14" style="border-bottom:1px solid;border-collapse: collapse; ">
  </td>
 </tr>
 <tr>
  <td valign="center" colspan="5">
    <div id="items_summ_txt" class="editable_sys" edtype="text" style="font-weight:bold;font-size:10pt;width:300px;">Всего к оплате:</div>
  </td>
  <td style="font-weight:bold;text-align:right;">
  '.($_POST['avans']=='No'?$_POST['itog']:'---').'
  </td>
 <td colspan="2" style="text-align: center;">
     X
 </td>
 <td style="font-weight:bold;text-align:right;">
 '.$_POST['itog_nds'].'
 </td>
  <td id="invoice_total_summ" style="font-weight:bold;font-size:10pt;text-align:right;">
  '.$_POST['itog_sum'].'
  </td>
<td colspan="2" style="border:0px;"></td>
 </tr>
</tbody></table>

<div id="post_div" style="display:none;">

</div>

<br><br>
<table width="100%">
<tbody><tr>
<td valign="top" width="500">
<table>
<tr>
'.((strlen($_POST['INN_comp'])==10)?'
<td>
Руководитель организации</td><td><span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td><td width="150px">'.(!empty($_POST['chiefName_comp'])?$_POST['chiefName_comp']:'(Фамилия И.О.)').'</td>
</tr><tr><td></td><td style="text-align:center;"><div id="owner_mile" class="editable_sys" edtype="text" style="font-size:7pt;text-align:center;">подпись</div></td><td></td>
':'
<td>Индивидуальный предприниматель</td><td><span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td></td><td width="150px">'.(!empty($_POST['chiefName_comp'])?$_POST['chiefName_comp']:'(Фамилия И.О.)').'</td>
</tr><tr><td></td><td style="text-align:center;"><div id="ip_mile" class="editable_sys" edtype="text" style="font-size:7pt;text-align:center;">подпись</div></td>
').'
</tr>
</table>
</td>
<td valign="top">
<table>
<tr>
    <td width="105px">
        Главный бухгалтер
    </td>
    <td>
        <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </td>
    <td width="150px">
    '.(!empty($_POST['accountant_comp'])?$_POST['accountant_comp']:'(Фамилия И.О.)').'
    </td>
</tr><tr><td>
</td><td style="text-align:center;"><div id="buhgalter_mile" class="editable_sys" edtype="text" style="font-size:7pt;text-align:center;">подпись</div></td><td></td></tr>
'.(strlen($_POST['INN_comp'])==12?'<tr><td>
</td><td><span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.(!empty($_POST['ogrn_comp'])?$_POST['ogrn_comp']:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td><td></td></tr>
<tr><td colspan="3">
(реквизиты свидетельства о государственной регистрации)
</td></tr>
':'').'
</table>
</td>
</tr>
</tbody></table>
<div id="prim" class="editable_sys" edtype="textarea" style="font-size: 7pt; background-color: transparent;">ПРИМЕЧАНИЕ. Первый экземпляр - покупателю, второй экземпляр - продавцу</div>
<br>

</form>
';
include $_SERVER['DOCUMENT_ROOT'] . '/include/MPDF/mpdf.php';

$mpdf = new mPDF('utf-8', 'A4-L', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/
$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/css/document.css'); /*подключаем css*/
$mpdf->WriteHTML($stylesheet, 1);

$mpdf->list_indent_first_level = 0;
$mpdf->WriteHTML($html, 2); /*формируем pdf*/

$mpdf->Output('mpdf.pdf', 'I');
?>