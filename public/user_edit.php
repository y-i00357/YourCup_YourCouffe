<?php

//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "mypage.php";
if (!strstr($referer, $url)) {
    header("Location: mypage.php");
    exit;
}

$login_user = $_SESSION;

$id = $login_user['login_user']['id'];
$name = $login_user['login_user']['name'];
$mail = $login_user['login_user']['mail'];
$password = $login_user['login_user']['password'];
$comment = $login_user['login_user']['comment'];


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報編集ページ</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php include('header2.html') ?>

    <div class="edit_wrapper">

        <h2 class="edit_title">アカウント情報編集</h2>

        <form action="user_edit_confirm.php" method="POST">
            
            <div class="edit_container">

            <input type="hidden" name="id" value="<?php echo h($id);?>">
    
                <div class="edit_item">
                    <p>ユーザーネーム</p>
                    <input type="text" name="name" style="width: 300px; height: 40px" value="<?php echo h($name);?>">
                </div>
    
                <div class="edit_item">
                    <p>メールアドレス</p>
                    <input type="mail" name="mail" style="width: 300px; height: 40px" value="<?php echo h($mail);?>">
                </div>
    
                <div class="edit_item">
                    <p>コメント</p>
                    <textarea name="comment" style="padding: 10px;" id="" cols="70" rows="10"><?php echo h($comment);?></textarea>
                </div>
    
            </div>

            <input type="submit" class="user_edit" name="user_edit" value="確　認">

        </form>

        <p class="user_delete_link"><a href="user_delete.php?id=<?php echo h($id);?>">このアカウントを削除する。</a></p>


    </div>

    <?php include('footer.html') ?>

</body>

</html>