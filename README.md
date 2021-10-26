# テストアカウント（操作OK）
- アカウント名：TestUser2021
- パスワード　：TestPass2021

# ざっくり仕様書
https://docs.google.com/spreadsheets/d/1BrBSshVTCp64pC4j-CoL7JSLQ-Z7XwNmtkTqi2f1U08/edit?usp=sharing
- DBのテーブル構成
- キャラ/スキル一覧
  - マップ一覧、敵一覧を作成予定…

# 現在の進捗
- 一通りのゲームの流れ（済）

## 着手中
- スキルのリキャスト処理
- フレーバーテキストを進捗に合わせて出し分け

## 不具合
### 修正済み
- イベントによる進捗増で、残距離を超えマイナスに突入
- クリア後にイベント抽選が発生し、クリアターンが増加

# 今後の実装予定
## 優先度高
- ランキング処理
- HP/SPの回復上限

## 優先度低
- キャラ選択に、各キャラのステータスを表示
- イベントの中身を書く（テキスト内容のみ）
- イベントごとに発生確率を設定できるようにする
	- レコード毎に確率持って計10に調整？考え中・・・・
- 初回ログイン時のチュートリアル
- ショップ（キャラ強化・着替えの追加）
- ゲームバランスの調整
- マップの追加
