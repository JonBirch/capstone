<?php

    require_once("db_connection.php");
    require_once("functions.php");
    require_once("session.php");
    

    $id = $_POST['Sensor_ID'];
    

    $query = "UPDATE Sensor_Table ";
    $query .= "SET Active = 0 ";
    $query .= "Where Sensor_ID = {$id} ";
     
            

    $result = mysqli_query($db,$query);
    
    $my_file = 'change.txt';
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
    
    echo(checkQuery($result));


?>