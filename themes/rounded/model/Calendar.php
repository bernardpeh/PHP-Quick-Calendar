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

class QCalendarRounded extends QCalendarBase {

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
		// start rendering table
		
		// start the week from Wed
		$this->fillArray(3);
		
		for($i=0;$i<$this->weeksInMonth;$i++) {
			for ($j=0;$j<7;$j++) {
				
				// check if if is today
				if (($this->today['day'] == $this->cell[$i][$j]['value']) && ($this->today['month'] == $this->month) && ($this->today['year'] == $this->year)) {
					$this->cell[$i][$j]['isToday'] = 1;
				}
				// else normal day
				else {
					$this->cell[$i][$j]['isToday'] = 0;
				}
				// init defaults
				$this->cell[$i][$j]['link'] = 'none';
				$this->cell[$i][$j]['day'] = $this->cell[$i][$j]['value'];
								
				// if days with link
				$count = 0;
				foreach ($this->links as $val) {
					if (($val['day'] == $this->cell[$i][$j]['value']) && (($val['month'] == $this->month) || ($val['month'] == '*')) && (($val['year'] == $this->year) || ($val['year'] == '*'))) {
						switch ($val['link']) {		
							case 'url':
								$this->cell[$i][$j]['link'] = 'url';
								$this->cell[$i][$j]['day'] = "<a href=\"{$val['url']}\" target='_blank' title=\"{$val['short_desc']}\">{$this->cell[$i][$j]['value']}</a>";
								break;
								
							case 'div':
								$this->cell[$i][$j]['day'] = "<a href=\"javascript:;\" onmouseover=\"qCalendarAllDetailsFloatOn('$this->divLongDesc', '$this->theme', '{$this->cell[$i][$j]['value']}', '{$this->month}', '{$this->year}', '{$this->cat_id}');\">{$this->cell[$i][$j]['value']}</a>";
								$this->cell[$i][$j]['link'] = 'div';
								break;
							default:
								break;
						}
						$count++;
					}
				}	
			}
		}	
		// register default body view var
		parent::createBody();
		$view = array();
		$view['cell'] = $this->cell;
		$this->registerView($view);
	}
	
	/**
	 * Overwrite parent html footer.
	 */
	function createFooter() {
	
		// register default footer view var
		parent::createFooter();
		$view = array();
		$view['prevMonth'] = "<a href=\"javascript:;\" onclick=\"displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '$this->day', '$this->prevMonth','$this->pYear', '$this->cat_id')\" class='headerNav' title='Prev Month'><img src=\"".QCALENDAR_WEB_PATH."/themes/$this->theme/images/prev.gif\"></a>";		
		$view['nextMonth'] = "<a href=\"javascript:;\" onclick=\"displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '$this->day', '$this->nextMonth','$this->lYear', '$this->cat_id')\" class='headerNav' title='Next Month'><img src=\"".QCALENDAR_WEB_PATH."/themes/$this->theme/images/next.gif\"></a>";
		// register view variable
		$this->registerView($view);
	}
}
?>
