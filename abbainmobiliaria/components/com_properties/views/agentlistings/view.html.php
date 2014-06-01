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
class PropertiesViewAgentlistings extends JView
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
	$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/agentlistings.css" type="text/css" />');	
	
	$agentId = JRequest::getInt('aid');
	
	$agent = $this->getAgent($agentId);
	$this->assignRef('agent', $agent);
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
		
		$moduleBreadcrumbs = JModuleHelper::getModule( 'breadcrumbs' ); 
				
		if($moduleBreadcrumbs)
			{
			$app	= JFactory::getApplication();
			$pathway = $app->getPathway();
			unset($pathway->_pathway[count($pathway->_pathway)-1]);
				if($menuProperties = LinkHelper::getMenu('agents'))
				{
				if($menuProperties and !$menuProperties->home)
					{
					$new = JRoute::_('index.php?option=com_properties&view=agents&Itemid='.$menuProperties->id); 		
					$pathway->addItem($menuProperties->name, $new); 
					}
				}	
				$pathway->addItem($agent->name, '');			
			}			
			
		parent::display();		
	}
	
	function getAgent($id)
	{		
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT a.* '			
			. ' FROM #__properties_profiles as a '					
			. ' WHERE a.published = 1 AND a.id = '.$id			
			;		
        $db->setQuery($query);
		$Agent = $db->loadObject();
		return $Agent;
	}
	
	function getPropertyViewLink($row)
		{		
			$link = LinkHelper::getLinkProperty($row->id,$row->alias);
		return $link;
		}
		
}