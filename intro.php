<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/maparr.php";
//require_once "tmp/charaarr.php";

$stmt = $pdo->prepare("SELECT `map_id`,`chara_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$map_id = $result["map_id"];
$chara_id = $result["chara_id"];

if($map_id == 0)://///////////////////////////////////
  //きさらぎ駅
  if($chara_id == 0):
    require_once "intro/m0c0.php";
    die();
  elseif($chara_id == 1):
    require_once "intro/m0c1.php";
    die();
  elseif($chara_id == 2):
    require_once "intro/m0c2.php";
    die();
  elseif($chara_id == 3):
    require_once "intro/m0c3.php";
    die();
  else:
    $errors["イントロ読込"] = "時間をおいて、再度お試しください。";
    require_once "tmp/error.php";
  endif;
/*
elseif($map_id == 1):
  //未定マップ
  if($chara_id == 0):
    require_once "intro/m1c0.php";
    die();
  elseif($chara_id == 1):
    require_once "intro/m1c1.php";
    die();
  elseif($chara_id == 2):
    require_once "intro/m1c2.php";
    die();
  elseif($chara_id == 3):
    require_once "intro/m1c3.php";
    die();
  else:
    $errors["イントロ読込"] = "時間をおいて、再度お試しください。";
    require_once "tmp/error.php";
  endif;
*/
endif;
?>