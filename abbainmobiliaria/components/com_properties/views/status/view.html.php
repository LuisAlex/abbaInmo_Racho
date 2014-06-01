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
require_once(JPATH_COMPONENT.DS.'models'.DS.'propertydetails.php');
class PropertiesViewStatus extends JView
{	
	function display($tpl = null)
	{	
	global $mainframe;
	JHTML::_('behavior.mootools');
	JHTML::_('behavior.modal');
	$this->lang =& JFactory::getLanguage();	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );	
	$this->params=$params;
	$useTranslations=$params->get('useTranslations','0');	
	
	$productId = JRequest::getVar('id');
	if($productId)
		{		
		$this->showProduct($params);
		}else{
		
		$menus = &JSite::getMenu();
		$menu  = $menus->getActive();
		$status = $menu->query['status'];
		
		$this->limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		$this->limit = $this->params->get('cantidad_productos',5);		
		
		$items		=& $this->get( 'Data');		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);
		
		require_once( JPATH_COMPONENT.DS.'helpers'.DS.'listing.php' );
		if($useTranslations)
			{
			require_once( JPATH_COMPONENT.DS.'helpers'.DS.'translation.php' );
			$items = ListingHelper::getItemsTranslated($items,$params);	
			}else{
			ListingHelper::getItemsImages($items,$params);		
			}		
		$this->assignRef('items',		$items);	
		ListingHelper::loadHeader($params);
		parent::display();
		}			
		
	}
		
	
	function showProduct($params)
		{
		global $mainframe;
		$useTranslations=$params->get('useTranslations','0');	
		require_once( JPATH_COMPONENT.DS.'helpers'.DS.'detail.php' );
		$productId = JRequest::getVar('id');
		$Product	=	DetailHelper::getProduct($params);		
		DetailHelper::loadHeader($params);			
		if($useTranslations)
			{
			require_once( JPATH_COMPONENT.DS.'helpers'.DS.'translation.php' );
			$Product = DetailHelper::getItemTranslated($Product,$params);	
			}			
		$this->ImagesProduct = DetailHelper::getImages($Product->id,'100');		
		$this->MyAgent=& DetailHelper::getMyAgent($Product->agent_id); 
		DetailHelper::setMeta($Product);
		$this->Product	=	$Product;	
		
		$moduleBreadcrumbs = JModuleHelper::getModule( 'breadcrumbs' ); 		
		if($moduleBreadcrumbs)
			{
			$app	= JFactory::getApplication();
			$pathway = $app->getPathway();	
			$pathway->addItem($Product->name, '');
			}
		$this->addTemplatePath( JPATH_COMPONENT . DS . 'views' . DS . 'property' . DS . 'tmpl' );  
  		echo $this->loadTemplate();		
		}
	function getPropertyViewLink($row)
		{
		if($this->params->get('linkToPropertyView'))
			{
				$link = LinkHelper::getLinkProperty($row->id,$row->alias);
			}else{
				$link = LinkHelper::getLinkPropertyMenu($row->id,$row->alias);
			}

		return $link;
		}
	function getOpenHouse($id)
		{
		$propertyDetailsModel=new PropertiesModelPropertydetails;	
		$OpenHouse = $propertyDetailsModel->getOpenHouse($id);
		return $OpenHouse;
		}		
}