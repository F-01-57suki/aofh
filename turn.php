<?php
die("まだだよ");

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
//現在のターンを取得

require_once "tmp/charaarr.php";
//
//
//
?>