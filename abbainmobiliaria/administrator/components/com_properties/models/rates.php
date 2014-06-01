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
class PropertiesModelRates extends JModel
{

function _buildQuery()
	{	
	$this->filter_order='ordering';
	if(($this->filter_order)=='ordering'){$this->filter_order='ordering';}
	
	$where = array();
	
	
	if(JRequest::getVar('productid'))
		{
		
		$this->filter_product_comment = JRequest::getVar('productid');
		$this->setState('filter_product_comment', $this->filter_product_comment);
		$where[] = 'r.productid = '.$this->filter_product_comment;
		}elseif ( $this->filter_product_comment )
		{			
				$where[] = 'r.productid = '.$this->filter_product_comment;			
		}
		
		
	
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );		
		$orderby 	= ' ORDER BY r.'. $this->filter_order .' '. $this->filter_order_Dir;
	
		//$orderby 	.= 
		$this->_query = ' SELECT r.* '					
			. ' FROM #__properties_rates AS r'			
			. $where
			. ' GROUP BY r.id '
			. $orderby
			;		

//echo str_replace('#_','jos',$this->_query);
		
        return $this->_query;
	}
	
var $_data;
var $TableName = null;	
var $_total = null;
var $_pagination = null;

function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;

$this->filter_product_comment		= $mainframe->getUserStateFromRequest( "$option.filter_product_comment",		'filter_product_comment',		'',		'int' );


		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);		
		$this->TableName = JRequest::getCmd('table');
		
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
	// state filter
	$lists['locality']	=  $this->filter_locality ;
	$lists['category']	=  $this->filter_category ;
	
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
	


	
function getRate()
	{

	$query = ' SELECT * FROM #__properties_rates WHERE id = '.$this->_id;				
	$this->_db->setQuery( $query );
	$this->_data = $this->_db->loadObject();	
	
	return $this->_data;
	
	}	
	
	
	
	
	
	function store($data,$TableName)
	{	
	$db		 =& JFactory::getDBO();	
	$row =& $this->getTable($TableName);
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());			
			
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());			
			
			return false;
		}
		
		if (!$row->id) {
		$where = "productid = " . $db->Quote($row->productid);
		$row->ordering = $row->getNextOrder( $where );
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
$TableName 	= 'rates';
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
	
	
	function deleteAjax($cids)
	{	
		
$TableName 	= 'rates';
	$row =& $this->getTable($TableName);  
  
		if (count( $cids )) {
		
			//foreach($cids as $cid) {
				if (!$row->delete( $cids )) {
					$this->setError( $row->getErrorMsg() );					
					return false;
				}				
			//}
		}
		return true;
	}
	
function getLastModif()
	{
	$TableName 	= 'rates';
		 $query = ' SELECT id FROM #__properties_'.$TableName.' ORDER BY id desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	//print_r($this->_data);
	 return $this->_data;


	}
	
		function orderItem($item, $movement)
	{
		$row =& $this->getTable('rates');
		$row->load( $item );
		if (!$row->move( $movement , ' productid = '.(int) $row->productid)) {
			$this->setError($row->getError());
			echo $row->getError();
			return false;
		}
				
		return true;
	}
		
		
		
		function setOrder($items)
	{
		$total		= count( $items );
		$row =& $this->getTable('rates');
		$groupings	= array();

		$order		= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($order);

		// update ordering values
		for( $i=0; $i < $total; $i++ ) {
			$row->load( $items[$i] );
			// track parents
			$groupings[] = $row->productid;
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					$this->setError($row->getError());
					return false;
				}
			} // if
		} // for

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder(' productid = '.(int) $group.' AND published >=0');
		}

				
		return true;
	}
	
	
}//fin clase