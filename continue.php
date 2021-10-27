<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

$stmt = $pdo->prepare("SELECT `save_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $stmt = null;
  $pdo = null;
  header('Location: turn.php');
  die();
else:
  $stmt = null;
  $pdo = null;
  header('Location: start.php');
  die();
endif;