<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

//セーブデータを取得
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result):
  header('Location: index.php');
  die();
else:
  $map_id = $result["map_id"];
  $chara_id = $result["chara_id"];
  $stmt = null;
endif;

//ニュース入れ込み
$news = "lost_m".$map_id."_c".$chara_id;//lost_m0_c0

//キャラのロストフラグ入れ込み
if($chara_id == 1):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_a`=1,`news`=:news WHERE `username`=:username");
elseif($chara_id == 2):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_t`=1,`news`=:news WHERE `username`=:username");
elseif($chara_id == 3):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_m`=1,`news`=:news WHERE `username`=:username");
elseif($chara_id == 4):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_y`=1,`news`=:news WHERE `username`=:username");
endif;
$stmt->bindParam(":news",$news);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//セーブ削除
$stmt = $pdo->prepare("DELETE FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//TOP画面へ戻る
?>
<p>ゲームオーバー</p>
<a href="index.php">TOP画面へ</a>