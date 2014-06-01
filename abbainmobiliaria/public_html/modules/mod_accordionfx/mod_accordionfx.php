<?php
/*------------------------------------------------------------------------
# mod_accordionfx.php - Accordion FX
# ------------------------------------------------------------------------
# author    FlashXML.net
# copyright Copyright (C) 2011 flashxml.net. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.flashxml.net
# Technical Support:  Forum - http://www.flashxml.net/accordion.html#comments
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

$accordionfx_path = $params->get('accordionfx_path');
if (strpos($accordionfx_path, '/') !== 0) {
	$accordionfx_path = '/'.$accordionfx_path;
	$params->def('accordionfx_path', $accordionfx_path);
}

$accordionfx_wmode = $params->get('accordionfx_wmode');
if (empty($accordionfx_wmode)) {
	$accordionfx_wmode = 'transparent';
	$params->def('accordionfx_wmode', $accordionfx_wmode);
}

$accordionfx_width = $accordionfx_height = 0;

switch (true) {
	case function_exists('simplexml_load_file') && file_exists(JPATH_BASE.$accordionfx_path.'settings.xml'):
		$xml = simplexml_load_file(JPATH_BASE.$accordionfx_path.'settings.xml');
		if ($xml) {
			$accordionfx_width_attributes_array = $xml->General_Properties->componentWidth->attributes();
				$accordionfx_width = !empty($accordionfx_width_attributes_array) ? (int)$accordionfx_width_attributes_array['value'] : 0;
				$accordionfx_height_attributes_array = $xml->General_Properties->componentHeight->attributes();
				$accordionfx_height = !empty($accordionfx_height_attributes_array) ? (int)$accordionfx_height_attributes_array['value'] : 0;
		}
	break;

	case (int)$params->get('accordionfx_width') > 0 && (int)$params->get('accordionfx_height') > 0:
		$accordionfx_width = (int)$params->get('accordionfx_width');
		$accordionfx_height = (int)$params->get('accordionfx_height');
	break;

	default:
		echo '<!--  invalid path to the settings XML file, please use valid module parameter values -->';
	break;
}

if ($accordionfx_width > 0 && $accordionfx_height > 0) {
	$joomla_install_dir_in_url = rtrim(JURI::root(true), '/');
	if (!empty($joomla_install_dir_in_url) && strpos($joomla_install_dir_in_url, '/') !== 0) {
		$joomla_install_dir_in_url = '/' . $joomla_install_dir_in_url;
	}

	global $mainframe;
	$mainframe->addCustomHeadTag('<script type="text/javascript" src="http'.(!empty($_SERVER['HTTPS']) ? 's' : '').'://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>');
	echo '<div id="flashxmlaccordion"></div><script type="text/javascript">'."swfobject.embedSWF('{$joomla_install_dir_in_url}{$accordionfx_path}AccordionFX.swf', 'flashxmlaccordion', '{$accordionfx_width}', '{$accordionfx_height}', '9.0.0.0', '', { folderPath: '{$joomla_install_dir_in_url}{$accordionfx_path}' }, { scale: 'noscale', salign: 'tl', wmode: '{$accordionfx_wmode}', allowScriptAccess: 'sameDomain', allowFullScreen: true }, {});</script>";
} else {
	echo '<!--  invalid Accordion FX width / height -->';
}