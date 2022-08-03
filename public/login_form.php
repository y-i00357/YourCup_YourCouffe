<?php
session_start();

require_once '../classes/UserLogic.php';

//signupから遷移してきたとき
//エラーメッセージ格納の為に$_SESSIONを初期化する。
$referer = $_SERVER['HTTP_REFERER'];
$url = "register.php";
if (strstr($referer,$url)) {
    $_SESSION = array();

} else {
    $result = UserLogic::checkLogin();
    if ($result) {
        header('Location: mypage.php');
        return;
    }

    $err = $_SESSION;
}



//セッション削除
$_SESSION = array();
session_destroy();


?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include('header1.html') ?>

    <div class="signup_wrapper">
        <div class="signup_container">
            <div class="signup_title">
                <h2>Your Cup Your Coffee</h2>
                <img src="../img/coffee_meter.png" alt="珈琲" width="200">
            </div>

            <h3>ログイン</h3>
            <?php if (isset($err['msg'])) : ?>
                <p><?php echo $err['msg'] ?></p>
            <?php endif; ?>

            <div class="signup_form">
                <form action="mypage.php" method="POST">
                    <div class="form_item">
                        <label for="mail"></label>
                        <input type="mail" name="mail" placeholder="メールアドレス" style="width: 200px; height: 30px">
                        <?php if (isset($err['errmail'])) : ?>
                            <p><?php echo $err['errmail'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form_item">
                        <label for="password"></label>
                        <input type="password" name="password" placeholder="パスワード" style="width: 200px; height: 30px">
                        <?php if (isset($err['errpassword'])) : ?>
                            <p><?php echo $err['errpassword'] ?></p>
                        <?php endif; ?>
                    </div>

                    <p><input type="submit" name="login" class="login_btn_2" style="width: 200px; height: 30px" value="ログイン"></p>


                </form>

                <p class="signup_btn"><a href="signup.php">新規アカウント作成</a></p>
                <p class="signup_btn"><a href="passwordresetform.php">パスワードを忘れた方はこちら</a></p>

            </div>

        </div>


    </div>

    <?php include('footer.html') ?>

</body>

</html>