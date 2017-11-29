<?php
header('Content-type: text/html; charset=utf-8');
include_once 'num2str.php';
function rdate($param, $time=0) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    if(strpos($param,'M')===false) return date($param, $time);
    else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}
$rub=[1=>'рубль',2=>'рубля',5=>'рублей'];
$kop=[1=>'копейка',2=>'копейки',5=>'копеек'];
$table='';
$count=0;
foreach ($_POST['name_item'] as $key=>$val) {
    $table.='
        <tr>
            <td>'.($key+1).'</td>
            <td>'.$val.'</td>
            <td>'.$_POST['kol_item'][$key].'</td>
            <td>'.$_POST['ed_item'][$key].'</td>
            <td>'.$_POST['price_item'][$key].'</td>
            <td style="text-align:right;">'.$_POST['sum_item'][$key].'</td>
        </tr>
    ';
    $count=$key+1;
}
$html='
<div style="font-weight: bold; font-size: 14pt; border-bottom: 2px solid; margin-top: 10px;"><div id="akt_nomer" class="editable" edtype="text" style="background-color: transparent;">Акт № '.(!empty($_POST['number'])?$_POST['number']:'1').' от '.(!empty($_POST['date'])?rdate('d M Y',strtotime($_POST['date'])):rdate('d M Y')).' г.</div></div>
<table width="100%" style="font-size: 9pt;">
<tbody><tr>
    <td style="font-size: 6pt;" colspan="2">&nbsp;</td>
</tr>
<tr>
    <td width="100"><div id="ispolnitel_text" class="editable_sys" edtype="text">Исполнитель:</div></td>
    <td style="font-weight: bold;"><div id="ispolnitel" class="editable" edtype="textarea" style="background-color: transparent;">'.((!empty($_POST['shortName_comp'])?$_POST['shortName_comp']:'').', ИНН/КПП '.(!empty($_POST['INN_comp'])?$_POST['INN_comp']:'').'/'.(!empty($_POST['kpp_comp'])?$_POST['kpp_comp']:'').', '.(!empty($_POST['address_comp'])?$_POST['address_comp']:'')).'</div></td>
</tr>
<tr>
    <td style="font-size: 6pt;" colspan="2">&nbsp;</td>
</tr>
<tr>
    <td width="100"><div id="zakazchik_text" class="editable_sys" edtype="text">Заказчик:</div></td>
    <td style="font-weight: bold;"><div id="zakazchik" class="editable" edtype="textarea" style="background-color: transparent;">'.((!empty($_POST['shortName_client'])?$_POST['shortName_client']:'').', ИНН/КПП '.(!empty($_POST['INN_client'])?$_POST['INN_client']:'').'/'.(!empty($_POST['kpp_client'])?$_POST['kpp_client']:'').', '.(!empty($_POST['address_client'])?$_POST['address_client']:'')).'</div></td>
</tr>
<tr>
    <td style="font-size: 6pt;" colspan="2">&nbsp;</td>
</tr>
</tbody></table>
<table class="items_block" style="width: 100%; text-align: center; font-size: 14pt; font-weight: bold; background-color: transparent;" border="1" cellpadding="0" cellspacing="0">
<thead>
<tr id="header" style="text-align: center;">
    <td width="72"><div id="item_npp_txt" class="editable_sys" edtype="textarea">№</div></td>
    <td width="517"><div id="item_usluga_txt" class="editable_sys" edtype="textarea" style="background-color: transparent;">Наименование работ, услуг</div></td>
    <td width="94"><div id="item_kolvo_txt" class="editable_sys" edtype="textarea">Кол-во</div></td>
    <td width="94"><div id="item_ei_txt" class="editable_sys" edtype="textarea">Ед.</div></td>
    <td width="94"><div id="item_price_txt" class="editable_sys" edtype="textarea">Цена</div></td>
    <td width="94"><div id="item_summ_txt" class="editable_sys" edtype="textarea">Сумма</div></td>
</tr>
</thead>
<tbody>
<tr id="last_item">
    <td colspan="6" style="text-align: left;">
    </td>
</tr>
'.$table.'
</tbody></table>
<table border="0" width="100%" cellpadding="1" cellspacing="1">
<tbody><tr>
    <td valign="center"></td>
    <td width="134" style="font-weight:bold;font-size:10pt;text-align:right;">Итого:</td>
    <td width="94" id="akt_total_summ" style="font-weight:bold;font-size:10pt;text-align:right;">'.$_POST['itog_sum'].'</td>
</tr>
<tr>
    <td valign="center"></td>
    <td width="134" style="font-weight:bold;font-size:10pt;text-align:right;">В том числе НДС:</td>
    <td width="94" id="akt_total_summ" style="font-weight:bold;font-size:10pt;text-align:right;">'.$_POST['itog_nds'].'</td>
</tr>
</tbody></table>

<div id="post_div" style="display:none;"><input type="text" name="akt_nomer"><input type="text" name="ispolnitel_text"><textarea name="ispolnitel"></textarea><input type="text" name="zakazchik_text"><textarea name="zakazchik"></textarea><textarea name="item_npp_txt"></textarea><textarea name="item_usluga_txt"></textarea><textarea name="item_kolvo_txt"></textarea><textarea name="item_ei_txt"></textarea><textarea name="item_price_txt"></textarea><textarea name="item_summ_txt"></textarea><input type="text" name="items_summ_txt"><input type="text" name="uslugi_text"><input type="text" name="ispolnitel_mile_text"><input type="text" name="zakazchik_mile_text"></div>
<br>
<div id="items_total_text" style="font-size: 10pt;">&nbsp;Всего оказано услуг '.$count.', на сумму '.$_POST['itog_sum'].' руб.</div>
<table style="font-weight: bold; font-size: 14pt;" width="100%">
<tbody><tr>
    <td style="font-weight:bold;" colspan="4">'.mb_ucfirst(written_number((integer)$_POST['itog_sum'])).' '.$rub[num_125((integer)$_POST['itog_sum'])].' '.substr($_POST['itog_sum'],-2,2).' '.$kop[num_125((integer)substr($_POST['itog_sum'],-2,2))].'<br><br><br></td>
</tr>
<tr>
    <td style="font-weight:normal; text-align: left;" colspan="4"><div id="uslugi_text" class="editable_sys" edtype="text" style="background-color: transparent;">'.(!empty($_POST['comment'])?$_POST['comment']:'').'</div></td>
</tr>
<tr>
    <td style="font-size: 6pt; border-bottom: 2px solid;" colspan="4">&nbsp;</td>
</tr>
<tr>
    <td style="font-size: 12pt;" colspan="4">&nbsp;</td>
</tr>
<tr>
    <td width="100"><div id="ispolnitel_mile_text" class="editable_sys" edtype="text" style="background: transparent;">Исполнитель</div></td>
    <td width="350" style="border-bottom: 1px solid;">'.($_POST['agent_comp']).'</td>
    <td width="90"><div id="zakazchik_mile_text" class="editable_sys" edtype="text" style="background-color: transparent;">Заказчик</div></td>
    <td width="389" style="border-bottom: 1px solid;">'.($_POST['agent_client']).'</td>
</tr>
</tbody></table>
';

include $_SERVER['DOCUMENT_ROOT'] . '/include/MPDF/mpdf.php';

$mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

//$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/css/document.css'); /*подключаем css*/
$mpdf->WriteHTML($stylesheet, 1);

$mpdf->list_indent_first_level = 0;
$mpdf->WriteHTML($html, 2); /*формируем pdf*/
$mpdf->Output('mpdf.pdf', 'I');
?>