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
global $mainframe;
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
JHTML::_('behavior.tooltip'); 
JHTML::_('behavior.formvalidation');
jimport('joomla.filesystem.file');
$document =& JFactory::getDocument();
$this->lang =& JFactory::getLanguage();
$user =& JFactory::getUser();
$Product=$this->Product;
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$this->params=$params;
$ShowImagesSystem=$params->get('ShowImagesSystem');
$DetailLayout=$params->get('DetailLayout');
$ActivarTabs = $params->get('ActivarTabs');
$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('content');
		$pVideo = new JObject();
		//$pVideo->text='{youtube}DV81bAghxBU{/youtube}';
		$pVideo->text=$Product->video;
		$results = $dispatcher->trigger('onPrepareContent', array (& $pVideo, '', 0));	
		$results = $dispatcher->trigger('onPrepareContent', array (& $Product, '', 0));
		$this->pVideo = $pVideo;

if($DetailLayout==0){$DetailLayout=NULL;}

if($ActivarTabs==1){$cssTabs='_tab';}else{$cssTabs=NULL;}
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/detail'.$cssTabs.$DetailLayout.'.css" type="text/css" media="screen" />');


if($ActivarTabs==1){
echo $this->loadTemplate('tabs'.$DetailLayout);
}else{
echo $this->loadTemplate('details'.$DetailLayout);

}

?>


<br />


