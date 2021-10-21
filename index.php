<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";

$contflag = 1;
//途中セーブの確認
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $contflag = 1;
  $map_id = $result["map_id"];      //マップの背景用に取得
  $chara_id = $result["chara_id"];  //TOP絵用に取得
  $panic_flg = $result["panic_flg"];//TOP絵用に取得
else:
  $contflag = 0;
endif;
$stmt = null;

//ユーザー情報の取得
$stmt = $pdo->prepare("SELECT `point`,`lost_a`,`lost_t`,`lost_m`,`lost_y`,`news` FROM `user_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
//所持ポイント
$point = $result["point"];
//キャラ生存数
$lost = 4-($result["lost_a"]+$result["lost_t"]+$result["lost_m"]+$result["lost_y"]);
//ユーザニュースの取得
$news = $result["news"];
$stmt = null;

//クリア状況
//マップ数を取得
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `map_tbl`");
$stmt->execute();
$result = $stmt->fetchColumn();
$map_count = $result;
$stmt = null;
//マップごとクリアデータ１つでもあればカウント
$i = 1;
$clear_count = 0;
while($i <= $map_count):
  $stmt = $pdo->prepare("SELECT `clear_id` FROM `clear_save_tbl` WHERE `username`=:username and `map_id`=:map_id");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->bindParam(":map_id",$i);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($result):
    $clear_count++;
  endif;
  $stmt = null;
  $i++;
endwhile;

//ランキングの取得
//考え中・・・・（自分の順位を取得できるか？できなければマップごと一位のみ
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
            <li><a href="shop.php">Shop</a></li>
            <li><a href="#" id="exit">Exit</a></li>
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
              <dd><i class="fas fa-ellipsis-h"></i> <?php echo $point; ?>p</dd>
              <dt><i class="fas fa-heartbeat"></i> 生存キャラ</dt>
              <dd><i class="fas fa-ellipsis-h"></i> <?php echo $lost; ?>/4</dd>
              <dt><i class="fas fa-eye"></i> クリア状況</dt>
              <dd><i class="fas fa-ellipsis-h"></i> <?php echo $clear_count; ?>/<?php echo $map_count; ?></dd>
            </dl>
            <h2 class="h2nplus2">総合ランキング</h2>
            <table>
              <tr>
                <th>マップ名</th>
                <th>順位</th>
                <th>スコア</th>
              </tr>
              <tr>
                <td>-</td>
                <td>-位</td>
                <td>-T</td>
              </tr>
              <tr>
                <td>-</td>
                <td>-位</td>
                <td>-T</td>
              </tr>
              <tr>
                <td>-</td>
                <td>-位</td>
                <td>-T</td>
              </tr>
            </table>
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
      }else{
        contli.onclick = function(){
          alert("セーブがありません。新規セーブを作成してください。");
        }
      }
      const exit = document.getElementById("exit");
      exit.onclick = function(){
        exityn = confirm("ログアウトしてよろしいですか？");
        if(exityn == true){
          location.href = "logout.php";
        }
      }
    </script>
  </body>
</html>