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

class PropertiesViewTranslations extends JView{
	
	function display($tpl = null)
	{

	global $mainframe;
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/com_properties/includes/css/translations.css');
	$option = JRequest::getVar('option');
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$useTranslations=$params->get('useTranslations');
	
	if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add')
	{	
	$array = JRequest::getVar('cid',  0, '', 'array');
	$id=(int)$array[0];
	$isNew = ($id < 1);
		
		if (!$isNew)  {
		$product =& $this->get('Product');		
		$this->assignRef('datos',		$product);
		}else{
		//echo 'is new';
		}

		
			
		$text = $isNew ? JText::_( 'New' ) : $product->name ;
		JToolBarHelper::title(''.'<small><small>[ '.$text.' ]</small></small>', 'translations.png' );
		
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}			
		
		parent::display($layout);
		
		}else{
		$filter_translation_tables	= $mainframe->getUserStateFromRequest( "$option.filter_translation_tables",'filter_translation_tables','','word' );
		$filter_translation_language	= $mainframe->getUserStateFromRequest( "$option.filter_translation_language",'filter_translation_language','','string' );	
		
		JToolBarHelper::title(''.JText::_('Translations'), 'translations.png');
		
		if($filter_translation_tables & $filter_translation_language)
			{		
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::custom('savelist', 'save.png', 'save.png', 'Save List', false);
		$items		= & $this->get( 'Data');	
			}

		$lists = & $this->get('List');
		$this->assignRef('lists', $lists);		
			
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);

		$this->assignRef('items',		$items);
		
		parent::display( $tpl );
		
	}
		
	}	
	
}