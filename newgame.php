<?php
require_once "tmp/session_out.php";
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
    <div id="wrapper" class="vh">
      <header>
        <h1><a href="login.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
        <p>‐ニューゲーム‐</p>
      </header>
      <main>
        <div>
          <form action="newgame_check.php" method="post">
            <table>
              <tr><th>User Name</th></tr>
              <tr><td>
                <input type="text" name="username">
                <p>※半角英数字のみ、60文字まで。</p>
              </td></tr>
              <tr><th>Password</th></tr>
              <tr><td>
                <input type="password" name="pass">
                <p>※半角英数字のみ、8～16文字まで。<br>※大文字、小文字、数字それぞれ1つ必須。</p>
              </td></tr>
              <tr><td colspan="2" id="btn"><input type="submit" value="新規データ作成" class="btnstyle"></td></tr>
            </table>
          </form>
        </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
  </body>
</html>