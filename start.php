<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

//既にセーブがある場合、破棄するか確認
$stmt = $pdo->prepare("SELECT * FROM `user_save_tbl` WHERE `username`=:username");
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
        <p><i class="fas fa-exclamation-triangle"></i> ご注意下さい <i class="fas fa-exclamation-triangle"></i></p>
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
else:
$stmt = null;
//マップの取得
$map_namearr = array();
$stmt = $pdo->prepare("SELECT `map_id`,`map_name` FROM `map_tbl`");
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
                  <tr>
                    <td>
                      <p class="skill_h"><i class="fas fa-toolbox"></i> <?php echo $skill_namearr[1]; ?></p>
                      <p class="skill_d"><?php echo $skill_effectarr[1]; ?><br>（使用間隔<?php echo $skill_recastarr[1]; ?>T）</p>
                    </td>
                    <td>
                      <p class="skill_h"><i class="fas fa-toolbox"></i> <?php echo $skill_namearr[2]; ?></p>
                      <p class="skill_d"><?php echo $skill_effectarr[2]; ?><br>（使用間隔<?php echo $skill_recastarr[1]; ?>T）</p>
                    </td>
                    <td>
                      <p class="skill_h"><i class="fas fa-toolbox"></i> <?php echo $skill_namearr[3]; ?></p>
                      <p class="skill_d"><?php echo $skill_effectarr[3]; ?><br>（使用間隔<?php echo $skill_recastarr[1]; ?>T）</p>
                    </td>
                    <td>
                      <p class="skill_h"><i class="fas fa-toolbox"></i> <?php echo $skill_namearr[4]; ?></p>
                      <p class="skill_d"><?php echo $skill_effectarr[4]; ?><br>（使用間隔<?php echo $skill_recastarr[1]; ?>T）</p>
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
  </body>
</html>
<?php endif; ?>