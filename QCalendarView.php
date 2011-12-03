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
 * The View Class
 * 
 * Accepts the view array and display html.
 *
 */
class QCalendarView {
	
	// view var
	var $view;
	
	/**
	 * The constructor 
	 *
	 * The constructor initialises the calendar.
	 *
	 */
	function QCalendarView($view, $theme, $file) {
		$this->view = $view;
		extract($view);
		// the view vars is now available for use in the template
		// in the template, print_r($this->view) to see all variables available
		require(QCALENDAR_SYS_PATH."/themes/$theme/view/$file");
	}
}
?>
