<?php
define("COMMITER", "commit");
define("PASSWORD", "pass");
session_start();
if(isset($_POST["action"])&&$_POST["action"]==="login"){

    if(PASSWORD === $_POST["password"]){//パスワード確認
        $_SESSION["lpmAdmin"] = hash_hmac('sha256',PASSWORD,false);//暗号化してセッションに保存
        header("Location:admin.php");
    }
    else if(COMMITER === $_POST["password"]){//パスワード確認
        $_SESSION["lpmAdmin"] = hash_hmac('sha256',PASSWORD,false);//暗号化してセッションに保存
        header("Location:upload.cgi");

    }else{
        session_destroy();//セッション破棄
        message();
    }
}

?>
<?php
function message(){
    session_destroy();//セッション破棄
//    die('Login Failure');
    header('Location: index.php?error=Login Failure');
}
?>
<?php
$ip=$_SERVER['REMOTE_ADDR'];//ipアドレスの取得
if ($ip != $_SESSION["setip"]) {
  $_SESSION["setip"] = $ip;
} else {
  $expire=1;
}
try {
    // connect to database
    $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
    
    // query and retrieve pending items
    $sth = $dbh->query("SELECT  * FROM packages group by name ORDER BY name");
    $pending = $sth->fetchAll();
    $sth = null;
    
} catch (PDOException $e) {
   die('Error: ' . $e->getMessage());
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
  <?php if (isset($_GET['error'])) {  ?>
  <div id="errorHeader"> <?php echo $_GET['error'] ?> </div>
  <?php } ?>

    <div class="middleonly">
     <h2>Available packages in the default public repository.</h2>
 <div class="para">
    <form action="" method="post">
     <table style="width:30%">
      <tr><th>PASSWORD</th><td><input name="password" type="password" value=""></td></tr>
      <tr><td align=center colspan=2><input name="action" type="submit" value="login" /></td></tr>
     </table>
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
