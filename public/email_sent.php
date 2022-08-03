<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <title>パスワードリセットメール送信完了</title>
</head>

<body>

    <?php include('header1.html') ?>

    <div class="sent_wrapper">

        <div class="sent_title">
            <h3>
                パスワードリセットメール<br>
                送信完了
            </h3>

        </div>
        <div class="sent_comment">
            <p>パスワードリセットURLを送信致しました。<br>
                ご確認ください。
            </p>
            <p>認証コード：<?php if (isset($certification)) {
                            echo $certification;
                        } ?></p>
        </div>
        <div class="sent_comment">
            <p>指示に従いリセット手続きをお願い致します。</p>
            <p>完了致しましたら、ログインを行ってください。</p>
        </div>


    </div>

    <?php include('footer.html') ?>

</body>

</html>