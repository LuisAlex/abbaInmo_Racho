<?php
/*------------------------------------------------------------------------
# com_properties
# ------------------------------------------------------------------------
# author Fabio Esteban Uzeltinger
# copyright Copyright (C) 2011 com-property.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:  www.com-property.com
# Technical Support: www.com-property.com/forum-v4
*/
// no direct access
defined('_JEXEC') or die('Restricted access'); 


// PHP Calendar Class Version 1.4 (5th March 2001)
//  
// Copyright David Wilkinson 2000 - 2001. All Rights reserved.
// 
// This software may be used, modified and distributed freely
// providing this copyright notice remains intact at the head 
// of the file.
//
// This software is freeware. The author accepts no liability for
// any loss or damages whatsoever incurred directly or indirectly 
// from the use of this script. The author of this software makes 
// no claims as to its fitness for any purpose whatsoever. If you 
// wish to use this software you should first satisfy yourself that 
// it meets your requirements.
//
// URL:   http://www.cascade.org.uk/software/php/calendar/
// Email: davidw@cascade.org.uk


class Calendar
{
    /*
        Constructor for the Calendar class
    */
    function Calendar()
    {
    }
    
    
    /*
        Get the array of strings used to label the days of the week. This array contains seven 
        elements, one for each day of the week. The first entry in this array represents Sunday. 
    */
    function getDayNames()
    {
        return $this->dayNames;
    }
    

    /*
        Set the array of strings used to label the days of the week. This array must contain seven 
        elements, one for each day of the week. The first entry in this array represents Sunday. 
    */
    function setDayNames($names)
    {
        $this->dayNames = $names;
    }
    
    /*
        Get the array of strings used to label the months of the year. This array contains twelve 
        elements, one for each month of the year. The first entry in this array represents January. 
    */
    function getMonthNames()
    {
        //return $this->monthNames;
    }
    
    /*
        Set the array of strings used to label the months of the year. This array must contain twelve 
        elements, one for each month of the year. The first entry in this array represents January. 
    */
    function setMonthNames($names)
    {
        //$this->monthNames = $names;
    }
    
    
    
    /* 
        Gets the start day of the week. This is the day that appears in the first column
        of the calendar. Sunday = 0.
    */
      function getStartDay()
    {
        return $this->startDay;
    }
    
    /* 
        Sets the start day of the week. This is the day that appears in the first column
        of the calendar. Sunday = 0.
    */
    function setStartDay($day)
    {
        $this->startDay = $day;
    }
    
    
    /* 
        Gets the start month of the year. This is the month that appears first in the year
        view. January = 1.
    */
    function getStartMonth()
    {
        return $this->startMonth;
    }
    
    /* 
        Sets the start month of the year. This is the month that appears first in the year
        view. January = 1.
    */
    function setStartMonth($month)
    {
        $this->startMonth = $month;
    }
    
    function getAmountMonths()
    {
        return $this->AmountMonths;
    }
	
	function setAmountMonths($AmountMonthsCalendar)
    {
        $this->AmountMonths = $AmountMonthsCalendar;
    }
	
	function getPropertyId()
    {
        return $this->PropertyId;
    }
	
	function setPropertyId($PropertyId)
    {
        $this->PropertyId = $PropertyId;
		$this->WeeksSelected=array();
    }
	
	function getDateSelected()
    {
        return $this->DateSelected;
    }
	
	function setDateSelected($DateSelected)
    {
        $this->DateSelected = $DateSelected;
    }
	function getDuration()
    {
        return $this->Duration;
    }
	
	function setDuration($Duration)
    {
        $this->Duration = $Duration;
		$this->WeeksSelected=$this->getWeeksSelected($Duration,$this->DateSelected);
		/*print_r($this->WeeksSelected); */
    }
	
	function getWeeksSelected($Duration,$DateSelected)
    {
	$total_weeks = $this->Duration/7;
	for($x=0;$x<$total_weeks;$x++)
		{
		//$i=$i+7;
		//$x=$i;
		//echo '<br>x: '.$x.'<br>';
		$selected=explode('-',$DateSelected);
		$year_select=$selected[0];
		$month_select=$selected[1];
		$day_select=$selected[2];
		
		$this_week  = date('Y-m-d',mktime(0, 0, 0, $month_select, ($day_select+($x*7)), $year_select));
		$WeeksSelected[$this_week]=$this_week;
		$lastday=date('Y-m-d',mktime(0, 0, 0, $month_select, ($day_select+(($x+1)*7)), $year_select));
		}
       // print_r($WeeksSelected); 
		//echo $lastday;
		$this->LastDaySelected=$lastday;
		return $WeeksSelected;
    }
	
	
    /*
        Return the URL to link to in order to display a calendar for a given month/year.
        You must override this method if you want to activate the "forward" and "back" 
        feature of the calendar.
        
        Note: If you return an empty string from this function, no navigation link will
        be displayed. This is the default behaviour.
        
        If the calendar is being displayed in "year" view, $month will be set to zero.
    */
    function getCalendarLink($month, $year)
    {
        return "";
    }
    
    /*
        Return the URL to link to  for a given date.
        You must override this method if you want to activate the date linking
        feature of the calendar.
        
        Note: If you return an empty string from this function, no navigation link will
        be displayed. This is the default behaviour.
    */
    function getDateLink($day, $month, $year)
    {
        return "";
    }


    /*
        Return the HTML for the current month
    */
    function getCurrentMonthView()
    {
        $d = getdate(time());
        return $this->getMonthView($d["mon"], $d["year"]);
    }
    

    /*
        Return the HTML for the current year
    */
    function getCurrentYearView()
    {
        $d = getdate(time());
        return $this->getYearView($d["year"]);
    }
    
    
    /*
        Return the HTML for a specified month
    */
    function getMonthView($month, $year)
    {
        return $this->getMonthHTML($month, $year);
    }
    

    /*
        Return the HTML for a specified year
    */
    function getYearView($year)
    {
        return $this->getYearHTML($year);
    }
    
    
    
    /********************************************************************************
    
        The rest are private methods. No user-servicable parts inside.
        
        You shouldn't need to call any of these functions directly.
        
    *********************************************************************************/


    /*
        Calculate the number of days in a month, taking into account leap years.
    */
    function getDaysInMonth($month, $year)
    {
        if ($month < 1 || $month > 12)
        {
            return 0;
        }
   
        $d = $this->daysInMonth[$month - 1];
   
        if ($month == 2)
        {
            // Check for leap year
            // Forget the 4000 rule, I doubt I'll be around then...
        
            if ($year%4 == 0)
            {
                if ($year%100 == 0)
                {
                    if ($year%400 == 0)
                    {
                        $d = 29;
                    }
                }
                else
                {
                    $d = 29;
                }
            }
        }
    
        return $d;
    }


    /*
        Generate the HTML for a given month
    */
    function getMonthHTML($m, $y, $showYear = 1)
    {
        $s = "";
        
        $a = $this->adjustDate($m, $y);
        $month = $a[0];
        $year = $a[1];        
        
    	$daysInMonth = $this->getDaysInMonth($month, $year);
    	$date = getdate(mktime(12, 0, 0, $month, 1, $year));
    	
    	$first = $date["wday"];
    	$monthName = $this->monthNames[$month - 1];
    	$monthName = JText::_($monthName);
    	$prev = $this->adjustDate($month - 1, $year);
    	$next = $this->adjustDate($month + 1, $year);
    	
    	if ($showYear == 1)
    	{
    	    $prevMonth = $this->getCalendarLink($prev[0], $prev[1]);
    	    $nextMonth = $this->getCalendarLink($next[0], $next[1]);
    	}
    	else
    	{
    	    $prevMonth = "";
    	    $nextMonth = "";
    	}
    	
    	$header = $monthName . (($showYear > 0) ? " " . $year : "");
    	
    	$s .= "<table class=\"table_month\">\n";
    	$s .= "<tr>\n";
    	//$s .= "<td align=\"center\" valign=\"top\">" . (($prevMonth == "") ? "&nbsp;" : "<a href=\"$prevMonth\">&lt;&lt;</a>")  . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\" colspan=\"7\">$header</td>\n"; 
    	//$s .= "<td align=\"center\" valign=\"top\">" . (($nextMonth == "") ? "&nbsp;" : "<a href=\"$nextMonth\">&gt;&gt;</a>")  . "</td>\n";
    	$s .= "</tr>\n";
    	
    	$s .= "<tr>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay)%7]) . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay+1)%7]) . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay+2)%7]) . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay+3)%7]) . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay+4)%7]) . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay+5)%7]) . "</td>\n";
    	$s .= "<td align=\"center\" valign=\"top\" class=\"calendarHeader\">" . JText::_($this->dayNames[($this->startDay+6)%7]) . "</td>\n";
    	$s .= "</tr>\n";
    	
    	// We need to work out what date to start at so that the first appears in the correct column
    	$d = $this->startDay + 1 - $first;
    	while ($d > 1)
    	{
    	    $d -= 7;
    	}

        // Make sure we know when today is, so that we can use a different CSS style
        $today = getdate(time());
    	
		
		
		
		
		
		
		
		$availavility=$this->getAvailbilityBooking($month,$year,$this->PropertyId);

		//$Unrented = $this->getUnrentedBooking($this->PropertyId);
		
		
		$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$PeriodEndBookings=$params->get('PeriodEndBookings');
$PeriodEndBookings=date('Y-m-d',strtotime($PeriodEndBookings));


		/*
		echo '<pre>';
		print_r($availavility);
		echo '</pre>';
		
		echo '<pre>';
		print_r($Unrented);
		echo '</pre>';
		*/
		
		
		
		
		
		
		
		
    	while ($d <= $daysInMonth)
    	{
    	    $s .= "<tr>\n";       
    	    
    	    for ($i = 0; $i < 7; $i++)
    	    {
        	    			
				   
    	        if ($d > 0 && $d <= $daysInMonth)
    	        {    	            
					
					if($d<10){$day_text='0'.$d;}else{$day_text=$d;}				
				
					if($month<10){$day_month='0'.$month;}else{$day_month=$month;}
				
					$DateToText=$year.'-'.$day_month.'-'.$day_text;
					
					$txtDate=$year.'-'.$month.'-'.$d;					
					
					if($availavility[$txtDate])
					{
					$this->available_class="available_".$availavility[$txtDate]->available;
					}else{
					$this->available_class="available_0";
					}
					
					$s .= "<td class=\"$this->available_class\" align=\"right\" valign=\"top\">".$d."</td>\n";										
					
    	        }
    	        else
    	        {
    	            $s .= "<td class=\"empty\" align=\"right\" valign=\"top\">&nbsp;</td>\n";
    	        }
				
				
      	       // $s .= "</td>\n";       
        	    $d++;
    	    }
    	    $s .= "</tr>\n";    
    	}
    	
    	$s .= "</table>\n";
    	
    	return $s;  	
    }
    
    
    /*
        Generate the HTML for a given year
    */
    function getYearHTML($year)
    {
        $s = "";
    	$prev = $this->getCalendarLink(0, $year - 1);
    	$next = $this->getCalendarLink(0, $year + 1);
        $AmountMonths=$this->AmountMonths;
		//echo $AmountMonths;
        $s .= "<table class=\"table_calendar\" border=\"0\">\n";
        //$s .= "<tr>";
    	//$s .= "<td align=\"center\" valign=\"top\" align=\"left\">" . (($prev == "") ? "&nbsp;" : "<a href=\"$prev\">&lt;&lt;</a>")  . "</td>\n";
       // $s .= "<td class=\"calendarHeader\" valign=\"top\" align=\"center\">" .  $year . "</td>\n";
    	//$s .= "<td align=\"center\" valign=\"top\" align=\"right\">" . (($next == "") ? "&nbsp;" : "<a href=\"$next\">&gt;&gt;</a>")  . "</td>\n";
      //  $s .= "</tr>\n";
        $s .= "<tr>";
        for($x=0;$x<$AmountMonths;$x++)
			{
		$s .= "<td class=\"td_calendar\" valign=\"top\">" . JText::_($this->getMonthHTML($x + $this->startMonth, $year, 0)) ."</td>\n";	
			}
		
        $s .= "</table>\n";
        
        return $s;
    }

    /*
        Adjust dates to allow months > 12 and < 0. Just adjust the years appropriately.
        e.g. Month 14 of the year 2001 is actually month 2 of year 2002.
    */
    function adjustDate($month, $year)
    {
        $a = array();  
        $a[0] = $month;
        $a[1] = $year;
        
        while ($a[0] > 12)
        {
            $a[0] -= 12;
            $a[1]++;
        }
        
        while ($a[0] <= 0)
        {
            $a[0] += 12;
            $a[1]--;
        }
        
        return $a;
    }



function getAvailbilityBooking($month,$year,$id_property){
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$PeriodEndBookings=$params->get('PeriodEndBookings');
$PeriodEndBookings=date('Y-m-d',strtotime($PeriodEndBookings));

//$PeriodUnrentedBooking=$this->getUnrentedBooking($id_property);

$db = & JFactory::getDBO();
if($month<10){$month='0'.$month;}
$query = 'SELECT date,available from #__properties_available_product '.
		' WHERE id_product = '.$id_property.		
		" AND EXTRACT(YEAR_MONTH FROM date) = ".$year.$month;
		//' AND available = 1 '.
	//	echo $query;
$db->setQuery($query);

$list = $db->loadObjectList();
//print_r($list);
foreach($list as $l){
$dia=explode('-',$l->date);
//echo $dia[2];
//$availavility[(int)$dia[2]]=$l->available;

$l->day=(int)$dia[2];
$return[(int)$dia[0].'-'.(int)$dia[1].'-'.(int)$dia[2]] = $l;
}

return $return;
}

function getUnrentedBooking($id_property){	
$db = & JFactory::getDBO();
$query = 'SELECT op_from,op_to from #__properties_owners_properties '.
		' WHERE op_property = '.$id_property
		//.' AND available = 0'
		;
$db->setQuery($query);
$List = $db->loadObject();
if($List)
	{
$fs=explode('-',$List->op_to);
$List->op_to = date('Y-m-d',mktime(0, 0, 0, $fs[1], ($fs[2]-7)  , $fs[0]));
	}
//print_r($Unavailavility);
return $List;
}

    /* 
        The start day of the week. This is the day that appears in the first column
        of the calendar. Sunday = 0.
    */
    var $startDay = 0;

    /* 
        The start month of the year. This is the month that appears in the first slot
        of the calendar in the year view. January = 1.
    */
    var $startMonth = 1;

    /*
        The labels to display for the days of the week. The first entry in this array
        represents Sunday.
    */
   /* var $dayNames = array("S", "M", "T", "W", "T", "F", "S");*/
    var $dayNames = array("nameday1","nameday2","nameday3","nameday4","nameday5","nameday6","nameday7",);
    /*
        The labels to display for the months of the year. The first entry in this array
        represents January.
    */

    var $monthNames = array("January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December");
                            
                            
    /*
        The number of days in each month. You're unlikely to want to change this...
        The first entry in this array represents January.
    */
    var $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    
}

?>
