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

class PropertiesViewStates extends JView{
	
	function display($tpl = null)
	{
	$option = JRequest::getVar('option');
	
	if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add'){
		$state	=& $this->get('State_');
		$isNew = ($state->id < 1);
			
		$text = $isNew ? JText::_( 'New' ) : $state->name;
		JToolBarHelper::title(   JText::_( 'State' ).': <small><small>[ ' . $text.' ]</small></small>','states.png' );
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}		
		$this->assignRef('state',		$state);		
		parent::display();
		
		}else{
		JToolBarHelper::title(   JText::_( 'States' ),'states.png' );
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
		parent::display($tpl);

		}
	}	
}