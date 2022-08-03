<?php

//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';


$id = $_GET['id'];



$name = $_SESSION['login_user']['name'];
$mail = $_SESSION['login_user']['mail'];
$comment = $_SESSION['login_user']['comment'];
$id = $_SESSION['login_user']['id'];


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント削除確認ページ</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php include('header2.html') ?>

    <div class="edit_wrapper">

        <h2 class="edit_title">アカウント削除</h2>

        <h3 style="color: red; margin-bottom: 30px;">本当に削除してよろしいですか？</h3>

        <form action="mypage.php" method="post">
            
            <div class="edit_container">

            <input type="hidden" name="id" value="<?php echo (int)$id;?>">
    
                <div class="edit_item">
                    <h4>ユーザーネーム</h4>
                    <input type="hidden" name="name" style="width: 300px; height: 40px" value="<?php echo h($name);?>">
                    <?php echo "<p>".h($name)."</p>";?>
                </div>
    
                <div class="edit_item">
                    <h4>メールアドレス</h4>
                    <input type="hidden" name="mail" style="width: 300px; height: 40px" value="<?php echo h($mail);?>">
                    <?php echo "<p>".h($mail)."</p>";?>
                </div>
    
                <div class="edit_item">
                    <h4>コメント</h4>
                    <input type="hidden" name="comment" value="<?php echo h($comment);?>">
                    <?php echo "<p>".h($comment)."</p>";?>
                </div>
    
            </div>

            <div class="btn_speace">

                <p><a style="color: white; background-color: #238236; margin-right: 50px; opacity: 0.8; border-radius: 4px;" class="back_btn" href="#" onclick="history.back(); return false;">戻　る</a></p>
    
                <p class="btn_delete"><a class="delete_btn" href="user_delete_complete.php?id=<?= $id ?>" onclick="return confirm('本当に削除しますか？')">削　除</a></p>

            </div>


        </form>



    </div>

    <?php include('footer.html') ?>

</body>

</html>