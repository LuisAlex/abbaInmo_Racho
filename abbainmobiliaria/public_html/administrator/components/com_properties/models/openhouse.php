<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class PropertiesModelOpenhouse extends JModel
{
	var $_data;
	var $TableName = null;	
	
function _buildQuery()
	{		
	//echo $this->filter_order;
	
		switch($this->filter_order)
			{
			case 'id' :
			$this->filter_order = 'id';
			break;
			case 'ordering' :
			$this->filter_order = 'ordering';
			break;
			case 'published' :
			$this->filter_order = 'published';
			break;			
			
			default :
			$this->filter_order = 'id';
			break;			
			}
			
		$where = array();
		
		
		if ($this->filter_cities_lastminute)
		{			
				$where[] = 'p.lid = '.$this->filter_cities_lastminute;			
		}
		
		
		if ( $this->filter_state )
		{
			if ( $this->filter_state == 'P' )
			{
				$where[] = 'oh.published = 1';
			}
			else if ($this->filter_state == 'U' )
			{
				$where[] = 'oh.published = 0';
			}
		}
		if ($this->search)
		{
			$where[] = 'LOWER(oh.name) LIKE \''. $this->search. '\'';
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY '. $this->filter_order .' '. $this->filter_order_Dir;
		
		$this->_query = ' SELECT oh.*, p.name, p.ref, p.lid '
				. ' FROM #__properties_openhouse AS oh '
				. ' LEFT JOIN #__properties_products AS p ON p.id = oh.pid'	
				. $where
				. ' GROUP BY oh.id'
				. $orderby
				;		
//echo $this->_query;
        return $this->_query;		
	}
	

var $_total = null;
var $_pagination = null;

function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;
	
	$this->filter_cities_lastminute	= $mainframe->getUserStateFromRequest( "$option.filter_cities_openhouse",	'filter_cities_openhouse',	'',	'int' );
	

		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ordering' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );		
		$this->filter_state		= $mainframe->getUserStateFromRequest( "$option.filter_state",		'filter_state',		'',		'word' );
		$this->search				= $mainframe->getUserStateFromRequest( "$option.search",			'search',			'',		'string' );
		$this->search				= JString::strtolower( $this->search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);

	$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);	
		
  }

function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;		

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
		$lists['state']	= JHTML::_('grid.state',  $this->filter_state );
		$lists['order_Dir']	= $this->filter_order_Dir;
		$lists['order']		= $this->filter_order;
		$lists['search']= $this->search;		
		return $lists;	
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
  
  
 function &getOpenhouse()
	{					
		$query = ' SELECT oh.*,p.name as property_name, p.id as property_id'
				.' FROM #__properties_openhouse as oh'
				.' LEFT JOIN #__properties_products AS p ON p.id = oh.pid'	
				.' WHERE oh.id = '.$this->_id;
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;		
		}
//	echo $query;
		return $this->_data;
	}
	
	
	
function store($data)
	{			
	$row =& $this->getTable('openhouse');
		
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

			return false;
		}
		
				
		return true;
	}

	function delete()
	{
	
	
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
$TableName 	= 'openhouse';
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



function getLastModif()
	{
	$TableName 	= 'openhouse';
		 $query = ' SELECT id FROM #__properties_'.$TableName.' ORDER BY id desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	//print_r($this->_data);
	 return $this->_data;


	}
	
	
}