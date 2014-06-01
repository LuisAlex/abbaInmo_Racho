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
require_once( JPATH_COMPONENT.DS.'admin.controller.php' );
//require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
	$option = JRequest::getVar('option');	
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/'.$option.'/includes/css/index.css');
if(!JRequest::getVar('view')){JRequest::setVar('view','panel');}
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}
$classname	= 'PropertiesController'.$controller;
$controller	= new $classname( );
$controller->execute( JRequest::getVar( 'task' ) );
$controller->redirect();
?>