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

class PropertiesControllerBookings extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask('save2new',		'save');
		$this->registerTask( 'unpublish', 	'publish');	
		$this->registerTask( 'unshow', 	'show');	
		
			$this->registerTask( 'confirm_y_mail', 	'confirm');
			
				
		$this->TableName = JRequest::getCmd('table');		

$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
JArrayHelper::toInteger($this->cid, array(0));

		if(JRequest::getCmd('task') == 'orderup'){
		$this->orderSection( $this->cid[0], -1);
		}elseif(JRequest::getCmd('task') == 'orderdown'){
		$this->orderSection( $this->cid[0], 1);
		}
		
	}	
	
	
	
function edit()
	{
		//JRequest::setVar( 'view', 'products' );
		JRequest::setVar( 'layout', 'form' );		
		parent::display();
	}

function printlist()
	{
	
	JRequest::setVar( 'layout', 'print' );
	JRequest::setVar( 'tmpl', 'component' );			
		parent::display();
	}
/* Publicar Despublicar items */
	function publish____()
	{
$this->TableName = 'order_bookings';	
$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
$this->publish	= ( $this->getTask() == 'publish' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $publish ? 'publish' : 'unpublish';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		$query = $this->_buildQuery();	
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&table='.$this->TableName;
		$this->setRedirect($link, $msg);		
	}


	function show()
	{
$this->TableName = 'order_bookings';	
$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
$this->show	= ( $this->getTask() == 'show' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $show ? 'show' : 'unshow';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		$query =' UPDATE #__properties_order_bookings'
		. ' SET `show` = ' . (int) $this->show
		. ' WHERE id IN ( '. $this->cids .' )'		
		;			
		echo $query;
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&table='.$this->TableName;
		$this->setRedirect($link, $msg);		
	}
	
	
	function saveorder(  )
	{		
		$this->TableName = 'order_bookings';
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

		$link = 'index.php?option=com_properties&table='.$this->TableName;
		$this->setRedirect($link, $msg);
}
	

	function orderSection( $uid, $inc)
	{	
	$this->TableName = 'order_bookings';
	global $mainframe;	
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$model = $this->getModel('property');		
	$db			=& JFactory::getDBO();
	$row		=& JTable::getInstance($this->TableName,'Table');
	$row->load( $uid );
	$row->move( $inc );			
	
	$link = 'index.php?option=com_properties&table='.$this->TableName;
		$this->setRedirect($link, $msg);
	}

	/**	 * display the edit form	 */
	

	/**
	 * save a record (and redirect to main page)	 */
	function save()
	{
	jimport('joomla.filesystem.folder');
	$this->TableName = 'order_bookings';
	$model = $this->getModel('bookings');	
				
$post = JRequest::get( 'post' );
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$AutoCoord=$params->get('AutoCoord',0);
/*
$data['ob_id_order'] = JRequest::getVar( 'ob_id_order','','post' );
$data['ob_id_property'] = JRequest::getVar( 'ob_id_property','','post' );
$data['ob_from'] = JRequest::getVar( 'ob_from','','post' );
$data['ob_to'] = JRequest::getVar( 'ob_to','','post' );
$data['confirmed'] = JRequest::getVar( 'confirmed','','post' );
*/
//	require('a');	
	if(!$post['ob_expire'])
	{
	$date_now = date('Y-m-d');	
	$fs=explode('-',$date_now);
	$post['ob_expire'] = date('Y-m-d',mktime(0, 0, 0, $fs[1], $fs[2]+10  , $fs[0]));	
	}else{	
	$post['ob_expire'] = date('Y-m-d',strtotime($post['ob_expire']));	
	}
	
	
	if($post['ob_deposit'])
	{
	$post['ob_deposit'] = date('Y-m-d',strtotime($post['ob_deposit']));
	}else{
	$post['ob_deposit']=NULL;
	//echo $post['ob_deposit'];require('a');
	}
	
	if($post['ob_created'])
	{
	$post['ob_created'] = date('Y-m-d 00:00:00',strtotime($post['ob_created']));
	}else{
	$post['ob_created']=NULL;	
	}
	
	if($post['ob_confirmed_date'])
	{
	$post['ob_confirmed_date'] = date('Y-m-d',strtotime($post['ob_confirmed_date']));
	}else{
	$post['ob_confirmed_date']=NULL;	
	}
	
	
	
	
	$post['ob_contract_send']=NULL;
	
	if ($model->store($post)) {	

if(!$post['ob_id_order'])
	{
$LastModif = $model->getLastSaved();
$post['ob_id_order'] = $LastModif;
	}else{	
	$LastModif =$post['ob_id_order'];
	}
	
//$saved_availables=$this->save_availables($post,$LastModif);	
	
$msg=JText::_('Saved Order');

	
			switch (JRequest::getCmd( 'task' ))
			{
			case 'apply':
	$this->setRedirect( 'index.php?option=com_properties&view=bookings&layout=form&task=edit&cid[]='.$LastModif);	
				break;
			case 'save':	
	$this->setRedirect( 'index.php?option=com_properties&view=bookings');	
				break;	
			case 'save2new':
	$this->setRedirect(JRoute::_('index.php?option=com_properties&view=bookings&layout=form&task=edit', false));
	$msg.='. '.JText::_('You can add new Order Booking');
				break;	
									
			}
			
$this->setMessage( JText::_( $msg ) );	
			
		} else {
			$msg = JText::_( 'Error Saving Greeting' );
			$msg .=  'err'.$this->Err;
			echo $msg;			
		}

	}

	/** remove record(s)	 */
	function remove()
	{
			
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		foreach($cids as $cid) 
			{
			
			//delete bookings
			$db		=& JFactory::getDBO();
			$query = 'DELETE FROM #__properties_bookings '
					. ' WHERE ob_id_order  = '.$cid
					;
		
			$db->setQuery( $query );
			if (!$db->query())
			{
				JError::raiseError(500, $db->getErrorMsg() );
			}	
			$msg .= JText::_( 'Deleted booking').' : '.$cid.' ' ;			
			
			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=bookings&table='.$this->TableName, $msg );
	}

	/**	 * cancel editing a record */
	function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = '';
		$this->setRedirect( 'index.php?option=com_properties&view=bookings&table='.$this->TableName, $msg );
	}	



function confirm_booking()
	{
	$ob_id_order=JRequest::getVar('book_id');
	$send_email=JRequest::getVar('send_email');
	$user =& JFactory::getUser();
	$query = 'UPDATE #__properties_bookings'
		. ' SET ob_confirmed = 1' 
		. ',ob_confirmed_date = \''.date('Y-m-d').'\''
		. ',ob_confirmed_by = '.$user->id
		. ' WHERE ob_id_order = '.$ob_id_order	
		;        
	$db 	=& JFactory::getDBO();
//echo $query;
//require('a');
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}else{
		echo JText::_('Saved');
		
		$saved_availables=$this->save_availables($data,$ob_id_order);
		
		
		if($send_email==1)
			{
			echo ' '.JText::_('and sending Mail');
			$this->send_confirmation_booking($ob_id_order);
			
			}
		}		
		
		
	}


function confirm()
	{
	$ob_id_order=JRequest::getVar('ob_id_order','','post' );	
	$ob_id_property=JRequest::getVar('ob_id_property','','post' );
	$ob_confirmed = JRequest::getVar( 'confirmed','','post' );		
	$ob_expire = JRequest::getVar( 'ob_expire','','post' );	
	
	if(!$ob_expire)
	{
	$date_now = date('Y-m-d');	
	$fs=explode('-',$date_now);
	$ob_expire = date('Y-m-d',mktime(0, 0, 0, $fs[1], $fs[2]+10  , $fs[0]));	
	}else{	
	$ob_expire = date('Y-m-d',strtotime($ob_expire));	
	}

	
		
	$user =& JFactory::getUser();
	$query = 'UPDATE #__properties_bookings'
		. ' SET ob_confirmed = '.$ob_confirmed 
		. ',ob_confirmed_date = \''.date('Y-m-d').'\''		
		. ',ob_confirmed_by = '.$user->id
		. ' WHERE ob_id_order = '.$ob_id_order	
		;        
	$db 	=& JFactory::getDBO();
//echo $query;
//require('a');
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}else{
		$msg .= JText::_('Saved');
	
	
	
	switch($ob_confirmed)
		{
		case 0: //New Booking
		$status = '';
		
		break;
		case 1: //Received
		$status = '1';
		//$saved_availables=$this->save_availables($data,$ob_id_order,$status);
		$msg .= ' . '.JText::_('Changed_availability_to_'.$saved_availables);
		if(JRequest::getCmd( 'task' )=='confirm_y_mail')
			{
		$confirmation_send_mail = $this->send_confirmation_booking($ob_id_order,$status);
		$msg .= ' '.JText::_('and sending Mail');
			}
		break;
		case 2: //Pending
		$status = '2';
		//$saved_availables=$this->save_availables($data,$ob_id_order,$status);
		$msg .= ' . '.JText::_('Changed_availability_to_'.$saved_availables);
		if(JRequest::getCmd( 'task' )=='confirm_y_mail')
			{
		$confirmation_send_mail = $this->send_confirmation_booking($ob_id_order,$status);
		$msg .= ' '.JText::_('and sending Mail');
			}
		break;
		case 3: //Acepted
		$status = '9';
		$saved_availables=$this->save_availables($data,$ob_id_order,$status);
		$msg .= ' . '.JText::_('Changed_availability_to_'.$saved_availables);
		if(JRequest::getCmd( 'task' )=='confirm_y_mail')
			{
		$confirmation_send_mail = $this->send_confirmation_booking($ob_id_order,$status);
		$msg .= ' '.JText::_('and sending Mail');
			}
		break;
		case 4: //Canceled
		$status = 4;
		$msg .= ' . '.JText::_('Changed_availability_to_'.$saved_availables);
		if(JRequest::getCmd( 'task' )=='confirm_y_mail')
			{
		$confirmation_send_mail = $this->send_confirmation_booking($ob_id_order,$status);
		$msg .= ' '.JText::_('and sending Mail');
			}
		break;
		case 5: //Contract
		$status = '5';
		$saved_availables=$this->save_availables($data,$ob_id_order,$status);
		break;
		default: 
		$status = '';
		break;		
		}
			
		
			
			
			
			
			
			
			
		}		
		
		
$this->setRedirect( 'index.php?option=com_properties&view=bookings&layout=form&task=edit&cid[]='.$ob_id_order, $msg );		
	}



function save_availables($data=NULL,$modificado,$status)
	{
	$db 	=& JFactory::getDBO();
	
	
	
	//restar 1 dia
//if(!$data)
//	{	
	$modificado = JRequest::getVar( 'ob_id_order','','post' );
$data['ob_id_order'] = JRequest::getVar( 'ob_id_order','','post' );
$data['ob_id_property'] = JRequest::getVar( 'ob_id_property','','post' );
$data['ob_from'] = JRequest::getVar( 'ob_from','','post' );
$data['ob_to'] = JRequest::getVar( 'ob_to','','post' );
$data['confirmed'] = JRequest::getVar( 'confirmed','','post' );

$data['ob_from'] = date('Y-m-d',strtotime($data['ob_from']));	
$data['ob_to'] = date('Y-m-d',strtotime($data['ob_to']));	

//	}




		$msg .= $status;
			
$uD = explode('-',$data['ob_to']);

$desdeU=$uD[2].$uD[1].$uD[0];

$ultimo_dia=date('Y-m-d',mktime(0, 0, 0, $uD[1], $uD[2]-1, $uD[0]));

$ob_from=$data['ob_from'];
$ob_to=$data['ob_to'];
echo $ob_from.' ' .$ob_to.'<br>';
//echo $ultimo_dia;echo $data['ob_to'];echo $data['ob_from'];require('a');
while($ob_from<=$ob_to)
	{
	$query = ' SELECT * FROM #__properties_available_product '				
			. ' WHERE id_product = '.$modificado
			. ' AND date = \''.$ob_from.'\''	
			;
			
	$db->setQuery( $query );				
	$availables_data = $db->loadObject();
	echo $query;
	echo $ob_from.' ' .$ob_to.'<br>';
	$nd = explode('-',$ob_from);
	$ob_from=date('Y-m-d',mktime(0, 0, 0, $nd[1], $nd[2]+1, $nd[0]));
	echo $ob_from.' ' .$ob_to.'<br>';
	}

			/*$post['id']=NULL;*/
			//$post['id_product']=$data['ob_id_property'];
			//$post['id_order']=$data['ob_id_order'];
			//$post['available']=$status;
			


	//$model = $this->getModel('bookings');
//print_r($weeks);	

/*
	foreach($weeks as $w)
		{
		$post['date']=$w;	
*/			
			
			
			
			$query = 'UPDATE #__properties_available_product'
		. ' SET available = '.$status		
		. ' WHERE id_product = '.$data['ob_id_property']
		. ' AND (date between \''.$data['ob_from'].'\' AND \''.$ultimo_dia.'\')'
		;  
		
		echo $query;
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}else{
		//echo JText::_('confirmed_'.$modificado);
		}
		
		require('a');
		
		
/*		}*/



	
/*	
if($status!='')
	{
	$query = 'UPDATE #__properties_available_product'
		. ' SET id_order = '.$modificado
		. ',available = '.$status		
		. ' WHERE id_product = '.$data['ob_id_property']
		. ' AND (date between \''.$data['ob_from'].'\' AND \''.$ultimo_dia.'\')'
		;  
		echo $query;
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}else{
		//echo JText::_('confirmed_'.$modificado);
		}
	}
*/	

//require('a');	
	return $status;
	}
	
	
	
function send_confirmation_booking($ob_id_order,$status)
	{

	global $mainframe;	
	$db 	=& JFactory::getDBO();
	$query = ' SELECT ob.* ,p.*,l.name as name_locality '
				. ' FROM #__properties_bookings AS ob '
				. ' LEFT JOIN #__properties_products AS p ON p.id = ob.ob_id_property'	
				. ' LEFT JOIN #__properties_locality as l ON l.id = p.lid '			
				. ' WHERE ob.ob_id_order = '.$ob_id_order;				
				;
	$db->setQuery( $query );				
	$data = $db->loadObject();
	
	/*
	$query = ' SELECT value FROM #__jf_content '
			. ' WHERE reference_id = '.$data->ob_id_property
			. ' AND reference_table = \'properties_products\''
			. ' AND reference_field = \'name\'';				
				
	$db->setQuery( $query );				
	$name_property = $db->loadResult();
	*/
	//echo '<b>'.$name_property.'</b>';
	
	$send_to=$data->ob_mail;
	

switch($data->ob_confirmed)
		{
		case 1: //Received
			$confirm_mail_to = 'received';	
		break;	
		case 2: //Pending
			$confirm_mail_to = 'pending';
		break;
		case 3: //Acepted
			$confirm_mail_to = 'acepted';
			
		break;
		case 4: //Canceled
			$confirm_mail_to = 'canceled';
		break;
		case 5: //Contract
			$confirm_mail_to = 'contract';
			/*
			$send_contract=TRUE;			
			$query = 'UPDATE #__properties_bookings'
			. ' SET ob_contract_send = \''.date('Y-m-d').'\''		
			. ' WHERE ob_id_order = '.$data->ob_id_order	
			;        
			$db 	=& JFactory::getDBO();
			$db->setQuery( $query );
			if (!$db->query())
			{
				JError::raiseError(500, $db->getErrorMsg() );
			}	
			*/	
		
		break;		
		}
		//echo $confirm_mail_to;require('a');
/*
	echo '<pre>';
	print_r($data);
	echo '</pre>';	
*/	
		$sitename 		= $mainframe->getCfg( 'sitename' );		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );
		
		$siteURL		= JURI::base();

	
	$subject = JText::_( $data->ob_language.'_SUBJET_BOOKING_CONFIRMED_'.$data->ob_confirmed );



$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

require_once(JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.$confirm_mail_to.'_confirm_html.php');

$nombre_archivo1 = 'components\com_properties\canceled_booking_mail.html';
$gestor1 = fopen($nombre_archivo1, 'w');	
$contenido1 .= "\n".$data->ob_language.$body_html;
fwrite($gestor1, $contenido1);

/*
    *   string  $from: From e-mail address
    * string $fromname: From name
    * mixed $recipient: Recipient e-mail address(es)
    * string $subject: E-mail subject
    * string $body: Message body
    * boolean $mode: false = plain text, true = HTML
    * mixed $cc: CC e-mail address(es)
    * mixed $bcc: BCC e-mail address(es)
    * mixed $attachment: Attachment file name(s)
    * mixed $replyto: Reply to email address(es)
    * mixed $replytoname: Reply to name(s)

*/


//require_once(JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.'contrato_html.php');



$att_path='';
if($send_contract)
	{
	
	$contrato_generado=$this->generate_contract($ob_id_order,$data,$name_property);
	
	
	$query = 'UPDATE #__properties_bookings'
		. ' SET ob_contract_send = \''.date('Y-m-d').'\''
		. ',ob_contract_name = \''.$contrato_generado.'\''		
		. ' WHERE ob_id_order = '.$data->ob_id_order	
		;        
	$db 	=& JFactory::getDBO();
//echo $query;
//require('a');
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		
		
		
$att_path=JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.$contrato_generado;	
	}
	
	
//echo $att_path;require($att_path);

JUtility::sendMail($mailfrom, $fromname, $send_to, $subject, $body_html, true,'','', $att_path);

JUtility::sendMail($mailfrom, $fromname, $mailfrom, $subject, $body_html, true);

$ob_send_mail=$data->ob_send_mail+1;

$query = 'UPDATE #__properties_bookings'
		. ' SET ob_send_mail = '.$ob_send_mail		
		. ',ob_text_mail = \''.str_replace("'","&#039;",$body_html).'\''
		//. ',ob_contract_name = \''.$contrato_generado.'\''
		. ' WHERE ob_id_order = '.$ob_id_order	
		;        
	$db 	=& JFactory::getDBO();

		
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}else{
		
		}
		
		/**/
	

//	require('a');

return JText::_('Mail sent');

	}
	
function send_contract()
	{
	global $mainframe;	
	$post = JRequest::get( 'post' );
	$db 	=& JFactory::getDBO();
	$query = ' SELECT ob.* ,p.*,l.name as name_locality '
				. ' FROM #__properties_order_bookings AS ob '
				. ' LEFT JOIN #__properties_products AS p ON p.id = ob.ob_id_property'	
				. ' LEFT JOIN #__properties_locality as l ON l.id = p.lid '			
				. ' WHERE ob.ob_id_order = '.$post['ob_id_order'];				
				;
	$db->setQuery( $query );				
	$data = $db->loadObject();
	
	$query = ' SELECT value FROM #__jf_content '
			. ' WHERE reference_id = '.$data->ob_id_property
			. ' AND reference_table = \'properties_products\''
			. ' AND reference_field = \'name\'';				
				
	$db->setQuery( $query );				
	$name_property = $db->loadResult();
	
	//echo '<b>'.$name_property.'</b>';
	
	$send_to=$data->ob_mail;
	
		$sitename 		= $mainframe->getCfg( 'sitename' );		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );
		
		$siteURL		= JURI::base();

	
	$subject = JText::_( $data->ob_language.'_SUBJET_SEND_CONTRACT' );



$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	
	$contrato_generado=$data->ob_contract_name;
	
$att_path=JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.$contrato_generado;	
	
	JUtility::sendMail($mailfrom, $fromname, $send_to, $subject, $subject, true,'','', $att_path);
	
	





	
	$query = 'UPDATE #__properties_order_bookings'
		. ' SET ob_contract_send = \''.date('Y-m-d').'\''		
		. ' WHERE ob_id_order = '.$data->ob_id_order	
		;        
	$db 	=& JFactory::getDBO();
//echo $query;
//require('a');
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		
		
		
	$msg=JText::_('Contract Send');
	$this->setRedirect( 'index.php?option=com_properties&view=bookings&layout=form&task=edit&cid[]='.$data->ob_id_order, $msg );	
		
			
	}	
	
	
	function generate_contract($ob_id_order,$data,$name_property)
		{
		$date_now = date('d/m/y');	
		$d= date('d.m.Y', strtotime($data->ob_from));
$h= date('d.m.Y', strtotime($data->ob_to));
if($data->ob_deposit)
	{
$data_deposit = date('d.m.Y', strtotime($data->ob_deposit));
	}
$EXTRAS_PROPERTY='';
if($data->extra2){$EXTRAS_PROPERTY.=' '.JText::_($data->ob_language.'_extra2');}
if($data->extra3){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra3');}
if($data->extra4){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra4');}
if($data->extra5){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra5');}
if($data->extra6){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra6');}
if($data->extra7){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra7');}
if($data->extra8){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra8');}
if($data->extra9){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra9');}
if($data->extra10){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra10');}
if($data->extra11){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra11');}
if($data->extra12){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra12');}
if($data->extra13){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra13');}
if($data->extra14){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra14');}
if($data->extra15){$EXTRAS_PROPERTY.=', '.JText::_($data->ob_language.'_extra15');}

if($data->contract_1){$DATA_CONTRACT_1_BEFORE=JText::_($data->language.'_CONTRACT_1_BEFORE');}
if($data->contract_2){$DATA_CONTRACT_2_BEFORE=JText::_($data->language.'_CONTRACT_2_BEFORE');}
if($data->contract_3){$DATA_CONTRACT_3_BEFORE=JText::_($data->language.'_CONTRACT_3_BEFORE');}
if($data->contract_4){$DATA_CONTRACT_4_BEFORE=JText::_($data->language.'_CONTRACT_4_BEFORE');}
if($data->contract_5){$DATA_CONTRACT_5_BEFORE=JText::_($data->language.'_CONTRACT_5_BEFORE');}
if($data->contract_6){$DATA_CONTRACT_6_BEFORE=JText::_($data->language.'_CONTRACT_6_BEFORE');}
if($data->contract_7){$DATA_CONTRACT_7_BEFORE=JText::_($data->language.'_CONTRACT_7_BEFORE');}
if($data->contract_8){$DATA_CONTRACT_8_BEFORE=JText::_($data->language.'_CONTRACT_8_BEFORE');}

if($data->contract_1){$DATA_CONTRACT_1_AFTER=JText::_($data->language.'_CONTRACT_1_AFTER');}
if($data->contract_2){$DATA_CONTRACT_2_AFTER=JText::_($data->language.'_CONTRACT_2_AFTER');}
if($data->contract_3){$DATA_CONTRACT_3_AFTER=JText::_($data->language.'_CONTRACT_3_AFTER');}
if($data->contract_4){$DATA_CONTRACT_4_AFTER=JText::_($data->language.'_CONTRACT_4_AFTER');}
if($data->contract_5){$DATA_CONTRACT_5_AFTER=JText::_($data->language.'_CONTRACT_5_AFTER');}
if($data->contract_6){$DATA_CONTRACT_6_AFTER=JText::_($data->language.'_CONTRACT_6_AFTER');}
if($data->contract_7){$DATA_CONTRACT_7_AFTER=JText::_($data->language.'_CONTRACT_7_AFTER');}
if($data->contract_8){$DATA_CONTRACT_8_AFTER=JText::_($data->language.'_CONTRACT_8_AFTER');}
	
$CITY_CUSTOMER=$data->ob_postcode.' '.$data->ob_city.' '.$data->ob_province;
	
		$text_from=$d;
		$text_to=$h;
		$text_price=$formatted_price = number_format($data->ob_price, 0,",",".");
		$deposit=($data->ob_price*30/100);
		$text_deposit=round($deposit/10,0)*10;		
		$text_saldo=$data->ob_price-$text_deposit;
		$text_saldo= number_format($text_saldo, 0,",",".");
		
	
		$plantilla = JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.$data->ob_language.'_contratto.rtf';
		
echo $plantilla;
$pre=time();
$fs='contratto_'.$ob_id_order.'_'.$pre.'.doc';

$fsalida=JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.$fs;

$texto = file($plantilla);
    $tamleef = sizeof($texto);
    for ($n=0;$n<$tamleef;$n++) {$todo= $todo.$texto[$n];}
    
$txtplantilla =	$todo;
//Paso no.2 Saca cabecera, el cuerpo y el final
$matriz=explode("sectd", $txtplantilla);
$cabecera=$matriz[0]."sectd";
$inicio=strlen($cabecera);
$final=strrpos($txtplantilla,"}");
$largo=$final-$inicio;
$cuerpo=substr($txtplantilla, $inicio, $largo);
//Paso no.3 Escribo el fichero
$punt = fopen($fsalida, "w");
fputs($punt, $cabecera);

//$despues=str_replace("NAME_CUSTOMER",$data->ob_name,$cuerpo);
$reemplazar = array("NAME_CUSTOMER","ADDRESS_CUSTOMER","CITY_CUSTOMER","PHONE_CUSTOMER","EXTRA1_PROPERTY","LOCALITY_PROPERTY","NAME_PROPERTY","DESCRIPTION_PROPERTY ","EXTRAS_PROPERTY","FROM_BOOKING","TO_BOOKING","PRICE_BOOKING","PRICE_DEPOSIT","DATA_DEPOSIT_BOOKING","SALDO_BOOKING","DATA_TODAY");
$reemplazador = array($data->ob_name,$data->ob_address,$CITY_CUSTOMER,$data->ob_phone,Jtext::_('extra1_'.$data->extra1),$data->name_locality, $data->name, $data->description, $EXTRAS_PROPERTY, $text_from, $text_to, $text_price.',00', $text_deposit.',00', $data_deposit, $text_saldo.',00',$date_now);
$reemplazado = str_replace($reemplazar,$reemplazador,$cuerpo);


$number_data=1;
if($data->contract_1){
$DATA_CONTRACT_1=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_1_BEFORE').' '.$data->contract_1.' '.JText::_($data->ob_language.'_CONTRACT_1_AFTER');
$number_data++;
}
if($data->contract_2){
$DATA_CONTRACT_2=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_2_BEFORE').' '.$data->contract_2.' '.JText::_($data->ob_language.'_CONTRACT_2_AFTER');
$number_data++;
}
$DATA_CONTRACT_3_8='';
if($data->contract_3){
$DATA_CONTRACT_3_8.=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_3_BEFORE').' '.$data->contract_3.' '.JText::_($data->ob_language.'_CONTRACT_3_AFTER')." \par ";
$number_data++;
}
if($data->contract_4){
$DATA_CONTRACT_3_8.=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_4_BEFORE').' '.$data->contract_4.' '.JText::_($data->ob_language.'_CONTRACT_4_AFTER')." \par ";
$number_data++;
}
if($data->contract_5){
$DATA_CONTRACT_3_8.=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_5_BEFORE').' '.$data->contract_5.' '.JText::_($data->ob_language.'_CONTRACT_5_AFTER')." \par ";
$number_data++;
}
if($data->contract_6){
$DATA_CONTRACT_3_8.=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_6_BEFORE').' '.$data->contract_6.' '.JText::_($data->ob_language.'_CONTRACT_6_AFTER')." \par ";
$number_data++;
}
if($data->contract_7){
$DATA_CONTRACT_3_8.=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_7_BEFORE').' '.$data->contract_7.' '.JText::_($data->ob_language.'_CONTRACT_7_AFTER')." \par ";
$number_data++;
}
if($data->contract_8){
$DATA_CONTRACT_3_8.=$number_data.') '.JText::_($data->ob_language.'_CONTRACT_8_BEFORE').' '.$data->contract_8.' '.JText::_($data->ob_language.'_CONTRACT_8_AFTER')." \par ";
$number_data++;
}
$reemplazado = str_replace('NOTEACCESSORIE_1',$DATA_CONTRACT_1,$reemplazado);
$reemplazado = str_replace('NOTEACCESSORIE_2',$DATA_CONTRACT_2,$reemplazado);
$reemplazado = str_replace('NOTEACCESSORIE_3_8',$DATA_CONTRACT_3_8,$reemplazado);


$despues=$reemplazado;
    fputs($punt,$despues);
    //  $saltopag="\par \page \par";
   	// fputs($punt,$saltopag);

fputs($punt,"}");
fclose ($punt);


$saltolinea="\par";



echo '<pre>';
print_r($data);
echo '</pre>';

echo $reemplazado;

$nombre_archivo1 = JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'mail'.DS.'booking'.DS.'contratohtml.html';
$gestor1 = fopen($nombre_archivo1, 'w');	
$contenido1 .= "\n".$despues;
fwrite($gestor1, $contenido1);


//require('a');
return $fs;


		}
	
	
	
	function getWeeks($from,$to)
		{
		
		$first_saturday = $from;
		$last_saturday = $to;		
		$fs=explode('-',$first_saturday);
		
	$year = 1;
	$seven=7;
	$next_saturday = $first_saturday;
	$salir = 0;
		
	while ($salir <= 0) {	
	$weeks[]=$next_saturday;	
	$fs=explode('-',$next_saturday);	
	$next_saturday = date('Y-m-d',mktime(0, 0, 0, $fs[1], $fs[2]+$seven  , $fs[0]));	
	$rate_to = date('Y-m-d',mktime(0, 0, 0, $fs[1], $fs[2]+$seven-1  , $fs[0]));	
	
	if($next_saturday==$last_saturday){$salir=1;}	
	}
	return $weeks;		
		}


function ShowListAvailables()
	{
	global $mainframe;
	$p_id=JRequest::getVar('productid');
	$db 	=& JFactory::getDBO();
	$query = ' SELECT ob.ob_name , ap.* '
				. ' FROM #__properties_available_product AS ap '				
				. ' left JOIN #__properties_order_bookings as ob ON ob.ob_id_order = ap.id_order '			
				. ' WHERE ap.id_product = '.$p_id
				. ' GROUP BY ap.date '			
				;
				
				
				
	$db->setQuery( $query );				
	$data = $db->loadObjectList();
	
	//echo str_replace('#_','jos',$query);
	//echo $p_id;
	$fondo[2]='#FFFFFF';
	$fondo[3]='#FFFFCC';
	$fondo[9]='#CC0000';
	$fondo[1]='#33CC33';
	
	echo '<table border="1" width="100%">';
	
	$weeks = $this->getWeeks('2010-04-24','2010-09-25');
	foreach($data as $dato)
		{
		$week_data[$dato->date]=$dato;
		}
	//foreach($data as $dato)
	foreach($weeks as $w)
		{
		if($week_data[$w])
			{
			$from = date('d-m-Y',strtotime($week_data[$w]->date));
			//$week_data[$w]->available
			//$week_data[$w]->id_order
			//$to = 
		echo '<tr style="background-color:'.$fondo[$week_data[$w]->available].';"><td>'.$from.'  : '.$week_data[$w]->ob_name.'</td></tr>';
			}else{
			echo '<tr style="background-color:'.$fondo[1].';"><td>'.$w.'</td></tr>';
			}
		
		}
	echo '</table>';
	}










function ShowListPrice()
	{
	
	
	global $mainframe;
	$p_id=JRequest::getVar('productid');
	$db 	=& JFactory::getDBO();
	$query = ' SELECT p.*,pp.name as name_residence '
				. ' FROM #__properties_products AS p '	
				. ' LEFT JOIN #__properties_products AS pp ON p.parent = pp.id '		
				. ' WHERE p.id = '.$p_id
				. '  '			
				;
				
				
				
	$db->setQuery( $query );				
	$data = $db->loadObject();
	
	echo 'Residence : '.$data->name_residence;
	
	$listaPrecios=$this->getAgenziaPriceList($p_id,$data->parent);
	
	//print_r($listaPrecios);
	
	//echo str_replace('#_','jos',$query);
	//echo $p_id;
	$fondo[2]='#FFFFFF';
	$fondo[3]='#FFFFCC';
	$fondo[9]='#CC0000';
	$fondo[1]='#33CC33';
	
	echo '<table border="1" width="100%">';
	
	$weeks = $this->getWeeks('2010-04-24','2010-09-25');
	
	//foreach($data as $dato)
	
	
	foreach($weeks as $w)
		{
		if($listaPrecios[$w])
			{
			$from = date('d-m-Y',strtotime($w));
			
			//$week_data[$w]->available
			//$week_data[$w]->id_order
			//$to = 
		echo '<tr style="background-color:'.$fondo[$listaPrecios[$w]['seleccionada']].';"><td>'.$listaPrecios[$w]['title'].'  : '.$listaPrecios[$w]['rate'].'</td></tr>';
			}else{
			echo '<tr style="background-color:'.$fondo[1].';"><td>'.$w.'</td></tr>';
			}
		
		}
			
	echo '</table>';
	
	
	
	
	
	}
	
	
	
	
	

}