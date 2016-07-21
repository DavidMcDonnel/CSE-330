<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>jMonthCalendar Sample</title>

    <link rel="stylesheet" href="css/core.css" type="text/css" />
    
    <!--<script type="text/javascript" src="login_ajax.js" id="Ajax"></script>-->
    <!--<script src="js/jquery-1.3.min.js" type="text/javascript"></script>-->
    <script src="http://code.jquery.com/jquery-2.1.1.js"></script>
    <!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    
    <script src="js/jMonthCalendar.js" type="text/javascript"></script>


	<style type="text/css" media="screen">
		#jMonthCalendar .Meeting { background-color: #DDFFFF;}
		#jMonthCalendar .Birthday { background-color: #DD00FF;}
		#jMonthCalendar #Event_3 { background-color:#0000FF; }
	</style>
	
	
    <script type="text/javascript">
        $().ready(function() {
			var options = {
				height: 650,
				width: 980,
				navHeight: 25,
				labelHeight: 25,
				onMonthChanging: function(dateIn) {
					//this could be an Ajax call to the backend to get this months events
					//var events = [ 	{ "EventID": 7, "StartDate": new Date(2009, 1, 1), "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
					//				{ "EventID": 8, "StartDate": new Date(2009, 1, 2), "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" }
					//];
					//$.jMonthCalendar.ReplaceEventCollection(events);
					return true;
				},
				
				onEventLinkClick: function(event) { 
					alert("event link click");
					return true; 
				},
				onEventBlockClick: function(event) { 
					alert("block clicked");
					return true; 
				},
				onEventBlockOver: function(event) {
					//alert(event.Title + " - " + event.Description);
					return true;
				},
				onEventBlockOut: function(event) {
					return true;
				},
				onDayLinkClick: function(date) { 
					alert(date.toLocaleDateString());
					return true; 
				},
				onDayCellClick: function() {
				    $("#edit-event-dialog-form").dialog({
					title: 'Edit Event',
					autoOpen: false,
					draggable: true,
					resizable: true,
					width: 600,
					height: 500,
					buttons: {
					    'Delete' : {
						text: 'Delete Event',
						click : function() {
							//deleteEventAjax();
							$(this).dialog('close');
						    }
					    },
					    'Cancel': function() {
						$(this).dialog('close');
					    },
					    'Submit': { 
						text: 'Submit',
						click : function() {
						    //addEventAjax();
						    $("#edit-event-dialog-form").dialog('close');
						}
					    }
					}
				    });
				    
				    $("#edit-event-dialog-form").dialog('open');
				    
				    //$.jMonthCalendar.AddEvents(extraEvents);
				    //<input type="button" id="open" value="Open Dialog" />
				    
				//    $(".dialog").dialog({
				//	autoOpen: false,
				//	buttons: { 
				//	    Ok: function() {
				//		$("#titleentered").text($("#title").val());
				//		$("#timeentered").text($("#time").val());
				//		$(".dialog").dialog("close");
				//	   },
				//	    Cancel: function () {
				//		$(".dialog").dialog("close");
				//	    }
				//	}
				//    });
				    
				    //$("#open").click(function () {
					//$(".dialog").dialog("open");
				    //});
					//var event = prompt("Please enter your event title", "Enter title here");
					//var time = prompt("Please enter the time of your event", "Enter time here");
					return true; 
				}
			};
			
			
			var events = [ 	{ "EventID": 1, "Date": "new Date(2009, 3, 1)", "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
							{ "EventID": 1, "StartDateTime": new Date(2009, 3, 12), "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
							{ "EventID": 2, "Date": "2009-04-28T00:00:00.0000000", "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" },
							{ "EventID": 3, "StartDateTime": new Date(2009, 3, 20), "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" },
							{ "EventID": 4, "StartDateTime": "2009-04-14", "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" }
			];
			
			var newoptions = { };
			var newevents = [ ];
			//$.jMonthCalendar.Initialize(newoptions, newevents);

			
			$.jMonthCalendar.Initialize(options, events);
			
			
			
			
			var extraEvents = [	{ "EventID": 5, "StartDateTime": new Date(2014, 3, 11), "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
								{ "EventID": 6, "StartDateTime": new Date(2009, 3, 20), "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" }
			];
			
			$("#Button").click(function() {					
				$.jMonthCalendar.AddEvents(extraEvents);
			});
			
			$("#ChangeMonth").click(function() {
				$.jMonthCalendar.ChangeMonth(new Date(2008, 4, 7));
			});
			//$(".login").submit(function(){
			//    username=$("#username").val();
			//    password=$("#password").val();
			//    $.ajax({
			//	type: "POST",
			//	url: "login.php",
			//	data: "username="+username+"&password="+password,
			//	success: function(html){
			//	    alert("hello");
			//	    if (html=='true') {
			//		$("#add_err").html("right username or password");
			//	    } else{
			//		$("#add_err").html("wrong username or password");
			//	    }
			//	},
			//	beforeSend: function(){
			//	
			//	}
			//    });
			//});
			$("#login_btn").click(function(){
			    //console.log("in login btn");
			    var username_log = document.getElementById("username_log").value;
			    var password_log = document.getElementById("password_log").value;
			    var login_flag = document.getElementById("login_flag").value;
		     
			    // Make a URL-encoded string for passing POST data:
			    var dataString = "username_log=" + encodeURIComponent(username_log) + "&password_log=" + encodeURIComponent(password_log) + "&login_flag=" + encodeURIComponent(login_flag);
			    //alert(dataString);
			    //console.log(dataString);
			    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
			    xmlHttp.open("POST", "login.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
			    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
			    xmlHttp.addEventListener("load", function(event){
				//console.log("in xml load");
				//alert("about to parse");
				//alert(event.target.responseText);
				    //console.log(event.target.responseText);
				    var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
				    //console.log("json parsed");
				    if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
					    alert("You've been Logged In!");
					    $(this).find('.login').hide();
					    //$(".login").hide();
					    //$("#register").hide();
					    $(this).find(".logout").show();
					    //console.log("You've been Logged In!");
				    }else{
					    alert("You were not logged in.  "+jsonData.message);
					    //$("#login").show();
					    //$("#register").show();
					    //$("#logout").hide();
					    //console.log("You were not logged in.  "+jsonData.message);
				    }
			    }, false); // Bind the callback to the load event
			    xmlHttp.send(dataString); // Send the data
			});


				
				//$.Ajax.loginAjax(event);
			$("#register_btn").click(function(){
				//console.log("in register btn");
				
				var username_reg = document.getElementById("username_reg").value;
				var password_reg = document.getElementById("password_reg").value;
				var email_reg = document.getElementById("email_reg").value;
				var register_flag = document.getElementById("register_flag").value;
    
				var dataString = "username_reg=" + encodeURIComponent(username_reg) + "&password_reg=" + encodeURIComponent(password_reg) + "&email_reg=" + encodeURIComponent(email_reg) + "&register_flag=" + encodeURIComponent(register_flag);
				//alert(dataString);
				//console.log(dataString);
				var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
				xmlHttp.open("POST", "userregistration.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
				xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
				xmlHttp.addEventListener("load", function(event){
				    //console.log("in xml load");
				    //console.log(event.target.responseText);
					var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
					//console.log("json parsed");
					if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
						alert("You've been Logged In!");
						//$('#login').hide();
						//$('#register').hide();
						//$('#logout').show();
						//console.log("You've been Logged In!");
					}else{
						alert("You were not logged in.  "+jsonData.message);
						//$('#login').show();
						//$('#register').show();
						//$('#logout').hide();
						//console.log("You were not logged in.  "+jsonData.message);
					}
				}, false); // Bind the callback to the load event
				xmlHttp.send(dataString); // Send the data

			});
			
			$("#logout_btn").click(function(){
				//console.log("in register btn");
				
				var logout_flag = document.getElementById("logout_flag").value;
    
				var dataString = "logout_flag=" + encodeURIComponent(logout_flag);
				//alert(dataString);
				//console.log(dataString);
				var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
				xmlHttp.open("POST", "login.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
				xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
				xmlHttp.addEventListener("load", function(event){
				    //console.log("in xml load");
				    //console.log(event.target.responseText);
					var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
					//console.log("json parsed");
					if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
						alert("You've been Logged In!");
						//$('#login').show();
						//$('#register').show();
						//$('#logout').hide();
						//console.log("You've been Logged Out!");
					}else{
						alert("You were not logged in.  "+jsonData.message);
						//$('#login').hide();
						//$('#register').hide();
						//$('#logout').show();
						//console.log("You were not logged out.  "+jsonData.message);
					}
				}, false); // Bind the callback to the load event
				xmlHttp.send(dataString); // Send the data

			});
			    
	});
			
        
    </script>
</head>
<body>
    <div id="edit-event-dialog-form" title="Confirm" style="display:none;">
	
	Fetch and display events here
    <br>
    <button>Add new event</button>
    </div>
<div class="sign_in">
    
    <form method="post" class="login">
	<h2>Log In</h2>
	<input type="hidden" id="login_flag" name="login_flag" value="true"/>
	<input type="text" name="username_log" id="username_log"/>
	<input type="password" id="password_log" name="password_log"/>
	<input type="submit" value="Log In" id="login_btn"/>
    
	<h2>Register</h2>
	<input type="hidden" id="register_flag" name="register_flag" value="true"/>
	<input type="text" name="username_reg" id="username_reg"/>
	<input type="password" id="password_reg" name="password_reg"/>
	<input type="text" id="email_reg" name="email_reg"/>
	<input type="submit" value="Register" id="register_btn"/>
    </form>
    <form method="post" class="logout">
	<h2>Log Out</h2>
	<input type="hidden" id="logout_flag" name="logout_flag" value="true"/>
	<input type="submit" value="Log Out" id="logout_btn"/>
    </form>
    <?php if (isset($_SESSION['username'])){echo $_SESSION['username'];}?>
</div>
	<center>
		<div id="jMonthCalendar"></div>

		<button id="Button">Add More Events</button>

		<button id="ChangeMonth">Change Months May 2009</button>
	</center>

</body>
<script type="text/javascript">

</script>
</html>