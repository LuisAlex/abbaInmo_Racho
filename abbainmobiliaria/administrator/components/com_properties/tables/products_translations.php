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

class Tableproducts_translations extends JTable
{    
	var $pt_id = null;
	var $pt_pid = null;
	var $pt_langid = null;
	var $pt_langcode = null;
	var $pt_name = null;
	var $pt_alias = null;
	var $pt_address = null;
	var $pt_description = null;
	var $pt_text = null;
	var $pt_currency = null;
	var $pt_published = null;
	var $pt_metatitle = null;
	var $pt_metadesc = null;
	var $pt_metakey = null;
	  
   function __construct(&$db)
  {
    parent::__construct( '#__properties_products_translations', 'pt_id', $db );
  }
  
  
  function check()
	{		
	$datenow =& JFactory::getDate();
		if(empty($this->pt_alias)) {
			$this->pt_alias = $this->pt_name;
		}
		$this->pt_alias = JFilterOutput::stringURLSafe($this->pt_alias);
		if(trim(str_replace('-','',$this->pt_alias)) == '') {
			
			$this->pt_alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		
				
		
		$query = 'SELECT pt_alias FROM #__properties_products_translations '
				.' WHERE pt_alias = ' . $this->_db->Quote( $this->pt_alias ) 
				.' AND pt_pid <>' . intval( $this->pt_pid );
        	$this->_db->setQuery( $query );
			$aliasrow = $this->_db->loadResult();	
			print_r($aliasrow);
			
        		if ( $aliasrow )
				{
				
				$this->pt_alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
				$this->setError(JText::_('Property alias already exists, is replaced to : '.$this->pt_alias));
				JError::raiseNotice(400, 'Property alias already exists [ '.$aliasrow.' ], is replaced to : '.$this->pt_alias );
				}	
				
				
				
				
				
				
				
		return true;
	}
	
	
}
?>


