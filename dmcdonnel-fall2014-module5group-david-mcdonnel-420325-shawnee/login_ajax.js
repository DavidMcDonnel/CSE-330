function loginAjax(event){
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
        alert(dataString);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "login.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Logged In!");
		}else{
			alert("You were not logged in.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}

function registerAjax(event){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    
 var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
        alert(dataString);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "userregistration.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You've been Logged In!");
		}else{
			alert("You were not logged in.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click
document.getElementById("register_btn").addEventListener("click", registerAjax, false); // Bind the AJAX call to button click