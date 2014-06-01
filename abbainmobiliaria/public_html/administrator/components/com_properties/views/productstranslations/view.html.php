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

class PropertiesViewProductstranslations extends JView{
	
	function display($tpl = null)
	{

	global $mainframe;
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/com_properties/includes/css/products.css');
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
		JToolBarHelper::title('&nbsp; &nbsp;'.'<small><small>[ '.$text.' ]</small></small>', 'productstranslations.png' );
		
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}			

		$filter_translation_language	= $mainframe->getUserStateFromRequest( "$option.filter_translation_language",'filter_translation_language','','string' );	
		$this->assignRef('filter_translation_language', $filter_translation_language);	
		parent::display($layout);
		
		}else{
		
		JToolBarHelper::title('&nbsp; &nbsp;'.JText::_('Products Translations'), 'productstranslations.png');		
		JToolBarHelper::deleteList();
		JToolBarHelper::addNewX();

		$lists = & $this->get('List');
		$this->assignRef('lists', $lists);		
		
		$items		= & $this->get( 'Data');
		
		for ($i=0, $n=count( $items ); $i < $n; $i++)
			{
			$row = &$items[$i];
			$productTranslation[$row->id]=$this->getProductTranslation($row->id);		
			}
		
		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);	


		foreach($items as $item){
			$Images[$item->id]=$this->getImages($item->id);
			$this->assignRef('Images',		$Images);		
		}		

	$this->assignRef('items',		$items);
	$this->assignRef('productTranslation', $productTranslation);		
		parent::display( $tpl );
		
	}
	
	
	}
	
		function getProductTranslation($pid)
		{
		global $mainframe;
		$filter_translation_language	= $mainframe->getUserStateFromRequest( "$option.filter_translation_language",'filter_translation_language','','string' );
		
		$thisLang=$filter_translation_language;
	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT pt.* '			
			. ' FROM #__properties_products_translations AS pt '					
			. ' WHERE pt.pt_pid = '.$pid
			. ' AND pt.pt_langcode = \''.$thisLang.'\''		
			;					
        $db->setQuery($query);
		$Translations = $db->loadObject();
							
														
		return $Translations;	
		}
		
		
function getImages($id,$total=1)
	{	
	
	$db 	=& JFactory::getDBO();	
	$query = ' SELECT i.* '			
			. ' FROM #__properties_images as i '					
			. ' WHERE i.published = 1 AND i.parent = '.$id			
			. ' order by i.ordering ';		
        $db->setQuery($query);   

		$Images = $db->loadObjectList();

	return $Images;
	}
	
}