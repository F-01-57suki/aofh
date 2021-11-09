<?php
//撃破（赤羽かつ、非ゴーストのみ）
if($_SESSION["chara_id"] == 4 and $_SESSION["enemy_type"] != "ghost"):
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
  //敵ダメージ分のAPを減算、終了処理へ（被ダメ1.5倍か悩み中・・・・・・・）
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`-:add_damage WHERE `username`=:username");
  $stmt->bindParam(":add_damage",$add_damage);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  //現在のAP/SPを取得！！！！！！！！！！！１１
  $stmt = $pdo->prepare("SELECT `now_ap`,`now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $now_ap = $result["now_ap"];
  $now_sp = $result["now_sp"];
  $panic_flg = $result["panic_flg"];
  $stmt = null;
  require_once "tmp/battle_end.php";
  ?>
    <section>
      <h2 class="eve_h2 sp">スキル発動<br><span class="eve_span">‐錆びた鉄パイプ‐</span></h2>
      <p class="eve_p">&emsp;錆を覆い、滴るのは返り血か――己の血か。それを袖で乱暴に拭い、赤羽は笑う。<br>「雑魚が。二度と逆らうなよ」<span class="system_span">&emsp;スキル効果により、APが<?php echo $add_damage; ?>減少。</span></p>
      </section>
  </div>
  <div>
    <a href="turn.php" class="next_turn">次のターンへ</a>
  </div>
  <?php
else:
  //エラー
  die("エラーが発生しました。");
endif;
?>