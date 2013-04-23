<?php
define("PASSWORD", "pass");
session_start();
if(isset($_SESSION["lpmAdmin"]) && $_SESSION["lpmAdmin"] != null && hash_hmac('sha256',PASSWORD,false) === $_SESSION["lpmAdmin"]){

}else{
    session_destroy();//セッション破棄
    header('Location: index.php?error=Login Failure');
}
if (isset($_POST["approval"])){
  $val=1;
} elseif (isset($_POST["reject"])){
  $val=99;
} else {
  $val=0;
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
        $dbh->exec("UPDATE packages set approval='$val' WHERE id = '$id'");
        
        // redirect to index page
        header('Location: admin.php');
        exit();
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }    
} else {
    die('Error in form submission');    
}
?>
