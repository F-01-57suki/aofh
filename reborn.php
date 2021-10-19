<?php
require_once "tmp/post.php";
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/charaarr.php";

//ポイントを差し引き
$stmt = $pdo->prepare("UPDATE `user_tbl` SET `point`=`point`-10 WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
//最新の所持ポイントを取得
$stmt = $pdo->prepare("SELECT `point` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$point = $result["point"];
$stmt = null;

//ロストフラグをオフ
if($_POST["reborn"] == 1):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_a`=0 WHERE `username`=:username");
elseif($_POST["reborn"] == 2):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_t`=0 WHERE `username`=:username");
elseif($_POST["reborn"] == 3):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_m`=0 WHERE `username`=:username");
elseif($_POST["reborn"] == 4):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_y`=0 WHERE `username`=:username");
endif;
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
?>
<p>現在の所持ポイント：<?php echo $point; ?></p>
<p><?php echo $charaarr[$_POST["reborn"]]; ?>が選択可能になりました。</p>

<a href="index.php">TOP画面へ</a>