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

class PropertiesControllerSendmail extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'rejected'  , 	'approved' );
	
		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
		
	}	

	


	
	function approved()
	{
	
	global $mainframe;	
	$db		=& JFactory::getDBO();		
	JRequest::checkToken() or jexit( 'Invalid Token' );		
	$post = JRequest::get( 'post' );
	jimport('joomla.filesystem.folder');	
	jimport('joomla.filesystem.file');	
		
	$sendtextmail = JRequest::getVar( 'sendtextmail', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$sendtextmail		= str_replace( '<br>', '<br />', $sendtextmail );		
	$post['sendtextmail'] = $sendtextmail;
	$id = $post['id'];	
	
	$queryp = 'SELECT *  FROM #__properties_profiles WHERE mid = '.$post['agent_id'];
		$db->setQuery( $queryp );
		$agent = $db->loadObject();
	$body = 'Dear '.$agent->name.' : <br>';
	
	switch (JRequest::getCmd( 'task' ))
			{
				case 'approved':
				$subject = $sitename.' : '.JText::_('Property Approved');	
				$body .= JText::_('Your Property has been Approved');
					$body .= $sendtextmail;
				break;
				case 'rejected':
				$subject = $sitename.' : '.JText::_('Your Property has been Rejected');
						
				$body .= $sendtextmail;		
				break;
			}
	
	$path=JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS;
		$plantilla = $path.'skeleton.html';
		
	$img_path = JUri::root().'components/com_properties/includes/mail/';
	$u =& JFactory::getURI();
	$url = $u->toString( array('', 'host'));
	$sitePhone='';
	$date_now = JHTML::_('date', '', JText::_('DATE_FORMAT_LC1'));
	
	$content = JFile::read($plantilla);	
	
	//require_once( JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'link.php' );
	//$urlDetail = LinkHelper::getLinkProperty($post['id'],$post['alias']);
	//$body .= '<br>'.$urlDetail ;
	//$urlPanel = '';
	
	$sitename 		= $mainframe->getCfg( 'sitename' );		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );		
		$siteURL		= JURI::base();
	$emailTo = '';	
	
	

	$send_to_agent = $agent->email;
	
	
	$reemplazado = str_replace('DATA_TODAY',$date_now,$content);
	$reemplazado = str_replace('FORM_TITLE',$title,$reemplazado);
	$reemplazado = str_replace('MAIL_CONTENT',$body,$reemplazado);
	$reemplazado = str_replace('IMAGE_PATH',$img_path,$reemplazado);
	$reemplazado = str_replace('MAIL_FROM',$mailfrom,$reemplazado);
	$reemplazado = str_replace('SITE_URL',$url,$reemplazado);
	$reemplazado = str_replace('SITE_PHONE',$sitePhone,$reemplazado);	
	
	$body_html = $reemplazado;	
	
	echo $body_html;
		
		echo  'mail to agent '.$send_to_agent.'';
		JUtility::sendMail($mailfrom, $fromname, $send_to_agent, $subject, $body_html, true);	
		
		/*echo  ' mail copy  to user '.$$emailFrom.' '.$name;*/
		JUtility::sendMail($mailfrom, $fromname, $mailfrom, $subject, $body_html, true);	
		
		
		
		
		
	
	
		
					
	//require('a');
	
	$msg = JText::_( 'Mail sent' );
	$this->setRedirect( 'index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id);
	$this->setMessage( JText::_( $msg ) );	
	}


	function cancel()
	{
	$post = JRequest::get( 'post' );
	$id = $post['id'];
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id, $msg );
	}	


}