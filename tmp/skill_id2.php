<?php
//お祓い（蘆野かつ、ゴーストのみ）
if($_SESSION["chara_id"] == 2 and $_SESSION["enemy_type"] == "ghost"):
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

  //恐怖値2倍のSPを加算、終了処理へ
  $addsp = ($_SESSION["add_fear"])*2;
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_sp`=`now_sp`+:addsp WHERE `username`=:username");
  $stmt->bindParam(":addsp",$addsp);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  require_once "tmp/battle_end.php";
  ?>
    <section>
      <h2 class="eve_h2 sp">スキル発動<br><span class="eve_span">‐古びたカメラ‐</span></h2>
      <p class="eve_p">&emsp;相手が怨霊の類であれば、蘆野の得意とするところだ。<br><span class="system_span">&emsp;スキル効果により、SPが<?php echo $addsp; ?>回復した。</span></p>
    </section>
  </div>
  <div>
    <a href="turn.php" class="next_turn">次のターンへ</a>
  </div>
  <?php endif; ?>