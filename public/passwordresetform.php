<?php

session_start();

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <title>パスワードリセット</title>
</head>

<body>

    <?php include('header1.html') ?>

    <div class="sent_wrapper">
        <div class="sent_title">
            <h1>Your Cup Your Coffee</h2>
        </div>

        <div class="sent_title">
            <h3>パスワードをお忘れですか？</h3>
            <h4>パスワードの再設定が必要となります。</h4>
        </div>

        <div class="sent_comment">

            <form action="request.php" method="POST">
                <p>--パスワードリセット--</p>
                <p>　</p>
                <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
                <label>
                    登録しているメールアドレスを入力してください。<br>
                    パスワードリセット用URLをメールにて送信致します。
                </label>
                <p><input style="width: 250px; height:25px; " type="email" name="email" value=""></p>
                <button style="padding: 3px 40px;" class="reset_btn" type="submit">送　信</button>
            </form>

        </div>


    </div>

    <?php include('footer.html') ?>

</body>

</html>