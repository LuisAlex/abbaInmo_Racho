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

jimport( 'joomla.application.component.model' );

class PropertiesModelContacts extends JModel
{
	function __construct()
		{
		parent::__construct();	
		}
	
	

	function store($data,$TableName)
		{	
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');
		$row =& JTable::getInstance($TableName, 'Table');
		if (!$row->bind($data)) {
			 $this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		if (!$row->check()) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );	
			return false;
		}
		return true;
	}
	
  function getLastModif()
	{
	 $query = ' SELECT id FROM #__properties_contacts ORDER BY id desc LIMIT 1';
	 	$db 	=& JFactory::getDBO();
		$db->setQuery( $query );		
		$data = $db->loadResult();
	 return $data;		
	}
}