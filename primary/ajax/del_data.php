<?php
if(!empty($_POST['type'])){
    include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/include/common-utf8/class/db.php";
    if($_POST['type']=='inv'){
        db::delete('ac_invoice','id='.$_POST['id_name']);
    }elseif($_POST['type']=='act'){
        db::delete('ac_service','id_act='.$_POST['id_name']);
        db::delete('ac_act','id='.$_POST['id_name']);
    }elseif($_POST['type']=='pack'){
        db::delete('ac_item','id_packing_list='.$_POST['id_name']);
        db::delete('ac_packing_list','id='.$_POST['id_name']);
    }

    $answer=['status'=>200,'msg'=>"Сохранение прошло успешно."];
    echo json_encode($answer);

}else{
    $answer=['status'=>0,'msg'=>"Ошибка в удалении."];
    echo json_encode($answer);
}