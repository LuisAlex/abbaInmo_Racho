<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.'); 
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="modules/mod_prop_search_ajax/css/mod_prop_search_ajax.css" type="text/css" />');
$mainframe->addCustomHeadTag('<script type="text/javascript">
  window.addEvent(\'domready\', function() {
	 ModuleSearchAjax();
   });
</script>');
require_once(dirname(__FILE__).DS.'helper.php');
$moduleclass_sfx    = $params->get( 'moduleclass_sfx' );
if($params->get('divHeight'))
	{
	$divHeight		=	'height:'.$params->get('divHeight');
	}
if($params->get('divWidth'))
	{
	$divWidth		=	'width:'.$params->get('divWidth');
	}	
if($params->get('selectWidth'))
	{
	$selectWidth	=	'width:'.$params->get('selectWidth');
	}		
require(JModuleHelper::getLayoutPath('mod_prop_search_ajax'));
?>