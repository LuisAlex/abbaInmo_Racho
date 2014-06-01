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

class Tablecontacts extends JTable
{    
var $id = null;
var $product_id = null;
var $user_id = null;
var $date = null;
var $name = null;
var $email = null;
var $phone = null;
var $address = null;
var $city = null;
var $state = null;
var $cp = null;
var $text = null;
var $userfile = null;
var $layout = null;
   function __construct(&$db)
  {
    parent::__construct( '#__properties_contacts', 'id', $db );
  }
  
  function check()
	{
		// check for http on webpage		
		if(empty($this->date)) {
		
			$datenow =& JFactory::getDate();
			$this->date = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		return true;
	}
}
?>