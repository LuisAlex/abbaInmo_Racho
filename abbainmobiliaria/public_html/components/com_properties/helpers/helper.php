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
class PropertiesHelper
{	
	function getPriceText($price,$currency,$cat_currency)
	{		
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
		$currencyformat=$params->get('FormatPrice');
		$SimbolPrice=$params->get('SimbolPrice');
		$PositionPrice=$params->get('PositionPrice');
		$FormatPrice=$params->get('FormatPrice',2);
		if($price==0)
			{
			return '';
			
			}

		$number = $price;
		if ($FormatPrice==0) {
			$formatted_price = number_format($number);
		} else if ($FormatPrice==1) {
			$formatted_price = number_format($number, 2,".",",");
		} else if ($FormatPrice==2) {
			$formatted_price = number_format($number, 0,",",".");
		} else if ($FormatPrice==3) {			
			$formatted_price = number_format($number, 2,",",".");
		}
		
		if($currency)
			{			
			$currencyValue = PropertiesHelper::getCurrency($currency);			
			if($currencyValue->position)
				{
				return $formatted_price.' '.$currencyValue->currency;
				}
			return $currencyValue->currency.' '.$formatted_price;				
			}
			
		if($cat_currency)
			{
			$currencyValue = PropertiesHelper::getCurrency($cat_currency);			
			if($currencyValue->position)
				{
				return $formatted_price.' '.$currencyValue->currency;
				}
			return $currencyValue->currency.' '.$formatted_price;	
			
			}
		
		if($PositionPrice==0){
			$priceText = $SimbolPrice.' '. $formatted_price; 
		}else{
			$priceText = $formatted_price .' '. $SimbolPrice; 
		}

		return $priceText;
	}	
	
	function getCurrency($currency)
		{
		$db =& JFactory::getDBO();		
		$query = 'SELECT * ' .
				' FROM #__properties_currencies ' .
				' WHERE published = 1'.
				' AND id = '.$currency;				
		$db->setQuery( $query );
		$item = $db->loadObject();
		return $item;
		}
	function getCurrencies()
		{
		$db =& JFactory::getDBO();		
		$query = 'SELECT * ' .
				' FROM #__properties_currencies ' .
				' WHERE published = 1'
				;				
		$db->setQuery( $query );
		$items = $db->loadObjectList();
		return $items;
		}		
}