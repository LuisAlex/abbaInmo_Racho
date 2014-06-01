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
class PropertiesModelProfiles extends JModel
{
	var $_data;
	var $TableName = null;	
	
function _buildQuery()
	{
if(($this->filter_order)=='title'){$this->filter_order='pf.name';}
if(($this->filter_order)=='cyid'){$this->filter_order='pf.name';}			
if(($this->filter_order)=='published'){$this->filter_order='t.published';}	
if(($this->filter_order)=='ordering'){$this->filter_order='pf.ordering';}	
if(($this->filter_order)=='name'){$this->filter_order='pf.name';}	
if(($this->filter_order)=='parent'){$this->filter_order='pf.parent';}	
if(($this->filter_order)=='id'){$this->filter_order='pf.id';}	
if(($this->filter_order)=='published'){$this->filter_order='pf.published';}	

		$where = array();
		
		
		if ($this->search)
		{
			$where[] = 'LOWER(pf.name) LIKE \''. $this->search. '\'';
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY '. $this->filter_order .' '. $this->filter_order_Dir;
		
		$this->_query = ' SELECT pf.*,u.name as name_user '
				. ' FROM #__properties_profiles AS pf '
				. ' INNER JOIN #__users AS u ON u.id = pf.mid'		
				. $where
				. ' GROUP BY pf.id'
				. $orderby
				;		
		
        return $this->_query;		
	}
	

var $_total = null;
var $_pagination = null;

function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;

		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ordering' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );			

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

		//$lists['state']	= JHTML::_('grid.state',  $this->filter_state );
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
	



 
 function &getProfile()
	{					
		$query = ' SELECT * FROM #__properties_profiles '.
					'  WHERE id = '.$this->_id;
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		
		if (!$this->_data) {
			$this->_data = new stdClass();
	$this->_data->cid = null;
	$this->_data->id = null;
	$this->_data->mid = null;
	$this->_data->name = null;
	$this->_data->alias = null;
	$this->_data->company = null;
	$this->_data->type = null;
	$this->_data->info = null;
	$this->_data->bio = null;
	$this->_data->properties = null;
	$this->_data->address1 = null;
	$this->_data->address2 = null;
	$this->_data->locality = null;
	$this->_data->pcode = null;
	$this->_data->state = null;
	$this->_data->country = null;
	$this->_data->show = null;
	$this->_data->email = null;
	$this->_data->phone = null;
	$this->_data->fax = null;
	$this->_data->mobile = null;
	$this->_data->skype = null;
	$this->_data->ymsgr = null;
	$this->_data->icq = null;
	$this->_data->web = null;
	$this->_data->blog = null;
	$this->_data->image = null;
	$this->_data->logo_image = null;
	$this->_data->logo_image_large = null;
	$this->_data->published = null;
	$this->_data->ordering = null;
	$this->_data->checked_out = null;
	$this->_data->checked_out_time = null; 	
		}
	//echo $query;
		return $this->_data;
	}
 
 
 
 
 
 	function store($data)
	{			
	$row =& $this->getTable('profiles');
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());			
			echo $this->_db->getErrorMsg();
			return false;
		}
		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());			
			echo $this->_db->getErrorMsg();
			return false;
		}
		
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );
echo $this->_db->getErrorMsg();
			return false;
		}
		
		if($TableName=='profiles'){
	//	$this->Notification();	
		}
		
		return true;
	}

	function delete()
	{
	
	
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
$TableName 	= 'profiles';
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
	$TableName 	= 'profiles';
		 $query = ' SELECT id FROM #__properties_'.$TableName.' ORDER BY id desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	//print_r($this->_data);
	 return $this->_data;


	}

 
  
}