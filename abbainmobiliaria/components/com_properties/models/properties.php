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

class PropertiesModelProperties extends JModel
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
$this->Mostrar = $params->get( 'cantidad_productos' ) ;

if(!JRequest::getVar('limitstart', 0, '', 'int')){
	$this->setState('limit', $this->Mostrar);
	$this->setState('limitstart', 0);
}else{
	$limit = $this->Mostrar;
	$this->setState('limit', $this->Mostrar);
	
$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
$this->setState('limitstart', $limitstart);	

$start = JRequest::getVar('start', 0, '', 'int');
$this->setState('start', $start);	
}
$ShowOrderByDefault=$params->get('ShowOrderByDefault');
$ShowOrderDefault=$params->get('ShowOrderDefault');

$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	$ShowOrderByDefault ,	'cmd' );
$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	$ShowOrderDefault,		'word' );

$menus = &JSite::getMenu();
$menu  = $menus->getActive();
$menu_params = new JParameter( $menu->params );


  }


	
	
	

function _buildQuery()
	{	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$ShowOrderByDefault = $params->get( 'ShowOrderByDefault' ) ;
	$ShowOrderDefault = $params->get( 'ShowOrderDefault' ) ;
	$db 	=& JFactory::getDBO();
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
	
	//if(JRequest::getVar('task')=='showresults')	{		
	
	$moduleSearchAjax = JModuleHelper::getModule( 'prop_search_ajax' );
	$paramsModuleSearchAjax = new JParameter( $moduleSearchAjax->params );
	$exactBedrooms = $paramsModuleSearchAjax->get('exactBedrooms',1);
	$exactBathrooms = $paramsModuleSearchAjax->get( 'exactBathrooms',1 ) ;
	$AreaToSearch = $paramsModuleSearchAjax->get( 'AreaToSearch','area' ) ;
		$cyid = JRequest::getInt('cyid');
		$sid = JRequest::getInt('sid');
		$lid = JRequest::getInt('lid');
		$cid = JRequest::getInt('cid');
		$tid = JRequest::getInt('tid');
		$bedrooms = JRequest::getInt('bedrooms');
		
		$bathrooms = JRequest::getInt('bathrooms');		
		
		$parking = JRequest::getInt('parking');
		$minprice = JRequest::getInt('minprice');
		$maxprice = JRequest::getInt('maxprice');
					
		$minarea = JRequest::getInt('minarea');
		$maxarea = JRequest::getInt('maxarea');
		$minareacov = JRequest::getInt('minareacov');
		$maxareacov = JRequest::getInt('maxareacov');
		$persons = JRequest::getInt('persons');
		
		if ( $cyid>0 )
		{			
				$where[] = 'p.cyid = '.$cyid;			
		}
		if ( $sid>0 )
		{			
				$where[] = 'p.sid = '.$sid;			
		}
		if ( $lid>0 )
		{			
				$where[] = 'p.lid = '.$lid;			
		}
		
		if ( $cid>0 )
		{			
			if ( $prodMultipleCats )
				{
				$sqlCategoryLeft = ' LEFT JOIN #__properties_product_category AS pc ON p.id = pc.productid '.
									'LEFT JOIN #__properties_category AS c ON c.id = pc.categoryid';				
				$where[] = 'pc.categoryid = '.$cid;
				}else{
				
				$where[] = 'p.cid = '.$cid;
				}			
		}
		if ( $tid>0 )
		{			
				$where[] = 'p.type = '.$tid;			
		}		
				
		if ( $bedrooms>0 )
		{		
			if ( $bedrooms==5 )
				{	
				$where[] = 'p.bedrooms >= '.$bedrooms;	
				}else{
				$where[] = $exactBedrooms ? 'p.bedrooms = '.$bedrooms : 'p.bedrooms >= '.$bedrooms;	
				}	
		}
		
		if ( $bathrooms>0 )
		{			
			if ( $bathrooms==5 )
				{
				$where[] = 'p.bathrooms >= '.$bathrooms;
				}else{		
				$where[] = $exactBathrooms ? 'p.bathrooms = '.$bathrooms : 'p.bathrooms >= '.$bathrooms;
				}
		}
		
		if ( $parking>0 )
		{			
				$where[] = 'p.garage = '.$parking;			
		}
		if ( $minprice>0 )
		{			
				$where[] = 'p.price >= '.$minprice;			
		}
		if ( $maxprice>0 )
		{			
				$where[] = 'p.price <= '.$maxprice;			
		}
		if ( $minarea>0 )
		{			
				$where[] = 'p.'.$AreaToSearch.' >= '.$minarea;			
		}
		if ( $maxarea>0 )
		{			
				$where[] = 'p.'.$AreaToSearch.' <= '.$maxarea;			
		}
		if ( $minareacov>0 )
		{			
				$where[] = 'p.covered_area >= '.$minareacov;			
		}
		if ( $maxareacov>0 )
		{			
				$where[] = 'p.covered_area <= '.$maxareacov;			
		}
		if(JRequest::getInt('e1'))
			{
			$where[] = 'p.extra1 = 1';	
			}
		if(JRequest::getInt('e2'))
			{
			$where[] = 'p.extra2 = 1';	
			}
		if(JRequest::getInt('e3'))
			{
			$where[] = 'p.extra3 = 1';	
			}
		if(JRequest::getInt('e4'))
			{
			$where[] = 'p.extra4 = 1';	
			}
		if(JRequest::getInt('e5'))
			{
			$where[] = 'p.extra5 = 1';	
			}
		if(JRequest::getInt('e6'))
			{
			$where[] = 'p.extra6 = 1';	
			}	
		if(JRequest::getInt('e7'))
			{
			$where[] = 'p.extra7 = 1';	
			}
		if(JRequest::getInt('e8'))
			{
			$where[] = 'p.extra8 = 1';	
			}
		if(JRequest::getInt('e9'))
			{
			$where[] = 'p.extra9 = 1';	
			}
		if(JRequest::getInt('e10'))
			{
			$where[] = 'p.extra10 = 1';	
			}
		
		$badchars = array('#','>','<','\\'); 
		$currency = trim(str_replace($badchars, '', JRequest::getString('currency', null)));
		if ( $currency )
			{			
				$where[] = 'p.currency = '.$db->Quote( $db->getEscaped( $currency, true ), false );							
			}	
		$textsearch = trim(str_replace($badchars, '', JRequest::getString('textsearch', null)));			
		if($textsearch)
			{
			$textsearch		= $db->Quote( '%'.$db->getEscaped( $textsearch, true ).'%', false );
			$wheres2 	= array();
			$wheres2[] 	= 'p.name LIKE '.$textsearch;
			$wheres2[] 	= 'p.text LIKE '.$textsearch;
			$wheres2[] 	= 'p.description LIKE '.$textsearch;
			$where[] 		= '((' . implode( ') OR (', $wheres2 ) . '))';
			}	
			
	//}	
	
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	$orderby 	= ' ORDER BY '. $this->filter_order .' '. $this->filter_order_Dir;		
		

			
			$this->_query = ' SELECT p.*, c.cat_currency, c.name as name_category,t.name as name_type,cy.name as name_country,s.name as name_state,l.name as name_locality,pf.name as name_profile,pf.logo_image as logo_image_profile, ';
			
			
					
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

	
function getData() 
  {  
 	// if data hasn't already been obtained, load it
 	if (empty($this->_data)) {	
 	    $query = $this->_buildQuery();
 	    $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));	 	
	}
//	print_r($this->_data);
 	return $this->_data;
  }
  
  
function getTotal()
  {
 	// Load the content if it doesn't already exist
 	if (empty($this->_total)) {
 	    $query = $this->_buildQuery();
 	    $this->_total = $this->_getListCount($query);	
 	}
 	return $this->_total;
  }


function getPagination()
  {
 	// Load the content if it doesn't already exist
 	if (empty($this->_pagination)) {
 	  //  require_once( JPATH_COMPONENT.DS.'helpers'.DS.'pagination.php' );
	  jimport('joomla.html.pagination');
 	    $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );		
		
 	}
 	return $this->_pagination;
  }

  
}//fin clase