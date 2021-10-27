<?php
//おまじない
header('X-FRAME-OPTIONS: SAMEORIGIN');
//セッション
session_start();
session_regenerate_id(true);
if(!isset($_SESSION['username'])):
  header('Location: login.php');
endif;
//エラー配列の作成
$errors = array();
?>