<?
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
//(User::is_login()?'Дорегистрация':'Регистрация');
if(!User::is_login()) header("Location: http://".SERVER_NAME."/user/login.php");
$h1=$title='Журнал';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/head.php';
?>
<link rel="stylesheet" href="../user/style.css" type="text/css">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" xmlns="http://www.w3.org/1999/html"
        xmlns="http://www.w3.org/1999/html"></script>
<script type="text/javascript" src="//htmlweb.ru/geo/api.js" async="true"></script>
<script type="text/javascript" src="../test/js.js" async></script>
    <div class="container clearfix">
<h1>Журнал документов</h1>
        <table width="1200px">
            <tr>
                <td style="text-align:center;border-bottom: solid 1px #000000" width="30%"><a href="packing.php" class="btn green">Создать накладную</a></td>
                <td style="text-align:center;border-bottom: solid 1px #000000" width="30%"><a href="invoice.php" class="btn green">Создать счет-фактуру</a></td>
                <td style="text-align:center;border-bottom: solid 1px #000000" width="30%"><a href="act.php" class="btn green">Создать акт услуг</a></td>
            </tr>
        </table>
        <?php
            $add_sql="(Select P.id as id, 'packing' as path, 'Товарная накладная' as document, P.number as number, P.date0 as date0, C.shortName as company, T.shortName as client, sum(I.price*I.number) as summ FROM ac_company C inner join (select * from ac_packing_list where user_id=".User::id().") P on C.id=P.id_company inner join ac_company T on T.id=P.id_client join ac_item I on P.id=I.id_packing_list GROUP BY P.id
            UNION
            Select S.id as id, 'invoice' as path, 'Счет-фактура' as document, S.number as number, S.date0 as date0, C.shortName as company, T.shortName as client, sum(I.price*I.number) as summ FROM ac_invoice S inner join (select * from ac_packing_list where user_id=".User::id().") P on S.id_packing=P.id inner join ac_company C on C.id=P.id_company inner join ac_company T on T.id=P.id_client join ac_item I on P.id=I.id_packing_list GROUP BY P.id
            UNION
            Select A.id as id, 'act' as path, 'Акт услуг' as document, A.number as number, A.date0 as date0, C.shortName as company, T.shortName as client, sum(S.price*S.number) as summ FROM (select * from ac_act where user_id=".User::id().") A inner join ac_company C on C.id=A.id_company inner join ac_company T on T.id=A.id_client join ac_service S on A.id=S.id_act GROUP BY A.id
            ORDER BY date0 desc ) D";
            $bar = new kdg_bar(array('perpage' => 10, 'tbl' =>$add_sql));
        print_r(addslashes($bar->sql));
        ?>
        <table width="1200px">
            <tr>
                <td><?=$bar->out()?></td>
                <td style="text-align: right;">
                        <form class="q" onsubmit="Search(this.q);return false;">
                        <input type="text" autocomplete="off" name="q" onblur="Search(this)" value="<?= (empty($_REQUEST['q']) ? '' : $_REQUEST['q']) ?>" placeholder="строка для поиска">
                        <input type="submit" value=""></form>
                </td>
            </tr>
        </table>
<table width="1200px" class="client-table">
    <tr>
        <th style="text-align: center;width: 160px;" onclick="Order('document')">Документ <?=(!empty($_GET['ord'])?$_GET['ord']=='document'?(!isset($_GET['desc'])?'&darr;':'&uarr;'):'':'')?></th>
        <th style="text-align: center;width: 60px;" onclick="Order('number')">№  <?=(!empty($_GET['ord'])?$_GET['ord']=='number'?(!isset($_GET['desc'])?'&darr;':'&uarr;'):'':'')?></th>
        <th style="text-align: center;width: 100px;" onclick="Order('date0')">Дата  <?=(!empty($_GET['ord'])?$_GET['ord']=='date0'?(!isset($_GET['desc'])?'&darr;':'&uarr;'):'':'&uarr;')?></th>
        <th style="text-align: center;width: 250px;" onclick="Order('company')">Продавец  <?=(!empty($_GET['ord'])?$_GET['ord']=='company'?(!isset($_GET['desc'])?'&darr;':'&uarr;'):'':'')?></th>
        <th style="text-align: center;width: 250px;" onclick="Order('client')">Покупатель  <?=(!empty($_GET['ord'])?$_GET['ord']=='client'?(!isset($_GET['desc'])?'&darr;':'&uarr;'):'':'')?></th>
        <th style="text-align: center;width: 135px;" onclick="Order('summ')">Сумма  <?=(!empty($_GET['ord'])?$_GET['ord']=='summ'?(!isset($_GET['desc'])?'&darr;':'&uarr;'):'':'')?></th>
    </tr>
    <?php
        $str='';
    if (!empty($bar->q)){
        if(strpos($bar->q,',')==false) {
            $bar->sql = ' WHERE LOWER(document) LIKE "%' . mb_strtolower(addslashes($bar->q),'utf-8') . '%"
                        or LOWER(company) LIKE "%' . mb_strtolower(addslashes($bar->q),'utf-8') . '%"
                        or LOWER(client) LIKE "%' . mb_strtolower(addslashes($bar->q),'utf-8') . '%"
                        ' . (intval($bar->q) > 0 ? ' or summ="' . intval($bar->q) . '"'.' or number="' . intval($bar->q) . '"' : '');
        }
    }
    $query = $bar->query();
    while ($data = DB::fetch_assoc($query)){
        $tbl=$data['path']=='packing'?'ac_packing_list':'ac_'.$data['path'];
        $str.='
                <tr id="id'. $data['id'].$data['path'] . '" style="border-top:#9fbddd 1px solid;" onmouseout="removeClass(this, \'row_over\');" onmouseover="addClass(this, \'row_over\');" ontouchstart="addClass(this, \'row_over\');">
                    <td style="font-size: 14px;text-align:left;">'.$data['document'].'</td>
                    <td style="font-size: 14px;">'.$data['number'].'</td>
                    <td style="font-size: 14px;">'.date('d.m.Y',strtotime($data['date0'])).'</td>
                    <td style="font-size: 14px;width:250px;text-align:left;"><div style="width:250px;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;">'.$data['company'].'</div></td>
                    <td style="font-size: 14px; width:250px;text-align:left;"><div style="width:250px;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;">'.$data['client'].'</div></td>
                    <td style="text-align: right;font-size: 14px;">'.number_format($data['summ']/100000,2,'.',' ').' <span class="rur">р.</span></td>
                    <td class="edit-del">
                        <a href="'.$data['path'].'.php?id_'.$data['path'].'='.$data['id'].'"><img class="edit"  src="/images/edit.png" style="cursor:pointer;width:20px; height: 20px;" alt="Редактировать документ" title="Редактировать документ" /></a>
                    </td>
                    <td class="edit-del">
	                    <a href="/api.php?tbl=' . $tbl . '&del=' . $data['id'] . '&path='.$data['path'].'" class="icon del confirm" style="margin-right: 0" title="Удалить"></a>
                    </td>
                </tr>';
    }
        echo $str?$str."</table>":'</table>Пустой журнал';
    ?>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery('.delete').click(function(){
            if(confirm('Вы уверены, что хотите удалить документ?')) {
                var _this = this;
                jQuery.ajax({
                    type: 'POST',
                    url: 'ajax/del_data.php',
                    data: 'type=' + jQuery('input.doc_type', jQuery(this).parents("td").get(0)).val() + '&id_name=' + jQuery('input.id_name', jQuery(this).parents("td").get(0)).val(),
                    dataType: 'json',
                    success(data)
                {
                    if (data.status == 200) {
                        jQuery(_this).parents("tr").get(0).remove();
                    } else {
                        alert(data.msg);
                    }

                }
            }
            )
            ;
        }
        });
    });
</script>
<?
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/tail.php' ?>