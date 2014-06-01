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
class PropertiesModelAvailables extends JModel
{

function _buildQuery()
	{	
	$TableName 	= JRequest::getVar('table');

		//$orderby 	.= 
		$this->_query = ' SELECT p.* '					
			. ' FROM #__properties_available_product AS p'			
			//. $where
			. ' GROUP BY p.id '
			//. $orderby
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
	
function getPrices() 
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
	

  
  function getAvailable()
	{

	$query = ' SELECT * FROM #__properties_available_product ';				
	$this->_db->setQuery( $query );
	$this->_data = $this->_getList($query);	
	return $this->_data;
	
	}
	
function getAvailableProduct()
	{
$this->id_product=JRequest::getVar('id_product' );
	$query = ' SELECT * FROM #__properties_available_product WHERE id_product = '.$this->id_product;				
	$this->_db->setQuery( $query );
	$this->_data = $this->_getList($query);	
	return $this->_data;
	
	}	
	
	
	
	
	
	function store($data,$TableName)
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

			return false;
		}
		
		return true;
	}
	
	
}//fin clase