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

class PropertiesControllerCategories extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask('save2new',		'save');
		$this->registerTask( 'apply',	'save' );
		$this->registerTask( 'unpublish', 	'publish');		
		
		$this->registerTask( 'accesspublic', 	'accessMenu');	
		$this->registerTask( 'accessregistered', 	'accessMenu');	
		$this->registerTask( 'accessspecial', 	'accessMenu');	

		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));

		if(JRequest::getCmd('task') == 'orderup'){
		$this->orderSection( $this->cid[0], -1);
		}elseif(JRequest::getCmd('task') == 'orderdown'){
		$this->orderSection( $this->cid[0], 1);
		}
		
	}	
	
	
	function accessMenu()
	{
		global $mainframe;
		
		
	switch (JRequest::getCmd( 'task' ))
		{
		case 'accesspublic' :
		$access=0;
		break;
		case 'accessregistered' :
		$access=1;
		break;
		case 'accessspecial' :
		$access=2;
		break;	
		}

		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db		= & JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$option	= JRequest::getCmd( 'option' );
		$cid	= $cid[0];
		
		$model = $this->getModel('categories');		
		$db			=& JFactory::getDBO();
		$row		=& JTable::getInstance('category','Table');	
		$row->load($cid);
		$row->access = $access;

		if (!$row->check()) {
			JError::raiseError( 500, $row->getError() );
			return false;
		}

		if (!$row->store()) {
			JError::raiseError( 500, $row->getError() );
			return false;
		}

		$mainframe->redirect('index.php?option=com_properties&view=categories');
	}
	

	function publish()
	{
	$this->TableName = JRequest::getCmd('table');	
	$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
	$this->publish	= ( $this->getTask() == 'publish' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $publish ? 'publish' : 'unpublish';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		
		$query = 'UPDATE #__properties_category'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'		
		;			
		
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&view=categories';
		$this->setRedirect($link, $msg);		
	}



	
	
	
		
	function saveorder(  )
	{		
		
	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );	
	JArrayHelper::toInteger($cid, array(0));
	//$this->cids = implode( ',', $cid );
	$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );
	//$itemid		= JRequest::getVar( 'itemid', array(0), 'post', 'array' );
	foreach($cid as $cids=>$c){
	$query = 'UPDATE #__properties_category'
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

		$link = 'index.php?option=com_properties&view=categories';
		$this->setRedirect($link, $msg);
}
	

	function orderSection( $uid, $inc)
	{	
	$this->TableName = 'category';
	global $mainframe;	
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$model = $this->getModel('categories');		
	$db			=& JFactory::getDBO();
	$row		=& JTable::getInstance($this->TableName,'Table');
	$row->load( $uid );
	$row->move( $inc );			
	
	$link = 'index.php?option=com_properties&view=categories';
		$this->setRedirect($link, $msg);
	}

	/**	 * display the edit form	 */
	
	function edit()
	{
	$this->TableName = JRequest::getVar('table');
		JRequest::setVar( 'view', 'categories' );
		JRequest::setVar( 'layout', 'form' );
		
		JRequest::setVar('TableName', $this->TableName);
		parent::display();
	}

	/**
	 * save a record (and redirect to main page)	 */
	function save()
	{
	jimport('joomla.filesystem.folder');	
	$model = $this->getModel('categories');
				
$post = JRequest::get( 'post' );
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$AutoCoord=$params->get('AutoCoord',0);


$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$text		= str_replace( '<br>', '<br />', $text );		
	$post['text'] = $text;

			
	if ($model->store($post)) {	
$msg = 	JText::_('Saved').' ( '.$post['name'].' ) ';
$LastModif = $model->getLastModif();
	
if(JRequest::getVar('id')){ $id = JRequest::getVar('id');}else{$id = $LastModif;}


				switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
	$this->setRedirect( 'index.php?option=com_properties&view=categories&layout=form&task=edit&cid[]='.$id);
	
				break;
			case 'save':
	$this->setRedirect( 'index.php?option=com_properties&view=categories');
	
				break;	
			case 'save2new':
				
	$this->setRedirect(JRoute::_('index.php?option=com_properties&view=categories&layout=form&task=edit', false));
	$msg.= '. '.JText::_('You can add new category');
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
		$model = $this->getModel('categories');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {

			$msg .= JText::_( 'Borrado '.$this->TableName.' : '.$cid );
			
}			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=categories', $msg );
	}

	/**	 * cancel editing a record */
	function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=categories', $msg );
	}	


}