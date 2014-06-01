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
class PropertiesControllerContact extends JController
{	
	function send_contact()
	{
		global $mainframe;	
		JRequest::checkToken() or jexit( 'Invalid Token' );		
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$mail_contact=$params->get('mail_contact');
		$sendAgentData=$params->get('sendAgentData');
		$send_to = $mail_contact;		
		$db		=& JFactory::getDBO();		
		$post = JRequest::get( 'post' );
 		$product_id =  JRequest::getInt( 'product_id','','post' ); 
 		$agent_id =  JRequest::getInt( 'agent_id','','post' );
 
		$name =  JRequest::getVar( 'name','','post' );
		$email =  JRequest::getVar( 'email','','post' );
		$phone =  JRequest::getVar( 'phone','','post' );
		$address =  JRequest::getVar( 'address','','post' );
		$city =  JRequest::getVar( 'city','','post' );
		$state =  JRequest::getVar( 'state','','post' );
		$cp =  JRequest::getVar( 'cp','','post' );
		$text =  JRequest::getVar( 'text','','post' );
		$emailCopy	= JRequest::getInt( 'email_copy',1,'post' );	
			
		$sitename 		= $mainframe->getCfg( 'sitename' );		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );		
		$siteURL		= JURI::base();

		$send_to_admin=$mailfrom;
	
	// Captcha Controller Patch rev. 4.5.0 Stable
		$dispatcher	= &JDispatcher::getInstance();
		$results = $dispatcher->trigger( 'onCaptchaRequired', array( 'com_properties.contact' ) );
		if ( $results[0] ) {
			$captchaparams = array( JRequest::getVar( 'captchacode', '', 'post' )
			, JRequest::getVar( 'captchasuffix', '', 'post' )
			, JRequest::getVar( 'captchasessionid', '', 'post' ));
			$results = $dispatcher->trigger( 'onCaptchaVerify', $captchaparams );
			if ( ! $results[0] ) {
				JError::raiseWarning( 'CAPTHCA', JText::_( 'CAPTCHACODE_DO_NOT_MATCH' ) );
				//print_r($post);require('a');
				if(JRequest::getVar( 'return','','post' )){
					$link =  JRequest::getVar( 'return','','post' );
					$this->setRedirect($link, $msg);
				}else{	
				$link = JRoute::_('index.php?option=com_properties&view=form1&Itemid='.$Itemid,false);
				$this->setRedirect($link, $msg);
				}
				
				return false;
			}
		}

		
		$body = html_entity_decode($body, ENT_QUOTES);
		
		$subject = $sitename.' : '.JText::_( 'Contacto');

	if($product_id)
		{
		$query = 	"SELECT * from #__properties_products where id = ".$product_id;
		$db->setQuery( $query );				
		$product = $db->loadObject();
		$link = LinkHelper::getLinkProperty($product->id,$product->alias);
		
		$product->link = JURI::base().substr($link, strlen(JURI::base(true)) + 1);

		$queryp = 'SELECT *  FROM #__properties_profiles WHERE mid = '.$product->agent_id;
		$db->setQuery( $queryp );
		$agent = $db->loadObject();
	}elseif($agent_id){
		$queryp = 'SELECT *  FROM #__properties_profiles WHERE mid = '.$agent_id;
		$db->setQuery( $queryp );
		$agent = $db->loadObject();
	}	

	$send_to_agent =	$agent->email;


		jimport('joomla.filesystem.folder');	
		jimport('joomla.filesystem.file');	

		$path=JPATH_COMPONENT.DS.'includes'.DS.'mail'.DS;
		$plantilla = $path.'skeleton.html';
		
		require_once($path.DS.'contact.php');

	$img_path = JUri::root().'components/com_properties/includes/mail/';
	$u =& JFactory::getURI();
	$url = $u->toString( array('', 'host'));
	$sitePhone='';
	$date_now = JHTML::_('date', '', JText::_('DATE_FORMAT_LC1'));
	
	$content = JFile::read($plantilla);
	$reemplazado = str_replace('DATA_TODAY',$date_now,$content);
	$reemplazado = str_replace('FORM_TITLE',$subject,$reemplazado);
	$reemplazado = str_replace('MAIL_CONTENT',$body,$reemplazado);
	$reemplazado = str_replace('IMAGE_PATH',$img_path,$reemplazado);
	$reemplazado = str_replace('MAIL_FROM',$mailfrom,$reemplazado);
	$reemplazado = str_replace('SITE_URL',$url,$reemplazado);
	$reemplazado = str_replace('SITE_PHONE',$sitePhone,$reemplazado);	
	$body_html = $reemplazado;	
if($sendAgentData)
	{	
	$reemplazado ='';
	$contentAdmin = JFile::read($plantilla);
	$reemplazado = str_replace('DATA_TODAY',$date_now,$contentAdmin);
	$reemplazado = str_replace('FORM_TITLE',$subject,$reemplazado);
	$reemplazado = str_replace('MAIL_CONTENT',$body.$agentData,$reemplazado);
	$reemplazado = str_replace('IMAGE_PATH',$img_path,$reemplazado);
	$reemplazado = str_replace('MAIL_FROM',$mailfrom,$reemplazado);
	$reemplazado = str_replace('SITE_URL',$url,$reemplazado);
	$reemplazado = str_replace('SITE_PHONE',$sitePhone,$reemplazado);	
	$bodyAdmin = $reemplazado;
	
	
	}else{
	$bodyAdmin=$body_html;
	}
	

		//if(!$send_to){$send_to=$send_to_agent;}

		if(!$send_to){$send_to=$send_to_admin;}
		
		if($params->get('SendContactForm')==1)
		{
		/*echo  'mail to ADMIN '.$send_to.'';*/
		JUtility::sendMail($mailfrom, $fromname, $send_to, $subject, $bodyAdmin, true);	
		}
		if($params->get('SendContactForm')==2)
		{
		/*echo  ' mail to AGENT '.$send_to_agent.'';*/
		JUtility::sendMail($mailfrom, $fromname, $send_to_agent, $subject, $body_html, true);	
		}	
		if($params->get('SendContactForm')==3)
		{
		/*echo  ' mail to ADMIN and AGENT ';*/
		JUtility::sendMail($mailfrom, $fromname, $send_to, $subject, $bodyAdmin, true);	
		JUtility::sendMail($mailfrom, $fromname, $send_to_agent, $subject, $body_html, true);	
		}
		/*echo  ' mail to USER ';*/
		JUtility::sendMail($mailfrom, $fromname, $email, $subject, $body_html,true);

		///save form////
		$SaveContactForm=$params->get('SaveContactForm',1);
		
		if($SaveContactForm==1){
		$model = $this->getModel('contacts');			
		if ($model->store($post,'contacts')) {
		//JError::raiseError(500, $db->getErrorMsg() );
			}else{
			JError::raiseError(500, 'eerrrreer' );
			}
		}

	if($params->get('SaveContactFile'))
		{	
		$LastModif = $model->getLastModif();
		if(!JFolder::exists($path.DS.'mailsents'))
			{
			JFolder::create($path.DS.'mailsents',0775);
			}	
		//$saveFileText="<br>mailfrom: ".$mailfrom."<br>fromname: ".$fromname."<br>mailto: ".$send_to."<br>subject: ".$subject."<br>".$body_html;
		$saveFileText=$body_html;
		JFile::write($path.DS.'mailsents'.DS.$LastModif.'_mail.html', "<html>\n\t<head>\n\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n\t</head>\n\t<body bgcolor=\"#FFFFFF\">".$saveFileText."\n\t</body>\n</html>");
		}
	
	
	$msg=JText::_( 'Message send');	
		
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
