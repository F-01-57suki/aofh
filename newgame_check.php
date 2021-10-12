<?php
require_once "tmp/post.php";
require_once "tmp/session_out.php";
require_once "tmp/db.php";

$errors = array();

//ユーザー名
if(preg_match("/^[A-Za-z0-9_.!?*-]{1,60}$/",$_POST['username'])):
  $username = htmlspecialchars($_POST['username'],ENT_QUOTES,'UTF-8');
else:
  $errors["ユーザー名"]="ユーザー名を正しく入力して下さい（半角英数字のみ、60文字まで）";
endif;

$stmt = $pdo->prepare("SELECT `username` FROM `user_tbl` WHERE `username`= :username");
$stmt->bindParam(":username",$_POST['username']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $errors["ユーザー名"]="このユーザー名は既に使用されています。";
endif;
$stmt = null;
$pdo = null;

//pass
if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,16}$/",$_POST['pass'])):
  $pass = htmlspecialchars($_POST['pass'],ENT_QUOTES,'UTF-8');
else:
  $errors["パスワード"]="パスワードを正しく入力して下さい（半角英数字8～16文字）";
endif;

if(count($errors)!==0):
  require_once "tmp/error.php";
else:
  $_SESSION['ucheck'] = $username;
  $_SESSION['pcheck'] = $pass;
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
        <h1><a href="login.php"><img src="images/title_mini.png" alt="タイトルロゴ"></a></h1>
        <p>‐登録しますか？‐</p>
      </header>
      <main>
        <div>
          <table>
            <tr><th>User Name</th></tr>
            <tr><td><?php echo $username; ?></td></tr>
            <tr><th>Password</th></tr>
            <tr><td><?php echo str_repeat("*",mb_strlen($pass,"UTF8")); ?></td></tr>
          </table>
        </div>
        <div>
          <form action="newgame_done.php" method="post" id="cbtn">
            <input type="button" value="戻る" onclick='history.go(-1)'>
            <input type="submit" value="登録">
            </form>
        </div>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
  </body>
</html>
<?php endif; ?>