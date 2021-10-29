<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
require_once "tmp/flavorarr.php";

$contflag = 1;
//途中セーブの確認
$stmt = $pdo->prepare("SELECT `save_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $contflag = 1;
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

//マップ名を取得
$mapname_arr = array();
$stmt = $pdo->prepare("SELECT `map_id`,`map_name` FROM `map_tbl`");
$stmt->execute();
while($result = $stmt->fetch(PDO::FETCH_ASSOC)):
  $setid = $result["map_id"];
  $mapname_arr[$setid] = $result["map_name"];
endwhile;
$stmt = null;

//ランキングの取得
//１．クリアデータから、WHEREマップ・ターン昇順に並び替えた結果を全件取得
//２．for回して配列に入れるなり、iでカウントして該当ユーザのデータ出たら止める（iが順位になる）
$mapid_arr = array();
for($i = 1;$i <= $map_count;$i++):
  $mapid_arr[$i] = $i;
endfor;

foreach($mapid_arr as $value):
  $stmt = $pdo->prepare("SELECT `clear_id` FROM `clear_save_tbl` WHERE `map_id`=:map_id AND `username`=:username");
  $stmt->bindParam(":map_id",$value);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($result):
    //該当ユーザ＆マップのクリアデータがある
    $stmt = null;
    $stmt = $pdo->prepare("SELECT `clear_turn`,`username` FROM `clear_save_tbl` WHERE `map_id`=:map_id ORDER BY `clear_turn` ASC");
    $stmt->bindParam(":map_id",$value);
    $stmt->execute();
    for($i = 1;$result = $stmt->fetch(PDO::FETCH_ASSOC);$i++):
      if($result["username"] == $_SESSION["username"]):
        //順位
        $setname = "m".$value."_ranking";
        $$setname = $i;
        //スコア
        $setname = "m".$value."_clear_turn";
        $$setname = $result["clear_turn"];
        break;
      endif;
    endfor;
  else:
    //順位
    $setname = "m".$value."_ranking";
    $$setname = "-";
    //スコア
    $setname = "m".$value."_clear_turn";
    $$setname = "-";
  endif;
endforeach;
$stmt = null;
$pdo = null;
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
          <!--進行度やshopの購入状況で変わる-->
          <img src="images/top_<?php echo $news; ?>.png" alt="TOP画像">
          <section>
            <h2>進行状況</h2>
            <dl>
              <dt><i class="fas fa-coins"></i> 所持ポイント</dt>
              <dd><i class="fas fa-ellipsis-h"></i> <?php echo $point; ?>p</dd>
              <dt><i class="fas fa-eye"></i> 生存キャラ</dt>
              <dd><i class="fas fa-ellipsis-h"></i> <?php echo $lost; ?>/4</dd>
              <dt><i class="fas fa-map"></i> クリア状況</dt>
              <dd><i class="fas fa-ellipsis-h"></i> <?php echo $clear_count; ?>/<?php echo $map_count; ?></dd>
            </dl>
            <h2 class="h2nplus2">総合ランキング</h2>
            <table>
              <tr>
                <th>マップ名</th>
                <th>順位</th>
                <th>スコア</th>
              </tr>
<?php foreach($mapid_arr as $value): ?>
                <tr>
                <td><?php echo $mapname_arr[$value]; ?></td>
  <?php
  $setname = "m".$value."_ranking";
  if($$setname == 1):
  ?>
                <td class="ranking1">
  <?php elseif($$setname == 2): ?>
                <td class="ranking2">
  <?php elseif($$setname == 3): ?>
                <td class="ranking3">
  <?php else: ?>
                <td>
  <?php endif; ?>
                <?php echo $$setname; ?>位</td>
  <?php $setname = "m".$value."_clear_turn"; ?>
                <td><?php echo $$setname; ?>T</td>
              </tr>
<?php endforeach; ?>
            </table>
          </section>
        </div>
        <div>
          <p class='flavor1'><?php echo $flavor[$news][1]; ?></p>
          <p class='flavor2'><?php echo $flavor[$news][2]; ?></p>
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
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>