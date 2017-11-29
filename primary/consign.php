<fieldset class="fieldset_consignee">
    <legend>Грузополучатель</legend>

    <label for="Consignee">Грузополучатель</label>
    <input name="Consignee" class="hidden_r" type="radio" value='He' <?=empty($consignee)?'checked':''?>>Он же
    <input name="Consignee" class="visible_r" type="radio" value='Non' <?=!empty($consignee)?'checked':''?>>Стороннее юр. лицо

    <div class="Consignee" <?=empty($consignee)?'style="display:none"':''?>>

        <fieldset class="fieldset">
            <legend>Информация о грузополучателе</legend>

            <label for="INN_consignee">ИНН продавца</label>
            <input name="INN_consignee" class="require_Consignee visible" type="text" value='<?=!empty($consignee['INN'])?$consignee['INN']:''?>' maxlength="12"  minlength="0">
            <span class="error_info INN_consignee_error"></span>

            <div class="INN_consignee" <?=empty($consignee)?'style="display:none"':''?>>

                <label for="shortName_consignee">Краткое название</label>
                <input name="shortName_consignee" class="require_Consignee" type="text" value='<?=!empty($consignee['shortName'])?$consignee['shortName']:''?>'>
                <span class="error_info shortName_consignee_error"></span>

                <label for="fullName_consignee">Полное название</label>
                <input name="fullName_consignee" class="require_Consignee" type="text" value='<?=!empty($consignee['fullName'])?$consignee['fullName']:''?>'>
                <span class="error_info fullName_consignee_error"></span>

                <label for="kpp_consignee">КПП</label>
                <input name="kpp_consignee" class="kpp require_Consignee" type="text" value='<?=!empty($consignee['kpp'])?$consignee['kpp']:''?>' maxlength="9"  minlength="9">
                <span class="error_info kpp_consignee_error"></span>

                <label for="ogrn_consignee">ОГРН(ОГРНИП)</label>
                <input name="ogrn_consignee" class="ogrn require_Consignee" type="text" value='<?=!empty($consignee['ogrn'])?$consignee['ogrn']:''?>' maxlength="15"  minlength="15">
                <span class="error_info ogrn_consignee_error"></span>

                <label for="okpo_consignee">ОКПО</label>
                <input name="okpo_consignee" class="okpo require_Consignee" type="text" value='<?=!empty($consignee['okpo'])?$consignee['okpo']:''?>' maxlength="10"  minlength="10">
                <span class="error_info okpo_consignee_error"></span>

                <label for="address_consignee">Адрес</label>
                <input name="address_consignee" class="require_Consignee" type="text" value='<?=!empty($consignee['address'])?$consignee['address']:''?>'>
                <span class="error_info address_consignee_error"></span>

                <label for="chiefName_consignee">Руководитель</label>
                <input name="chiefName_consignee" class="require_Consignee" type="text" value='<?=!empty($consignee['chiefName'])?$consignee['chiefName']:''?>'>
                <span class="error_info chiefName_consignee_error"></span>

                <label for="rs_consignee">Расчетный счет</label>
                <input name="rs_consignee" type="text" class="rs require_Consignee" value='<?=!empty($consignee['rs'])?$consignee['rs']:''?>' maxlength="20"  minlength="20">
                <span class="error_info rs_consignee_error"></span>

                <label for="tel_consignee">Телефон</label>
                <input id="tel" name="tel_consignee" type="tel" class="tel require_Consignee" value='<?=!empty($consignee['tel'])?$consignee['tel']:''?>' maxlength="50">

                <span id="istel" class="is-is-info"></span>
            </div>
        </fieldset>

        <fieldset class="fieldset">
            <legend>Банковские реквизиты грузополучателя</legend>

            <label for="BIC_consignee">БИК банка грузополучателя</label>
            <input name="BIC_consignee" class="bic require_Consignee visible_b" type="text" value='<?=!empty($bank_consignee['BIC'])?$bank_consignee['BIC']:''?>' maxlength="9"  minlength="9">
            <span class="error_info BIC_consignee_error"></span>

            <div class="BIC_consignee" <?=empty($bank_consignee)?'style="display:none"':''?>>

                <label for="name_bank_consignee">Название</label>
                <input name="name_bank_consignee" class="require_Consignee" type="text" value='<?=!empty($bank_consignee['name'])?$bank_consignee['name']:''?>'>
                <span class="error_info name_bank_consignee_error"></span>

                <label for="city_bank_consignee">Город</label>
                <input name="city_bank_consignee" class="require_Consignee" type="text" value='<?=!empty($bank_consignee['city'])?$bank_consignee['city']:''?>'>
                <span class="error_info city_bank_consignee_error"></span>

                <label for="adress_bank_consignee">Адрес</label>
                <input name="adress_bank_consignee" class="require_Consignee" type="text" value='<?=!empty($bank_consignee['adress'])?$bank_consignee['adress']:''?>'>
                <span class="error_info adress_bank_consignee_error"></span>

                <label for="ks_bank_consignee">Корреспондентский счет</label>
                <input name="ks_bank_consignee" class="ks require_Consignee" type="text" value='<?=!empty($bank_consignee['ks'])?$bank_consignee['ks']:''?>' maxlength="20"  minlength="20">
                <span class="error_info ks_bank_consignee_error"></span>
            </div>
        </fieldset>
    </div>

</fieldset>
<fieldset class="fieldset_consignor">
    <legend>Грузоотправитель</legend>

    <label for="Consignor">Грузоотправитель</label>
    <input name="Consignor" class="hidden_r" type="radio" value='He' <?=empty($consignor)?'checked':''?>>Он же
    <input name="Consignor" class="visible_r" type="radio" value='Non' <?=!empty($consignor)?'checked':''?>>Стороннее юр. лицо

    <div class="Consignor" <?=empty($consignor)?'style="display:none"':''?>>

        <fieldset class="fieldset">
            <legend>Информация о грузоотправителе</legend>

            <label for="INN_consignor">ИНН грузополучателя</label>
            <input name="INN_consignor" class="require_Consignor visible" type="text" value='<?=!empty($consignor['INN'])?$consignor['INN']:''?>' maxlength="12"  minlength="10">
            <span class="error_info INN_consignor_error"></span>

            <div class="INN_consignor" <?=empty($consignor)?'style="display:none"':''?>>

                <label for="shortName_consignor">Краткое название</label>
                <input name="shortName_consignor" class="require_Consignor" type="text" value='<?=!empty($consignor['shortName'])?$consignor['shortName']:''?>'>
                <span class="error_info shortName_consignor_error"></span>

                <label for="fullName_consignor">Полное название</label>
                <input name="fullName_consignor" class="require_Consignor" type="text" value='<?=!empty($consignor['fullName'])?$consignor['fullName']:''?>'>
                <span class="error_info fullName_consignor_error"></span>

                <label for="kpp_consignor">КПП</label>
                <input name="kpp_consignor" class="kpp require_Consignor" type="text" value='<?=!empty($consignor['kpp'])?$consignor['kpp']:''?>' maxlength="9"  minlength="9">
                <span class="error_info kpp_consignor_error"></span>

                <label for="ogrn_consignor">ОГРН(ОГРНИП)</label>
                <input name="ogrn_consignor" class="ogrn require_Consignor" type="text" value='<?=!empty($consignor['ogrn'])?$consignor['ogrn']:''?>' maxlength="15"  minlength="15">
                <span class="error_info ogrn_consignor_error"></span>

                <label for="okpo_consignor">ОКПО</label>
                <input name="okpo_consignor" class="okpo require_Consignor" type="text" value='<?=!empty($consignor['okpo'])?$consignor['okpo']:''?>' maxlength="10"  minlength="10">
                <span class="error_info okpo_consignor_error"></span>

                <label for="address_consignor">Адрес</label>
                <input name="address_consignor" class="require_Consignor" type="text" value='<?=!empty($consignor['address'])?$consignor['address']:''?>'>
                <span class="error_info address_consignor_error"></span>

                <label for="chiefName_consignor">Руководитель</label>
                <input name="chiefName_consignor" class="require_Consignor" type="text" value='<?=!empty($consignor['chiefName'])?$consignor['chiefName']:''?>'>
                <span class="error_info chiefName_consignor_error"></span>

                <label for="rs_consignor">Расчетный счет</label>
                <input name="rs_consignor" type="text" class="rs require_Consignor" value='<?=!empty($consignor['rs'])?$consignor['rs']:''?>' maxlength="20"  minlength="20">
                <span class="error_info rs_consignor_error"></span>

                <label for="tel_consignor">Телефон</label>
                <input id="tel" name="tel_consignor" type="tel" class="tel require_Consignor" value='<?=!empty($consignor['tel'])?$consignor['tel']:''?>' maxlength="50">

                <span id="istel" class="is-is-info"></span>
            </div>
        </fieldset>

        <fieldset class="fieldset">
            <legend>Банковские реквизиты грузоотправителя</legend>

            <label for="BIC_consignor">БИК банка грузоотправителя</label>
            <input name="BIC_consignor" class="bic require_Consignor visible_b" type="text" value='<?=!empty($bank_consignor['BIC'])?$bank_consignor['BIC']:''?>' maxlength="9"  minlength="9">
            <span class="error_info BIC_consignor_error"></span>

            <div class="BIC_consignor" <?=empty($bank_consignor)?'style="display:none"':''?>>

                <label for="name_bank_consignor">Название</label>
                <input name="name_bank_consignor" class="require_Consignor" type="text" value='<?=!empty($bank_consignor['name'])?$bank_consignor['name']:''?>'>
                <span class="error_info name_bank_consignor_error"></span>

                <label for="city_bank_consignor">Город</label>
                <input name="city_bank_consignor" class="require_Consignor" type="text" value='<?=!empty($bank_consignor['city'])?$bank_consignor['city']:''?>'>
                <span class="error_info city_bank_consignor_error"></span>

                <label for="adress_bank_consignor">Адрес</label>
                <input name="adress_bank_consignor" class="require_Consignor" type="text" value='<?=!empty($bank_consignor['adress'])?$bank_consignor['adress']:''?>'>
                <span class="error_info adress_bank_consignor_error"></span>

                <label for="ks_bank_consignor">Корреспондентский счет</label>
                <input name="ks_bank_consignor" class="ks require_Consignor" type="text" value='<?=!empty($bank_consignor['ks'])?$bank_consignor['ks']:''?>' maxlength="20"  minlength="20">
                <span class="error_info ks_bank_consignor_error"></span>
            </div>
        </fieldset>
    </div>
</fieldset>