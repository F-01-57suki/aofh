<?php
//おまじない
header('X-FRAME-OPTIONS: SAMEORIGIN');
//セッション
session_start();
session_regenerate_id(true);
if(!isset($_SESSION['username'])):
  header('Location: login.php');
endif;
//チュートリアル確認
if($_SESSION['news'] != 'tutorial'):
  header('Location: index.php');
endif;
//require_once "tmp/db.php";

if(isset($_POST["tutorial"])):
  if($_POST["tutorial"] == "move"):
    //チュートリアル１の１：進む
    ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="turn" class="map0">
      <div id="wrapper">
        <header>
          <div>
            <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
            <p>～チュートリアル中～</p>
          </div>
          <div id="turn_header">
            <div id="map_gage">
              <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
              <div id="gage_all"><div id="gage_now"></div></div>
              <p>残りの距離&emsp;3</p>
            </div>
            <div id="info">
              <p>
                ＴＵＲＮ&emsp;<span id="now_turn">0</span>
              </p>
              <p>
                <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                <span class="now_p max_p">10</span>
                &emsp;
                <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                <span class="now_p max_p">10</span>
              </p>
              <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">4T</span>
              </p>
            </div>
          </div>
        </header>
        <main>
          <div id="contwrap">
            <img src="images/hutu_4.png" alt="選択キャラクター" id="charaimg">
            <section>
              <p class="tutorial_p">来た時と雰囲気が違う？　鋭いですねえ。まあ、立ち止まっていても仕方ないので、行きましょうか。</p>
              <h2 class="eve_h2">‐行動を選択‐</span></h2>
              <form action="tutorial.php" method="post" id="action">
                <button type="submit" name="tutorial" value="moveok" class="action_btn">先へ進む</button>
              </form>
            </section>
          </div>
        </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <script>
        const gage_now = document.getElementById("gage_now");
        gage_now.style.width = "0%";
      </script>
      <?php require_once "tmp/ng_js.php"; ?>
    </body>
  </html>
    <?php
  endif;

  if($_POST["tutorial"] == "moveok"):
    //チュートリアル１の２：進む
    ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="turn" class="map0">
      <div id="wrapper">
        <header>
          <div>
            <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
            <p>～チュートリアル中～</p>
          </div>
          <div id="turn_header">
            <div id="map_gage">
              <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
              <div id="gage_all"><div id="gage_now"></div></div>
              <p>残りの距離&emsp;3</p>
            </div>
            <div id="info">
              <p>
                ＴＵＲＮ&emsp;<span id="now_turn">0</span>
              </p>
              <p>
                <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                <span class="now_p max_p">10</span>
                &emsp;
                <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                <span class="now_p max_p">10</span>
              </p>
              <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">4T</span>
              </p>
            </div>
          </div>
        </header>
        <main>
          <div id="contwrap">
            <img src="images/hutu_4.png" alt="選択キャラクター" id="charaimg">
            <section>
              <p class="tutorial_p">先へ進むと進捗が加算され、残り距離が0でクリアです。どんどん進んじゃってください。</p>
              <h2 class="eve_h2 ok">‐進む‐</span></h2>
              <p>&emsp;周囲を警戒しながら、慎重な足取りで暗闇の先へと進んだ。</p>
              <form action="tutorial.php" method="post" id="action">
                <button type="submit" name="tutorial" value="battle" class="next_turn_btn">次のターンへ</button>
              </form>
            </section>
          </div>
        </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <script>
        const gage_now = document.getElementById("gage_now");
        gage_now.style.width = "0%";
      </script>
      <?php require_once "tmp/ng_js.php"; ?>
    </body>
  </html>
    <?php
  endif;

  if($_POST["tutorial"] == "battle"):
    //チュートリアル２の１：接敵（回避
    ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="turn" class="map0">
      <div id="wrapper">
        <header>
          <div>
            <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
            <p>～チュートリアル中～</p>
          </div>
          <div id="turn_header">
            <div id="map_gage">
              <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
              <div id="gage_all"><div id="gage_now"></div></div>
              <p>残りの距離&emsp;2</p>
            </div>
            <div id="info">
              <p>
                ＴＵＲＮ&emsp;<span id="now_turn">1</span>
              </p>
              <p>
                <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                <span class="now_p max_p">10</span>
                &emsp;
                <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                <span class="now_p max_p">10</span>
              </p>
              <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">3T</span>
              </p>
            </div>
          </div>
        </header>
        <main>
          <div id="battle_ui">
            <p id="battle_h"><span>諤ｪ逡ｰ</span>縺檎樟繧後∪縺励◆</p>
            <p id="battle_p">ここになんか敵によって変わるテキスト<br>を出したいというきもちがあるよ</p>
          </div>
          <div id="contwrap">
            <img src="images/dkdk_4.png" alt="選択キャラクター（接敵中）" id="charaimg">
            <section>
              <p class="tutorial_p">やっぱり出ましたねえ。残念ながら、除霊は専門外なので……ま、逃げるなり隠れるなりで、なんとかやり過ごしましょうか。</p>
              <h2 class="eve_h2 ng">‐行動を選択‐</span></h2>
              <form action="tutorial.php" method="post" id="action">
                <button type="submit" name="tutorial" value="battleok" class="action_btn">隠れる</button><br>
                <button type="submit" name="tutorial" value="battleok" class="action_btn">逃げる</button><br>
              </form>
            </section>
          </div>
        <div>
          <p>その恐ろしい姿に、背筋が凍った……。<br><span class="system_span">SPが2減少。</span></p>
        </div>
      </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <script>
        const battle_ui = document.getElementById("battle_ui");
        battle_ui.style.display = "block";
        battle_ui.style.backgroundImage = "url(images/ghost.jpg)";
        const gage_now = document.getElementById("gage_now");
        gage_now.style.width = "33%";
      </script>
      <?php require_once "tmp/ng_js.php"; ?>
    </body>
  </html>
    <?php
  endif;

  if($_POST["tutorial"] == "battleok"):
    //チュートリアル２の２：接敵（回避
    ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="turn" class="map0">
      <div id="wrapper">
        <header>
          <div>
            <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
            <p>～チュートリアル中～</p>
          </div>
          <div id="turn_header">
            <div id="map_gage">
              <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
              <div id="gage_all"><div id="gage_now"></div></div>
              <p>残りの距離&emsp;2</p>
            </div>
            <div id="info">
              <p>
                ＴＵＲＮ&emsp;<span id="now_turn">1</span>
              </p>
              <p>
                <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                <span class="now_p max_p">10</span>
                &emsp;
                <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                <span class="now_p">8</span>
              </p>
              <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">3T</span>
              </p>
            </div>
          </div>
        </header>
        <main>
          <div id="battle_ui">
            <p id="battle_h"><span>諤ｪ逡ｰ</span>縺檎樟繧後∪縺励◆</p>
            <p id="battle_p">ここになんか敵によって変わるテキスト<br>を出したいというきもちがあるよ</p>
          </div>
          <div id="contwrap">
            <img src="images/dkdk_4.png" alt="選択キャラクター（接敵中）" id="charaimg">
            <section>
              <p class="tutorial_p">うまくいきましたね。もし失敗して接触されると、AP/SPが減る上、回避できるまで付きまとわれるので注意してください。</p>
              <h2 class="eve_h2 ok">‐回避に成功‐</span></h2>
              <p class="eve_p">&emsp;上手く回避できたようだ。</p>
              <form action="tutorial.php" method="post" id="action">
                <button type="submit" name="tutorial" value="return" class="next_turn_btn">次のターンへ</button><br>
              </form>
            </section>
          </div>
        </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <script>
        const battle_ui = document.getElementById("battle_ui");
        battle_ui.style.display = "block";
        battle_ui.style.backgroundImage = "url(images/ghost.jpg)";
        const gage_now = document.getElementById("gage_now");
        gage_now.style.width = "33%";
      </script>
      <?php require_once "tmp/ng_js.php"; ?>
    </body>
  </html>
    <?php
  endif;

  if($_POST["tutorial"] == "return"):
    //チュートリアル３の１：戻る
    ?>
    <!DOCTYPE html>
    <html lang="ja">
      <head>
        <meta charset="UTF-8">
        <title>AVACHIofHORROR（仮）</title>
        <link href="style.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      </head>
      <body id="turn" class="map0">
        <div id="wrapper">
          <header>
            <div>
              <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
              <p>～チュートリアル中～</p>
            </div>
            <div id="turn_header">
              <div id="map_gage">
                <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
                <div id="gage_all"><div id="gage_now"></div></div>
                <p>残りの距離&emsp;2</p>
              </div>
              <div id="info">
                <p>
                  ＴＵＲＮ&emsp;<span id="now_turn">2</span>
                </p>
                <p>
                  <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                  <span class="now_p max_p">10</span>
                  &emsp;
                  <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                  <span class="now_p">8</span>
                </p>
                <p>
                  <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">2T</span>
                </p>
              </div>
            </div>
          </header>
          <main>
            <div id="contwrap">
              <img src="images/hutu_4.png" alt="選択キャラクター" id="charaimg">
              <section>
                <p class="tutorial_p">……まだ追って来るようなので、来た道を戻りますか。早めに距離を取れば、奴らもこちらを見失います。</p>
                <h2 class="eve_h2">‐行動を選択‐</span></h2>
                <form action="tutorial.php" method="post" id="action">
                  <button type="submit" name="tutorial" value="returnok" class="action_btn">道を戻る</button><br>
                </form>
              </section>
            </div>
          </main>
          <footer>
            <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
          </footer>
        </div>
        <script>
          const gage_now = document.getElementById("gage_now");
          gage_now.style.width = "33%";
        </script>
        <?php require_once "tmp/ng_js.php"; ?>
      </body>
    </html>
    <?php
  endif;

  if($_POST["tutorial"] == "returnok"):
    //チュートリアル３：戻る
    ?>
    <!DOCTYPE html>
    <html lang="ja">
      <head>
        <meta charset="UTF-8">
        <title>AVACHIofHORROR（仮）</title>
        <link href="style.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      </head>
      <body id="turn" class="map0">
        <div id="wrapper">
          <header>
            <div>
              <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
              <p>～チュートリアル中～</p>
            </div>
            <div id="turn_header">
              <div id="map_gage">
                <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
                <div id="gage_all"><div id="gage_now"></div></div>
                <p>残りの距離&emsp;2</p>
              </div>
              <div id="info">
                <p>
                  ＴＵＲＮ&emsp;<span id="now_turn">2</span>
                </p>
                <p>
                  <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                  <span class="now_p max_p">10</span>
                  &emsp;
                  <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                  <span class="now_p">8</span>
                </p>
                <p>
                  <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">2T</span>
                </p>
              </div>
            </div>
          </header>
          <main>
            <div id="contwrap">
              <img src="images/hutu_4.png" alt="選択キャラクター" id="charaimg">
              <section>
                <p class="tutorial_p">ゴールは遠のきましたが……、まあ、安全第一です。怪異の接近に気付くメンバーもいるんですが、私は鈍いのでカンですね。</p>
                <h2 class="eve_h2 ok">‐戻る‐</span></h2>
                <p>&emsp;嫌な予感がし、来た道を戻った。</p>
              <form action="tutorial.php" method="post" id="action">
                <button type="submit" name="tutorial" value="rest" class="next_turn_btn">次のターンへ</button><br>
              </form>
              </section>
            </div>
          </main>
          <footer>
            <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
          </footer>
        </div>
        <script>
          const gage_now = document.getElementById("gage_now");
          gage_now.style.width = "33%";
        </script>
        <?php require_once "tmp/ng_js.php"; ?>
      </body>
    </html>
    <?php
  endif;

  if($_POST["tutorial"] == "rest"):
    //チュートリアル４：休む
    ?>
    <!DOCTYPE html>
    <html lang="ja">
      <head>
        <meta charset="UTF-8">
        <title>AVACHIofHORROR（仮）</title>
        <link href="style.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      </head>
      <body id="turn" class="map0">
        <div id="wrapper">
          <header>
            <div>
              <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
              <p>～チュートリアル中～</p>
            </div>
            <div id="turn_header">
              <div id="map_gage">
                <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
                <div id="gage_all"><div id="gage_now"></div></div>
                <p>残りの距離&emsp;3</p>
              </div>
              <div id="info">
                <p>
                  ＴＵＲＮ&emsp;<span id="now_turn">3</span>
                </p>
                <p>
                  <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                  <span class="now_p max_p">10</span>
                  &emsp;
                  <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                  <span class="now_p">8</span>
                </p>
                <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">1T</span>
                </p>
              </div>
            </div>
          </header>
          <main>
            <div id="contwrap">
              <img src="images/hutu_4.png" alt="選択キャラクター" id="charaimg">
              <section>
                <p class="tutorial_p">走ってお疲れでしょうし、少し休みましょうか。1ターン経過してしまいますが、AP/SPが1ずつ回復しますよ。</p>
                <h2 class="eve_h2">‐行動を選択‐</span></h2>
                <form action="tutorial.php" method="post" id="action">
                  <button type="submit" name="tutorial" value="restok" class="action_btn">休憩する</button><br>
                </form>
              </section>
            </div>
          </main>
          <footer>
            <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
          </footer>
        </div>
        <script>
          const gage_now = document.getElementById("gage_now");
          gage_now.style.width = "0%";
        </script>
        <?php require_once "tmp/ng_js.php"; ?>
      </body>
    </html>
    <?php
  endif;

  if($_POST["tutorial"] == "restok"):
    //チュートリアル４：休む
    ?>
    <!DOCTYPE html>
    <html lang="ja">
      <head>
        <meta charset="UTF-8">
        <title>AVACHIofHORROR（仮）</title>
        <link href="style.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      </head>
      <body id="turn" class="map0">
        <div id="wrapper">
          <header>
            <div>
              <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
              <p>～チュートリアル中～</p>
            </div>
            <div id="turn_header">
              <div id="map_gage">
                <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
                <div id="gage_all"><div id="gage_now"></div></div>
                <p>残りの距離&emsp;3</p>
              </div>
              <div id="info">
                <p>
                  ＴＵＲＮ&emsp;<span id="now_turn">3</span>
                </p>
                <p>
                  <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                  <span class="now_p max_p">10</span>
                  &emsp;
                  <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                  <span class="now_p">8</span>
                </p>
                <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">1T</span>
                </p>
              </div>
            </div>
          </header>
          <main>
            <div id="contwrap">
              <img src="images/hutu_4.png" alt="選択キャラクター" id="charaimg">
              <section>
                <p class="tutorial_p">休んだ気がしない？　状況が状況ですし、気休めにしかならないでしょうね。AP/SPは余裕を見て管理しましょう。</p>
                <h2 class="eve_h2 ok">‐休憩‐</span></h2>
                <p>&emsp;休めそうな場所を見つけ、少し休憩した。<br><span class="system_span">APが1回復。SPが1回復。</span></p>
                <form action="tutorial.php" method="post" id="action">
                  <button type="submit" name="tutorial" value="skill" class="next_turn_btn">次のターンへ</button><br>
                </form>
              </section>
            </div>
          </main>
          <footer>
            <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
          </footer>
        </div>
        <script>
          const gage_now = document.getElementById("gage_now");
          gage_now.style.width = "0%";
        </script>
        <?php require_once "tmp/ng_js.php"; ?>
      </body>
    </html>
    <?php
  endif;

  if($_POST["tutorial"] == "skill"):
    //チュートリアル５の１：スキルについて
    ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="turn" class="map0">
      <div id="wrapper">
        <header>
          <div>
            <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
            <p>～チュートリアル中～</p>
          </div>
          <div id="turn_header">
            <div id="map_gage">
              <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
              <div id="gage_all"><div id="gage_now"></div></div>
              <p>残りの距離&emsp;3</p>
            </div>
            <div id="info">
              <p>
                ＴＵＲＮ&emsp;<span id="now_turn">4</span>
              </p>
              <p>
                <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                <span class="now_p max_p">10</span>
                &emsp;
                <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                <span class="now_p">9</span>
              </p>
              <p>
                <i class="fas fa-toolbox" id="skill_ok"></i><span class="info_t">&nbsp;スキル発動可</span>
              </p>
            </div>
          </div>
        </header>
        <main>
          <div id="battle_ui">
            <p id="battle_h"><span>諤ｪ逡ｰ</span>縺檎樟繧後∪縺励◆</p>
            <p id="battle_p">ここになんか敵によって変わるテキスト<br>を出したいというきもちがあるよ</p>
          </div>
          <div id="contwrap">
            <img src="images/dkdk_4.png" alt="選択キャラクター（接敵中）" id="charaimg">
            <section>
              <p class="tutorial_p">おっと……。こいつは実体があるタイプですね。じゃあ、折角ですし、私のスキルをお見せしちゃいます。</p>
              <h2 class="eve_h2 ng">‐行動を選択‐</span></h2>
              <form action="tutorial.php" method="post" id="action">
                <button type="submit" name="tutorial" value="kill" class="action_btn">撃破</button><br>
              </form>
            </section>
          </div>
        <div>
          <p>その恐ろしい姿に、背筋が凍った……。<br><span class="system_span">SPが9減少。</span></p>
        </div>
      </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <script>
        const battle_ui = document.getElementById("battle_ui");
        battle_ui.style.display = "block";
        battle_ui.style.backgroundImage = "url(images/zombie.jpg)";
        const gage_now = document.getElementById("gage_now");
        gage_now.style.width = "0%";
      </script>
      <?php require_once "tmp/ng_js.php"; ?>
    </body>
  </html>
    <?php
  endif;

  if($_POST["tutorial"] == "kill"):
    //チュートリアル５の２：スキルについて
    ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="turn" class="map0">
      <div id="wrapper">
        <header>
          <div>
            <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
            <p>～チュートリアル中～</p>
          </div>
          <div id="turn_header">
            <div id="map_gage">
              <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
              <div id="gage_all"><div id="gage_now"></div></div>
              <p>残りの距離&emsp;3</p>
            </div>
            <div id="info">
              <p>
                ＴＵＲＮ&emsp;<span id="now_turn">4</span>
              </p>
              <p>
                <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                <span class="now_p max_p">10</span>
                &emsp;
                <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                <span class="now_p min_p">0</span>
              </p>
              <p>
              <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">4T</span>
              </p>
            </div>
          </div>
        </header>
        <main>
          <div id="battle_ui">
            <p id="battle_h"><span>諤ｪ逡ｰ</span>縺檎樟繧後∪縺励◆</p>
            <p id="battle_p">ここになんか敵によって変わるテキスト<br>を出したいというきもちがあるよ</p>
          </div>
          <div id="contwrap">
            <img src="images/dkdk_4.png" alt="選択キャラクター（接敵中）" id="charaimg">
            <section>
              <p class="tutorial_p">……殲滅完了です、雑魚でしたね。他のメンバーもそれぞれのスキルを持っているので、追々見せてもらって下さい。</p>
              <h2 class="eve_h2 sp">スキル発動<br><span class="eve_span">‐錆びた鉄パイプ‐</span></h2>
              <p class="eve_p">&emsp;怪異を撃破した。<br><span class="system_span">&emsp;スキル効果により、APが3減少。</span></p>
            </section>
          </div>
          <div>
            <form action="tutorial.php" method="post">
              <button type="submit" name="tutorial" value="panic" class="next_turn_btn">次のターンへ</button><br>
            </form>
          </div>
        </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
      <script>
        const battle_ui = document.getElementById("battle_ui");
        battle_ui.style.display = "block";
        battle_ui.style.backgroundImage = "url(images/zombie.jpg)";
        const gage_now = document.getElementById("gage_now");
        gage_now.style.width = "0%";
      </script>
      <?php require_once "tmp/ng_js.php"; ?>
    </body>
  </html>
    <?php
  endif;

  if($_POST["tutorial"] == "panic"):
    //チュートリアル６：パニックについて
    ?>
    <!DOCTYPE html>
    <html lang="ja">
      <head>
        <meta charset="UTF-8">
        <title>AVACHIofHORROR（仮）</title>
        <link href="style.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
      </head>
      <body id="turn" class="map0">
        <div id="wrapper">
          <header>
            <div>
              <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
              <p>～チュートリアル中～</p>
            </div>
            <div id="turn_header">
              <div id="map_gage">
                <div id="gage_title"><p>0%&nbsp;&nbsp;</p><p>&nbsp;50%</p><p>100%</p></div>
                <div id="gage_all"><div id="gage_now"></div></div>
                <p>残りの距離&emsp;3</p>
              </div>
              <div id="info">
                <p>
                  ＴＵＲＮ&emsp;<span id="now_turn">5</span>
                </p>
                <p>
                  <span id="panic_span">パニック発生中&nbsp;<i class="fas fa-exclamation"></i></span>
                </p>
                <p>
                  <i class="fas fa-heartbeat fa-fw"></i><span class="info_t">&nbsp;ＡＰ：</span>
                  <span class="now_p max_p">7</span>
                  &emsp;
                  <i class="fas fa-brain fa-fw"></i><span class="info_t">&nbsp;ＳＰ：</span>
                  <span class="now_p">-3</span>
                </p>
                <p>
                <i class="fas fa-toolbox" id="skill_ng"></i><span class="info_t">&nbsp;発動まで&nbsp;</span><span class="now_p">3T</span>
                </p>
              </div>
            </div>
          </header>
          <main>
            <div id="contwrap">
              <img src="images/panik_4.png" alt="選択キャラクター" id="charaimg">
              <section>
                <p class="tutorial_p">あ、怪異を直視しすぎるとSPが減って、パニック状態……行動不能になりますよ。0の瞬間にペナルティで-3されるので要注意です。</p>
                <h2 class="eve_h2 ng">‐パニック発生中‐</span></h2>
                <p>&emsp;パニックのため、行動不能。<br><span class="system_span">&emsp;APが1回復。SPが1回復。</span></p>
                <form action="tutorial.php" method="post">
                  <button type="submit" name="tutorial" value="end" class="next_turn_btn">次のターンへ</button><br>
                </form>
              </section>
            </div>
          </main>
          <footer>
            <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
          </footer>
        </div>
        <script>
          const gage_now = document.getElementById("gage_now");
          gage_now.style.width = "0%";
        </script>
        <?php require_once "tmp/ng_js.php"; ?>
      </body>
    </html>
    <?php
  endif;

  if($_POST["tutorial"] == "end"):
    //チュートリアルおわり
    $news = "none";
    require_once "tmp/db.php";
    $stmt = $pdo->prepare("UPDATE `user_tbl` SET `news`=:news WHERE `username`=:username");
    $stmt->bindParam(":username",$_SESSION["username"]);
    $stmt->bindParam(":news",$news);
    $stmt->execute();
    $stmt = null;
    $pdo = null;
    $_SESSION['news'] = $news;
    ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>AVACHIofHORROR（仮）</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body id="result" class="map0">
    <div id="wrapper">
      <header>
        <h1><img src="images/title_mini.png" alt="タイトルロゴ"></h1>
        <p>‐チュートリアル完了‐</p>
      </header>
      <main>
        <div>
          <h2>今回のスコア</h2>
          <table>
            <tr>
              <td colspan="2"><img src="images/rank_s.png" alt="sランク獲得"></td>
            </tr>
            <tr>
              <th>総ターン数：</th><td>6T</td>
            </tr>
            <tr>
              <th>獲得ポイント：</th><td>10p</td>
            </tr>
          </table>
          <p>クリアランクに応じ、ポイントを獲得しました。<br>現在の所持ポイントが「<span class="system_span">10p」</span>になりました。</p>
        </div>
        <div id="outro">
            <p class="asterisk">＊＊＊</p>
            <p>「お疲れさまでした。……ゴリさんの紹介なだけあって、筋がよさそうです」</p>
            <p>　褒められているのだろうが、それどころではない。今見たもの、――異様な雰囲気の道に、明らかにこの世のものとは思えない異形。平然としている、この少女も、全て。自分の中で、受け止め切れていない。</p>
            <p>「ああ、まあ、最初は皆、そういう反応ですよ。そのうち慣れます。慣れてほしい、慣れろ」</p>
            <p>　今までのアルバイトたちが続かなかった理由を、完全に理解した。無理だ。自分には。断ろう、今ここで。</p>
            <p>「もう辞めたいって顔してますねえ。この辺で、こんな楽で時給のいいバイト、そうそうないと思いますよ」</p>
            <p>　ずるい。苦学生にその言葉は効く。決心が、揺らぐ――。</p>
            <p>「他のメンバーの写メ見ます？」</p>
            <p>　こちらが何かを言うよりも早く、赤羽はスマホの液晶をこちらに向ける。――そこには、美人の女性たちが肩を寄せ合い、微笑んでいる写真が表示されていた。</p>
            <p>「明日から、よろしくお願いしますね」</p>
            <p>　――筋がいい。その言葉を信じ、もう少し頑張ってみることにした。</p>
            <a href="index.php">TOPページへ</a>
          </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <?php require_once "tmp/ng_js.php"; ?>
  </body>
</html>
      <?php
  endif;
else:
  //チュートリアル開始
  ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）</title>
      <link href="style.css" rel="stylesheet">
      <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body id="intro" class="map0">
      <div id="wrapper">
        <header>
        <h1><img src="images/map0logo.png" alt="チュートリアルロゴ"></h1>
        <p>‐チュートリアル‐</p>
        </header>
        <main>
          <div>
          <p>　それは、この辺りではちょっとばかり有名な『事故物件』だった。</p>
          <p>　かなりの曰く付きらしく、あまり近寄る人もいない。詳細は知らないが、知りたいとも思わない。</p>
          <p>　まさか――そんな場所に、自ら足を運ぶことになろうとは。</p>
          <p>「ああ、はい。新しいバイトさんですよね」</p>
          <p>　どこか不気味な外観からは想像もできないほど、その扉の向こうは、明るくおしゃれなオフィスだった。</p>
          <p>「座ってください。書類系を先に書いてもらってから、業務の説明をしますね」</p>
          <p>　どうしたことか、そこには小さな女の子しかいなかった。雇用主は急用で外しているのか。君はご家族か何かか。それらの疑問を、少女に率直にぶつける。</p>
          <p>「あれ。ゴリさんから聞いてませんかね？　私が雇用主にあたる者です。赤羽と申します」</p>
          <p>　驚いた。その背格好から成人しているようにも、事業主をしているようにも見えないが――。</p>
          <p>「見た目に囚われる人、この界隈向いてないんですけどね。んでも、まあ、初回くらいは姐さんたちに代わってもらうべきだったかな……。や、でも、その辺は私がやる約束だし」</p>
          <p>　赤羽はぶつぶつと言いながら、契約書やらの書類を準備していく。その手際を見るに、彼女が雇用主というのも嘘ではなさそうだ。</p>
          <p>　この界隈。不意にその言葉が気になって、詳細を尋ねてみた。</p>
          <p>「ゴリさんから……や、うーん。絶対お酒の席でスカウトしたな、あの人。……この事務所はですね。<span>オカルト専門の探偵事務所</span>、的なやつで」</p>
          <p>　オカルト。探偵事務所。どちらもあまり頻繁に耳にする言葉ではないため、思わずおうむ返ししてしまった。</p>
          <p>「都市伝説とか、怪談とかに絡む困りごとのある人が、相談に来るわけです。我々は助言をしたり、必要に応じて調査をしたり……。ああ、そんな顔しないで。これバイトさんの仕事ではないので」</p>
          <p>　正直、現実味のない話だ。普通の探偵事務所だって物珍しいというのに、まさか、オカルト専門のそれとは。</p>
          <p>　もしかして、赤羽は所謂『除霊師』というやつなのだろうか。</p>
          <p>「除霊？　原因が幽霊であれば、必要に応じて除霊もしますが……それは私の分野じゃないので、別のメンバーに任せてますね」</p>
          <p>　別のメンバー。先ほど言っていた、姐さんたち、だろうか。</p>
          <p>「私が事業主って形はとってますが、ここは<span>四人で共同経営</span>してまして……まあ、あと三人とも、追々顔を合わせることになると思いますよ」</p>
          <p>　と、そこで書類を書き終わり、彼女は話を打ち切ると机を片付けた。</p>
          <p class="asterisk">＊＊＊</p>
          <p>　あの話を聞いた後だったものだから、一体どんなバイトになるのかと戦々恐々としていたが――その仕事内容は、至って地味なものだった。</p>
          <p>「オフィスの清掃。ゴミ捨て。来客や電話があれば、上で寝ている私に取次ぎ。それだけです」</p>
          <p>　それだけ。時給からは想像もつかない、簡単な内容。</p>
          <p>「私に連絡するときはスマホへ。絶対に上には立ち入らないで下さい、絶対の絶対」</p>
          <p>　住居、それも赤羽が住んでいると聞いて、勝手に入るわけがない。そう言うと、彼女は、念のため、そしてお互いのため、と口に指を当てて。</p>
          <p>「……今日は、こんなところですかね。あ！　あと、最後に大事な注意点がありました」</p>
          <p>　赤羽の不敵な笑みを見て、何故か、このバイトを紹介された時の話を思い出した。行きつけの飲み屋で、友人から聞いた話。</p>
          <p>　――あのバイトは、『向いている人』にしか紹介できない。それでも、すぐ辞めてしまうみたいで。</p>
          <p>　内容からは想像できない、破格の時給。有名な事故物件。オカルト探偵事務所。</p>
          <p>「行きはよいよい、ってやつで。このビル周辺、日が暮れると<span>変なモノ</span>に絡まれやすいんです。初日は見送りがてら対処法をお教えしますから、……死なないように、死ぬ気で帰ってくださいね」</p>
            <img src="images/map0intro.png" alt="チュートリアルイントロ画像">
            <div>
              <form action="tutorial.php" method="post">
                <input type="hidden" name="tutorial" value="move">
                <input type="image" name="submit" src="images/login.png" alt="スタート">
              </form>
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
<?php endif; ?>