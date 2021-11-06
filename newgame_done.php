<?php
require_once "tmp/session_out.php";
require_once "tmp/post.php";
require_once "tmp/db.php";

//ユーザー名
if(preg_match("/^[A-Za-z0-9_.!?*-]{1,60}$/",$_SESSION['ucheck'])):
  $username = htmlspecialchars($_SESSION['ucheck'],ENT_QUOTES,'UTF-8');
else:
  $errors["ユーザー名"]="ユーザー名を正しく入力して下さい（半角英数字のみ、60文字まで）";
endif;

$stmt = $pdo->prepare("SELECT `username` FROM `user_tbl` WHERE `username`= :username");
$stmt->bindParam(":username",$_SESSION['ucheck']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result):
  $errors["ユーザー名"]="このユーザー名は既に使用されています。";
endif;
$stmt = null;

//pass
if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,16}$/",$_SESSION['pcheck'])):
  $pass = password_hash($_SESSION['pcheck'],PASSWORD_DEFAULT);
else:
  $errors["パスワード"]="パスワードを正しく入力して下さい（半角英数字8～16文字）";
endif;
if(count($errors)!==0):
  require_once "tmp/error.php";
else:
  //user_tbl
  $news = "tutorial";
  $stmt = $pdo->prepare("INSERT INTO `user_tbl` (`username`,`pass`,`point`,`lost_a`,`lost_t`,`lost_m`,`lost_y`,`news`) VALUES (:username,:pass,10,0,0,0,0,:news)");
  $stmt->bindParam(":username",$_SESSION['ucheck']);
  $stmt->bindParam(":pass",$pass);
  $stmt->bindParam(":news",$news);
  $stmt->execute();
  $stmt = null;
  //ログイン情報の入れ込み
  $_SESSION['username'] = $_SESSION['ucheck'];
  $_SESSION['pass'] = $_SESSION['pcheck'];
  $_SESSION['news'] = $news;
  unset($_SESSION['ucheck']);
  unset($_SESSION['pcheck']);

  //user_buy_tbl（保留）
  $pdo = null;
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
      <p>‐登録完了‐</p>
      </header>
      <main>
        <div>
          <table>
            <tr><th>User Name</th></tr>
            <tr><td><?php echo $username; ?></td></tr>
            <tr><th>Password</th></tr>
            <tr><td><?php echo str_repeat("*",mb_strlen($_SESSION['pass'],"UTF8")); ?></td></tr>
          </table>
        </div>
        <div>
          <p id="startBtn"><a href="index.php"><img src="images/login.png" alt="ゲームスタート"></a></p>
        </div>
      </main>
    </div>
  </body>
</html>
<?php endif; ?>