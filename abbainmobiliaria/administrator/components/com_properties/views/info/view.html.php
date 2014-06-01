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

jimport( 'joomla.application.component.view' );
class PropertiesViewInfo extends JView
{	
	function display($tpl = null)
	{	
	global $mainframe;
	JToolBarHelper::title(JText::_('Info'), 'info.png');	

jimport('joomla.html.pane');
$pane	=& JPane::getInstance('sliders');	



$Totalproducts		= $this->getTotalproducts();
$Categories = $this->getCategories();
$Types = $this->getTypes();

foreach($Categories as $c)
	{
	$Category[$c->id]['name']=$c->name;
	$Category[$c->id]['products']=$this->getTotalproducts($c->id);
	}
	
foreach($Types as $t)
	{
	$Type[$t->id]['name']=$t->name;
	$Type[$t->id]['products']=$this->getTotalproducts('',$t->id);
	}	
	

	

/*
$categories		= $this->get( 'Totalcategories' );
$types			= $this->get( 'Totaltypes' );
$agents			= $this->get( 'Totalagents' );
$publisher		= $this->get( 'Totalpublisher' );
$registered		= $this->get( 'Totalregistered' );
$morevisited	= $this->get( 'Morevisited' );
*/
$this->assignRef( 'Totalproducts'		, $Totalproducts );
$this->assignRef( 'Category'		, $Category );
$this->assignRef( 'Type'		, $Type );

		$this->assignRef( 'pane'		, $pane );		
		
		parent::display($tpl);
	}	
	
	function getTotalproducts($cid=null,$type=null)
		{
		global $mainframe, $option;
		$where = array();		
		if($cid)
			{
			$where[] = ' cid = '.$cid;
			}
		if($type)
			{
			$where[] = ' cid = '.$type;
			}
			
		$where = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );		
		
		$db 	=& JFactory::getDBO();	
		$query = 	"SELECT COUNT(id) from #__properties_products ".$where;			
		$db->setQuery( $query );				
		$products = $db->loadResult();
		return $products;
		}		
		
	function getCategories()
		{
		global $mainframe, $option;			
		$db 	=& JFactory::getDBO();	
		$query = 	"SELECT * from #__properties_category";			
		$db->setQuery( $query );				
		$categories = $db->loadObjectList();
		return $categories;
		}		
	function getTypes()
		{
		global $mainframe, $option;			
		$db 	=& JFactory::getDBO();	
		$query = 	"SELECT * from #__properties_type ";			
		$db->setQuery( $query );				
		$Types = $db->loadObjectList();
		return $Types;
		}		
}