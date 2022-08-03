<?php

//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "coffee_delete_confirm.php";
if (!strstr($referer, $url)) {
    header("Location: coffee.php");
    exit;
}

$id = $_GET['id'];

$login_user = $_SESSION['login_user'];


//idをもとにデータベースから珈琲メモの情報を削除
$result = UserLogic::delete($id);

if($result) {
    header("Location: mypage.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除</title>
</head>
<body>
    <p>削除完了テスト</p>
</body>
</html>