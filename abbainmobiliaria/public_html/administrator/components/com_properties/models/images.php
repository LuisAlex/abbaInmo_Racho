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
class PropertiesModelImages extends JModel
{
	var $_id = null;	
	var $_data = null;	
	function __construct()
	{
		parent::__construct();
	global $mainframe, $option;
$this->filter_order		= null;
		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ordering' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );
			
		$this->filter_category		= $mainframe->getUserStateFromRequest( "$option.filter_category",		'filter_category',		'',		'int' );
		
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




function _buildQuery()
	{
		
			if ( $this->filter_state )
		{
			if ( $this->filter_state == 'P' )
			{
				$where[] = 'i.published = 1';
			}
			else if ($this->filter_state == 'U' )
			{
				$where[] = 'i.published = 0';
			}
		}
		if ($this->search)
		{
			$where[] = 'LOWER(r.name) LIKE \''. $this->search. '\'';
		}
		
		
		if($this->filter_product){
		$where[] = 'i.parent = '.$this->filter_product;
		}elseif(JRequest::getVar('product_id')){
		$where[] = 'i.parent = '.JRequest::getVar('product_id');
		$this->filter_product = JRequest::getVar('product_id');
		$this->setState('filter_product', $this->filter_product);
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY i.'. $this->filter_order .' '. $this->filter_order_Dir;
		
		
		$this->_query = 'SELECT i.* '
			         .' FROM #__properties_images AS i'					
					 .' LEFT JOIN #__properties_products as p ON p.id = i.parent '	
					 . $where
					. ' GROUP BY i.id'
					. $orderby									 
					 ;	
	//	echo str_replace('#_','jos',$this->_query);
		 return $this->_query;
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
	
	$lists['category']	=  $this->filter_category ;	
		$lists['state']	= JHTML::_('grid.state',  $this->filter_state );		
		$lists['order_Dir']	= $this->filter_order_Dir;
		$lists['order']		= $this->filter_order;		
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
 	    $this->_pagination = new JPagination($this->getTotal(), 0, 100 );
 	}
 	return $this->_pagination;
  }

  
  
  	function orderItem($item, $movement)
	{
		$row =& $this->getTable('images');
		$row->load( $item );
		if (!$row->move( $movement , ' parent = '.(int) $row->parent)) {
			$this->setError($row->getError());
			return false;
		}
		//JError::raiseError(500, $movement  .'id = '.$item );
		// clean cache
	
		
		return true;
	}
  
  
  
  
  
  
  
  
  
  
  	
	

	function getImages()
	{	
	global $mainframe;				 
					 
			$query = 'SELECT i.* '
			         .' FROM #__product_images AS i'					
					 .' LEFT JOIN #__product_products as c ON c.id = i.parent '									 
					// .' WHERE i.product_id = '.$Productoid
					// .' AND d.parent = cd.id '				 
					 ;			 
					 		
			$this->_db->setQuery( $query );
			$this->_data = $this->_getList($query);
		//	echo str_replace('#_','jos',$query);
		return $this->_data;	
	}
		

		


function store($data)
	{	
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');
		$row =& JTable::getInstance('images', 'Table');
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
		$where = "parent = " . $db->Quote($row->parent);
		$row->ordering = $row->getNextOrder( $where );
		}
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}



		









	function delete()
	{
	
	$user =& JFactory::getUser();
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	$TableName 	= 'images';
	$row =& $this->getTable($TableName);

  
  
		if (count( $cids )) {
		
			foreach($cids as $cid) {
				

			
		
			
		
			if ( 0 < $cid )
        	{
			$this->deleteImagesProperty($cid,$TableName);
			
			
			}		
						
			
			if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );					
					return false;
				}	
				
	
	
	
	
			//require('nada.php');
							
			}
		}
		return true;
	}




function deleteImagesProperty($imageid,$TableName)
	{
	
	jimport('joomla.filesystem.file');
	
	$query = 'SELECT * FROM #__properties_images' .
				' WHERE id = '.$imageid;
				//' AND agent_id = '.$user->id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

				
	$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$this->_data->parent.DS;
	$destino_peque = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.'thumbs'.DS.$this->_data->parent.DS;
	
	JFile::delete($destino_imagen.$this->_data->name);
	JFile::delete($destino_peque.$this->_data->name);


	return true;
	}
	
	
	
	
	
	
	
			
function deleteimg()
	{
			$campo =  'image'.JRequest::getVar('borrar');
			echo 'zbrZcampo : '.$campo;
		echo '<br>id:'.JRequest::getVar('id');
		
$Tabla 	= JRequest::getVar('Tabla');
	$row =& $this->getTable($Tabla);  
$dataimg['id']=  JRequest::getVar('id');
$dataimg[$campo]=  '';
if (!$row->bind( $dataimg )) {
        $this->setError($this->_db->getErrorMsg());
			return false;
}

if (!$row->store()) {
        $this->setError($this->_db->getErrorMsg());
			return false;
}
print_r($dataimg);
echo 'supuestamente borrada la imagen';		

		
		return true;
	}
	
	
	function getLastModif()
	{
	$TableName 	= 'images';
		 $query = ' SELECT id FROM #__properties_'.$TableName.' ORDER BY id desc LIMIT 1';
	 $this->_db->setQuery( $query );	
			$this->_data = $this->_db->loadResult();
	
	//print_r($this->_data);
	 return $this->_data;


	}
		
}//fin clase