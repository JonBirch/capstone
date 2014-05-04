<?php

    require_once("db_connection.php");
    require_once("functions.php");
    require_once("session.php");

  
   $theme = $_POST["Theme"];
   $userID = $_SESSION['userID'];
  
  
            $query =  "UPDATE User_Table ";
            $query .= "SET Theme = '{$theme}' ";
            $query .= "WHERE Username = '{$userID}';";
            
            
            $result = mysqli_query($db,$query);
            
            $_SESSION['theme'] = $theme;
      
      
            echo (checkQuery($result));


    
 
?>

