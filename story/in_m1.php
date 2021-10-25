<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>AVACHIofHORROR（仮）</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body id="intro" class="map1">
    <div id="wrapper">
      <header>
      <h1><img src="images/map1logo.png" alt="きさらぎ駅ロゴ"></h1>
      <p>‐序章‐</p>
      </header>
      <main>
        <div>
          <p>　キャラ名描写の確認です。選択キャラは「<?php echo $chara_name; ?>」。</p>
          <p>　キャラごとのテキスト確認です。<?php
          if($chara_id == 1):
            echo "踊り場で踊る";
          elseif($chara_id == 2):
            echo "拙僧";
          elseif($chara_id == 3):
            echo "夢の国にナマハゲ";
          elseif($chara_id == 4):
            echo "赤ずきんの傭兵をすこれ";
          endif;
          ?></p>
          <p>　きさらぎ駅とは、日本のインターネットコミュニティで都市伝説として語られている架空の鉄道駅である。</p>
          <p>　2004年にインターネット掲示板の2ちゃんねるに投稿された実況形式の怪奇体験談の舞台として登場したもので、人里離れた沿線に忽然と現れた謎の無人駅として描写されている。</p>
          <p>　体験談の内容から静岡県浜松市の遠州鉄道沿線、またはそこから繋がった異界にあるものとされているが、以後ネット上では類似の体験談が相次いで、インターネット・ミームとしての広まりを見せている。</p>
          <p>　ひらがなで「きさらぎ駅」と表記するのが一般的であるが、のちの体験談や考察では「如月駅」や「鬼駅」などの表記も見られる。また、その後都市伝説として語られるようになった類似の架空の駅を含む総称として「異界駅」と呼ぶことがある。</p>
          <img src="images/map1intro.png" alt="きさらぎ駅イントロ画像">
          <div>
            <a href="turn.php"><img src="images/login.png" alt="スタート"></a>
          </div>
        </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>