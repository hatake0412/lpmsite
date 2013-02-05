<?php
$recname = null;
$recver = null;
$recbit = null;


    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        // retrieve item record
        $sth = $dbh->query("SELECT name FROM osmaster order by name");
        $recname = $sth->fetchALL();

        $sth = $dbh->query("SELECT distinct ver FROM osvm order by ver");
        $recver = $sth->fetchALL();

        $sth = $dbh->query("SELECT distinct bit FROM osvm order by bit");
        $recbit = $sth->fetchALL();

        // break due date timestamp into constituent parts
        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
?>

<div id="shadowing"></div>
<div id="box">
  <span id="boxtitle"></span>
  <form method="POST" action="actionReportsSave.php" name="pop" target = "_parent"> 
  <input type="hidden" name="package_id" id="package_id" value="">  
  <p>OS:
     <select name="os_id" id = "osname" ></select>
  </p>
  <p>Version:
     <select name="osver" id = "osver"></select>
  </p>
<script type="text/javascript">
$(function() {
  $("#osname").jCombo("getOsName.php");
  $("#osver").jCombo("getOsVer.php?id=", {parent: "#osname"});
});
</script>
  <p>bit:
     <select name="bit">
        <option selected></option>
        <option value="32">32</option>
        <option value="64">64</option>
     </select>
  </p>
  <p> action OK<input type="radio" name="report" class="txt" value="OK" ></p>
  <p> action NG<input type="radio" name="report" class="txt" value="NG" ></p>
    <p> 
      <input type="submit" name="submit">
      <input type="button" name="cancel" value="Cancel" onClick="closebox()">
    </p>
  </form>
</div>

