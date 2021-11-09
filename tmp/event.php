<?php
//イベント配列
$evearr = array(
  "",
  //ID1　ホッと一息　APが5回復
  "　そこはかとなく空腹を感じ、バッグの中を覗き込む。<br>　そこには少し溶けた小粒のチョコレート菓子が入っていた。",
  //ID2　元気の源　SPが5回復
  "　恐怖に疲労、心細さが一気に押し寄せて、思わず涙ぐむ。そんな場合ではないのに。<br>　気付けば、スマホでメンバーとのチャットを見返していた。そこには楽し気な会話と写真がずらりと並ぶ。<br>　また皆と笑い合う、そのために、絶対に帰ってみせる。スマホを握る手に力を込めた。",
  //ID3　希望へ！　進んだ距離が3増加
  "イベント３のミニストーリーをここに入れます。<br>ほにゃららほにゃららほにゃらら",
  //ID4　彼女ハ迷走ス　ターンが1増加
  "イベント４のミニストーリーをここに入れます。<br>ほにゃららほにゃららほにゃらら",
);

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
  //AP（現在値＋回復値＝最大値より大きい場合、最大値に回復）
  $ap_limit = $now_ap + $add_ap;
  if($ap_limit <= $chara_ap):
    //問題なし、通常処理
    $recovery_ap = $ap_limit;
  else:
    //上限を入れ込む
    $recovery_ap = $chara_ap;
  endif;
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=:recovery_ap WHERE `username`=:username");
  $stmt->bindParam(":recovery_ap",$recovery_ap);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
elseif($add_sp != 0)://SP追加イベント
  //SP（現在値＋回復値＝最大値より大きい場合、最大値に回復）
  $sp_limit = $now_sp + $add_sp;
  if($sp_limit <= $chara_sp):
    //問題なし、通常処理
    $recovery_sp = $sp_limit;
  else:
    //上限を入れ込む
    $recovery_sp = $chara_sp;
  endif;
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_sp`=:recovery_sp WHERE `username`=:username");
  $stmt->bindParam(":recovery_sp",$recovery_sp);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
endif;
?>
  <section>
    <h2 class="eve_h2">イベント発生<br><span class="eve_span">‐<?php echo $event_name; ?>‐</span></h2>
    <p class="eve_p"><?php echo $evearr["$event_id_lottery"]; ?></p>
    <p><span class="system_span"><?php echo $event_effect; ?>した。</span></p>
    <a href="turn.php" class="next_turn">次のターンへ</a>
  </section>
</div>