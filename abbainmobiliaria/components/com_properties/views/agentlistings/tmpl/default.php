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
		
		if($menu_params->get('show_page_title') & $menu_params->get('page_title'))
		{
			$title=$menu_params->get('page_title');		
		}elseif($menu_params->get('titlepage')){
			$title = $menu_params->get('titlepage');			
		}else{
			$title = $mainframe->getCfg( 'sitename' );
		}			
		
		if($menu_params->get('description')){
			$description = $menu_params->get('description');		
		}else{
			$description = $mainframe->getCfg( 'MetaDesc' );	
		}			
			
		if($menu_params->get('keywords')){
			$keywords = $menu_params->get('keywords');	
		}else{
			$keywords = $mainframe->getCfg( 'MetaKeys' );	
		}
			
			$document->setTitle( $title );
			$document->setDescription($description);
			$document->setMetadata('keywords',$keywords);

$component = JComponentHelper::getComponent( 'com_properties' );
$this->params = new JParameter( $component->params );
$ShowOrderBy=$this->params->get('ShowOrderBy');
$Listlayout=$this->params->get('Listlayout');
JHTML::_('behavior.modal');
	echo $this->loadTemplate('agentdata');	
require_once( JPATH_COMPONENT.DS.'views'.DS.'templates'.DS.$Listlayout.'_list'.'.php' );
?>