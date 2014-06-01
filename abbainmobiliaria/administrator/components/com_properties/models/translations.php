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
class PropertiesModelTranslations extends JModel
{
	var $_data;
	var $_total = null;
	var $_pagination = null;
	
function _buildQuery()
	{
		switch($this->filter_order)
			{
			case 'name' :
			$this->filter_order='name';
			break;			
			case 'id' :
			$this->filter_order='id';
			break;
			default:
			$this->filter_order='id';
			break;
			}

		$where = array();		
		
		if ( $this->filter_state )
		{
			if ( $this->filter_state == 'P' )
			{
				$where[] = 'r.t_published = 1';
			}
			else if ($this->filter_state == 'U' )
			{
				$where[] = 'r.t_published = 0';
			}
		}
		
		
		if ( $this->filter_translation_tables )
		{			
				//$where[] = 'r.t_table = \''.$this->filter_translation_tables.'\'';			
		}
		if ( $this->filter_translation_language )
		{			
				//$where[] = 'r.t_languagecode = \''.$this->filter_translation_language.'\'';			
		}
		

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY a.'. $this->filter_order .' '. $this->filter_order_Dir;
		
		$table = '#__properties_'.$this->filter_translation_tables;		
					
		$this->_query = ' SELECT a.*,t.* '	
			. ' FROM '.$table.' AS a'
			
			. ' LEFT JOIN #__properties_translations AS t ON t.t_fieldid = a.id AND t.t_table = "'.$this->filter_translation_tables.'" AND t.t_languagecode = "'.$this->filter_translation_language.'"'
			
			//. ' LEFT JOIN #__languages AS l ON l.lang_code = t.t_languagecode '
			
			. $where

			. $orderby
			;	
//echo str_replace('#_','jos',$this->_query);
		
        return $this->_query;		
	}
	



function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;
$this->filter_order		= null;

		$this->filter_translation_language		= $mainframe->getUserStateFromRequest( "$option.filter_translation_language",'filter_translation_language','' ,'cmd' );
		$this->filter_translation_tables		= $mainframe->getUserStateFromRequest( "$option.filter_translation_tables",'filter_translation_tables','country' ,'cmd' );
		
		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'name' ,	'cmd' );
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
	$lists['country']	=  $this->filter_country ;	
	$lists['category']	=  $this->filter_category ;
	$lists['sid']	=  $this->filter_sid ;
	$lists['locality']	=  $this->filter_locality ;
	$lists['type']	=  $this->filter_type ;
	$lists['featured']	=  $this->filter_featured ;
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




 function &getTranslation()
	{		
	$query = ' SELECT r.* '	
			. ' FROM #__properties_translations AS r'
			. ' WHERE r.t_id = '.$this->_id;	
	/*$query = ' SELECT r.* ,'
			.'  t.name AS name_category, ty.name as name_type, '
			.' s.name AS name_state, l.name AS name_locality, y.name AS name_country '			
			. ' FROM #__properties_products AS r'
			. ' LEFT JOIN #__properties_category AS t ON t.id = r.cid'	
			. ' LEFT JOIN #__properties_type AS ty ON ty.id = r.type'	
			. ' LEFT JOIN #__properties_locality AS l ON l.id = r.lid'
			. ' LEFT JOIN #__properties_state AS s ON s.id = r.sid '
			. ' LEFT JOIN #__properties_country AS y ON y.id = s.parent '
			. ' WHERE r.id = '.$this->_id;	*/		

			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;		
		}
	//echo $query;
		return $this->_data;
	}


 
 	function store($data)
	{			
	$row =& $this->getTable('translations');

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
	
	$user =& JFactory::getUser();
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	$TableName 	= 'translations';
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
	$TableName 	= 'translations';
		 $query = ' SELECT t_id FROM #__properties_'.$TableName.' ORDER BY t_id desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	//print_r($this->_data);
	 return $this->_data;
	}
	


}