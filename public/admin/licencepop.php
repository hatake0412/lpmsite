<?php
$licenceName = null;


    try {
        // connect to database
        $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');

        // retrieve item record
        $sth = $dbh->query("SELECT name FROM licences order by name");
        $licenceName = $sth->fetchALL();

        // break due date timestamp into constituent parts
        unset($dbh);
    } catch (PDOException $e) {
       die('Error: ' . $e->getMessage());
    }
?>

<div id="shadowing"></div>
<div id="box">
  <span id="boxtitle"></span>
  <form method="POST" action="actionLicenceSave.php" name="pop" target = "_parent"> 
    <input type="hidden" name="package_id" id="package_id" value="">  
    <p>Licence:
      <select name="licenceId" id = "licencename" >
        <option selected></option>
        <?php foreach ($licenceName as $l) { ?>
          <option value="<?php echo $l['name']; ?>"><?php echo $l['name']; ?></option>
        <?php } ?>
      </select>
    </p>
  <p> Other_Licence:<input type="text" name="otherlicence" class="txt" value="" ></p>
  <p> 
      <input type="submit" name="submit">
      <input type="button" name="cancel" value="Cancel" onClick="closebox()">
  </p>
  </form>
</div>

