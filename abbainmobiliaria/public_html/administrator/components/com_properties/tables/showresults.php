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

class Tableshowresults extends JTable
{    
	var $id = null;
	var $date = null;
	var $url = null;
	var $hits = null;	
	var $cyid = null;
	var $sid = null;
	var $lid = null;
	var $cid = null;
	var $tid = null;
	var $capacity = null;
	var $bedrooms = null;
	var $bathrooms = null;
	var $garage = null;
	var $minprice = null;
	var $maxprice = null;
	
   function __construct(&$db)
  {
    parent::__construct( '#__properties_showresults', 'id', $db );
  }
}
?>