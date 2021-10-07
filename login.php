<?php
require_once "tmp/session_out.php";
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ABCofHORROR</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  </head>
  <body id="login">
    <div id="wrapper">
      <main>
        <h1><img src="images/title_big.png" alt="タイトルロゴ"></h1>
        <div>
          <form action="login_done.php" method="post">
            <table>
              <tr><th>user：</th><td><input type="text" name="username"></td></tr>
              <tr><th>pass：</th><td><input type="password" name="pass"></td></tr>
              <tr><td colspan="2"><input type="image" src="images/login.png" alt="ログイン" id="loginbtn"></td></tr>
            </table>
          </form>
        </div>
        <div><p><a href="signup.php">新しく始める</a></p></div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
    <script>
    </script>
  </body>
</html>