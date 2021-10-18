<?php
//バトル終了処理
//セーブの敵IDを消去
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemy_id`=0 WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
//接敵フラグのリセット
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemies_flg`=0 WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
//一時セッションの破棄
unset($_SESSION["enemy_name"]);
unset($_SESSION["enemy_type"]);
unset($_SESSION["enemy_speed"]);
unset($_SESSION["enemy_wisdom"]);
unset($_SESSION["add_damage"]);
unset($_SESSION["add_fear"]);
unset($_SESSION["chara_speed"]);
unset($_SESSION["chara_stealth"]);
?>