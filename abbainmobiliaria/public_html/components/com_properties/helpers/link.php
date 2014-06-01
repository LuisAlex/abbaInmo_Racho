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
class LinkHelper
{	
	function getItemid( $TableName,$cid=0 )
	{
		$db =& JFactory::getDBO();	
		if($TableName == 'category' & $cid !=0)
			{
			$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$TableName.'&cid='.$cid.'"';					
				$db->setQuery( $query );
				$output = $db->loadResult();
			}
		
		
		if($TableName == 'property')
			{
				$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$TableName.'&id=0"';					
				$db->setQuery( $query );
				$output = $db->loadResult();
				if(!$output)
					{
					$query = 'SELECT id FROM #__menu' .
					' WHERE link LIKE "%index.php?option=com_properties&view='.$TableName.'%"';			
					$db->setQuery( $query );
					$output = $db->loadResult();
					}					
					return $output;						
			}
		
		if($TableName == 'agentlistings')
			{		
			
				$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$TableName.'"';					
				$db->setQuery( $query );
				$output = $db->loadResult();				
				
				if(!$output)
					{					
					JError::raiseNotice(400, 'Menu to agentlistings not exists');
					return false;
					}				
				return $output;						
			}
			
		$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$TableName.'"';					
		$db->setQuery( $query );
		$output = $db->loadResult();
		
		if(!$output){
		$query = 'SELECT id FROM #__menu' .
				' WHERE link LIKE "%index.php?option=com_properties&view='.$TableName.'%"';			
		$db->setQuery( $query );
		$output = $db->loadResult();
		}		
		
		if(!$output){
		$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view=properties&cid=0&tid=0"';			
		$db->setQuery( $query );
		$output = $db->loadResult();
		}
		
		if(!$output){
		$query = 'SELECT id FROM #__menu' .
				' WHERE link LIKE "%index.php?option=com_properties&view=properties%"';			
		$db->setQuery( $query );
		$output = $db->loadResult();
		}
		
		return $output;
	}
	
	
	
	function getLink( $Pview,$Task=NULL,$Tmpl=NULL,$CYslug=NULL,$Sslug=NULL,$Lslug=NULL,$Cslug=NULL,$Tslug=NULL,$Pslug=NULL,$Aid=NULL )
	{
	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
		
	$l = 'index.php?option=com_properties&amp;view='.$Pview;
	if($Task)
		{
		$l.='&amp;task='.$Task;
		}
	if($Tmpl)
		{
		$l.='&amp;tmpl='.$Tmpl;
		}
	
	if($Cslug)
		{
		$CategoryName=explode(':',$Cslug);		
		$l.='&amp;cid='.$CategoryName[0].':'.JText::_($CategoryName[1]);
		}	
	if($Tslug)
		{
		$TypeName=explode(':',$Tslug);			
		$l.='&amp;tid='.$TypeName[0].':'.JText::_($TypeName[1]);
		}	
	if($Pslug)
		{
		$l.='&amp;id='.$Pslug;
		}
	if($Aid)
		{
		$l.='&amp;aid='.$Aid;
		}
	
			
	$l.='&amp;Itemid='.LinkHelper::getItemid($Pview);			
	
	$link = JRoute::_($l);
		
	return $link;
	}
	
	
	
	
	
	
	
	function getLinkProperty( $id,$alias,$Layout=NULL,$cid=NULL,$calias=NULL,$Task=NULL,$Tmpl=NULL )
	{
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$categoryInUrl=$params->get('categoryInUrl');
	$l='';
	$l.='&Itemid='.LinkHelper::getItemid('property');	
	
	if($params->get('linkToPropertyView'))
		{
		if($ItemId = LinkHelper::getItemid('property'))
			{
			$l = 'index.php?option=com_properties&view=property';
			}else{
			$ItemId = LinkHelper::getItemid('properties');
			$l = 'index.php?option=com_properties&view=properties';
			}
		}else{
			$ItemId = LinkHelper::getItemid('properties');
			$l = 'index.php?option=com_properties&view=properties';
		}
			
	
	if($Task)
		{
		$l.='&task='.$Task;
		}
	if($Tmpl)
		{
		$l.='&tmpl='.$Tmpl;
		}
	if($Layout)
		{
		$l.='&layout='.$Layout;	
				
		}elseif($categoryInUrl){
		
			if($cid)
				{
				$catAlias = explode(':',$cid);
				if($config->sef)
					{						
						$categoryAlias = LinkHelper::getCategoryAlias($catAlias[0]);
					
						$l.='&cid='.$categoryAlias;
					}else{
						$l.='&cid='.$catAlias[0];	
					}
				}else{
					$menu =& JSite::getMenu();
					$menuitem =& $menu->getActive();
				if($config->sef)
					{
						$l.='&cid='.$menuitem->alias;	
					}else{
						$l.='&cid='.$menuitem->query['cid'];	
					}
				}
				
		}
	
	
	if($config->sef)
		{
		$l.='&id='.$alias;
		}else{
		$l.='&id='.$id;
		}			
			
	$l.='&Itemid='.$ItemId;			
	//echo $l;
	
	$link = JRoute::_($l);
		
	return $link;
	}
	
	
	
	
	
	
	function getLinkPropertyMenu( $id,$alias,$Layout=NULL,$cid=NULL,$calias=NULL,$Task=NULL,$Tmpl=NULL )
	{
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
		
	$menu =& JSite::getMenu();
					$menuitem =& $menu->getActive();
					/*
					echo '<pre>';
					print_r($menuitem);
					echo '</pre>';
					*/
						
		$l='';							
		if($config->sef)
		{
		$l.='&id='.$alias;
		}else{
		$l=$menuitem->link;		
		$l.='&id='.$id;
		}	
		$l.='&Itemid='.$menuitem->id;	
					
	$link = JRoute::_($l);
		
	return $link;
	}
	
	function getModuleLinkProperty( $id,$alias,$cid=NULL,$calias=NULL,$tid=NULL,$talias=NULL )
	{
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$l = 'index.php?option=com_properties&view=property';
	if($config->sef)
		{
		$l.='&id='.$alias;
		}else{
		$l.='&id='.$id;
		}			
			
	$l.='&Itemid='.LinkHelper::getItemid('property');			
	
	$link = JRoute::_($l);
		
	return $link;
	}
	
	function getLocationLinkProperty( $row )
	{
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$alias = $row->alias;
	$id = $row->id;
	$CYslug = explode(':',$row->CYslug);
	$Sslug = explode(':',$row->Sslug);
	$Lslug = explode(':',$row->Lslug);
	
	$cyid = $CYslug[1];
	$sid = $Sslug[1];
	$lid = $Lslug[1];	

	$l = 'index.php?option=com_properties&view=location';
	if($config->sef)
		{
		$l.='&cyid='.$CYslug[1];
		$l.='&sid='.$Sslug[1];
		$l.='&lid='.$Lslug[1];
		$l.='&id='.$alias;		
		}else{
		$l.='&cyid='.$CYslug[0];
		$l.='&sid='.$Sslug[0];
		$l.='&lid='.$Lslug[0];
		$l.='&id='.$id;				
		}
		
		//$l.='&task=showproperty';
			
	$l.='&Itemid='.LinkHelper::getItemid('location');			
	
	$link = JRoute::_($l);
		
	return $link;
	}
	
	function getMenu( $view,$id=0 )
	{
		$db =& JFactory::getDBO();
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');

		if($view == 'category' & $id != 0)
			{			
			$query = 'SELECT * FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$view.'&cid='.$id.'"';					
				$db->setQuery( $query );
				$output = $db->loadObject();
				$output->newlink=$output->link.'&Itemid='.$output->id;			
				return $output;	
			}		
		
		if($view == 'category')
			{		
			
			$config	= new JConfig();
			if($config->sef)
				{
					$cid = JRequest::getVar('cid');						
					$calias = str_replace(':', '-',JRequest::getVar('cid'));										
					$categoryId = LinkHelper::getCategoryId($calias);
													
				}else{
					$categoryId = JRequest::getInt('cid');		
				}		
						
				$query = 'SELECT * FROM #__menu '
					.'WHERE link = "index.php?option=com_properties&view='.$view.'&cid='.$categoryId.'"';	
				$db->setQuery( $query );
				$output = $db->loadObject();
				if($config->sef)
					{					
					$output->newlink='index.php?Itemid='.$output->id;
					}else{
					$output->newlink=$output->link.'&Itemid='.$output->id;
					}		
				return $output;	
			}
			
		$query = 'SELECT * FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$view.'"';					
		$db->setQuery( $query );
		$output = $db->loadObject();
		
		if(!$output){
		$query = 'SELECT * FROM #__menu' .
				' WHERE link LIKE "%index.php?option=com_properties&view='.$view.'%"';			
		$db->setQuery( $query );
		$output = $db->loadObject();
		}	
		return $output;	
	}
	
	
	function getCategoryId($alias)
		{
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');
		
		$db = JFactory::getDBO();
		if($useTranslations)
			{
			$query = 'SELECT c.* FROM #__properties_category as c '.		
			' LEFT JOIN #__properties_translations AS t ON t_fieldid = c.id '.		
			' WHERE alias = '.$db->Quote($alias)		
			.' OR t_alias = '.$db->Quote($alias)		
			;
			}else{
			$query = 'SELECT c.* FROM #__properties_category as c '				
			.' WHERE alias = '.$db->Quote($alias)		
			;
			}
			$db->setQuery($query);
			$category = $db->loadObject();					
		return $category->id;
		}
		
		
	function getCategoryAlias($id)
		{
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();	
		$db = JFactory::getDBO();
		if($useTranslations)
			{
			$query = 'SELECT c.alias,t.t_alias FROM #__properties_category as c '.		
			' LEFT JOIN #__properties_translations AS t ON t_fieldid = c.id '.
			' AND t.t_languagecode = \''.$thisLang.'\''.
			' WHERE c.id = '.(int) $id
			
			;
			}else{
			$query = 'SELECT c.* FROM #__properties_category as c '				
			.' WHERE id = '.(int) $id	
			;
			}
			$db->setQuery($query);
			$category = $db->loadObject();			

		if($category->t_alias)
			{
			return $category->t_alias;
			}else{
			return $category->alias;
			}		
		}
		
		
		
}