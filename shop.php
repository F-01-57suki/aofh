<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

//所持ポイントの取得
$stmt = $pdo->prepare("SELECT `point` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$point = $result["point"];
$stmt = null;

//ロストキャラの取得
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

//商品一覧を取得
//キャラ復活
$reborn = "reborn";
$sell_name_reborn = array(0 => null);
$sell_price_reborn = array(0 => null);
$stmt = $pdo->prepare("SELECT `sell_id`,`sell_name`,`sell_price` FROM `shop_tbl` WHERE `sell_type`=:sell_type");
$stmt->bindParam(":sell_type",$reborn);
$stmt->execute();
while($result = $stmt->fetch(PDO::FETCH_ASSOC)):
  $sellkey = $result["sell_id"];
  $sell_name_reborn[$sellkey] = $result["sell_name"];
  $sell_price_reborn[$sellkey] = $result["sell_price"];
endwhile;
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
        <p>‐Pショップ‐</p>
      </header>
      <main>
        <div>
          <p id="nowp"><i class="fas fa-coins"></i> 所持ポイント <i class="fas fa-ellipsis-h"></i> <?php echo $point; ?>ｐ</p>
          <h2>キャラクターの復活</h2>
          <p>探索中に失ったキャラクターを復活させます。</p>
          <?php if($lost_a == 0 and $lost_t == 0 and $lost_m == 0 and $lost_y == 0): ?>
          <p class="shop_nop">現在、復活が必要なキャラはいません。</p>
          <?php else: ?>
            <form action="reborn.php" method="post">
              <table>
              <?php
              foreach($lostarr as $key => $value):
                if($value == 1):
              ?>
                <tr>
                  <th>
                  <?php if($point < $sell_price_reborn[$key]): ?>
                    -
                  <?php else: ?>
                    <input type="radio" name="reborn" value="<?php echo $key; ?>">
                  <?php
                  endif;
                  echo $sell_name_reborn[$key];
                  ?>
                  </th>
                  <td><?php echo $sell_price_reborn[$key]; ?>ｐ消費</td>
                </tr>
              <?php
                endif;
              endforeach;
              ?>
                <tr>
                  <td colspan="2"><input type="submit" value="購入する" class="btnstyle"></td>
                </tr>
              </table>
            </form>
          <?php endif; ?>

          <h2>キャラクターの強化</h2>
          <p>キャラのステータスやスキルを強化します。</p>
          <p class="shop_nop">購入可能な商品がありません。</p>
          <h2>キャラクターの着替え</h2>
          <p>キャラの服装を変更します。</p>
          <p class="shop_nop">購入可能な商品がありません。</p>
        </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>