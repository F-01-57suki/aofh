<?php
require_once "tmp/session_in.php";
require_once "tmp/db.php";
//require_once "tmp/maparr.php";
//require_once "tmp/charaarr.php";

//セーブの取得（なかったら弾く）
$stmt = $pdo->prepare("SELECT `map_id`,`chara_id`,`now_adv`,`now_turn`,`now_ap`,`now_sp`,`panic_flg`,`now_recast`,`enemies_flg` FROM `user_save_tbl` WHERE `username`=:username");
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
  $stmt = null;
endif;

//マップの取得
//map_sizeが全体、now_advが進み


//キャラやスキルの取得


//しんだ判定（基本的に接敵イベントの最後に判定するが念のため）
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
  //パニックON、SPに-3　　　　　　　　　　　　　　　　　　　　　　いまここ！！！！！！！！！１１SPまいなす
  $stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `panic_flg`=1,`now_sp`=`now_sp`-3 WHERE `username`=:username");
  $stmt->bindParam(":point",$point);
  $stmt->bindParam(":username",$_SESSION["username"]);
  $stmt->execute();
  $stmt = null;
elseif($now_sp == 0 and $panic_flg == 1)://SPが0に戻った
  //パニックフラグOFF、SPに＋1
endif;

//イベントをカウントする
$event_sum = $event_count+1;


//ターンイベントの抽選（接敵フラグorアイテム）
//接敵フラグの判定
if($enemies_flg == 1):
  //接敵イベントへ
  require_once "tmp/.php";
else:
  //接敵フラグを抽選、当たれば加算。
  $enemies_lottery = mt_rand(0,10);
  if($panic_flg):
    if($enemies_lottery <= 8)://確率80％（マップごとの確率を倍とかの方がいいかも
      $enemies_flg = 1;
    endif;
  else:
    if($enemies_lottery <= 3)://確率30％！！！！！！！！マップごとに確率もってDBから持ってきたい
      $enemies_flg = 1;
    endif;
  endif;
  //接敵イベントなければイベント抽選（パニック時どうするか未定・・・・・・・・・・・・
  $event_lottery = mt_rand(0,10);
  if($event_lottery <= 3)://確率30％！！！！！！！！マップごとに確率もってDBから持ってきたい
    $event_id_lottery = mt_rand(0,$event_sum);//イベントをカウントしてマイナス1する
    if($event_id_lottery == 1):
      //$event_idが1のイベント
    elseif($event_id_lottery == 2):
      //$event_idが2のイベント
    else:
      //$event_idが0のイベント
    endif;
  else:
    require_once "tmp/action.php";//行動選択へ
  endif;
endif;

//
//
//
//
?>