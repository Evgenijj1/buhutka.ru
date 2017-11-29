<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/common-utf8/class/db.php";
echo json_encode(db::select('ac_countries','code='.$_POST['code']));