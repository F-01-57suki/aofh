<?php
require_once "tmp/post.php";
require_once "tmp/session_in.php";
//後で消す！/////////////////////////////////////////////////////
if($_POST["stage"] == "2"):
  header('Location: story/in_m2.php');
  die();
elseif($_POST["stage"] == "3"):
  header('Location: story/in_m3.php');
  die();
endif;
////////////////////////////////////////////////////////////////
require_once "tmp/db.php";

//キャラデータの確認
$stmt = $pdo->prepare("SELECT `lost_a`,`lost_t`,`lost_m`,`lost_y` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
foreach($result as $key => $value):
  $$key = $value;//カラム名変数に生存フラグを入れる
endforeach;
$stmt = null;
//もしロストキャラを選んでいたらエラー
if($lost_a == 1 and $_POST["chara"] == 1 or $lost_t == 1 and $_POST["chara"] == 2 or $lost_m == 1 and $_POST["chara"] == 3 or $lost_y == 1 and $_POST["chara"] == 4):
  $errors["キャラクター選択"] = "ロストしているキャラクターです。";
  require_once "tmp/error.php";
endif;

//既存セーブがないことを確認し、新規セーブ作成
$stmt = $pdo->prepare("SELECT `save_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $errors["セーブ"] = "既にセーブがあります。";
  require_once "tmp/error.php";
else:
  $stmt = null;
  //選択キャラのステータス取得
  $stmt = $pdo->prepare("SELECT `chara_ap`,`chara_sp` FROM `chara_tbl` WHERE `chara_id`=:chara_id");
  $stmt->bindParam(":chara_id",$_POST["chara"]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $ap = $result["chara_ap"];
  $sp = $result["chara_sp"];
  //セーブデータ作成
  $stmt = $pdo->prepare("INSERT INTO `user_save_tbl` (`username`,`map_id`,`chara_id`,`now_adv`,`now_turn`,`now_ap`,`now_sp`,`panic_flg`,`now_recast`,`enemies_flg`,`action_flg`,`enemy_id`) VALUES (:username,:map_id,:chara_id,0,0,:now_ap,:now_sp,0,0,0,0,0)");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->bindParam(":map_id",$_POST["stage"]);
  $stmt->bindParam(":chara_id",$_POST["chara"]);
  $stmt->bindParam(":now_ap",$ap);
  $stmt->bindParam(":now_sp",$sp);
  $stmt->execute();
  $stmt = null;
  $pdo = null;
endif;
header('Location: intro.php');
?>