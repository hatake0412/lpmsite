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
       header('Location: comment.php?rid=' . $_POST['rid'] . '&id=' . $_POST['pid'] .'&name=' . $_POST['pnm'].'&error=' . $recaptcha->getError());
    }
 
    // check if record ID exists in the form submission
    if (isset($_POST['rid']) && is_numeric(trim($_POST['rid']))) {
        $response_id = (int) $_POST['rid'];
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
     $content = nl2br($_POST["content"]);
    if (!isset($_POST["content"])) {
        $errors = 'Invalid comment';
    }
    
    // print errors and exit
    // if no errors, proceed to save the record to the database
    if (sizeof($errors) > 0) {
       header('Location: comment.php?rid=' . $_POST['rid'] . '&id=' . $_POST['pid'] .'&name=' . $_POST['pnm'].'&error=' . $errors);
    } else {
        
        try {
            // connect to database
            $dbh = new PDO('sqlite:/var/www/lpm/db/development.sqlite3');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
            // generate UNIX timestamp for due date
            $created_date =  date('Y-m-d H:i:s');
	    $solved = $_POST['solved'];

            // generate UPDATE or INSERT query
            $sql = "INSERT INTO comments (name, email, content, response_id, solved, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $sth = $dbh->prepare($sql);
            $sth -> bindValue(1,$name, SQLITE3_TEXT);
            $sth -> bindValue(2,$email, SQLITE3_TEXT);
            $sth -> bindValue(3,$content, SQLITE3_TEXT);
            $sth -> bindValue(4,$response_id, SQLITE3_INTEGER);
            $sth -> bindValue(5,$solved, SQLITE3_TEXT);
            $sth -> bindValue(6,$created_date, SQLITE3_TEXT);
            $sth -> bindValue(7,$created_date, SQLITE3_TEXT);
            // $sqlparam = array ($name, $email, $content, $package_id, $created_date, $created_date);
            // print_r $sqlparam; 
            // execute query
            $result = $sth->execute();
            unset($dbh);
            $package_id=$_POST['pid']; 
            // redirect to index page

       $add_to = "hatake0412@gmail.com";
       $subject = "about  " . $_POST["pnm"];
       $message1 = "掲示板に新しい書き込みがありました。\n\n\n =============書き込み内容============\n\n";
       $message2 = $content .                          "\n\n\n =====================================\n\n\n\n";
       $message3 = "http://" . $_SERVER["HTTP_HOST"] ."/faq/form.php?id=" . $_POST['pid'] . "&name=" . $_POST['pnm'];
       mb_send_mail($add_to, $subject, $message1 . $message2 . $message3);
       header('Location: comment.php?rid=' . $_POST['rid'] . '&id=' . $_POST['pid'] .'&name=' . $_POST['pnm']);
            exit();        
        } catch (PDOException $e) {
           die('Error: ' . $e->getMessage());
        }    
    }    
} else {
    die('Error in form submission');    
}
?>
