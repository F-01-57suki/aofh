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
        <p>パニックで動けない……。</p>
      </div>
      <div>
        <a href="turn.php" class="next_turn">次のターンへ</a>
      </div>
    </main>
    <?php
  else:
  //行動選択画面を表示
  ?>
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
    //接敵イベントをセット
    if($enemy_id == 0):
      //敵を抽選し、セーブにセット
      require_once "tmp/enemy_set.php";
    endif;
    //敵パラメータを取得
    $stmt = $pdo->prepare("SELECT `enemy_name`,`enemy_type`,`enemy_speed`,`enemy_wisdom`,`add_damage`,`add_fear` FROM `enemy_tbl` WHERE `enemy_id`=:enemy_id");
    $stmt->bindParam(":enemy_id",$enemy_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //セッションに一時格納
    $_SESSION["enemy_name"] = $result["enemy_name"];
    $_SESSION["enemy_type"] = $result["enemy_type"];
    $_SESSION["enemy_speed"] = $result["enemy_speed"];
    $_SESSION["enemy_wisdom"] = $result["enemy_wisdom"];
    $_SESSION["add_damage"] = $result["add_damage"];
    $_SESSION["add_fear"] = $result["add_fear"];
    $_SESSION["chara_id"] = $chara_id;
    $_SESSION["chara_speed"] = $chara_speed;
    $_SESSION["chara_stealth"] = $chara_stealth;
    $stmt = null;
    ?>
        <form action="battle.php" method="post" id="action">
    <?php
    if($_SESSION["chara_id"] == 4 and $_SESSION["enemy_type"] != "ghost"):
      ?>
          <button type="submit" name="battle" value="kill" class="action_btn">撃破</button><br>
      <?php
    elseif($_SESSION["chara_id"] == 2 and $_SESSION["enemy_type"] == "ghost"):
      ?>
      <button type="submit" name="battle" value="purify" class="action_btn">お祓い</button><br>
      <?php
    endif;
    $stmt = null;
    ?>
          <button type="submit" name="battle" value="stealth" class="action_btn">隠れる</button><br>
          <button type="submit" name="battle" value="speed" class="action_btn">逃げる</button><br>
        </form>
      </div>
      <div><p>異質な気配が近付く……。<br><span class="system_span">SAN値が<?php echo $_SESSION["add_fear"]; ?>減少。</span></p></div>
    </main>
    <?php
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
        $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $stmt = null;
        ?>
            <p>パニックで動けない……。</p>
          </div>
          <div>
            <a href="turn.php" class="next_turn">次のターンへ</a>
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
    </script>
  </body>
</html>