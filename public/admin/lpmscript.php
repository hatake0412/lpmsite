<?php
define("PASSWORD", "pass");
session_start();
if(isset($_SESSION["lpmAdmin"]) && $_SESSION["lpmAdmin"] != null && hash_hmac('sha256',PASSWORD,false) === $_SESSION["lpmAdmin"]){

}else{
    session_destroy();//セッション破棄
    header('Location: index.php?error=Login Failure');
}

  $packageName=$_GET['name'];
  $fileName="/var/www/lpm/repository/" . $packageName . ".lpm";
//  echo $packageName . ".lpm<br /><br />";
  $lpmScript="<pre>" . file_get_contents($fileName) . "</pre>";
//  echo $lpmScript;
include '../include/headhtml.php';
?>
<body>
  <div id="wrap">
   <div id="top"></div>
   <div id="content">
    <div class="header">
     <h1><a href="/">LPM: Local Package Manager</a></h1>
     <h2>Want to install software without root?</h2>
    </div>
  <?php if (isset($_GET['error'])) {  ?>
  <div id="errorHeader"> <?php echo $_GET['error'] ?> </div>
  <?php } ?>

    <div class="middleonly">
     <h2>Available packages in the default public repository.</h2>
     <div class="para">
      <?php 
       echo $packageName . ".lpm.asc<br /><br />";
       echo $lpmScript;
       $approval="lpmApproval.php?id=" . $_GET["id"];
      ?>
<form method="POST" action="<?php echo $approval;?>">
<INPUT type="button" onClick='window.close();' value="close">
<input type="submit" name="approval" value="Approval">
<input type="submit" name="reject" value="Reject">
</form>
     </div> <!-- end of para -->
    </div> <!-- end of main test -->
    <div id="clear"></div>
   </div>
   <div id="bottom"></div>
  </div>
<div id="footer">
<?php include '../include/footerhtml.php'; ?>
</div>
</body>
</html>
