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

class PropertiesModelPropertieslist extends JModel
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

	if(!JRequest::getVar('limitstart', 0, '', 'int'))
		{
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

	}


	
	
	

function _buildQuery()
	{
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$ShowOrderByDefault = $params->get( 'ShowOrderByDefault' ) ;
	$ShowOrderDefault = $params->get( 'ShowOrderDefault' ) ;
	$useTranslations222=$params->get('useTranslations','0');
	$prodMultipleCats=$params->get('prodMultipleCats','0');
	
	$menus = &JSite::getMenu();
		$menu  = $menus->getActive();	
		
		if($menu->query['view']=='region')
			{
			$menu_params = new JParameter( $menu->params );
			if($menu_params->get('localities'))
				{
				$where[] = 'p.lid IN ('.$menu_params->get('localities').')';
				}
			}
			
		if($menu->query['view']=='selection')
			{
			$menu_params = new JParameter( $menu->params );
			if($menu_params->get('types'))
				{
				$where[] = 'p.type IN ('.$menu_params->get('types').')';
				}
			}
		/*	
		if($menu->query['view']=='agents')
			{
			$menu_params = new JParameter( $menu->params );
			if($menu_params->get('aid'))
				{
				$where[] = 'p.agent_id = '.$menu_params->get('aid');
				}
			}
		*/				
		if($menu->query['view']=='favorites')
			{			
			$session =& JFactory::getSession();
			$favoritesSession = $session->get('favorites', array(), 'com_properties');
			$favorites = implode(',',$favoritesSession);	
			if($favorites)
				{			
				$where[] = 'p.id IN ('.$favorites.')';
				}else{
				$where[] = 'p.id = 0';
				}					
			}
		if(isset($menu->query['cyid']))
			{
			$cyid = $menu->query['cyid'];
			}
		if(isset($menu->query['sid']))
			{
			$sid = $menu->query['sid'];
			}
		if(isset($menu->query['lid']))
			{
			$lid = $menu->query['lid'];
			}	
		if(isset($menu->query['cid']))
			{
			$cid = $menu->query['cid'];
			}
		if(isset($menu->query['tid']))
			{
			$type = $menu->query['tid'];
			}	
		if(isset($menu->query['status']))
			{
			$status = $menu->query['status'];
			}	
	if($menu->query['view']=='location')
			{			
		if($config->sef)
			{
			require_once( JPATH_COMPONENT.DS.'helpers'.DS.'listing.php' );
			if(JRequest::getVar('cyid'))
				{				
				$cyid = ListingHelper::getID('country',JRequest::getVar('cyid'));				
				}
			if(JRequest::getVar('sid'))
				{
				$sid = ListingHelper::getID('state',JRequest::getVar('sid'));
				}
			if(JRequest::getVar('lid'))
				{
				$lid = ListingHelper::getID('locality',JRequest::getVar('lid'));
				}
			
		}else{
			$cyid = JRequest::getInt('cyid');		
			$sid = JRequest::getInt('sid');		
			$lid = JRequest::getInt('lid');			
		}
		}
			
		//print_r($menu);		
		
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
	

		
		if(isset($status))
			{
			$where[] = 'p.available = '.$status;	
			}
		
			
		if(isset($cid) and $cid>0)
			{	
			if ( $prodMultipleCats )
				{
				$sqlCategoryLeft = ' LEFT JOIN #__properties_product_category AS pc ON p.id = pc.productid '.
									'LEFT JOIN #__properties_category AS c ON c.id = pc.categoryid';				
				$where[] = 'pc.categoryid = '.$cid;
				}else{
				$sqlCategoryLeft = ' LEFT JOIN #__properties_category AS c ON c.id = p.cid ';
				$where[] = 'p.cid = '.$cid;
				}
			}else{
				$sqlCategoryLeft = ' LEFT JOIN #__properties_category AS c ON c.id = p.cid ';
				
			}			
			
		if(isset($type))
			{
			$where[] = 'p.type = '.$type;	
			}	
		
		if(isset($cyid))
			{
			$where[] = 'p.cyid = '.$cyid;	
			}	
		if(isset($sid))
			{
			$where[] = 'p.sid = '.$sid;	
			}	
		if(isset($lid))
			{
			$where[] = 'p.lid = '.$lid;	
			}		
			
					
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