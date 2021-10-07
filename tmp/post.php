<?php
//POSTでない場合はindexへ転送
if($_SERVER["REQUEST_METHOD"]!=="POST"):
  header('Location: index.php');
  die();
endif;
?>