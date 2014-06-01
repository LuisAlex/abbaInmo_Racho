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

class Tableopenhouse extends JTable
{    
	var $id = null;
	var $pid = null;
	var $publish_up = null;
	var $date = null;
	var $from = null;
	var $to = null;
	var $text = null;
	var $published = null;
	var $ordering = null;
	var $checked_out = null;
	var $checked_out_time = null;
   function __construct(&$db)
  	{
    parent::__construct( '#__properties_openhouse', 'id', $db );
  	}  	
}
?>