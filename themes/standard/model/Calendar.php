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

class QCalendarStandard extends QCalendarBase {

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
				$this->cell[$i][$j]['short_desc'][] = '';
				$this->cell[$i][$j]['short_desc_image'][] ='';
								
				// if days with link
				$count = 0;
				foreach ($this->links as $val) {
					if (($val['day'] == $this->cell[$i][$j]['value']) && (($val['month'] == $this->month) || ($val['month'] == '*')) && (($val['year'] == $this->year) || ($val['year'] == '*'))) {
						switch ($val['link']) {		
							case 'url':
								$this->cell[$i][$j]['link'] = 'url';
								$this->cell[$i][$j]['short_desc'][$count] = "<a href=\"{$val['url']}\" target='_blank'>{$val['short_desc']}</a>";
								$this->cell[$i][$j]['short_desc_image'][$count] = ($val['short_desc_image']) ? "<a href=\"".QCALENDAR_WEB_PATH."{$val['url']}\" target='_blank'><img src=\"".QCALENDAR_WEB_PATH."{$val['short_desc_image']}\"></a>" : '';
								break;
								
							case 'div':
								$this->cell[$i][$j]['link'] = 'div';
								$this->cell[$i][$j]['short_desc'][$count] = "<a href=\"javascript:;\" onclick=\"qCalendarDetails('$this->divLongDesc', '$this->theme', {$val['id']})\">{$val['short_desc']}</a>";
								$this->cell[$i][$j]['short_desc_image'][$count] = ($val['short_desc_image']) ? "<a href=\"javascript:;\" onclick=\"qCalendarDetails('$this->divLongDesc', '$this->theme', {$val['id']})\"><img src=\"".QCALENDAR_WEB_PATH."{$val['short_desc_image']}\"></a>" : '';
								break;
								
							default:
								$this->cell[$i][$j]['short_desc'][$count] = $val['short_desc'];
								$this->cell[$i][$j]['short_desc_image'][$count] = $val['short_desc_image'];
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
		$view['todayLink'] = "displayQCalendar('$this->theme', '$this->divCalendar', '$this->divLongDesc', '{$this->day}', '{$this->today['month']}','{$this->today['year']}', '{$this->cat_id}')";
		$view['todayText'] = $this->today['day'].' '.date('M', mktime(0,0,0,$this->today['month'],1,$this->today['year'])).' '.$this->today['year'];
		// register view variable
		$this->registerView($view);
	}
}
?>
