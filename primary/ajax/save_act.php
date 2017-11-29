<?php
include_once "res.php";

$id_company=db::SelectId('ac_company','INN='.$_POST['INN_comp']);


if(empty($_POST['list'])) {
    if (db::SelectId('ac_act', 'id_company=' . $id_company . ' and number=' . $_POST['number'])) {
        $answer = ['status' => 0, 'msg' => "Договор с таким номером уже существует! Измените номер договора."];
        echo json_encode($answer);
        exit;
    }
}
if(empty($_POST['name_item'])){
    $answer = ['status' => 0, 'msg' => "Строки с товарами должны быть заполнены!"];
    echo json_encode($answer);
    exit;
}
if(empty($_POST['INN_comp'])||empty($_POST['INN_client'])){
    $answer = ['status' => 0, 'msg' => "Все поля должны быть заполнены!"];
    echo json_encode($answer);
    exit;
}

$id_client=db::SelectId('ac_company','INN='.$_POST['INN_client']);

$arr=['user_id'=>User::id(),'id_company'=>$id_company,'id_client'=>$id_client,
    'number'=>(!empty($_POST['number'])?$_POST['number']:1),'date0'=>(!empty($_POST['date'])?$_POST['date']:date('d.m.Y')),
    'comment'=>$_POST['comment'],'agent_company'=>$_POST['agent_comp'],'agent_client'=>$_POST['agent_client']];
if(!empty($_POST['list'])){
    db::update('ac_act',$arr,'id='.$_POST['list']);
    $id_act=$_POST['list'];
    db::Delete('ac_service','id_act='.$id_act);
}else{
    DB::insert('ac_act',$arr);
    $id_act=db::selectId('ac_act','id_company='.$arr['id_company'].' and number='.$arr['number']);
}
foreach($_POST['name_item'] as $k=>$v){
    $items=['id_act'=>$id_act,'name'=>$v,'unit'=>$_POST['ed_item'][$k],'number'=>(double)$_POST['kol_item'][$k]*1000,'price'=>(double)$_POST['price_item'][$k]*100,'NDS'=>$_POST['nds'][$k]];
    DB::insert('ac_service',$items);
}

$answer=['status'=>200,'msg'=>"Сохранение прошло успешно."];
echo json_encode($answer);