<?php

//セッション開始
session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';


//ログイン判定
//していなかったら新規登録画面に戻す
$result = UserLogic::checkLogin();

if (!$result) {
    $_SESSION['login_err'] = "<span style='color:red;'>ユーザー登録、またはログインしてください。</span>";
    header('Location: signup.php');
    return;
}


//ユーザー情報
$login_user = $_SESSION['login_user'];
$user_id = $login_user["id"];

// //全データ取得
// $result = UserLogic::getAll();


//ページネーション用準備
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$coffees = UserLogic::allPostfindAll($page);
$coffees_count = UserLogic::countOthersAll($user_id);
$params = [
    'coffees' => $coffees,
    'pages' => $coffees_count / 5
];


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style2.css">
    <title>投稿一覧</title>
</head>

<body>

    <?php include('header2.html') ?>


    <div class="allpost_wrapper">
        <h1 class="allpost_title" style="margin-left: 8%;">Everyone's　Cup!!</h3>

            <div class="allpost_container">

                <!--foreach記述-->
                <?php foreach ($params['coffees'] as $column) : ?>
                    <div class="allpost_content"  style="margin-top: 20px;">

                        <a class="allpost_img" href="/others_coffee.php?id=<?php echo h($column['id']) ?>"><img src="../img/takeout_cup.png" alt="カップ画像" width="200"></a>

                        <div class="post_info">
                            <ul>
                                <li>　</li>
                                <li>ユーザーネーム：<a class="allpost_username" href="others_mypage.php?user_id=<?php echo h($column['user_id']) ?>"><?php echo h($column['user_name']) ?></a></li>
                                <li>珈琲名称：<?php echo h($column['name']) ?></li>
                                <li>購入店：<?php echo h($column['place']) ?></li>
                                <li>総合評価：</li>
                                <div class="rating">
                                    <style>
                                        .rating span {
                                            color: #ffbb00;
                                        }
                                    </style>
                                    <?php echo "<div>";
                                    $r = h($column['evaluation']);
                                    for ($j = 0; $j < 5; $j++) {
                                        if ($j < $r) {
                                            echo "<span>&#9733</span>";
                                        } else {
                                            echo "<span>&#9734</span>";
                                        }
                                    }
                                    echo "</div>";
                                    ?>
                                </div>
                                <li>日付：<?php echo h($column['created_at']) ?></li>
                                <li><a class="detail" href="./others_coffee.php?id=<?php echo h($column['id']) ?>">詳細</a></li>
                            </ul>


                        </div>


                    </div>

                <?php endforeach; ?>
            </div>

            <div class='paging'>
                <?php
                for ($i = 0; $i <= $params['pages']; $i++) {
                    if (isset($_GET['page']) && $_GET['page'] == $i) {
                        echo $i + 1;
                    } else {
                        echo "<a  href='?page=" . $i . "'>" . ($i + 1) . "</a>" . " ";
                    }
                }
                ?>
            </div>


    </div>

    <?php include('footer.html') ?>

</body>

</html>