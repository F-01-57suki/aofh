<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

//セーブからマップとキャラ取得
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$map_id = $result["map_id"];
$chara_id = $result["chara_id"];
$stmt = null;
//キャラ名取得
$stmt = $pdo->prepare("SELECT `chara_name` FROM `chara_tbl` WHERE `chara_id`=:chara_id");
$stmt->bindParam(":chara_id",$chara_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$chara_name = $result["chara_name"];
$stmt = null;

$filepass = "story/in_m".$map_id.".php";
require_once "$filepass";
$pdo = null;
?>