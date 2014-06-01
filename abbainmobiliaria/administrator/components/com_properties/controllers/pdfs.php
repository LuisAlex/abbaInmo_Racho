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

class PropertiesControllerPdfs extends PropertiesController
{
	function __construct()
	{
		parent::__construct();
		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask('save2new',		'save');
		$this->registerTask( 'unpublish', 	'publish');	
	}
	
	function display()
	{
		parent::display();
	}	
	
	function edit()
	{
		JRequest::setVar( 'view', 'pdfs' );
		JRequest::setVar( 'layout', 'form' );		
		parent::display();
	}
	
	function save()
	{
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	$this->TableName='pdfs';
	global $mainframe;
	$component_name = 'properties';
	$option = JRequest::getVar('option');
	$model = $this->getModel('pdfs');
	$post = JRequest::get( 'post' );
	$db 	=& JFactory::getDBO();
	require_once(JPATH_SITE.DS.'configuration.php');
	$datos = new JConfig();	
	$basedatos = $datos->db;
	$dbprefix = $datos->dbprefix;
	$query = "SHOW TABLE STATUS FROM `".$basedatos."` LIKE '".$dbprefix.$component_name."_".$this->TableName."';";
		$db->setQuery( $query );		
		$nextAutoIndex = $db->loadObject();

	if(JRequest::getVar('id')){ $id_archivo = JRequest::getVar('id');
	}else{$id_archivo = $nextAutoIndex->Auto_increment;}

	if($_FILES['archivo']['name']) {	
	
	// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		
	$path = JPATH_SITE.DS.'images'.DS.'properties'.DS.'pdfs'.DS.$post['parent'].DS;
		
	if(!JFolder::exists($path))
		{
		JFolder::create($path,0755);
		}
	
		$ext =  JFile::getExt($_FILES['archivo']['name']);
		$filename = $post['name'].'.'.$ext;
		$move_to=$path.$filename;
		
if(JFolder::move($_FILES['archivo']['tmp_name'], $move_to)) 
	{		
	$post['archivo'] = $filename;	
	}
	}
	
	$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );		
	$post['text'] = $text;
	
	$datenow =& JFactory::getDate();
	$post['date'] = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
	
	if ($model->store($post)) {	
	$msg = 	JText::_( 'Saved').' ( '.$post['name'].' ) ';

	switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
	$this->setRedirect( 'index.php?option=com_properties&view=pdfs&layout=form&task=edit&cid[]='.$id_archivo);
				break;
			case 'save':
	$this->setRedirect( 'index.php?option=com_properties&view=pdfs');
				break;				
			case 'save2new':
	$this->setRedirect(JRoute::_('index.php?option=com_properties&view=pdfs&layout=form&task=edit', false));
	$msg.=JText::_('You can add new Product.');
				break;					
		}		
			
		} else {
			$msg = JText::_( 'Error Saving Greeting' );
			$msg .=  'err'.$this->Err;
		}	
		$this->setMessage( JText::_( $msg ) );	
	}
	
	
	function remove()
	{
	//echo 'remove';
	$model = $this->getModel('pdfs');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
			$msg = JText::_( 'Deleted' ) ;
		}
	$this->setRedirect( 'index.php?option=com_properties&view=pdfs',$msg);	
	}
	
	function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		//$this->setRedirect( 'index.php?option=com_properties&table='.$this->TableName, $msg );
		parent::display();
	}	
	
	
	
}