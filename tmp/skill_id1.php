<?php
if($chara_id == 1 and $now_recast == 0):
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
  //セーブのnow_recastに加算＆アクションフラグ加算
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_recast`=:skill_recast,`action_flg`=1 WHERE `username`=:username");
  $stmt->bindParam(":skill_recast",$skill_recast);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  ?>
            <section>
              <h2 class="eve_h2 sp">スキル発動<br><span class="eve_span">‐壊れたラジオ‐</span></h2>
              <p class="eve_p">&emsp;突如、ラジオから耳障りなノイズが鳴り始めた……。なぜか無性に胸騒ぎがする！<br><span class="system_span">&emsp;先に進むと怪異に遭遇、戻ると回避。</span></p>
              <a href="turn.php" class="next_turn">行動選択へ</a>
            </section>
          </div>
        </main>
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
<?php
  die();
endif;
?>