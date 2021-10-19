<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/charaarr.php";

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
$stmt = null;
?>
<p>現在の所持ポイント：<?php echo $point; ?></p>
<h2>キャラの復活</h2>
<p>探索中に失ったキャラクターを復活させます。</p>
<?php if($lost_a == 0 and $lost_t == 0 and $lost_m == 0 and $lost_y == 0): ?>
<p>復活が必要なキャラはいません。</p>
<?php else: ?>
  <form action="reborn.php" method="post">
    <table>
  <?php if($lost_a == 1): ?>
      <tr>
        <th>
          <?php if($point < 10): ?>
          -
          <?php else: ?>
          <input type="radio" name="reborn" value="1">
          <?php endif; ?>
          <?php echo $charaarr[1]; ?>を復活させる
        </th>
        <td>10ポイント消費</td>
      </tr>
  <?php
  endif;
  if($lost_t == 1):
  ?>
      <tr>
        <th>
          <?php if($point < 10): ?>
          -
          <?php else: ?>
          <input type="radio" name="reborn" value="2">
          <?php endif; ?>
          <?php echo $charaarr[2]; ?>を復活させる
        </th>
        <td>10ポイント消費</td>
      </tr>
  <?php
  endif;
  if($lost_m == 1):
  ?>
      <tr>
        <th>
          <?php if($point < 10): ?>
          -
          <?php else: ?>
          <input type="radio" name="reborn" value="3">
          <?php endif; ?>
          <?php echo $charaarr[3]; ?>を復活させる
        </th>
        <td>10ポイント消費</td>
      </tr>
      <?php
  endif;
  if($lost_y == 1):
  ?>
      <tr>
        <th>
          <?php if($point < 10): ?>
          -
          <?php else: ?>
          <input type="radio" name="reborn" value="4">
          <?php endif; ?>
          <?php echo $charaarr[4]; ?>を復活させる
        </th>
        <td>10ポイント消費</td>
      </tr>
  <?php endif; ?>
      <tr>
        <td colspan="2"><input type="submit" value="購入する"></td>
      </tr>
    </table>
  </form>
  <?php if($point < 10): ?>
    <p>！！！ポイントが足りません！！！</p>
  <?php endif; ?>
<?php endif; ?>

<h2>キャラのステータス強化</h2>
<p>準備中。。。</p>
<h2>キャラの着替え</h2>
<p>準備中。。。</p>

<a href="index.php">TOP画面へ</a>