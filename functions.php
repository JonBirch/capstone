<?php


    require_once ("eos.class.php");

    function redirect_to($new_location) {
        
	  header("Location: " . $new_location);
	  exit;
	}

    function checkQuery($result){
        
         global $db;
        
        if(!$result){    
            die("Query Failed " . mysqli_error($db));
        }else{
            return $result;
            }
        
     
    }
    function hasNewSensors(){
        
        global $db;
        
            $query =  "Select * ";
            $query .= "From Sensor_Table ";
            $query .= "WHERE Location_ID = 1 ";
        
            $result = mysqli_query($db,$query);
      
            checkQuery($result);
                
            if(mysqli_num_rows($result) > 0){
                 
                mysqli_free_result($result);
                 echo "true";
     
            }else{
                mysqli_free_result($result);
                echo "false";
            
            }
        
        
    }
    function isUser($username){
        
        global $db;
        
            $query =  "Select * ";
            $query .= "From User_Table ";
            $query .= "Where Username = '{$username}' ";
        
            $result = mysqli_query($db,$query);
      
            checkQuery($result);
                
            if(mysqli_num_rows($result) > 0){
                 
                while($row = mysqli_fetch_assoc($result)){
                    
                    mysqli_free_result($result);
                    return $row;

                }
     
            }else{
                mysqli_free_result($result);
                return null;
            
            }
        
        
    }
    
    function generatePassword($password){
        
       //use blowfish ten times
        $hashFormat = "$2y$10$";
        
        $saltLength = 22;
        
        $salt = generateSalt($saltLength);
        
        $formatAndSalt = $hashFormat . $salt;
        
        $hash = crypt($password,$formatAndSalt);
        
        return $hash;
        
        
    }
    
    
    function generateSalt($length){
        
        $uniqueString = md5(uniqid(mt_rand(),true));
        
        $validString = str_replace('+','.',base64_encode($uniqueString));
        
        $salt = substr($validString,0,$length);
        
        return $salt;    
        
    }
    
    function passwordCheck($password,$dbHash){
        
        $hash = crypt($password,$dbHash);
        
        if($hash === $dbHash){
            return true;
        }else{
            return false;
        }
        
        
    }
    function attemptLogin($username,$password){
        
        $user = isUser($username);
        
        if($user){
            if(passwordCheck($password,$user['Password'])){
                //matched passwords
                return $user;
            }else{
                
                return false;
            }
        }else{
            
            return false;
        }
        
    }

    
    function isUnique($username){
        
        global $db;
        
            $query =  "Select * ";
            $query .= "From User_Table ";
            $query .= "Where Username = '{$username}' ";
        
            $result = mysqli_query($db,$query);
      
            checkQuery($result);
                
            if(mysqli_num_rows($result) > 0){
                
                mysqli_free_result($result); 
                return false;
     
            }else{
            
                mysqli_free_result($result);
                return true;
            
            }
    }   

    
function getActiveChannels(){
    
            global $db;
           
        
            $query =  "Select * ";
            $query .= "From Sensor_Table ";
            $query .= "INNER JOIN Location_Table ";
            $query .= "ON Sensor_Table.Location_ID = Location_Table.Location_ID ";
	    $query .= "INNER JOIN Type_Table ";
            $query .= "ON Sensor_Table.Type_ID = Type_Table.Type_ID ";
            $query .= "Where Active = '1' ";
        
            $result = mysqli_query($db,$query);
      
            checkQuery($result);
            
             $activeArray = array();
            
            while($row = mysqli_fetch_assoc($result)){
                

                $activeArray[$row['Channel']] = $row;
      

            }
            
            mysqli_free_result($result);

            return $activeArray;
    
    
           
}

function createChannelDivs() {

 
   //call getactiveChannels();
   
   $activeChannels = getActiveChannels();
   
   $optionArray = getLocations();
   
   $typeArray = getTypes();
   

   
   //pulls active channels into array
    $list = "<ul>";
   //create tab list using for
   for ($i = 1; $i <= count($activeChannels); $i++) {
      
	$list .= "<li><a href='#tabs-{$activeChannels[$i]['Channel']}'> Channel {$activeChannels[$i]['Channel']} </a></li>";
   }
   
   $list .= "</ul>";
   
   $div = "";
   //create divs for each list item
   
   for($j = 1; $j <= count($activeChannels); $j++){
      
   $div .=
    "<div id='tabs-{$activeChannels[$j]['Channel']}' name='{$activeChannels[$j]['Channel']}'>".
        "<h2>Channel {$activeChannels[$j]['Channel']} </h2>".

        "<br/>".
        
        "<form id='form{$activeChannels[$j]['Channel']}'> ".
        
        
        "<input type='hidden' id='Sensor_ID{$activeChannels[$j]['Channel']}' name='Sensor_ID' value='{$activeChannels[$j]['Sensor_ID']}' hidden='hidden' readonly >".
        
        "<table id='channelTable'>".
        
        "<tr><td>".
        
        "<label for='location{$activeChannels[$j]['Channel']}'>Location</label>".
        
        "</td><td>".
	
	"<label for='type{$activeChannels[$j]['Channel']}'>Type</label>".
        
        "</td><td>".
        
        "<label for='equation{$activeChannels[$j]['Channel']}'>Units".
	
	" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Equation</label>".
         
        "</td></tr><tr><td>".


            "<select id='location{$activeChannels[$j]['Channel']}' name='location{$activeChannels[$j]['Channel']}' >";

                for($k = 0; $k < count($optionArray); $k++){
                    
                    if($activeChannels[$j]['Location'] == $optionArray[$k]){
                        
                        $div .= "<option selected='selected' value='{$optionArray[$k]}'>{$optionArray[$k]}</option>";
                        
                    }else{
                
                         $div .= "<option value='{$optionArray[$k]}'>{$optionArray[$k]}</option>";

                 }    
                }
            
           $div .= "</select>".
	   
	  
	  " <input type='button' value='+' id='locationButton' onClick='openLocationDialog({$activeChannels[$j]['Channel']})' ".
	  	
	    "</td><td>".

          "<select id='type{$activeChannels[$j]['Channel']}' name='type{$activeChannels[$j]['Channel']}'>";
	  
	                  for($k = 0; $k < count($typeArray); $k++){
                    
                    if($activeChannels[$j]['Type'] == $typeArray[$k]){
                        
                        $div .= "<option selected='selected' value='{$typeArray[$k]}'>{$typeArray[$k]}</option>";
                        
                    }else{
                
                         $div .= "<option value='{$typeArray[$k]}'>{$typeArray[$k]}</option>";

                 }    
                }
	  
	  $div .= "</select>".
	  
	   " <input type='button' value='+' id='typeButton' onClick='openTypeDialog({$activeChannels[$j]['Channel']})' ".
        
  
             "</td><td>".
	    
	    "<input type='text' id='units{$activeChannels[$j]['Channel']}' size='10' value='{$activeChannels[$j]['Units']}' name='units{$activeChannels[$j]['Channel']}'>".

        
            "=<input type='text' id='equation{$activeChannels[$j]['Channel']}' size='30' value='{$activeChannels[$j]['Equation']}' name='equation{$activeChannels[$j]['Channel']}'>".
              
                
            
             "</td></tr>".
         
         "</table>".
         
         "<br/>".
	 "<br/>".
	 "<br/>".
         
        " <input type='button' value='Apply' id='Apply' onClick='updateChannel({$activeChannels[$j]['Channel']})' style='float:right;'>".
    
   
    
        '</form>'.
    
    "<br/>".
    
    '</div>';
      
      
   }
   
   //return entire string
   
   echo($list.$div);
   
}

function createDummyData(){
    
    //create dummy data for both sensor_ID Table and Data_Table.
    
        global $db;
    

    $j = 1;
    
    $k = 9;
    
    for($i = 1;$i <= 20;$i++){
        
        
        
        
        if($i == $j + $k){           
            $j++;
            $k = ($k + 10) - $j;
       
        }
    
    $current = $k * $j * $i;
    
    
            $query =  "INSERT INTO Data_Table ";
            $query .= "VALUES (default,default,$current,$j)";
            
            
           
        
        
            $result = mysqli_query($db,$query);
      
            sleep(5);
      
        
        echo(checkQuery($result));
            
            
            
}
}



function createChartData($result){
    
            $maxId = 0;
            
            $dataArray = array();
            while($row = mysqli_fetch_array($result)) { 
           
	   
                $equation = $row['Equation'];
                $voltage = $row['digital_Voltage'];
                $voltage = $voltage * .0048828125;
                
                
                $equation = str_replace("x",$voltage,$equation);

                $eq = new eqEOS();
                $realData = $eq->solveIF($equation);
        
            
            $dataArray[$row['Location']][$row['Units']][]=[(strtotime($row['time_stamp']) * 1000),(($realData))];
            
            
            if($row['Data_ID']> $maxId){
            
                 $maxId = $row['Data_ID'];
            }
            }
            
            setcookie("lastQuery",$maxId);

           
           return json_encode($dataArray);
    
    
    
}

function getLocations(){
    
                global $db;
           
        
            $query =  "Select Location ";
            $query .= "From Location_Table ";

        
            $result = mysqli_query($db,$query);
      
            checkQuery($result);
            
            $locationArray = array();
            
            while($row = mysqli_fetch_assoc($result)){
                

                $locationArray[] = $row['Location'];
      

            }
            
            mysqli_free_result($result);

            return $locationArray;

    
}
function getTypes(){
    
            global $db;
           
        
            $query =  "Select Distinct Type ";
            $query .= "From Type_Table ";

        
            $result = mysqli_query($db,$query);
      
            checkQuery($result);
            
            $typeArray = array();
            
            while($row = mysqli_fetch_assoc($result)){
                $typeArray[] = $row['Type'];
            }
            
            mysqli_free_result($result);

            return $typeArray;
}
?>