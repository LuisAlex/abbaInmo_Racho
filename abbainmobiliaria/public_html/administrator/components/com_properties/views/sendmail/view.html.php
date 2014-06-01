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

class PropertiesViewSendmail extends JView{
	
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

		
		$rates=$this->getRates($product->id);	
		$this->assignRef('rates',		$rates);	
		$Images=$this->getImages($product->id);
		$this->assignRef('Images',		$Images);
			
		}else{
		$product = new JObject();
		$product->id = null;
		}
		
		$this->assignRef('datos',		$product);		
			
		$text = $isNew ? JText::_( 'New' ) : $product->name ;
		JToolBarHelper::title('&nbsp; &nbsp;'.'<small><small>[ '.$text.' ]</small></small>', 'products.png' );
		
		//JToolBarHelper::custom('exportxml', 'export.png', 'export.png', 'Export XML', false);

		JToolBarHelper::custom('approved', 'new.png', 'new_f2.png', 'approved', false);
		JToolBarHelper::custom('rejected', 'delete.png', 'delete.png', 'rejected', false);
		JToolBarHelper::cancel( 'cancel', 'Close' );
	
		
		parent::display();
		
		}else{
		
		JToolBarHelper::title('&nbsp; &nbsp;'.JText::_('Products'), 'products.png');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

$lists = & $this->get('List');
		$this->assignRef('lists', $lists);		
		
		$items		= & $this->get( 'Data');
		
		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);	


foreach($items as $item){

$Images[$item->id]=$this->getImages($item->id);
		$this->assignRef('Images',		$Images);
		
		
		
}		
$this->assignRef('items',		$items);

		
		parent::display( $tpl );
		
	}
	
	
	}
	
	
			
		
	function getRates($id)
		{
		
	$db 	=& JFactory::getDBO();	
	$query = ' SELECT r.*'			
			. ' FROM #__properties_rates as r'			
			. ' WHERE r.productid = '.$id		
			. ' order by r.validfrom '
			;		
        $db->setQuery($query);   

		$Menus = $db->loadObjectList();

	return $Menus;
	
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