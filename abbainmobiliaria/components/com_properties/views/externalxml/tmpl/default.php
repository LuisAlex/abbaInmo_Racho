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
global $mainframe;
JHTML::_('behavior.tooltip');
jimport('joomla.filesystem.file');
$document =& JFactory::getDocument();

$user =& JFactory::getUser();
$menus = &JSite::getMenu();
		$menu  = $menus->getActive();
		$menu_params = new JParameter( $menu->params );
		if($menu_params->get('show_page_title') & $menu_params->get('page_title')){
		$title=$menu_params->get('page_title');
		$Mkey.=' '.$title;
		}else{
		$title 		= $mainframe->getCfg( 'sitename' );	
		$Mkey.=' '.$title;
		}

$component = JComponentHelper::getComponent( 'com_properties' );
$this->params = new JParameter( $component->params );
$ShowTextSearch=$this->params->get('ShowTextSearch');
$ShowOrderBy=$this->params->get('ShowOrderBy');
$Listlayout=$this->params->get('Listlayout');

$document->setTitle( $title );
$document->setMetadata('keywords',$Mkey);
$document->setDescription($title);

JHTML::_('behavior.modal');

	//echo $this->loadTemplate('list'.$Listlayout);	
require_once( JPATH_COMPONENT.DS.'views'.DS.'templates'.DS.$Listlayout.'_list'.'.php' );
?>