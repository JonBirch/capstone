<?php
   
   require_once("db_connection.php");
   require_once("functions.php");
   require_once("session.php");

   
   $username = $_POST['username'];
   $password = $_POST['password'];
 
  
    //query the database for username and password
      
    $user = attemptLogin($username,$password);

    if($user){
        
        $_SESSION["userID"] = $user["Username"];
        
        $_SESSION["theme"] = $user["Theme"];

        
        echo true;
        
        
    }else{
        
        echo "Username or Password Not Found";
    }
   
   
   
    //if match send to setup.html
    
    
    
    
    
    //else show error and ask for retype
   
   
   
    //Close connection to the DataBase
     mysqli_close($db);
   
   
?>




