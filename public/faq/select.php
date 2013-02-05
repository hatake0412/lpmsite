<?
if(isset($_POST["select"])){

$vselect = $_POST["select"];

    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        $sth = $dbh->query("SELECT distinct ver FROM osvm where os_id = '$vselect' order by ver");
        $recver = $sth->fetchALL();

        // break due date timestamp into constituent parts
        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
$viewdata = "";
$cnt = 0;

foreach($recver as $data){

$ver=$data["ver"];

//データ数のカウント
$cnt++;
$viewdata .= "<option value = ".$ver.">".$ver."</option>";
}

if($cnt){
$viewdata = "<select name = \"tab2\">" . $viewdata;
$viewdata = $viewdata . "</select>";

echo $viewdata;
}
}
?>


  
