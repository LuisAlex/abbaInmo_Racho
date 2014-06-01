<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.'); 
class Modprop_search_verticalHelper
{	
	function getItemid()
	{
	$db = &JFactory::getDBO();
	$query = 'SELECT id FROM #__menu' .
				' WHERE LOWER( link ) = "index.php?option=com_properties&view=properties"';				
		$db->setQuery( $query );
		$row = $db->loadResult();
		return $row;		
	}	
}