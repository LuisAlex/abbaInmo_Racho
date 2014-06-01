<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view' );

class PropertiesViewOpenhouse extends JView{
	
	function display($tpl = null)
	{
	$option = JRequest::getVar('option');
		
	if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add'){

		$openhouse		=& $this->get('Openhouse');		
	
		$isNew = ($openhouse->id < 1);
			
		$text = $isNew ? JText::_( 'New' ) : $openhouse->property_name;
		JToolBarHelper::title(   JText::_( 'Open house' ).': <small><small>[ '.$text.' ]</small></small>','openhouse.png' );
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}			
		
		$this->assignRef('openhouse',		$openhouse);			
		
		parent::display($layout);
		
		}else{
		
		JToolBarHelper::title(   JText::_( 'Open house' ),'openhouse.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

$items		= & $this->get( 'Data');
$pagination =& $this->get('Pagination');
$lists = & $this->get('List');

$this->assignRef('items',		$items);
$this->assignRef('pagination', $pagination);
$this->assignRef('lists', $lists);


$FilterLocality = $this->getFilterLocality();
$this->assignRef('FilterLocality', $FilterLocality);
		
parent::display($tpl);


		}
	}	
	
		
		
		function getFilterLocality()
	{	
		global $mainframe;			
		$filter_cities_openhouse= $mainframe->getUserStateFromRequest( "$option.filter_cities_openhouse",		'filter_cities_openhouse',	'',	'int' );
		$db =& JFactory::getDBO();		
		
		$query = 'SELECT * ' .
				' FROM #__properties_locality ' .				
				' WHERE published = 1 ' .	
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
		
$javascript='onchange="submitform( );"';
		$output = JHTML::_('select.genericlist',   $items, 'filter_cities_openhouse', 'class="" size="1" '.$javascript, 'value', 'text', $filter_cities_openhouse );	
		
		return $output;
	}	

}