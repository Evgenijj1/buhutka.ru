<?php
header('Content-type: text/html; charset=utf-8');
include_once 'num2str.php';
$pre[0]=$_POST['Consignor']=='He'?'_comp':'_consignor';
$pre[1]=$_POST['Consignee']=='He'?'_client':'_consignee';
$pre[2]='_comp';
$pre[3]='_client';
$count=0;
$rub=[1=>'рубль',2=>'рубля',5=>'рублей'];
$kop=[1=>'копейка',2=>'копейки',5=>'копеек'];
for($i=0;$i<4;$i++){
    $e=$pre[$i];
    $arr[$i]=$_POST['shortName'.$e].' , '.$_POST['address'.$e].' , тел. '.$_POST['tel'.$e].' , ИНН '.$_POST['INN'.$e].
        '\\'.$_POST['kpp'.$e].' , р/с '.$_POST['rs'.$e].' в '.$_POST['name_bank'.$e].' , '.$_POST['city_bank'.$e].
        ' , БИК '.$_POST['BIC'.$e].' , корр/с '.$_POST['ks_bank'.$e];
}
$vsego=0;
foreach($_POST['name_item'] as $key=>$val){
$table.='
    <tr id="item_1">
        <td class="ppnum" style="text-align:center;width:36px;">'.($key+1).'</td>
        <td style="width:200px;">'.$val.'</td>
        <td style="width:55px;"></td>
        <td style="width:54px;">'.$_POST['ed_item'][$key].'</td>
        <td style="width:54px;"></td>
        <td style="width:42px;"></td>
        <td style="width:42px;">1</td>
        <td style="width:55px;">1</td>
        <td style="width:53px;"></td>
        <td style="width:61px;">'.$_POST['kol_item'][$key].'</td>
        <td style="width:67px;">'.$_POST['price_item'][$key].'</td>
        <td style="width:60px;text-align:right;">'.number_format((double)$_POST['sum_item'][$key]/((integer)$_POST['nds'][$key]/100+1),2).'</td>
        <td style="width:60px;text-align:center;">'.$_POST['nds'][$key].'%</td>
        <td style="width:67px;text-align:right;">'.number_format((double)$_POST['sum_item'][$key]-(double)$_POST['sum_item'][$key]/((integer)$_POST['nds'][$key]/100+1),2).'</td>
        <td class="torg12_item_summ" style="text-align:right;width:67px;">'.$_POST['sum_item'][$key].'</td>
    </tr>';
    $count=$key+1;
    $vsego+=1;
}
$html = '
<table style="width:100%;border:0px;" border="0">
<tbody><tr>
<td>
    <div style="position: absolute; margin-left: -200px; margin-top: -20px;">
            </div>
</td>
<td style="width:300px;" align="right">
<div id="forma" class="editable_sys" edtype="textarea" style="width: 100px; font-size: 4pt; background-color: transparent;">
Унифицированная форма № ТОРГ-12 Утверждена<br>постановлением Госкомстата России от 25.12.98 № 132
</div>
</td>
</tr>
</tbody></table>


<table style="width:100%;border:0px;" border="0">
<tbody><tr>
<td style="z-index:100;" width="770">
<br>
<table>
<tr>
<td style="border-bottom: 1px solid black;"><div id="gruzootpavitel" class="editable" edtype="textarea" style="width: 750px; background-color: transparent;">'.$arr[0].'</div></td>
</tr>
</table>
<div id="go_name" class="editable_sys" edtype="text" style="font-size: 6.5pt; text-align: center; width: 750px; height: 15px; background-color: transparent;">
грузоотправитель, адрес, номер телефона, банковские реквизиты, структурное подразделение
</div><br><br>
    <table width="100%">
        <tbody><tr>
            <td width="125" align="right"><div id="gruzopoluchatel_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Грузополучатель</div></td>
            <td style="border-bottom:1px solid;"><div id="gruzopoluchatel" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">'.$arr[1].'</div></td>
        </tr>
        <tr>
            <td width="125" align="right"><div id="postavshik_name" class="editable_sys" edtype="text" style="width:100%;font-size:10pt;">Поставщик</div></td>
            <td style="border-bottom:1px solid;"><div id="postavshik" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">'.$arr[2].'</div></td>
        </tr>
        <tr>
            <td width="125" align="right"><div id="platelshik_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Плательщик</div></td>
            <td style="border-bottom:1px solid;"><div id="platelshik" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">'.$arr[3].'</div></td>
        </tr>
        <tr>
            <td width="125" align="right"><div id="osnovanie_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Основание</div></td>
            <td style="border-bottom:1px solid;"><div id="osnovanie" class="editable" edtype="textarea" style="width: 100%; font-size: 8pt; background-color: transparent;">'.$_POST['base'].'</div></td>
        </tr>
        <tr>
            <td width="125" align="right"></td>
            <td valign="top"><div id="naryad_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 6.5pt; text-align: center; background-color: transparent;">договор, заказ-наряд</div></td>
        </tr>
    </tbody></table>
</td>
<td valign="top" align="right"><br>
<div style="position:relative;z-index:0; margin-left: -50px;">
<div style="right:0px;width:310px;z-index:2;">
<table style="background-color: transparent;" width="310" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
        <td colspan="2"></td>
        <td style="border:1px solid;" width="70" align="center"><div id="kod_okud_name" class="editable_sys" edtype="text" style="width:100%;font-size:6.5pt;text-align:center;">Код</div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;" align="right"><div id="okud_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Форма по ОКУД</div></td>
        <td style="border:1px solid;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="okud" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">0330212</div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;" align="right"><div id="okpo_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">по ОКПО</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="okpo" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">'.$_POST['okpo'.$pre[0]].'</div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;" align="right">&nbsp;</td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;" align="right"><div id="okpd_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Вид деятельности по ОКДП</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="okpd" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;height:25px;vertical-align:middle;" align="right"><div id="okpo2_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">по ОКПО</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="okpo2" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">'.$_POST['okpo'.$pre[1]].'</div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;height:25px;vertical-align:middle;" align="right"><div id="okpo3_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">по ОКПО</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="okpo3" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">'.$_POST['okpo'.$pre[2]].'</div></td>
    </tr>
    <tr>
        <td colspan="2" style="padding-right:5px;height:25px;vertical-align:middle;" align="right"><div id="okpo4_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">по ОКПО</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="okpo4" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">'.$_POST['okpo'.$pre[3]].'</div></td>
    </tr>

    <tr>
        <td></td>
        <td style="padding-right:5px;border:1px solid;border-right:0px;" width="70" align="right"><div id="nomer1_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">номер</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="nomer1" class="editable" edtype="text" style="width: 100%; font-size: 10pt; font-weight: bold; background-color: transparent;">&nbsp;</div></td>
    </tr>
    <tr>
        <td></td>
        <td style="padding-right:5px;border:1px solid;border-right:0px;border-top:0px;" width="70" align="right"><div id="data1_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">дата</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="data1" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">&nbsp;</div></td>
    </tr>
    <tr>
        <td style="padding-right:0px;" align="left"><div id="transp_nakl_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Транспортная накладная</div></td>
        <td style="padding-right:5px;border:1px solid;border-right:0px;border-top:0px;" width="70" align="right"><div id="nomer2_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">номер</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="nomer2" class="editable" edtype="text" style="width: 100%; font-size: 10pt; font-weight: bold; background-color: transparent;">&nbsp;</div></td>
    </tr>
    <tr>
        <td></td>
        <td style="padding-right:5px;border:1px solid;border-right:0px;border-top:0px;" width="70" align="right"><div id="data2_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">дата</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;" width="70" align="center"><div id="data2" class="editable" edtype="text" style="width: 100%; font-size: 10pt; font-weight: bold; background-color: transparent;">&nbsp;</div></td>
    </tr>


    <tr>
        <td colspan="2" style="padding-right:5px;" align="right"><div id="vido_name" class="editable_sys" edtype="text" style="width: 100%; font-size: 10pt; background-color: transparent;">Вид операции</div></td>
        <td style="border:1px solid;border-top:0px;border-left:2px solid;border-right:2px solid;border-bottom:2px solid;" width="70" align="center"><div id="vido" class="editable" edtype="text" style="width:100%;font-size:10pt;font-weight:bold;">&nbsp;</div></td>
    </tr>
</tbody></table>
</div>
</div>
</td>
</tr>
<tr>
    <td width="770" align="center">
        <table width="100%">
            <tbody><tr>
                <td width="50%" align="right"><div id="nakladnaya_name" class="editable_sys" edtype="text" style="font-size: 10pt; font-weight: bold; background-color: transparent;">ТОВАРНАЯ НАКЛАДНАЯ</div></td>
                <td align="left">
                    <table cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr><td style="border:1px solid;" width="100" align="center"><div id="nomerdoc_name" class="editable_sys" edtype="text" style="font-size: 6.5pt; background-color: transparent;">Номер документа</div></td><td style="border:1px solid;border-left:0px;" width="100" align="center"><div id="datesoz_name" class="editable_sys" edtype="text" style="font-size:6.5pt;">Дата составления</div></td></tr>
                        <tr><td style="border:2px solid;" align="center"><div id="nomerdoc" class="editable" edtype="text" style="font-size: 10pt; font-weight: bold; background-color: transparent;">'.(!empty($_POST['number'])?$_POST['number']:1).'</div></td><td style="border:2px solid;border-left:0px;" align="center"><div id="date_soz" class="editable" edtype="text" style="font-size:10pt;font-weight:bold;">'.(!empty($_POST['date'])?$_POST['date']:date('d.m.Y')).'</div></td></tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
    </td>
    <td></td>
</tr>
</tbody></table>
<br>
<br>
<table id="items" class="invoice_com_items border" width="100%" cellspacing="0" cellpadding="0" border="0">
<thead>
<tr height="10">
    <td rowspan="2" width="36" height="12" style="text-align:center;"><div id="nomerpp_name" class="editable_sys" edtype="textarea">Но-<br>мер<br>по по-<br>рядку</div></td>
    <td colspan="2" height="12" style="text-align:center;"><div id="tovar_name" class="editable_sys" edtype="text" style="width: 255px; background-color: transparent;">Товар</div></td>
    <td colspan="2" height="12" style="text-align:center;"><div id="ed_name" class="editable_sys" edtype="text" style="width: 108px; background-color: transparent;">Единица измерения</div></td>
    <td rowspan="2" width="42" height="12" style="text-align:center;"><div id="vidupak_name" class="editable_sys" edtype="textarea" style="width: 42px; background-color: transparent;">Вид<br>упа-<br>ковки</div></td>
    <td colspan="2" height="12" style="text-align:center;"><div id="kolvo_name" class="editable_sys" edtype="text" style="background-color: transparent;">Количество</div></td>
    <td rowspan="2" width="53" height="12" style="text-align:center;"><div id="mbrutto_name" class="editable_sys" edtype="textarea" style="width:53px;">Масса<br>брутто</div></td>
    <td rowspan="2" width="61" height="12" style="text-align:center;"><div id="mnetto_name" class="editable_sys" edtype="textarea" style="background-color: transparent;">Количе-<br>ство<br>(масса<br>нетто)</div></td>
    <td rowspan="2" width="67" height="12" style="text-align:center;"><div id="price_name" class="editable_sys" edtype="textarea" style="background-color: transparent;">Цена,<br>руб. коп.</div></td>
    <td rowspan="2" width="60" height="12" style="text-align:center;"><div id="summwo_nds_name" class="editable_sys" edtype="textarea">Сумма без<br>учета НДС,<br>руб. коп.</div></td>
    <td colspan="2" height="12" style="text-align:center;"><div id="nds_name" class="editable_sys" edtype="text">НДС</div></td>
    <td rowspan="2" width="67" height="12" style="text-align:center;"><div id="summw_nds_name" class="editable_sys" edtype="textarea">Сумма с<br>учетом<br>НДС,<br>руб. коп.</div></td>
</tr>
<tr>
    <td width="200" style="text-align:center;"><div id="naim_name" class="editable_sys" edtype="textarea" style="width: 200px; background-color: transparent;">Наименование, характеристика, сорт,<br>артикул товара</div></td>
    <td width="55" style="text-align:center;"><div id="kod_name" class="editable_sys" edtype="text" style="width: 55px; background-color: transparent;">Код</div></td>
    <td width="54" style="text-align:center;"><div id="ednaim_name" class="editable_sys" edtype="textarea" style="width: 54px; background-color: transparent;">Наиме-<br>нование</div></td>
    <td width="54" style="text-align:center;"><div id="okei_name" class="editable_sys" edtype="textarea" style="width: 54px; background-color: transparent;">Код по<br>ОКЕИ</div></td>
    <td width="42" style="text-align:center;"><div id="inplace_name" class="editable_sys" edtype="textarea" style="width:42px;">В<br>одном<br>месте</div></td>
    <td width="55" style="text-align:center;"><div id="mest_name" class="editable_sys" edtype="textarea" style="width:55px;">Мест,<br>штук</div></td>
    <td width="60" style="text-align:center;"><div id="stavka_name" class="editable_sys" edtype="text" style="width:60px;">Ставка, %</div></td>
    <td width="67" style="text-align:center;"><div id="total_summ_name" class="editable_sys" edtype="textarea" style="width:67px;">Сумма,<br>руб. коп.</div></td>
</tr>
 <tr>
  <td style="widtd:36px;text-align:center;">
    <div id="1_id" class="editable_sys" edtype="text" style="background-color: transparent;">1</div>
  </td>
  <td style="widtd:200px;text-align:center;">
    <div id="2_id" class="editable_sys" edtype="text" style="background-color: transparent;">2</div>
  </td>
  <td style="widtd:55px;text-align:center;">
    <div id="3_id" class="editable_sys" edtype="text">3</div>
  </td>
  <td style="widtd:54px;text-align:center;">
    <div id="4_id" class="editable_sys" edtype="text" style="background-color: transparent;">4</div>
  </td>
  <td style="widtd:54px;text-align:center;">
    <div id="5_id" class="editable_sys" edtype="text" style="background-color: transparent;">5</div>
  </td>
  <td style="widtd:42px;text-align:center;">
    <div id="6_id" class="editable_sys" edtype="text" style="background-color: transparent;">6</div>
  </td>
  <td style="widtd:42px;text-align:center;">
    <div id="7_id" class="editable_sys" edtype="text" style="background-color: transparent;">7</div>
  </td>
  <td style="widtd:55px;text-align:center;">
    <div id="8_id" class="editable_sys" edtype="text" style="background-color: transparent;">8</div>
  </td>
  <td style="widtd:53px;text-align:center;">
    <div id="9_id" class="editable_sys" edtype="text" style="background-color: transparent;">9</div>
  </td>
  <td style="widtd:61px;text-align:center;">
    <div id="10_id" class="editable_sys" edtype="text" style="background-color: transparent;">10</div>
  </td>
  <td style="widtd:67px;text-align:center;">
    <div id="11_id" class="editable_sys" edtype="text" style="background-color: transparent;">11</div>
  </td>
  <td style="widtd:60px;text-align:center;">
    <div id="12_id" class="editable_sys" edtype="text">12</div>
  </td>
  <td style="widtd:60px;text-align:center;">
    <div id="13_id" class="editable_sys" edtype="text">13</div>
  </td>
  <td style="widtd:67px;text-align:center;">
    <div id="14_id" class="editable_sys" edtype="text">14</div>
  </td>
  <td style="widtd:67px;text-align:center;">
    <div id="15_id" class="editable_sys" edtype="text">15</div>
  </td>
 </tr>
</thead>
 <tbody>'.
    $table.'
    <tr id="item_n">
        <td class="ppnum" colspan="7" style="border:none;text-align:right; width:36px;">Итого</td>
        <td style="width:55px;"></td>
        <td style="width:53px;"></td>
        <td style="width:61px;"></td>
        <td style="width:67px;text-align:center;">X</td>
        <td style="width:60px;">'.$_POST['itog'].'</td>
        <td style="width:60px;text-align:center;">X</td>
        <td style="width:67px;">'.$_POST['itog_nds'].'</td>
        <td class="torg12_item_summ" style="text-align:right;width:67px;">'.$_POST['itog_sum'].'</td>
    </tr>
</tbody></table>

<table width="100%">
    <tbody><tr>
        <td align="center">
        <div style="text-align:left;font-size:8pt;">Товарная накладная имеет приложение на XXXXXXXXXX листах<br>и содержит порядковых <span style="border-bottom:1px solid; width:500px;">'.written_number($count).'</span> номеров записей
        <div id="propis1_name" class="editable_sys" edtype="text" style="width: 87%; font-size: 6.5pt; text-align: center; background-color: transparent;">прописью</div>
        </div>
        </td>
    </tr>
</tbody></table>

<table width="100%">
    <tbody><tr>
        <td width="365" valign="bottom" align="right">
        <table>
            <tr>
                <td><div id="vsego_mest" class="editable_sys" edtype="text" style="font-size: 8pt; display: inline; background-color: transparent;">Всего мест</div></td><td>'.mb_ucfirst(written_number($vsego)).'</td>
            </tr>
            <tr>
                <td></td><td style="border-top:1px solid;"><div id="propis2_name" class="editable_sys" edtype="text" style="width:180px;font-size:6.5pt;text-align:center;">прописью</div></td>
            </tr>
        </table>
        </td>
        <td style="padding-left:10px;" valign="top" align="right">
        <table style="border-spacing:0;">
            <tr>
                <td style="width:200px;">
                    <div id="massa_netto" class="editable_sys" edtype="text" style="display:inline;text-align:left;">Масса груза (нетто)</div>
                </td>
                <td style="width:450px; border-bottom:1px solid;">

                </td>
                <td style="border:2px solid;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr><tr>
                <td>
                    <div id="massa_brutto" class="editable_sys" edtype="text" style="display: inline; background-color: transparent;">Масса груза (брутто)</div>
                </td>
                <td style="width:450px; border-bottom:1px solid;">
                    <div id="propis4_name" class="editable_sys" edtype="text" style="width: 450px; font-size: 6.5pt; text-align: center; border-top: 1px solid; background-color: transparent;"></div>
                </td>
                <td style="border:2px solid;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
        </table>
        </td>
    </tr>
</tbody></table>
<br>
<table width="100%">
    <tbody><tr>
        <td style="border-right:1px solid;width:50%;">
<div id="pril_pasport" class="editable_sys" edtype="text" style="display:inline;">Приложение (паспорта, сертификаты и т.п) на</div><div style="display:inline;">  _________________</div> <div id="pril_list" class="editable_sys" edtype="text" style="display:inline;">листах</div>
        <div id="propis5_name" class="editable_sys" edtype="text" style="font-size:6.5pt;padding-left:270px;">прописью</div>
        <br>
<div style="font-weight:bold;">Всего отпущено '.written_number($count).' наименований<br>на сумму '.mb_ucfirst(written_number((integer)$_POST['itog_sum'])).' '.$rub[num_125((integer)$_POST['itog_sum'])].' '.substr($_POST['itog_sum'],-2,2).' '.$kop[num_125((integer)substr($_POST['itog_sum'],-2,2))].'</div><br>
<table width="100%" style=" border-spacing:4px;">
    <tbody><tr>
        <td align="left"><div id="otpus_raz_name" class="editable_sys" edtype="text">Отпуск разрешил</div></td>
        <td style="padding:2px;" width="100">'.(!(empty($_POST['allowed_position_comp']))?$_POST['allowed_position_comp']:'Ген. директор').'</td>
        <td style="padding:2px;" width="100">&nbsp;</td>
        <td style="text-align:center;padding:2px;" width="200"><div id="otpus_raz_mile" class="editable" edtype="text">/'.(!(empty($_POST['allowed_comp']))?$_POST['allowed_comp']:$_POST['chiefName_comp']).'/</div></td>
   </tr>
    <tr>
        <td style="font-size:6.5pt;" align="left">&nbsp;</td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="dolznost1_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">должность</div></td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="podpis1_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">подпись</div></td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="rashifr1_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">расшифровка подписи</div></td>
   </tr>

    <tr>
        <td colspan="2" align="left"><div id="buhgalter_name" class="editable_sys" edtype="text">Главный (старший бухгалтер)</div></td>
        <td style="padding:2px;" width="100">&nbsp;</td>
        <td style="text-align:center;padding:2px;" width="200"><div id="buhgalter_mile" class="editable" edtype="text">/'.$_POST['accountant'.$pre[2]].'/</div></td>
   </tr>
    <tr>
        <td colspan="2" style="font-size:6.5pt;" align="left">&nbsp;</td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="podpis2_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">подпись</div></td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="rashifr2_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">расшифровка подписи</div></td>
   </tr>

    <tr>
        <td align="left"><div id="otpus_pro_name" class="editable_sys" edtype="text">Отпуск груза произвел</div></td>
        <td style="padding:2px;" width="100">'.(!(empty($_POST['produced_position_comp']))?$_POST['produced_position_comp']:'').'</td>
        <td style="padding:2px;" width="100">&nbsp;</td>
        <td style="text-align:center;padding:2px;" width="200"><div id="otpus_pro_mile" class="editable" edtype="text">'.(!(empty($_POST['produced_comp']))?'/'.$_POST['produced_comp'].'/':'').'</div></td>
   </tr>
    <tr>
        <td style="font-size:6.5pt;" align="left">&nbsp;</td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="dolznost3_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">должность</div></td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="podpis3_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">подпись</div></td>
        <td style="border-top:1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="rashifr3_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">расшифровка подписи</div></td>
   </tr>
</tbody></table>
<table width="100%">
<tbody><tr>
    <td width="50%" align="center"><div id="mp1_name" class="editable_sys" edtype="text" style="font-size:8pt;text-align:center;">М.П.</div></td>
    <td><div id="date1_name" class="editable_sys" edtype="text" style="font-size:8pt;text-align:center;">\'\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\'\'&nbsp;______________ 20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;года</div></td>
</tr>
</tbody></table>

        </td>
        <td style="width:50%;padding-left:30px;vertical-align:top;"><br>
<div id="po_dover" class="editable_sys" edtype="text" style="background-color: transparent;">По доверенности №<span style="border-bottom:1px solid;">'.(!empty($_POST['number_proxy'])?$_POST['number_proxy']:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').'</span> от '.(!empty($_POST['date_proxy'])?$_POST['date_proxy']:'').'</div>
<div id="dover_vid" class="editable_sys" edtype="text" style="display:inline;">выданной <span style="border-bottom:1px solid;">'.($_POST['proxy']=='Yes'?$_POST['position_proxy'].' '.$_POST['shortName_client'].' '.$_POST['name_proxy'].' для '.$_POST['position_client_proxy'].' '.$_POST['name_client_proxy']:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').'</span></div>
<div id="kem_name" class="editable_sys" edtype="text" style="font-size: 6.5pt; padding-left: 150px; background-color: transparent;">кем, кому (организация, должность, фамилия, и.о.)</div>



<br>
<table width="100%" style=" border-spacing:4px;">
    <tbody><tr>
        <td align="left"><div id="gruz_prin_name" class="editable_sys" edtype="text">Груз принял</div></td>
        <td style="padding:2px;" width="100">'.(!(empty($_POST['accepted_position_client']))?$_POST['accepted_position_client']:'Ген. директор').'</td>
        <td style="padding:2px;" width="100">&nbsp;</td>
        <td style="text-align:center;padding:2px;" width="100"><div id="gruz_prin_mile" class="editable_sys" edtype="text">/'.(!(empty($_POST['accepted_client']))?$_POST['accepted_client']:$_POST['chiefName_client']).'/</div></td>
   </tr>
    <tr>
        <td style="font-size:6.5pt;" align="left">&nbsp;</td>
        <td style="border-top: 1px solid; padding:0px;padding-left:3px;padding-right:3px;"><div id="dolznost4_name" class="editable_sys" edtype="text" style="font-size: 6.5pt; text-align: center; background-color: transparent;">должность</div></td>
        <td style="border-top: 1px solid; padding:0px;padding-left:3px;padding-right:3px;"><div id="podpis4_name" class="editable_sys" edtype="text" style="font-size: 6.5pt; text-align: center; background-color: transparent;">подпись</div></td>
        <td style="border-top: 1px solid; padding:0px;padding-left:3px;padding-right:3px;"><div id="rashifr4_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">расшифровка подписи</div></td>
   </tr>

    <tr>
        <td rowspan="2" valign="top" align="left"><div id="gruz_pol_name" class="editable_sys" edtype="textarea">Груз получил<br>грузополучатель</div></td>
        <td style="padding:2px;" width="100">'.(!(empty($_POST['received_position_client']))?$_POST['received_position_client']:'').'</td>
        <td style="padding:2px;" width="100">&nbsp;</td>
        <td style="text-align:center;padding:2px;" width="100"><div id="gruz_pol_mile" class="editable_sys" edtype="text">'.(!(empty($_POST['received_client']))?'/'.$_POST['received_client'].'/':'').'</div></td>
   </tr>
    <tr>

        <td style="border-top: 1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="dolznost5_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">должность</div></td>
        <td style="border-top: 1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="podpis5_name" class="editable_sys" edtype="text" style="font-size: 6.5pt; text-align: center; background-color: transparent;">подпись</div></td>
border-top: 1px solid;        <td style="border-top: 1px solid;padding:0px;padding-left:3px;padding-right:3px;"><div id="rashifr5_name" class="editable_sys" edtype="text" style="font-size:6.5pt;text-align:center;">расшифровка подписи</div></td>
   </tr>
</tbody></table>
<table width="100%">
<tbody><tr>
    <td width="50%" align="center"><div id="mp2_name" class="editable_sys" edtype="text" style="font-size:8pt;text-align:center;">М.П.</div></td>
    <td><div id="date2_name" class="editable_sys" edtype="text" style="font-size: 8pt; text-align: center; background-color: transparent;">\'\'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\'\'&nbsp;______________ 20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;года</div></td>
</tr>
</tbody></table>
        </td>
    </tr>
</tbody></table>
';

include $_SERVER['DOCUMENT_ROOT'] . '/include/MPDF/mpdf.php';

$mpdf = new mPDF('utf-8', 'A4-L', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/
$stylesheet = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/css/document.css'); /*подключаем css*/
$mpdf->WriteHTML($stylesheet, 1);

$mpdf->list_indent_first_level = 0;
$mpdf->WriteHTML($html, 2); /*формируем pdf*/
$numpage=$mpdf->docPageNum();

$mpdf->Output('mpdf.pdf', 'F');

$mpdf->OverWrite('mpdf.pdf','XXXXXXXXXX',written_number($numpage),'I');
?>