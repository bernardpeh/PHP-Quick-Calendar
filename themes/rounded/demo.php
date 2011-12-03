<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Demo theme - Rounded Calendar</title>

</head>

<body>

<h2>PHP Quick Calender Demo - Rounded Corners</h2>
<p>Smiliar to the small calendar but with some css trick and floating div. Noticed that the start of week starts from Wednesday. Kinda stupid but shows how the calendar can be easily configured.</p>

<?php
require_once('../../controller.php');
// configure calendar theme
$cssCalendar='';
$cssLongDesc='width:300px;overflow:auto;z-index:10;position:absolute;border:1px solid #333; background-color:#FFCCCC; visibility:hidden;padding:5px;';
initQCalendar('rounded','qCalendarRounded', $cssCalendar, 'myContentRounded', $cssLongDesc, 0,0,0,0,0);
?>

</body>
</html>
