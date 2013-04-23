<?php
//require 'include.php';
require ('Services/ReCaptcha.php');
// セッション開始
  session_start();
 
// タイムスタンプと推測できない文字列にてキーを発行
  $key = md5(time()."rentoubousinoki0");
 
// 発行したキーをセッションに保存
  $_SESSION['key'] = $key;

  $publicKey  = "6LfflNkSAAAAAHmGkLnEs10x9ImiyVkueLJWqduk";
  $privateKey = "6LfflNkSAAAAAGKpL-PNxcS2N9L9_p-ftUnoCz2V";
// we instanciate our Services_ReCaptcha instance with the public key and the 
// private key
$recaptcha = new Services_ReCaptcha($publicKey, $privateKey);

// we are going to customize our Services_ReCaptcha instance
$recaptcha->setOption('secure', true);   // we force the secure url
$recaptcha->setOption('theme', 'white'); // use the white theme
$recaptcha->setOption('lang', 'fr');     // set language to french

$record = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        // retrieve item record
        $sth = $dbh->query("SELECT * FROM responses WHERE package_id = '$id' order by updated_at desc");
        $record = $sth->fetchALL();
        
        // break due date timestamp into constituent parts
        unset($dbh);        
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }            
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
    <div class="middle">
     <div>
     <div style="float: left"><h2>User FAQ for <?php echo $_GET['name']; ?></h2></div>
     <div style="float: right"><h2>
<div class="fb-like" data-href="http://www.localpackagemanager.com/" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true"></div>
     <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">ツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
     </h2> </div>
     </div>
     <table>
      <tr>
          <th>subject</th>
          <th>name</th>
          <th>date</th>
      </tr>
  <?php foreach ($record as $p) {
  ?>

    <tr>
      <td class="<?php echo $class; ?>"><a href= "./comment.php?rid=<?php echo $p['id']; ?>&name=<?php echo $_GET['name']; ?>&id=<?php echo $_GET['id']; ?>"><?php echo $p['content']; ?></a></td>
      <td class="<?php echo $class; ?>"><?php echo $p['name']; ?></td>
      <td class="<?php echo $class; ?>"><?php echo $p['updated_at']; ?></td>
    </tr>

  <?php } ?>

  </table>
  <a id="err" name="err"></a>
  <?php if (isset($_GET['error'])) {  ?>
  <div id="errorHeader"> <?php echo $_GET['error'] ?> </div> 
  <?php } ?>

  <form method="post" action="save.php">

    <p><label>Content:</label></p>
    <p><textarea name="content" cols="90" rows="4"></textarea></p>
    <p><label>name:</label>
    <input type="text" name="name" class="txt" value="<?php echo $record['name']; ?>"></p>
    <!-- <p><label>email:</label>
    <input type="text" name="email" class="txt" value="<?php echo $record['email']; ?>"></p><br /> -->
    
    <input type="hidden" name="package_id" value="<?php echo $id; ?>">    
    <input type="hidden" name="pid" value="<?php echo $id; ?>">    
    <input type="hidden" name="pnm" value="<?php echo $_GET['name']; ?>">    
    <?php echo $recaptcha; ?>    

    <p><input type="submit" name="submit" value="Submit" class="btn"></p>
  </form>
    </div> <!-- end of middle  -->
  <div class="right">
     <h2>User Feedback </h2>
   <?php include 'popcount.php'; ?>
    <table >
      <tr>
         <th>OS</th>
         <th>Ver</th>
         <th>bit</th>
         <th>OK</th>
         <th>NG</th>
      </tr>
    <?php foreach ($recActionReport as $ra) { ?>
      <tr>
         <td><?php echo $ra["name"];?></td>
         <td><?php echo $ra["ver"];?></td>
         <td><?php echo $ra["bit"];?></td>
         <td><?php echo $ra["okcnt"];?></td>
         <td><?php echo $ra["ngcnt"];?></td>
      </tr>
   <?php } ?>
     </table>

  </div> <!-- end of right -->
  <div class="right">
     <h2>Version UP Request</h2>
   <?php include 'vup.php'; ?>
    <table >
      <tr>
         <th>Version UP Reqest</th>
         <th>Count</th>
      </tr>
    <?php foreach ($recPackages as $r) { ?>
      <tr>
         <td><a href="vupcount.php?id=<?php echo (int) $r['id']; ?>" >VerUP? </a></td>
         <td><?php echo $r['vupcount']; ?></td>
      </tr>
   <?php } ?>
    </table>
  </div> <!-- end of right -->

    <div id="clear"></div>
   </div>
   <div id="bottom"></div>
  </div>
<div id="footer">
<?php include '../include/footerhtml.php'; ?>
</div>
</body>
</html>
