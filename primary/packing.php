<?
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
//(User::is_login()?'Дорегистрация':'Регистрация');
$h1=$title='Расходная накладная';
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
        echo '<form name="anketa" id="form_packing" method="post" target="_blank" action="../primary/php2pdf/php2pdf.php">';
        include_once 'form.php';
        ?>
        <?php
        if(User::is_login())
            echo '<input type="submit" onclick="save_list();return false;" class="btn green" value="Сохранить'.(!empty($packing)?' изменения':'').'">';
        ?>
        <input type="submit" onclick="save_comp();" class="btn green" value='Печать'>
        <button onclick="save_comp();" class="btn green" formaction="php2pdf/php2pdf_invoice.php">Печать счета</button>
        <button onclick="save_comp();" class="btn green" formaction="php2pdf/php2pdf_tovar.php">Печать товарного чека</button>
        </form>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/include/tail.php' ?>