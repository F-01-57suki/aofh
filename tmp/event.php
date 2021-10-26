<?php
/////////////////////////////////////////////////////
//イベント配列（いっそ別ファイルにするか悩みどころ・・・・
$evearr = array(
  "",
  //イベ１
  "イベント１のミニストーリーをここに入れます。<br>ほにゃららほにゃららほにゃらら",
  //イベ２
  "イベント２のミニストーリーをここに入れます。<br>ほにゃららほにゃららほにゃらら",
  //イベ３
  "イベント３のミニストーリーをここに入れます。<br>ほにゃららほにゃららほにゃらら",
  //イベ４
  "イベント４のミニストーリーをここに入れます。<br>ほにゃららほにゃららほにゃらら",
);
/////////////////////////////////////////////////////

//ターン追加
if($now_recast == 0):
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1 WHERE `username`=:username");
else:
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1 WHERE `username`=:username");
endif;
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//イベントをカウントする
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `event_tbl`");//あれば末尾にWHERE
$stmt->execute();
$result = $stmt->fetchColumn();
$event_count = $result;
$stmt = null;
//イベントの数で抽選
$event_id_lottery = mt_rand(1,$event_count);

//イベント情報の取得
$stmt = $pdo->prepare("SELECT `event_name`,`event_effect`,`add_adv`,`add_turn`,`add_ap`,`add_sp` FROM `event_tbl` WHERE `event_id`=:event_id");
$stmt->bindParam(":event_id",$event_id_lottery);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$event_name = $result["event_name"];
$event_effect = $result["event_effect"];
$add_adv = $result["add_adv"];
$add_turn = $result["add_turn"];
$add_ap = $result["add_ap"];
$add_sp = $result["add_sp"];
$stmt = null;

//イベント処理
if($add_adv != 0)://進捗追加イベント
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`+:add_adv WHERE `username`=:username");
  $stmt->bindParam(":add_adv",$add_adv);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
elseif($add_turn != 0)://turn追加イベント
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+:add_turn WHERE `username`=:username");
  $stmt->bindParam(":add_turn",$add_turn);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
elseif($add_ap != 0)://AP追加イベント
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+:add_ap WHERE `username`=:username");
  $stmt->bindParam(":add_ap",$add_ap);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
elseif($add_sp != 0)://AP追加イベント
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_sp`=`now_sp`+:add_sp WHERE `username`=:username");
  $stmt->bindParam(":add_sp",$add_sp);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
endif;
?>
  <section>
    <h2 class="eve_h2">イベント発生<br><span class="eve_span">‐<?php echo $event_name; ?>‐</span></h2>
    <p class="eve_p"><?php echo $evearr["$event_id_lottery"]; ?></p>
    <p><span class="system_span"><?php echo $event_effect; ?>した。</span></p>
  </section>
</div>
<div>
  <a href="turn.php" class="next_turn">次のターンへ</a>
</div>