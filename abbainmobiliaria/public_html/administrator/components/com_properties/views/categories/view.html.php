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
class PropertiesViewCategories extends JView
{	
	function display($tpl = null)
	{
	global $mainframe;		
	$option = JRequest::getVar('option');
		if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add')
		{
		$category		=& $this->get('Category');
		$isNew = ($category->id < 1);			
		$text = $isNew ? JText::_( 'New' ) : $category->name;
		JToolBarHelper::title(   JText::_( 'Categories' ).': <small><small>[ '.$text.' ]</small></small>', 'categories.png' );		
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}		
		$this->assignRef('category',		$category);		
		parent::display();
				
		}else{
		
		JToolBarHelper::title(JText::_('Categories'), 'categories.png');
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