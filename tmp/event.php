<?php
//ターン追加
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1 WHERE `username`=:username");
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

/////////////////////////////////////////////////////////////////////
if($event_id_lottery == 1):
//$event_idが1のイベント
?>
  <p>イベント（１）</p>
</div>
<div>
  <a href="turn.php" class="next_turn">次のターンへ</a>
</div>
<?php
/////////////////////////////////////////////////////////////////////
elseif($event_id_lottery == 2):
//$event_idが2のイベント
?>
  <p>イベント（２）</p>
</div>
<div>
  <a href="turn.php" class="next_turn">次のターンへ</a>
</div>
<?php
/////////////////////////////////////////////////////////////////////
else:
//$event_idが3～のイベント
?>
  <p>イベント（３）</p>
</div>
<div>
  <a href="turn.php" class="next_turn">次のターンへ</a>
</div>
<?php
endif;
?>