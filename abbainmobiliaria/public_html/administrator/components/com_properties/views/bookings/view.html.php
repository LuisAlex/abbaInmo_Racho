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
class PropertiesViewBookings extends JView
{	
	function display($tpl = null)
	{
	global $mainframe;
	$task=JRequest::getVar('task');	
	
		if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add'){
		
		JToolBarHelper::apply();
		JToolBarHelper::cancel( 'cancel', 'Close' );
		$Order		= & $this->get( 'Order');
		$this->assignRef('Order',		$Order);
		//$tpl='form';
		
		
		}else{	
		JToolBarHelper::title(JText::_('Bookings'), 'bookings.png');
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();	
			$bar=& JToolBar::getInstance( 'toolbar' );
$bar->appendButton( 'Popup', 'print', 'Imprimir', 'index.php?option=com_properties&view=bookings&layout=print&tmpl=component', 800, 600 );
	
		$lists = & $this->get('List');
		$this->assignRef('lists', $lists);
				
		$items		= & $this->get( 'Data');
		$this->assignRef('items',		$items);
		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);
		}
		parent::display($tpl);
	}
}