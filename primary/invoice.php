<?
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
//(User::is_login()?'Дорегистрация':'Регистрация');
$h1=$title='Счет-фактура';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
?>
    <link rel="stylesheet" href="../user/style.css" type="text/css">
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js" xmlns="http://www.w3.org/1999/html"
            xmlns="http://www.w3.org/1999/html"></script>
    <script type="text/javascript" src="//htmlweb.ru/geo/api.js" async="true"></script>
    <script type="text/javascript" src="../test/js.js" async></script>
    <script src="data_validator.js"></script>
    <div class="container clearfix">
        <div style="max-width: 900px;" class="b-login user clearfix">
            <h1><?=$h1?></h1>

            <?php
            if(!User::is_login()){
                echo '<h3>
            Регистрация через:
                <a class="icon-vk" href="../user/api.php?vk" title="Войти через Vkontakte"></a>
                <a class="icon-facebook" href="../user/api.php?fb" title="Войти через Facebook"></a><br>
            </h3>';
            }
            if(!empty($_GET['id_invoice'])){
                if($invoice=db::select('ac_invoice','id='.$_GET['id_invoice'])){
                    $docs=db::select2array('ac_documents','invoice_id='.$_GET['id_invoice']);
                    $_GET['id_packing']=$invoice['id_packing'];
                }
            }else if(!empty($_GET['id_packing'])){
                $packing_num=db::select('ac_packing_list','id='.$_GET['id_packing'])['number'];
            }else{
                $packing_num=db::select('ac_packing_list','user_id='.User::id().' order by number desc')['number']+1;
            }
            ?>
            <form name="anketa" id="form_packing" method="post" target="_blank" action="../primary/php2pdf/php2pdf_fact.php">

                <label for="number_fact">Счет-фактура №</label>
                <input name="number_fact" type="number" value='<?=(!empty($invoice['number'])?$invoice['number']:$packing_num)?>' required>
                <span class="error_info number_fact_error"></span>

                <label for="date_fact">Дата составления</label>
                <input name="date_fact" class="date" type="text" value='<?=(!empty($invoice['date0'])?date('d.m.Y',strtotime($invoice['date0'])):date('d.m.Y'))?>' required>
                <span class="error_info date_fact_error"></span>

                <fieldset class="fieldset_edits">
                    <legend>Исправления</legend>

                    <label for="edit">Исправления</label>
                    <input name="edit" class="hidden_r" type="radio" value='No' <?=((empty($invoice['number_correction'])&&empty($invoice['date_correction']))?'checked':'')?>>Не вносились
                    <input name="edit" class="visible_r" type="radio" value='Yes' <?=((empty($invoice['number_correction'])&&empty($invoice['date_correction']))?'':'checked')?>>Вносились

                    <div class="edit" <?=((empty($invoice['number_correction'])&&empty($invoice['date_correction']))?'style="display: none;"':'')?>>
                        <label for="number_fact_edit">Исправление №</label>
                        <input name="number_fact_edit" type="number" value='<?=(!empty($invoice['number_correction'])?$invoice['number_correction']:'')?>'>
                        <span class="error_info number_fact_edit_error"></span>

                        <label for="date_fact_edit">Дата исправления</label>
                        <input name="date_fact_edit" class="date" type="text" value='<?=(!empty($invoice['date_correction'])?date('d.m.Y',strtotime($invoice['date_correction'])):date('d.m.Y'))?>'>
                        <span class="error_info date_fact_edit_error"></span>
                    </div>
                </fieldset>

                <label for="avans">На авансовый платеж</label>
                <input name="avans" type="radio" value='Yes' <?=(!empty($invoice)&&$invoice==1)?'checked':''?>>Да
                <input name="avans" type="radio" value='No'  <?=(!empty($invoice)&&$invoice==1)?'':'checked'?>>Нет

                    <table class="table">
                        <caption>К платежно-расчетному документу</caption>
                        <tr>
                            <td>№ документа</td>
                            <td>Дата</td>
                            <td></td>
                        </tr>
                        <?php
                            if(!empty($docs)){
                                foreach ($docs as $val) {
                                    echo '<tr>
                                    <td><input type="number" name="doc_num[]" value="'.$val['number'].'"></td>
                                    <td><input type="text" name="doc_date[]" class="date" value="'.date('d.m.Y',strtotime($val['date0'])).'"></td>
                                    <td><img class="delete"  src="/images/del_row.png" style="cursor:pointer;width:20px; height: 20px;" alt="Удалить строку" title="Удалить строку" /></td>
                                    </tr>';
                                }
                            }else {
                                echo '<tr>
                                <td><input type="number" name="doc_num[]"></td>
                                <td><input type="text" name="doc_date[]" class="date"></td>
                                <td><img class="delete"  src="/images/del_row.png" style="cursor:pointer;width:20px; height: 20px;" alt="Удалить строку" title="Удалить строку" /></td>
                                </tr>';
                            }
                        ?>
                        <tr class="lastDoc">
                            <td colspan="3"><span style="cursor:pointer;" id="AddDocString">Добавить строку</span></td>
                        </tr>
                    </table>
                <?php
                if(User::is_login()){
                    echo '<fieldset>
                        <legend>Выбор накладной</legend>
                        <select name="id_packing" class="invoice_packing_list">
                        <option selected value="0">Новая накладная</option>';
                    $packing_list=db::select2array('ac_packing_list','user_id='.User::id());
                    foreach($packing_list as $val){
                        echo '<option'.(!empty($_GET['id_packing'])&&($val['id']==$_GET['id_packing'])?' selected ':'').' value="'.$val['id'].'">'.$val['number'].'</option>';
                    }
                    echo '</select></fieldset>';
                }
                ?>
                <div id="invoice_form">
            <?php
                include_once 'form.php';
            ?>
                </div>
            <?php
            if(User::is_login())
                echo '<input type="submit" onclick="save_invoice();return false;" class="btn green" value="Сохранить">';
                echo '<input type="submit" onclick="save_list();return false;" class="btn green" value="Сохранить накладную">';
            ?>
            <input type="submit" onclick="save_comp();" class="btn green" value='Печать'>
            </form>
        </div>
    </div>



    <script>
        jQuery(document).ready(function() {
            jQuery("#AddDocString").bind("click", add_doc_row);
            jQuery("select.invoice_packing_list").change(formload);
        });
        function add_doc_row() {

            var lr = $("tr.lastDoc");
            var s='<tr>'+
                '<td><input type="number" name="doc_num[]"></td>' +
                '<td><input type="text" name="doc_date[]" class="date"></td>' +
                '<td><img class="delete"  src="/images/del_row.png" style="cursor:pointer;width:20px; height: 20px;" alt="Удалить строку" title="Удалить строку" /></td>' +
                '</tr>';
            var new_row = $(s);
            lr.before(new_row);
            jQuery(".date").mask("99.99.9999");
        }

        function formload(){
            jQuery.ajax({
                type:'POST',
                url:'form.php',
                data:{'id_packing':this.value},
                success(data){
                    jQuery('#invoice_form').html(data);
                }
            });
        }

        function save_invoice() {
            var msg   = jQuery('#form_packing').serialize();
            jQuery.ajax({
                type: 'POST',
                url: 'ajax/save_invoice.php',
                data: msg
            }).done(function(data){
                var res;
                if(res = JSON.parse(data)) alert(res.msg)
                else alert("Проверьте правильность введенных данных");
            });
        }
    </script>



<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/include/tail.php' ?>