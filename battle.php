<?php
//ターン追加
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `now_turn`=`now_turn`+1 WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;

//敵の取得
//敵の抽選
//SAN値チェック
//行動選択
//選択後に別PHPへ飛ばす、以下の処理はそっちへ
echo "接敵イベント未実装";
//赤羽かつゴースト以外なら撃破が選択可能（倍の攻撃を受けて撃破
//芦野かつゴーストなら祓うが選択可能（受けた恐怖値ぶん回復

//逃げる
//スピードが早ければ成功確率上昇（キャラ速度取得して敵速度ぶん減、乱数とってキャラ速度の範囲内なら成功）

//隠れる
//ステルスが高ければ成功確率上昇（キャラステルス取得して敵賢さぶん減、乱数とってキャラステルスの範囲内なら成功）

//行動が失敗した場合、SAN値とダメージ

//ゲームオーバー判定
if($now_ap == 0):
  header('Location: failed.php');
endif;

//終了時に接敵フラグのリセット
$stmt = $pdo->prepare("UPDATE `user_save_tbl` SET `enemies_flg`=0 WHERE `username`=:username");
$stmt->bindParam(":username",$_SESSION["username"]);
$stmt->execute();
$stmt = null;
?>