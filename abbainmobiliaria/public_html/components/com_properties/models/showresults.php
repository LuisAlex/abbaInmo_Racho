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

class PropertiesModelShowresults extends JModel
{
	function __construct()
		{
		parent::__construct();	
		}
	
	

	function store($data)
		{	
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');
		$row =& JTable::getInstance('showresults', 'Table');
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

}