<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

//既にセーブがある場合、破棄するか確認
$stmt = $pdo->prepare("SELECT `save_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>AVACHIofHORROR（仮）</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body id="restart">
    <div id="wrapper">
      <header>
        <h1><a href="index.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
        <p><i class="fas fa-exclamation-triangle fa-fw"></i> ご注意下さい <i class="fas fa-exclamation-triangle fa-fw"></i></p>
      </header>
      <main>
        <p>進行中のセーブデータがあります！<br><span>現在のセーブを破棄し</span>、新たにゲームを開始しますか？</p>
        <form action="restart.php" method="post">
          <input type="submit" value="破棄して開始" class="btnstyle">
        </form>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>
<?php
  $stmt = null;
  $pdo = null;
else:
  $stmt = null;
  //マップの取得
  $map_namearr = array();
  $stmt = $pdo->prepare("SELECT `map_id`,`map_name` FROM `map_tbl` ORDER BY `map_id` ASC");
  $stmt->execute();
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)):
    $mapkey = $result["map_id"];
    $map_namearr[$mapkey] = $result["map_name"];
  endwhile;
  $stmt = null;
  //スキルの取得
  $skill_namearr = array();
  $skill_effectarr = array();
  $skill_recastarr = array();
  $stmt = $pdo->prepare("SELECT `skill_name`,`skill_effect`,`skill_recast`,`chara_id` FROM `skill_tbl`");
  $stmt->execute();
  while($result = $stmt->fetch(PDO::FETCH_ASSOC)):
    $chara_id = $result["chara_id"];
    $skill_namearr[$chara_id] = $result["skill_name"];
    $skill_effectarr[$chara_id] = $result["skill_effect"];
    $skill_recastarr[$chara_id] = $result["skill_recast"];
  endwhile;
  $stmt = null;
  //キャラデータの確認
  $stmt = $pdo->prepare("SELECT `lost_a`,`lost_t`,`lost_m`,`lost_y` FROM `user_tbl` WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  foreach($result as $key => $value):
    $$key = $value;//キャラ名変数に生存フラグを入れる
  endforeach;
  $stmt = null;
  //キャラステータスの取得
  $cidarr = array("a" => "1","t" => "2","m" => "3","y" => "4");
  foreach($cidarr as $key => $value):
    $cstarr["$key"] = array("chara_id" => "$value");
    $stmt = $pdo->prepare("SELECT `chara_ap`,`chara_sp`,`chara_speed`,`chara_stealth` FROM `chara_tbl` WHERE `chara_id`=:chara_id");
    $stmt->bindParam(":chara_id",$cstarr["$key"]["chara_id"]);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $cstarr["$key"]["chara_ap"] = $result["chara_ap"];
    $cstarr["$key"]["chara_sp"] = $result["chara_sp"];
    $cstarr["$key"]["chara_speed"] = $result["chara_speed"];
    $cstarr["$key"]["chara_stealth"] = $result["chara_stealth"];
    $stmt = null;
    //ゲージ算出
    $cstarr["$key"]["ap_gage"] = ($cstarr["$key"]["chara_ap"] / 40) * 100;
    $cstarr["$key"]["sp_gage"] = ($cstarr["$key"]["chara_sp"] / 40) * 100;
    $cstarr["$key"]["speed_gage"] = ($cstarr["$key"]["chara_speed"] / 10) * 100;
    $cstarr["$key"]["stealth_gage"] = ($cstarr["$key"]["chara_stealth"] / 10) * 100;
  endforeach;
  $pdo = null;
  ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="start">
      <div id="wrapper">
        <header>
          <h1><a href="index.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
          <p>‐選択して下さい‐</p>
        </header>
        <main>
          <div>
            <form action="start_check.php" method="post">
              <table>
              <tr><th>Stage Select</th></tr>
                <tr><td>
                  <select name="stage">
                  <?php foreach($map_namearr as $key => $value): ?>
                  <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
                </td></tr>
                <tr><th>Character Select</th></tr>
                <tr><td id="charaSelect">
                  <table>
                    <tr>
                      <th>新 城<br><span>-Sinjo-</span></th>
                      <th>蘆 野<br><span>-Ashino-</span></th>
                      <th>狩 場<br><span>-Kariba-</span></th>
                      <th>赤 羽<br><span>-Akaha-</span></th>
                    </tr>
                    <tr>
                      <td><?php if($lost_a == 0): ?>
                        <img src="images/chara_a1.png" alt="キャラ画像（新城）"><?php else: ?>
                        <img src="images/chara_a0.png" alt="キャラ画像（新城）"><?php endif; ?>
                      </td>

                      <td><?php if($lost_t == 0): ?>
                        <img src="images/chara_t1.png" alt="キャラ画像（蘆野）"><?php else: ?>
                        <img src="images/chara_t0.png" alt="キャラ画像（蘆野）"><?php endif; ?>
                      </td>

                      <td><?php if($lost_m == 0): ?>
                        <img src="images/chara_m1.png" alt="キャラ画像（狩場）"><?php else: ?>
                        <img src="images/chara_m0.png" alt="キャラ画像（狩場）"><?php endif; ?>
                      </td>

                      <td><?php if($lost_y == 0): ?>
                        <img src="images/chara_y1.png" alt="キャラ画像（赤羽）"><?php else: ?>
                        <img src="images/chara_y0.png" alt="キャラ画像（赤羽）"><?php endif; ?>
                      </td>
                    </tr>
                    <tr id="cst_ap">
                      <td>
                        <div>
                          <i class="fas fa-heartbeat fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="aap_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-heartbeat fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="tap_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-heartbeat fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="mrap_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-heartbeat fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="yap_gage"></div></div>
                        </div>
                      </td>
                    </tr>
                    <tr id="cst_sp">
                      <td>
                        <div>
                          <i class="fas fa-brain fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="asp_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-brain fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="tsp_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-brain fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="msp_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-brain fa-fw fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="ysp_gage"></div></div>
                        </div>
                      </td>
                    </tr>
                    <tr id="cst_speed">
                      <td>
                        <div>
                          <i class="fas fa-running fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="aspeed_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-running fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="tspeed_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-running fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="mspeed_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="fas fa-running fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="yspeed_gage"></div></div>
                        </div>
                      </td>
                    </tr>
                    <tr id="cst_stealth">
                      <td>
                        <div>
                          <i class="far fa-eye-slash fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="astealth_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="far fa-eye-slash fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="tstealth_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="far fa-eye-slash fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="mstealth_gage"></div></div>
                        </div>
                      </td>
                      <td>
                        <div>
                          <i class="far fa-eye-slash fa-fw"></i>&ensp;
                          <div class="gage_all"><div id="ystealth_gage"></div></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p class="skill_h"><i class="fas fa-toolbox fa-fw"></i> <?php echo $skill_namearr[1]; ?></p>
                        <p class="skill_d"><?php echo $skill_effectarr[1]; ?><br>（使用間隔<?php echo $skill_recastarr[1]; ?>T）</p>
                      </td>
                      <td>
                        <p class="skill_h"><i class="fas fa-toolbox fa-fw"></i> <?php echo $skill_namearr[2]; ?></p>
                        <p class="skill_d"><?php echo $skill_effectarr[2]; ?><br>（使用間隔<?php echo $skill_recastarr[2]; ?>T）</p>
                      </td>
                      <td>
                        <p class="skill_h"><i class="fas fa-toolbox fa-fw"></i> <?php echo $skill_namearr[3]; ?></p>
                        <p class="skill_d"><?php echo $skill_effectarr[3]; ?><br>（使用間隔<?php echo $skill_recastarr[3]; ?>T）</p>
                      </td>
                      <td>
                        <p class="skill_h"><i class="fas fa-toolbox fa-fw"></i> <?php echo $skill_namearr[4]; ?></p>
                        <p class="skill_d"><?php echo $skill_effectarr[4]; ?><br>（使用間隔<?php echo $skill_recastarr[4]; ?>T）</p>
                      </td>
                    </tr>
                    <tr>
                      <td><?php if($lost_a == 0): ?>
                        <input type="radio" name="chara" value="1" required="required"><?php else: ?>
                        <p class="lost_p">選択不可</p><?php endif; ?>
                      </td>
                      <td><?php if($lost_t == 0): ?>
                        <input type="radio" name="chara" value="2"><?php else: ?>
                        <p class="lost_p">選択不可</p><?php endif; ?>
                      </td>
                      <td><?php if($lost_m == 0): ?>
                        <input type="radio" name="chara" value="3"><?php else: ?>
                        <p class="lost_p">選択不可</p><?php endif; ?>
                      </td>
                      <td><?php if($lost_y == 0): ?>
                        <input type="radio" name="chara" value="4"><?php else: ?>
                        <p class="lost_p">選択不可</p><?php endif; ?></td>
                    </tr>
                  </table>
                </td></tr>
                <tr>
                  <td colspan="2" id="btn">
                    <input type="submit" value="確認画面へ" class="btnstyle">
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <?php require_once "tmp/ng_js.php"; ?>
      <script>
      const aap_gage = document.getElementById("aap_gage");
      aap_gage.style.width = "<?php echo $cstarr["a"]["ap_gage"]; ?>%";
      const asp_gage = document.getElementById("asp_gage");
      asp_gage.style.width = "<?php echo $cstarr["a"]["sp_gage"]; ?>%";
      const aspeed_gage = document.getElementById("aspeed_gage");
      aspeed_gage.style.width = "<?php echo $cstarr["a"]["speed_gage"]; ?>%";
      const astealth_gage = document.getElementById("astealth_gage");
      astealth_gage.style.width = "<?php echo $cstarr["a"]["stealth_gage"]; ?>%";

      const tap_gage = document.getElementById("tap_gage");
      tap_gage.style.width = "<?php echo $cstarr["t"]["ap_gage"]; ?>%";
      const tsp_gage = document.getElementById("tsp_gage");
      tsp_gage.style.width = "<?php echo $cstarr["t"]["sp_gage"]; ?>%";
      const tspeed_gage = document.getElementById("tspeed_gage");
      tspeed_gage.style.width = "<?php echo $cstarr["t"]["speed_gage"]; ?>%";
      const tstealth_gage = document.getElementById("tstealth_gage");
      tstealth_gage.style.width = "<?php echo $cstarr["t"]["stealth_gage"]; ?>%";

      const mrap_gage = document.getElementById("mrap_gage");
      mrap_gage.style.width = "<?php echo $cstarr["m"]["ap_gage"]; ?>%";
      const msp_gage = document.getElementById("msp_gage");
      msp_gage.style.width = "<?php echo $cstarr["m"]["sp_gage"]; ?>%";
      const mspeed_gage = document.getElementById("mspeed_gage");
      mspeed_gage.style.width = "<?php echo $cstarr["m"]["speed_gage"]; ?>%";
      const mstealth_gage = document.getElementById("mstealth_gage");
      mstealth_gage.style.width = "<?php echo $cstarr["m"]["stealth_gage"]; ?>%";

      const yap_gage = document.getElementById("yap_gage");
      yap_gage.style.width = "<?php echo $cstarr["y"]["ap_gage"]; ?>%";
      const ysp_gage = document.getElementById("ysp_gage");
      ysp_gage.style.width = "<?php echo $cstarr["y"]["sp_gage"]; ?>%";
      const yspeed_gage = document.getElementById("yspeed_gage");
      yspeed_gage.style.width = "<?php echo $cstarr["y"]["speed_gage"]; ?>%";
      const ystealth_gage = document.getElementById("ystealth_gage");
      ystealth_gage.style.width = "<?php echo $cstarr["y"]["stealth_gage"]; ?>%";
      </script>
    </body>
  </html>
<?php endif; ?>