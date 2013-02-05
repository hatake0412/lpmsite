<?php
require ('Services/ReCaptcha.php');

  $publicKey  = "6LfflNkSAAAAAHmGkLnEs10x9ImiyVkueLJWqduk";
  $privateKey = "6LfflNkSAAAAAGKpL-PNxcS2N9L9_p-ftUnoCz2V";
//  $errors = array();

if (isset($_POST['submit'])) {
  $recaptcha = new Services_ReCaptcha($publicKey, $privateKey);
    if ($recaptcha->validate()) {
        // the catpcha challenge response is ok, we display a message and exit
    } else {
        // if the captcha validation failed, instead of letting the captcha
        // display the error, we want to echo the error and exit
       $errors= $recaptcha->getError();
       header('Location: form.php?id=' . $package_id .'&name=' . $_POST['pnm'].'&error=' . $recaptcha->getError());
    }
 
    // check if record ID exists in the form submission
    if (isset($_POST['package_id']) && is_numeric(trim($_POST['package_id']))) {
        $package_id = (int) $_POST['package_id'];
    }

    // check name
    $name = $_POST['name'];
    if (!isset($_POST['name']) ) {
        $errors = 'Invalid name';
    }
             
    // check email
/*     $email = $_POST['email'];
    if (!isset($_POST['email']) || !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
        $errors = 'Invalid email';
    }
*/
    // check content
     $content = $_POST["content"];
    if (!isset($_POST["content"])) {
        $errors = 'Invalid comment';
    }
    
    // print errors and exit
    // if no errors, proceed to save the record to the database
    if (sizeof($errors) > 0) {
        header('Location: form.php?id=' . $package_id .'&name=' . $_POST['pnm'].'&error=' . $errors);
    } else {
        
        try {
            // connect to database
            $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
            // generate UNIX timestamp for due date
            $created_date =  date('Y-m-d H:i:s');

            // generate UPDATE or INSERT query
            $sql = "INSERT INTO responses (name, email, content, package_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
            $sth = $dbh->prepare($sql);
            $sth -> bindValue(1,$name, SQLITE3_TEXT);
            $sth -> bindValue(2,$email, SQLITE3_TEXT);
            $sth -> bindValue(3,$content, SQLITE3_TEXT);
            $sth -> bindValue(4,$package_id, SQLITE3_INTEGER);
            $sth -> bindValue(5,$created_date, SQLITE3_TEXT);
            $sth -> bindValue(6,$created_date, SQLITE3_TEXT);
            // $sqlparam = array ($name, $email, $content, $package_id, $created_date, $created_date);
            // print_r $sqlparam; 
            // execute query
            $result = $sth->execute();
            unset($dbh);
            $package_id=$_POST['pid']; 
            // redirect to index page
            header('Location: form.php?id=' . $package_id .'&name=' . $_POST['pnm']);
            exit();        
        } catch (PDOException $e) {
           die('Error: ' . $e->getMessage());
        }    
    // sending mail
    $add_to = "hatake0412@gamil.com";
    $subject = "about" . $_POST["pnm"];
    $message = "掲示板に新しい書き込みがありました。\n\n\n"
               .$content . "\n\n" 
               .$_SERVER["HTTP_HOST"] .form.php?id=' . $package_id .'&name=' . $_POST['pnm']; 
    mb_send_mail($add_to, $subject, $message); 
    }    
} else {
    die('Error in form submission');    
}
?>
