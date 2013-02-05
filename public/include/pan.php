<?php
$pannavi=preg_replace("/(.+)(\.[^.]+$)/", "$1", $_SERVER['PHP_SELF']);

?>
<a href="/">Home</a><a href="#/"><?php echo $pannavi; ?></a>

<?php /* if ($_SESSION["LANGS"] == "ENG") { ?>
  <div class="langsel">English | <a href="include/chglang.php">Japanese</a></div>
<?php }else{ ?>
  <div class="langsel"><a href="include/chglang.php">English</a> | Japanese</div>
<?php } */?>

<?php
$urls=explode("?", $_SERVER["REQUEST_URI"]);

 if ($_GET["la"] == "ja") { ?>
  <div class="langsel"><a href="<?php echo $urls[0]; ?>?la=en">English</a> | Japanese</div>
<?php }else{ ?>
  <div class="langsel">English | <a href="<?php echo $urls[0]; ?>?la=ja">Japanese</a></div>
<?php } ?>
