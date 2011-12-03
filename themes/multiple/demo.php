<?php
/*
   Copyright 2009 Bernard Peh

   This file is part of PHP Quick Calendar.

   NOTICE OF LICENSE

   This source file is subject to the Open Software License (OSL 3.0)
   that is bundled with this package in the file LICENSE.txt.
   It is also available through the world-wide-web at this URL:
   http://opensource.org/licenses/osl-3.0.php
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>Demo theme - Multiple Calendars</title>

</head>

<body>

<h2>PHP Quick Calender Demo - Multiple calendars</h2>
<p>Display multiple calendars at a time using simple for-loop. With abit of CSS styling, noticed all the calendar has the same height irregardless of the number of weeks in a month.</p>
<?php
require_once('../../controller.php');
for ($i=1; $i<13; $i++) {
	// configure calendar theme
	echo "<div style='float:left; margin-right:20px;margin-bottom:20px;border:1px dashed red; vertical-align:top;height:180px;'>";
	$cssCalendar= '';
	$cssLongDesc='width:300px;overflow:auto;z-index:10;position:absolute;border:1px solid #333; background-color:#fff; visibility:hidden;padding:5px;';
	initQCalendar('plain', 'qCalendar'.$i, $cssCalendar, 'myContent'.$i, $cssLongDesc, 0, $i, '2009', 0, 0);
	echo "</div>";
}
?>

</body>
</html>
