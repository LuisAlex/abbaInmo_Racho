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

class PropertiesControllerProfiles extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask( 'unpublish', 	'publish');			
		$this->registerTask( 'unshow', 	'show');
		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));

		if(JRequest::getCmd('task') == 'orderup'){
		$this->orderSection( $this->cid[0], 1);
		}elseif(JRequest::getCmd('task') == 'orderdown'){
		$this->orderSection( $this->cid[0], -1);
		}
		$this->TableName = JRequest::getCmd('table');
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
		
		$query = 'UPDATE #__properties_profiles'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'		
		;			
		
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&view=profiles';
		$this->setRedirect($link, $msg);		
	}



function show()
	{
	
	$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
	$this->show	= ( $this->getTask() == 'show' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $show ? 'show' : 'unshow';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		$query =' UPDATE #__properties_profiles'
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
		$link = 'index.php?option=com_properties&view=profiles';
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
	$query = 'UPDATE #__properties_profiles'
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

		$link = 'index.php?option=com_properties&view=profiles';
		$this->setRedirect($link, $msg);
}
	

	function orderSection( $uid, $inc)
	{	
	$this->TableName = 'profiles';
	global $mainframe;	
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$model = $this->getModel('profiles');		
	$db			=& JFactory::getDBO();
	$row		=& JTable::getInstance($this->TableName,'Table');
	$row->load( $uid );
	$row->move( $inc );			
	$msg = $uid.' : '.$inc;
	$link = 'index.php?option=com_properties&view=profiles';
		$this->setRedirect($link, $msg);
	}

	/**	 * display the edit form	 */
	
	function edit()
	{
		JRequest::setVar( 'view', 'profiles' );
		JRequest::setVar( 'layout', 'form' );
		parent::display();
	}

	/**
	 * save a record (and redirect to main page)	 */
	function save()
	{
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	$component_name = 'properties';
	$option = JRequest::getVar('option');	
	$model = $this->getModel('profiles');
	$this->TableName='profiles';
				
$post = JRequest::get( 'post' );
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$AutoCoord=$params->get('AutoCoord',0);

$db 	=& JFactory::getDBO();
require_once(JPATH_SITE.DS.'configuration.php');
$datos = new JConfig();	
$basedatos = $datos->db;
$dbprefix = $datos->dbprefix;
$query = "SHOW TABLE STATUS FROM `".$basedatos."` LIKE '".$dbprefix.$component_name."_".$this->TableName."';";
		$db->setQuery( $query );		
		$nextAutoIndex = $db->loadObject();
$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS;		


if(JRequest::getVar('id')){
$id_agent=JRequest::getVar('id');
}else{
$id_agent=$nextAutoIndex->Auto_increment;
}
if (isset($_FILES['image'])){ 

$name = $_FILES['image']['name'];	
if (!empty($name)) {		
		$ext = '.'.JFile::getExt($name);
		
$personal_image = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS;
move_uploaded_file($_FILES['image']['tmp_name'],	$personal_image.$id_agent.'_p'.$ext); 
$post['image'] = $id_agent.'_p'.$ext;
$AnchoLogo=140;
$AltoLogo=200;
$destinoCopia=$personal_image;
$destinoNombre=$post['image'];
$destino = $personal_image;
$this->CambiarTamanoExacto($post['image'],$AnchoLogo,$AltoLogo,$destinoCopia,$destinoNombre,$destino);

}
}

if (isset($_FILES['logo_image'])){ 

$name = $_FILES['logo_image']['name'];	
if (!empty($name)) {			
		$ext = '.'.JFile::getExt($name);
$personal_image = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS;
move_uploaded_file($_FILES['logo_image']['tmp_name'],	$personal_image.$id_agent.'_l'.$ext); 
$post['logo_image'] = $id_agent.'_l'.$ext;
$AnchoLogo=140;
$AltoLogo=45;
$destinoCopia=$personal_image;
$destinoNombre=$post['logo_image'];
$destino = $personal_image;
$this->CambiarTamanoExacto($post['logo_image'],$AnchoLogo,$AltoLogo,$destinoCopia,$destinoNombre,$destino);

}
}
if (isset($_FILES['logo_image_large'])){ 

$name = $_FILES['logo_image_large']['name'];	
if (!empty($name)) {			
		$ext = '.'.JFile::getExt($name);
$personal_image = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS;
move_uploaded_file($_FILES['logo_image_large']['tmp_name'],	$personal_image.$id_agent.'_ll'.$ext); 
$post['logo_image_large'] = $id_agent.'_ll'.$ext;
$AnchoLogo=500;
$AltoLogo=160;
$destinoCopia=$personal_image;
$destinoNombre=$post['logo_image_large'];
$destino = $personal_image;
$this->CambiarTamanoExacto($post['logo_image_large'],$AnchoLogo,$AltoLogo,$destinoCopia,$destinoNombre,$destino);



}
}
jimport('joomla.filesystem.file');
$imagePath = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS;	

	
if($post['deleteimage'])
	{
	$query = "SELECT * FROM #__properties_profiles WHERE id = ".$post['id'];
		$db->setQuery( $query );		
		$profile = $db->loadResultArray();
		
	foreach($post['deleteimage'] as $field => $iamgeName )
		{
		echo '<br>'.$iamgeName;
		if(!JFile::delete($imagePath.$iamgeName))
			{
			echo 'error to delete<br>'.$imagePath.$iamgeName;
			}else{
			echo 'deleted<br>'.$imagePath.$iamgeName;
			}
		$post[$field]='';
		}
	}

	
if(!$post['email'])
	{
	$userMid =& JFactory::getUser($post['mid']);
	$post['email']=$userMid->email;
	}


$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
	$text		= str_replace( '<br>', '<br />', $text );		
	$post['text'] = $text;

			
	if ($model->store($post)) {	

$LastModif = $model->getLastModif();
	
if(JRequest::getVar('id')){ $id = JRequest::getVar('id');}else{$id = $LastModif;}

$msg='Saved  profile  : '.$LastModif.'!  ';
				switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
	$this->setRedirect( 'index.php?option=com_properties&view=profiles&layout=form&task=edit&cid[]='.$id);
	
				break;
			case 'save':
	$this->setRedirect( 'index.php?option=com_properties&view=profiles');
	
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
	$this->TableName = 'profiles';
		$model = $this->getModel('profiles');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {

			$msg .= JText::_( 'Deleted '.$this->TableName.' : '.$cid );
			
}			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=profiles', $msg );
	}

	/**	 * cancel editing a record */
	function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=profiles', $msg );
	}	


function CambiarTamanoExacto($nombre,$max_width,$max_height,$destinoCopia,$destinoNombre,$destino)
{


$InfoImage=getimagesize($destino.$nombre);               
                $width=$InfoImage[0];
                $height=$InfoImage[1];
				$type=$InfoImage[2];						 
						
	$x_ratio = $max_width / $width;
	$y_ratio = $max_height / $height;

	if (($width <= $max_width) && ($height <= $max_height) ) {
		$tn_width = $width;
		$tn_height = $height;
	} else if (($x_ratio * $height) < $max_height) {
		$tn_height = ceil($x_ratio * $height);
		$tn_width = $max_width;
	} else {
		$tn_width = ceil($y_ratio * $width);
		$tn_height = $max_height;
	}
$width=$tn_width;
$height	=$tn_height;	

		 
switch($type)
                  {
                    case 1: //gif
                     {
                          $img = imagecreatefromgif($destino.$nombre);
                          $thumb = imagecreatetruecolor($width,$height);
                        imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
                        ImageGIF($thumb,$destinoCopia.$destinoNombre,100);
						
                        break;
                     }
                    case 2: //jpg,jpeg
                     {					 
                          $img = imagecreatefromjpeg($destino.$nombre);
                          $thumb = imagecreatetruecolor($width,$height);
                         imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
                         ImageJPEG($thumb,$destinoCopia.$destinoNombre);
                        break;
                     }
                    case 3: //png
                     {
                          $img = imagecreatefrompng($destino.$nombre);
                          $thumb = imagecreatetruecolor($width,$height);
                        imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
                        ImagePNG($thumb,$destinoCopia.$destinoNombre);
                        break;
                     }
                  } // switch				  

}
	
	
}