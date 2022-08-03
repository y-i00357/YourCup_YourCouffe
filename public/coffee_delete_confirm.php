<?php

//セッション開始
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url = "coffee.php";
if (!strstr($referer, $url)) {
    header("Location: mypage.php");
    exit;
}

$id = $_GET['id'];

$login_user = $_SESSION['login_user'];

//値の判定
if (empty($id)) {
    exit("存在しない不正なIDです。");
}

//idをもとにデータベースから珈琲メモの情報を取得
$result = UserLogic::getId($id);

//値の判定
if (!$result) {
    exit("珈琲メモがありません。");
}


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>珈琲メモ削除ページ</title>
</head>

<body>

    <?php include('header2.html') ?>

    <div class="post_wrapper">

        <div class="check_title">
            <h4 class=><?php echo h($login_user['name']); ?>さんのCupboard</h4>
            <p>投稿日時：<?php echo h($result['created_at']); ?></p>
        </div>

        <div class="post_form">


            <form class="post_form" action="post_confirm.php" method="post" enctype="multipart/form-data">

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

                <p style="color: red; font-size: 1.2rem;">この珈琲メモを削除してよろしいでしょうか？</p>

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
                                <input type="hidden" name="rating" value="<?php echo h($evaluation); ?>">
                            </div>
                        </section>

                        <div class="form_item">
                            <p>名　称　：
                                <input type="hidden" name="c_name" value="<?php echo h($result['name']); ?>"><?php echo h($result['name']); ?>
                            </p>
                            <p>購入店　：
                                <input type="hidden" name="place" value="<?php echo h($result["place"]); ?>"><?php echo h($result['place']); ?>
                            </p>
                            <p>価　格　：
                                <input type="hidden" name="price" value="<?php echo h($result["price"]); ?>"><?php echo h($result["price"]); ?>
                            </p>


                            <p>生産地　：
                                <input type="hidden" name="origin" value="<?php echo h($result["origin"]); ?>"><?php echo h($result["origin"]); ?>
                            </p>
                            <p>品　種　：
                                <input type="hidden" name="variety" value="<?php echo h($result["variety"]); ?>"><?php echo h($result["variety"]); ?>
                            </p>
                            <p>抽出方法：
                                <input type="hidden" name="brew" value="<?php echo h($result["brew"]); ?>"><?php echo h($result["brew"]); ?>
                            </p>
                            <p>焙　煎　：
                                <input type="hidden" name="roast" value="<?php echo h($result["roast"]); ?>"><?php echo h($result["roast"]);; ?>
                            </p>
                            <!--公開/非公開設定-->
                            <input type="hidden" name="publish_status" value="<?php echo h($result["publish_status"]); ?>">
                            <?php if ($result['publish_status'] == "1") {
                                echo "公開設定：";
                            } elseif ($result['publish_status']) {
                                echo "未公開設定";
                            } else {
                                echo "数値が正しくありません。";
                            }
                            ?>
                        </div>
                    </div>

                </div>

                <div class="post_comment">
                    <p>コメント</p>
                    <p class="comment"><?php echo h($result['comment']); ?></p>
                </div>
            </form>

            <div class="btn_speace">
                <p class="btn_edit"><a href="#" onclick="history.back(); return false;">戻　る</a></p>

                <p class="btn_delete"><a class="delete_btn" href="coffee_delete.php?id=<?= $result['id'] ?>" onclick="return confirm('本当に削除しますか？')">削　除</a></p>
            </div>

        </div>

    </div>

    <?php include('footer.html') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>