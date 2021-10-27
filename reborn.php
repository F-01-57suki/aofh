<?php
require_once "tmp/post.php";
require_once "tmp/session_in.php";
//選択せずボタンを押した際は弾く
if(!isset($_POST["reborn"])):
  header('Location: shop.php');
  die();
endif;
require_once "tmp/db.php";

//リロード対策（ロストフラグを配列へ、復活キャラと照合してフラグ0なら処理なし
$stmt = $pdo->prepare("SELECT `lost_a`,`lost_t`,`lost_m`,`lost_y` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$lost_a = $result["lost_a"];
$lost_t = $result["lost_t"];
$lost_m = $result["lost_m"];
$lost_y = $result["lost_y"];
$lostarr = array(null,$lost_a,$lost_t,$lost_m,$lost_y);
$stmt = null;
$lostkey = $_POST["reborn"];
if($lostarr[$lostkey] == 0):
  $pdo = null;
  header('Location: shop.php');
  die();
endif;

//商品の取得
$stmt = $pdo->prepare("SELECT `sell_name`,`sell_price` FROM `shop_tbl` WHERE `sell_id`=:sell_id");
$stmt->bindParam(":sell_id",$_POST["reborn"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$sell_name = $result["sell_name"];
$sell_price = $result["sell_price"];
$stmt = null;

//ポイントを差し引きとニュース入れ込み
$news = "reborn_c".$_POST["reborn"];
$stmt = $pdo->prepare("UPDATE `user_tbl` SET `point`=`point`-:point,`news`=:news WHERE `username`=:username");
$stmt->bindParam(":point",$sell_price);
$stmt->bindParam(":news",$news);
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
//最新の所持ポイントを取得
$stmt = $pdo->prepare("SELECT `point` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$point = $result["point"];
$stmt = null;

//ロストフラグをオフ
if($_POST["reborn"] == 1):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_a`=0 WHERE `username`=:username");
elseif($_POST["reborn"] == 2):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_t`=0 WHERE `username`=:username");
elseif($_POST["reborn"] == 3):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_m`=0 WHERE `username`=:username");
elseif($_POST["reborn"] == 4):
  $stmt = $pdo->prepare("UPDATE `user_tbl` SET `lost_y`=0 WHERE `username`=:username");
endif;
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
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
  <body id="shop">
    <div id="wrapper">
      <header>
        <h1><a href="index.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
        <p>‐購入完了‐</p>
      </header>
      <main>
        <div>
        <p id="nowp"><i class="fas fa-coins"></i> 所持ポイント <i class="fas fa-ellipsis-h"></i> <?php echo $point; ?>ｐ</p>
        <p><?php echo $sell_price; ?>ポイントを消費し、<?php echo $sell_name; ?>しました。</p>
        <a href="shop.php">もどる</a>
        </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>