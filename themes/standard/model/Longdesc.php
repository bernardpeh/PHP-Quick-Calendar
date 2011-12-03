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

// model for longdesc

require_once(QCALENDAR_SYS_PATH.'/QCalendarLongdesc.php');

class LongdescStandard extends QCalendarLongDesc {

	function LongdescStandard($view, $theme) {
		parent::QCalendarLongDesc($view, $theme);
	}
}
?>
