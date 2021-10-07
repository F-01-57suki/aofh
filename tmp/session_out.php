<?php
//おまじない
header('X-FRAME-OPTIONS: SAMEORIGIN');
//セッション（未ログイン状態）
session_start();
session_regenerate_id(true);
if(isset($_SESSION['username'])):
  header('Location: index.php');
endif;
//エラー配列の作成
$errors=array();
?>