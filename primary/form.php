<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/include/config.php';
    if(User::is_login()){
        $comp=db::select('ac_company','user_id='.User::id());
    if(!isset($_POST['ActOfServicesRendered'])){
        if(!empty($_GET['id_packing'])){
            if($packing=db::select('ac_packing_list','id='.$_GET['id_packing'])){
                $comp=db::select('ac_company','id='.$packing['id_company']);
                $client=db::select('ac_company','id='.$packing['id_client']);
                $bank_comp=db::select('ac_bank','id='.$packing['bank_company']);
                $bank_client=db::select('ac_bank','id='.$packing['bank_client']);
                $consignee=!empty($packing['consignee'])?db::select('ac_company','id='.$packing['consignee']):'';
                $consignor=!empty($packing['consignor'])?db::select('ac_company','id='.$packing['consignor']):'';
                $bank_consignee=!empty($packing['consignee'])?db::select('ac_bank','id='.$packing['bank_consignee']):'';
                $bank_consignor=!empty($packing['consignor'])?db::select('ac_bank','id='.$packing['bank_consignor']):'';
                $items=db::select2array('ac_item','id_packing_list='.$packing['id']);
            }
        }elseif(!empty($_POST['id_packing'])){
            if($packing=db::select('ac_packing_list','id='.$_POST['id_packing'])){
                $comp=db::select('ac_company','id='.$packing['id_company']);
                $client=db::select('ac_company','id='.$packing['id_client']);
                $bank_comp=db::select('ac_bank','id='.$packing['bank_company']);
                $bank_client=db::select('ac_bank','id='.$packing['bank_client']);
                $consignee=!empty($packing['consignee'])?db::select('ac_company','id='.$packing['consignee']):'';
                $consignor=!empty($packing['consignor'])?db::select('ac_company','id='.$packing['consignor']):'';
                $bank_consignee=!empty($packing['consignee'])?db::select('ac_bank','id='.$packing['bank_consignee']):'';
                $bank_consignor=!empty($packing['consignor'])?db::select('ac_bank','id='.$packing['bank_consignor']):'';
                $items=db::select2array('ac_item','id_packing_list='.$packing['id']);
            }
        }else{
                $number=db::select('ac_packing_list','user_id='.User::id().' order by number desc');
        }
    }else{
        if(!empty($_GET['id_act'])){
            if($packing=db::select('ac_act','id='.$_GET['id_act'])){
                $comp=db::select('ac_company','id='.$packing['id_company']);
                $client=db::select('ac_company','id='.$packing['id_client']);
                $items=db::select2array('ac_service','id_act='.$packing['id']);
            }else{
                $number=db::select('ac_act','user_id='.User::id().' order by number desc');
            }
        }else{
            $number=db::select('ac_act','user_id='.User::id().' order by number desc');
        }
    }}
        ?>
            <label for="number">Номер документа</label>
            <input name="number" class="number" type="number" value='<?=!empty($packing['number'])?$packing['number']:(!empty($number)?$number['number']+1:'1')?>' required>
            <span class="error_info number_error"></span>

            <label for="date">Дата составления документа</label>
            <input name="date" class="date" type="text" value='<?=!empty($packing['date0'])?date('d.m.Y',strtotime($packing['date0'])):date('d.m.Y')?>'>
            <span class="error_info date_error"></span>
            <?php
                if(!isset($_POST['ActOfServicesRendered'])){
            ?>
            <label for="base">Основание</label>
            <input name="base" type="text" value='<?=!empty($packing['base'])?$packing['base']:''?>'>
            <span class="error_info base_error"></span>

                    <label for="proxy">Доверенность</label>
                    <input name="proxy" class="hidden_r" type="radio" value='No' <?=empty($packing['number_proxy'])?'checked':''?>>Нет
                    <input name="proxy" class="visible_r" type="radio" value='Yes' <?=!empty($packing['number_proxy'])?'checked':''?>>Есть

                    <div class="proxy" <?=empty($packing['number_proxy'])?'style="display:none"':''?>>

                            <label for="number_proxy">Номер доверенности</label>
                            <input name="number_proxy" type="number" value='<?=!empty($packing['number_proxy'])?$packing['number_proxy']:''?>'>
                            <span class="error_info number_proxy_error"></span>

                                <label for="date_proxy">Дата доверенности</label>
                                <input name="date_proxy" class="date" type="text" value='<?=!empty($packing['date_proxy'])?date('d.m.Y',strtotime($packing['date_proxy'])):''?>'>
                                <span class="error_info date_proxy_error"></span>

                                <label for="name_proxy">ФИО представителя компании</label>
                                <input name="name_proxy" type="text" value='<?=!empty($packing['name_proxy'])?$packing['name_proxy']:''?>'>
                                <span class="error_info name_proxy_error"></span>

                                <label for="position_proxy">Должность представителя</label>
                                <input name="position_proxy" type="text" value='<?=!empty($packing['position_proxy'])?$packing['position_proxy']:''?>'>
                                <span class="error_info position_proxy_error"></span>

                                <label for="name_client_proxy">ФИО доверенного лица</label>
                                <input name="name_client_proxy" type="text" value='<?=!empty($packing['name_client_proxy'])?$packing['name_client_proxy']:''?>'>
                                <span class="error_info name_client_proxy_error"></span>

                                <label for="position_client_proxy">Должность доверенного лица</label>
                                <input name="position_client_proxy" type="text" value='<?=!empty($packing['position_client_proxy'])?$packing['position_client_proxy']:''?>'>
                                <span class="error_info position_client_proxy_error"></span>
                    </div>
            <?php }?>

            <fieldset class="fieldset_comp">
                <legend>Информация об организации</legend>

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
                    <?php
                    if(!isset($_POST['ActOfServicesRendered'])){
                        ?>
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

                    <span id="istel" class="is-is-info"></span>

                    <label for="allowed_comp">Отпуск груза разрешил</label>
                    <input name="allowed_comp" type="text" value='<?=!empty($packing['allowed'])?$packing['allowed']:''?>'>
                    <span class="error_info allowed_comp_error"></span>

                    <label for="allowed_position_comp">Должность разрешившего</label>
                    <input name="allowed_position_comp" type="text" value='<?=!empty($packing['allowed_position'])?$packing['allowed_position']:''?>'>
                    <span class="error_info allowed_position_comp_error"></span>

                    <label for="produced_comp">Отпуск груза произвел</label>
                    <input name="produced_comp" type="text" value='<?=!empty($packing['produced'])?$packing['produced']:''?>'>
                    <span class="error_info produced_comp_error"></span>

                    <label for="produced_position_comp">Должность произвевшего</label>
                    <input name="produced_position_comp" type="text" value='<?=!empty($packing['produced_position'])?$packing['produced_position']:''?>'>
                    <span class="error_info produced_position_comp_error"></span>

                    <?php }else{?>
                        <label for="agent_comp">Представитель</label>
                        <input name="agent_comp" type="text" value='<?=!empty($packing['agent_company'])?$packing['agent_company']:''?>'>
                        <span class="error_info agent_comp_error"></span>
                    <?php }?>
                </div>
            </fieldset>
            <?php
                if(!isset($_POST['ActOfServicesRendered'])){
            ?>
                <fieldset class="fieldset_bcomp">
                <legend>Банковские реквизиты организации</legend>

                <label for="BIC_comp">БИК банка организации</label>
                <input name="BIC_comp" class="visible_b" type="text" value='<?=!empty($bank_comp['BIC'])?$bank_comp['BIC']:''?>' maxlength="9"  minlength="9" required>
                <span class="error_info BIC_comp_error"></span>

                <div class="BIC_comp" <?=empty($bank_comp)?'style="display: none;"':''?>>

                    <label for="name_bank_comp">Название</label>
                    <input name="name_bank_comp" type="text" value='<?=!empty($bank_comp['name'])?$bank_comp['name']:''?>' required>
                    <span class="error_info name_bank_comp_error"></span>

                    <label for="city_bank_comp">Город</label>
                    <input name="city_bank_comp" type="text" value='<?=!empty($bank_comp['city'])?$bank_comp['city']:''?>' required>
                    <span class="error_info city_bank_comp_error"></span>

                    <label for="adress_bank_comp">Адрес</label>
                    <input name="adress_bank_comp" type="text" value='<?=!empty($bank_comp['adress'])?$bank_comp['adress']:''?>' required>
                    <span class="error_info adress_bank_comp_error"></span>

                    <label for="ks_bank_comp">Корреспондентский счет</label>
                    <input name="ks_bank_comp"  class="ks" type="text" value='<?=!empty($bank_comp['ks'])?$bank_comp['ks']:''?>' maxlength="20"  minlength="20" required>
                    <span class="error_info ks_bank_comp_error"></span>
                </div>
            </fieldset>
                    <?php
                        }
                    ?>
            <fieldset class="fieldset_client">
                <legend>Информация о клиенте</legend>

                <label for="INN_client">ИНН клиента</label>
                <input name="INN_client" class="visible" type="text" value='<?=!empty($client['INN'])?$client['INN']:''?>' maxlength="12"  minlength="10" required>
                <span class="error_info INN_client_error"></span>

                <div class="INN_client" <?=empty($client)?'style="display: none;"':''?>>

                    <label for="shortName_client">Краткое название</label>
                    <input name="shortName_client" type="text" value='<?=!empty($client['shortName'])?$client['shortName']:''?>' required>
                    <span class="error_info shortName_client_error"></span>

                    <label for="fullName_client">Полное название</label>
                    <input name="fullName_client" type="text" value='<?=!empty($client['fullName'])?$client['fullName']:''?>' required>
                    <span class="error_info fullName_client_error"></span>

                    <label for="kpp_client">КПП</label>
                    <input name="kpp_client" class="kpp" type="text" value='<?=!empty($client['kpp'])?$client['kpp']:''?>' maxlength="9"  minlength="9" required>
                    <span class="error_info kpp_client_error"></span>

                    <label for="ogrn_client">ОГРН(ОГРН)</label>
                    <input name="ogrn_client" class="ogrn" type="text" value='<?=!empty($client['ogrn'])?$client['ogrn']:''?>' maxlength="15"  minlength="15" required>
                    <span class="error_info ogrn_client_error"></span>

                    <label for="okpo_client">ОКПО</label>
                    <input name="okpo_client" class="okpo" type="text" value='<?=!empty($client['okpo'])?$client['okpo']:''?>' maxlength="10"  minlength="10" required>
                    <span class="error_info okpo_client_error"></span>

                    <label for="address_client">Адрес</label>
                    <input name="address_client" type="text" value='<?=!empty($client['address'])?$client['address']:''?>' required>
                    <span class="error_info address_client_error"></span>
                    <?php
                    if(!isset($_POST['ActOfServicesRendered'])){
                        ?>
                    <label for="chiefName_client">Руководитель</label>
                    <input name="chiefName_client" type="text" value='<?=!empty($client['chiefName'])?$client['chiefName']:''?>' required>
                    <span class="error_info chiefName_client_error"></span>

                    <label for="rs_client">Расчетный счет</label>
                    <input name="rs_client" type="text" class="rs" value='<?=!empty($client['rs'])?$client['rs']:''?>' maxlength="20"  minlength="20" required>
                    <span class="error_info rs_client_error"></span>

                    <label for="tel">Телефон</label>
                    <input required name="tel_client" type="tel" class="tel" value='<?=!empty($client['tel'])?$client['tel']:''?>' maxlength="50">

                    <span id="istel" class="is-is-info"></span>

                    <label for="accepted_client">Груз принял</label>
                    <input name="accepted_client" type="text" value='<?=!empty($packing['accepted'])?$packing['accepted']:''?>'>
                    <span class="error_info accepted_client_error"></span>

                    <label for="accepted_position_client">Должность принявшего груз</label>
                    <input name="accepted_position_client" type="text" value='<?=!empty($packing['accepted_position'])?$packing['accepted_position']:''?>'>
                    <span class="error_info accepted_position_client_error"></span>

                    <label for="received_client">Груз получил грузополучатель</label>
                    <input name="received_client" type="text" value='<?=!empty($packing['received'])?$packing['received']:''?>'>
                    <span class="error_info received_client_error"></span>

                    <label for="received_position_client">Должность грузополучателя</label>
                    <input name="received_position_client" type="text" value='<?=!empty($packing['received_position'])?$packing['received_position']:''?>'>
                    <span class="error_info received_position_client_error"></span>

                    <?php }else{?>
                        <label for="agent_client">Представитель</label>
                        <input name="agent_client" type="text" value='<?=!empty($packing['agent_client'])?$packing['agent_client']:''?>'>
                        <span class="error_info agent_client_error"></span>
                    <?php }?>
                </div>
            </fieldset>
            <?php
                if(!isset($_POST['ActOfServicesRendered'])){
            ?>
            <fieldset class="fieldset_client">
                <legend>Банковские реквизиты клиента</legend>

                <label for="BIC_client">БИК банка клиента</label>
                <input name="BIC_client" class="visible_b" type="text" value='<?=!empty($bank_client['BIC'])?$bank_client['BIC']:''?>' maxlength="9"  minlength="9" required>
                <span class="error_info BIC_client_error"></span>

                <div class="BIC_client" <?=empty($bank_client)?'style="display: none;"':''?>">

                    <label for="name_bank_client">Название</label>
                    <input name="name_bank_client" type="text" value='<?=!empty($bank_client['name'])?$bank_client['name']:''?>' required>
                    <span class="error_info name_bank_client_error"></span>

                    <label for="city_bank_client">Город</label>
                    <input name="city_bank_client" type="text" value='<?=!empty($bank_client['city'])?$bank_client['city']:''?>' required>
                    <span class="error_info city_bank_client_error"></span>

                    <label for="adress_bank_client">Адрес</label>
                    <input name="adress_bank_client" type="text" value='<?=!empty($bank_client['adress'])?$bank_client['adress']:''?>' required>
                    <span class="error_info adress_bank_client_error"></span>

                    <label for="ks_bank_client">Корреспондентский счет</label>
                    <input name="ks_bank_client" class="ks" type="text" value='<?=!empty($bank_client['ks'])?$bank_client['ks']:''?>' maxlength="20"  minlength="20" required>
                    <span class="error_info ks_bank_client_error"></span>
                </div>
            </fieldset>
                    <?php
                        }
                    ?>
                <?=!empty($packing)?'<input type="hidden" name="list" value="'.$packing['id'].'">':''?>
<?php
if(!isset($_POST['ActOfServicesRendered'])) include_once 'consign.php';
include_once 'table_item.php';
?>