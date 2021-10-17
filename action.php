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
  header('Location: index.php');
  die();
endif;
?>
      <main>
        <div>
<?php
if($_POST["action"] == "rest"):
  //休む
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
  <p><br>少し休憩した</p><br>
  <a href="turn.php">次のターンへ</a>
  <?php
elseif($_POST["action"] == "move"):
  //進む
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
  <p><br>先へ進んだ</p><br>
  <a href="turn.php">次のターンへ</a>
  <?php
else:
  //戻る
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_adv`=`now_adv`-1,`now_turn`=`now_turn`+1,`enemies_flg`=0 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
  <p><br>来た道を戻った</p><br>
  <a href="turn.php">次のターンへ</a>
  <?php
endif;
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
  </body>
</html>