<?php
require_once "tmp/post.php";
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/turn_set.php";
if(!isset($_SESSION["enemy_name"])):
  header('Location: index.php');
  die();
endif;
?>
<script>
  battle_ui.style.backgroundImage = "url(images/<?php echo $_SESSION["enemy_type"]; ?>.jpg)";
</script>
<?php
$stmt = $pdo->prepare("SELECT `panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$panic_flg = $result["panic_flg"];
$stmt = null;
if($panic_flg == 1):
  //パニック中は被ダメが倍
  $add_damage = $_SESSION["add_damage"]*2;
else:
  $add_damage = $_SESSION["add_damage"];
endif;

//赤羽スキル発動
if($_POST["battle"] == "kill" and $now_recast == 0):
  require_once "tmp/skill_id4.php";

//蘆野スキル発動
elseif($_POST["battle"] == "purify" and $now_recast == 0):
  require_once "tmp/skill_id2.php";

//隠れる
//ステルスが高ければ成功確率上昇（乱数とってキャラステルスの範囲内なら成功）
elseif($_POST["battle"] == "stealth"):
  //キャラのステルスから敵の賢さを引き、判定へ
  $stealth_check = ($_SESSION["chara_stealth"])-($_SESSION["enemy_wisdom"]);
  $stealth_lottery = mt_rand(1,10);

  //lotteryがcheck以下なら成功
  if($stealth_lottery <= $stealth_check):
    require_once "tmp/battle_end.php";
    ?>
      <section>
        <h2 class="eve_h2 ok">‐回避に成功‐</span></h2>
        <p class="eve_p">&emsp;物陰に隠れ、息を殺す。早鐘を打つ心臓を、必死で抑える。<br>&emsp;不気味な気配は暫く近くを探していたようだが、――やがて諦めたのか、どこかへと去っていった……。</p>
      </section>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  else:
    //失敗処理（AP/SP減少の後、「次へ」を表示。押したらターン1加算で再度バトル処理へ）
    if($now_recast == 0):
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_ap`=`now_ap`-:add_damage,`now_sp`=`now_sp`-:add_fear WHERE `username`=:username");
    else:
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1,`now_ap`=`now_ap`-:add_damage,`now_sp`=`now_sp`-:add_fear WHERE `username`=:username");
    endif;
    $stmt->bindParam(":add_damage",$add_damage);
    $stmt->bindParam(":add_fear",$_SESSION["add_fear"]);
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
    //パニック判定
    if($now_sp <= 0 and $panic_flg == 0)://SPが0になった
      //パニックON、ペナルティでSPに-3
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=1,`now_sp`=`now_sp`-3 WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $stmt = null;
      //最新のSPとパニックフラグを再取得
      $stmt = $pdo->prepare("SELECT `now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $now_sp = $result["now_sp"];
      $panic_flg = $result["panic_flg"];
      $stmt = null;
    elseif($now_sp >= 0 and $panic_flg == 1)://SPが0に戻った
      //パニックフラグOFF、SPに3加算
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=0,`now_sp`=`now_sp`+1 WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $stmt = null;
      //最新のSPとパニックフラグを再取得
      $stmt = $pdo->prepare("SELECT `now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $now_sp = $result["now_sp"];
      $panic_flg = $result["panic_flg"];
      $stmt = null;
    endif;
    ?>
      <section>
        <h2 class="eve_h2 ng">‐回避失敗‐</span></h2>
        <p>&emsp;慌てて隠れるも、すぐに見つかってしまった！<br><span class="system_span">&emsp;怪異との接触により、APが<?php echo $add_damage; ?>減少。SPが<?php echo $_SESSION["add_fear"]; ?>減少。</span></p>
      </section>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php

  endif;

//逃げる
//スピードが早ければ成功確率上昇（乱数とってキャラ速度の範囲内なら成功）
elseif($_POST["battle"] == "speed"):
  //キャラの速度から敵の速度を引き、判定へ
  $speed_check = ($_SESSION["chara_speed"])-($_SESSION["enemy_speed"]);
  $speed_lottery = mt_rand(1,10);
  //狩場スキル発動
  require_once "tmp/skill_id3.php";
  //lotteryがcheck以下なら成功
  if($speed_lottery <= $speed_check):
    require_once "tmp/battle_end.php";
    ?>
      <section>
        <h2 class="eve_h2 ok">‐回避に成功‐</span></h2>
        <p>&emsp;考えるよりも先に、体が動いていた。無我夢中で走っていた。<br>&emsp;そして、――やがて疲れて立ち止まると、もう不気味な気配は追ってきていなかった。</p>
      </section>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  else:
    //失敗処理（AP/SP減少の後、「次へ」を表示。押したら再度バトル処理へ）
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_ap`=`now_ap`-:add_damage,`now_sp`=`now_sp`-:add_fear WHERE `username`=:username");//ターンも1加算
    $stmt->bindParam(":add_damage",$add_damage);
    $stmt->bindParam(":add_fear",$_SESSION["add_fear"]);
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
    //パニック判定
    if($now_sp <= 0 and $panic_flg == 0)://SPが0になった
      //パニックON、ペナルティでSPに-3
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=1,`now_sp`=`now_sp`-3 WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $stmt = null;
      //最新のSPとパニックフラグを再取得
      $stmt = $pdo->prepare("SELECT `now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $now_sp = $result["now_sp"];
      $panic_flg = $result["panic_flg"];
      $stmt = null;
    elseif($now_sp >= 0 and $panic_flg == 1)://SPが0に戻った
      //パニックフラグOFF、SPに3加算
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=0,`now_sp`=`now_sp`+1 WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $stmt = null;
      //最新のSPとパニックフラグを再取得
      $stmt = $pdo->prepare("SELECT `now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $now_sp = $result["now_sp"];
      $panic_flg = $result["panic_flg"];
      $stmt = null;
    endif;
    ?>
      <section>
        <h2 class="eve_h2 ng">‐回避失敗‐</span></h2>
        <p>&emsp;走って逃げるも、すぐに追いつかれてしまった！<br><span class="system_span">&emsp;怪異との接触により、APが<?php echo $add_damage; ?>減少。SPが<?php echo $_SESSION["add_fear"]; ?>減少。</span></p>
      </section>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  endif;
endif;
?>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <script>
      const gage_now = document.getElementById("gage_now");
      gage_now.style.width = "<?php echo $map_percent; ?>%";
      console.log(<?php echo $map_percent; ?>);
    </script>
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>