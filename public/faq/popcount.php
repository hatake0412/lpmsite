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
				sum(ar.okcnt) as okcnt,
				sum(ar.ngcnt) as ngcnt
		             FROM  osmaster om, actionReports ar
			     where
				package_id = '$pid'
				and om.id = ar.os_id
			     group by package_id, os_id
			     order by os_id");

        $recall = $sth->fetchALL();

        $sth = $dbh->query("SELECT
                            ar.id as id,
                            ar.package_id as package_id,
                            om.id as os_id,
                            om.name as name,
                            osvm.ver as ver,
                            ar.bit as bit,
                            ar.okcnt as okcnt,
                            ar.ngcnt as ngcnt
                            FROM osmaster om, actionReports ar, osvm
                            where
                            package_id = '$package_id'
                            and om.id = ar.os_id
                            and ar.os_id=osvm.os_id
                            and ar.vid=osvm.id
                            order by os_id");

        $recActionReport = $sth->fetchALL();

        // break due date timestamp into constituent parts
        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
?>

