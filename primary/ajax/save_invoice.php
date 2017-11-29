<?php
include_once "save_list.php";
if(empty($_POST['number_fact']) || empty($_POST['date_fact'])){
    $answer=['status'=>0,'msg'=>"Проверьте правильность заполения номера и даты счета-фактуры!"];
    echo json_encode($answer);
    exit;
}

if(!$id_packing=db::selectId('ac_packing_list','number='.$_POST['number'].' and user_id='.User::id())){

    $answer=['status'=>0,'msg'=>"Накладной с таким номером не существует!"];
    echo json_encode($answer);
    exit;
}
$arr=['id_packing'=>$id_packing,
    'number'=>$_POST['number_fact'],
    'date0'=>date('Y-m-d',strtotime($_POST['date_fact'])),
    'number_correction'=>($_POST['edit']=='Yes'?$_POST['number_fact_edit']:NULL),
    'date_correction'=>($_POST['edit']=='Yes'?$_POST['date_fact_edit']:NULL),
    'avans'=>($_POST['avans']=='No'?'0':'1')];
if(db::select('ac_invoice','id_packing='.$id_packing)){
    db::update('ac_invoice',$arr,'id_packing='.$id_packing);
}else {
    db::insert('ac_invoice', $arr);
}

if(!$id_invoice=db::selectId('ac_invoice','id_packing='.$id_packing)){
    $answer=['status'=>0,'msg'=>"Произошла проблема в сохранении счета-фактуры!"];
    echo json_encode($answer);
    exit;
}
foreach($_POST['doc_num'] as $key=>$val){
    if($val!='' and $_POST['doc_date'][$key]!=''){
        if(db::select('ac_documents','invoice_id='.$id_invoice.' and number='.$val))
            db::write_array('ac_documents', ['invoice_id' => $id_invoice, 'number' => $val, 'date0' => $_POST['doc_date'][$key]]);
        else
            db::update('ac_documents',['date0'=>$_POST['doc_date'][$key]],'invoice_id='.$id_invoice.' and number='.$val);
    }
}

$answer=['status'=>200,'msg'=>"Сохранение прошло успешно."];
echo json_encode($answer);