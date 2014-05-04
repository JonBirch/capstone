<?php


   require_once("db_connection.php");
   require_once("functions.php");
   require_once("session.php");


    $location = $_POST['Location'];


    $query = "Select Distinct Type From Type_Table ";
    $query .= "Inner JOIN Sensor_Table ";
    $query .= "ON Sensor_Table.Type_ID = Type_Table.Type_ID ";
    $query .= "Inner JOIN Location_Table ";
    $query .= "ON Sensor_Table.Location_ID = Location_Table.Location_ID ";
    $query .= "Where Location = '{$location}' ";

    $result = mysqli_query($db,$query);
      
    checkQuery($result);
            
    $list = "";
            
        while($row = mysqli_fetch_assoc($result)){
                
            $type = $row['Type'];
                
            $list .= "<option value='{$type}'>{$type}</option>";


        }
            
            
      echo $list;


?>