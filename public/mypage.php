<?php
//セッション開始
session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';



//ログイン：エラーメッセージ
$err = [];
if (isset($_POST['login'])) {

    //バリデーション
    if (!$mail = filter_input(INPUT_POST, 'mail')) {
        $err['errmail'] = "<span style='color:red;'>メールアドレスを入力してください。</span>";
    }
    if (!$password = filter_input(INPUT_POST, 'password')) {
        $err['errpassword'] = "<span style='color:red;'>パスワードを入力してください。</span>";
    }


    if (count($err) > 0) {
        //エラーがあった場合は戻す
        $_SESSION = $err;
        header('Location: login_form.php');
        return;
    }


    //ログイン成功時の処理
    $result = UserLogic::login($mail, $password);
    //ログイン失敗時の処理
    if (!$result) {
        header('Location: login_form.php');
        return;
    }
} elseif (isset($_POST['mypage'])) {
    //ログイン成功時の処理
    $result = UserLogic::login($mail, $password);
    //ログイン失敗時の処理
    if (!$result) {
        header('Location: login_form.php');
        return;
    }
}



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



//ページ更新による重複登録対策
//新規投稿機能
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //データベースに登録
    if (isset($_POST['reg_coffee'])) {
        $result = UserLogic::dateCreate($_POST);
        //リダイレクト処理
        header('Location: ' . $_SERVER['SCRIPT_NAME']);
    }
}

//投稿更新機能
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //投稿更新
    if (isset($_POST['update_coffee'])) {
        $result = UserLogic::coffeeUpdate($_POST);
        //リダイレクト処理
        header('Location: ' . $_SERVER['SCRIPT_NAME']);
    }
}

//アカウント情報更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //アカウント情報更新
    if (isset($_POST['user_edit'])) {
        $result = UserLogic::userUpdate($_POST);
        //リダイレクト処理
        //header('Location: '.$_SERVER['SCRIPT_NAME']);
    }
}

$edit_user = UserLogic::getUserByMail($login_user['mail']);

$_SESSION['login_user'] = $edit_user;



//投稿数取得
$countUserId = UserLogic::countUserId($user_id);
$countUserId = $countUserId["count(user_id=$user_id or null)"];



//ページネーション用準備
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$coffees = UserLogic::userFindAll($page, $user_id);
$coffees_count = UserLogic::countUserAll($user_id);
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
                        <p>ユーザーネーム:<?php echo h($login_user['name']); ?></p>
                        <p>メールアドレス:<?php echo h($login_user['mail']); ?></p>
                        <p>コ　メ　ン　ト:</p>
                        <p><?php echo h($edit_user['comment']); ?></p>
                        <a href="user_edit.php">編集する</a>
                        <!-- <a href="user_edit.php?id=<//?php echo h($login_user['id']); ?>">編集する</a> -->
                </div>
            </div>

            <div class="main_container">
                <div class="main_title_wrapper">
                    <div class="main_content_title">
                        <p class=><?php echo h($login_user['name']); ?>さんのCupboard</p>
                        <!-- post.php-->
                        <p><a href="post.php">＋新規珈琲メモ作成</a></p>
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
                                        <p><a href="./coffee.php?id=<?php echo h($column['id']); ?>">詳細</a></p>

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
                echo "<a  href='?page=" . $i . "'>" . ($i + 1) . "</a>" . " ";
            }
        }
        ?>
    </div>

    <?php include('footer.html') ?>

</body>

</html>