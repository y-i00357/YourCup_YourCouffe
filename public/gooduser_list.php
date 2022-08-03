<?php

session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限

//coffee_idからgoodしたユーザーのidを取得
//user_idに紐づいたユーザー情報を制限して取得（ユーザーネームのみで大丈夫）
$id = $_GET['id']; //coffee_id

$gooduser = UserLogic::getGoodUser($id);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style2.css">
    <title>いいね！したユーザー一覧</title>
</head>

<body>

    <?php include('header2.html') ?>

    <div class="gooduser_wrapper">

    
        <div class="gooduserlist_title">
            <h3 style="margin-bottom: 15px;">いいね！したユーザー一覧</h3>

            <a style="color: darkgray; opacity: 0.8; border-bottom: 3px;" class="back_btn" href="#" onclick="history.back(); return false;">　珈琲メモの詳細に戻る</a>
        </div>
        <?php foreach ($gooduser as $column) : ?>

        <div class="gooduserlist">
            <img style="width: 100px;" src="../img/46474.png" alt="ユーザーシルエット">
            <p class="ggg" style="font-weight: 600;">◇ユーザーネーム◇<br><a style="color: #12521f;;" href="others_mypage.php?user_id=<?php echo h($column['user_id']) ?>"><?php echo h($column['user_name']) ?></a></p>
        </div>

        <?php endforeach; ?>
    </div>

    <?php include('footer.html') ?>

</body>

</html>