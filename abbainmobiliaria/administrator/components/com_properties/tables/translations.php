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

class Tabletranslations extends JTable
{    
	var $t_id = null;
	var $t_languageid = null;
	var $t_languagecode = null;
	var $t_table = null;
	var $t_field = null;
	var $t_fieldid = null;
	var $t_value = null;
	var $t_alias = null;
	var $published = null;
	  
   function __construct(&$db)
  {
    parent::__construct( '#__properties_translations', 't_id', $db );
  }
  function check()
	{		
		if(empty($this->t_alias)) {
			$this->t_alias = $this->t_value;
		}
		$this->t_alias = JFilterOutput::stringURLSafe($this->t_alias);
		$datenow =& JFactory::getDate();
		
		if(trim(str_replace('-','',$this->t_alias)) == '') {			
			$this->t_alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		/*
		$query = 'SELECT alias FROM #__properties_products'
				.' WHERE alias = ' . $this->_db->Quote( $this->alias ) 
				.' AND id <>' . intval( $this->id );
        	$this->_db->setQuery( $query );
			$aliasrow = $this->_db->loadResult();	
			print_r($aliasrow);
			
        		if ( $aliasrow )
				{
				
				$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
				$this->setError(JText::_('Property alias already exists, is replaced to : '.$this->alias));
				JError::raiseNotice(400, 'Property alias already exists [ '.$aliasrow.' ], is replaced to : '.$this->alias );
				}		
		*/
				
		return true;
	}
		

			
	function getMeta()
		{
		$db 	=& JFactory::getDBO();	
		$query = 	"SELECT c.name as category,t.name as type,l.name as locality "
				. " from #__properties_category as c "
				. " LEFT JOIN #__properties_type as t ON t.id = ".$this->type
				. " LEFT JOIN #__properties_locality as l ON l.id = ".$this->lid
				. " WHERE c.id = ".$this->cid;			
		$db->setQuery( $query );					
		$row = $db->loadObject();		
		return $this->name.', '.$row->type.', '.$row->category.', '.$this->postcode.', '.$this->address.', '.$row->locality;
		}

}
?>