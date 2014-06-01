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
class AgentDataHelper
{	
	function getAgent($mid)
	{		
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT a.* '			
			. ' FROM #__properties_profiles as a '					
			. ' WHERE a.published = 1 AND a.mid = '.$mid			
			;		
        $db->setQuery($query);
		$Agent = $db->loadObject();
		return $Agent;
	}	
}