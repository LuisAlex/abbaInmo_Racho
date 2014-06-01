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
class PropertiesViewContacts extends JView{
	
	function display($tpl = null)
	{	
	global $mainframe;
	$option = JRequest::getVar('option');	

if(JRequest::getVar('layout')){
$contact = & $this->get('Contact');
$this->assignRef('contact',		$contact);

JToolBarHelper::back();

$bar=& JToolBar::getInstance( 'toolbar' );
$bar->appendButton( 'Popup', 'print', 'Print', 'index.php?option=com_properties&view=contacts&layout=print&tmpl=component&cid[]='.$contact->id, 800, 600 );
JToolBarHelper::deleteList();

}else{
JToolBarHelper::title(JText::_('Contacts'), 'contacts.png');
JToolBarHelper::deleteList();
$items		= & $this->get( 'Data');
$pagination =& $this->get('Pagination');
$lists = & $this->get('List');
$this->assignRef('items',		$items);
$this->assignRef('pagination', $pagination);
$this->assignRef('lists', $lists);


}
parent::display($tpl);
	}	
}