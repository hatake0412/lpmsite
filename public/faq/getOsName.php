<?php
    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        $sth = $dbh->query("SELECT id,name FROM osmaster;");
        $recos = $sth->fetchALL();

        // break due date timestamp into constituent parts
        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
$item=array();

foreach($recos as $data){

  $item[] = array($data[0], $data[1] );
}
echo json_encode($item);
?>


  
