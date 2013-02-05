<?php
session_start();

if ($_SESSION["LANGS"]=="JA") {
  $_SESSION["LANGS"]="ENG";
} elseif ($_SESSION["LANGS"]=="ENG"){
  $_SESSION["LANGS"]="JA";
} else {
  $_SESSION["LANGS"]="ENG";
}
if( $_SERVER[HTTP_REFERER] != NULL ){
  header("Location: $_SERVER[HTTP_REFERER]");
}
else{
  header('Location: /index.php');
}

?>
