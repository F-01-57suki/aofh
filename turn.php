<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/turn_set.php";

if($action_flg):
  //パニックなら操作不能
  if($panic_flg):
    //強制で休む
    if($now_recast == 0):
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
    else:
      $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1 WHERE `username`=:username");
    endif;
    $stmt->bindParam(":username",$_SESSION["username"]);
    $stmt->execute();
    $stmt = null;
    ?>
        <section>
          <h2 class="eve_h2 ng">‐パニック発生中‐</span></h2>
            <p>&emsp;うまく息ができない……。なすすべもなく、その場にうずくまった。<br><span class="system_span">&emsp;APが1回復。SPが1回復。</span></p>
          <a href="turn.php" class="next_turn">次のターンへ</a>
        </section>
      </div>
      <div>
        <a href="turn.php" class="next_turn">次のターンへ</a>
      </div>
    </main>
    <?php
  else:
  //行動選択画面を表示
  ?>
        <section>
          <h2 class="eve_h2">‐行動を選択‐</span></h2>
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
        </section>
      </div>
    </main>
  <?php
  endif;
else:
  //ターンイベントの抽選（接敵フラグorアイテム）
  //接敵フラグの判定
  if($enemies_flg == 1):
    $firstmessage = 0;
    //接敵イベントをセット
    if($enemy_id == 0):
      $firstmessage = 1;
      //敵を抽選し、セーブにセット
      require_once "tmp/enemy_set.php";
?>
<script>
  const battle_ui = document.getElementById("battle_ui");
  battle_ui.style.display = "block";
if(panic_flg == 0){
  const charaimg = document.getElementById("charaimg");
  charaimg.src = "images/dkdk_<?php echo $chara_id; ?>.png";
}
</script>
<?php
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
    <script>
      battle_ui.style.backgroundImage = "url(images/<?php echo $_SESSION["enemy_type"]; ?>.jpg)";
    </script>
        <form action="battle.php" method="post" id="action">
        <h2 class="eve_h2 ng">‐行動を選択‐</span></h2>
    <?php
    //赤羽スキル選択
    if($_SESSION["chara_id"] == 4 and $_SESSION["enemy_type"] != "ghost" and $now_recast == 0):
      ?>
          <button type="submit" name="battle" value="kill" class="action_btn">撃破</button><br>
      <?php
    //蘆野スキル選択
    elseif($_SESSION["chara_id"] == 2 and $_SESSION["enemy_type"] == "ghost" and $now_recast == 0):
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
      <div>
        <?php if($firstmessage == 1): ?>
        <p>その恐ろしい姿に、背筋が凍った……。<br><span class="system_span">SPが<?php echo $_SESSION["add_fear"]; ?>減少。</span></p>
        <?php else: ?>
        <p>何度も失敗はできない。どうすべきだろうか……？</p>
        <?php endif; ?>
      </div>
    </main>
    <?php
  else:
    //接敵フラグを抽選、当たれば加算。
    $enemies_lottery = mt_rand(1,10);
    if($panic_flg):
      if($enemies_lottery <= ($enemy_rand+1))://通常確率の10%増
        $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemies_flg`=1 WHERE `username`=:username");
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $stmt = null;
        //感知（新城のみ）
        require_once "tmp/skill_id1.php";
      endif;
    else:
      if($enemies_lottery <= $enemy_rand)://マップごとDBに持っている確率
        $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemies_flg`=1 WHERE `username`=:username");
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $stmt = null;
        //感知（新城のみ）
        require_once "tmp/skill_id1.php";
      endif;
    endif;
    //接敵イベントなければイベント抽選（パニック時どうするか未定・・・・・・・・・・・・
    $event_lottery = mt_rand(1,10);
    if($event_lottery <= $event_rand)://マップごとDBに持っている確率
      require_once "tmp/event.php";
    else:
      //パニックなら操作不能
      if($panic_flg):
        //強制で休む
        if($now_recast == 0):
          $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1 WHERE `username`=:username");
        else:
          $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_ap`=`now_ap`+1,`now_sp`=`now_sp`+1,`now_turn`=`now_turn`+1,`now_recast`=`now_recast`-1 WHERE `username`=:username");
        endif;
        $stmt->bindParam(":username",$_SESSION["username"]);
        $stmt->execute();
        $stmt = null;
        ?>
            <section>
              <h2 class="eve_h2 ng">‐パニック発生中‐</span></h2>
              <p>&emsp;うまく息ができない……。なすすべもなく、その場にうずくまった。<br><span class="system_span">&emsp;APが1回復。SPが1回復。</span></p>
              <a href="turn.php" class="next_turn">次のターンへ</a>
            </section>
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
      <section>
        <h2 class="eve_h2">‐行動を選択‐</span></h2>
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
        </section>
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
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>