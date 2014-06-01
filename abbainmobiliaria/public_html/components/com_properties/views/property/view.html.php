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
class PropertiesViewProperty extends JView
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
		}
	
	}
	
	
	function showProduct($params)
		{
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'models'.DS.'propertydetails.php');
		$propertyDetailsModel=new PropertiesModelPropertydetails;

		$useTranslations=$params->get('useTranslations','0');	
		require_once( JPATH_COMPONENT.DS.'helpers'.DS.'detail.php' );
		$productId = JRequest::getVar('id');
		$Product	=	$propertyDetailsModel->getProduct($params);	
	if(!$Product->id){JError::raiseError(404, 'Property not exixts' );}
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');
		$results = $dispatcher->trigger('onPrepareContent', array (& $Product, & $item->params, 0));			
			
		if($useTranslations)
			{
			require_once( JPATH_COMPONENT.DS.'helpers'.DS.'translation.php' );
			$Product = $propertyDetailsModel->getItemTranslated($Product,$params);	
			}	
					
		DetailHelper::loadHeader($params);	
		$propertyDetailsModel->setMeta($Product);	


		$this->ImagesProduct =  $propertyDetailsModel->getImages($Product->id,'100');		
		$this->MyAgent = $propertyDetailsModel->getMyAgent($Product->agent_id); 				
		$this->Rates = $propertyDetailsModel->getRates($Product->id);
		$this->Pdfs = $propertyDetailsModel->getPdfs($Product->id);
		$this->OpenHouse = $propertyDetailsModel->getOpenHouse($Product->id);

		$this->Product	=	$Product;	
		$moduleBreadcrumbs = JModuleHelper::getModule( 'breadcrumbs' ); 		
		if($moduleBreadcrumbs)
			{
			$app	= JFactory::getApplication();
			$pathway = $app->getPathway();
			$menu =& JSite::getMenu();
			$menuitem =& $menu->getActive();
			if(($menuitem->query['id']) == 0)
				{				
				unset($pathway->_pathway[count($pathway->_pathway)-1]);
				if($menuProperties = LinkHelper::getMenu('properties'))
				{
				if($menuProperties and !$menuProperties->home)
					{
					$new = JRoute::_('index.php?option=com_properties&view=properties&Itemid='.$menuProperties->id); 		
					$pathway->addItem($menuProperties->name, $new); 
					}
				}	
				$pathway->addItem($Product->name, '');	
				}
			
	}	
			
			
			
		$this->addTemplatePath( JPATH_COMPONENT . DS . 'views' . DS . 'property' . DS . 'tmpl' );  
  		echo $this->loadTemplate();		
		}
	
		function getOpenHouse($id)
		{
		$propertyDetailsModel=new PropertiesModelPropertydetails;	
		$OpenHouse = $propertyDetailsModel->getOpenHouse($id);
		return $OpenHouse;
		}
	
	
	
	
}