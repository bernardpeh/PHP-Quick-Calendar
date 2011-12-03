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
 * The standard QCalendar Class
 * 
 * Quick Calendar parent class. The user can then display the calendar using the render function.
 *
 */
class QCalendarBase {
	
	// calendar html to render
	var $html;
	
	// no. of days in current month
	var $daysInMonth;
	
	// no. of weeks in current month
	var $weeksInMonth;
	
	// days in array
	var $cell;
	
	// first day of month
	var $firstDay;
	
	// this month
	var $month;
	
	// css name for calendar
	var $css;
	
	// this year
	var $year;
	
	// this day
	var $day;
	
	// this category
	var $cat_id;
	
	// today in array format
	var $today;
	
	// links in array. links will appear in the cell.
	var $links;
	
	// header description
	var $header;
	
	// next month
	var $nextMonth;
	
	// previous month
	var $prevMonth;
	
	// next year. why i named it lYear i dont know.
	var $lYear;
	
	// previous year
	var $pYear;
	
	// calendar theme
	var $theme;
	
	// calendar div
	var $divCalendar;
	
	// calendar long description div
	var $divLongDesc;
	
	// view container
	var $view;
	
	/**
	 * The constructor 
	 *
	 * The constructor initialises the calendar.
	 *
	 */
	function QCalendarBase($theme, $divCalendar, $divLongDesc) {
		// set css
		$this->setCss($theme);
		// set theme
		$this->theme = $theme;
		$this->divCalendar = $divCalendar;
		$this->divLongDesc = $divLongDesc;
		// This year
		$this->year  = date('Y');
		// This month
		$this->month = date('n');
		// This Day
		$this->day = date('j');
		// Selected Category ID
		$this->cat_id = 0;
		$this->today = array('day'=>$this->day, 'month'=>$this->month, 'year'=>$this->year);
		$this->init();
	}
	
	// $firstColumn: 0 is a sunday
	function init() {
		$this->cell = array();
		$this->links = array();
		$this->view = array();
		$this->daysInMonth = date("t",mktime(0,0,0,$this->month,1,$this->year));
		// get first day of the month
		$this->firstDay = date("w", mktime(0,0,0,$this->month,1,$this->year));
		$tempDays = $this->firstDay + $this->daysInMonth;
		$this->weeksInMonth = ceil($tempDays/7);
		$this->createLinks();
		$this->fillArray();
		$this->buildNavigationVar();	
	}
	/**
	 * Check if user uses ajax
	 *
	 */
	function createLinks() {
		$sql = "SELECT q.id, q.hr, q.min, q.day, q.month, q.year, q.link, q.url, q.short_desc, q.short_desc_image, c.short_desc as category, c.id as cat_id FROM ".QCALENDAR_TABLE." as q,".QCALENDAR_CAT_TABLE." as c WHERE IF ($this->cat_id != 0, c.id = '$this->cat_id', 1) AND q.category_id=c.id AND q.active='1' and ((q.month='$this->month' AND q.year='$this->year') || (q.month='*' AND q.year='$this->year') || (q.month='$this->month' AND q.year='*') || (q.month='*' AND q.year='*')) order by q.hr asc, q.min asc";
		$rs = mysql_query($sql);
		while ($rw = mysql_fetch_array($rs)) {
			extract($rw);
			$this->links[] = array('id'=>$id, 'cat_id'=>$cat_id, 'hr' => $hr, 'min' => $min ,'day'=>$day, 'month'=>$month, 'year'=>$year, 'link'=>$link, 'url' => $url, 'short_desc'=>$short_desc, 'short_desc_image'=>$short_desc_image, 'category' => $category);
		}
	}	
	
	/**
	 * register variables to View
	 *
	 * @param Array $view
	 */
	 function registerView($view) {
		if (is_array($view)) {
			foreach ($view as $k => $v) {
				$this->view[$k] = $v;
			}
		}
		else {
			exit('$view must be an array');
		}
	 }
	 
	/**
	 * set css name of table
	 *
	 * @param String $css
	 */
	 function setCss($css) {
		$this->css=$css;
	 }
	 
	 /**
	 * set month
	 *
	 * @param int $m
	 */
	 function setMonth($m) {
		$this->month=$m;
	 }
	 
	 /**
	 * set year
	 *
	 * @param int $y
	 */
	 function setYear($y) {
		$this->year=$y;
	 }
	 
	 /**
	 * set day
	 *
	 * @param int $d
	 */
	 function setDay($d) {
		$this->day=$d;
	 }
	 
	 /**
	 * set category id
	 *
	 * @param int $cat_id
	 */
	 function setCategoryId($cat_id) {
		$this->cat_id=$cat_id;
	 }
	 
	/**
	 * The calendar is created using a 2-D array. This function fills the array with the right values. 0 is a sunday.
	 *
	 * @param Int $firstColumn
	 */
	function fillArray($firstColumn=0) {
		// create a 2-d array
		$counter = $firstColumn;
		if ($firstColumn > $this->firstDay) {
			$counter = -(7 - $firstColumn);
			$this->weeksInMonth++;
		}
		
		for($i=0; $i<$this->weeksInMonth; $i++) {
			// if days in month exceeded, break out of loop
			if ($counter - $this->firstDay + 1 > $this->daysInMonth) {
				$this->weeksInMonth--;
			}
				
			for($j=0;$j<7;$j++) {				
				$counter++;
				$this->cell[$i][$j]['value'] = $counter; 
				// offset the days
				$this->cell[$i][$j]['value'] -= $this->firstDay;
				if (($this->cell[$i][$j]['value'] < 1) || ($this->cell[$i][$j]['value'] > $this->daysInMonth)) {	
					$this->cell[$i][$j]['value'] = '';
				}
			}
		}
	}
	
	function buildNavigationVar() {
		$this->header = date('M', mktime(0,0,0,$this->month,1,$this->year)).' '.$this->year;
		$this->nextMonth = $this->month+1;
		$this->prevMonth = $this->month-1;

		switch($this->month) {
			case 1:
	   			$this->lYear = $this->year;
   				$this->pYear = $this->year-1;
   				$this->nextMonth=2;
   				$this->prevMonth=12;
   				break;
  			case 12:
   				$this->lYear = $this->year+1;
   				$this->pYear = $this->year;
   				$this->nextMonth=1;
   				$this->prevMonth=11;
      			break;
  			default:
      			$this->lYear = $this->year;
	   			$this->pYear = $this->year;
    	  		break;
  		}
	}
	
	/**
	 * default html header
	 */
	function createHeader() {
		$view = array();
		$view['lastYear'] = "displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '$this->day', '$this->month','".($this->year-1)."', '$this->cat_id')";
		$view['lastMonth'] = "displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '$this->day', '$this->prevMonth','$this->pYear', '$this->cat_id')";
		$view['header'] = $this->header;
		$view['nextMonth'] = "displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '$this->day', '$this->nextMonth','$this->lYear', '$this->cat_id')";
		$view['nextYear'] = "displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '$this->day', '$this->month','".($this->year+1)."', '$this->cat_id')";
		// register view variable
		$this->registerView($view);
	}
	
	/**
	 * default html body
	 */
	function createBody() {
		$view = array();
		$view['weeksInMonth'] = $this->weeksInMonth;
		$this->registerView($view);
	}
	
	/**
	 * default html footer
	 */
	function createFooter() {
		// nothing for now
	}
	
	/**
	 * Call this function to render the html
	 *
	 */
	function render() {
		// create HTML
		$this->createHeader();
		$this->createBody();
		$this->createFooter();
		// add standard var
		$this->view['css'] = $this->css;
		$this->view['QCALENDAR_SYS_PATH'] = QCALENDAR_SYS_PATH;
		$this->view['QCALENDAR_WEB_PATH'] = QCALENDAR_WEB_PATH;
		require_once(QCALENDAR_SYS_PATH."/QCalendarView.php");
		new QCalendarView($this->view, $this->theme, 'calendar.phtml');
	}
}
?>
