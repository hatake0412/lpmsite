<?php
if(isset($_GET["id"])){

$id = $_GET["id"];

    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        $sth = $dbh->query("SELECT distinct id,ver FROM osvm where os_id = '$id' order by ver");
        $recver = $sth->fetchALL();

        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
$item=array();
foreach($recver as $data){

  $item[]=array($data[0], $data[1]);
}
echo json_encode($item);
}
?>
