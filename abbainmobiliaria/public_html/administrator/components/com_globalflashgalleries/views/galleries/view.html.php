<?php
/**
 * @copyright   Copyright (c) 2010 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

jimport('joomla.application.component.view');
jimport('joomla.utilities.date');

class GlobalFlashGalleriesViewGalleries extends JView
{
	function display( $tpl = null )
	{
		//$document =& JFactory::getDocument();
		//$document->addStyleSheet( JURI::base().'components/com_globalflashgalleries/css/icons.css', 'text/css', null, array() );

		$title = JText::_('Manage Galleries');
		JToolBarHelper::title( JText::_('Flash Galleries').": <small>[ {$title} ]</small>", 'gallery.png' );

		$items =& $this->get('Data');
		if ( count($items) )
		{
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::deleteList();
			JToolBarHelper::editListX();
		}
		JToolBarHelper::addNewX();

		JToolBarHelper::help('../galleries.html', true);

		$this->assignRef('items', $items);

		parent::display($tpl);
	}

}
