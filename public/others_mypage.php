<?php

//セッション開始
session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';


// //アクセス制限
// $referer = $_SERVER['HTTP_REFERER'];
// $url = "allpost.php";
// $url2 = "others_mypage";
// if(!strstr($referer, $url2)) {
//     if (!strstr($referer, $url)) {
//         header("Location: mypage.php");
//         exit;
//     }
// } else {

// }


//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "allpost.php";
$url2 = "others_mypage.php";
$url3 = "others_coffee.php";
$url4 = "gooduser_list.php";
if (strstr($referer, $url) || strstr($referer, $url2) || strstr($referer, $url3) || strstr($referer, $url4)) {
} else {
    header("Location: mypage.php");
    exit;
}


//GETで送ったuser_idを受け取り変数に格納
$user_id = $_GET['user_id'];



//$user_idに紐づくuser_name,commentを取得
$contributor = UserLogic::getUserId($user_id);


//投稿数取得
$countUserId = UserLogic::countUserId($user_id);
$countUserId = $countUserId["count(user_id=$user_id or null)"];


//ページネーション用準備
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$coffees = UserLogic::othersUserFindAll($page, $user_id);
$coffees_count = UserLogic::countOthersAll($user_id);
$params = [
    'coffees' => $coffees,
    'pages' => $coffees_count / 3
];

?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>マイページ</title>
</head>

<body>

    <?php include('header2.html') ?>

    <div class="main_wrapper">
        <div class="user_wrapper">
            <div class="urse_container">
                <div class="coffee_inf">
                    <p class="coffee_count">Coffee so for...</p>
                    <p class="coffee_number"><span style="font-size: 30px;"><?php echo $countUserId; ?></span>　Cups</p>
                </div>
                <div class="account_inf">
                    <h4>【 アカウント情報 】</h3>
                        <p>ユーザーネーム:<?php echo h($contributor['name']); ?></p>
                        
                        <p>コ　メ　ン　ト:</p>
                        <p><?php echo h($contributor['comment']); ?></p>
                        
                </div>
            </div>

            <div class="main_container">
                <div class="main_title_wrapper">
                    <div class="main_content_title">
                        <h2>Welcome　to...</h2>
                        <p class=>　<?php echo h($contributor['name']); ?>さんのCupboard</p>
                        <!-- post.php-->
                    </div>

                </div>
                <div>

                    <div class="main_content_wrapper">
                        <div class="main_content">
                            <?php foreach ($params['coffees'] as $column) : ?>

                                <div class="main_item">
                                    <img src="../img/takeout_cup.png" alt="カップ画像" width="200">
                                    <div style="margin-right: 20px" ;>
                                        <ul>
                                            <li>名前：<?php echo h($column['name']) ?></li>
                                            <li>場所：<?php echo h($column['place']) ?></li>
                                            <li>総合評価：<div class="rating">
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
                                            </li>
                                            <li>投稿日：<?php echo h($column['created_at']); ?></li>
                                        </ul>
                                        <p><a href="./others_coffee.php?id=<?php echo h($column['id']); ?>">詳細</a></p>

                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class='paging'>
        <?php
        for ($i = 0; $i <= $params['pages']; $i++) {
            if (isset($_GET['page']) && $_GET['page'] == $i) {
                echo $i + 1;
            } else {
                echo "<a  href='?user_id=".$user_id."&page=" . $i . "'>" . ($i + 1) . "</a>" . " ";
            }
        }
        ?>
    </div>


    <?php include('footer.html') ?>

</body>

</html>