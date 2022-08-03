<?php

session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';

//$mail = $_SESSION["mail"];
//$password = $_SESSION['password'];

//var_dump($_SESSION);

//ログイン判定
$result = UserLogic::checkLogin();

if (!$result) {
    $_SESSION['login_err'] = "<span style='color:red;'>ユーザー登録、またはログインしてください。</span>";
    header('Location: signup.php');
    return;
}

$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規珈琲メモ作成</title>
    <link rel="stylesheet" href="../css/style.css">


</head>

<body>



    <?php include('header2.html') ?>



    <div class="post_wrapper">

        <div class="post_title">
            
        </div>




        <div class="post_form">


            <form class="post_form" action="post_confirm.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="user_id" value="<?php echo $login_user['id'] ?>">


                <div class="post_container">

                    <div class="img_container">

                    <h3 style="margin-bottom: 70px;">＋新規珈琲メモ作成</h3>

                        <img src="../img/takeout_cup.png" alt="珈琲イメージ" style="width: 200px; margin-top:20px"><br>

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

                            <p>名　称<span style="color: red;">*</span>　：
                                <input type="text" name="c_name" id="" style="height: 30px;" value="<?php if(!empty($_POST['c_name'])){echo $_POST['c_name'];}?>">
                            </p>
                            <p>購入店<span style="color: red;">*</span>　：
                                <input type="text" name="place" id="" style="height: 30px" value="<?php if(!empty($_POST['place'])){echo $_POST['place'];}?>">
                            </p>
                            <p>価　格　：
                                <input type="number" min=0 name="price" id="" style="width: 143px; height: 30px" value="<?php if(!empty($_POST['price'])){echo $_POST['price'];}?>">円
                            </p>


                            <p>生産地　：
                                <input type="text" name="origin" id="" style="height: 30px" value="<?php if(!empty($_POST['origin'])){echo $_POST['origin'];}?>">
                            </p>
                            <p>品　種　：
                                <input type="text" name="variety" id="" style="height: 30px" value="<?php if(!empty($_POST['variety'])){echo $_POST['variety'];}?>">
                            </p>
                            <p>抽出方法：
                                <select name="brew" id="" style="height: 30px" value="<?php if(!empty($_POST['brew'])){echo $_POST['brew'];}?>">
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
                                <select name="roast" id="" style="height: 30px" >
                                    <option value="<?php if(!empty($_POST['roast'])){echo $_POST['roast'];}else{echo "";}?>"><?php if(!empty($_POST['roast'])){echo $_POST['roast'];}else{ echo "焙煎を選択してください。";}?></option>
                                    <option value="浅煎り">浅煎り</option>
                                    <option value="中煎り">中煎り</option>
                                    <option value="深煎り">深煎り</option>
                                    <option value="その他">その他</option>
                                </select>
                            </p>
                            <!--公開/非公開設定-->
                            <input type="radio" name="publish_status" id="" value="1">公開
                            <input type="radio" name="publish_status" id="" value="2" checked>非公開
                        </div>
                    </div>

                </div>

                <div class="post_comment">
                    <p>コメント　※１５０文字まで</p>
                    <textarea name="comment" id="text" cols="85" rows="10" style="padding: 10px;"><?php if(!empty($_POST['comment'])){echo $_POST['comment'];}?></textarea>
                    <div id="ret"></div>
                    
                </div>

                <input class="chack_btn" style="width: 200px; height: 30px; margin:10px" type="submit" name="coffee_memo" id="" value="確　認">


            </form>
            <button id="send">文字数カウント</button>
            <script>
                        $(function () {
                            $("#send").on("click",function(event){
                                let id = $("#text").val();
                                $ajax({
                                    type: "POST",
                                    url: "count.php",
                                    data: {"id": id},
                                    datatype: "text"
                                }).done(function(data) {
                                    //通信成功時処理
                                    $("#ret").html(data);
                                }).fail(function (XMLHttpRequest,status,error) {
                                    //失敗時処理
                                    alert(error);
                                });
                            });  
                        });
                    </script>
        </div>

    </div>


    <?php include('footer.html') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    $(function () {
      $("#send").on("click", function (event) {
        let id = $("#text").val();
        $.ajax({
          type: "POST",
          url: "count.php",
          data: { "id": id },
          dataType: "text"
        }).done(function (data) {
          // 通信成功時の処理
          $("#ret").html(data);
        }).fail(function (XMLHttpRequest, status, error) {
          // 津神失敗時の処理
          alert(error);
        });
      });
    });
  </script>
</body>

</html>