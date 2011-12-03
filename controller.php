<?php
/*
   Copyright 2009 Bernard Peh

   This file is part of PHP Quick Calendar.

   PHP Quick Calendar is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   PHP Quick Calendar is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with PHP Quick Calendar.  If not, see <http://www.gnu.org/licenses/>.
*/

?>

<?php
define(QCALENDAR_SYS_PATH, dirname(__FILE__));
require_once(QCALENDAR_SYS_PATH.'/config.php');
require_once(QCALENDAR_SYS_PATH.'/QCalendarBase.php');
?>
<script type='text/javascript'>
/* <![CDATA[ */
qcalendarsyspath = '<?= QCALENDAR_WEB_PATH ?>'+'/';
/* ]]> */
</script>

<?php
/*
 * set calendar theme
 *
 * A factory that generates the right object based on user input
 *
 */
function initQCalendar($theme,$divCalendar='qCalendar', $divCalendarCss='', $divLongDesc='qCalendarLongDesc', $divLongDescCss='', $d=0, $m=0, $y=0, $c=0, $ajax=0) {
	require_once(QCALENDAR_SYS_PATH."/themes/$theme/model/Calendar.php");
 	if (!$ajax) {
		echo '<script type=\'text/javascript\' src=\''.QCALENDAR_WEB_PATH.'/js/qCalendar.js\'></script>';
		// insert calendar css
		echo "<link href=\"".QCALENDAR_WEB_PATH."/themes/$theme/view/calendar.css\" rel=\"stylesheet\" type=\"text/css\" />";
		// clear all styles first to prevent css inheritance from other parts of the page
		echo "<div style=\"margin: 0;padding: 0;border: 0;outline: 0;font-size: 100%;vertical-align: baseline;background: transparent; text-align:center;\">";
		echo "<div id='$divCalendar' style='$divCalendarCss'>";
	}
	$classname = 'QCalendar'.ucfirst($theme);
	$qcal = new $classname($theme, $divCalendar, $divLongDesc);
	// if month or year is set
	if ($m || $y || $d || $c) {
		$qcal->setMonth($m);
		$qcal->setYear($y);
		$qcal->setDay($d);
		$qcal->setCategoryId($c);
		$qcal->init();
	}
	// render calendar
	$qcal->render();

	if (!$ajax) {
		echo "</div></div>";
		// insert long desc css
		echo "<link href=\"".QCALENDAR_WEB_PATH."/themes/$theme/view/longdesc.css\" rel=\"stylesheet\" type=\"text/css\" />";
		// render long desc
		echo "<div id='$divLongDesc' style='$divLongDescCss'></div>";
		// clear all styles
		echo "<div style='clear:both'></div>";
	}
}

// if user clicks on cell links to display one event
if (isset($_GET['id']) && isset($_GET['theme'])) {
	$sql = "SELECT q.day, q.month, q.year, q.link, q.hr, q.min, c.short_desc as category, q.short_desc, q.long_desc, q.short_desc_image, q.long_desc_image FROM ".QCALENDAR_TABLE." as q, ".QCALENDAR_CAT_TABLE." as c WHERE q.id='{$_GET['id']}' AND q.category_id=c.id AND q.active='1'";
	$rs = mysql_query($sql);
	$rw = mysql_fetch_assoc($rs);
	foreach ($rw as $k => $v) {
		$view[$k] = $v;
	}
	// calls the required model
	require_once(QCALENDAR_SYS_PATH."/themes/{$_GET['theme']}/model/Longdesc.php");
	$classname = 'Longdesc'.ucfirst($_GET['theme']);
	$longdesc = new $classname($view, $_GET['theme']);
	$longdesc->render();
	exit();
}

// if user clicks on cell links to display many events
if (!isset($_GET['divCalendar']) && isset($_GET['m'])) {
	$sql = "SELECT q.day, q.month, q.year, q.link, q.hr, q.min, c.short_desc as category, q.short_desc, q.long_desc, q.short_desc_image, q.long_desc_image FROM ".QCALENDAR_TABLE." as q, ".QCALENDAR_CAT_TABLE." as c WHERE q.category_id=c.id AND IF ({$_GET['c']}!= 0, c.id = '{$_GET['c']}', 1) AND q.active='1' AND ((q.day = '{$_GET['d']}' && q.month='{$_GET['m']}' AND q.year='{$_GET['y']}') || (q.day = '{$_GET['d']}' && q.month='*' AND q.year='{$_GET['y']}') || (q.day = '{$_GET['d']}' && q.month='{$_GET['m']}' AND q.year='*') || (q.day = '*' && q.month='{$_GET['m']}' AND q.year='{$_GET['y']}') || (q.day = '*' && q.month='{$_GET['m']}' AND q.year='{$_GET['y']}') || (q.day = '*' && q.month='*' AND q.year='*') || (q.day = '{$_GET['d']}' && q.month='*' AND q.year='*') || (q.day = '*' && q.month='{$_GET['m']}' AND q.year='*') || (q.day = '*' && q.month='*' AND q.year='{$_GET['y']}')) order by q.hr asc, q.min asc";
	$rs = mysql_query($sql);
	while ($rw = mysql_fetch_assoc($rs)) {
		foreach ($rw as $k => $v) {
			$view[$k][] = $v;
		}
	}
	// calls the required model
	require_once(QCALENDAR_SYS_PATH."/themes/{$_GET['theme']}/model/Longdesc.php");
	$classname = 'Longdesc'.ucfirst($_GET['theme']);
	$longdesc = new $classname($view, $_GET['theme']);
	$longdesc->render();
	exit();
}

// if user clicks on month or year navigation, re-render calendar
if (isset($_GET['divCalendar']) && isset($_GET['m'])) {
	initQCalendar($_GET['theme'], $_GET['divCalendar'], '', $_GET['divLongDesc'], '', $_GET['d'], $_GET['m'],$_GET['y'], $_GET['c'], 1);
	exit();
}
?>


