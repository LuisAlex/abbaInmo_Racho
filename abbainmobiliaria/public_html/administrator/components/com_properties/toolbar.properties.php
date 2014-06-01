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
$option = JRequest::getVar('option');
$view	= JRequest::getCmd('view','properties');
$task = JRequest::getVar('task');
JHTML::_('behavior.switcher');
// Load submenu's
$views	= array(
					'configuration'			=> JText::_('Configuration'),	
					'categories'			=> JText::_('Categories'),
					'types' 			=> JText::_('Types'),				
					'products' 			=> JText::_('Products'),
					'profiles'		=> JText::_('Profiles'),
					'bookings'		=> JText::_('Bookings'),
					'panel'			=> JText::_('Panel de Control')
				);	
foreach( $views as $key => $val )
{
	$active	= ( $view == $key );
JSubMenuHelper::addEntry('<img src="components/'.$option.'/includes/img/t_'.$key.'.png" style="margin-right: 5px;" align="absmiddle" />'.$val, 'index.php?option='.$option.'&view=' . $key , $active);
}