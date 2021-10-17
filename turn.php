<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/turn_set.php";

if($action_flg):
  //パニックなら操作不能
  if($panic_flg):
    //強制で休む
    $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
    $stmt->bindParam(":username",$_SESSION["username"]);
    $stmt->execute();
    $stmt = null;
    ?>
    <main>
      <div>
        <p>パニックで動けない……。</p>
        <a href="turn.php">次のターンへ</a>
      </div>
    </main>
    <?php
  else:
  //行動選択画面を表示
  ?>
    <main>
      <div>
        <form action="action.php" method="post" id="action">
          <button type="submit" name="action" value="move" class="action_btn">先へ進む</button><br>
          <button type="submit" name="action" value="rest" class="action_btn">休憩する</button><br>
  <?php
    $stmt = $pdo->prepare("SELECT `now_adv` FROM `user_save_tbl` WHERE `username`=:username");
    $stmt->bindParam(":username",$_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result["now_adv"] >= 1):  
  ?>
          <button type="submit" name="action" value="return" class="action_btn">道を戻る</button><br>
  <?php
  endif;
  $stmt = null;
  ?>
        </form>
      </div>
    </main>
  <?php
  endif;
else:
  //ターンイベントの抽選（接敵フラグorアイテム）
  //接敵フラグの判定
  if($enemies_flg == 1):
    //接敵イベントへ
    require_once "tmp/battle.php";
  else:
    //接敵フラグを抽選、当たれば加算。
    $enemies_lottery = mt_rand(1,10);
    if($panic_flg):
      if($enemies_lottery <= 8)://確率80％（マップごとの確率を倍とかの方がいいかも
        $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemies_flg`=1 WHERE `username`=:username");
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $stmt = null;
      endif;
    else:
      if($enemies_lottery <= 3)://確率30％！！！！！！！！マップごとに確率もってDBから持ってきたい
        $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemies_flg`=1 WHERE `username`=:username");
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $stmt = null;
        echo "<br>接敵フラグ＋１<br>";//////////////////////////////////////////////////////けす
      endif;
    endif;
    //接敵イベントなければイベント抽選（パニック時どうするか未定・・・・・・・・・・・・
    $event_lottery = mt_rand(1,10);
    if($event_lottery <= 3)://確率30％！！！！！！！！マップごとに確率もってDBから持ってきたい
      require_once "tmp/event.php";
    else:
      //パニックなら操作不能
      if($panic_flg):
        //強制で休む
        $now_ap += 1;
        $now_sp += 1;
        $now_turn += 1;
        ?>
        <main>
          <div>
            <p>パニックで動けない……。</p>
            <a href="turn.php">次のターンへ</a>
          </div>
        </main>
        <?php
      else:
      //行動選択画面を表示
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `action_flg`=1 WHERE `username`=:username");
      $stmt->bindParam(":username",$_SESSION["username"]);
      $stmt->execute();
      $stmt = null;
      ?>
    <main>
      <div>
        <form action="action.php" method="post" id="action">
          <button type="submit" name="action" value="move" class="action_btn">先へ進む</button><br>
          <button type="submit" name="action" value="rest" class="action_btn">休憩する</button><br>
      <?php
        $stmt = $pdo->prepare("SELECT `now_adv` FROM `user_save_tbl` WHERE `username`=:username");
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result["now_adv"] >= 1):  
      ?>
          <button type="submit" name="action" value="return" class="action_btn">道を戻る</button><br>
  <?php
  endif;
  $stmt = null;
  ?>
        </form>
      </div>
    </main>
      <?php
      endif;
    endif;
  endif;
endif;
?>
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