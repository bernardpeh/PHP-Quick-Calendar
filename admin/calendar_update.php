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


require_once('../config.php');

// if user deletes
if (isset($_GET['del'])) {
	$sql = "delete from ".QCALENDAR_TABLE." where id='".$_GET['id']."'";
	mysql_query($sql) or die(mysql_error());
	exit("Entry #".$_GET['id']." deleted. <a href=\"calendar.php\">back to admin home.</a>");
}
// del short desc image
if (isset($_GET['delshortimage'])) {
	// get file link
	$sql = "select short_desc_image from ".QCALENDAR_TABLE." where id='".$_GET['id']."'";
	$rs = mysql_query($sql) or die(mysql_error());
	extract(mysql_fetch_assoc($rs));
	// delete file
	unlink(QCALENDAR_SYS_PATH.$short_desc_image);
	// remove from db
	$sql = "update ".QCALENDAR_TABLE." set short_desc_image='' where id='".$_GET['id']."'";
	mysql_query($sql) or die(mysql_error());
	exit("Entry #".$_GET['id']." updated. <a href=\"calendar.php\">back to admin home.</a>");
}
// del long desc image
if (isset($_GET['dellongimage'])) {
	// get file link
	$sql = "select long_desc_image from ".QCALENDAR_TABLE." where id='".$_GET['id']."'";
	$rs = mysql_query($sql) or die(mysql_error());
	extract(mysql_fetch_assoc($rs));
	// delete file
	unlink(QCALENDAR_SYS_PATH.$long_desc_image);
	// remove from db
	$sql = "update ".QCALENDAR_TABLE." set long_desc_image='' where id='".$_GET['id']."'";
	mysql_query($sql) or die(mysql_error());
	exit("Entry #".$_GET['id']." updated. <a href=\"calendar.php\">back to admin home.</a>");
}
// if user updates
else if (isset($_POST['update']) && isset($_POST['id'])) {
	array_map('addslashes', $_POST);
	extract($_POST);
	if ($_FILES['short_desc_image']['name'] != '') {
		$image_path = '/upload/'.date("Ymds").'_'.$_FILES['short_desc_image']['name'];
		$short_desc_image = $image_path;
		if (!move_uploaded_file($_FILES['short_desc_image']['tmp_name'], QCALENDAR_SYS_PATH.$image_path)) {
			exit("error uploading {$_FILES['short_desc_image']['name']}");
		}
	}
	else {
		$rs = mysql_query("select short_desc_image from ".QCALENDAR_TABLE." where id='{$_POST['id']}'");
		$rw = mysql_fetch_assoc($rs);
		$short_desc_image = $rw['short_desc_image'];
	}
	
	if ($_FILES['long_desc_image']['name'] != '') {
		$image_path = '/upload/'.date("Ymds").'_'.$_FILES['long_desc_image']['name'];
		$long_desc_image = $image_path;
		if (!move_uploaded_file($_FILES['long_desc_image']['tmp_name'], QCALENDAR_SYS_PATH.$image_path)) {
			exit("error uploading {$_FILES['long_desc_image']['name']}");
		}
	}
	else {
		$rs = mysql_query("select long_desc_image from ".QCALENDAR_TABLE." where id='{$_POST['id']}'");
		$rw = mysql_fetch_assoc($rs);
		$long_desc_image = $rw['long_desc_image'];
	}
	$sql = "Update ".QCALENDAR_TABLE." set day='$day', month='$month', year='$year', link='$link', hr='$hr', min='$min', category_id='$category_id', email_alert='$email_alert', sms_alert='$sms_alert', cron_email='$cron_email', cron_sms_number='$cron_sms_number', short_desc='$short_desc', url='$url', long_desc='$long_desc', short_desc_image='$short_desc_image', long_desc_image='$long_desc_image',  active='$active' where id='{$_POST['id']}'";
	mysql_query($sql) or die(mysql_error());
	exit("Entry updated. <a href=\"calendar.php\">back to admin home.</a>");
}
// if user adds new entry
else if (isset($_POST['add'])) {
	array_map('addslashes', $_POST);
	extract($_POST);
	if ($_FILES['short_desc_image']['name'] != '') {
		$image_path = '/upload/'.date("Ymds").'_'.$_FILES['short_desc_image']['name'];
		$short_desc_image = $image_path;
		if (!move_uploaded_file($_FILES['short_desc_image']['tmp_name'], QCALENDAR_SYS_PATH.$image_path)) {
			exit("error uploading {$_FILES['short_desc_image']['name']}");
		}
	}
	if ($_FILES['long_desc_image']['name'] != '') {
		$image_path = '/upload/'.date("Ymds").'_'.$_FILES['long_desc_image']['name'];
		$long_desc_image = $image_path;
		if (!move_uploaded_file($_FILES['long_desc_image']['tmp_name'], QCALENDAR_SYS_PATH.$image_path)) {
			exit("error uploading {$_FILES['long_desc_image']['name']}");
		}
	}
	$sql = "Insert into ".QCALENDAR_TABLE." (day, month, year, hr, min, link, url, short_desc, long_desc, category_id, email_alert, sms_alert, cron_email, cron_sms_number, short_desc_image, long_desc_image, active) values ('$day', '$month', '$year', '$hr', '$min', '$link', '$url', '$short_desc', '$long_desc', '$category_id', '$email_alert', '$sms_alert', '$cron_email', '$cron_sms_number', '$short_desc_image', '$long_desc_image', '$active')";
	mysql_query($sql) or die(mysql_error());
	exit("New entry added. <a href=\"calendar.php\">back to admin home.</a>");
}

// extract user details if user update
if (isset($_GET['id'])) {
	$sql = "select * from ".QCALENDAR_TABLE." where id='".$_GET['id']."'";
	$rs = mysql_query($sql) or die(mysql_error());
	extract(mysql_fetch_assoc($rs));
	echo "<h2>Update Event #$id</h2>";
}
?>

<!-- you may want to verify the input details -->

<form name="form1" method="post" action="" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $_GET['id']; ?>"/>

Hours (0 to 24):<input type="text" name="hr" value="<?= $hr; ?>"/>
<br/><br/>
Minutes (0 to 60):<input type="text" name="min" value="<?= $min; ?>"/>
<br/><br/>
Day (DD):<input type="text" name="day" value="<?= $day; ?>"/>
<br/><br/>
Month (MM): <input type="text" name="month" value="<?= $month; ?>"/>
<br/><br/>
Year (YYYY): <input type="text" name="year" value="<?= $year; ?>"/>
<br/><br/>
Select Category:
<select name="category_id">
<option value='0'>All</option>
<?php
$sql = "select id, short_desc from ".QCALENDAR_CAT_TABLE." where active='1'";
$rs = mysql_query($sql) or die(mysql_error());
while ($rw = mysql_fetch_assoc($rs)) {
	echo "<option value='{$rw['id']}' ";
	if ($category_id == $rw['id']) {
		echo 'selected';
	}
	echo ">{$rw['short_desc']}</option>";
}
?>
</select>	
<br/><br/>
Link Type: <select name="link"><option value='none'>none</option>
<option value='url' <?php if ($link=='url') {echo 'selected';} ?>>url only</option>
<option value='div' <?php if ($link=='div') {echo 'selected';} ?>>div</option></select>
<br/><br/>
URL: <input type="text" name="url" value="<?= $url; ?>"/>
<br/><br/>
Short Desc (HTML):<br/> <textarea name="short_desc"><?= $short_desc; ?></textarea>
<br/><br/>
Long Desc (HTML):<br/> <textarea name="long_desc" style="width:400; height:200px;overflow:auto;"><?= $long_desc; ?></textarea>
<br/><br/>
email alert: <select name="email_alert">
<option value='0' <?php if ($email_alert=='0') {echo 'selected';} ?>>No</option>
<option value='1' <?php if ($email_alert=='1') {echo 'selected';} ?>>Yes</option>
</select>
<br/><br/>
cron email:<input type="text" name="cron_email" value="<?= $cron_email; ?>"/>
<br/><br/>
sms alert: <select name="sms_alert">
<option value='0' <?php if ($sms_alert=='0') {echo 'selected';} ?>>No</option>
<option value='1' <?php if ($sms_alert=='1') {echo 'selected';} ?>>Yes</option>
</select>
<br/><br/>
cron sms number:<input type="text" name="cron_sms_number" value="<?= $cron_sms_number; ?>"/>
<br/><br/>
Short Desc Image: <input type="file" name="short_desc_image" />
<br/><br/>
<?php 
if ($short_desc_image != '') {
	echo "<br/><img src='".QCALENDAR_WEB_PATH."$short_desc_image'/><a href=\"?delshortimage&id={$_GET['id']}\">del</a>";
}
?>
<br/><br/>
Long Desc Image: <input type="file" name="long_desc_image" />
<br/><br/>
<?php 
if ($long_desc_image != '') {
	echo "<br/><img src='".QCALENDAR_WEB_PATH."$long_desc_image'/><a href=\"?dellongimage&id={$_GET['id']}\">del</a>";
}
?>
<br/><br/>
Active: <select name="active">
<option value='1' <?php if ($active=='1') {echo 'selected';} ?>>Yes</option>
<option value='0' <?php if ($active=='0') {echo 'selected';} ?>>No</option>
</select>
<br/><br/>
<?php
// if updating entries
if (isset($_GET['id'])) {
	echo "<input type='submit' name='update' value='Update'>";
}
// adding new entries
else {
	echo "<input type='submit' name='add' value='Add'>";
}
?>
</form>
<p>
Click <a href="http://web-developer.sitecritic.net/2009/01/08/installing-quick-calendar/" target="_blank">here</a> to see what the fields above mean.
</p>
