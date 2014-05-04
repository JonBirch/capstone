<?php
        require_once("db_connection.php");
        require_once("session.php");
        require_once("functions.php");

        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        
        //check to see if unique
        if(isUnique($username)){
            
           $password = generatePassword($password);
            
            $query =  "INSERT INTO User_Table ";
            $query .= "VALUES (default,'{$username}','{$password}',1)";

        
            $result = mysqli_query($db,$query);

            
            $_SESSION["userID"] = $username;
            $_SESSION["theme"] = 1;
            

            echo("1");
        }else{
            mysqli_free_result($result);
            echo"Username Already Used";
            
        }
        
        
        //encrypt
        
        //insert into database
        
        
        //if user inserted set session
        
        //else throw error



?>








