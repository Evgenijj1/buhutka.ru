<?php
include_once "res.php";
$id_company=db::SelectId('ac_company','INN='.$_POST['INN_comp']);


if(empty($_POST['list'])) {
    if (db::SelectId('ac_packing_list', 'id_company=' . $id_company . ' and number=' . $_POST['number'].' and user_id='.User::id())) {
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
$bank_company=db::SelectId('ac_bank','BIC='.$_POST['BIC_comp']);
$bank_client=db::SelectId('ac_bank','BIC='.$_POST['BIC_client']);
$consignee=$_POST['Consignee']=='Non'?db::SelectId('ac_company','INN='.$_POST['INN_consignee']):NULL;
$consignor=$_POST['Consignor']=='Non'?db::SelectId('ac_company','INN='.$_POST['INN_consignor']):NULL;
$bank_consignee=$_POST['Consignee']=='Non'?db::SelectId('ac_bank','BIC='.$_POST['BIC_consignee']):NULL;
$bank_consignor=$_POST['Consignee']=='Non'?db::SelectId('ac_bank','BIC='.$_POST['BIC_consignor']):NULL;
$arr=['user_id'=>User::id(),'id_company'=>$id_company,'id_client'=>$id_client,'bank_company'=>$bank_company,'bank_client'=>$bank_client,
'consignee'=>$consignee,'consignor'=>$consignor,'bank_consignee'=>$bank_consignee,'bank_consignor'=>$bank_consignor,
'number'=>(!empty($_POST['number'])?$_POST['number']:1),'date0'=>(!empty($_POST['date'])?date('Y-m-d',strtotime($_POST['date'])):date('Y-m-d')),
'base'=>$_POST['base']];
if($_SERVER['PHP_SELF']!='/primary/ajax/save_invoice.php') {
    $arr += ['allowed' => $_POST['allowed_comp'], 'allowed_position' => $_POST['allowed_position_comp'],
        'produced' => $_POST['produced_comp'], 'produced_position' => $_POST['produced_position_comp'],
        'accepted' => $_POST['accepted_client'], 'accepted_position' => $_POST['accepted_position_client'],
        'received' => $_POST['received_client'], 'received_position' => $_POST['received_position_client']];
    if($_POST['proxy']=='Yes')
        $arr+=['number_proxy'=>$_POST['number_proxy'],'date_proxy'=>date('Y-m-d',strtotime($_POST['date_proxy'])),
            'name_proxy'=>$_POST['name_proxy'],
            'position_proxy'=>$_POST['position_proxy'],'name_client_proxy'=>$_POST['name_client_proxy'],
            'position_client_proxy'=>$_POST['position_client_proxy']];
}
if(!empty($_POST['list'])){
    db::update('ac_packing_list',$arr,'id='.$_POST['list']);
    $id_packing=$_POST['list'];
    db::Delete('ac_item','id_packing_list='.$id_packing);
}else{
    DB::insert('ac_packing_list',$arr);
    $id_packing=db::selectId('ac_packing_list','id_company='.$arr['id_company'].' and number='.$arr['number']);
}
foreach($_POST['name_item'] as $k=>$v){
    $items=['id_packing_list'=>$id_packing,'name'=>$v,'unit'=>$_POST['ed_item'][$k],'number'=>(double)$_POST['kol_item'][$k]*1000,'price'=>(double)$_POST['price_item'][$k]*100,'NDS'=>$_POST['nds'][$k]];
    if(!empty($_POST['code'])) $items+=['country_code'=>$_POST['code'][$k],'country_name'=>$_POST['country'][$k],'custom'=>$_POST['custom'][$k]];
    DB::insert('ac_item',$items);
}
if($_SERVER['PHP_SELF']!='/primary/ajax/save_invoice.php'){
    $answer=['status'=>200,'msg'=>"Сохранение прошло успешно."];
    echo json_encode($answer);
}