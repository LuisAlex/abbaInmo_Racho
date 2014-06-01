<?php
/**
 * @copyright   Copyright (c) 2010-2011 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

jimport('joomla.application.component.view');
jimport('joomla.plugin.helper');

class GlobalFlashGalleriesViewGallery extends JView
{
	var $options = array();

	function display( $tpl = null )
	{
		require_once globalflash_frontendDir.DS.'models'.DS.'gallery.php';
		$this->model = new GlobalFlashGalleriesModelGallery();

		$gallery = $this->model->getData();
		$this->assignRef('gallery', $gallery);

		if ($gallery->published)
		{
			$document =& JFactory::getDocument();
			$document->addScript( globalflash_frontendURL.'/js/jquery/jquery.js' );

			JPluginHelper::importPlugin('globalflashgalleries');
			$dispatcher =& JDispatcher::getInstance();

			$altgallery = $dispatcher->trigger('getJS');
			if (!empty($altgallery[0])) {
				$jsURL = str_replace(DS, '/', preg_replace('/^'.preg_quote(JPATH_ROOT.DS, '/').'(.*)/', JURI::root().'$1', realpath($altgallery[0])));
				$document->addScript($jsURL);
			}
			else
				$document->addScript(globalflash_frontendURL.'/js/altgallery.js');

			$swf = $dispatcher->trigger('getSWFfor'.$gallery->type);
			if (!empty($swf[0]))
				$swfURL = str_replace(DS, '/', preg_replace('/^'.preg_quote(JPATH_ROOT.DS, '/').'(.*)/', JURI::root().'$1', realpath($swf[0])));
			else
				$swfURL = globalflash_frontendURL.'/swf/'.$gallery->type.'.swf';

			$this->assignRef('swfURL', $swfURL);

			$this->assignRef('altContent', $this->model->getAltContent());

			require_once globalflash_frontendDir.DS.'inc'.DS.'ui.class.php';
			$ui = new GlobalFlashGalleries_UI();
			$this->assignRef('ui', $ui);

			/*
			$document =& JFactory::getDocument();
			$document->addStyleSheet( globalflash_frontendURL.'/css/default.css' );
			*/

			parent::display($tpl);
		}
	}

}
