<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );

class PropertiesModelProfile extends JModel
{

	function __construct()
  	{
 	parent::__construct();
	global $mainframe, $option;
 	 }
	function getProfile() 
  	{     
  	$user =& JFactory::getUser();
 	 $queryP = ' SELECT * FROM #__properties_profiles '.
					'  WHERE mid = '.$user->id;
	$this->_db->setQuery( $queryP );
	$this->_data = $this->_db->loadObject();
	return $this->_data;					
  	}
	
	function store($data)
	{	
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');
	$row =& JTable::getInstance('profiles', 'Table');

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
		$query = ' SELECT id FROM #__properties_profiles ORDER BY id desc LIMIT 1';
		$this->_db->setQuery( $query );	
		$_data = $this->_db->loadResult();
		return $_data;
		}
					
}//fin clase