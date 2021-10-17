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
<p>イベント１</p><br><a href="turn.php">次のターンへ</a>
<?php
/////////////////////////////////////////////////////////////////////
elseif($event_id_lottery == 2):
//$event_idが2のイベント
?>
<p>イベント２が発生</p><br><a href="turn.php">次のターンへ</a>
<?php
/////////////////////////////////////////////////////////////////////
else:
//$event_idが3～のイベント
?>
<p>イベント３</p><br><a href="turn.php">次のターンへ</a>
<?php
endif;
?>