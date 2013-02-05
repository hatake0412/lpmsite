<?php
$recall = null;
$pid=$p['id'];
$package_id=$_GET['id'];
    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        $sth = $dbh->query("SELECT 
                            ar.id as id,
                            ar.package_id as package_id,
                            om.id as os_id,
                            om.name as name,
                            ar.okcnt as okcnt,
                            ar.ngcnt as ngcnt 
                            FROM  (osmaster om left join actionReports ar on om.id = ar.os_id) left join osvm on om.id=osvm.os_id
                            where 
                            package_id = '$pid' 
                            group by package_id, os_id
                            order by name , bit");

        $recall = $sth->fetchALL();

        $sth = $dbh->query("SELECT
                            ar.id as id,
                            ar.package_id as package_id,
                            om.id as os_id,
                            om.name as name,
                            osvm.ver,
                            osvm.bit,
                            ar.okcnt as okcnt,
                            ar.ngcnt as ngcnt
                            FROM  (osmaster om left join actionReports ar on om.id = ar.os_id) left join osvm on om.id=osvm.os_id
                            where
                            package_id = '$package_id'
                            group by package_id, os_id
                            order by name , bit");

        $recActionReport = $sth->fetchALL();

        // break due date timestamp into constituent parts
        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
?>

