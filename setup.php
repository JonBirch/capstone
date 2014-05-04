<!doctype html>

<?php

    require_once("db_connection.php");
    require_once("functions.php");
    require_once("session.php");

    if(!isset($_SESSION['userID'])){
        redirect_to('index.php');    
    }
?>



<html lang="en">

<head>
    
    <title>Configure</title>
    
    <!--Bring in the css-->
        <?php
    if(isset($_SESSION["theme"])){
      
      switch($_SESSION["theme"]){
         
         
         case 1:
            
             echo( '<link rel="stylesheet" type="text/css" href="css/theme1.css">');
            break;
         
         
         case 2:
            
             echo( '<link rel="stylesheet" type="text/css" href="css/theme2.css">');
            break;
         
         
         
         case 3:
            
            
             echo( '<link rel="stylesheet" type="text/css" href="css/theme3.css">');
            break;
 
      }
  
    }else{
      
       echo( '<link rel="stylesheet" type="text/css" href="css/theme1.css">');
      
    }
    
    
    ?>
    <link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.min.css">    
        
    <!--Bring in the Scripts-->    
    <script language="javascript" type="text/javascript" src="js/scripts.js"></script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.min.js"></script>


</head>    
<body>
    
    
    <pre id="header">Capstone Website</pre>
    
            <div class="links">

            <a id="home">Home</a>
            <br/>
            <br/>
            <a id="logout">Log Out</a>

    
         </div>
    <hr/>
    
    
    <br/>
    <br/>
  <script>      
        
        $(function() {
             $("#tabs").tabs({
         
                 beforeActivate: function( event, ui ) {

                        if(ui.newPanel.attr('name')){
                            
                            
                        }
                   
            }
        });

    $("#updateDialog").dialog({
            
            autoOpen : false,
            resizable: false,
            modal: true,
            draggable: false,
            buttons:{
                
                "OK": function(){
                    
                    $(this).dialog("close");
   
                },
                
            }

             
            
            });
    
        $("#addLocation").dialog({
            
            autoOpen : false,
            resizable: false,
            modal: true,
            draggable: false,
            buttons:{
                
                "Add": function(){
                    
                    $(this).dialog("close");
                    addLocation();
   
                },
                
            }

             
            
            });
        
                $("#addType").dialog({
            
            autoOpen : false,
            resizable: false,
            modal: true,
            draggable: false,
            buttons:{
                
                "Add": function(){
                    
                    $(this).dialog("close");
                    addType();
   
                },
                
            }

             
            
            });
        
                $("#deleteWarning").dialog({
            
            autoOpen : false,
            resizable: false,
            modal: true,
            draggable: false,
            buttons:{
                
                
                "Cancel": function(){
                    
                    $(this).dialog("close");
               
   
                },
                
                "OK": function(){
                    
                   
                    $(this).dialog("close");
                    deleteChannelData(document.getElementById("channelID").value);

   
                },

                
            }

             
            
            });
            $("#deleteDataDialog").dialog({
            
            autoOpen : false,
            resizable: false,
            width: "400px",
            within: "top",
            at: "top",
            modal: true,
            draggable: false,
            buttons:{
                
                
                "Cancel": function(){
                    
                    $(this).dialog("close");
               
   
                },
                
                "Delete": function(){
                    
                   
                    $(this).dialog("close");
                    deleteData();

   
                },

                
            }

             
            
            });
        
        
        });

        $("#home").on("click", function(){
            
           window.location.href = 'index.php';
            
        });
        $("#logout").on("click", function(){
            
           window.location.href = 'logout.php';
            
        });


        
 </script>
  

<div id="tabs">
    
    


<?php

createChannelDivs();


?>

</div>

<br/>

<table align="center">

<tr>
    <td>
<div id="themeDiv" class="tableDivs" >
    
    <label for="themeSelect" >Choose Theme</label>
     <hr/>
    <select name="themeSelect" align="center" id="themeSelect" onchange="changeTheme('setup.php');">
        <option value="1" <?php if(isset($_SESSION['theme']) && $_SESSION['theme'] == 1){echo("selected");}?>>Basic</option>
        <option value="2" <?php if(isset($_SESSION['theme']) && $_SESSION['theme'] == 2){echo("selected");}?>>Green</option>
        <option value="3" <?php if(isset($_SESSION['theme']) && $_SESSION['theme'] == 3){echo("selected");}?>>Blue</option>
    </select>

</div>
    </td><td>

<div id="ActivateDiv" class="tableDivs" style="width: 250px"   >
    
    <label for="ActivateChannels">Activate Channels</label>
    <hr/>
    <table >
        <tr><td width="150px">
    <select name="activateSelect" align="center" id="activateSelect"  onchange="changeActiveButton();">
        <option value="1">Channel 1</option>
        <option value="2">Channel 2</option>
        <option value="3">Channel 3</option>
        <option value="4">Channel 4</option>
        <option value="5">Channel 5</option>
        <option value="6">Channel 6</option>
        <option value="7">Channel 7</option>
        <option value="8">Channel 8</option>
    </select>
        </td>
       <td> 
    <input type="button" value="Activate" id="activeButton" onclick="activateSensor();" style="float: right">
        </td>
    </tr>
    </table>
    
</div>
</td>
    
<td>
    <div id="deleteDataButton" class="tableDivs" style="width: 200px" >
    
    Delete Data
    <hr/>

    
    <input type="button" value="Delete" id="showDeleteButton" onclick="openDeleteDialog()" >

    </div>


</td>
    
</tr>
</table>
    






<div title="Update" id="updateDialog">
    
    <p>
    
    </p>
    
</div>
    
<div id="deleteDataDialog" title="Delete Data" >
    
    <h4>I HOPE YOU KNOW WHAT YOU ARE DOING!!</h4>
    <hr/>
    <table>
    <tr>
    <td width="100px">
    <label for="deleteListLocation">Location:</label>
    </td>
    <td>
    <select id="deleteListLocation" onchange="populateTypeList();" >
   <?php
            $list = getLocations();
            for($i = 0; $i < count($list); $i++){
                echo("<option value='{$list[$i]}' name='{$list[$i]}'>{$list[$i]}</option>");
            }
   ?>
    </select>
    </td>
    </tr>
    </table>

    <table id="listTables" hidden="hidden" >
        <tr><td width="100px">
    <label id="typeLabel" for="type">Type:</label>
    </td><td>
    <select name="type" id="type" onchange="populateUnitsType();"></select>
    </td>
    </tr>
    <tr>
    <td>
    <label id="unitsLabel" for="units">Units:</label>
    </td>
    <td>
    <select name="units" id="units"></select>
    </td>
    </tr>

    <tr>
    <td>
    <label id="timeDeleteLabel" for="timeDelete">Time:</label>
    </td>
    <td>
    <select name="timeDelete" align="center" id="timeDelete">
        <option value="3600">Last Hour</option>
        <option value="7200">Last Two Hours</option>
        <option value="14400">Last Four Hours</option>
        <option value="86400">Today</option>
        <option value="0">Everything</option>
    </select>
    </td>
    </tr>
    </table>
    <br/>
        <div id="noDeleteDataText"  hidden="hidden"></div>
    
</div>    
    
    
<div title="Add Location" id="addLocation" >
    
    <label for="locationAdd">Location</label>
    
    <input type="text" id="locationAdd" value="" >
        
    <input type="text" id="channelID" value="" hidden="hidden">
    
</div>

<div title="Add Sensor Type" id="addType" >
    
    <label for="typeAdd">Type</label>
    
    <input type="text" id="typeAdd" value="" >
        

    
</div>



<script>
        changeActiveButton();
        populateTypeList();
        
</script>

    
    
    
</body>
</html>