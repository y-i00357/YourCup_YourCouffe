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
            <h2>Your Cup Your Coffee</h2>
            <h4>パスワードの再設定を行います。</h4>
        </div>

        <div class="sent_comment">
            <p style="margin-bottom: 20px;">パスワードリセット</p>
            <form action="reset.php" method="POST">
                <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
                <input type="hidden" name="password_reset_token" value="<?= $passwordResetToken ?>">

                <p>
                    新しいパスワード
                    <input style="width: 250px; height:25px; " type="password" name="password">
</p>
                <br>
                <p>
                    パスワード（確認用）
                    <input style="width: 250px; height:25px; " type="password" name="password_confirmation">
</p>
                <br>

                <button style="padding: 3px 40px;" type="submit" class="reset_btn">登　録</button>
            </form>

        </div>


    </div>

    <?php include('footer.html') ?>

</body>

</html>