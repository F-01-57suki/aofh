<?php
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `action_flg`=1 WHERE `username`=:username");
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
<?php die(); ?>