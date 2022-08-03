<?php
$id = $_POST['id'];
//文字数カウント
$count = mb_strlen($id);
//出力
echo "現在".$count."文字です。";

exit;

?>