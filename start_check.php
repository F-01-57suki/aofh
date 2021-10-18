<?php
require_once "tmp/post.php";
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/maparr.php";

//選択なければエラー
if(!isset($_POST["chara"]) or !isset($_POST["stage"])):
  $errors["開始設定"] = "ステージとキャラクターを1つずつ選択して下さい。";
  require_once "tmp/error.php";
endif;

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
  </body>
</html>
<?php
endif;
$stmt = null;
//キャラデータの確認
$stmt = $pdo->prepare("SELECT `lost_a`,`lost_t`,`lost_m`,`lost_y` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
foreach($result as $key => $value):
  $$key = $value;//カラム名変数に生存フラグを入れる
endforeach;
$stmt = null;
//もしロストキャラを選んでいたらエラー
if($lost_a == 1 and $_POST["chara"] == 1 or $lost_t == 1 and $_POST["chara"] == 2 or $lost_m == 1 and $_POST["chara"] == 3 or $lost_y == 1 and $_POST["chara"] == 4):
  $errors["キャラクター選択"] = "ロストしているキャラクターです。";
  require_once "tmp/error.php";
endif;
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
        <p>‐以下の内容で開始します‐</p>
      </header>
      <main>
        <div>
          <form action="start_done.php" method="post">
            <table>
            <tr><th>Stage</th></tr>
              <tr><td><?php echo $maparr[$_POST["stage"]]; ?></td></tr>
              <tr><th>Character</th></tr>
              <tr><td id="charaSelect">
                <table>
                  <tr>
                    <?php if($_POST["chara"] == 1): ?>
                    <th>新 城<br><span>-Sinjo-</span></th>
                    <?php elseif($_POST["chara"] == 2): ?>
                    <th>蘆 野<br><span>-Ashino-</span></th>
                    <?php elseif($_POST["chara"] == 3): ?>
                    <th>狩 場<br><span>-Kariba-</span></th>
                    <?php elseif($_POST["chara"] == 4): ?>
                    <th>赤 羽<br><span>-Akaha-</span></th>
                    <?php endif; ?>
                  </tr>
                  <tr>
                    <td>
                    <?php if($_POST["chara"] == 1): ?>
                      <img src="images/chara_a1.png" alt="キャラ（A）">
                    <?php elseif($_POST["chara"] == 2): ?>
                      <img src="images/chara_t1.png" alt="キャラ（T）">
                    <?php elseif($_POST["chara"] == 3): ?>
                      <img src="images/chara_m1.png" alt="キャラ（M）">
                    <?php elseif($_POST["chara"] == 4): ?>
                      <img src="images/chara_y1.png" alt="キャラ（Y）">
                    <?php endif; ?>
                    </td>
                  </tr>
                  <tr>
                    <?php if($_POST["chara"] == 1): ?>
                    <td><p class="skill_h"><i class="fas fa-toolbox"></i> 壊れたラジオ</p><p class="skill_d">接敵前に回避行動が可能<br>（リキャスト5T）</p></td>
                    <?php elseif($_POST["chara"] == 2): ?>
                    <td><p class="skill_h"><i class="fas fa-toolbox"></i> 古びたカメラ</p><p class="skill_d">ゴーストを祓ってSP回復<br>（リキャスト5T）</p></td>
                    <?php elseif($_POST["chara"] == 3): ?>
                    <td><p class="skill_h"><i class="fas fa-toolbox"></i> 茉莉花の髪飾り</p><p class="skill_d">接敵時、逃走確率が上昇<br>（常時発動）</p></td>
                    <?php elseif($_POST["chara"] == 4): ?>
                    <td><p class="skill_h"><i class="fas fa-toolbox"></i> 錆びた鉄パイプ</p><p class="skill_d">HP消費でゴースト以外撃破<br>（常時発動）</p></td>
                    <?php endif; ?>
                  </tr>
                </table>
              </td></tr>
              <tr>
                <td colspan="2" id="btn_c">
                  <input type="hidden" name="stage" value="<?php echo $_POST["stage"]; ?>">
                  <input type="hidden" name="chara" value="<?php echo $_POST["chara"]; ?>">
                  <input type="button" value="戻る" onclick='history.go(-1)' class="btnstyle">
                  <input type="submit" value="開始" class="btnspan">
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
  </body>
</html>