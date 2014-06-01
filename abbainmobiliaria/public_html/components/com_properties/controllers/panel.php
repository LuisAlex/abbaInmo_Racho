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

class PropertiesControllerPanel extends JController
{
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask( 'unpublish', 	'publish');	
		$this->registerTask( 'nodestacado', 	'destacado');	
		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));		
	}	
	
	/**	 * display the edit form	 */
	
	function edit()
	{	
	JRequest::checkToken() or jexit( 'Invalid Token' );		
		JRequest::setVar( 'view', 'panel' );
		JRequest::setVar( 'layout', 'form' );		
		parent::display();
	}
	
	function cancel()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );	
		//JRequest::setVar( 'view', 'panel' );
		//JRequest::setVar( 'layout', 'default' );
		$link = JRoute::_('index.php?option=com_properties&amp;view=panel&amp;Itemid='.LinkHelper::getItemid('panel'),false);
		//$link = LinkHelper::getLink('panel');
		//echo $link;require('a');
		$msg = JText::_('Operation canceled');
		
		$this->setRedirect($link, $msg);
		//parent::display();
	}
	
	function remove()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );	
		$model = $this->getModel('panel');
			if(!$model->delete()) {
				$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
			} else {
				$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
					foreach($cids as $cid) {

					$msg .= JText::_( 'Deleted product : '.$cid );
						
			
					}			
			}

		$link = JRoute::_('index.php?option=com_properties&amp;view=panel&amp;Itemid='.LinkHelper::getItemid('panel'),false);
		$msg = '';
		
		$this->setRedirect($link, $msg);
		
	}
	
	function save()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );	
		JRequest::setVar( 'view', 'panel' );
		$db 	=& JFactory::getDBO();		
		$post = JRequest::get('post');
		$productId = (int)$post['id'];
		//echo $productId;require('a');
		
		$user =& JFactory::getUser();
		if($productId)
			{
			
			$query = ' SELECT p.id '
					. ' FROM #__properties_products AS p '	
					. ' WHERE p.id = '.$productId
					. ' AND p.agent_id = '.$user->id;
			$db->setQuery( $query );
			$exists = $db->loadObject();
			
				if(!$exists)
				{
				JError::raiseError(500, JText::_( 'Problem with your account', true ) );			
				}
			}else{
			//is new
			$post['agent_id'] = $user->id;
			}
		
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$AutoCoord=$params->get('AutoCoord',0);
		
		if($productId)
			{
			$id_imagen = $productId;
			}
			

		if($AutoCoord)
			{
			if(!$post['lat'])
				{
				$coord=$this->GetCoord();
				//print_r($coord);
				$ll=explode(',',$coord);
				if($ll[0]!=0){$post['lat']=$ll[0];}
				if($ll[1]!=0){$post['lng']=$ll[1];}
				}
			}
			
			
		jimport( 'joomla.application.component.helper' );				
		$filter = new JFilterInput(array(), array(), 1, 1);			
		
		$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$text		= str_replace( '<br>', '<br />', $text );		
		$post['text'] = $filter->clean($text);
		/*
		$description = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$description		= str_replace( '<br>', '<br />', $description );		
		$post['description'] = $filter->clean($description);	
		*/
		
		for ($ex=2;$ex<41;$ex++)
			{
			$extra='extra'.$ex;
			if(!$post[$extra]){$post[$extra]='0';}
			}
			
		$model = $this->getModel('panel');	
		if ($model->store($post)) 
			{
			//send email to admin
			$MailAdminPublish=$params->get('MailAdminPublish',0);
			$MailAdminPublish=1;
			
			if($productId)
				{ 
					$id = $productId;	
					$isNew = false;										
				}else{
					$id = $model->getLastModif();	
					$isNew = true;					
				}				
						if($MailAdminPublish==1)
							{
							$this->SendEmailToAdmin($id,$isNew);
							}				
			$model->storeProductCategory($post,$id);
			}
		/**/
	if($productId)
		{ 
		if(JRequest::getVar('myOrden', 'post', 'array' ))
			{
			$this->ChangeImageOrder(JRequest::getVar('myOrden', 'post', 'array' ));
			}
			
		$deleteimage	= JRequest::getVar( 'deleteimage', array(), 'post', 'array');	
		if($deleteimage)
			{	
			$photo = JPATH_SITE.DS."images".DS."properties".DS."images".DS.$productId.DS;	
			$thumb = JPATH_SITE.DS."images".DS."properties".DS."images".DS."thumbs".DS.$productId.DS;
				
			foreach($deleteimage as $image_name=>$valor)
				{		
				$query = 'DELETE FROM #__properties_images' .
				' WHERE name = \''.$image_name.'\'';				
				$db->setQuery( $query );
				if (!$db->query())
					{
					JError::raiseError(500, $db->getErrorMsg() );
					}						
			 	if (JFile::exists($photo.$image_name))
        			{
           			JFile::delete($photo.$image_name);
       		 		}
				if (JFile::exists($thumb.$image_name))
        			{
            		JFile::delete($thumb.$image_name);
       		 		}			
				}   
			}	
			
		}
			
	
	
		$msg = 'Item saved';
		
		switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
			JRequest::setVar( 'layout', 'form' );
			JRequest::setVar('cid', $id);			
			break;
			case 'save':
			JRequest::setVar( 'view', 'panel' );
			JRequest::setVar( 'layout', 'default' );	
			break;									
		}
		
		$app = JFactory::getApplication();
		$app->enqueueMessage( $msg );

		parent::display();				
		
	}
	
	
	
	function SendEmailToAdmin($id,$isNew)
	{
	global $mainframe;		
		
		$db		=& JFactory::getDBO();
		$sitename 		= $mainframe->getCfg( 'sitename' );		
		$mailfrom 		= $mainframe->getCfg( 'mailfrom' );
		$fromname 		= $mainframe->getCfg( 'fromname' );
		$post		= JRequest::get( 'post' );
		$user =& JFactory::getUser();
		$siteURL		= JURI::base();
		$UrlAdmin		= JURI::base().'administrator/index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id;

		//print_r($post);
				
		$body = JText::_( 'PUBLISH_BODY0').' '.$user->name.'('.$user->username.')['.$user->id.']'."\n".		
		JText::_( 'PUBLISH_BODY1').' '.$id."\n"
		.JText::_('PUBLISH_BODY2')."\n"
		.' '.$UrlAdmin.' '."\n".
		JText::_('PUBLISH_BODY3')."\n".
		$body."\n".
		JText::_('PUBLISH_BODY4').' '.$user->email;
		
		$subject=JText::_('PUBLISH_SUBJET');
		$subject.= $isNew ? ' (new)' : ' (edit)';
		//echo '<b>'.$subject.'</b><br>';		
		//echo $body;
		//require('a');
		//$this->send();	
		JUtility::sendMail($user->email, $user->name, $mailfrom, $subject, $body);
		
		
	}
	
	function GetCoord()
	{
	$post = JRequest::get( 'post' );
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$apikey=$params->get('apikey');

	$db 	=& JFactory::getDBO();

	$locid = $post['lid'];
    $stid = $post['sid'];
    $cnid = $post['cyid'];    

	$query1 = 'SELECT name FROM #__properties_country WHERE id = '.(int)$post['cyid'];		
        $db->setQuery($query1);        
		$Country = $db->loadResult();
	$query2 = 'SELECT name FROM #__properties_state WHERE id = '.(int)$post['sid'];		
        $db->setQuery($query2);        
		$State = $db->loadResult();
	$query3 = 'SELECT name FROM #__properties_locality WHERE id = '.(int)$post['lid'];		
        $db->setQuery($query3);        
		$Locality = $db->loadResult();				
    
  $mapaddress = str_replace( " ", "%20", urlencode($post['address']).", ".urlencode($Locality).", ".urlencode($State).", ".$post['postcode'].", ".urlencode($Country) );
        
        $file = "http://maps.google.com/maps/geo?q=".$mapaddress."&output=xml&key=".$apikey;

        $longitude = "";
        $latitude = "";
        if ( $fp = fopen( $file, "r" ) )
        {
            $coord = "<coordinates>";
            $coordlen = strlen( $coord );
            $r = "";
            while ( $data = fread( $fp, 32768 ) )
            {
                $r .= $data;
            }
            do
            {
                $foundit = stristr( $r, $coord );
                $startpos = strpos( $r, $coord );
                if ( 0 < strlen( $foundit ) )
                {
                    $mypos = strpos( $foundit, "</coordinates>" );
                    $mycoord = trim( substr( $foundit, $coordlen, $mypos - $coordlen ) );
                    list( $longitude, $latitude ) = split( ",", $mycoord );
                    $r = substr( $r, $startpos + 10 );
                }
            } while ( 0 < strlen( $foundit ) );
            fclose( $fp );
        }
	$coord = $latitude.','.$longitude;
	return $coord;
	}
	
	
	function ChangeImageOrder($array)
		{		
		$db 	=& JFactory::getDBO();		
		$myOrden=explode(',',$array);		
		
		for($x=0;$x<count($myOrden);$x++)
			{
			$image_id=explode('_',$myOrden[$x]);
			$CambiarOrden[$image_id[0]]=$x;			
			
			$query = 'UPDATE #__properties_images'
		. ' SET ordering = \'' . (int) $x
		. '\' WHERE id = '. (int) $image_id[0]
		;	
		
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}			
			}
		}
		
		
}
?>