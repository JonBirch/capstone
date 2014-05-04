<?php

   require_once("db_connection.php");
   require_once("functions.php");
   require_once("session.php");

?>

<!doctype html>

<html lang="en">
<head>
    
    <title>Capstone Project</title>
    
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
    <script src="js/highstock.js"></script>
    
    
    <script>
    
        //check for login
        
        var isLoggedIn = <?php
                            
                            if(isset($_SESSION['userID']))
                                    {echo "true";}
                                else
                                    {echo "false";}
                         ?>;
 
        //set up boolean to show new sensor dialog
        //if (get total sensors with null foreign keys) > 0
        //send data
        var showNewSensorDialog;
        
        
        if (<?php hasNewSensors(); ?>) {
            showNewSensorDialog = true;
        }else{
            showNewSensorDialog = false;     
        }

        

        
    </script>
    
<body>
    

    
    
    <pre id="header">Capstone Website</pre>
   
    <?php
    
        echo('<div class="links">');
    
        if(isset($_SESSION['userID'])){
        
            echo('<a id="logout" >Log Out</a>');
            echo('<br/>');
            echo('<br/>');
            echo('<a id="config" >Configure Sensors</a>');
            echo('<br/>');
            echo('<br/>');
            echo('<a id="createUser" href="createCharts.php">Used For Testing</a>');
        
        }else{
        
            echo('<a id="login" >Log In</a>');
            echo('<br/>');
            echo('<br/>');
            echo('<a id="createUser">Create User</a>');
            echo('<br/>');
            echo('<br/>');
            echo('<a id="createUser" href="createCharts.php">Used For testing</a>');
        
        }


    echo('</div>');
    
    ?>
   
    <hr/>
    


    <div hidden="hidden" id="loginDialog" title="Log In">
    
     <div id="loginUserError"></div>
    
        <form id="loginForm">
        <fieldset>
       
            <label for="user">UserName</label>
            <input id="user" type="text" name="username"/>
      
            <label for="pass">Password</label>
            <input id="pass" type="password" name="password" />
        
        </fieldset>    
        
        </form>
        
    </div>
    
    <div hidden="hidden" id="createUserDialog" title="Create User">
    
        <div id="createUserError"></div>
    
        <form id="createUserForm">
        <fieldset>
           
            <label for="createUsername" >Username</label>
            <input id="createUsername" type="text" name="username" class="text ui-widget-content ui-corner-all"/>
           
            <label for="createPassword">Password</label>
            <input id="createPassword" type="password" name="password" class="text ui-widget-content ui-corner-all" />

            <label for="verifyPassword">Confirm Password</label>
            <input id="verifyPassword" type="password"  name="verifyPassword"  class="text ui-widget-content ui-corner-all"/>
        
        </fieldset>
        </form>
    
    </div>
    
        
    <br/>
    <br/>
    
    <div id="mainCharts"> </div>
    
    <div hidden="hidden" id="newSensors" title="New Sensors">       
        You Have Connected new Sensors
        <br/>
        <br/>
        Would you like to set them up now? 
    </div>
  
  
  <script>


        
    $(function() {

            var  seriesOptions = [],
                 yAxisOptions = [],
		 colors = Highcharts.getOptions().colors;
  
        $.getJSON('createCharts.php',	function(data) {

            //takes json object and creates array       
                 seriesOptions = createChartData(data);
                 createChart();
            
        });
      
      
      	// create the chart when all data is loaded
    function createChart() {

    	Highcharts.setOptions({
		global : {
			useUTC : false
		}
	});
	
    
    
		$('#mainCharts').highcharts('StockChart', {
		    chart: {
                        
                        borderRadius:25,
                        
                       	events : {
			    load : function() {
                                        
				    function updateData(chart){
					var series = chart.series;

                                           $.ajax({ url: 'updateChartData.php',
                                                data: {},
                                                type: 'post',
                                                success: function(output)
                                                {
 
                                                     var newData = createChartData(JSON.parse(output));
                    
                                                        for(var i = 0; i < newData.length; i++) {
                     
                                                             var count = series.length;
                    
                                                             for(var j = 0; j < count; j++) {
                                                                if(series[j].name == newData[i]['name']){
                                                               

                                                                        for(var k = 0; k < newData[i]['data'].length; k++){
                                                                             series[j].addPoint(newData[i]['data'][k],true,true);
                                                                         }
                                                                 
                                                                 }
                                                            }           
                                                        }
                                                
                                                },
                                                complete: function(){
                                                    updateData(chart);
                                                }
                                            });

                                        }
                               updateData(this);         
                            }
			}
		    },

		    rangeSelector: {
                            buttons: [{
                                        type: 'second',
                                        count: 3,
                                        text: 'sec'
                                        }, {
                                        type: 'minute',
                                        count: 6,
                                        text: 'min'
                                    },{
                                        type: 'hour',
                                        count: 6,
                                        text: 'Hour'
                                    },{
                                        type: 'day',
                                        count: 6,
                                        text: 'Day'
                                    }]
                            },
                            
                    xAxis: {
                            minRange: 1000
                     },        

		    yAxis: {

		    	plotLines: [{
		    		value: 0,
		    		width: 2,
		    		color: 'silver'
		    	}]
		    },
                    
		    
		    plotOptions: {
		    	series: {
		    		//compare: 'percent'
		    	}
		    },
		    

		    
		    series: seriesOptions
		});
	}
        
});

    
    $(function(){
        
        $("#loginDialog").dialog({
            
            autoOpen : false,
            resizable: false,
            modal: true,
            draggable: false,
            buttons:{
                
                "Log In": function(){
                    
                    //check to see if blank
                    var user = $( "#user" );
                    var pass = $( "#pass" );
 
                    if (user.val() != "" && pass.val() != "") {
                        //code
                    
                    //send data
                    $.ajax({ url: 'login.php',
                         data: {
                                username: user.val(),
                                password: pass.val()
                                },
                         type: 'post',
                         
                         success: function(output) {
                            
                                if (output == 1) {
                                    
                                    window.location.href = 'setup.php';
                                
                                }else{
                                    
                                    document.getElementById("loginUserError").innerHTML = "<ul><li>"+output+"</li></ul>";

                                }
                         
                         
                        }
                    });
                    }else{
                        if (user.val() == "") {
                            document.getElementById("loginUserError").innerHTML = "<ul><li>Username Can Not Be Blank</li></ul>";
                        }else{
                            
                             document.getElementById("loginUserError").innerHTML = "<ul><li>Password Can Not Be Blank</li></ul>";
                        }
                        
                        
                    }
                    
                    
                },
  

                
            }

             
            
            });
        
        //setup create user dialog
            $("#createUserDialog").dialog({
            
                autoOpen : false,
                resizable: false,
                modal: true,
                draggable: false,
                buttons:{
                
                    "Create User": function(){
                       var username = document.getElementById("createUsername").value
                       var password = document.getElementById("createPassword").value
                       var verifyPassword = document.getElementById("verifyPassword").value
                       
                       
                       
                        //check to see if data is blank
                        if (username != "" && password != "" && verifyPassword !="") {
                            
                            if (verifyPassword == password) {
                                sendNewUserData(username,password);
                                
                            }else{
                               document.getElementById("createUserError").innerHTML = "<ul><li>Passwords Do Not Match</li></ul>";
                            }
  
                        }else{
                            
                            document.getElementById("createUserError").innerHTML = "<ul><li>Can Not Leave Any Field Blank</li></ul>";
                            
                        }
                        
                    

                    
                    }, 
            }
            
            });
        
        $("#newSensors").dialog({
            
            autoOpen : showNewSensorDialog,
            modal: true,
            resizable: false,
            width: 400,
            height: 220,
            draggable: false,
            buttons:{
                
                "No": function(){
                    
                    $(this).dialog("close");
                    
                },
               
                "Yes": function(){
                
                    if (isLoggedIn) {
                    
                        
                        window.location.href = 'setup.php';
                       
                     return false;
                    
                    }else{
                        
                        $("#loginDialog").dialog("open");
                         
                         
                         return false;
                    
                    }
 
                }

                
            }
            
            
            });
        
        
        $("#login").on("click", function(){
            
            document.getElementById("user").value = "";
            document.getElementById("pass").value = "";
            $("#loginDialog").dialog("open");
            

            
            
            });
        
        $("#createUser").on("click", function(){
            
           document.getElementById("createUsername").value ="";
           document.getElementById("createPassword").value ="";
           document.getElementById("verifyPassword").value ="";
           $("#createUserDialog").dialog("open");
            
        });
        
        $("#logout").on("click", function(){
            
           window.location.href = 'logout.php';
            
        });
        
        $("#config").on("click", function(){
            
           window.location.href = 'setup.php';
        });
        
        
    });
    
    
    
  </script>

    

    
</body>
</html>
