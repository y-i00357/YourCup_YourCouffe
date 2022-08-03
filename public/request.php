<?php
session_start();

//外部ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';



$csrfToken = filter_input(INPUT_POST, '_csrf_token');

// csrf tokenを検証
if (
    empty($csrfToken)
    || empty($_SESSION['_csrf_token'])
    || $csrfToken !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

// emailのバリデーション
if (!$email = filter_input(INPUT_POST, 'email')) {
    header("Location: passwordresetform.php");
    exit;
};

$certification = generateCode(4);

// pdoオブジェクトを取得
$pdo = connect();
// emailがusersテーブルに登録済みか確認
$sql = 'SELECT * FROM users WHERE mail = :mail ';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $email, \PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(\PDO::FETCH_OBJ);

// 未登録のメールアドレスであっても、送信完了画面を表示
// 「未登録です」と表示すると、万が一そのメールアドレスを知っている別人が入力していた場合、「このメールアドレスは未登録である」と情報を与えてしまう
if (!$user) {
    require_once './email_sent.php';
    exit();
}


// password reset token生成
$passwordResetToken = bin2hex(random_bytes(32));
$certification = generateCode(4);

//SQL記述
$sql = 'INSERT INTO password_resets(email,token,token_sent_at,cood) 
        VALUES(:email, :token, :token_sent_at, :cood)';

// password_resetsテーブルへの変更とメール送信は原子性を保ちたいため、トランザクションを設置する
// メール送信に失敗した場合は、パスワードリセット処理自体も失敗させる
try {
    $pdo->beginTransaction();

    // ユーザーを仮登録
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':token', $passwordResetToken, PDO::PARAM_STR);
    $stmt->bindValue(':cood', $certification, PDO::PARAM_INT);
    $stmt->bindValue(':token_sent_at', (new DateTime())->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();


// 以下、mail関数でパスワードリセット用メールを送信
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// URLはご自身の環境に合わせてください
$url = "http://localhost/public/show_reset_form.php?token={$passwordResetToken}";

$subject =  'パスワードリセット用URLをお送りします';

$body = <<<EOD
        24時間以内に下記URLへアクセスし、パスワードの変更を完了してください。
        {$url}
        EOD;


// From
$headers = "From : y.imai19951018@gmail.com";

// mb_send_mailは成功したらtrue、失敗したらfalseを返す
$isSent = mb_send_mail($email, $subject, $body, $headers);

if (!$isSent) throw new Exception('メール送信に失敗しました。');

// メール送信まで成功したら、password_resetsテーブルへの変更を確定
$pdo->commit();

} catch (Exception $e) {
    $pdo->rollBack();

    exit($e->getMessage());
}


// 送信済み画面を表示
require_once './email_sent.php';