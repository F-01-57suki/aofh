<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

$contflag = 1;
//途中セーブの確認
$stmt = $pdo->prepare("SELECT * FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $contflag = 1;
else:
  $contflag = 0;
endif;
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>AVACHIofHORROR（仮）‐メニュー</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body id="index">
    <div id="wrapper">
      <header>
        <div>
          <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
          <p><?php echo $_SESSION['username']; ?>でログイン中</p>
        </div>
        <nav>
          <ul>
            <li><a href="start.php">Start</a></li>
            <li><a href="continue.php" id="contli">Continue<span id="contspn"><i class="fas fa-exclamation-triangle"></i> 進行中</span></a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="logout.php">Exit</a></li>
          </ul>
        </nav>
      </header>
      <main>
        <div>
          <img src="images/top.png" alt="TOP画像"><!--進行度やshopの購入状況で変わる-->
          <section>
            <h2>進行状況</h2>
            <dl>
              <dt><i class="fas fa-coins"></i> 所持ポイント</dt>
              <dd><i class="fas fa-ellipsis-h"></i> 1000p</dd>
              <dt><i class="fas fa-heartbeat"></i> 生存キャラ</dt>
              <dd><i class="fas fa-ellipsis-h"></i> 4/4</dd>
              <dt><i class="fas fa-eye"></i> クリア状況</dt>
              <dd><i class="fas fa-ellipsis-h"></i> 1/3</dd>
              <dd>
                <table>
                  <caption>‐総合ランキング‐</caption>
                  <tr>
                    <th>マップ名</th>
                    <th>順位</th>
                    <th>スコア</th>
                  </tr>
                  <tr>
                    <td>ほにゃ</td>
                    <td>1位</td>
                    <td>10T</td>
                  </tr>
                  <tr>
                    <td>ららら</td>
                    <td>3位</td>
                    <td>220T</td>
                  </tr>
                  <tr>
                    <td>オーモンド</td>
                    <td>UC</td>
                    <td>0T</td>
                  </tr>
                </table>
              </dd>
            </dl>
          </section>
        </div>
        <div>
          <p class="flavor1">――ここに進行状況に応じたフレーバーテキスト</p>
          <p class="flavor2">なるべく２行でテキスト表示したいというきもち</p>
        </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <script>
      const contli = document.getElementById("contli");
      const contspn = document.getElementById("contspn");
      let contflag = <?php echo $contflag; ?>;
      if(contflag == 1){
        contli.style.textShadow = "0 0 3px rgb(153, 153, 0),0 0 3px rgb(153, 153, 0),0 0 3px rgb(153, 153, 0),0 0 3px rgb(153, 153, 0)";
        contspn.style.display = "block";
      }
    </script>
  </body>
</html>