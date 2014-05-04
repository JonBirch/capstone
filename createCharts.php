<?php

    require_once("db_connection.php");
    require_once("functions.php");
    require_once("session.php");
    require_once ("eos.class.php");
  
    //gets all data

    $maxId = 0;

    
    $query  = "SELECT * FROM Data_Table ";
    $query .= "INNER JOIN Sensor_Table ";
    $query .= "ON Data_Table.Sensor_ID = Sensor_Table.Sensor_ID ";
    $query .= "INNER JOIN Location_Table ";
    $query .= "ON Location_Table.Location_ID = Sensor_Table.Location_ID ";
    $query .= "ORDER BY Location, time_stamp";
    
    
            $result = mysqli_query($db,$query);
    
    
            checkQuery($result);
    


            $dataArray = array();
            while($row = mysqli_fetch_array($result)) {
                


                $equation = $row['Equation'];
                $voltage = $row['digital_Voltage'];
                $voltage = $voltage * .0048828125;
                
                
                $equation = str_replace("x",$voltage,$equation);

                $eq = new eqEOS();
                $realData = $eq->solveIF($equation);
        
            $dataArray[$row['Location']][$row['Units']][]=[(strtotime($row['time_stamp']) * 1000),(($realData))];
            
            
            if($row['Data_ID']> $maxId)
            $maxId = $row['Data_ID'];   
            }
            
            setcookie("lastQuery",$maxId);
            
            mysqli_free_result($result);
           
            echo json_encode($dataArray);
 


    
 
?>

