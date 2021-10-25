<?php
//DB情報
$dbname = 'mysql:host=mysql1.php.xdomain.ne.jp;dbname=crimsonscar_aofh;charset=utf8';
$id = 'crimsonscar_root';
$pw = 'Ha020714';
//DB接続
try{
  $pdo = new pdo($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES => false));
}
catch(PDOException $e){
  ?>
  <!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>AVACHIofHORROR（仮）‐接続エラー</title>
      <link href="style.css" rel="stylesheet">
    </head>
    <body id="error">
      <div id="wrapper">
        <main>
          <h1>接続エラー</h1>
          <p>接続に失敗しました。<br>時間をおいて、再度お試しください。</p>
          <p><input type="button" value="戻る" onclick='history.go(-1)' class="btnstyle"></p>
        </main>
        <footer>
          <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
        </footer>
      </div>
    </body>
  </html>
  <?php
  die();
}
?>