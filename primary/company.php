<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
if(User::is_login()){
//(User::is_login()?'Дорегистрация':'Регистрация');
$h1=$title='Введите данные вашей компании';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
    $comp=db::select('ac_company','user_id='.User::id());
?>
    <link rel="stylesheet" href="../user/style.css" type="text/css">
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js" xmlns="http://www.w3.org/1999/html"
            xmlns="http://www.w3.org/1999/html"></script>
    <script type="text/javascript" src="//htmlweb.ru/geo/api.js" async="true"></script>
    <script type="text/javascript" src="../test/js.js" async></script>
    <script src="data_validator.js"></script>
    <div class="container clearfix">
        <div style="max-width: 700px;" class="b-login user clearfix">
            <h1><?=$h1?></h1>

            <form name="anketa" id="form_packing" method="post" target="_blank" action="php2pdf/php2pdf.php">
                <fieldset class="fieldset_client">
                    <legend>Информация о клиенте</legend>
                    <label for="INN_comp">ИНН организации</label>
                    <input name="INN_comp" class="visible" type="text" value='<?=!empty($comp['INN'])?$comp['INN']:''?>' maxlength="12"  minlength="10" required>
                    <span class="error_info INN_comp_error"></span>

                    <div class="INN_comp" <?=empty($comp)?'style="display: none;"':''?>>

                        <label for="shortName_comp">Краткое название</label>
                        <input name="shortName_comp" type="text" value='<?=!empty($comp['shortName'])?$comp['shortName']:''?>' required>
                        <span class="error_info shortName_comp_error"></span>

                        <label for="fullName_comp">Полное название</label>
                        <input name="fullName_comp" type="text" value='<?=!empty($comp['fullName'])?$comp['fullName']:''?>' required>
                        <span class="error_info fullName_comp_error"></span>

                        <label for="kpp_comp">КПП</label>
                        <input name="kpp_comp" class="kpp" type="text" value='<?=!empty($comp['kpp'])?$comp['kpp']:''?>' maxlength="9"  minlength="9" required>
                        <span class="error_info kpp_comp_error"></span>

                        <label for="ogrn_comp">OГРН(ОГРНИП)</label>
                        <input name="ogrn_comp" class="ogrn" type="text" value='<?=!empty($comp['ogrn'])?$comp['ogrn']:''?>' maxlength="15"  minlength="15" required>
                        <span class="error_info ogrn_comp_error"></span>

                        <label for="okpo_comp">ОКПО</label>
                        <input name="okpo_comp"  class="okpo" type="text" value='<?=!empty($comp['okpo'])?$comp['okpo']:''?>' maxlength="10"  minlength="10" required>
                        <span class="error_info okpo_comp_error"></span>

                        <label for="address_comp">Адрес</label>
                        <input name="address_comp" type="text" value='<?=!empty($comp['address'])?$comp['address']:''?>' required>
                        <span class="error_info address_comp_error"></span>

                        <label for="chiefName_comp">Руководитель</label>
                        <input name="chiefName_comp" type="text" value='<?=!empty($comp['chiefName'])?$comp['chiefName']:''?>' required>
                        <span class="error_info chiefName_comp_error"></span>

                        <label for="accountant_comp">Главный бухгалтер</label>
                        <input name="accountant_comp" type="text" value='<?=!empty($comp['accountant'])?$comp['accountant']:''?>' required>
                        <span class="error_info accountant_comp_error"></span>

                        <label for="rs_comp">Расчетный счет</label>
                        <input name="rs_comp"  class="rs" type="text" value='<?=!empty($comp['rs'])?$comp['rs']:''?>' maxlength="20"  minlength="20" required>
                        <span class="error_info rs_comp_error"></span>

                        <label for="tel">Телефон</label>
                        <input required name="tel_comp" type="text" class="tel" value='<?=!empty($comp['rs'])?$comp['rs']:''?>' maxlength="50">
                        </div>
                    </fieldset>

                <input type="submit" onclick="save_comp();return false;" class="btn green" value="Сохранить">
                <script type="text/javascript" src="packing.js"></script>
            </form>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery(".tel").mask("+7(999) 999-99-99");
        });
        function save_comp() {
            var msg   = jQuery('#form_packing').serialize();
            jQuery.ajax({
                type: 'POST',
                url: 'ajax/save_comp.php',
                data: msg
            }).done(function(data){
                var res = JSON.parse(data);
                alert(res.msg);
            });
        }
    </script>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/include/tail.php';
}else{
    header('Location: ./index.php');
}?>