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

class SelectHelper
{
	function ParentCategory( &$row,$TableName )
	{
		$db =& JFactory::getDBO();				
		if (!$row->parent) {
			$row->parent = 0;
		}		
		$query = 'SELECT * ' .
				' FROM #__properties_category as c' .				
				' WHERE published != -2' .				
				' ORDER BY parent, ordering';
		$db->setQuery( $query );
		$categories = $db->loadObjectList();				
		$mitems 	= array();		
		$mitems[] = JHTML::_('select.option',  0, 'All Categories' );
		foreach ( $categories as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;'. $item->name );
		}
		$output = JHTML::_('select.genericlist',   $mitems, 'parent', 'class="inputbox select select" size="1"', 'value', 'text', $row->parent );
		return $output;
	}
	
	function Select( &$row,$TableName,$params=NULL )
	{
	global $mainframe,$option;
		$db =& JFactory::getDBO();		
		if (!$row->parent) {
			if($params)
				{
					if($TableName=='country')
					{
					$row->parent = $params->get('UseCountryDefault');					
					$filter_country	= $mainframe->getUserStateFromRequest( "$option.filter_country",'filter_country','','int' );				
					if($filter_country)
						{
						$row->parent = $filter_country;
						}						
					}
					if($TableName=='state')
					{
					$row->parent = $params->get('UseStateDefault');
					$filter_sid	= $mainframe->getUserStateFromRequest( "$option.filter_sid",'filter_sid','','int' );			
					if($filter_sid)
						{
						$row->parent = $filter_sid;
						}						
					}
				}				
		}		
		$query = 'SELECT * ' .
				' FROM #__properties_'.$TableName.' ' .
				' WHERE published = 1' .
				
				' ORDER BY name';
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		$mitems 	= array();
		
		$mitems[] = JHTML::_('select.option',  0, 'Not use '.$TableName );		

		foreach ( $items as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;'. $item->name );
		}
		$output = JHTML::_('select.genericlist',   $mitems, 'parent', 'class="inputbox select" size="1"', 'value', 'text', $row->parent );		
		return $output;
	}
	
		function ParentCategoryType( &$row,$TableName,$call )
	{
	
		$db =& JFactory::getDBO();		
		if ( $row->id ) {
			if($call=='category'){$id = ' AND id != '.(int) $row->id;}else{$id = null;}
		} else {
			$id = null;
		}
		if (!$row->cid) {
			$row->cid = 0;
		}
		$query = 'SELECT * ' .
				' FROM #__properties_'.$TableName.' ' .				
				' WHERE published != -2' .
				$id .
				' ORDER BY parent, ordering';
		$db->setQuery( $query );
		$items = $db->loadObjectList();
				
		$mitems 	= array();
		$mitems[] 	= JHTML::_('select.option',  '', JText::_( 'Top' ) );

		foreach ( $items as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;'. $item->name );
		}
		
$javascript = 'onChange="ChangeType(this.value)"';

		$output = JHTML::_('select.genericlist',   $mitems, 'cid', 'class="inputbox select required" size="1"'.$javascript, 'value', 'text', $row->cid );	
		
		return $output;
	}
	
	
	function SelectType( &$row,$TableName,$soy_id )
	{
		$db =& JFactory::getDBO();			
		$query = 'SELECT * ' .
				' FROM #__properties_'.$TableName.' ' .
				//' WHERE menutype = '.$db->Quote($row->menutype) .
				' WHERE published = 1 AND parent = 0 OR parent = ' . $row->parent .		
				' ORDER BY name';				
		$db->setQuery( $query );
		$items = $db->loadObjectList();		
		$mitems 	= array();
		$mitems[0]->id=0;
		$mitems[0]->name=JText::_( 'Type' );
		foreach ( $items as $item ) {
			$mitems[] = $item;
		}
		$javascript = '';
		$output = JHTML::_('select.genericlist',   $mitems, 'type', 'class="inputbox select" size="1"', 'id', 'name', $row->type);
		
		return $output;
	}	
	
	
		function MultiParent( &$row,$TableName )
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT * ' .
				' FROM #__properties_'.$TableName.' as c' .				
				' WHERE published = 1' .				
				' ORDER BY name';
		$db->setQuery( $query );
		$list = $db->loadObjectList();

		
	
			$query = 'SELECT categoryid AS value'
			. ' FROM #__properties_product_category'
			. ' WHERE productid = '.(int) $row->id
			;
			$db->setQuery( $query );
			$lookup = $db->loadObjectList();
			
		$mitems 	= array();
		$mitems[] 	= JHTML::_('select.option',  '0', JText::_( 'Varies Categories' ) );

		foreach ( $list as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;'. $item->name );
		}
	
	$output	= JHTML::_('select.genericlist',   $mitems, 'selections[]', 'class="inputbox" size="7" multiple="multiple"', 'value', 'text', $lookup, 'selections' );	
		//print_r($mitems);
		return $output;
	}
	
	
	
	
		function SelectAjaxPaises( &$row,$TableName,$soy_id )
	{
		$db =& JFactory::getDBO();		
		if ( $row->id ) {
			//$id = ' AND id != '.(int) $row->id;
		} else {
			$id = null;
		}
		// In case the parent was null
		
		$query = 'SELECT * ' .
				' FROM #__properties_'.$TableName.' ' .
				//' WHERE menutype = '.$db->Quote($row->menutype) .
				' WHERE published != -2' .
				//$id .
				' ORDER BY name';
				
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		
		$mitems 	= array();
		
/*
$mitems[0]->id=0;
$mitems[0]->name=JText::_( 'Not use Country' );
*/
		foreach ( $items as $item ) {
			$mitems[] = $item;
		}
$javascript = 'onChange="ChangeState(this.value)"';
		$output = JHTML::_('select.genericlist',   $mitems, 'cyid', 'class="inputbox select" size="1"'.$javascript, 'id', 'name', $row->cyid);

		//print_r($mitems);
		
		return $output;
	}

function SelectAjaxStates(&$row,$TableName,$soy_id) {
global $mainframe;
$datos = null;

$db 	=& JFactory::getDBO();
$Country_id = $row->cyid;

$Country_id = $row->cyid ? $row->cyid : 0;

$query = 	"SELECT * from #__properties_state where published = 1 and parent = ".$Country_id." ORDER BY name ASC";

$db->setQuery( $query );				
$States = $db->loadObjectList();

$nP = count($States);
/*
$mitems[0]->id=0;
$mitems[0]->name='Not use State';
*/
$mitems = array();
if($States){
		foreach ( $States as $item ) {
			$mitems[] = $item;
		}
		}
$javascript = 'onChange="ChangeLocality(this.value)"';
$ComboStates        = JHTML::_('select.genericlist',   $mitems, 'sid', 'class="inputbox select" size="1" '.$javascript,'id', 'name',  $row->sid); 
return $ComboStates;

}



function SelectAjaxLocalities(&$row,$TableName,$soy_id) {
global $mainframe;
$datos = null;

$db 	=& JFactory::getDBO();
$State_id = $row->sid;

$State_id = $row->sid ? $row->sid : 0;

$query = 	"SELECT * from #__properties_locality where published = 1 and parent = ".$State_id." ORDER BY name ASC";
//if($State_id){
$db->setQuery( $query );				
$Localities = $db->loadObjectList();
//}

$nP = count($Localities);
/*
$mitems[0]->id=0;
$mitems[0]->name='Not use Localities';
*/
$mitems = array();
if($Localities){
		foreach ( $Localities as $item ) {
			$mitems[] = $item;
		}
		}
$javascript = '';
$ComboLocalities        = JHTML::_('select.genericlist',   $mitems, 'lid', 'class="inputbox select" size="1" '.$javascript,'id', 'name',  $row->lid); 
return $ComboLocalities;

}
	
	
	
	
	
	function SelectCliente( &$row,$TableName )
	{
		$db =& JFactory::getDBO();
		
		//$queryP = ' SELECT mid FROM #__properties_profiles '.
		$query = 'SELECT * ' .
				' FROM #__users' .				
				//' WHERE gid = 100' .						
				' ORDER BY username';	
					
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		$javascript = 'onChange="CambiarCliente(this.value)"';
		$output = JHTML::_('select.genericlist',   $items, 'mid', 'class="inputbox" size="1" '.$javascript, 'id', 'username', $row->mid );
		//print_r($mitems);
		return $output;
	}
	
	
	function SelectJoomlaUser( &$row )
	{
		$db =& JFactory::getDBO();				
				$query = 'SELECT u.*,p.mid' .
				' FROM #__users as u' .	
				' LEFT OUTER JOIN #__properties_profiles as p ON u.id = p.mid'.			
				' WHERE p.id IS null ';
				if($row->mid){$query .=' OR u.id = ' .	$row->mid; }			
				$query .= ' ORDER BY username';	
				//echo str_replace('#_','jos',$query);		
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		
		$javascript = '';
		$output = JHTML::_('select.genericlist',   $items, 'mid', 'class="inputbox" size="1" '.$javascript, 'id', 'username', $row->mid );
		//print_r($items);
		return $output;
	}
	
	
	
	function SelectAgent( $agent_id )
	{
		$db =& JFactory::getDBO();
		
		$query = 'SELECT * FROM #__users WHERE gid > 18 ORDER BY username';	
		
		$query = 'SELECT * FROM #__properties_profiles ' .				
				/*' WHERE gid > 18' .*/						
				' ORDER BY name';
							
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		$javascript = 'onChange="ChangeAgent(this.value)"';
		$output = JHTML::_('select.genericlist',   $items, 'agent_id', 'class="inputbox select" size="1" '.$javascript, 'mid', 'name', $agent_id );
		//print_r($mitems);
		return $output;
	}
	
	
	function SelectCurrency( $currency_id,$field )
		{
		$db =& JFactory::getDBO();		
		$query = 'SELECT * ' .
				' FROM #__properties_currencies ' .
				' WHERE published = 1'.
				' ORDER BY currency ASC';				
		$db->setQuery( $query );
		$items = $db->loadObjectList();		
		$mitems 	= array();
		$mitems[0]->id=0;
		$mitems[0]->currency=JText::_( 'Moneda' );
		foreach ( $items as $item ) 
			{
			$mitems[] = $item;
			}
		$output = JHTML::_('select.genericlist',   $mitems, $field, 'class="inputbox select" size="1"', 'id', 'currency', $currency_id);
		
		return $output;
		}
	
	
}