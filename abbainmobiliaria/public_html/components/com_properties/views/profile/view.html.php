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
jimport( 'joomla.application.component.view' );

class PropertiesViewProfile extends JView
{	
	function display($tpl = null)
	{
	global $mainframe;
	$user =& JFactory::getUser();
	$task = JRequest::getVar('task');
	$layout = JRequest::getVar('layout');

	if (!$user->guest) 
		{
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/panel.css" type="text/css" />');	
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="administrator/templates/khepri/css/icon.css" type="text/css" />');
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/profile_form.css" type="text/css" />');
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$Profile		=& $this->get('Profile');
		$this->assignRef('datos',		$Profile);
		parent::display();
		}
	}
}