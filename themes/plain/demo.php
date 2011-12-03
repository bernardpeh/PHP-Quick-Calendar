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

<title>Demo theme - Plain Calendar</title>

</head>

<body>

<h2>PHP Quick Calender Demo - Plain Calendar</h2>
<p>Shows basic functionality without header and footer. Added abit of mouseover effects.</p>

<?php
require_once('../../controller.php');
$cssCalendar= 'float:left;border: 1px dashed #ddd;';
$cssLongDesc='width:300px;overflow:auto;z-index:10;position:absolute;border:1px solid #333; background-color:#fff; visibility:hidden;padding:5px;';
// configure calendar theme
initQCalendar('plain','qCalendarPlain', $cssCalendar, 'myContentPlain', $cssLongDesc, 0,0,0,0,0);
?>

</body>
</html>
