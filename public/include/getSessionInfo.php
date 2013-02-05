<?php
    session_start( ) ;

    if ( !isset( $_SESSION['session_data'] ) {
        print -1 ;
        exit ;
    }
    else {
        print $_SESSION['session_data'] ;
        exit ;
    }
?>
