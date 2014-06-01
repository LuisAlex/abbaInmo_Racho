<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.'); 
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="modules/mod_prop_googlemap/css/'.$params->get('layout','default').'.css" type="text/css" />');
require_once( JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'link.php' );
require_once(dirname(__FILE__).DS.'helper.php');

jimport( 'joomla.application.component.helper' );
$component = JComponentHelper::getComponent( 'com_properties' );
$componentParams = new JParameter( $component->params );
//$apikey 		= $paramsC->get( 'apikey' ) ;
$MapApiKey 		= $params->get( 'MapApiKey' ) ;
$MapDistance 	= $params->get( 'MapDistance' ) ;
$DefaultLat 	= $params->get( 'DefaultLat' ) ;
$DefaultLng 	= $params->get( 'DefaultLng' ) ;
$showName 		= $params->get('showName');
$showCategory 	= $params->get('showCategory');
$showType 		= $params->get('showType');
$showLocality 	= $params->get('showLocality');
$showHits 		= $params->get('showHits');
$showPrice 		= $params->get('showPrice');
$SimbolPrice 	= $params->get('SimbolPrice');
$PositionPrice 	= $params->get('PositionPrice');
$FormatPrice 	= $params->get('FormatPrice');

$items = Modprop_googlemapHelper::getItems($params);

$useTranslations=$componentParams->get('useTranslations','0');
	if($useTranslations)
	{
	require_once( JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'translation.php' );			
		
	for ($i=0, $n=count( $items ); $i < $n; $i++)	
    	{
		$row = $items[$i];
		$translation = TranslationHelper::getTranslations($row);			
		if(isset($translation['country']))
			{
			$items[$i]->name_country=$translation['country'];			
			}
		if(isset($translation['state']))
			{
			$items[$i]->name_state=$translation['state'];			
			}	
		if(isset($translation['locality']))
			{
			$items[$i]->name_locality=$translation['locality'];			
			}	
		if(isset($translation['category']))
			{
			$items[$i]->name_category=$translation['category'];			
			}	
		if(isset($translation['type']))
			{
			$items[$i]->name_type=$translation['type'];			
			}	
			
		$productTranslation = TranslationHelper::getProductTranslations($row);
			
		if($productTranslation->pt_name)
			{
			$items[$i]->name=$productTranslation->pt_name;			
			}
			
		if($productTranslation->pt_alias)
			{
			$items[$i]->alias=$productTranslation->pt_alias;			
			}
			
		if($productTranslation->pt_address)
			{			
			$items[$i]->address=$productTranslation->pt_address;						
			}	
		}
	}
	
	
require(JModuleHelper::getLayoutPath('mod_prop_googlemap',$params->get('layout','default')));
?>