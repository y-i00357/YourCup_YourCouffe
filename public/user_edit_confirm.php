<?php


//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "user_edit.php";
if (!strstr($referer, $url)) {
    header("Location: mypage.php");
    exit;
}

$name = $_POST['name'];
$mail = $_POST['mail'];
$comment = $_POST['comment'];
$id = $_POST['id'];


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報編集確認ページ</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php include('header2.html') ?>

    <div class="edit_wrapper">

        <h2 class="edit_title">アカウント情報編集</h2>

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

            <a style="color: white; background-color: #238236; padding: 6px 60px; opacity: 0.8; border-radius: 4px;" class="back_btn" href="#" onclick="history.back(); return false;">戻　る</a>

            <input type="submit" class="user_edit" name="user_edit" value="登　録">

        </form>



    </div>

    <?php include('footer.html') ?>

</body>

</html>