<?php

   //Open up Connection to the database
  
    define("SERVER","localhost");
    define("USER","jon");
    define("PASS","toor");
    define("DATABASE","capstone");

  
    $db = mysqli_connect(SERVER,USER,PASS,DATABASE);
  
  
    if(mysqli_connect_errno()){
        
        die("Database Connection Failed: " .
                 mysqli_connect_error() .
                    "(" . mysqli_connect_errno().")");
        
        
    }

?>