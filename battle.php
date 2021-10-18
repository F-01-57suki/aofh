<?php
///////////////////////////////////////////////////////////
//パニック時の処理（キャラステ半減を予定）は未実装
///////////////////////////////////////////////////////////

require_once "tmp/post.php";
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/turn_set.php";

//撃破（赤羽かつ、非ゴーストのみ）
if($_POST["battle"] == "kill"):
  if($_SESSION["chara_id"] == 4 and $_SESSION["enemy_type"] != "ghost"):
    //敵ダメージ分のAPを減算、終了処理へ（被ダメ1.5倍か悩み中・・・・・・・）
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`-:add_damage WHERE `username`=:username");
    $stmt->bindParam(":add_damage",$_SESSION["add_damage"]);
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
    //ゲームオーバー判定
    if($now_ap <= 0):
      header('Location: failed.php');
    endif;
    require_once "tmp/battle_end.php";
    ?>
      <p>倒したよ</p>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  else:
    //エラー
    die("エラーが発生しました。");
  endif;

//お祓い（蘆野かつ、ゴーストのみ）
elseif($_POST["battle"] == "purify"):
  if($_SESSION["chara_id"] == 2 and $_SESSION["enemy_type"] == "ghost"):
    //恐怖値2倍のSPを加算、終了処理へ
    $addsp = ($_SESSION["add_fear"])*2;
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_sp`=`now_sp`+:addsp WHERE `username`=:username");
    $stmt->bindParam(":addsp",$addsp);
    $stmt->bindParam(":username",$_SESSION["username"]);
    $stmt->execute();
    $stmt = null;
    require_once "tmp/battle_end.php";
    ?>
      <p>お祓いしたよ</p>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  else:
    //エラー
    die("エラーが発生しました。");
  endif;

//隠れる
//ステルスが高ければ成功確率上昇（乱数とってキャラステルスの範囲内なら成功）
elseif($_POST["battle"] == "stealth"):
  //キャラのステルスから敵の賢さを引き、判定へ
  $stealth_check = ($_SESSION["chara_stealth"])-($_SESSION["enemy_wisdom"]);
  $stealth_lottery = mt_rand(1,10);

  ///////////////////////////////////////////////////////
  //後で消す
  echo 'キャラステ',$_SESSION["chara_stealth"],'敵ステ',$_SESSION["enemy_wisdom"],'<br><br>stealth_check：',$stealth_check,'<br><br>stealth_lottery：',$stealth_lottery,'<br><br>';
  ///////////////////////////////////////////////////////

  //lotteryがcheck以下なら成功
  if($stealth_lottery <= $stealth_check):
    require_once "tmp/battle_end.php";
    ?>
      <p>隠れたよ</p>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  else:
    //失敗処理（AP/SP減少の後、「次へ」を表示。押したら再度バトル処理へ）
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_ap`=`now_ap`-:add_damage,`now_sp`=`now_sp`-:add_fear WHERE `username`=:username");//ターンも1加算
    $stmt->bindParam(":add_damage",$_SESSION["add_damage"]);
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
    //ゲームオーバー判定
    if($now_ap <= 0):
      header('Location: failed.php');
    endif;
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
    require_once "tmp/battle_end.php";
    ?>
      <p>ステルスしっぱい・・・・・・</p>
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

  ///////////////////////////////////////////////////////
  //後で消す
  echo 'キャラ速度',$_SESSION["chara_speed"],'敵速度',$_SESSION["enemy_speed"],'<br><br>speed_check：',$speed_check,'<br><br>speed_lottery：',$speed_lottery,'<br><br>';
  ///////////////////////////////////////////////////////

  //lotteryがcheck以下なら成功
  if($speed_lottery <= $speed_check):
    require_once "tmp/battle_end.php";
    ?>
      <p>逃げたよ</p>
    </div>
    <div>
      <a href="turn.php" class="next_turn">次のターンへ</a>
    </div>
    <?php
  else:
    //失敗処理（AP/SP減少の後、「次へ」を表示。押したら再度バトル処理へ）
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1,`now_ap`=`now_ap`-:add_damage,`now_sp`=`now_sp`-:add_fear WHERE `username`=:username");//ターンも1加算
    $stmt->bindParam(":add_damage",$_SESSION["add_damage"]);
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
    //ゲームオーバー判定
    if($now_ap <= 0):
      header('Location: failed.php');
    endif;
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
    require_once "tmp/battle_end.php";
    ?>
      <p>にげれんかった・・・・・・</p>
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
  </body>
</html>