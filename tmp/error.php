<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ABCofHORROR‐エラー</title>
    <link href="style.css" rel="stylesheet">
  </head>
  <body id="error">
    <div id="wrapper">
      <main>
<?php foreach($errors as $key=>$value): ?>
        <h1><?php echo $key; ?>エラー</h1>
        <p><?php echo $value; ?></p>
<?php endforeach; ?>
        <p><input type="button" value="戻る" onclick='history.go(-1)'></p>
      </main>
      <footer>
        <p>copyright &copy; <?php echo date('Y'); ?> Miyashita.</p>
      </footer>
    </div>
  </body>
</html>
<?php
if(isset($stmt)):
  $stmt = null;
endif;
if(isset($pdo)):
  $pdo = null;
endif;
die();
?>