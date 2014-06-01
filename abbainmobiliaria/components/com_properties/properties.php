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
$lang =& JFactory::getLanguage();

jimport('joomla.application.component.helper');
/*
	$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/index.css" type="text/css" />');
	$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/'.$lang->getTag().'-index.css" type="text/css" />');
*/

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'link.php' );
require_once (JPATH_COMPONENT.DS.'controller.php');


if($controller = JRequest::getWord('controller')) {
$path = (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}	
}

$classname	= 'PropertiesController'.$controller;
$controller = new $classname( );
$controller->execute( JRequest::getVar('task'));
$controller->redirect();
?>