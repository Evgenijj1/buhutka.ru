<?php
header('Content-type: text/html; charset=utf-8');
include_once 'num2str.php';
$rub=[1=>'рубль',2=>'рубля',5=>'рублей'];
$kop=[1=>'копейка',2=>'копейки',5=>'копеек'];
foreach($_POST['name_item'] as $key=>$val){
    $table.='
    <tr id="item_1">
        <td class="ppnum" style="text-align:center;width:36px;">'.($key+1).'</td>
        <td></td>
        <td>'.$val.'</td>
        <td >'.$_POST['kol_item'][$key].'</td>
        <td>'.$_POST['ed_item'][$key].'</td>
        <td style="width:67px;">'.$_POST['price_item'][$key].'</td>
        <td style="width:60px;text-align:right;">'.$_POST['sum_item'][$key].'</td>
    </tr>';
}
$html='

<table width="100%" border="0">
<tbody><tr>
<td>
    <div id="seller_name" class="editable" edtype="text" style="width: 100%; font-size: 8pt; font-weight: bold; background-color: transparent;">Продавец: '.(!empty($_POST['shortName_comp'])?$_POST['shortName_comp']:'').', ИНН: '.(!empty($_POST['INN_comp'])?$_POST['INN_comp']:'').'</div>
</td>
</tr>
<tr>
<td>    
    <div id="seller_address" class="editable" edtype="text" style="width: 100%; font-size: 8pt; font-weight: bold; background-color: transparent;">Адрес: '.(!empty($_POST['address_comp'])?$_POST['address_comp']:'').'</div>
</td>
</tr>
</tbody></table>
<br>

    <div id="check_name" class="editable" edtype="text" style="width: 100%; text-align: center; font-size: 8pt; font-weight: bold; background-color: transparent;">ТОВАРНЫЙ ЧЕК №'.(!empty($_POST['number'])?$_POST['number']:'1').' от '.(!empty($_POST['date'])?$_POST['date']:date('d.m.Y')).'</div>

<br>

    <div id="buyer_name" class="editable" edtype="text" style="width: 100%; font-size: 8pt; font-weight: bold; background-color: transparent;">Покупатель: '.(!empty($_POST['shortName_client'])?$_POST['shortName_client']:'').'</div>

<br>
<table id="items" class="check_items" border="1" width="100%" cellpadding="0" cellspacing="0">
<thead>
 <tr id="header">
  <th style="width:30px;">
    <div id="item_n_txt" class="editable_sys" edtype="text" style="width:30px;">№</div>  
  </th> 
  <th style="width:60px;">
    <div id="item_kod_txt" class="editable_sys" edtype="text" style="width:60px;">Код</div>    
  </th> 
  <th>
    <div id="item_name_txt" class="editable_sys" edtype="text" style="background-color: transparent;">Товар</div>     
  </th>  
  <th style="width:50px;">
    <div id="item_kol_txt" class="editable_sys" edtype="text" style="width:50px;">Кол-во</div>       
  </th>
  <th style="width:45px;">
    <div id="item_ed_txt" class="editable_sys" edtype="text" style="width:45px;">Ед.</div>         
  </th>
  <th style="width:75px;">
    <div id="item_price_txt" class="editable_sys" edtype="text" style="width:75px;">Цена</div>         
  </th>
  <th style="width:75px;">
    <div id="item_summ_txt" class="editable_sys" edtype="text" style="width:75px;">Сумма</div>           
  </th>     
 </tr> 
</thead>                
 <tbody><tr id="last_item">
  <td valign="center" colspan="7">
    
  </td>
 </tr>
 '.$table.'
</tbody></table>
<table width="100%">
<tbody><tr>
  <td width="20">
  </td>
  <td>
    &nbsp;
  </td>
</tr>
</tbody></table> 
<br>
<table border="0" width="100%" cellpadding="1" cellspacing="1">

 <tbody><tr>
  <td>
    <div id="items_summ_txt" class="editable_sys" edtype="text" style="font-weight: bold; font-size: 8pt; width: 100%; text-align: left; background: transparent;">Получено: '.(!empty($_POST['itog_sum'])?$_POST['itog_sum']:'0.00').' руб.</div>
  </td>
  <td id="invoice_total_summ" style="font-weight:bold;font-size:10pt;text-align:left;">
 
  </td>
  
 </tr>
 <tr>
  <td>
    <div id="items_summ_txt" class="editable_sys" edtype="text" style="font-weight: bold; font-size: 8pt; width: 100%; text-align: left; background: transparent;">В том числе НДС: '.(!empty($_POST['itog_nds'])?($_POST['itog_nds']):'0.00').' руб.</div>
  </td>
  <td id="invoice_total_summ" style="font-weight:bold;font-size:10pt;text-align:left;">
 
  </td>
  
 </tr>
</tbody></table>

<br>


<span style="font-weight: bold; font-size: 8pt; width: 100%; text-align: left; background: transparent;">'.mb_ucfirst(written_number((integer)$_POST['itog_sum'])).' '.$rub[num_125((integer)$_POST['itog_sum'])].' '.substr($_POST['itog_sum'],-2,2).' '.$kop[num_125((integer)substr($_POST['itog_sum'],-2,2))].'</span>


<br>
<br>
<div id="worker_mile" class="editable_sys" edtype="text" style="background: transparent;">Продавец '.(!empty($_POST['shortName_comp'])?$_POST['shortName_comp']:'______________________').'</div>
<br>
<div id="mp" class="editable_sys" edtype="text" style="width: 300px; text-align: center; background-color: transparent;">М.П.</div>
<br>
<div id="war_accept" class="editable" edtype="textarea" style="width: 100%; font-size: 6.5pt; background-color: transparent;">Гарантийные обязательства</div>
<br>
<div id="get_tov" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">Товар получил(ла) полностью. Претензий по комплектности, внешнему виду и упаковке, не имею.<br>С правилами гарантийного обслуживания ознакомлен(на).</div>
<br><br>
<div id="check_date" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">'.(!empty($_POST['date'])?$_POST['date']:date('d.m.Y')).'</div>
<br><br>
<div id="buyer_mile" class="editable_sys" edtype="text" style="background-color: transparent;">Покупатель '.(!empty($_POST['shortName_client'])?$_POST['shortName_client']:'______________________').'</div>
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