<?php
$add_to = "hatake0412@gmail.com";
    $subject = "about" ;
    $message = "掲示板に新しい書き込みがありました。\n\n\n";
    mb_send_mail($add_to, $subject, $message);
?>
