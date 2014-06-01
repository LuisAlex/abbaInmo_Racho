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
class PropertiesModelCategories extends JModel
{
	var $_data;
	var $TableName = null;	
	var $_total = null;
	var $_pagination = null;

	function _buildQuery()
		{
		switch($this->filter_order)
			{
			case 'name' :
			$this->filter_order='name';
			break;
			case 'ordering' :
			$this->filter_order='ordering';
			break;
			case 'id' :
			$this->filter_order='id';
			break;
			default:
			$this->filter_order='ordering';
			break;
			}
			$where = array();

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );			
		
		$orderby 	= ' ORDER BY c.'. $this->filter_order .' '. $this->filter_order_Dir;
				
		$this->_query = ' SELECT c.*, g.name AS groupname'
				. ' FROM #__properties_category AS c '
				. ' LEFT JOIN #__groups AS g ON g.id = c.access' 
				. $where
				//. ' GROUP BY t.id_categoria'
				. $orderby
				;				
		
        return $this->_query;		
	}
	



function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;
	$this->filter_order		= null;
		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ordering' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );
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
	//$lists['category']	=  $this->filter_category ;	
	//	$lists['state']	= JHTML::_('grid.state',  $this->filter_state );
		$lists['order_Dir']	= $this->filter_order_Dir;
		$lists['order']		= $this->filter_order;
	//	$lists['search']= $this->search;		
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
	
	
 function &getCategory()	
	{					
		$query = ' SELECT * FROM #__properties_category '.
					'  WHERE id = '.$this->_id;
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->name = '';	
			$this->_data->alias = '';
			$this->_data->published = 1;	
			$this->_data->ordering = '';
		}
	
		return $this->_data;
	}
  
 	function store($data)
	{			
	$row =& $this->getTable('category');
	$db		 =& JFactory::getDBO();	
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());			
			
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());			
			
			return false;
		}
		
		if (!$row->id) {		
		$row->ordering = $row->getNextOrder();
		}
		
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );

			return false;
		}
		
		if($TableName=='profiles'){
		$this->Notification();	
		}
		
		return true;
	}

	function delete()
	{
	
	
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
$TableName 	= 'category';
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

function orderItem($item, $movement)
	{
		$row =& $this->getTable('category');
		$row->load( $item );
		if (!$row->move( $movement , ' parent = '.(int) $row->parent)) {
			$this->setError($row->getError());
			return false;
		}
		//JError::raiseError(500, $movement  .'id = '.$item );
		// clean cache
	
		
		return true;
	}

function getLastModif()
	{
	$TableName 	= 'category';
		 $query = ' SELECT id FROM #__properties_'.$TableName.' ORDER BY id desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	//print_r($this->_data);
	 return $this->_data;


	}

 
  
}