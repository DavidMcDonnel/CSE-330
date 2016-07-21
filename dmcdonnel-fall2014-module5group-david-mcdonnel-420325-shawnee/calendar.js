var csrf_token = '<%= token_value %>';
$("body").bind("ajaxSend", function(elm, xhr, s){
   if (s.type == "POST") {
      xhr.setRequestHeader('X-CSRF-Token', csrf_token);
   }
});


// For our purposes, we can keep the current month in a variable in the global scope
    var currentMonth = new Month(2013, 11); // November 2013
    var selectedCell = null;
    //var eventsParent = document.getElementById("existingEvents");
$(document).ready(function() {
    
    
    //Initialize the calendar
    updateCalendar();
    initEventDialog();
    document.getElementById("existingEvents").innerHTML = "";

    // Change the month when the "next" button is pressed
    $("#next_month_btn").click(function(){
	    currentMonth = currentMonth.nextMonth(); // Previous month would be currentMonth.prevMonth()
	    updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
	    console.log("The new month is "+currentMonth.month+" "+currentMonth.year);
    });
    // Change the month when the "next" button is pressed
    $("#prev_month_btn").click(function(){
	    currentMonth = currentMonth.prevMonth(); // Previous month would be currentMonth.prevMonth()
	    updateCalendar(); // Whenever the month is updated, we'll need to re-render the calendar in HTML
	    console.log("The new month is "+currentMonth.month+" "+currentMonth.year);
    });
    
    
    $('#calendar td').mouseover(function(){
	$(this).addClass('hover');
	selectedCell = $(this);
    });
    
    $('#calendar td').mouseout(function(){
	$(this).removeClass('hover');
	selectedCell = null;
    });

    $('#calendar td').click(function() {
	var date = $(this).find(".date").html();
	var week = $(this).parent().attr('class').slice(-1)
	//Need to deal with "rollover" dates from previous/next months
	if (week == 0 && date > 20 ) {
	    openEventDialog((currentMonth.month-1 % 12), date);
	} else if (week == 4 && date < 10 ) {
	    openEventDialog((currentMonth.month+1 % 12), date);
	} else {
	    openEventDialog(currentMonth.month, date);
	}
	
    });
    
    $("#new_event_btn").click(addEventAjax);
    $("#delete_event_btn").click(deleteEventAjax);
    $("#edit_event_btn").click(editEventAjax);
    $("#cancel_btn").click(function(){
	$("#event").hide();
	$("#day").val("");
	document.getElementById("existingEvents").innerHTML = "";
    });
    
    


    
    
});
 


 
// This updateCalendar() function only alerts the dates in the currently specified month.  You need to write
// it to modify the DOM (optionally using jQuery) to display the days and weeks in the current month.
function updateCalendar(){
    
	
	$("#currentMonth").html(monthToString(currentMonth.month) + " " + currentMonth.year);
	console.log(currentMonth);
	var weeks = currentMonth.getWeeks();
 
	for(var w in weeks){
		var days = weeks[w].getDates();
		// days contains normal JavaScript Date objects.
		
		//console.log("Week starting on "+days[0]);
 
		for(var d in days){
		    console.log(Date(days[d]));
		    $(".week" + w).find(".day"+d).html(days[d].getDate());
		    $(".week" + w).find(".day"+d).click(function() {
			var today = currentMonth.year + "-" + currentMonth.month + "-" + $(this).html();
			var day = document.getElementById("day");
			day.setAttribute('value', today);
			fetchEvents();
			$("#event").show();
			
			console.log(day.value);
			
			
		    });
		    
			// You can see console.log() output in your JavaScript debugging tool, like Firebug,
			// WebWit Inspector, or Dragonfly.
			//console.log(days[d].toISOString());
			
		}
	}
}


function initEventDialog() {
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
		    deleteEventAjax();
		    $(this).dialog('close');
		}
	},
	'Cancel': function() {
	    $(this).dialog('close');
	},
	'Submit': { 
	    text: 'Submit',
	    click : function() {
		addEventAjax();
		$("#edit-event-dialog-form").dialog('close');
	    }
	}
    }
    });
}

function openEventDialog(month, date) {

var title = 'Editing xxxx';

var dialogDiv = $('#edit-event-dialog-form');
dialogDiv.dialog("option", "position", 'center' );
dialogDiv.dialog("option", "title", "Add New Event On " + monthToString(month) + " " + date);
dialogDiv.dialog('open');
//dialogDiv.parent().before('<div id="dialog-overlay"></div>');
dialogDiv.parent().css("z-index","1100");
//dialogDiv.parent().find('.ui-dialog-buttonpane .ui-button:first-child').focus();

//Ajax event here
}

function addEventToUI(w, d, date, event) {
    var name = event['name'];
    var color = event['color'];
    var eventHTML = "<div class='calEvent' style='background-color:" + color + "'>" + name + "</div>";
    
    $(".week" + w).find(".day"+ d).append(eventHTML);
}


//add event ajax function
function addEventAjax(event){

	var eventname = $("#event_name").val();
	var h = document.getElementById("hour");
	var hour = h.options[h.selectedIndex].value;
	var day = document.getElementById("day").value;
	
    
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "eventname=" + encodeURIComponent(eventname) + "&day=" + encodeURIComponent(day) + "&hour=" + encodeURIComponent(hour);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "events.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
        xmlHttp.send(dataString); // Send the data
        xmlHttp.addEventListener("load", addEventCallback, false);
	
	$("#event_name").val("");
	$("#day").val("");
}

function addEventCallback(event) {

    var jsonData = JSON.parse(event.target.responseText); 
    if(jsonData.eventAdded){
        
        var eventname = jsonData.eventname;
	$("#testMessege").html(eventname);
	$("#event").hide();
        
    }else{
        $("#testMessage").html("Add event failed");
    }
}


//edit event
function editEventAjax(event){

	var eventname = $("#event_name").val();
	var h = document.getElementById("hour");
	var hour = h.options[h.selectedIndex].value;
	var day = document.getElementById("day").value;
	
    
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "eventname=" + encodeURIComponent(eventname) + "&day=" + encodeURIComponent(day) + "&hour=" + encodeURIComponent(hour);
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "editEvent.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
        xmlHttp.send(dataString); // Send the data
        xmlHttp.addEventListener("load", editEventCallback, false);
	
	$("#event_name").val("");
	$("#day").val("");
}

function editEventCallback(event) {

    var jsonData = JSON.parse(event.target.responseText); 
    if(jsonData.eventEdit){
        
        var eventname = jsonData.eventname;
	$("#event").hide();
        
    }else{
        console.log(jsonData.message);
    }
}

//delete event function
function deleteEventAjax(event){

	var eventname = $("#event_name").val(); 
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "eventname=" + encodeURIComponent(eventname) ;
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "deleteEvent.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
        xmlHttp.send(dataString); // Send the data
        xmlHttp.addEventListener("load", deleteEventCallback, false);
	
	$("#event_name").val("");
	$("#day").val("");
}

function deleteEventCallback(event) {

    var jsonData = JSON.parse(event.target.responseText); 
    if(jsonData.eventDeleted){
        
        var eventname = jsonData.eventname;
	$("#testMessege").html("event deleted sucessfully");
	$("#event").hide();
        
    }else{
        $("#testMessage").html("Delete event failed");
    }
}


//display events

function fetchEvents(event) {
    
    var day = document.getElementById("day").value;
    var dataString = "day=" + encodeURIComponent(day);
    
    
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", "getEvents.php",true);
    xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlHttp.addEventListener("load", fetchEventsCallback, false);
    xmlHttp.send(dataString);
}

function fetchEventsCallback(event) {

    var jsonData = JSON.parse(event.target.responseText);
    var eventsParent = document.getElementById("existingEvents");
    eventsParent.innerHTML = "";
    
    if(jsonData.eventExisted){
	var events = jsonData.events;
	for(var i in events) {
	    var title = events[i].title;
	    var time = events[i].time;
	    eventsParent.innerHTML += "<p>" + title + " " + time + "</p>" + "<br>"; 
	}
    console.log(events);
        
    }else{
        //$("#loginMessage").html("You were not logged in.  "+jsonData.message);
	console.log(jsonData);
	
    }
}

function monthToString(month) {
    switch(month) {
	case 0:
	  return "January";
	  break;
	case 1:
	  return "February";
	  break;
	case 2:
	  return "March";
	  break;
	case 3:
	  return "April";
	  break;
	case 4:
	  return "May";
	  break;
	case 5:
	  return "June";
	  break;
	case 6:
	  return "July";
	  break;
	case 7:
	  return "August";
	  break;
	case 8:
	  return "September";
	  break;
	case 9:
	  return "October";
	  break;
	case 10:
	  return "November";
	  break;
	case 11:
	  return "December";
	  break;
	default:
	  return "Unknown Month";
    }
}

function dayToString(day) {
    switch(month) {
	case 0:
	  return "Sunday";
	  break;
	case 1:
	  return "Monday";
	  break;
	case 2:
	  return "Tuesday";
	  break;
	case 3:
	  return "Wednesday";
	  break;
	case 4:
	  return "Thursday";
	  break;
	case 5:
	  return "Friday";
	  break;
	case 6:
	  return "Saturday";
	  break;
	default:
	  return "Unknown Day";
    }
}