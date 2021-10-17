<?php
//セーブの取得（なかったら弾く）
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id`,`now_adv`,`now_turn`,`now_ap`,`now_sp`,`panic_flg`,`now_recast`,`enemies_flg`,`action_flg` FROM `user_save_tbl` WHERE `username`=:username");
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

//キャラやスキルの取得
//まだ・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//まだ・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・
//まだ・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・

//ゲームオーバー判定
if($now_ap == 0):
  header('Location: failed.php');
endif;

//クリア判定
//now_advがmap_sizeに到達したか？
if($now_adv == $map_size):
  //リザルト表示へ（そっちで評価出してポイント加算してセーブ消す）
  header('Location: result.php');
endif;

//パニック判定
if($now_sp == 0 and $panic_flg == 0)://SPが0になった
  //パニックON、SPに-3
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=1,`now_sp`=-3 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
elseif($now_sp == 0 and $panic_flg == 1)://SPが0に戻った
  //パニックフラグOFF、SPに3加算
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=0,`now_sp`=3 WHERE `username`=:username");
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
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
  <body id="newgame">
    <div id="wrapper">
      <header>
        <h1><a href="index.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
        <p>‐行動選択‐</p>
        <div id="map_gage">
          <div id="gage_title"><p>0%&nbsp;&nbsp; </p><p>&nbsp;50%</p><p>100%</p></div>
          <div id="gage_all"><div id="gage_now"></div></div>
          <p>残り：<?php echo $map_remain; ?></p>
        </div>
        <div id="info">
          <p>現在のターン：<?php echo $now_turn; ?></p>
          <p>AP：<?php echo $now_ap; ?>｜SP：<?php
          echo $now_sp;
          if($panic_flg): ?>
          <span id="panic_span">！パニック中！</span>
            <?php endif; ?></p>
        </div>
      </header>