<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );

class PropertiesModelPanel extends JModel
{
	var $_data;
	var $TableName = null;	
	var $_total = null;
	var $_pagination = null;

	function __construct()
  	{
 	parent::__construct();
	global $mainframe, $option;
	$cids = JRequest::getVar('cid',  0, '', 'array');
	$this->setId((int)$cids[0]);
	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$this->AmountPanel = $params->get( 'AmountPanel' ) ;

	$this->filter_order		= null;
		$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	'ordering' ,	'cmd' );
		$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'',		'word' );
		$this->filter_country		= $mainframe->getUserStateFromRequest( "$option.filter_country",		'filter_country',		'',		'int' );
		$this->filter_sid		= $mainframe->getUserStateFromRequest( "$option.filter_sid",		'filter_sid',		'',		'int' );
		$this->filter_locality		= $mainframe->getUserStateFromRequest( "$option.filter_locality",		'filter_locality',		'',		'int' );		
		$this->filter_category		= $mainframe->getUserStateFromRequest( "$option.filter_category",		'filter_category',		'',		'int' );
		$this->filter_type= $mainframe->getUserStateFromRequest( "$option.filter_type",		'filter_type',		'',		'int' );
		$this->filter_featured= $mainframe->getUserStateFromRequest( "$option.filter_featured",		'filter_featured',		'',		'int' );
		$this->filter_state		= $mainframe->getUserStateFromRequest( "$option.filter_state",		'filter_state',		'',		'word' );
		$this->search				= $mainframe->getUserStateFromRequest( "$option.search",			'search',			'',		'string' );
		$this->search				= JString::strtolower( $this->search );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	/*
	$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);
*/
	$limit=JRequest::getVar('limit',  10, '', 'int');
	$limitstart=JRequest::getVar('limitstart',  0, '', 'int');
	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);		
	}
  
    function setId($id)
	{
		$this->_id		= $id;		
	}

	function _buildQueryPanel()
	{	
 	$user =& JFactory::getUser();	
	//$this->filter_order='id';	
	switch($this->filter_order)
			{
			case 'name' :
			$this->filter_order='p.name';
			break;
			case 'ref' :
			$this->filter_order='p.ref';
			break;
			case 'cyid' :
			$this->filter_order='name_country';
			break;
			case 'sid' :
			$this->filter_order='name_state';
			break;
			case 'lid' :
			$this->filter_order='name_locality';
			break;
			case 'cid' :
			$this->filter_order='name_category';
			break;
			case 'type' :
			$this->filter_order='name_type';
			break;
			case 'hits' :
			$this->filter_order='p.hits';
			break;
			case 'ordering' :
			$this->filter_order='p.ordering';
			break;
			case 'id' :
			$this->filter_order='p.id';
			break;
			default:
			$this->filter_order='p.ordering';
			break;
			}
		$where = array();
		if ( $this->filter_category )
		{			
				$where[] = 'r.cid = '.$this->filter_category;			
		}
		if ( $this->filter_type )
		{			
				$where[] = 'r.type = '.$this->filter_type;			
		}
		if ( $this->filter_country)
		{			
				$where[] = 'r.cyid = '.$this->filter_country;			
		}
		if ( $this->filter_sid )
		{			
				$where[] = 'r.sid = '.$this->filter_sid;			
		}
		if ( $this->filter_locality )
		{			
				$where[] = 'r.lid = '.$this->filter_locality;			
		}
		if ( $this->filter_featured )
		{			
			if ( $this->filter_featured == 1 )
			{
				$where[] = 'r.featured = 1';
			}
			else if ($this->filter_featured == 9 )
			{
				$where[] = 'r.featured = 0';
			}			
						
		}
		
		if ( $this->filter_state )
		{
			if ( $this->filter_state == 'P' )
			{
				$where[] = 'p.published = 1';
			}
			else if ($this->filter_state == 'U' )
			{
				$where[] = 'p.published = 0';
			}
		}
		if ($this->search)
		{
			$where[] = 'LOWER(p.name) LIKE \''. $this->search. '\'';
		}

		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		$orderby 	= ' ORDER BY '. $this->filter_order .' '. $this->filter_order_Dir;
		
		
		
		
			$this->_query = ' SELECT p.*,c.name as name_category,cy.name as name_country,s.name as name_state,l.name as name_locality,pf.name as name_profile,pf.logo_image as logo_image_profile, t.name as name_type, '
		. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as Pslug,'
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as Cslug,'
		. ' CASE WHEN CHAR_LENGTH(cy.alias) THEN CONCAT_WS(":", cy.id, cy.alias) ELSE cy.id END as CYslug,'
		. ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as Sdslug,'		
		. ' CASE WHEN CHAR_LENGTH(l.alias) THEN CONCAT_WS(":", l.id, l.alias) ELSE l.id END as Lslug '				
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_profiles AS pf ON pf.mid = p.agent_id '				
				. ' WHERE p.published != -2 '	
				. ' AND p.agent_id = '.$user->id
			. $where
			. ' GROUP BY p.id'
			. $orderby
			;				
					
//echo str_replace('#_','jos',$this->_query);
        return $this->_query;		
}



	function getList()
	{
	$lists['country']	=  $this->filter_country ;	
	$lists['category']	=  $this->filter_category ;
	$lists['sid']	=  $this->filter_sid ;
	$lists['locality']	=  $this->filter_locality ;
	$lists['type']	=  $this->filter_type ;
	$lists['featured']	=  $this->filter_featured ;
		$lists['state']	= JHTML::_('grid.state',  $this->filter_state );
		$lists['order_Dir']	= $this->filter_order_Dir;
		$lists['order']		= $this->filter_order;
		$lists['search']= $this->search;		
		return $lists;	
	}
	

	function getProductEdit() 
		{		
		$user =& JFactory::getUser();
		$query = ' SELECT p.*,c.name as name_category,cy.name as name_country,s.name as name_state,l.name as name_locality,t.name as name_type,pf.type as type_profile, '
		. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as Pslug,'
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as Cslug,'
		. ' CASE WHEN CHAR_LENGTH(cy.alias) THEN CONCAT_WS(":", cy.id, cy.alias) ELSE cy.id END as CYslug,'
		. ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as Sdslug,'		
		. ' CASE WHEN CHAR_LENGTH(l.alias) THEN CONCAT_WS(":", l.id, l.alias) ELSE l.id END as Lslug '				
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_category AS c ON c.id = p.parent '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_profiles AS pf ON pf.mid = p.agent_id '	
				. ' WHERE p.published != -2 '					
				. ' AND p.id = '.$this->_id
				. ' AND p.agent_id = '.$user->id;
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			//echo '$this->_id; '.$this->_id;
			//echo str_replace('#_','jos',$query);
			
			return $this->_data;
		}

	function getDataAgent() 
	{  
	$user =& JFactory::getUser();
	$query = 'SELECT * FROM #__properties_profiles ' .
			' WHERE mid = '.$user->id;
				
		$this->_db->setQuery( $query );
		$agent = $this->_db->loadObject();		
		return $agent;
  }

function getDataPanel() 
  {    
  $querysl = $this->_buildQueryPanel();
	$this->_db->setQuery( $querysl );	
	$this->_data = $this->_getList($querysl, $this->getState('limitstart'), $this->getState('limit'));	
	return $this->_data;
  }
  
 function getTotalPanel()
  { 	
	$querysl = $this->_buildQueryPanel();			
 	    $this->_total = $this->_getListCount($querysl);
		//$this->setTotalProducts($this->_total);
 	return $this->_total;
  }
  
  function getTotalProducts()
  	{	
	return $this->_total;
	}
	
 function getPaginationPanel()
  {
 	if (empty($this->_pagination)) {
 	       require_once( JPATH_COMPONENT.DS.'helpers'.DS.'pagination.php' );
		$this->_pagination = new JPaginationPanel($this->getTotalPanel(), $this->getState('limitstart'), $this->getState('limit') );		
 	}
 	return $this->_pagination;
  } 
  
  
  
  
  
  
  
  
  
  function store($data)
	{	
	JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');
	$row =& JTable::getInstance('products', 'Table');
		if (!$row->bind($data)) {
			 $this->setError( $this->_db->getErrorMsg() );
			return false;
		}		
		if (!$row->check()) {
			$this->setError( $this->_db->getErrorMsg() );			
			return false;
		}
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		return true;
	}
	
	function getLastModif()
		{	
		$query = ' SELECT id FROM #__properties_products ORDER BY id desc LIMIT 1';
		$this->_db->setQuery( $query );	
		$_data = $this->_db->loadResult();
		return $_data;
		}
	
	
	
	
	function storeProductCategory($data,$lastId)
		{	
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'tables');

		$row =& JTable::getInstance('product_category', 'Table');
		$db		=& JFactory::getDBO();

		if($data==''){		$data = JRequest::get( 'post' );}
		if($data['id'] == 0){$data['id']=$lastId;}

		
		$selections = JRequest::getVar( 'selections', array(), 'post', 'array' );
		JArrayHelper::toInteger($selections);

		$query = 'DELETE FROM #__properties_product_category '
		. ' WHERE productid = '.(int) $data['id']
		;
		
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}	
		if ( $selections[0] == 0 ) {
			$query = 'INSERT INTO #__properties_product_category'
			. ' SET productid = '.(int) $data['id'].' , categoryid = '.$data['cid']
			;		
			
			$contenido .= "\n".(int) $data['id'].' , categoryid = '.$data['cid'];			
			
					$db->setQuery( $query );
					if (!$db->query()) {
						return JError::raiseWarning( 500, $db->getError() );
					}
		}
		else
		{
			foreach ($selections as $menuid)
			{
				if ( (int) $menuid >= 0 ) {					
					$query = 'INSERT INTO #__properties_product_category'
					. ' SET productid = '.(int) $data['id'] .', categoryid = '.(int) $menuid
					;
					$db->setQuery( $query );
					if (!$db->query()) {
						return JError::raiseWarning( 500, $db->getError() );
					}
				}
			}
		}
		return true;
	}
	
	
	function delete()
	{
	
	$user =& JFactory::getUser();
	$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
	$row =& $this->getTable('products');  
  
		if (count( $cids )) {
			foreach($cids as $cid) {				
				
				$query = 'SELECT * FROM #__properties_products' .
				' WHERE id = '.$cid;
				' AND agent_id = '.$user->id;
			$this->_db->setQuery( $query );
			$delete_data = $this->_db->loadObject();
			
			$id = $delete_data->id;	
			
			//JError::raiseError(500, $id );
			
		if ( 0 < $id )
        	{
		$row->load($id);	
		if($row->agent_id != $user->id)
			{
			JError::raiseError(500, $id );
			}
		
		$row->published = -2;
		if (!$row->check()) {
			JError::raiseError( 500, $row->getError() );
			return false;
		}

		if (!$row->store()) {
			JError::raiseError( 500, $row->getError() );
			return false;
		}
		
		//print_r($row);	
		//require('nada.php');		
			
			}

							
			}
		}
		return true;
	}
	
	
	
}//fin clase