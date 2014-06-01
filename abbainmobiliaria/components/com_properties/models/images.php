<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class PropertiesModelImages extends JModel
{

	function __construct()
	{
		parent::__construct();
	}


	function store($data)
	{	
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');
		$row =& JTable::getInstance('images', 'Table');
		
		$db		 =& JFactory::getDBO();
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->id) {
		$where = "parent = " . $db->Quote($row->parent);
		$row->ordering = $row->getNextOrder( $where );
		}
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}			
		
}//fin clase