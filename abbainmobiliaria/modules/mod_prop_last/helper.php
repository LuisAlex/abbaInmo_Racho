<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.'); 
class Modprop_lastHelper
{
    function getItems($params)
    {	
	$ShowFeatured = $params->get('ShowFeatured');
$OrderBy = $params->get('OrderBy');
$Order = $params->get('Order');
$amountShow = $params->get('amountShow');
$ShowPropertyID = $params->get('ShowPropertyID');
$widthThumb = $params->get('widthThumb');
$heightThumb = $params->get('heightThumb');
$BorderThumbPx = $params->get('BorderThumbPx');
$BordeThumbC = $params->get('BordeThumbC');
$showShadow = $params->get('showShadow');
$showName = $params->get('showName');
$showCategory = $params->get('showCategory');
$showType = $params->get('showType');
$showLocality = $params->get('showLocality');
$showHits = $params->get('showHits');
$showPrice = $params->get('showPrice');
$SimbolPrice = $params->get('SimbolPrice');
$PositionPrice = $params->get('PositionPrice');
$FormatPrice = $params->get('FormatPrice');
$ShowInList = $params->get('ShowInList');   
$ShowThisCategory = $params->get('ShowThisCategory'); 
	
	if($OrderBy=='rand()')
		{
		$Order='';
		}else{
		$OrderBy = 'p.'.$OrderBy;
		}
	$where = array();
	$where[] = 'p.published = 1';	
	
	if($ShowPropertyID)
		{
		$where[] = ' p.id IN ('.$ShowPropertyID.')';
		}
		
	if($ShowThisCategory)
		{
		$where[] = ' p.cid = '.$ShowThisCategory;
		}	
		
	if($ShowFeatured)
		{
		$where[] = ' p.featured = 1';
		}
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$db = &JFactory::getDBO();     
        $query = 'SELECT p.*, i.name as imagename,c.cat_currency,c.name as name_category,t.name as name_type,cy.name as name_country,s.name as name_state,l.name as name_locality,'
				. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as Pslug,'
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as Cslug,'
		. ' CASE WHEN CHAR_LENGTH(cy.alias) THEN CONCAT_WS(":", cy.id, cy.alias) ELSE cy.id END as CYslug,'
		. ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as Sslug,'		
		. ' CASE WHEN CHAR_LENGTH(l.alias) THEN CONCAT_WS(":", l.id, l.alias) ELSE l.id END as Lslug, '	
		. ' CASE WHEN CHAR_LENGTH(t.alias) THEN CONCAT_WS(":", t.id, t.alias) ELSE t.id END as Tslug '
                . ' FROM #__properties_products AS p '
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
				. ' LEFT JOIN #__properties_images AS i ON i.parent = p.id AND i.ordering = 1 '
				. $where				
				. ' GROUP BY p.id '	
				. ' ORDER BY '.$OrderBy.' '.$Order
				. ' LIMIT '.$amountShow;

        $db->setQuery($query);	
		$items = $db->loadObjectList();
       // $items = ($items = $db->loadObjectList())?$items:array(); 
//echo str_replace('#_','jos',$query);
	
        return $items;
    }  

	
	function getItemid( $TableName )
	{
		$db =& JFactory::getDBO();	
		$query = 'SELECT id FROM #__menu' .
				' WHERE LOWER( link ) = "index.php?option=com_properties&view='.$TableName.'&id=0"';				
		$db->setQuery( $query );
		$output = $db->loadResult();
		
		if(!$output){
		$query = 'SELECT id FROM #__menu' .
				' WHERE LOWER( link ) = "index.php?option=com_properties&view=properties"';				
		$db->setQuery( $query );
		$output = $db->loadResult();
		}
		
		if(!$output){
		$query = 'SELECT id FROM #__menu' .
				' WHERE LOWER( link ) = "index.php?option=com_properties&view=properties&cid=0&tid=0"';				
		$db->setQuery( $query );
		$output = $db->loadResult();
		}
		
		return $output;
	}
} 

?>