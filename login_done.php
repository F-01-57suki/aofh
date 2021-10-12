<?php
require_once "tmp/post.php";
require_once "tmp/session_out.php";
require_once "tmp/db.php";

$stmt = $pdo->prepare("SELECT `pass` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_POST["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  if(password_verify($_POST["pass"],$result["pass"])):
    //ログイン成功
    $_SESSION['username'] = $_POST["username"];
    $_SESSION['pass'] = $_POST["pass"];
    $stmt = null;
    $pdo = null;
    header('Location: index.php');
    die();
  else:
    $errors["ログイン"] = "パスワードが違います。";
    require_once "tmp/error.php";
  endif;
else:
  $errors["ログイン"] = "ユーザー名が違います。";
  require_once "tmp/error.php";
endif;
?>