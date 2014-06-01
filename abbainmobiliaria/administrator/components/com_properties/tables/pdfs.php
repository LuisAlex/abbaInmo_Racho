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
defined( '_JEXEC' ) or die( 'Restricted access' );
class Tablepdfs extends JTable
{    
	var $id = null;
	var $name = null;
	var $alias = null;	
	var $parent = null;
	var $published = null;
	var $ordering = null;
	var $text = null;
	var $date = null;
	var $archivo = null;
	var $archivo_path = null;
	var $archivo_rout = null;


   function __construct(&$db)
  {
    parent::__construct( '#__properties_pdfs', 'id', $db );
  }
  
  function check()
	{		
		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		if(trim(str_replace('-','',$this->alias)) == '') {
			$datenow =& JFactory::getDate();
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		if(empty($this->date)) {
		
			$datenow =& JFactory::getDate();
			$this->date = $datenow->toFormat("%Y-%m-%d");
		}
		return true;
	}
}
?>