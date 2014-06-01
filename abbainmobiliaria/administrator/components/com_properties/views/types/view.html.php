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
class PropertiesViewTypes extends JView
{	
	function display($tpl = null)
	{
	global $mainframe;
	$option = JRequest::getVar('option');

		if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add')
		{
		$type		=& $this->get('Type');
		$isNew = ($type->id < 1);
			
		$text = $isNew ? JText::_( 'New' ) : $type->name;
		JToolBarHelper::title(   JText::_( 'Types' ).': <small><small>[ ' . $text.' ]</small></small>', 'types.png' );
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}			
		
		$this->assignRef('type',		$type);			
		
		parent::display();
		
		}else{
		JToolBarHelper::title(JText::_('Types'), 'types.png');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();		

		$lists = & $this->get('List');
		$this->assignRef('lists', $lists);		
		
		$items		= & $this->get( 'Data');
		$this->assignRef('items',		$items);
		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);		
		parent::display($tpl);
	
		}
	}
}