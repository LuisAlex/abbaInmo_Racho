<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class Modprop_googlemapHelper
{

	function getItems($params)
    { 
	$db = &JFactory::getDBO();	
	 
	$amountShow=$params->get('amountShow');
	$where = array();
	$where[] = 'p.published = 1';	
	if($params->get('ShowPropertyID'))
		{
		$where[] = ' p.id IN ('.$params->get('ShowPropertyID').')';
		}
	if($params->get('ShowFeatured'))
		{
		$where[] = ' p.featured = 1';
		}
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );	

		$query = 'SELECT p.*, i.name as imagename,c.name as name_category,t.name as name_type,cy.name as name_country'
		. ' ,s.name as name_state,l.name as name_locality, COUNT(p.id) as cant, '
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
				. ' LIMIT '.$amountShow;				
				
        $db->setQuery($query);		
		$items = $db->loadObjectList();       
        return $items;
    }	
	
}