

function showLogin() {
    
   var loginDiv = document.getElementById("loginDiv");
    
    loginDiv.style.visibility = "show"
    
    
    
}


function sendNewUserData(username,password){
   
                           //send data
                        $.ajax({ url: 'createUser.php',
                            data: {
                                username:username,
                                password:password
                                },
                                type: 'post',
                                success: function(output) {
                                    
                                    if (output == 1) {
                                         window.location.href = 'setup.php';
                                     }else{
                                       
                                        document.getElementById("createUserError").innerHTML = "<ul><li>"+output+"</li></ul>";
                                     }
                                 }
                            });
   
}


function channelIsDisabled(tabId) {
  
  
  
}

function activateSensor(){
   
   var channel =  document.getElementById("activateSelect").value;
   
       $.ajax({ url: 'activateChannel.php',
                            data: {
                                Channel:channel
                                },
                                type: 'post',
                                success: function(output) {
                                    
                                    if (output == 1) {
                                         window.location.href = 'setup.php';
                                     }else{
                                       window.location.href = 'setup.php';
                                      //document.getElementById("updateDialog").innerHTML = "<p>"+output+"</p>";
                                      // $("#updateDialog").dialog("open");
                                     }
                                 }
         });
   
   
}
function deactivateSensor(){
   
   var channel =  document.getElementById("activateSelect").value;
   var Sensor_id = document.getElementById("Sensor_ID"+channel).value;

   
       $.ajax({ url: 'deactivateChannel.php',
                            data: {
                                Sensor_ID:Sensor_id
                                },
                                type: 'post',
                                success: function(output) {
                                    
                                    if (output == 1) {
                                         window.location.href = 'setup.php';
                                     }else{
                                       document.getElementById("updateDialog").innerHTML = "<p>"+output+"</p>";
                                       $("#updateDialog").dialog("open");
                                     }
                                 }
         });
   
   
}

function deleteData(channel) {
   
  var location = document.getElementById("deleteListLocation").value;
  var type = document.getElementById("type").value;
  var units = document.getElementById("units").value;
  var time = document.getElementById("timeDelete").value;
  
  
   $.ajax({ url: 'deleteData.php',
               data: {
                        Location: location,
                        Time: time,
                        Type: type,
                        Units: units

                     },
                     type: 'post',
                     success: function(output) {

                         if (output == 1) {
                          
                           document.getElementById("updateDialog").innerHTML = "<p> "+ location +" Data Deleted</p>";
                           
                         }else{
                           
                          // document.getElementById("updateDialog").innerHTML = "<p>Something Went Wrong Channel "+channelNumber+" Not Updated </p>";
                           document.getElementById("updateDialog").innerHTML = "<p>"+output+"</p>";
                         }
                         
                         $("#updateDialog").dialog("open");
                         
                        }
                    });
   
 
}


function updateChannel(channelNumber){
   
  var Sensor_ID = document.getElementById("Sensor_ID"+channelNumber).value;
  var location = document.getElementById("location"+channelNumber).value;  
  var equation = document.getElementById("equation"+channelNumber).value;
  var units = document.getElementById("units"+channelNumber).value;
  var type = document.getElementById("type"+channelNumber).value;

  
  
   $.ajax({ url: 'updateChannel.php',
               data: {
                        Sensor_ID: Sensor_ID,
                        location: location,
                        Equation: equation,
                        Units: units,
                        Type: type
                     },
                     type: 'post',
                     success: function(output) {

                         if (output == 1) {
                          
                           document.getElementById("updateDialog").innerHTML = "<p>Channel "+channelNumber+" Updated</p>";
                           populateTypeList();
                           
                         }else{
                           
                          // document.getElementById("updateDialog").innerHTML = "<p>Something Went Wrong Channel "+channelNumber+" Not Updated </p>";
                           document.getElementById("updateDialog").innerHTML = "<p>"+output+"</p>";
                         }
                         
                         $("#updateDialog").dialog("open");
                         
                        }
                    });
  
  
   
   
}

function createChartData(data) {
   
   var count = 0;              
   var index = 0;
   
   var  seriesOptions = [];
   
   count = Object.keys(data).length;
            

                for(room in data){

                
                    for(voltage in data[room]){
                        
                    
                         for(time in data[room][voltage]){
            
                                seriesOptions[index] = {
                                    name:       room,
                                    data:       data[room][voltage]
                                };                         
                        }
                    }

                    index++;
                   
                    if (index == count) {

                     //   console.log(seriesOptions[0]['name']);
                     
                     return seriesOptions;

                     
                     }
                
                
                }
           
          return seriesOptions; 
   
}

function addLocation(){
   
   //show dialog for creating a new location
   var newLocation = document.getElementById("locationAdd").value;
   var channel = document.getElementById("channelID").value;
   
   
   //add option and select it
   var locations = document.getElementById("location"+channel);
   
   var option = document.createElement("option");
   option.text = newLocation;
   option.value = newLocation;
   option.selected = true;
   locations.add(option);
   
   
   
}
function addType(){
   
   //show dialog for creating a new location
   var newType = document.getElementById("typeAdd").value;
   var channel = document.getElementById("channelID").value;
   
   
   //add option and select it
   var types = document.getElementById("type"+channel);
   
   var option = document.createElement("option");
   option.text = newType;
   option.value = newType;
   option.selected = true;
   types.add(option);
   
   
   
}

function openLocationDialog(channel){
   
   $("#addLocation").dialog("open");
   
   document.getElementById("channelID").value = channel;
   
}

function openTypeDialog(channel){
   
   $("#addType").dialog("open");
   
   document.getElementById("channelID").value = channel;
   
}

function openDeleteDialog(){
   
   $("#deleteDataDialog").dialog("open");
   

   
}

function changeTheme(page) {
   
   
     var theme = document.getElementById("themeSelect").value;

        $.ajax({ url: 'updateTheme.php',
               data: {
                        Theme: theme,
                     },
                     type: 'post',
                     success: function(output) {


                         window.location.href = page;
                         
                        }
                    });
   
}


function changeActiveButton(){
   
   
      var channelSelect = document.getElementById("activateSelect").value;
      var button = document.getElementById("activeButton");
      
      if (document.getElementById('tabs-'+channelSelect)){
         button.value = "Deactivate";
         button.onclick = deactivateSensor;
      }else{
         button.value = "Activate";
         button.onclick = activateSensor;
         
      }
      
      
   
   
}

function populateTypeList(){
   
   var location = document.getElementById("deleteListLocation").value;
   
   
           $.ajax({ url: 'getType.php',
               data: {
                        Location: location
                     },
                     type: 'post',
                     success: function(output) {

                        if (output) {
                              document.getElementById("listTables").hidden = "";
                              document.getElementById("noDeleteDataText").hidden = "hidden";
                              document.getElementById("type").innerHTML = output;
                              populateUnitsType();
                        }else{
                            document.getElementById("listTables").hidden = "hidden";

                              document.getElementById("noDeleteDataText").hidden = "";
                              document.getElementById("noDeleteDataText").innerHTML = location+" Has No Data To Delete";
                        }
                        
                        }
                    });
   
}
function populateUnitsType(){
   
   
      var location = document.getElementById("deleteListLocation").value;
      var type = document.getElementById("type").value;
    
    
               $.ajax({ url: 'getUnits.php',
               data: {
                        Location  : location,
                        Type:    type
                     },
                     type: 'post',
                     success: function(output) {
                     
                        if (output) {
                              document.getElementById("units").innerHTML = output;
                        }
                        
                        }
                    });
   
   
   
}
     
   
   


