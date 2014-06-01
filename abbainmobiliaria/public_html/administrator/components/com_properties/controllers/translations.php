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

class PropertiesControllerTranslations extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		

		$this->registerTask( 'unpublish', 	'publish');			

		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
			
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
		
		$query = 'UPDATE #__properties_translations'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE t_id IN ( '. $this->cids .' )'		
		;    
				
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&view=translations';
		$this->setRedirect($link, $msg);		
	}



	function savelist()
	{
	jimport('joomla.filesystem.folder');	
	$model = $this->getModel('translations');				
	$post = JRequest::get( 'post' );
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );			
			
		$t_languagecode= JRequest::getVar('filter_translation_lang', 'post', '', 'string');
		$t_table= JRequest::getVar('filter_translation_table', 'post', '', 'word');
		$ids	= JRequest::getVar('fid', array(), '', 'array');
		$tids	= JRequest::getVar('tid', array(), '', 'array');
		$tvalues	= JRequest::getVar('tvalue', array(), '', 'array');
		$talias	= JRequest::getVar('talias', array(), '', 'array');
		$originalnames	= JRequest::getVar('originalnames', array(), '', 'array');
		
		$tanslate = array();
		foreach($ids as $id => $fid)
		{		
			if($tvalues[$fid])
			{	
				$tanslate['t_id']	= $tids[$fid];
				$tanslate['t_languageid']	= $t_languageid;
				$tanslate['t_languagecode']	= $post['filter_translation_language'];
				$tanslate['t_table']	=$post['filter_translation_tables'];
				$tanslate['t_field']	=$originalnames[$fid];
				$tanslate['t_fieldid']	= $fid;
				$tanslate['t_value']	= $tvalues[$fid];				
				$tanslate['t_alias']	= $talias[$fid];				
				$tanslate['t_published']	= 1;					
			$model->store($tanslate);
			}			 
		}
		$this->setMessage( JText::_( 'List Saved' ) );
		$this->setRedirect( 'index.php?option=com_properties&view=translations');	
	}
	
	
	

	/** remove record(s)	 */
	function remove()
	{
	$this->TableName = JRequest::getCmd('table');
		$model = $this->getModel('translations');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {

			$msg .= JText::_( 'Borrado translations : '.$cid );
			
}			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=translations', $msg );
	}



function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=translations', $msg );
	}	


}