<?php
define("PASSWORD", "pass");
session_start();
if(isset($_SESSION["lpmAdmin"]) && $_SESSION["lpmAdmin"] != null && hash_hmac('sha256',PASSWORD,false) === $_SESSION["lpmAdmin"]){

}else{
    session_destroy();//セッション破棄
    header('Location: index.php?error=Login Failure');
}

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
    <div class="middle">
     <h2>Upload LPM script (Commiter mode)</h2>
     <p>We welcome any submissions regardless regular maintainance. Please upload an LPM script from the form below.</p>
<?php
if (is_uploaded_file($_FILES["lpmscript"]["tmp_name"])) {
  if (filesize($_FILES["lpmscript"]["tmp_name"]) > 0) {
    $lpmBaseName=basename($_FILES["lpmscript"]["name"],'.lpm');
    if (move_uploaded_file($_FILES["lpmscript"]["tmp_name"], "/var/www/lpm/tmp/" . $_FILES["lpmscript"]["name"])) {
      echo $_FILES["lpmscript"]["name"] . " is uploaded.";
      $uploadFile = "/var/www/lpm/script/sign_package_commiter " . $lpmBaseName;
      if (is_null(shell_exec ($uploadFile))){ echo "file upload failure"; }
    } else {
      echo "I was not able to upload files.";
    }
  } else {
      echo "file size error.(" . filesize($_FILES["lpmscript"]["tmp_name"]) . ")";
  }
}
?>
  <form method="post" action="upload.php" enctype="multipart/form-data">
    <p><label>FILE : </label>
       <input type="file" name="lpmscript" size="30">
    <input type="submit" name="submit" value="UPLOAD" class="btn"></p>
  </form>
    </div> <!-- end of middle  -->

  <div class="right">
    <h2><a href="logout.php">logout</a></h2>
  </div> <!-- end of navigation -->
    <div id="clear"></div>
   </div>
   <div id="bottom"></div>
  </div>
<div id="footer">
<?php include '../include/footerhtml.php'; ?>
</div>
</body>
</html>
