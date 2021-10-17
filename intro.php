<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/maparr.php";
require_once "tmp/charaarr.php";

$stmt = $pdo->prepare("SELECT `map_id`,`chara_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$map_id = $result["map_id"];
$chara_id = $result["chara_id"];

if($map_id == 1):
  //きさらぎ駅
  require_once "story/in_m1.php";
/*
elseif($map_id == 2):
  //未定マップ
  require_once "story/in_m2.php";
*/
endif;
?>