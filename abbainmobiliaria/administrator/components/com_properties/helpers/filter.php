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

class Filter
{	
	function FilterCountry( &$row,$TableName,$call )
	{	
		global $mainframe,$option;
		$filter_country		= $mainframe->getUserStateFromRequest( "$option.filter_country",'filter_country','','int' );
		$db =& JFactory::getDBO();
		$query = 'SELECT * ' .
				' FROM #__properties_country ' .				
				' WHERE published = 1' .				
				' ORDER BY name';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();		
		$items 	= array();
		$items[] 	= JHTML::_('select.option',  '0', JText::_( 'All Countries' ) );
		if ( $mitems )
		{			
			foreach ( $mitems as $item )
			{
				$name=str_replace("'","&#039;",$item->name);
				$items[] = JHTML::_('select.option',  $item->id, '&nbsp;'. $name );
			}
		}			
		
$javascript='onchange="this.form.getElementById(\'filter_sid\').value=\'0\';this.form.getElementById(\'filter_locality\').value=\'0\';submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_country', 'class="" size="1" '.$javascript, 'value', 'text', $filter_country );	
		
		return $output;
	}
	
	function FilterSid( &$row,$TableName,$call )
	{	
		global $mainframe,$option;
		$filter_country		= $mainframe->getUserStateFromRequest( "$option.filter_country",		'filter_country',		'',		'int' );
		$filter_sid		= $mainframe->getUserStateFromRequest( "$option.filter_sid",		'filter_sid',		'',		'int' );
		$db =& JFactory::getDBO();		
		
		if($filter_country>0){$CountrySql=' AND parent = ' .$filter_country;}else{$CountrySql='';}
		
		$query = 'SELECT * ' .
				' FROM #__properties_state ' .				
				' WHERE published = 1 ' .$CountrySql.
				' ORDER BY parent, name';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		
		$items 	= array();
		$items[] 	= JHTML::_('select.option',  '0', JText::_( 'All States' ) );
		if ( $mitems )
		{			
			foreach ( $mitems as $item )
			{
				$items[] = JHTML::_('select.option',  $item->id, '&nbsp;'. $item->name );
			}
		}			
		
		$javascript='onchange="this.form.getElementById(\'filter_locality\').value=\'\';submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_sid', 'class="" size="1" '.$javascript, 'value', 'text', $filter_sid );	
		
		return $output;
	}
	
	function FilterMultiSid( &$row,$TableName,$call )
	{	
		global $mainframe,$option;
		$filter_country		= $mainframe->getUserStateFromRequest( "$option.filter_country",		'filter_country',		'',		'int' );
		$filter_multisid		= $mainframe->getUserStateFromRequest( "$option.filter_multisid",		'filter_multisid',		'',		'array' );
		$db =& JFactory::getDBO();		
		
		if($filter_country>0){$CountrySql=' AND parent = ' .$filter_country;}else{$CountrySql='';}
		
		$query = 'SELECT * ' .
				' FROM #__properties_state ' .				
				' WHERE published = 1 ' .$CountrySql.
				' ORDER BY parent, name';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		
		$items 	= array();
		$items[] 	= JHTML::_('select.option',  '0', JText::_( 'All States' ) );
		if ( $mitems )
		{			
			foreach ( $mitems as $item )
			{
				$items[] = JHTML::_('select.option',  $item->id, '&nbsp;'. $item->name );
			}
		}			
		
		//$javascript='onchange="this.form.getElementById(\'filter_locality\').value=\'\';submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_multisid[]', 'class="" size="10" multiple="multiple"'.$javascript, 'value', 'text', $filter_multisid );	
		
		return $output;
	}
	
	
	function FilterLocality( &$row,$TableName,$call )
	{	
		global $mainframe,$option;		
		$filter_sid		= $mainframe->getUserStateFromRequest( "$option.filter_sid",		'filter_sid',		'',		'int' );
		$filter_locality		= $mainframe->getUserStateFromRequest( "$option.filter_locality",		'filter_locality',		'',		'int' );
		$db =& JFactory::getDBO();		
		
				
		if($filter_sid){$StateSql=' AND parent = ' .$filter_sid;}else{$StateSql='';}
		
		$query = 'SELECT * ' .
				' FROM #__properties_locality ' .				
				' WHERE published = 1 ' .$StateSql.	
				' ORDER BY parent, name';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		
		$items 	= array();
		$items[] 	= JHTML::_('select.option',  '0', JText::_( 'All Localities' ) );

		if ( $mitems )
		{			
			foreach ( $mitems as $item )
			{
				$items[] = JHTML::_('select.option',  $item->id, '&nbsp;'. $item->name );
			}
		}			
		
$javascript='onchange="this.form.getElementById(\'filter_locality\').value=\'\';submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_locality', 'class="" size="1" '.$javascript, 'value', 'text', $filter_locality );	
		
		return $output;
	}
	
	
	function FilterCategory( &$row,$TableName,$call )
	{	
		global $mainframe,$option;
		$filter_category		= $mainframe->getUserStateFromRequest( "$option.filter_category",		'filter_category',		'',		'int' );
		$db =& JFactory::getDBO();		
		
		
		$query = 'SELECT * ' .
				' FROM #__properties_'.$TableName.' ' .				
				' WHERE published != -2' .				
				' ORDER BY parent, ordering';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		
		$children = array();

		if ( $mitems )
		{			
			foreach ( $mitems as $v )
			{
				$pt 	= $v->parent;
				$list 	= @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		}
		$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );
		
		$mitems 	= array();
		$mitems[] 	= JHTML::_('select.option',  '0', JText::_( 'All Categories' ) );

		foreach ( $list as $item ) {
			$mitems[] = JHTML::_('select.option',  $item->id, '&nbsp;&nbsp;&nbsp;'. $item->treename );
		}
$javascript='onchange="this.form.getElementById(\'filter_state\').value=\'\';submitform( );"';
		$output = JHTML::_('select.genericlist',   $mitems, 'filter_category', 'class="" size="1" '.$javascript, 'value', 'text', $filter_category );	
		
		return $output;
	}
	
	function FilterType( &$row,$TableName,$call )
	{	
		global $mainframe,$option;
		$filter_category		= $mainframe->getUserStateFromRequest( "$option.filter_category",		'filter_category',		0,		'int' );
		$filter_type		= $mainframe->getUserStateFromRequest( "$option.filter_type",		'filter_type',		'',		'int' );
		$db =& JFactory::getDBO();			
		
		$query = 'SELECT * ' .
				' FROM #__properties_type ' .				
				' WHERE published != -2 AND parent = 0 or parent = ' .$filter_category.			
				' ORDER BY name';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();		
		$items 	= array();
		$items[] 	= JHTML::_('select.option',  '0', JText::_( 'Types' ) );
		if ( $mitems )
		{			
			foreach ( $mitems as $item )
			{
				$items[] = JHTML::_('select.option',  $item->id, '&nbsp;'. $item->name );
			}
		}		
$javascript='onchange="submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_type', 'class="select_filter" size="1" '.$javascript, 'value', 'text', $filter_type );	
		
		//echo 	$query;
		//print_r($mitems);
		return $output;
	}
	
	
	function FilterFeatured( &$row,$TableName,$call )
	{	
		global $mainframe,$option;
		$filter_featured		= $mainframe->getUserStateFromRequest( "$option.filter_featured",		'filter_featured',		'',		'int' );
			
			if ( $filter_featured == 1 )
			{
				$filter_featured_id = 1;
			}
			else if ($filter_featured == 9 )
			{
				$filter_featured_id = 0;
			}	
			
		$items 	= array();
		$items[] 	= JHTML::_('select.option',  '0', JText::_( 'Selec Featured' ) );
					
			$items[] = JHTML::_('select.option',  1, '&nbsp;'. 'Featured' );
			$items[] = JHTML::_('select.option',  9, '&nbsp;'. 'No Featured' );
			
$javascript='onchange="submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_featured', 'class="select_filter" size="1" '.$javascript, 'value', 'text', $filter_featured );		
		return $output;
	}
	
	
	
	
	
	function FilterTranslationTables()
	{	
		global $mainframe,$option;
		$filter_translation_tables	= $mainframe->getUserStateFromRequest( "$option.filter_translation_tables",'filter_translation_tables','','word' );
		$options	= array();
		
		$options[]	= JHtml::_('select.option', 'country', 'Country');
		$options[]	= JHtml::_('select.option', 'state', 'State');		
		$options[]	= JHtml::_('select.option', 'locality', 'Locality');
		$options[]	= JHtml::_('select.option', 'category', 'Category');
		$options[]	= JHtml::_('select.option', 'type', 'Type');			
	$javascript='onchange="submitform( );"';
		$output = JHTML::_('select.genericlist',   $options, 'filter_translation_tables', 'class="" size="1" '.$javascript, 'value', 'text', $filter_translation_tables );	
		
		return $output;
	}
	
	 function FilterTranslationLanguages()
	{
	
	global $mainframe,$option;
		$filter_translation_language	= $mainframe->getUserStateFromRequest( "$option.filter_translation_language",'filter_translation_language','','string' );	
		
		$db		=& JFactory::getDBO();
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$rows	= array ();		
		
		jimport('joomla.client.helper');
		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');		
		
		jimport('joomla.filesystem.folder');
	$path = JLanguage::getLanguagePath($client->path);
	$dirs = JFolder::folders( $path );
		
		foreach ($dirs as $dir)
	{
		$files = JFolder::files( $path.DS.$dir, '^([-_A-Za-z]*)\.xml$' );
		foreach ($files as $file)
		{
			$data = JApplicationHelper::parseXMLLangMetaFile($path.DS.$dir.DS.$file);

			$row 			= new StdClass();
			$row->id 		= $rowid;
			$row->language 	= substr($file,0,-4);

			if (!is_array($data)) {
				continue;
			}
			foreach($data as $key => $value) {
				$row->$key = $value;
			}

			// if current than set published
			$params = JComponentHelper::getParams('com_languages');
			if ( $params->get($client->name, 'en-GB') == $row->language) {
				$row->published	= 1;
			} else {
				$row->published = 0;
				
			}

			$row->checked_out = 0;
			$row->mosname = JString::strtolower( str_replace( " ", "_", $row->name ) );
			$rows[] = $row;
			$rowid++;
		}
	}
		
		$options	= array();
		$options[]	= JHtml::_('select.option','', 'Select Language');
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];
			
				if($row->published == 0)
					{
					$options[]	= JHtml::_('select.option', $row->language, $row->language);
					}
				}
					
		$javascript='onchange="submitform( );"';
		$output = JHTML::_('select.genericlist',   $options, 'filter_translation_language', 'class="" size="1" '.$javascript, 'value', 'text', $filter_translation_language );	
		
		return $output;

	}
	
}