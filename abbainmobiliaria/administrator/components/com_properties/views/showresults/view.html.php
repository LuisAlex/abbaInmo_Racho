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

class PropertiesViewShowresults extends JView{
	
	function display($tpl = null)
	{

	global $mainframe;
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/com_properties/includes/css/showresults.css');
	$option = JRequest::getVar('option');
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	
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
		JToolBarHelper::title('&nbsp; &nbsp;'.'<small><small>[ '.$text.' ]</small></small>', 'showresults.png' );
		
		JToolBarHelper::cancel( 'cancel', 'Close' );
					
		
		parent::display($layout);
		
		}else{
		
		JToolBarHelper::title('&nbsp; &nbsp;'.JText::_('Show Results'), 'showresults.png');
		
		JToolBarHelper::deleteList();
	
	

$lists = & $this->get('List');
		$this->assignRef('lists', $lists);		
		
		$items		= & $this->get( 'Data');
		
		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);	

	
$this->assignRef('items',		$items);

		
		parent::display( $tpl );
		
	}
	
	
	}
	
	
		
}