<?php
session_start();
if(!isset($_SESSION["LANGS"])){
  $_SESSION["LANGS"]="ENG";
}
$lang=$_GET["la"];
if (!isset($lang)) {$lang="en";}

include 'include/headhtml.php';
?>
<body>
<div id="wrap">

<div id="top"></div>

<div id="content">

<div class="header">
<h1><a href="/">LPM: Local Package Manager</a></h1>
<h2>Want to install software without root?</h2>
</div>

<div class="breadcrumbs">
<?php include 'include/pan.php'; ?>
</div>

<div class="middle">
 <h1 class="title">Discussion</h1>
<?php
if ($lang == "en") {
  include 'include/engdiscuss.php';
} else {
  include 'include/japdiscuss.php';
}
?>
</div> <!-- end of main text -->
		
<div class="right">
		
<h2>Navigation</h2>
<?php
  include 'include/menu.php';
?>
</div> <!-- end of navigation -->

<div id="clear"></div>

</div>

<div id="bottom"></div>

</div>

<div id="footer">
<?php include 'include/footerhtml.php'; ?>
</div>

</body>
</html>
