<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

//クリアデータ取得
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id`,`now_adv`,`now_turn` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result):
  header('Location: index.php');
  die();
else:
  $map_id = $result["map_id"];
  $chara_id = $result["chara_id"];
  $now_adv = $result["now_adv"];
  $now_turn = $result["now_turn"];
  $stmt = null;
endif;

//マップサイズと評価を取得
$stmt = $pdo->prepare("SELECT `map_name`,`map_size`,`rank_s_turn`,`rank_a_turn`,`rank_b_turn`,`rank_s_point`,`rank_a_point`,`rank_b_point`,`rank_c_point` FROM `map_tbl` WHERE `map_id`=:map_id");
$stmt->bindParam(":map_id",$map_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result):
  header('Location: index.php');
  die();
else:
  $map_name = $result["map_name"];
  $map_size = $result["map_size"];
  $rank_s_turn = $result["rank_s_turn"];
  $rank_a_turn = $result["rank_a_turn"];
  $rank_b_turn = $result["rank_b_turn"];
  $rank_s_point = $result["rank_s_point"];
  $rank_a_point = $result["rank_a_point"];
  $rank_b_point = $result["rank_b_point"];
  $rank_c_point = $result["rank_c_point"];
  $stmt = null;
endif;

//現在のポイントを取得
$stmt = $pdo->prepare("SELECT `point` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$point = $result["point"];
$stmt = null;

//判定
if($now_adv != $map_size):
  header('Location: turn.php');
  die();
endif;

//結果の判定
if($now_turn <= $rank_s_turn)://S判定
  $rank = "s";
  $addp = $rank_s_point;
elseif($now_turn <= $rank_a_turn)://A判定
  $rank = "a";
  $addp = $rank_a_point;
elseif($now_turn <= $rank_b_turn)://B判定
  $rank = "b";
  $addp = $rank_b_point;
else://C判定
  $rank = "c";
  $addp = $rank_c_point;
endif;

//ニュース入れ込み
$news = "clear_m".$map_id."_c".$chara_id;//clear_m0_c0
//ポイント加算
$stmt = $pdo->prepare("UPDATE `user_tbl` SET `point`=`point`+:addp,`news`=:news WHERE `username`=:username");
$stmt->bindParam(":addp",$addp);
$stmt->bindParam(":news",$news);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//クリアデータの保存
$stmt = $pdo->prepare("INSERT INTO `clear_save_tbl` (`username`,`map_id`,`chara_id`,`clear_turn`,`rank`) VALUES (:username,:map_id,:chara_id,:clear_turn,:rank)");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->bindParam(":map_id",$map_id);
$stmt->bindParam(":chara_id",$chara_id);
$stmt->bindParam(":clear_turn",$now_turn);
$stmt->bindParam(":rank",$rank);
$stmt->execute();
$stmt = null;

//セーブ削除
$stmt = $pdo->prepare("DELETE FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//評価の表示とエピローグ
echo "あなたのランクは、「",$rank,"」でした！<br>ポイントを",$addp,"獲得しました。";
//「$rank」ごとに画像を変える。加算ポイントのテキストは「$addp」を表示
//リザルトの後にエピローグ
//クリックでindexに飛ぶ
?>
<a href="index.php">TOP画面へ</a>