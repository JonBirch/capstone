<?php

   require_once("functions.php");
   require_once("session.php");
   
   $_SESSION['userID'] = null;
   $_SESSION['theme'] = null;
   
    redirect_to("index.php");


?>