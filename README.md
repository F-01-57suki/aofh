# テストアカウント（操作OK）
- アカウント名：TestUser2021
- パスワード　：TestPass2021

# ざっくり仕様書
https://docs.google.com/spreadsheets/d/1BrBSshVTCp64pC4j-CoL7JSLQ-Z7XwNmtkTqi2f1U08/edit?usp=sharing
- DBのテーブル構成
- キャラ/スキル一覧
  - マップ一覧、敵一覧を作成予定…

# 現在の進捗
- 登録～チュートリアル～ゲーム内容まで一通り
- マップID１完成

# 今後の実装予定
- SPの下限
- マップID2～3の実装
- ランキング同率○位の処理について考える（今どうなってるか調査含め
- イベントごとに発生確率を設定できるようにする
	- レコード毎に確率持って計10に調整？考え中・・・・
- ショップ（キャラ強化・着替えの追加）
- ゲームバランスの調整

## 確認済みの不具合
### 修正完了
- イベントによる進捗増で、残距離を超えマイナスに突入
- クリア後にイベント抽選が発生し、クリアターンが増加
- パニック時に接敵フラグが経っていても接敵しない
