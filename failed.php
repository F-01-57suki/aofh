<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
/*
//セーブデータを取得
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result):
  header('Location: index.php');
  die();
else:
  $map_id = $result["map_id"];
  $chara_id = $result["chara_id"];
  $stmt = null;
endif;

//ニュース入れ込み
$news = "lost_m".$map_id."_c".$chara_id;//lost_m0_c0

//キャラのロストフラグ入れ込み
if($chara_id == 1):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_a`=1,`news`=:news WHERE `username`=:username");
elseif($chara_id == 2):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_t`=1,`news`=:news WHERE `username`=:username");
elseif($chara_id == 3):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_m`=1,`news`=:news WHERE `username`=:username");
elseif($chara_id == 4):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_y`=1,`news`=:news WHERE `username`=:username");
endif;
$stmt->bindParam(":news",$news);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//セーブ削除
$stmt = $pdo->prepare("DELETE FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
*/
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>AVACHIofHORROR（仮）</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body id="shop">
    <div id="wrapper">
      <header>
        <h1><a href="index.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
        <p>‐ゲームオーバー‐</p>
      </header>
      <main>
        <div>
          <h2>今回のスコア</h2>
          <table>
            <tr>
              <th>総ターン数：</th><td>ほにゃ</td>
            </tr>
            <tr>
              <th>進んだ距離：</th><td>ほにゃ/ほにゃ</td>
            </tr>
          </table>
          <p class="shop_nop">「キャラ名」が使用不可になりました。</p>
          <p>※ショップでポイントを支払って復活できます。</p>
          <a href="start.php">もう一度挑戦する</a>
        </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
  </body>
</html>