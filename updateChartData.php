<?php

    require_once("db_connection.php");
    require_once("functions.php");

    

    define('MESSAGE_TIMEOUT_SECONDS', 30);
 

    define('MESSAGE_TIMEOUT_SECONDS_BUFFER', 5);

    set_time_limit(MESSAGE_TIMEOUT_SECONDS+MESSAGE_TIMEOUT_SECONDS_BUFFER);
 
    
    $id = $_COOKIE['lastQuery'];
    
    
    
    //get request and
    
    while(true)
    {
    // Check for new data (not illustrated)
       $data = getNewData($id);
       
        if(isset($data))
        {
            print_r($data);
            break;
        }
        else
        {
        // Otherwise, sleep for the specified time, after which the loop runs again
            usleep(100000);
 

        }
    }
    
    
    
    function getNewData($id){
        
        global $db;
        
            $query  = "SELECT * FROM Data_Table ";
            $query .= "INNER JOIN Sensor_Table ";
            $query .= "ON Data_Table.Sensor_ID = Sensor_Table.Sensor_ID ";
            $query .= "INNER JOIN Location_Table ";
            $query .= "ON Location_Table.Location_ID = Sensor_Table.Location_ID ";
            $query .= "WHERE Data_ID > $id ";
            $query .= "ORDER BY Location, time_stamp";
        
        
          $result = mysqli_query($db,$query);
          
          checkQuery($result);
          
            if(mysqli_num_rows($result) > 0){
                
                
                $newData = createChartData($result);
                 
                mysqli_free_result($result);
                 
                return $newData;
 
            }else{
            
               return null;
            
            }
       
        
        
    }

    

?>
