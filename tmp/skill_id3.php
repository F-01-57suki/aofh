<?php
if($_SESSION["chara_id"] == 3 and $now_recast == 0):
  //リキャスト処理
  //スキルのskill_recastを取得
  $stmt = $pdo->prepare("SELECT `skill_recast` FROM `skill_tbl` WHERE `chara_id`=:chara_id");
  if(isset($chara_id)):
    $stmt->bindParam(":chara_id",$chara_id);
  elseif(isset($_SESSION["chara_id"])):
    $stmt->bindParam(":chara_id",$_SESSION["chara_id"]);
  endif;
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $skill_recast = $result["skill_recast"];
  $stmt = null;
  //セーブのnow_recastに加算
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_recast`=:skill_recast WHERE `username`=:username");
  $stmt->bindParam(":skill_recast",$skill_recast);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  //最終結果を2倍
  $speed_check = $speed_check*2;
endif;
?>