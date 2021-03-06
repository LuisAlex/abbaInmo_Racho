<?php
/**
 * @copyright   Copyright (c) 2010 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

jimport('joomla.application.component.view');

class GlobalFlashGalleriesViewGlobalFlashGalleries extends JView
{
	function display( $tpl = null )
	{
		JToolBarHelper::title( JText::_('Global Flash Galleries Component').' <small style="color:#999;">[ '.JText::_('Version: ').globalflash_version.' ]</small>', 'cpanel.png' );
		JToolBarHelper::help('../contents.html', true);

		parent::display($tpl);
	}

}
