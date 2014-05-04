<?php

   require_once("db_connection.php");
  // require_once("functions.php");
   require_once("session.php");

    //echo("I SEE YOUR POST AND RAISE YOU A QUERY");
    
    $Location = $_POST['Location'];
    $Time = $_POST['Time'];
    $Type = $_POST['Type'];
    $Units = $_POST['Units'];
    
    date_default_timezone_set('America/New_York');
    
    $deleteTime = time() - $Time;
    
    $now = date("Y-m-d H:i:s",$deleteTime);

      
    $nestedQuery = "Select Sensor_ID From Sensor_Table ";
    $nestedQuery .= "INNER JOIN Location_Table ";
    $nestedQuery .= "ON Sensor_Table.Location_ID = Location_Table.Location_ID ";
    $nestedQuery .= "INNER JOIN Type_Table ";
    $nestedQuery .= "ON Sensor_Table.Type_ID = Type_Table.Type_ID ";
    $nestedQuery .= "WHERE Location = '{$Location}' ";
    $nestedQuery .= "AND Type = '{$Type}' ";
    $nestedQuery .= "AND Units = '{$Units}' ";
    
    
    echo($nestedQuery);
      
      
      
    $query = "Delete From Data_Table ";
    $query .= "WHERE time_stamp > {$Time} ";
    $query .= "AND Data_Table.Sensor_ID = ($nestedQuery) ";
    
    $result = mysqli_query($db,$query);
    

   //  echo(checkQuery($result));
    

?>