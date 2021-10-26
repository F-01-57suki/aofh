<?php
//ターン追加
if($now_recast == 0):
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1 WHERE `username`=:username");
else:
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1 WHERE `username`=:username");
endif;
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//マップの敵idを順に配列へ
$enemyarr = array(0 => 0);
$stmt = $pdo->prepare("SELECT `enemy_id` FROM `enemy_tbl` WHERE `map_id`=:map_id");
$stmt->bindParam(":map_id",$map_id);
$stmt->execute();
while($result = $stmt->fetch(PDO::FETCH_ASSOC)):
  $enemyarr[] = $result["enemy_id"];
endwhile;
$stmt = null;


//敵数を取得
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `enemy_tbl` WHERE `map_id`=:map_id");
$stmt->bindParam(":map_id",$map_id);
$stmt->execute();
$result = $stmt->fetchColumn();
$enemy_count = $result;
$stmt = null;

//敵の抽選（敵数で抽選し、配列のキーに当てはめて敵を決定）
$enemy_mt_rand = mt_rand(1,$enemy_count);
$setenemy = $enemyarr[$enemy_mt_rand];

//敵IDをセーブ
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemy_id`=:enemy_id WHERE `username`=:username");
$stmt->bindParam(":enemy_id",$setenemy);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//敵IDの再取得（しないと初期値0のまま）
$stmt = $pdo->prepare("SELECT `enemy_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$enemy_id = $result["enemy_id"];
$stmt = null;

//初回のSAN値チェック
//恐怖値の取得
$stmt = $pdo->prepare("SELECT `add_fear` FROM `enemy_tbl` WHERE `enemy_id`=:enemy_id");
$stmt->bindParam(":enemy_id",$enemy_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$add_fear = $result["add_fear"];
$stmt = null;
//SAN値の減少
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_sp`=`now_sp`-:add_fear WHERE `username`=:username");
$stmt->bindParam(":add_fear",$add_fear);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
?>