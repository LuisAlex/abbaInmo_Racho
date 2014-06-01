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

jimport( 'joomla.application.component.model' );
class PropertiesModelBookings extends JModel
{
	var $_data;
	var $TableName = null;	
	var $_total = null;
	var $_pagination = null;
function _buildQuery()
	{
	
if(($this->filter_order)=='name'){$this->filter_order='ob.name';}	
if(($this->filter_order)=='parent'){$this->filter_order='s.parent';}	
if(($this->filter_order)=='id'){$this->filter_order='ob.ob_id';}	
if(($this->filter_order)=='published'){$this->filter_order='s.published';}	

if(!$this->filter_order) { $this->filter_order='ob.ob_id_property'; }
		$where = array();
		if ( $this->filter_state )
		{
			if ( $this->filter_state == 'P' )
			{
				$where[] = 's.published = 1';
			}
			else if ($this->filter_state == 'U' )
			{
				$where[] = 's.published = 0';
			}
		}				
		
		if ($this->filter_cities_b)
		{			
				$where[] = 'p.lid = '.$this->filter_cities_b;			
		}		
		
		
		if ($this->filter_property_b)
		{			
				$where[] = 'p.id = '.$this->filter_property_b;			
		}
		
		if ($this->filter_period_b)
		{			
				$where[] = 'ob.ob_from = \''.$this->filter_period_b.'\'';			
		}
				
		
		if ($this->search)
		{
			$where[] = 'LOWER(s.name) LIKE \''. $this->search. '\'';
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY '. $this->filter_order .' '. $this->filter_order_Dir;
		
		$this->_query = 'SELECT ob.*, p.* '
				. ' FROM #__properties_bookings AS ob '					
				. ' LEFT JOIN #__properties_products AS p ON p.id = ob.ob_id_property'					
				. $where
				. ' GROUP BY ob.ob_id_order'
				. $orderby
				;		
  
 
   
   
   
        return $this->_query;		
	}
	



function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;

		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ob_id_property' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );
		$this->filter_agency		= $mainframe->getUserStateFromRequest( "$option.filter_agency",		'filter_agency',		'',		'int' );
		$this->filter_residence_b		= $mainframe->getUserStateFromRequest( "$option.filter_residence_b",		'filter_residence_b',		'',		'int' );
		$this->filter_property_b		= $mainframe->getUserStateFromRequest( "$option.filter_property_b",		'filter_property_b',		'',		'int' );
		$this->filter_cities_b		= $mainframe->getUserStateFromRequest( "$option.filter_cities_b",		'filter_cities_b',		'',		'int' );
		
		$this->filter_period_b		= $mainframe->getUserStateFromRequest( "$option.filter_period_b",		'filter_period_b',		'',		'date' );
		
		$this->filter_partenza_b		= $mainframe->getUserStateFromRequest( "$option.filter_partenza_b",		'filter_partenza_b',		'',		'date' );
		
		$this->filter_confirmed_b		= $mainframe->getUserStateFromRequest( "$option.filter_confirmed_b",		'filter_confirmed_b',		'',		'int' );
		
		
		
		$this->filter_state		= $mainframe->getUserStateFromRequest( "$option.filter_state",		'filter_state',		'',		'word' );
		$this->search				= $mainframe->getUserStateFromRequest( "$option.search",			'search',			'',		'string' );
		$this->search				= JString::strtolower( $this->search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);


  }

function getData() 
	{
 	if (empty($this->_data)) {
		$query = $this->_buildQuery();
 	    $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
	}
	return $this->_data;
  }	

function getList()
	{
	// state filter
	//$lists['category']	=  $this->filter_category ;
	
		$lists['state']	= JHTML::_('grid.state',  $this->filter_state );

		// table ordering
		$lists['order_Dir']	= $this->filter_order_Dir;
		$lists['order']		= $this->filter_order;

		// search filter
		$lists['search']= $this->search;
		
		return $lists;
	
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
 	    jimport('joomla.html.pagination');
 	    $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
 	}
 	return $this->_pagination;
  }

function getOrder()
	{
	
	$array = JRequest::getVar('cid',  0, '', 'array');
		$this->Id=((int)$array[0]);
	$query = ' SELECT ob.*,p.name as property_name ,p.ref as property_ref, p.id as property_id '
				. ' FROM #__properties_bookings AS ob '				
				. ' LEFT JOIN #__properties_products AS p ON p.id = ob.ob_id_property'											
				. ' WHERE ob.ob_id_order = '.$this->Id;				
				;		
	$this->_db->setQuery( $query );
	$this->_data = $this->_db->loadObject();
	//echo $query;
	return $this->_data;
	
	}
  
  
  	function store($data)
	{	
		$TableName = 'bookings';
	$row =& $this->getTable($TableName);

print_r($data);
if($data==''){		$data = JRequest::get( 'post' );}
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			
			
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			
			
			return false;
		}
		
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );
			echo $this->_db->getErrorMsg();
			return false;
		}
		
		return true;
	}
	
	
	function delete()
	{
	
	
	$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	$TableName 	= 'bookings';
	$row =& $this->getTable($TableName);

  
  
		if (count( $cids )) {
			foreach($cids as $cid) {
			
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );					
					return false;
				}	
							
			}
		}
		return true;
	}
	
	
	
	function store_available_product($data,$TableName)
	{	
		
	$row =& $this->getTable($TableName);
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			
			
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			
			
			return false;
		}
		
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );
			echo $this->_db->getErrorMsg();
			return false;
		}
		
		return true;
	}
	
	
	function getLastSaved()
		{
		$TableName 	= 'bookings';
		 $query = ' SELECT ob_id_order FROM #__properties_'.$TableName.' ORDER BY ob_id_order desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	print_r($this->_data);
	 return $this->_data;
		}
	
}//fin clase