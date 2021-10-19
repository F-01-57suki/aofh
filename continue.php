<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

$stmt = $pdo->prepare("SELECT * FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  header('Location: turn.php');
  die();
else:
  header('Location: index.php');
  die();
endif;