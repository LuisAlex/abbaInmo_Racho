<?php
/**
 * @copyright   Copyright (c) 2010 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

jimport('joomla.application.component.view');
jimport('joomla.utilities.date');

class GlobalFlashGalleriesViewAlbums extends JView
{
	function display( $tpl = null )
	{
		$title = JText::_('Manage Albums');
		JToolBarHelper::title( JText::_('Flash Galleries').": <small>[ {$title} ]</small>", 'album.png' );

		$items =& $this->get('Data');

		if ( count($items) )
		{
			JToolBarHelper::deleteList();
			JToolBarHelper::editListX();
		}
		JToolBarHelper::addNewX();

		JToolBarHelper::help('../albums.html', true);

		$this->assignRef('items', $items);

		require_once globalflash_adminDir.DS.'inc'.DS.'ui.class.php';
		$ui = new GlobalFlashGalleries_UI();
		$this->assignRef('ui', $ui);

		parent::display($tpl);
	}
}
