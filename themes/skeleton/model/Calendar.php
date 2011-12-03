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

require_once(QCALENDAR_SYS_PATH.'/QCalendarBase.php');

class QCalendarSkeleton extends QCalendarBase {

	// uses parent constructor by default
	
	/**
	 * Overwrite parent header for the calendar.
	 */
	function createHeader() {
		
		// register default header view var
		parent::createHeader();
	}
	
	/**
	 * Overwrite parent html body. This is the main bulk of the logic. modify at your own risks.
	 */
	function createBody(){
	
		/*
		 * Main Bulk of logic is here. If unsure, refer to other themes.
		 */ 
		 // register default body view var
		parent::createBody();
		
	}
	
	/**
	 * Overwrite parent html footer.
	 */
	function createFooter() {
	
		// register default footer view var
		parent::createFooter();
	}
}
?>
