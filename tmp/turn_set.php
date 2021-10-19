<?php
//セーブの取得（なかったら弾く）
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id`,`now_adv`,`now_turn`,`now_ap`,`now_sp`,`panic_flg`,`now_recast`,`enemies_flg`,`action_flg`,`enemy_id` FROM `user_save_tbl` WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result):
  header('Location: index.php');
  die();
else:
  $map_id = $result["map_id"];
  $chara_id = $result["chara_id"];
  $now_adv = $result["now_adv"];
  $now_turn = $result["now_turn"];
  $now_ap = $result["now_ap"];
  $now_sp = $result["now_sp"];
  $panic_flg = $result["panic_flg"];
  $now_recast = $result["now_recast"];
  $enemies_flg = $result["enemies_flg"];
  $action_flg = $result["action_flg"];
  $enemy_id = $result["enemy_id"];
  $stmt = null;
endif;

//マップの取得
$stmt = $pdo->prepare("SELECT `map_size` FROM `map_tbl` WHERE `map_id`=:map_id");
$stmt->bindParam(":map_id",$map_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$map_size = $result["map_size"];
$stmt = null;
//全体（map_size）から進み（now_adv）を引いて、残り取得
$map_remain = $map_size - $now_adv;
//ある数は全体の何パーセントか？ という計算は ある数 ÷ 全体 ×100. という式
$map_percent = ($now_adv / $map_size) * 100;

//キャラの取得
//スキルは未実装のため、実装後の取得
$stmt = $pdo->prepare("SELECT `chara_ap`,`chara_sp`,`chara_speed`,`chara_stealth` FROM `chara_tbl` WHERE `chara_id`=:chara_id");
$stmt->bindParam(":chara_id",$chara_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$chara_ap = $result["chara_ap"];
$chara_sp = $result["chara_sp"];
$chara_speed = $result["chara_speed"];
$chara_stealth = $result["chara_stealth"];
$stmt = null;

//ゲームオーバー判定
if($now_ap <= 0):
  header('Location: failed.php');
endif;

//クリア判定
//now_advがmap_sizeに到達したか？
if($now_adv == $map_size):
  //リザルト表示へ（そっちで評価出してポイント加算してセーブ消す）
  header('Location: result.php');
endif;

//パニック判定
if($now_sp <= 0 and $panic_flg == 0)://SPが0になった
  //パニックON、ペナルティでSPに-3
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=1,`now_sp`=`now_sp`-3 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  //最新のSPとパニックフラグを再取得
  $stmt = $pdo->prepare("SELECT `now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $now_sp = $result["now_sp"];
  $panic_flg = $result["panic_flg"];
  $stmt = null;
elseif($now_sp >= 0 and $panic_flg == 1)://SPが0に戻った
  //パニックフラグOFF、SPに3加算
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=0,`now_sp`=`now_sp`+1 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
  //最新のSPとパニックフラグを再取得
  $stmt = $pdo->prepare("SELECT `now_sp`,`panic_flg` FROM `user_save_tbl` WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $now_sp = $result["now_sp"];
  $panic_flg = $result["panic_flg"];
  $stmt = null;
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
  <body id="turn">
    <div id="wrapper">
      <header>
        <div>
          <a href="index.php"><h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1></a>
          <p><?php echo $_SESSION['username']; ?>でログイン中</p>
        </div>
        <div id="turn_header">
          <div id="map_gage">
            <div id="gage_title"><p>0%&nbsp;&nbsp; </p><p>&nbsp;50%</p><p>100%</p></div>
            <div id="gage_all"><div id="gage_now"></div></div>
            <p>残りの距離&emsp;<?php echo $map_remain; ?></p>
          </div>
          <div id="info">
            <p>
              ＴＵＲＮ‐ <span id="now_turn"><?php echo $now_turn; ?></span>
            </p>
            <p>
              <i class="fas fa-heartbeat fa-fw"></i> ＡＰ：<span id="now_ap"><?php echo $now_ap; ?></span>
              &emsp;
              <i class="fas fa-brain fa-fw"></i> ＳＰ：<span id="now_sp"><?php echo $now_sp; ?></span>
              <?php if($panic_flg): ?>
              <span id="panic_span"><br><i class="fas fa-exclamation fa-fw"></i>パニック発生<i class="fas fa-exclamation fa-fw"></i></span>
            <?php endif; ?>
            </p>
          </div>
        </div>
      </header>
      <main>
        <div>
          <img src="images/turn_t_n.png" alt="選択キャラクター">
<?php
//////////////////////////////////////////
/*キャラ分画像が出来たら、imgタグの出し分け
if($chara_id == 1):
  if($panic_flg == 1):
    //パニック中
    <img src="images/ほにゃ" alt="選択キャラクター（パニック中）">
  elseif($enemy_id != 0):
    //接敵中
    <img src="images/ほにゃ" alt="選択キャラクター（接敵中）">
  else:
    //通常時
    <img src="images/ほにゃ" alt="選択キャラクター">
  endif;
elseif($chara_id == 2):
elseif($chara_id == 3):
elseif($chara_id == 4):
else:
  die("エラーです");
endif;
*/
//////////////////////////////////////////
?>