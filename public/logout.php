<?php 

session_start();

require_once '../classes/UserLogic.php';

if(!$logout = filter_input(INPUT_POST, 'logout'))
{
    exit('不正リクエストです。');
}

//ログイン判定
//セッションが切れていたらログインをするようにメッセージする。
$result = UserLogic::checkLogin();


//セッションが切れていた時はトップページに遷移
if (!$result) {
    header('Location: index.php');
    return;
}

//ログアウト処理
UserLogic::logout();

?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ログアウト</title>
</head>
<body>

 <?php include('header1.html') ?>

 <div class="logout_wrapper">
    <div class="logout_title">
        <h3>ログアウトしました。</h3>
        <p>またのご利用をお待ちしております。</p>
        <p><br></p>

        
        <a href="index.php">トップページへ！</a>
    </div>
    
 </div>


 <?php include('footer.html') ?>
 <style>
    footer {
        margin: 0;
    }
 </style>

</body>
</html>