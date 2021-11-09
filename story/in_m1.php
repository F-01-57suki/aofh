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
        <p>　――きさらぎ駅。インターネットやSNSを中心として広まった、有名な都市伝説だ。</p>
        <p>「<?php
                  if($chara_id == 1):
                    echo "きさらぎ駅……って、一昔前に流行った都市伝説、だよね？";
                  elseif($chara_id == 2):
                    echo "きさらぎ駅とは。随分と懐かしい名前が出たな……";
                  elseif($chara_id == 3):
                    echo "確か、赤羽ちゃんが好きな都市伝説よね。都市伝説の、調査？";
                  elseif($chara_id == 4):
                    echo "ははあ、きさらぎ駅の調査ですか。こりゃまた突然な";
                  endif;
            ?>」</p>
        <p>　ぼやきながら、<?php echo $chara_name; ?>は依頼のメールを読み返す。そこには、一見すると悪戯めいた内容が記載されていた。</p>
        <p>　自分は、かつて『きさらぎ駅』に迷い込んだｘｘの友人。きさらぎ駅へと向かい、ｘｘの遺品を回収して、匿名で送り届けてほしい。きさらぎ駅へ向かう際は、新浜松駅から遠州鉄道に乗車し……。</p>
        <p>「捜索じゃなくて、遺品の回収。依頼者は匿名、何故かこっちも匿名で、遺品を送れ……？」</p>
        <p>　たまに、こういった悪戯はある。心霊スポットへの調査だの、都市伝説の真偽だの。事務所の性質上、それは仕方のないことなのだが。</p>
        <p>「<?php
                  if($chara_id == 1):
                    echo "でも、今回は流石に悪戯じゃない……よね";
                  elseif($chara_id == 2):
                    echo "悪戯にしちゃ、流石に手が込んでるというか……ねえ";
                  elseif($chara_id == 3):
                    echo "でも、……今回は、悪戯にしてはやりすぎ、かな？";
                  elseif($chara_id == 4):
                    echo "今回はちょっと、悪戯と一蹴するわけにもいかなそうです";
                  endif;
        ?>」</p>
        <p>　時間にして、メールが送信されてすぐ、だろうか。依頼料と思われる、多額の入金があった。事務所のホームページに記載した中で、一番高額の――危険を伴う調査の依頼料。</p>
        <p>「まずは他のメンバーに相談するとして、集まれる時間に作戦会議を……」</p>
        <p>　そう呟いた瞬間。目の前のパソコンから、甲高い通知音が響いた。通知は、どうやらメールアプリから。</p>
        <p>「……」</p>
        <p>　それはあまりにもタイミングがよくて。流石の<?php echo $chara_name; ?>も、鳥肌が立つのを感じた。依頼のメールと同じ、出鱈目なアドレスからの、それ。</p>
        <p>「調査は、急ぎ……、今すぐ駅へ？」</p>
        <p>　なぜ。何をそんなに急いでいるのだろう。あんなに昔からある都市伝説で、今になって依頼をしてきたというのに、急ぐ理由なんて無いように思う。</p>
        <p>　けれど、そのメールの文面は、本当に切羽詰まっているように見えて。</p>
        <p>（<?php
                  if($chara_id == 1):
                    echo "単独行動は不安だけど、見て見ぬ振りもできないよね";
                  elseif($chara_id == 2):
                    echo "相談もなしに、ってのは気が引けるけど。こうなっちゃ行くしかないか";
                  elseif($chara_id == 3):
                    echo "他のメンバーがいない以上、ここは私が行くしかなさそうね";
                  elseif($chara_id == 4):
                    echo "観光ついでと思って、ちゃちゃっと片付けちゃいましょうか";
                  endif;
        ?>）</p>
        <p>　恐怖はあった。不気味だとも思ったが、――謎の使命感と、少しの興味にかられた<?php echo $chara_name; ?>は、事務所を飛び出した。</p>
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