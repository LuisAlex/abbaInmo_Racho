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
jimport('joomla.application.component.controller');
class PropertiesControllerRecommend extends JController
{	
	function send_recommend()
	{
		global $mainframe;	
		
		JRequest::checkToken() or jexit( 'Invalid Token' );		
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$post = JRequest::get( 'post' );
		$db		=& JFactory::getDBO();	
		
		$product_id	= JRequest::getInt( 'id',0,'post' );
		$agent_id	= JRequest::getInt( 'agent_id',0,'post' );
		$name		= JRequest::getVar( 'name','','post' );
		$emailFrom		= JRequest::getVar( 'emailFrom','','post' );
		$emailTo		= JRequest::getVar( 'emailTo','','post' );
		$message	= JRequest::getVar( 'message','','post' );
		$product_link =  JRequest::getVar( 'url','','post' );
		
		$sitename 		= $mainframe->getCfg( 'sitename' );		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );		
		$siteURL		= JURI::base();

		$query = ' SELECT p.*, c.name as name_category, cy.name as name_country, s.name as name_state, l.name as name_locality, t.name as name_type '
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
				. ' WHERE p.id = '.$product_id;
				
		$db->setQuery( $query );
		$product = $db->loadObject();		
		
		$subject = $sitename.' : '.JText::_( 'Contact Form');	

		jimport('joomla.filesystem.folder');	
		jimport('joomla.filesystem.file');	

		$path=JPATH_COMPONENT.DS.'includes'.DS.'mail'.DS;
		$plantilla = $path.'skeleton.html';
		
		//require_once($path.DS.'recommend.php');
	
	$img_path = JUri::root().'components/com_properties/includes/mail/';
	$u =& JFactory::getURI();
	$url = $u->toString( array('', 'host'));
	$sitePhone='';
	$date_now = JHTML::_('date', '', JText::_('DATE_FORMAT_LC1'));
	
	$content = JFile::read($plantilla);	
	
	$subject = '['.$name.'] '.JText::_( 'RECCOMEND_PROP_FROM_FRIEND');
	$title = ''.$name.' '.JText::_( 'RECCOMEND_PROP_FROM_FRIEND');
            $body = $name." (".$emailFrom.") ". JText::_( 'INVITE_VIEW_PROP')."\r \n<br>";
			
            $body .= " \r \n\r \n<br>" ;

			$body .= '<a href="'.$product_link.'">'.$product->ref.' [ '.$product->name.' ]</a><br>';
			
			$body .= " \r \n\r \n<br>" ;
			
            //$body .= JText::_( 'BROKENLINK_WARNING')."\r \n<br>";
	
			$body .= " \r \n\r \n<br>" ;	
		
	$reemplazado = str_replace('DATA_TODAY',$date_now,$content);
	$reemplazado = str_replace('FORM_TITLE',$title,$reemplazado);
	$reemplazado = str_replace('MAIL_CONTENT',$body,$reemplazado);
	$reemplazado = str_replace('IMAGE_PATH',$img_path,$reemplazado);
	$reemplazado = str_replace('MAIL_FROM',$mailfrom,$reemplazado);
	$reemplazado = str_replace('SITE_URL',$url,$reemplazado);
	$reemplazado = str_replace('SITE_PHONE',$sitePhone,$reemplazado);	
	
	$body_html = $reemplazado;	
		
		/*echo  'mail to friend '.$$emailTo.'';*/
		JUtility::sendMail($mailfrom, $fromname, $emailTo, $subject, $body_html, true);	
		
		/*echo  ' mail copy  to user '.$$emailFrom.' '.$name;*/
		JUtility::sendMail($mailfrom, $fromname, $emailFrom, $subject, $body_html, true);	
		

	/*
		if(!JFolder::exists($path.DS.'mailsents'))
			{
			JFolder::create($path.DS.'mailsents',0775);
			}
		
		$saveFileText=$body_html;
		JFile::write($path.DS.'mailsents'.DS.'recommend_mail.html', "<html>\n\t<head>\n\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n\t</head>\n\t<body bgcolor=\"#FFFFFF\">".$saveFileText."\n\t</body>\n</html>");*/		
	
	
	$msg=JText::_( 'Recommendation send');			
		
	if(JRequest::getVar( 'return','','post' )){
	$link =  JRequest::getVar( 'return','','post' );
	$config	= new JConfig();
	if($config->sef)
		{
		$link = str_replace('?send=1','',$link);
		$link .= '?send=1';
		}else{
		$link = str_replace('&send=1','',$link);
		$link .= '&send=1';
		}
	
	$this->setRedirect($link, $msg);
	}
	
		//parent::display();
	
		
	}
	
	
	
	
	
}