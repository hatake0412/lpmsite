<?php
define("PASSWORD", "pass");
session_start();
if(isset($_SESSION["lpmAdmin"]) && $_SESSION["lpmAdmin"] != null && hash_hmac('sha256',PASSWORD,false) === $_SESSION["lpmAdmin"]){
       
}else{
    session_destroy();//セッション破棄
    header('Location: index.php?error=Login Failure');
}
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
 <a id="err" name="err"></a>
  <?php if (isset($_GET['error'])) {  ?>
  <div id="errorHeader"> <?php echo $_GET['error'] ?> </div>
  <?php } ?>

    <div class="middleonly">
     <div>
     <div style="float:left">
     <h2>Available packages in the default public repository.</h2>
     </div>
     <div style="float:right">
     <h3><a href="upload.php">File Upload&nbsp;&nbsp;&nbsp;</a>
     <a href="logout.php">logout</a></h3>
     </div>
     </div>
 <div class="para">
     <table>
      <tr><th>name</th>
          <th>ver [Request]</th>
          <th>description</th>
          <th>depends</th>    
          <th>CREATE DATE</th>    
          <th>BBS</th>
          <th>Licence</th>
          <th>APPROVAL</th></tr>    
  <?php foreach ($pending as $p) {
  if ($p['approval']==1) {
    $approval="◎";
  } elseif ($p['approval']==99) {
    $approval="×";
  }else{
    $approval="<a href=\"lpmApproval.php?id=" . $p["id"] ."\">-</a>";
  }                
  ?>    
    <tr>
      <td><a href= "lpmscript.php?name=<?php echo $p['name']; ?>&id=<?php echo $p['id']; ?>" target="_blank"><?php echo $p['name'];?></a></td>
      <td><?php echo $p['ver'] . " [". $p['vupcount'] . "]"; ?></td>
      <td class="<?php echo $class; ?>"><?php echo $p['description']; ?></td>
      <td class="<?php echo $class; ?>"><?php echo $p['depends']; ?></td>
      <td><?php echo $p['created_at']; ?>'</td>
      <td><a href="/faq/form.php?id=<?php echo (int) $p['id']; ?>&name=<?php echo $p['name'] . " " .  $p['ver']; ?>" >BBS</a></td>
      <td><a href="#" onClick="openbox('about <?php echo $p['name']; ?>', '<?php echo $p['id']; ?>', 1)" ><img src="/images/licence.png"  /><?php echo $p['licence']; ?></a></td>
      <td align=center><?php echo $approval;?> </td>
   </tr>
  <?php } 
  include 'licencepop.php'; ?>
  
  </table>
     <div style="float:right">
     <h3><a href="logout.php">logout</a></h3>
     </div>
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
