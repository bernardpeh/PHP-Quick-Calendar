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

<?php
/*
Email Example

You can set cron jobs that run every morning 4am and check for events that are to occur on that day. If there are events on that day, send a reminder email to the specified user.

In the crontab

0 4 * * * php /path_to_this_dir/cron.php

you can also incorporate an sms gateway to send sms.
*/
define(QCALENDAR_SYS_PATH, dirname(__FILE__));
require_once(QCALENDAR_SYS_PATH.'/config.php');

// This year
$y  = date('Y');
// This month
$m = date('n');
// This day
$d = date('j');

$sql = "SELECT q.day, q.month, q.year, q.link, q.hr, q.min, c.short_desc as category, q.short_desc, q.long_desc, q.short_desc_image, q.long_desc_image FROM ".QCALENDAR_TABLE." as q, ".QCALENDAR_CAT_TABLE." as c WHERE q.category_id=c.id AND q.active='1' AND q.email_alert='1' AND ((q.day = '$d' && q.month='$m' AND q.year='$y') || (q.day = '$d' && q.month='*' AND q.year='$y') || (q.day = '$d' && q.month='$m' AND q.year='*') || (q.day = '*' && q.month='$m' AND q.year='$y') || (q.day = '*' && q.month='$m' AND q.year='$y') || (q.day = '*' && q.month='*' AND q.year='*') || (q.day = '$d' && q.month='*' AND q.year='*') || (q.day = '*' && q.month='$m' AND q.year='*') || (q.day = '*' && q.month='*' AND q.year='$y'))";

$rs = mysql_query($sql);
while ($rw = mysql_fetch_assoc($rs)) {
	extract($rw);
	$recipient = $cron_email;
	$subject =  $short_desc;
	$mail_body = "${year}-${month}-${day}\n\n$hr hrs $min mins\n\n$long_desc";
	// using simple php mail function
	mail($recipient, $subject, $mail_body);
}
?>