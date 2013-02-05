<?php
    $langs = $_POST['langs'] ;
    if ( checkPostData( $langs ) == true ) {
        $session_data = makeSession( $langs ) ;
        $_SESSION['session_data'] = $session_data ;
        print "OK" ;
    }
    else {
        print "NG" ;
    }
    exit ;
?>
