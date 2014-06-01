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

class PropertiesViewLocalities extends JView{
	
	function display($tpl = null)
	{
	$option = JRequest::getVar('option');
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/com_properties/imagenes/properties.css');	
	
	if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add')
	{
		$locality		=& $this->get('Locality');
		$isNew = ($locality->id < 1);
			
		$text = $isNew ? JText::_( 'New' ) : $locality->name;
		JToolBarHelper::title(   JText::_('Localities').': <small><small>[ ' . $text.' ]</small></small>', 'localities.png' );
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}		
		$this->assignRef('locality',		$locality);		
		parent::display();
		
		}else{		
		
		JToolBarHelper::title(JText::_('Localities'), 'localities.png');
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