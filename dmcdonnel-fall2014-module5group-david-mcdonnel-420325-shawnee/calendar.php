<?php session_start(); ?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
	<script src='./public_html/jquery/jquery-1.9.1.min.js'></script>
	<script src='./public_html/jquery/jquery-ui-1.10.2.custom.min.js'></script>
	<link rel='stylesheet' href='./fullcalendar-2.1.1/fullcalendar.css' />
	<link rel='stylesheet' href='./fullcalendar-2.1.1/fullcalendar.print.css' media='print'/>
	<script src='./fullcalendar-2.1.1/lib/jquery.min.js'></script>
	<script src='./fullcalendar-2.1.1/lib/moment.min.js'></script>
	<script src='./fullcalendar-2.1.1/fullcalendar.js'></script>
	<script src='./fullcalendar-2.1.1/fullcalendar.min.js'></script>
	
	<title>My Calendar</title>
    <script type="text/javascript">
	$(document).ready(function() {
	    var date = new Date();
	    var d = date.getDate();
	    var m = date.getMonth();
	    var y = date.getFullYear();
	    var calendar = $('#calendar').fullCalendar({
		header:
		{
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'month',
		lazyFetching: false,
		events: {url:'events.php',
			       type:'POST'},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay)
			{
			    var title = prompt('Event Title:');
			    if (title)
					{
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end
								//allDay: allDay
							},
							true // make the event "stick"
						);
						var day = moment(start).format('YYYY-MM-DD');
						var time = moment(start).format('HH:mm:ss');
						var dataString = "start=" + encodeURIComponent(time) + "&title=" + encodeURIComponent(title) + "&day=" + encodeURIComponent(day);
						var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
						xmlHttp.open("POST", "addEvent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
						xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
						xmlHttp.addEventListener("load", function(event){
							var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
							if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
							
							}else{
							    //alert("You were not logged in.  "+jsonData.message);
							}
						}, false); // Bind the callback to the load event
						xmlHttp.send(dataString); // Send the data
					}
					calendar.fullCalendar('unselect');
				},
				editable: true,
				eventClick: function(event,start, end,allDay) {
				    var title = prompt('Event Title:', event.title);
				    if(title)
				    {
					calendar.fullCalendar('renderEvent',
							{
							    title: title,
							    start: start,
							    end: end
							},
							true
							);
							var day = moment(start).format('YYYY-MM-DD');
							var time = moment(start).format('HH:mm:ss');
							var dataString = "start=" + encodeURIComponent(time) + "&title=" + encodeURIComponent(title) + "&day=" + encodeURIComponent(day) + "&id=" + encodeURIComponent(event.id);
							var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
							xmlHttp.open("POST", "updateEvent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
							xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
							xmlHttp.addEventListener("load", function(event){
								var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
								if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
								}else{
								    //alert("You were not logged in.  "+jsonData.message);
								}
							}, false); // Bind the callback to the load event
							xmlHttp.send(dataString); // Send the data
				    }
				    calendar.fullCalendar('unselect');
				},
		    
		    
	    });
	
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
			    //$(this).find('.sign_in').hide();
			    //$(".login").hide();
			    //$("#register").hide();
			    //$(this).find(".sign_out").show();
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
<!--    <div id="prompt">-->
<!--	<form method="post">-->
<!--	    <input type="hidden" id="add_flag" name="add_flag" value="true"/>-->
<!--	    <input type="text" default="Title" required="required" id="title"/>-->
<!--	    <input type="text" default="time" required="required" id="time"/>-->
<!--	</form>-->
<!--    </div>-->
    
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
    </div>
    <div class="sign_out">
	<form method="post" class="logout">
	    <h2>Log Out</h2>
	    <input type="hidden" id="logout_flag" name="logout_flag" value="true"/>
	    <input type="submit" value="Log Out" id="logout_btn"/>
	</form>
	<?php if (isset($_SESSION['username'])){echo $_SESSION['username'];}?>
    </div>
    <div id='calendar'></div>
</body>
</html>