<?php

session_start();

require_once '../classes/UserLogic.php';

//エラーメッセージ
$err = [];

$token = filter_input(INPUT_POST, 'csrf_token');

$_SESSION = $_POST;
//トークンがない、もしくは一致しない場合、処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    exit('不正なリクエスト');
}

unset($_SESSION['csrf_token']);


if (isset($_POST['signup'])) {
    //バリデーション
    if (!$username = filter_input(INPUT_POST, 'username')) {
        $err['username'] = "<span style='color:red;'>ユーザーネームを入力してください。</span>";
    }
    if (!$mail = filter_input(INPUT_POST, 'mail')) {
        $err['mail'] = "<span style='color:red;'>メールアドレスを入力してください。</span>";
    }
    $password = filter_input(INPUT_POST, 'password');
    //正規表現
    if (!preg_match('/\A[a-z\d]{8,100}+\z/i', $password)) {
        $err['password'] = "<span style='color:red;'>パスワードは英数字8文字以上100文字以下にしてください。</span>";
    }
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    if ($password !== $password_conf) {
        $err['password_conf'] = "<span style='color:red;'>確認用パスワードが異なっています。</span>";
    }


    if (count($err) > 0) {
        //エラーがあった場合は戻す
        $_SESSION = $err;
        header('Location: signup.php');
        return;
    }

    if (count($err) === 0) {
        //ユーザーを登録する処理
        $hasCreated = UserLogic::createUser($_POST);
        header('Location: login_form.php');
        


        if (!$hasCreated) {
            $err['hasCreated'] = '登録失敗しました。';
        }
        if (count($err) > 0) {
            //エラーがあった場合は戻す
            $_SESSION = $err;
            header('Location: signup.php');
            return;
        }
    }
}

?>