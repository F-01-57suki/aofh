<?php
require_once "tmp/session_in.php";
//ログアウト処理
$_SESSION=array();
if(isset($_COOKIE[session_name()])):
  setcookie(session_name(),"",time()-1000);
endif;
session_destroy();
header('Location: login.php');
die();
?>