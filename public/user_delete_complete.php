<?php

//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "user_delete.php";
if (!strstr($referer, $url)) {
    header("Location: user_edit.php");
    exit;
}

$id = $_GET['id'];

//idをもとにデータベースからアカウント（ユーザー）情報を削除
$result = UserLogic::deleteUser($id);

if($result) {
    header("Location: index.php");
}


?>