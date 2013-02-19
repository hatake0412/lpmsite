<?php
session_start();

$ip=$_SERVER['REMOTE_ADDR'];//ipアドレスの取得
if ($ip != $_SESSION["setip"]) {
  $_SESSION["setip"] = $ip;
} else {
  $expire=1;
}
require 'include.php';
try {
    // connect to database
    $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
    
    // query and retrieve pending items
    $sth = $dbh->query("SELECT  * FROM packages where approval=1 group by name ORDER BY name");
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
    <div id="menu_l">
      <?php include '../include/menu.php'; ?>
    </div>
    <div class="breadcrumbs">
      <?php include '../include/pan.php'; ?>
    </div>
 <a id="err" name="err"></a>
  <?php if (isset($_GET['error'])) {  ?>
  <div id="errorHeader"> <?php echo $_GET['error'] ?> </div>
  <?php } ?>

    <div class="middleonly">
     <h2>Available packages in the default public repository.</h2>
 <div class="para">
     <table>
      <tr><th>name</th>
          <th>ver</th>
          <th>description</th>
          <th>depends</th>    
          <th>OK</th>    
          <th>BBS</th></tr>    

  <?php foreach ($pending as $p) {
    include 'popcount.php';
    $actionCount="<table><tr><th>OS</th><th>OK</th><th>NG</th></tr>";
    foreach ($recall as $ra) {
      $actionCount = $actionCount . "<tr><td>". $ra["name"] . "</td><td>" . $ra["okcnt"] . "</td><td>" . $ra["ngcnt"] . "</td></tr>";
    }
    $actionCount = $actionCount . "</table>";
  ?>
    
    <tr>
      <td class="<?php echo $class; ?>">
          <a rel="tooltip" title="<?php echo $actionCount;?>" href= <?php echo $p['note']; ?> target="_blank">
             <?php echo $p['name'];?>
          </a>
      </td>
      <td class="<?php echo $class; ?>"><?php echo $p['ver']; ?></td>
      <td class="<?php echo $class; ?>"><?php echo $p['description']; ?></td>
      <td class="<?php echo $class; ?>"><?php echo $p['depends']; ?></td>
      <td><a href="#" onClick="openbox('about <?php echo $p['name']; ?>', '<?php echo $p['id']; ?>', 1)" ><img src="/images/report_icon.jpg"  /></a></td>
      <td><a href="form.php?id=<?php echo (int) $p['id']; ?>&name=<?php echo $p['name'] . " " .  $p['ver']; ?>" >BBS</a></td>
    </tr>
  <?php } ?>
  <?php include 'popup.php'; ?> 
  
  </table>
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
