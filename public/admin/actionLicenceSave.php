<?php

if (isset($_POST['submit'])) {
 
    if (isset($_POST['package_id']) && is_numeric(trim($_POST['package_id']))) {
        $package_id = (int) $_POST['package_id'];
    } 

    if (isset($_POST['otherlicence']) && $_POST['otherlicence'] != "") {
        $licenceid = $_POST['otherlicence'];

    } elseif (isset($_POST['licenceId']) ) {
        $licenceid = $_POST['licenceId'];

    } elseif ( $licenceid == "") {
      $errors='Please enter or licensed to select the license ';
    } else {
      $errors='Please enter or licensed to select the license ';
    }

    
    if (sizeof($errors) > 0) {
        header('Location: admin.php?error=' . $errors);
    } else {
        
        try {
            // connect to database
            $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
            // generate UPDATE or INSERT query
            $sql = "UPDATE packages set licence = ? where id = ?";
//            $sql = "UPDATE packages set licence = '$licenceid' where name = (select name from packages where id = '$package_id')";
            $sth = $dbh->prepare($sql);
            $sth -> bindValue(1,$licenceid, SQLITE3_TEXT);
            $sth -> bindValue(2,$package_id, SQLITE3_INTEGER);
            $result = $sth->execute();
            unset($dbh);
            // redirect to index page
            header('Location: admin.php');
            exit();        
        } catch (PDOException $e) {
           die('Error: ' . $e->getMessage());
        }    
    }    
} else {
    die('Error in form submission');
}

?>

