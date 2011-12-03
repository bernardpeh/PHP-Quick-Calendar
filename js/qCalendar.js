/*** local Javascript float routines ***************************************/

var IE = document.all?true:false;
if (!IE) document.captureEvents(Event.MOUSEMOVE)
document.onmousemove = qCalendarGetMouseXY;
var qCalendarMouseX = 0;
var qCalendarMouseY = 0;

function qCalendarGetMouseXY(e) {
	if (IE) {
		qCalendarMouseX = event.clientX + document.body.scrollLeft;
		qCalendarMouseY = event.clientY + document.body.scrollTop;
	}
	else {
		qCalendarMouseX = e.pageX;
		qCalendarMouseY = e.pageY;
	}
	return true;
}

function qCalendarDetailsFloatOn(divLongDesc, theme, id) {
	// move the div box
	document.getElementById(divLongDesc).style.left=qCalendarMouseX + 'px';
	document.getElementById(divLongDesc).style.top=qCalendarMouseY + 'px';
	// display content
	document.getElementById(divLongDesc).style.visibility='visible';
	qCalendarDetails(divLongDesc, theme, id);
}

function qCalendarAllDetailsFloatOn(divLongDesc, theme, d, m, y, c) {
	// move the div box
	document.getElementById(divLongDesc).style.left=qCalendarMouseX + 'px';
	document.getElementById(divLongDesc).style.top=qCalendarMouseY + 'px';
	// display content
	document.getElementById(divLongDesc).style.visibility='visible';
	qCalendarAllDetails(divLongDesc, theme, d, m, y, c);
}

function qCalendarDetailsFloatOff(divLongDesc) {
	// hid float
	document.getElementById(divLongDesc).style.visibility='hidden';
}

/*** AJAX client-side Javascript ********************************************/

function createQCObject() {
   var req;
   if(window.XMLHttpRequest){
	  // Firefox, Safari, Opera...
	  req = new XMLHttpRequest();
   } else if(window.ActiveXObject) {
	  // Internet Explorer 5+
	  req = new ActiveXObject('Microsoft.XMLHTTP');
   } else {
	  alert('Problem creating the XMLHttpRequest object');
   }
   return req;
}

// Make the XMLHttpRequest object
var xhr = createQCObject();

//  qcalendarsyspath is set in controller.php

function displayQCalendar(theme, divCalendar, divLongDesc, d, m, y, c) {
	var ran_no = new Date().getTime();
	xhr.open('get', qcalendarsyspath+'controller.php?theme='+theme+'&divCalendar='+divCalendar+'&divLongDesc='+divLongDesc+'&d='+d+'&m='+m+'&y='+y+'&c='+c+'&ran='+ran_no);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var response = xhr.responseText;
			if(response) {
				document.getElementById(divCalendar).innerHTML = response;
			}
		}
	}
	xhr.send(null);
}

function qCalendarDetails(divLongDesc, theme, id) {
	var ran_no = new Date().getTime();
	xhr.open('get', qcalendarsyspath+'controller.php?theme='+theme+'&id='+id+'&ran='+ran_no);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var response = xhr.responseText;
			if(response) {
				document.getElementById(divLongDesc).innerHTML = response;
			}

		}
	}
	xhr.send(null);
}

function qCalendarAllDetails(divLongDesc, theme, d, m, y, c) {
	var ran_no = new Date().getTime();
	xhr.open('get', qcalendarsyspath+'controller.php?theme='+theme+'&d='+d+'&m='+m+'&y='+y+'&c='+c+'&ran='+ran_no);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var response = xhr.responseText;
			if(response) {
				document.getElementById(divLongDesc).innerHTML = response;
			}
		}
	}
	xhr.send(null);
}

