
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/good.js"></script>

<?php
session_start();

require_once '../classes/UserLogic.php';
require_once '../functions.php';



if(isset($_POST)) {

  $user_id = $_SESSION['login_user']['id'];
  $p_id = $_POST['post_id'];

  //登録されているか確認
  if(!UserLogic::check_favolite_duplicate($user_id,$p_id)) {
    $result = UserLogic::favoriteDone($user_id,$p_id);
    header("Location: others_coffee.php?id=$p_id");
    echo '登録';
  } else {
    UserLogic::favoriteCancal($user_id,$p_id);
    header("Location: others_coffee.php?id=$p_id");
    echo '削除';
  }

}