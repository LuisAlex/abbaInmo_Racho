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
class PropertiesModelPdfs extends JModel
{
	var $_data;
	var $TableName = null;	
	var $_total = null;
	var $_pagination = null;

function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;

		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ordering' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );
		$this->filter_category		= $mainframe->getUserStateFromRequest( "$option.filter_category",		'filter_category',		'',		'int' );	
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
	
	

  
function _buildQuery()
	{
		$component_name = 'properties';	
if(($this->filter_order)=='title'){$this->filter_order='name';}
if(($this->filter_order)=='name'){$this->filter_order='name';}	
if(($this->filter_order)=='id'){$this->filter_order='id';}
if(($this->filter_order)=='published'){$this->filter_order='published';}
if(($this->filter_order)=='ordering'){$this->filter_order='ordering';}
		$where = array();
		
		
		
		if ( $this->filter_state )
		{
			if ( $this->filter_state == 'P' )
			{
				$where[] = 'pdf.published = 1';
			}
			else if ($this->filter_state == 'U' )
			{
				$where[] = 'pdf.published = 0';
			}
		}
		if ($this->search)
		{
			$where[] = 'LOWER(p.name) LIKE \''. $this->search. '\'';
		}
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY pdf.'. $this->filter_order .' '. $this->filter_order_Dir;		
		$this->_query = ' SELECT pdf.* ,p.name AS parent_name '
				. ' FROM #__'.$component_name.'_pdfs AS pdf '
				. ' LEFT JOIN #__'.$component_name.'_products AS p ON p.id = pdf.parent '				
				. $where
				. ' GROUP BY pdf.id'
				. $orderby
				;				

        return $this->_query;		
	}

function &getPdf()
	{					
		$component_name = 'properties';	
		$query = ' SELECT pdf.* ,p.name AS parent_name '
				. ' FROM #__'.$component_name.'_pdfs AS pdf '
				. ' LEFT JOIN #__'.$component_name.'_products AS p ON p.id = pdf.parent '
				. '  WHERE pdf.id = '.$this->_id;
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;		
		}
	//echo $query;
		return $this->_data;
	}



function getList()
	{
	// state filter
	$lists['country']	=  $this->filter_country ;	
		$lists['state']	= JHTML::_('grid.state',  $this->filter_state );
		// table ordering
		$lists['order_Dir']	= $this->filter_order_Dir;
		$lists['order']		= $this->filter_order;
		// search filter
		$lists['search']= $this->search;		
		return $lists;	
	}

function getData() 
  {
 	// if data hasn't already been obtained, load it
 	if (empty($this->_data)) {
 	    $query = $this->_buildQuery();
 	    $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));	
 	}
	print_r($this_data);
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
 	    jimport('joomla.html.pagination');
 	    $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
 	}
 	return $this->_pagination;
  }
					
	function orderItem($item, $movement)
	{
		$row =& $this->getTable('pdfs');
		$row->load( $item );
		if (!$row->move( $movement)) {
			$this->setError($row->getError());
			return false;
		}		
		return true;
	}
	
	
	function store($data)
	{			
	$row =& $this->getTable('pdfs');
	if($data==''){$data = JRequest::get( 'post' );}
	$db		 =& JFactory::getDBO();	
	
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
		//	JError::raiseError(500, $this->_db->getErrorMsg() );
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
		//	JError::raiseError(500, $this->_db->getErrorMsg() );
			return false;
		}
		
		if (!$row->id) {
		$where = "parent = " . $db->Quote($row->parent);
		$row->ordering = $row->getNextOrder( $where );
	}
		
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );
			//JError::raiseError(500, $this->_db->getErrorMsg() );
			return false;
		}
		//JError::raiseError(500, $this->setError($this->_db->getErrorMsg()) );
		return true;
	}
	
	function delete()
	{
	
	$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	$row =& $this->getTable('pdfs');
	if (count( $cids )) 
		{
		foreach($cids as $cid) 
			{
			
			if (!$row->load($cid)) 
				{
    			return JError::raiseWarning( 500, $row->getError() );
				}else{
			//print_r($row);require('a');
			
				if (!$row->delete( $cid )) 
					{
					$this->setError( $row->getErrorMsg() );					
					return false;
					}else{
					jimport('joomla.filesystem.file');
					$filename = JPATH_SITE.DS.'images'.DS.'properties'.DS.'pdfs'.DS.$row->parent.DS.$row->archivo;
					JFile::delete($filename);
					}
				}	
			}
		}	
	return true;
	}
	
}//fin clase