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

class PropertiesControllerProductstranslations extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask('save2new',		'save');

		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));			
	}		


	
	function edit()
	{	
		JRequest::setVar( 'view', 'productstranslations' );
		JRequest::setVar( 'layout', 'form' );		
		parent::display();
	}

	/**
	 * save a record (and redirect to main page)	 */
	function save()
	{
	
	$model = $this->getModel('productstranslations');	
				
$post = JRequest::get( 'post' );
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );

	$pt_text = JRequest::getVar( 'pt_text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$pt_text		= str_replace( '<br>', '<br />', $pt_text );		
		$post['pt_text'] = $pt_text;

	$pt_description = JRequest::getVar( 'pt_description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$pt_description		= str_replace( '<br>', '<br />', $pt_description );		
		$post['pt_description'] = $pt_description;
				
	if ($model->store($post)) {	

$LastModif = $model->getLastModif();
	
if(JRequest::getVar('id')){ $id = JRequest::getVar('id');}else{$id = $LastModif;}

$msg = 	JText::_('Saved').' ( '.$post['name'].' ) ';
				
				switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
	$this->setRedirect( 'index.php?option=com_properties&view=productstranslations&layout=form&task=edit&cid[]='.$id);
	
				break;
			case 'save':
	$this->setRedirect( 'index.php?option=com_properties&view=productstranslations');
	
				break;	
			case 'save2new':
				$this->setRedirect(JRoute::_('index.php?option=com_properties&view=productstranslations&layout=form&task=edit', false));
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
		$model = $this->getModel('productstranslations');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {

			$msg .= JText::_( 'Borrado productstranslations : '.$cid );
			
}			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=productstranslations', $msg );
	}



function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=productstranslations', $msg );
	}	


}