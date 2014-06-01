<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once(dirname(__FILE__).DS.'helper.php');
require_once( JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'helper.php' );
$component = JComponentHelper::getComponent( 'com_properties' );
$componentParams = new JParameter( $component->params );
$SpecialDesign = $params->get('SpecialDesign',$params->get('layout','mod_prop_last'));
$lang =& JFactory::getLanguage();	
 $mainframe->addCustomHeadTag('<link rel="stylesheet" href="modules/mod_prop_last/css/'.$SpecialDesign.'.css" type="text/css" />'); 	
	
$items = Modprop_lastHelper::getItems($params);

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
			
		if($productTranslation = TranslationHelper::getProductTranslations($row))
		{
			
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
	}
	$Itemid=Modprop_lastHelper::getItemid('property');

$widthThumb = $params->get('widthThumb');
$heightThumb = $params->get('heightThumb');
$showName = $params->get('showName');
$showCategory = $params->get('showCategory');
$showType = $params->get('showType');
$showLocality = $params->get('showLocality');
$showHits = $params->get('showHits');
$showPrice = $params->get('showPrice');
$ShowWaterMark = $params->get('ShowWaterMark');
$amountColumns = $params->get('amountColumns',3);
	require(JModuleHelper::getLayoutPath('mod_prop_last',$params->get('layout')));


?>