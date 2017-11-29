<?php
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: *");
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 600);
curl_setopt($ch, CURLOPT_URL, 'https://www.creditnet.ru/nkbrelation/api/company?inn='.$_GET['inn']);
$res = curl_exec($ch);
$result = json_decode($res,!0);
$info = curl_getinfo($ch);
curl_close($ch);
echo($res);