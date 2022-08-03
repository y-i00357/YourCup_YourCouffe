<?php
session_start();

require_once '../functions.php';
require_once '../classes/UserLogic.php';

$result = UserLogic::checkLogin();
if ($result) {
    header('Location: mypage.php');
    return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);


$err = $_SESSION;

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
    <title>新規アカウント作成</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include('header1.html') ?>

    <div class="signup_wrapper">
        <div class="signup_container">
            <style>
                .signup_container p {
                    text-align: center;
                }
            </style>
            <div class="signup_title">
                <h2>Your Cup Your Coffee</h2>
                <img src="../img/coffee_meter.png" alt="珈琲" width="200">
            </div>

            <h3>アカウント作成</h3>
            <!--ログインエラー-->
            <style></style>
            <?php if (isset($login_err)) : ?>
                <p><?php echo $login_err; ?></p>
            <?php endif; ?>
            <!--登録エラー-->
            <?php if (isset($err['hasCreated'])) : ?>
                <p><?php echo $err['hasCreated'] ?></p>
            <?php endif; ?>

            <div class="signup_form">
                <form action="register.php" method="POST">
                    <div class="form_item">
                        <label for="username"><span></span></label>
                        <input type="text" name="username" style="width: 200px; height: 30px" placeholder="ユーザーネーム">
                        <?php if (isset($err['username'])) : ?>
                            <p><?php echo $err['username'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form_item">
                        <label for="mail"><span></span></label>
                        <input type="mail" name="mail" style="width: 200px; height: 30px" placeholder="メールアドレス">
                        <?php if (isset($err['mail'])) : ?>
                            <p><?php echo $err['mail'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form_item">
                        <label for="password"><span></span></label>
                        <input type="password" name="password" style="width: 200px; height: 30px" placeholder="パスワード">
                        <?php if (isset($err['password'])) : ?>
                            <p><?php echo $err['password'] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form_item">
                        <label for="password_conf"><span></span></label>
                        <input type="password" name="password_conf" style="width: 200px; height: 30px" placeholder="確認用パスワード">
                        <?php if (isset($err['password_conf'])) : ?>
                            <p><?php echo $err['password_conf'] ?></p>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="csrf_token" value="<?php echo h(setToken());  ?>">

                    <p><input type="submit" name="signup" class="reg_btn" style="width: 200px; height: 30px;" value="新規登録"></p>


                </form>

                <p class="signup_btn"><a href="login_form.php">ログインはこちら！</a></p>

            </div>

        </div>


    </div>

    <?php include('footer.html') ?>

</body>

</html>