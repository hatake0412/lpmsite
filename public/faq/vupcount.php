<?php
session_start();
$_SESSION["cntid"][$_GET['id']]=$_GET['id'];

$ip=$_SERVER['REMOTE_ADDR'];//ipアドレスの取得
if ($ip != $_SESSION["setip"]) {
  $_SESSION["setip"] = $ip;
} else {
  header('Location: index.php?error');
}

// check for record ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
        
        // update item record
        // change status field
        $now = mktime();
        $dbh->exec("UPDATE packages set vupcount=coalesce(vupcount,0)+1, vupip='$ip' WHERE id = '$id'");
//        $dbh->exec("UPDATE packages set vupcount=vupcount+1, vupip='$ip' WHERE id = '$id' and vupip != '$ip'");
        
        // redirect to index page
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }    
} else {
    die('Error in form submission');    
}
?>
