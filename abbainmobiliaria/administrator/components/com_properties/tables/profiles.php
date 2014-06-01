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

class Tableprofiles extends JTable
{    
  var $id = null;
  var $mid = null;
  var $name = null;
  var $alias = null;
  var $company = null;
  var $type = null;
  var $info = null;
  var $bio = null;
  var $properties = null;
  var $address1 = null;
  var $address2 = null;
  var $locality = null;
  var $pcode = null;
  var $state = null;
  var $country = null;
  var $show = null;
  var $email = null;
  var $phone = null;
  var $fax = null;
  var $mobile = null;
  var $skype = null;
  var $ymsgr = null;
  var $icq = null;
  var $web = null;
  var $blog = null;
  var $image = null;
  var $logo_image = null;
  var $logo_image_large = null;
  var $published = null;
  var $ordering = null;
  var $checked_out = null;
  var $checked_out_time = null; 

   function __construct(&$db)
  {
    parent::__construct( '#__properties_profiles', 'id', $db );
  }
  
 function check()
	{
		// check for http on webpage		
		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if(trim(str_replace('-','',$this->alias)) == '') {
			$datenow =& JFactory::getDate();
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		return true;
	}
}
?>