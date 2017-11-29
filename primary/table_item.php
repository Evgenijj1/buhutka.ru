<table class="table" id="tble" cellspacing="0" cellpadding="0">
    <caption>Товары</caption>
    <tr>
        <td>Наименование</td>
        <td width="100px">Ед.</td>
        <td width="90px">Кол-во</td>
        <td width="90px">Цена</td>
        <td width="85px">НДС</td>
        <?if(!isset($_POST['ActOfServicesRendered'])){?>
        <td width="85px">Цифровой код страны</td>
        <td width="85px">Краткое наименование</td>
        <td width="85px">Номер таможенной декларации</td>
        <?}?>
        <td width="100px">Сумма</td>
    </tr>
    <?php
    $total=0.0;
    $nds=0.0;
    if(!empty($items)) {
        foreach($items as $val) {
            $total=$total+(double)$val['number']*(double)$val['price']/100000;
            $nds=$nds+(double)$val['number']*(double)$val['price']*(double)$val['NDS']/10000000;
            ?>
            <tr class="roww">
                <td><input name="name_item[]" type="text" required=""
                           value='<?= $val['name'] ?>' list="list_name"></td>
                <td><input name="ed_item[]" type="text" required=""
                           value='<?= $val['unit'] ?>'></td>
                <td><input name="kol_item[]" class="qnt" type="text" required=""
                           value='<?=number_format((double)$val['number']/1000,3,'.','')?>'></td>
                <td><input name="price_item[]" class="prc" type="text" required=""
                           value='<?=number_format((double)$val['price']/100,2,'.','')?>'></td>
                <td>
                    <select name="nds[]" class="nds">
                        <option <?= $val['NDS'] == 0 ? 'selected' : '' ?> value='0'>0%</option>
                        <option <?= $val['NDS'] == 10 ? 'selected' : '' ?> value='10'>10%</option>
                        <option <?= $val['NDS'] == 18 ? 'selected' : '' ?> value='18'>18%</option>
                    </select>
                </td>
                <?if(!isset($_POST['ActOfServicesRendered'])){?>
                <td><input name="code[]" class="country_code" type="text" maxlength="3" minlength="3"
                           value='<?=$val['country_code']?>'></td>
                <td><input name="country[]" class="country" type="text"
                           value='<?=$val['country_name']?>'></td>
                <td><input name="custom[]" type="text"
                           value='<?=$val['custom']?>'></td>
                <?}?>
                <td><input name="sum_item[]" class="sum" type="text" readonly="" value='<?=number_format((double)$val['number']*(double)$val['price']/100000,2,'.','');?>'></td>
                <td  style="border: none;" align="center"><img class="delete"  src="/images/del_row.png" style="cursor:pointer;width:20px; height: 20px;" alt="Удалить строку" title="Удалить строку" /></td>
            </tr>
        <?php
        }}else {
        ?>
        <tr class="roww">
            <td><input name="name_item[]" type="text" required="" list="list_name"></td>
            <td><input name="ed_item[]" type="text" required="" list="list_unit"></td>
            <td><input name="kol_item[]" class="qnt" type="text" required=""></td>
            <td><input name="price_item[]" class="prc" type="text" required=""></td>
            <td>
                <select name="nds[]" class="nds">
                    <option value='0'>0%</option>
                    <option value='10'>10%</option>
                    <option selected value='18'>18%</option>
                </select>
            </td>
            <?if(!isset($_POST['ActOfServicesRendered'])){?>
            <td><input name="code[]" class="country_code" type="text" maxlength="3" minlength="3"
                       value=''></td>
            <td><input name="country[]" class="country" type="text"
                       value=''></td>
            <td><input name="custom[]" type="text"
                       value=''></td>
            <?}?>
            <td><input name="sum_item[]" class="sum" type="text" readonly=""></td>
            <td  style="border: none;" align="center"><img class="delete"  src="/images/del_row.png" style="cursor:pointer;width:20px; height: 20px;" alt="Удалить строку" title="Удалить строку" /></td>
        </tr>
    <?php
    }
    ?>
    <tr class="last">
        <td colspan="<?=(!isset($_POST['ActOfServicesRendered'])?'7':'4')?>"><span style="cursor:pointer;" id="Addstring">Добавить строку</span></td>
        <td>Итого</td>
        <td><input name="itog" id="total_value" type="text" readonly="" value='<?=number_format($total,2,'.','')?>'></td>
    </tr>
    <tr>
        <td colspan="<?=(!isset($_POST['ActOfServicesRendered'])?'7':'4')?>"></td>
        <td>НДС</td>
        <td><input name="itog_nds" id="total_nds" type="text" readonly="" value='<?=number_format($nds,2,'.','')?>'></td>
    </tr>
    <tr>
        <td colspan="<?=(!isset($_POST['ActOfServicesRendered'])?'7':'4')?>"></td>
        <td>Итого с НДС</td>
        <td><input name="itog_sum" id="total_sum" type="text" readonly="" value='<?=number_format($total+$nds,2,'.','')?>'></td>
    </tr>
</table>
<?php
if(!isset($_POST['ActOfServicesRendered'])){
if($iitems=db::SelectSql('Select name FROM ac_item WHERE id_packing_list in (Select id FROM ac_packing_list WHERE user_id='.User::id().') GROUP BY name')) {
    echo '<datalist id="list_name">';
    foreach ($iitems as $val) {
        echo '<option>' . $val['name'] . '</option>';
    }
    echo '</datalist>';
}
if($iitems=db::SelectSql('Select unit FROM ac_item WHERE id_packing_list in (Select id FROM ac_packing_list WHERE user_id='.User::id().') GROUP BY unit')){
    echo '<datalist id="list_unit">';
    foreach ($iitems as $val) {
        echo '<option>' . $val['unit'] . '</option>';
    }
    echo '</datalist>';
}}else{
if($iitems=db::SelectSql('Select name FROM ac_service WHERE id_act in (Select id FROM ac_act WHERE user_id='.User::id().') GROUP BY name')) {
    echo '<datalist id="list_name">';
    foreach ($iitems as $val) {
        echo '<option>' . $val['name'] . '</option>';
    }
    echo '</datalist>';
}
if($iitems=db::SelectSql('Select unit FROM ac_service WHERE id_act in (Select id FROM ac_act WHERE user_id='.User::id().') GROUP BY unit')){
    echo '<datalist id="list_unit">';
    foreach ($iitems as $val) {
        echo '<option>' . $val['unit'] . '</option>';
    }
    echo '</datalist>';
}}
?>

<script type="text/javascript" src="packing.js"></script>
<script>
    function add_row() {

        var lr = $("tr.last");
        var s='<tr class="roww">' +
            '<td><input name="name_item[]" list="list_name" type="text"></td><td><input name="ed_item[]" type="text" required="" list="list_unit"></td>' +
            '<td><input name="kol_item[]" class="qnt" type="text" required=""></td>' +
            '<td><input name="price_item[]" class="prc" type="text" required=""></td>' +
            '<td><select name="nds[]" class="nds"><option value="0">0%</option><option value="10">10%</option><option selected value="18">18%</option></select></td>'+
            <?if(!isset($_POST['ActOfServicesRendered'])){?>
            '<td><input name="code[]" class="country_code" type="text" maxlength="3" minlength="3" value=""></td>'+
            '<td><input name="country[]" class="country" type="text" value=""></td>'+
            '<td><input name="custom[]" type="text" value=""></td>' +
            <?}?>
            '<td><input name="sum_item[]" class="sum" type="text" readonly=""></td>' +
            '<td style="border: none;" align="center"><img class="delete" style="cursor:pointer;width:20px; height: 20px;" src="/images/del_row.png" alt="Удалить строку" title="Удалить строку" /></td>' +
            '</tr>';
        var new_row = $(s);
        lr.before(new_row);
        set_events();
    }
</script>