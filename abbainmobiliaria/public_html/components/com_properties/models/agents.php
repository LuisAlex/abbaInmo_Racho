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
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class PropertiesModelAgents extends JModel
{
	var $_data;
	var $_total = null;
	var $_pagination = null;

function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;

$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );

	$ShowOrderByDefault=$params->get('ShowOrderByDefault');
	$ShowOrderDefault=$params->get('ShowOrderDefault');

		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	$ShowOrderByDefault ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	$ShowOrderDefault,		'word' );
		
		
$this->amountAgentsList = $params->get( 'amountAgentsList',5 ) ;

	if(!JRequest::getVar('limitstart', 0, '', 'int')){
		$this->setState('limit', $this->amountAgentsList);
		$this->setState('limitstart', 0);
	}else{
		$limit = $this->amountAgentsList;
		$this->setState('limit', $this->amountAgentsList);
	
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		$this->setState('limitstart', $limitstart);	

		$start = JRequest::getVar('start', 0, '', 'int');
		$this->setState('start', $start);	
	}
	
	$aid = JRequest::getInt('aid');	
	$this->setId($aid);
	
	$menus = &JSite::getMenu();
	$menu  = $menus->getActive();
	$menu_params = new JParameter( $menu->params );
	if($menu->query['view']=='agents')
		{			
		if($menu_params->get('aid'))
			{
			$where[] = 'p.agent_id = '.$menu_params->get('aid');
			}
		}
	}
	
	function setId($aid)
	{
	$this->_aid		= $aid;
	}
	
function _buildQuery()
	{	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$where = array();
	$where[] = 'published = 1';	
	
	$where = ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );	
			
		$this->_query = 'SELECT * FROM #__properties_profiles '.$where;
//echo str_replace('#_','jos',$this->_query);
        return $this->_query;		
}
	
function getData() 
  {  
 	if (empty($this->_data)) {	
 	    $query = $this->_buildQuery();
 	    $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));	 	
	}
 	return $this->_data;
  }  
  
function getTotal()
  {
 	if (empty($this->_total)) {
 	    $query = $this->_buildQuery();
 	    $this->_total = $this->_getListCount($query);	
 	}
 	return $this->_total;
  }


function getPagination()
  {
 	if (empty($this->_pagination)) {
	  jimport('joomla.html.pagination');
 	    $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );		
 	}
 	return $this->_pagination;
  }

  
  
  
  
  
  function _buildListingsQuery()
	{	
	
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$ShowOrderByDefault = $params->get( 'ShowOrderByDefault' ) ;
	$ShowOrderDefault = $params->get( 'ShowOrderDefault' ) ;
	$useTranslations=$params->get('useTranslations','0');
	$prodMultipleCats=$params->get('prodMultipleCats','0');
	
	switch ($ShowOrderByDefault)
	{
	case 'refresh_time': $o='p.refresh_time';
	break;
	case 'price': $o='p.price';
	break;
	case 'cid': $o='c.name';
	break;
	case 'type': $o='t.name';
	break;
	case 'name': $o='p.name';
	break;
	case 'ordering': $o='p.ordering';
	break;
	default: $o='p.ordering';
	break;
	}
	
	if(!$this->filter_order){$this->filter_order = $o;}
	if(!$this->filter_order_Dir){$this->filter_order_Dir=$ShowOrderDefault;}
	
	$sqlCategoryLeft = ' LEFT JOIN #__properties_category AS c ON c.id = p.cid ';
	$where[] = 'p.published = 1';
	
	
	if($this->_aid){
	$where[] = ' p.agent_id = '.$this->_aid;
	}
					
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	$orderby 	= ' ORDER BY '. $this->filter_order .' '. $this->filter_order_Dir;
		
			
			$this->_query = ' SELECT p.*,c.name as name_category,t.name as name_type,cy.name as name_country,s.name as name_state,l.name as name_locality,pf.name as name_profile,pf.logo_image as logo_image_profile, ';
			
			
					
			$this->_query .= ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as Pslug,'
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as Cslug,'
		. ' CASE WHEN CHAR_LENGTH(cy.alias) THEN CONCAT_WS(":", cy.id, cy.alias) ELSE cy.id END as CYslug,'
		. ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as Sslug,'		
		. ' CASE WHEN CHAR_LENGTH(l.alias) THEN CONCAT_WS(":", l.id, l.alias) ELSE l.id END as Lslug, '	
		. ' CASE WHEN CHAR_LENGTH(t.alias) THEN CONCAT_WS(":", t.id, t.alias) ELSE t.id END as Tslug '			
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_profiles AS pf ON pf.mid = p.agent_id '
				//. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. $sqlCategoryLeft
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type ';
				
				
				
				$this->_query .= $where.' '
				. $orderby
				;
//echo str_replace('#_','jos',$this->_query);
        return $this->_query;		
			
	}

  function getAgentListings() 
  {  
 	if (empty($this->_data)) {	
 	    $query = $this->_buildListingsQuery();
 	    $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));	 	
	}
 	return $this->_data;
  }  
  
function getTotalListings()
  {
 	if (empty($this->_total)) {
 	    $query = $this->_buildListingsQuery();
 	    $this->_total = $this->_getListCount($query);	
 	}
 	return $this->_total;
  }


function getPaginationListings()
  {
 	if (empty($this->_pagination)) {
	  jimport('joomla.html.pagination');
 	    $this->_pagination = new JPagination($this->getTotalListings(), $this->getState('limitstart'), $this->getState('limit') );		
 	}
 	return $this->_pagination;
  }






  
}//fin clase