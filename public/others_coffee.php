<?php

//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "allpost.php";
$url2 = "others_mypage.php";
$url3 = "favorite.php";
$url4 = "others_coffee.php";
if (strstr($referer, $url) || strstr($referer, $url2) || strstr($referer, $url3) || strstr($referer, $url4)) {
} else {
    header("Location: mypage.php");
    exit;
}


$id = $_GET['id'];

//値の判定
if (empty($id)) {
    exit("存在しない不正なIDです。");
}

//idをもとにデータベースから珈琲メモの情報を取得
$result = UserLogic::getId($id);

$user_id = $result['user_id'];

//user_idからユーザー情報取得する
$contributor = UserLogic::getUserId($user_id);

//値の判定
if (!$result) {
    exit("珈琲メモがありません。");
}


//いいね！の件数取得
$goodcount = UserLogic::countGoodC($id);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <title>珈琲詳細ページ</title>
</head>

<body>

    <?php include('header2.html') ?>

    <div class="post_wrapper">

        <div class="check_title">
            <h4 class=><?php echo h($contributor['name']);
                        ?>さんのCupboard</h4>

            <p><a style="color: dimgrey;" href="./others_mypage.php?user_id=<?php echo h($user_id);
                                                                            ?>">メインページはこちら！</a></p>
        </div>

        <div class="post_form">


            <form class="post_form" action="post_confirm.php" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">

                <div class="post_container">


                    <div class="img_container2">

                        <img src="../images/<?php if (!empty($result['image'])) {
                                                echo h($result['image']);
                                            } else {
                                                echo 'takeout_cup.png';
                                            }
                                            ?>" alt="投稿画像" style="width: 200px">

                        <input type="hidden" name="image" value="<?php echo h($result['image']); ?>">
                        <p>-イメージ表示-</p>



                    </div>

                    <div class="c_memo_container">

                        <p>総合評価</p>
                        <section>
                            <style>
                                .rating span {
                                    color: #ffbb00;
                                    font-size: 30px;
                                }
                            </style>
                            <div class="rating">
                                <?php echo "<div>";
                                $r = $result['evaluation'];
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
                        </section>

                        <div class="form_item">
                            <p>名　称　:
                                <?php echo h($result['name']); ?>
                            </p>
                            <p>購入店　:
                                <?php echo h($result['place']); ?>
                            </p>
                            <p>価　格　:
                                <?php echo h($result['price']); ?>
                            </p>


                            <p>生産地　:
                                <?php echo h($result['origin']); ?>
                            </p>
                            <p>品　種　:
                                <?php echo h($result['variety']); ?>
                            </p>
                            <p>抽出方法：
                                <?php echo h($result['brew']); ?>
                            </p>
                            <p>焙　煎　:
                                <?php echo h($result['roast']); ?>
                            </p>
                            <p>投稿日時：<?php echo h($result['created_at']); ?></p>


                            <!--いいね機能-->
                            <form class="favorite_comment" action="favorite.php" method="post">
                                <input type="hidden" name="post_id">
                                <button style="border-style: none;" type="button" name="favorite" class="favorite_comment" data-post_id="<?php echo $id ?>" data-c_id="<?php echo $_SESSION['login_user']['id'] ?>">
                                    <?php if (!UserLogic::check_favolite_duplicate($_SESSION['login_user']['id'], $id)) : ?>
                                        いいね！するには下記ボタンをクリック！
                                    <?php else : ?>
                                        いいね解除は下記ボタンクリック
                                    <?php endif; ?>
                                </button>
                            </form>
                                <div class="good_container">
                                    
                                    <form class="favorite_count" action="favorite.php" method="post">
                                        <input type="hidden" name="post_id" value="<?php echo $id;?>">
                                        <button  type="submit" name="favorite" class="favorite_btn" >
                                            <?php if (!UserLogic::check_favolite_duplicate($_SESSION['login_user']['id'], $id)) : ?>
                                                Good!!
                                            <?php else : ?>
                                                Thank You!!
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                    
                                    <p style="margin-left: 15px;">♥<?php echo $goodcount["count(coffee_id=$id or null)"] ?></p>
                                </div>



                        </div>
                    </div>

                </div>

                <div class="post_comment">
                    <p>コメント</p>
                    <p class="comment"><?php echo nl2br($result['comment']); ?></p>
                </div>
            </form>

            <a style="color: white; background-color: darkgray; padding: 3px 70px; opacity: 0.8; border-radius: 4px;" class="back_btn" href="#" onclick="history.back(); return false;">戻　る</a>

        </div>

    </div>

    <?php include('footer.html') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/good.js"></script>
</body>

</html>