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


// CONFIGURE WEB LOCATION FROM ROOT
define(QCALENDAR_WEB_PATH,'/qcalendar');

// CONFIGURE DB ACCESS
$dbhost = 'localhost';
$dbuser = '';
$dbpass = '';
$database = '';

// CONFIGURE MAIN TABLE
define(QCALENDAR_TABLE,'qcalendar');

// CONFIGURE CATEGORY TABLE
define(QCALENDAR_CAT_TABLE,'qcalendar_category');

// END OF CONFIGURATION. NOTHING NEEDS TO BE DONE BEYOND THIS POINT.

// start connecting to db
$dbConnect = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$dbConnect) {
   die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db($database, $dbConnect);
if (!$db_selected) {
   die ('db selection error : ' . mysql_error());
}
?>
