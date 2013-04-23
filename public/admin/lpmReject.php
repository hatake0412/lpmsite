<?php
define("PASSWORD", "pass");
session_start();
if(isset($_SESSION["lpmAdmin"]) && $_SESSION["lpmAdmin"] != null && hash_hmac('sha256',PASSWORD,false) === $_SESSION["lpmAdmin"]){

}else{
    session_destroy();//セッション破棄
    die('Login Failure');
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
        $dbh->exec("UPDATE packages set approval=99 WHERE id = '$id'");
        
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
