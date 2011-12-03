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


/*
 * The Long Desc Class
 * 
 * Master class for long desc
 *
 */
class QCalendarLongdesc {

	// theme
	var $theme;
	
	// view variables
	var $view;
	
	// css
	var $css;
	
	// constructor
	function QCalendarLongdesc($view, $theme) {
		$this->theme = $theme;
		$view['QCALENDAR_SYS_PATH'] = QCALENDAR_SYS_PATH;
		$view['QCALENDAR_WEB_PATH'] = QCALENDAR_WEB_PATH;
		$this->css = $theme.'_longdesc';
		$view['css'] = $this->css;
		$this->view = $view;
	}
	
	function render() {
		require_once(QCALENDAR_SYS_PATH.'/QCalendarView.php');
		new QCalendarView($this->view, $this->theme, 'longdesc.phtml');
	}
}
?>
