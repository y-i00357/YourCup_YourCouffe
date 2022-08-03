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

//IDから取得した情報を変数へ入れておく。
$id = $result["id"];
$name = $result["name"];
$evaluation = $result["evaluation"];
$place = $result["place"];
$price = $result["price"];
$origin = $result["origin"];
$variety = $result["variety"];
$brew = $result["brew"];
$roast = $result["roast"];
$image = $result["image"];
$comment = $result["comment"];
$publish_status = $result["publish_status"];


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>珈琲メモ編集ページ</title>
    <link rel="stylesheet" href="../css/style.css">


</head>

<body>

    <?php include('header2.html') ?>

    <div class="post_wrapper">

        <div class="post_title">
            <!-- 余白用 -->
        </div>




        <div class="post_form">


            <form class="post_form" action="coffee_update.php" method="post" enctype="multipart/form-data">




                <div class="post_container">

                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="img_container">


                        <h3 style="margin-bottom: 70px;">＋珈琲メモ編集ページ</h3>

                        <!--表示部分-->
                        <img src="../images/<?php if (!empty($image)) {
                                                echo $image;
                                            } else {
                                                echo 'takeout_cup.png';
                                            }
                                            ?>" alt="投稿画像" style="width: 200px">

                        <input type="hidden" name="MAX_FILE_SIZE" value="1048579">
                        <!--既存登録データ-->
                        <input type="hidden" name="image" id="" value="<?php echo $image; ?>">
                        <p style="font-size: 8px; color:darkgray">※未登録の場合はイメージ画像です。</p>
                        <!--新規登録部分-->
                        <p style="font-size: 15px; color:darkgray">- 新規画像登録の場合はこちら -</p>
                        <input type="file" name="image" id="" accept="image/*">

                    </div>

                    <div class="c_memo_container">
                        <p style="margin-bottom: 40px;">各項目を記入及び選択してください。<br><span style="color: red;">*</span>は必須項目となります。</p>


                        <p>総合評価<span style="color: red;">*</span></p>
                        <p>以前の評価は<?php echo $evaluation ?>でした。</p>
                        <section>
                            <div class="rating">
                                <input class="rating__input hidden--visually" type="radio" id="5-star" name="rating" value="5" required />
                                <label class="rating__label" for="5-star" title="星5つ"><span class="rating__icon" aria-hidden="true"></span><span class="hidden--visually">星5つ</span></label>
                                <input class="rating__input hidden--visually" type="radio" id="4-star" name="rating" value="4" />
                                <label class="rating__label" for="4-star" title="星4つ"><span class="rating__icon" aria-hidden="true"></span><span class="hidden--visually">星4つ</span></label>
                                <input class="rating__input hidden--visually" type="radio" id="3-star" name="rating" value="3" />
                                <label class="rating__label" for="3-star" title="星3つ"><span class="rating__icon" aria-hidden="true"></span><span class="hidden--visually">星3つ</label></span></label>
                                <input class="rating__input hidden--visually" type="radio" id="2-star" name="rating" value="2" />
                                <label class="rating__label" for="2-star" title="星2つ"><span class="rating__icon" aria-hidden="true"></span><span class="hidden--visually">星2つ</span></label>
                                <input class="rating__input hidden--visually" type="radio" id="1-star" name="rating" value="1" />
                                <label class="rating__label" for="1-star" title="星1つ"><span class="rating__icon" aria-hidden="true"></span><span class="hidden--visually">星1つ</span></label>
                            </div>
                        </section>

                        <div class="form_item">

                            <p>名　称<span style="color: red;">*</span>　：
                                <input type="text" name="name" id="" style="height: 30px;" value="<?php echo $name; ?>">
                            </p>
                            <p>購入店<span style="color: red;">*</span>　：
                                <input type="text" name="place" id="" style="height: 30px" value="<?php echo $place; ?>">
                            </p>
                            <p>価　格　：
                                <input type="number" min=0 name="price" id="" style="width: 143px; height: 30px" value="<?php echo $price; ?>">円
                            </p>


                            <p>生産地　：
                                <input type="text" name="origin" id="" style="height: 30px" value="<?php echo $origin; ?>">
                            </p>
                            <p>品　種　：
                                <input type="text" name="variety" id="" style="height: 30px" value="<?php echo $variety; ?>">
                            </p>
                            <p>抽出方法：
                                <select name="brew" id="" style="height: 30px">
                                    <option value="">抽出方法を選択してください。</option>
                                    <option value="ペーパードリップ" <?php if ($brew === "ペーパードリップ") echo "selected" ?>>ペーパードリップ</option>
                                    <option value="ネルドリップ" <?php if ($brew === "ネルドリップ") echo "selected" ?>>ネルドリップ</option>
                                    <option value="サイフォン" <?php if ($brew === "サイフォン") echo "selected" ?>>サイフォン</option>
                                    <option value="エスプレッソ" <?php if ($brew === "エスプレッソ") echo "selected" ?>>エスプレッソ</option>
                                    <option value="フレンチプレス" <?php if ($brew === "フレンチプレス") echo "selected" ?>>フレンチプレス</option>
                                    <option value="コールドブリュー" <?php if ($brew === "コールドブリュー") echo "selected" ?>>コールドブリュー</option>
                                    <option value="エアロプレス" <?php if ($brew === "エアロプレス") echo "selected" ?>>エアロプレス</option>
                                </select>
                            </p>
                            <p>焙　煎　：
                                <select name="roast" id="" style="height: 30px">
                                    <option value="">焙煎を選択してください。</option>
                                    <option value="浅煎り" <?php if ($roast === "浅煎り") echo "selected" ?>>浅煎り</option>
                                    <option value="中煎り" <?php if ($roast === "中煎り") echo "selected" ?>>中煎り</option>
                                    <option value="深煎り" <?php if ($roast === "深煎り") echo "selected" ?>>深煎り</option>
                                    <option value="その他" <?php if ($roast === "その他") echo "selected" ?>>その他</option>
                                </select>
                            </p>
                            <!--公開/非公開設定-->
                            <input type="radio" name="publish_status" id="" value="1" <?php if ($publish_status === 1) echo "checked" ?>>公開
                            <input type="radio" name="publish_status" id="" value="2" <?php if ($publish_status === 2) echo "checked" ?>>非公開
                        </div>
                    </div>

                </div>

                <div class="post_comment">
                    <p>コメント</p>
                    <textarea name="comment" id="" cols="85" rows="10" style="padding: 10px;"><?php echo $comment; ?></textarea>
                </div>

                <input class="chack_btn" style="width: 200px; height: 30px; margin:10px" type="submit" name="coffee_memo" id="" value="確　認">


            </form>
        </div>

    </div>


    <?php include('footer.html') ?>

</body>

</html>