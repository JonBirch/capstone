<?php

   require_once("db_connection.php");
   require_once("functions.php");
   require_once("session.php");

    //echo("I SEE YOUR POST AND RAISE YOU A QUERY");
    
    $Primary_KEY = ($_POST['Sensor_ID']);
    $location = $_POST["location"];
    $equation = $_POST["Equation"];
    $units = $_POST["Units"];
    $type = $_POST["Type"];
    
   $locationID;
    $typeID;
      
   getLocationID($db,$location);
   getTypeID($db,$type,$units,$equation);
 
 
    //write update or insert query for channels 
    $query = "UPDATE Sensor_Table SET ";
    $query .= "Location_ID = {$locationID}, ";
    $query .= "Type_ID = {$typeID} ";
    $query .= "WHERE Sensor_ID = {$Primary_KEY}";
    

   $result = mysqli_query($db,$query);
    
    

    echo(checkQuery($result));
    
    
    
    
    function getLocationID($db,$location){
   global $locationID;
    $query = "Select * From Location_Table ";
    $query .= "WHERE Location = '{$location}'";
    
    $result = mysqli_query($db,$query);
    
    checkQuery($result);
      
     if(mysqli_num_rows($result) > 0){

     
        while($row = mysqli_fetch_assoc($result)){  
           
           $locationID = $row['Location_ID'];
        }
     
     }else{
        
            $query = "INSERT INTO Location_Table ";
            $query .= "Values(default,'{$location}')";
        
        
            mysqli_query($db,$query);
            
            
            $locationID = mysqli_insert_id($db); 
        
     }
      
      
      
      
    }
    function getTypeID($db,$type,$units,$equation){
      global $typeID;
    $query = "Select * From Type_Table ";
    $query .= "WHERE Type = '{$type}' ";
    $query .= "AND Units = '{$units}' ";
    $query .= "AND Equation = '{$equation}' ";
    
    $result = mysqli_query($db,$query);
    
    checkQuery($result);
      
     if(mysqli_num_rows($result) > 0){

     
        while($row = mysqli_fetch_assoc($result)){  
           
            $typeID = $row['Type_ID'];
        }
     
     }else{
        
            $query = "INSERT INTO Type_Table ";
            $query .= "Values(default,'{$type}','{$units}','{$equation}')";
        
        
            mysqli_query($db,$query);
            
            
            $typeID = mysqli_insert_id($db); 
        
     }
      
      
      
      
    }

?>