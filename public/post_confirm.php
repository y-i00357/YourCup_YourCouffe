<?php

//セッション開始
session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';

//アクセス制限
$referer = $_SERVER['HTTP_REFERER'];
$url1 = "post.php";
$url2 = "post_confirm.php";
if (!(strstr($referer, $url1) || strstr($referer, $url2))) {
    header("Location: post.php");
    exit;
}

//ページ判別番号
$page_flag = 0;

//チェック後の値を変数に入れる
//バリデーション
$validate = UserLogic::dataValidate($_POST);
//エスケープ処理
$clean = html($_POST);


//値が入っていてエラーがある場合
//ページ番号変更
if (!empty($clean['coffee_memo'])) {
    $error = $validate;
    if (!empty($error)) {
        $page_flag = 1;
    }
}

//画像処理
//$_FILEに値がある場合（画像が添付されてる時）

if (!empty($_FILES) || $_FILES['error'] != 4) {
    //ファイルの値を変数に格納
    $file = $_FILES['img'];
    $filename = basename($file['name']);
    $tmp_path = $file['tmp_name'];
    $file_err = $file['error'];
    $filesize = $file['size'];
    //アップロード先の絶対パス
    $upload_dir = "C:/xampp/htdocs/PHP自作/images/";
    //保存用ファイルネーム用変数
    $save_filename = date('ymdHis') . $filename;
}


$evaluation = $_POST["rating"];
$c_name = $_POST["c_name"];
$place = $_POST["place"];
$price = $_POST["price"];
$origin = $_POST["origin"];
$variety = $_POST["variety"];
$brew = $_POST["brew"];
$roast = $_POST["roast"];
$publish_status = $_POST["publish_status"];
$comment = $_POST["comment"];
$user_id = $_POST["user_id"];



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>新規珈琲メモ確認画面</title>
</head>

<body>

    <?php include('header2.html') ?>


    <!--ページ番号-->
    <?php if ($page_flag === 1) : ?>
        <div class="post_wrapper">

            <div class="post_title">

            </div>




            <div class="post_form">


                <form class="post_form" action="post_confirm.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">


                    <div class="post_container">


                        <div class="img_container">

                            <h3 style="margin-bottom: 70px;">＋新規珈琲メモ作成</h3>

                            <img src="../img/takeout_cup.png" alt="珈琲イメージ" style="width: 200px; margin-top:20px"><br>

                            <?php echo isset($error['file']) ? $error['file'] : ''; ?>
                            <?php echo isset($error['filesize']) ? $error['filesize'] : ''; ?>
                            <?php echo isset($error['ext']) ? $error['ext'] : ''; ?>

                            <input type="hidden" name="MAX_FILE_SIZE" value="1048579">
                            <input type="file" name="img" id="" accept="image/*">

                        </div>

                        <div class="c_memo_container">

                            <p style="margin-bottom: 40px;">各項目を記入及び選択してください。<br><span style="color: red;">*</span>は必須項目となります。</p>

                            <p>総合評価<span style="color: red;">*</span></p>
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
                                <?php echo isset($error['c_name']) ? $error['c_name'] : ''; ?>
                                <p>名　称<span style="color: red;">*</span>　：
                                    <input type="text" name="c_name" id="" style="height: 30px;" value="<?php if (!empty($clean['c_name'])) {
                                                                                                            echo $clean['c_name'];
                                                                                                        } ?>">
                                </p>
                                <?php echo isset($error['place']) ? $error['place'] : ''; ?>
                                <p>購入店<span style="color: red;">*</span>　：
                                    <input type="text" name="place" id="" style="height: 30px" value="<?php if (!empty($clean['place'])) {
                                                                                                            echo $clean['place'];
                                                                                                        } ?>">
                                </p>
                                <?php echo isset($error['price']) ? $error['price'] : ''; ?>
                                <p>価　格　：
                                    <input type="number" min=0 max=100000 name="price" id="" style="width: 143px; height: 30px" value="<?php if (!empty($clean['price'])) {
                                                                                                                                            echo $clean['price'];
                                                                                                                                        } ?>">円
                                </p>


                                <?php echo isset($error['origin']) ? $error['origin'] : ''; ?>
                                <p>生産地　：
                                    <input type="text" name="origin" id="" style="height: 30px" value="<?php if (!empty($clean['origin'])) {
                                                                                                            echo $clean['origin'];
                                                                                                        } ?>">
                                </p>
                                <?php echo isset($error['variety']) ? $error['variety'] : ''; ?>
                                <p>品　種　：
                                    <input type="text" name="variety" id="" style="height: 30px" value="<?php if (!empty($clean['variety'])) {
                                                                                                            echo $clean['variety'];
                                                                                                        } ?>">
                                </p>
                                <p>抽出方法：
                                    <select name="brew" id="" style="height: 30px" value="<?php if (!empty($clean['brew'])) {
                                                                                                echo $clean['brew'];
                                                                                            } ?>">
                                        <option value="">抽出方法を選択してください。</option>
                                        <option value="ペーパードリップ">ペーパードリップ</option>
                                        <option value="ネルドリップ">ネルドリップ</option>
                                        <option value="サイフォン">サイフォン</option>
                                        <option value="エスプレッソ">エスプレッソ</option>
                                        <option value="フレンチプレス">フレンチプレス</option>
                                        <option value="コールドブリュー">コールドブリュー</option>
                                        <option value="エアロプレス">エアロプレス</option>
                                    </select>
                                </p>
                                <p>焙　煎　：
                                    <select name="roast" id="" style="height: 30px" value="<?php if (!empty($clean['roast'])) {
                                                                                                echo $clean['roast'];
                                                                                            } ?>">
                                        <option value="">焙煎を選択してください。</option>
                                        <option value="浅煎り">浅煎り</option>
                                        <option value="中煎り">中煎り</option>
                                        <option value="深煎り">深煎り</option>
                                        <option value="その他">その他</option>
                                    </select>
                                </p>
                                <!--公開/非公開設定-->
                                <?php echo isset($error['publish_status']) ? $error['publish_status'] : ''; ?>
                                <input type="radio" name="publish_status" id="" value="1">公開
                                <input type="radio" name="publish_status" id="" value="2" checked>非公開
                            </div>
                        </div>

                    </div>

                    <?php echo isset($error['comment']) ? $error['comment'] : ''; ?>
                    <div class="post_comment">
                        <p>コメント</p>
                        <textarea name="comment" id="" cols="85" rows="10" style="padding: 10px;" value="<?php if (!empty($clean['comment'])) {
                                                                                                                echo $clean['comment'];
                                                                                                            } ?>"></textarea>
                    </div>

                    <input class="chack_btn" style="width: 200px; height: 30px; margin:10px" type="submit" name="coffee_memo" id="" value="確　認">


                </form>
            </div>

        </div>

    <?php else : ?>


        <?php
        //ファイルがあるかチェック
        if (!empty($_FILES) || $_FILES['error'] != 4) {
            if (is_uploaded_file($tmp_path)) {
                if (move_uploaded_file($tmp_path, $upload_dir . $save_filename)) {
                    //成功処理
                    $img = $save_filename;
                } else {
                    //失敗処理
                    $error['file'] = "ファイルが保存できませんでした。";
                }
            } else {
                $img = "";
                $error['file'] = "ファイルが選択されていません。";
            }
            $img = "";
        } else {
            $img = "";
        }

        ?>

        <div class="post_wrapper">

            <div class="post_title">

            </div>

            <div class="post_form">


                <form class="post_form" action="post_confirm.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <div class="post_container">

                        <div class="img_container">

                            <h3 style="margin-bottom: 70px;">＋新規珈琲メモ作成</h3>

                            <img src="../images/<?php if (!empty($tmp_path)) {
                                                    echo $save_filename;
                                                    $img = $save_filename;
                                                } else {
                                                    echo 'takeout_cup.png';
                                                }
                                                ?>" alt="投稿画像" style="width: 200px">

                            <input type="hidden" name="image" value="<?php echo $img; ?>">
                            <p>-イメージ表示-</p>



                        </div>

                        <div class="c_memo_container">

                            <p style="margin-bottom: 40px;">各項目の記入を確認してください。<br><span style="color: red;">*</span>は必須項目となります。</p>

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
                                    $r = $evaluation;
                                    for ($j = 0; $j < 5; $j++) {
                                        if ($j < $r) {
                                            echo "<span>&#9733</span>";
                                        } else {
                                            echo "<span>&#9734</span>";
                                        }
                                    }
                                    echo "</div>";
                                    ?>
                                    <input type="hidden" name="rating" value="<?php echo $evaluation; ?>">
                                </div>
                            </section>

                            <div class="form_item">
                                <p>名　称　：
                                    <input type="hidden" name="c_name" value="<?php echo $clean["c_name"] ?>"><?php echo $clean["c_name"]; ?>
                                </p>
                                <p>購入店　：
                                    <input type="hidden" name="place" value="<?php echo $clean["place"] ?>"><?php echo $clean["place"]; ?>
                                </p>
                                <p>価　格　：
                                    <input type="hidden" name="price" value="<?php echo $clean["price"] ?>"><?php echo $clean["price"]; ?>円
                                </p>


                                <p>生産地　：
                                    <input type="hidden" name="origin" value="<?php echo $clean["origin"] ?>"><?php echo $clean["origin"]; ?>
                                </p>
                                <p>品　種　：
                                    <input type="hidden" name="variety" value="<?php echo $clean["variety"] ?>"><?php echo $clean["variety"]; ?>
                                </p>
                                <p>抽出方法：
                                    <input type="hidden" name="brew" value="<?php echo $clean["brew"] ?>"><?php echo $clean["brew"]; ?>
                                </p>
                                <p>焙　煎　：
                                    <input type="hidden" name="roast" value="<?php echo $clean["roast"] ?>"><?php echo $clean["roast"]; ?>
                                </p>
                                <!--公開/非公開設定-->
                                <input type="hidden" name="publish_status" value="<?php echo $clean["publish_status"] ?>">
                                <?php if ($publish_status == "1") {
                                    echo "公開設定：";
                                } elseif ($publish_status == "2") {
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
                        <textarea name="comment" id="" cols="85" rows="10" style="padding: 10px;" value="<?php echo $clean["comment"] ?>"><?php echo $clean["comment"]; ?></textarea>
                    </div>

                    <input class="chack_btn" style="width: 200px; height: 30px; margin:10px" type="submit" name="back" id="" formaction="post.php" value="戻　る">
                    <input class="reg_btn" style="width: 200px; height: 30px; margin:10px" type="submit" name="reg_coffee" id="" formaction="mypage.php" value="登　録">


                </form>
            </div>

        </div>
    <?php endif ?>


    <?php include('footer.html') ?>

</body>

</html>