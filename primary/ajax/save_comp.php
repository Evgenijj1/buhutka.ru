<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/common-utf8/class/db.php";
$e='_comp';
$val1=['shortName'=>$_POST['shortName'.$e],'fullName'=>$_POST['fullName'.$e],'INN'=>$_POST['INN'.$e],'kpp'=>$_POST['kpp'.$e],'ogrn'=>$_POST['ogrn'.$e],'OKPO'=>$_POST['okpo'.$e],'address'=>$_POST['address'.$e]];
$val1['chiefName']=$_POST['chiefName'.$e];
$val1['accountant']=$_POST['accountant'.$e];
$val1['tel']=$_POST['tel'.$e];
$val1['rs']=$_POST['rs'.$e];
$val1['user_id']=User::id();

if(!empty($_POST['BIC'.$e]))
    $val2=['BIC'=>$_POST['BIC'.$e],'name'=>$_POST['name_bank'.$e],'city'=>$_POST['city_bank'.$e],'adress'=>$_POST['adress_bank'.$e],'ks'=>$_POST['ks_bank'.$e]];
if($id=db::SelectId('ac_company','INN='.$_POST['INN'.$e])) {
    db::update('ac_company',$val1,'id='.$id);
}else{
    DB::write_array('ac_company', $val1);
}

if(!empty($_POST['BIC'.$e]))
    if($bank=db::SelectId('ac_bank','BIC='.$_POST['BIC'.$e])){
        db::update('ac_bank',$val2,'id='.$bank);
    }else{
        DB::write_array('ac_bank', $val2);
    }
$answer=['status'=>200,'msg'=>"Сохранение прошло успешно."];
echo json_encode($answer);