<?php
//おまじない
header('X-FRAME-OPTIONS: SAMEORIGIN');
//セッション
session_start();
session_regenerate_id(true);
if(!isset($_SESSION['username'])):
  header('Location: login.php');
endif;
//チュートリアル確認
if($_SESSION['news'] == 'tutorial'):
  header('Location: tutorial.php');
endif;
//エラー配列の作成
$errors = array();
?>