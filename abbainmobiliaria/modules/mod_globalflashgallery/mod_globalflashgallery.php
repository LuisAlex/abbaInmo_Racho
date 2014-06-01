<?php
/**
 * @copyright   Copyright (c) 2010-2011 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

$gallery_id = $params->get('gallery_id');
if ($gallery_id)
{
	$componentDir = JPATH_ROOT.DS.'components'.DS.'com_globalflashgalleries';
	if ( is_dir($componentDir) )
	{
		$id = JRequest::getVar('id');
		JRequest::setVar('id', $gallery_id);

		include_once $componentDir.DS.'defines.php';
		include_once $componentDir.DS.'views'.DS.'gallery'.DS.'view.html.php';

		$view = new GlobalFlashGalleriesViewGallery();
		$view->addTemplatePath($componentDir.DS.'views'.DS.'gallery'.DS.'tmpl');

		if ($width = $params->get('width'))
			$view->options['width'] = $width;

		if ($height = $params->get('height'))
			$view->options['height'] = $height;

		if ($align = $params->get('align'))
			$view->options['align'] = $align;

		$view->display();

		JRequest::setVar('id', $id);
	}
}
