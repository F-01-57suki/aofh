<?php
require_once "tmp/post.php";
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/turn_set.php";

//アクションフラグの判定・リセット
$stmt = $pdo->prepare("SELECT `action_flg` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result["action_flg"] == 1):
  $stmt = null;
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `action_flg`=0 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
else:
  $stmt = null;
  $pdo = null;
  header('Location: index.php');
  die();
endif;
?>
        <div>
<?php
if($_POST["action"] == "rest"):
  //休む
  if($now_recast == 0):
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
  else:
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1 WHERE `username`=:username");
  endif;
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
  <h2 class="eve_h2 ok">‐休憩‐</span></h2>
  <p>&emsp;座って休めそうな場所を見つけ、少し休憩した。<br>&emsp;いざという時のため、体力は温存すべきだ。――その時が来ないに越したことはないが。<br><span class="system_span">APが1回復。SPが1回復。</span></p>
  <a href="turn.php" class="next_turn">次のターンへ</a>
  <?php
elseif($_POST["action"] == "move"):
  //進む
  if($now_recast == 0):
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
  else:
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`+1,`now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1 WHERE `username`=:username");
  endif;
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
  <h2 class="eve_h2 ok">‐進む‐</span></h2>
  <p>&emsp;一刻も早く、ここから脱出しなければ。<br>&emsp;周囲を警戒しながら、慎重な足取りで暗闇の先へと進んだ。</p>
  <a href="turn.php" class="next_turn">次のターンへ</a>
  <?php
elseif($_POST["action"] == "return"):
  //戻る
  if($now_recast == 0):
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`-1,`now_turn`=`now_turn`+1,`enemies_flg`=0 WHERE `username`=:username");
  else:
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`-1,`now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1,`enemies_flg`=0 WHERE `username`=:username");
  endif;
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
  <h2 class="eve_h2 ok">‐戻る‐</span></h2>
  <p>&emsp;――嫌な予感がした。こういった予感、直感というのは、よく当たるものだ。<br>&emsp;急いては事を仕損じる、とも言うし、焦る気持ちをぐっと堪えて来た道を戻った。</p>
  <a href="turn.php" class="next_turn">次のターンへ</a>
  <?php
endif;
$pdo = null;
?>
        </div>
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