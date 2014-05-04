<?php

    require_once("db_connection.php");
    require_once("functions.php");
    require_once("session.php");
    
    
    $Channel = ($_POST['Channel']);
    $id;
    
    
    $query = "Select * From Sensor_Table, Server_Table ";
    $query .= "Where Channel = {$Channel} ";
    $query .= "AND Time_Created > Server_Table.UpTime ";
    $query .= "ORDER BY Time_Created DESC ";
    $query .= "LIMIT 1";
    
    $result = mysqli_query($db,$query);
    
    checkQuery($result);

    if(mysqli_num_rows($result) > 0){
                 
        while($row = mysqli_fetch_assoc($result)){
            
            //get id then update where id = id
            $id = $row['Sensor_ID'];
            
        }
                $query = "UPDATE Sensor_Table ";
                $query .= "SET Active = 1 ";
                $query .= "Where Sensor_ID = {$id} ";
     
        }else{
               
               // insert new sensor into table
                $query = "INSERT INTO Sensor_Table ";
                $query .= "VALUES(default,{$Channel},default,1,1,{$Channel}) ";     
                   
            
            }
            

    $result = mysqli_query($db,$query);
    
    $my_file = 'change.txt';
    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file
    
    echo(checkQuery($result));


?>