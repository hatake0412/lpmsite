<?php

if (isset($_POST['submit'])) {
 
    if (isset($_POST['package_id']) && is_numeric(trim($_POST['package_id']))) {
        $package_id = (int) $_POST['package_id'];
    } 
    if (isset($_POST['os_id']) && is_numeric(trim($_POST['os_id']))) {
        $os_id = (int) $_POST['os_id'];
    } else {
      $errors='OS is required ';
    }
    if (isset($_POST['osver']) && is_numeric(trim($_POST['osver']))) {
        $vid = (int) $_POST['osver'];
    } else {
      $errors='Version is required ';
    }
    $bit=$_POST["bit"];
    // check action count
     $report = $_POST["report"];
    if (!isset($_POST["report"])) {
        $errors = 'action is required ';
    } else {
      if ($report == "OK"){ 
        $okcnt=1;
        $ngcnt=0;
      } elseif ($report == "NG") {
        $ngcnt=1;
        $okcnt=0;
      }
    }
    
    $memo=""; 
    // print errors and exit
    // if no errors, proceed to save the record to the database
    if (sizeof($errors) > 0) {
        header('Location: index.php?error=' . $errors);
    } else {
        
        try {
            // connect to database
            $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
            // generate UPDATE or INSERT query
            $sth = $dbh->query("SELECT COUNT(id) as cnt FROM actionReports WHERE package_id = '$package_id' and os_id = '$os_id' and vid = '$vid' and bit = '$bit'" );
            $counter=$sth->fetch();
            if($counter['cnt'] == 0){
            $sql = "INSERT OR REPLACE INTO actionReports (id, package_id, os_id, okcnt, ngcnt, memo, vid, bit) 
                    VALUES ((select max(id) from actionReports)+1, ?, ?, ?, ?, ?, ?, ?)";
            $sth = $dbh->prepare($sql);
            //$sth -> bindValue(1,$id, SQLITE3_INTEGER);
            $sth -> bindValue(1,$package_id, SQLITE3_INTEGER);
            $sth -> bindValue(2,$os_id, SQLITE3_INTEGER);
            $sth -> bindValue(3,$okcnt, SQLITE3_INTEGER);
            $sth -> bindValue(4,$ngcnt, SQLITE3_INTEGER);
            $sth -> bindValue(5,$memo, SQLITE3_TEXT);
            $sth -> bindValue(6,$vid, SQLITE3_INTEGER);
            $sth -> bindValue(7,$bit, SQLITE3_INTEGER);
            $result = $sth->execute();
            } else {
              $dbh->exec("UPDATE actionReports set okcnt=okcnt+'$okcnt',ngcnt=ngcnt+'$ngcnt' WHERE package_id = '$package_id' and os_id = '$os_id'");
            }
            unset($dbh);
            // redirect to index page
            header('Location: index.php');
            exit();        
        } catch (PDOException $e) {
           die('Error: ' . $e->getMessage());
        }    
    }    
} else {
    die('Error in form submission');    
}
?>
