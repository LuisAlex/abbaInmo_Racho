<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class PropertiesControllerOpenhouse extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask('save2new',		'save');
		$this->registerTask( 'unpublish', 	'publish');				

		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));

		if(JRequest::getCmd('task') == 'orderup'){
		$this->orderSection( $this->cid[0], -1);
		}elseif(JRequest::getCmd('task') == 'orderdown'){
		$this->orderSection( $this->cid[0], 1);
		}		
	}		

function publish()
	{	
	$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
	$this->publish	= ( $this->getTask() == 'publish' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $publish ? 'publish' : 'unpublish';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		
		$query = 'UPDATE #__properties_openhouse'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'		
		;    
		
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&view=openhouse';
		$this->setRedirect($link, $msg);		
	}



	
		
	function saveorder(  )
	{		
		$this->TableName = JRequest::getVar('table');
	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );	
	JArrayHelper::toInteger($cid, array(0));
	//$this->cids = implode( ',', $cid );
	$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );
	//$itemid		= JRequest::getVar( 'itemid', array(0), 'post', 'array' );
	foreach($cid as $cids=>$c){
	$query = 'UPDATE #__properties_openhouse'
		. ' SET ordering = \'' . (int) $order[$cids]
		. '\' WHERE id = '. $c//$itemid[$cids-1]
		;	
	$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
	
	}		
	$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );		

		$link = 'index.php?option=com_properties&view=openhouse';
		$this->setRedirect($link, $msg);
}
	

	function orderSection( $uid, $inc)
	{	
	
	global $mainframe;	
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$model = $this->getModel('openhouse');		
	$db			=& JFactory::getDBO();
	$row		=& JTable::getInstance('openhouse','Table');
	$row->load( $uid );
	$row->move( $inc );			
	
	$link = 'index.php?option=com_properties&view=openhouse';
		$this->setRedirect($link, $msg);
	}

	/**	 * display the edit form	 */
	
	function edit()
	{	
		JRequest::setVar( 'view', 'openhouse' );
		JRequest::setVar( 'layout', 'form' );		
		parent::display();
	}

	/**
	 * save a record (and redirect to main page)	 */
	function save()
	{
	jimport('joomla.filesystem.folder');	
	$model = $this->getModel('openhouse');	
				
$post = JRequest::get( 'post' );
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );

	if (strlen(trim($post['publish_up'])) <= 10) {
			$post['publish_up'] .= ' 00:00:00';
		}


	$post['from']=$post['start_hour'].':'.$post['start_minute'].':00';
	$post['to']=$post['end_hour'].':'.$post['end_minute'].':00';
	
		
	$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$text		= str_replace( '<br>', '<br />', $text );		
		$post['text'] = $text;	
		
		
				
	if ($model->store($post)) {	

$LastModif = $model->getLastModif();

	
if(JRequest::getVar('id')){ $id = JRequest::getVar('id');}else{$id = $LastModif;}

$msg = 	JText::_('Saved').' ( '.$post['name'].' ) ';
				
				switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
	$this->setRedirect( 'index.php?option=com_properties&view=openhouse&layout=form&task=edit&cid[]='.$id);
	
				break;
			case 'save':
	$this->setRedirect( 'index.php?option=com_properties&view=openhouse');
	
				break;	
			case 'save2new':
				$this->setRedirect(JRoute::_('index.php?option=com_properties&view=openhouse&layout=form&task=edit', false));
	$msg.='. '.JText::_('You can add new Country');
				break;			
		}
$this->setMessage( JText::_( $msg ) );	
			
		} else {
			$msg = JText::_( 'Error Saving Greeting' );
			$msg .=  'err'.$this->Err;
		}

	}

	/** remove record(s)	 */
	function remove()
	{
	$this->TableName = JRequest::getCmd('table');
		$model = $this->getModel('openhouse');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
			$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
				foreach($cids as $cid) {

			$msg .= JText::_( 'Borrado openhouse : '.$cid );
			
}			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=openhouse', $msg );
	}



function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=openhouse', $msg );
	}	


}