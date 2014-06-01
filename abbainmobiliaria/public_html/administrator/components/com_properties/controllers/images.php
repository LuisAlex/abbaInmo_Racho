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

class PropertiesControllerImages extends PropertiesController
{
		function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask('save2new',		'save');
		$this->registerTask( 'unpublish', 	'publish');		
		$this->TableName = JRequest::getCmd('table');		
		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
		
	}



function publish()
	{
$this->TableName = 'images';
$product_id	= JRequest::getVar( 'product_id', '', '', 'int' );
$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
$this->publish	= ( $this->getTask() == 'publish' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $publish ? 'publish' : 'unpublish';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		
		$query  = 'UPDATE #__properties_images'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'		
		;		
			
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&view=images&product_id='.$product_id;
		$this->setRedirect($link, $msg);		
	}



	function saveorder(  )
	{		
		$this->TableName = 'images';
		$product_id	= JRequest::getVar( 'product_id', '', '', 'int' );
	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );	
	JArrayHelper::toInteger($cid, array(0));
	//$this->cids = implode( ',', $cid );
	$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );
	//$itemid		= JRequest::getVar( 'itemid', array(0), 'post', 'array' );
	foreach($cid as $cids=>$c){
	$query = 'UPDATE #__properties_images'
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

		$link = 'index.php?option=com_properties&view=images&product_id='.$product_id;
		$this->setRedirect($link, $msg);
}



	
	function orderup()
	{
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
$this->TableName = 'images';
		
		$product_id	= JRequest::getVar( 'product_id', '', '', 'int' );
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);


$link = 'index.php?option=com_properties&view='.$this->TableName.'&product_id='.$product_id;

		if (isset($cid[0]) && $cid[0]) {
			$id = $cid[0];
		} else {
			$this->setRedirect($link, $msg);
			return false;
		}

		$model =& $this->getModel( 'images' );
		if ($model->orderItem($id, -1)) {
			$msg = JText::_( 'Menu Item Moved Up' );
		} else {
			$msg = $model->getError();
		}
		/*$msg = $id;*/
		$this->setRedirect($link, $msg);
	}

	/**
	* Save the item(s) to the menu selected
	*/
	function orderdown()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
$this->TableName = 'images';
$product_id	= JRequest::getVar( 'product_id', '', '', 'int' );
		
		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

$link = 'index.php?option=com_properties&view='.$this->TableName.'&product_id='.$product_id;

		if (isset($cid[0]) && $cid[0]) {
			$id = $cid[0];
		} else {
			$this->setRedirect($link, $msg);
			return false;
		}

		$model =& $this->getModel( 'images' );
		if ($model->orderItem($id, 1)) {
			$msg = JText::_( 'Menu Item Moved Down' );
		} else {
			$msg = $model->getError();
		}
		$this->setRedirect($link, $msg);
	}	
	
	
	
	function save()
	{	
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');	
	

	$this->TableName = 'images';
	$model = $this->getModel('images');	
	$user =& JFactory::getUser();
$post = JRequest::get( 'post' );
$option = JRequest::getVar('option');
$component_name = 'properties';
	
	
$db 	=& JFactory::getDBO();
require_once(JPATH_SITE.DS.'configuration.php');

$datos = new JConfig();	
$basedatos = $datos->db;
$dbprefix = $datos->dbprefix;
$query = "SHOW TABLE STATUS FROM `".$basedatos."` LIKE '".$dbprefix.$component_name."_".$this->TableName."';";

		$db->setQuery( $query );		
		$nextAutoIndex = $db->loadObject();	
$id_imagen = $nextAutoIndex->Auto_increment;

$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );		
	$post['text'] = $text;

if (!empty($_FILES['files'])){


$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS;

$TotalImages=count($_FILES['files']['name']);

        for($i=0;$i<$TotalImages;$i++) { 
		
		$name = $_FILES['files']['name'][$i]; 
		if (!empty($name)) {
		$totalImagenes++;
		$nombreImagen[$i]=$_FILES['files']['name'][$i];		
		
		$ext =  JFile::getExt($name);

$nameImage=$i+$id_imagen.'_'.$post['parent'].'.'.$ext;

$imagenGuardada=$destino_imagen.DS.$post['parent'].DS.$nameImage;

$thumb=	$destino_imagen.'thumbs'.DS.$post['parent'].DS.$nameImage;

//JError::raiseError( 500, $ViviendaId );
$postI['name'] = $nameImage;
$postI['alias'] = '';
$postI['parent'] = $post['parent'];
$postI['published'] = 1;
$postI['ordering'] = $i;
$postI['type'] = $ext;
$postI['path'] = $imagenGuardada;
$ruta= JURI::root().'images/properties/images/'.$post['parent'].'/'.$nameImage;
$postI['rout'] = $ruta;
$postI['name_image'] = '';
$datenow =& JFactory::getDate();			
$postI['date'] = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
$postI['uid'] = $user->id;
$postI['cat_prod_id'] = 0;
$postI['product_id'] = $post['parent'];
$postI['text'] = '';


$path = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$post['parent'];
$paththumbs = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.'thumbs'.DS.$post['parent'];
		
	
	if(!JFolder::exists($path))
		{
		JFolder::create($path,0777);
		}
	if(!JFolder::exists($paththumbs))
		{
		JFolder::create($paththumbs,0777);
		}



		move_uploaded_file($_FILES['files']['tmp_name'] [$i],$imagenGuardada);		 
		@chmod($imagenGuardada, 0666);	

$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );		
$WidthImage=$params->get('WidthImage');
$HeightImage=$params->get('HeightImage');
if($WidthImage & $HeightImage)
	{
$this->CambiarTamano($imagenGuardada,$WidthImage,$HeightImage,$imagenGuardada);
	}
	
	
$this->CambiarTamano($imagenGuardada,200,150,$thumb);



	if ($model->store($postI)) {		
if($post['parent']){ $id = $post['parent'];

}
$Itemid = JRequest::getVar( 'Itemid' );
		switch (JRequest::getCmd( 'task' ))
		{
			case 'apply':
	//$this->setRedirect( 'index.php?option=com_gestor&view=administrar&Table='.$this->TableName.'&pt=3&task=edit&cid[]='.$id);
				break;
			case 'save':
	//$this->setRedirect( 'index.php?option=com_gestor&view=administrar&pt=5');
	$this->setRedirect( 'index.php?option=com_properties&view=images&product_id='.$post['parent']);
				break;	
				
		}

		$this->setMessage( JText::_( 'Images Saved !!!' ) );			
			
		} else {
			$msg = JText::_( 'Error Saving Greeting' );
			$msg .=  'err'.$this->Err;
		}
	


}
	}
	
}
/*
if (count( $post )) {foreach($post as $a=>$b) {$contenidoI .= "\n***********".$a.':'.$b;}	}

if (count( $postI )) {foreach($postI as $a=>$b) {$contenidoI .= "\n***********".$a.':'.$b;}	}
$nombre_archivo = 'components\com_gestor\fabio_images.txt';
$gestor = fopen($nombre_archivo, 'w');
$contenidoI .= "\n***********";
$contenidoI .= "\n TotalImages : ".$TotalImages;
fwrite($gestor, $contenidoI);
*/
	

	}

	
	
	/** remove record(s)	 */
	function remove()
	{
	$this->TableName = JRequest::getCmd('table');
	$product_id=JRequest::getVar( 'product_id', 0, '', 'int' );
		$model = $this->getModel('images');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {

			$msg .= JText::_( 'Deleted' ).' : '.$cid ;
			
}			
		}

		$this->setRedirect( 'index.php?option=com_properties&view=images&product_id='.$product_id, $msg );
	}

	/**	 * cancel editing a record */
	function cancel()
	{
			$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=images', $msg );
	}	



	/** remove record(s)	 */
	function delimg()
	{
	$this->TableName = JRequest::getCmd('Tabla');
		$model = $this->getModel('administrar');
		if(!$model->deleteimg()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$id = JRequest::getVar('id');
			$msg .= JText::_( 'Borrada Imagen  : '.$id );
			
		}

		$this->setRedirect( 'index.php?option=com_gestor&controller=administrar&Tabla='.$this->TableName.'&task=edit&cid[]='.$id, $msg );
		//echo 'borar'.JRequest::getVar('borrar');
		//echo '<br>id:'.JRequest::getVar('id');
	}


	function deldoc()
	{
	$this->TableName = JRequest::getCmd('Tabla');
		$model = $this->getModel('administrar');
$id = JRequest::getVar('id');		
		if(!$model->deletedoc()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {

			$msg .= JText::_( 'Borrado Doc  : '.$id );
			
		}

		$this->setRedirect( 'index.php?option=com_gestor&controller=administrar&Tabla='.$this->TableName.'&task=edit&cid[]='.$id, $msg );
		//echo 'borar'.JRequest::getVar('borrar');
		//echo '<br>id:'.JRequest::getVar('id');
	}
	
			
	
	function CambiarTamano($imagenGuardada,$max_width,$max_height,$peque)
{


$InfoImage=getimagesize($imagenGuardada);               
                $width=$InfoImage[0];
                $height=$InfoImage[1];
				$type=$InfoImage[2];
$max_height = $max_width;

	$x_ratio = $max_width / $width;
	$y_ratio = $max_height / $height;
	
if (($x_ratio * $height) < $max_height) {
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
                          $img = imagecreatefromgif($imagenGuardada);
                          $thumb = imagecreatetruecolor($width,$height);
                        imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
                        ImageGIF($thumb,$peque,100);
						
                        break;
                     }
                    case 2: //jpg,jpeg
                     {					 
                          $img = imagecreatefromjpeg($imagenGuardada);
                          $thumb = imagecreatetruecolor($width,$height);
                         imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
                         ImageJPEG($thumb,$peque);
                        break;
                     }
                    case 3: //png
                     {
                          $img = imagecreatefrompng($imagenGuardada);
                          $thumb = imagecreatetruecolor($width,$height);
                        imagecopyresampled($thumb,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
                        ImagePNG($thumb,$peque);
                        break;
                     }
                  } // switch				  

}
	
	
	












function generate_folder_thumbs()
	{
		
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');	
	

	$this->TableName = 'images';
	$model = $this->getModel('images');	
	$user =& JFactory::getUser();
$post = JRequest::get( 'post' );
$option = JRequest::getVar('option');
$component_name = 'properties';
	
	
$db 	=& JFactory::getDBO();
require_once(JPATH_SITE.DS.'configuration.php');

$datos = new JConfig();	
$basedatos = $datos->db;
$dbprefix = $datos->dbprefix;
$query = "SHOW TABLE STATUS FROM `".$basedatos."` LIKE '".$dbprefix.$component_name."_".$this->TableName."';";

		$db->setQuery( $query );		
		$nextAutoIndex = $db->loadObject();	
$id_imagen = $nextAutoIndex->Auto_increment;

if (!empty($post['img_name'])){

$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS;



$TotalImages=count($post['img_name']);

        for($i=0;$i<$TotalImages;$i++) { 
		
		$name = $post['img_name'][$i]; 
		if (!empty($name)) {
		$totalImagenes++;
		$nombreImagen[$i]=$_FILES['files']['name'][$i];		
		
		$ext =  JFile::getExt($name);

$oldimage=$destino_imagen.DS.$post['parent'].DS.$name;
$nameImage=$i+$id_imagen.'_'.$post['parent'].'.'.$ext;

$imagenGuardada=$destino_imagen.DS.$post['parent'].DS.$nameImage;

$thumb=	$destino_imagen.'thumbs'.DS.$post['parent'].DS.$nameImage;


$postI['name'] = $nameImage;
$postI['alias'] = '';
$postI['parent'] = $post['parent'];
$postI['published'] = 1;
$postI['ordering'] = $i;
$postI['type'] = $ext;
$postI['path'] = $imagenGuardada;
$ruta= JURI::root().'images/properties/images/'.$post['parent'].'/'.$nameImage;
$postI['rout'] = $ruta;
$postI['name_image'] = '';
$datenow =& JFactory::getDate();			
$postI['date'] = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
$postI['uid'] = $user->id;
$postI['cat_prod_id'] = 0;
$postI['product_id'] = '';
$postI['text'] = '';


$path = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$post['parent'];
$paththumbs = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.'thumbs'.DS.$post['parent'];
		
	
	if(!JFolder::exists($path))
		{
		JFolder::create($path,0777);
		}
	if(!JFolder::exists($paththumbs))
		{
		JFolder::create($paththumbs,0777);
		}




		//move_uploaded_file($_FILES['files']['tmp_name'] [$i],$imagenGuardada);		 
		//@chmod($imagenGuardada, 0666);	
JFolder::move($oldimage, $imagenGuardada);
$this->CambiarTamano($imagenGuardada,200,150,$thumb);

if ($model->store($postI)) {$msg.='added : '.$nameImage.' , '; }

}
}
}


	
	
$this->setRedirect( 'index.php?option=com_properties&view=images&product_id='.$post['parent']);

$this->setMessage( JText::_( 'Images Added !!!' ) );
		
}		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function saveImagesList()
	{
	$product_id=JRequest::getVar('product_id');
	
	$post=JRequest::get('post');
	print_r($post);
	
	$parent = JRequest::getVar( 'productid','','post' );
	
	$sectors = JRequest::getVar( 'sector','','post' );
	$text = JRequest::getVar( 'text','','post' );
	//print_r($sectors);
	
	$model = $this->getModel('images');
	
	
	
	
	foreach($sectors as $p => $val)
		{
		echo $p.' '.$val.' :::: '.$text[$p].'<br>';
		$data['id']=$p;
		$data['sector']=$val;
		$data['text']=$text[$p];
		if ($model->store($data,'rates')) {	
		}
		}
	//require('aa');	
		
	$this->setRedirect( 'index.php?option=com_properties&view=images&product_id='.$product_id);
	
	
	
	//require('aaa');
	}
	
	
	
			
	
	function swfupload_files()
	{
	jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');	
	

	$this->TableName = 'images';
	$model = $this->getModel('images');	
	$user =& JFactory::getUser();
$post = JRequest::get( 'post' );
$option = JRequest::getVar('option');
$component_name = 'properties';
	
	
$db 	=& JFactory::getDBO();
require_once(JPATH_SITE.DS.'configuration.php');

$datos = new JConfig();	
$basedatos = $datos->db;
$dbprefix = $datos->dbprefix;
$query = "SHOW TABLE STATUS FROM `".$basedatos."` LIKE '".$dbprefix.$component_name."_".$this->TableName."';";
//echo $query;require('a');
		$db->setQuery( $query );		
		$nextAutoIndex = $db->loadObject();	
$id_imagen = $nextAutoIndex->Auto_increment;


 $idproduct = JRequest::getVar('idproduct');

$fieldName = 'Filedata';
 

$fileError = $_FILES[$fieldName]['error'];
if ($fileError > 0) 
{
        switch ($fileError) 
        {
        case 1:
        echo JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );
        return;
 
        case 2:
        echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
        return;
 
        case 3:
        echo JText::_( 'ERROR PARTIAL UPLOAD' );
        return;
 
        case 4:
        echo JText::_( 'ERROR NO FILE' );
        return;
        }
}
 

$fileSize = $_FILES[$fieldName]['size'];
if($fileSize > 5000000)
{
    echo JText::_( 'FILE BIGGER THAN 5MB' );
}

$fileName = $_FILES[$fieldName]['name'];
$fileExt = JFile::getExt($fileName);

$validFileExts = explode(',', 'jpeg,jpg,png,gif');

foreach($validFileExts as $key => $value)
{
        if( preg_match("/$value/i", $fileExt ) )
        {
                $extOk = true;
        }
}
 
if ($extOk == false) 
{
        echo JText::_( 'INVALID EXTENSION' ).$fileExt;
        return;
}


$fileTemp = $_FILES[$fieldName]['tmp_name'];

$imageinfo = getimagesize($fileTemp);



$fileName = $id_imagen.'_'.$idproduct.'.'.$fileExt;
 

$uploadPath = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$idproduct.DS.$fileName;
 
if(!JFile::upload($fileTemp, $uploadPath)) 
{
        echo JText::_( 'ERROR MOVING FILE' );
        return;
}
else
{
   // success, exit with code 0 for Mac users, otherwise they receive an IO Error
  // exit(0);
  
}
$_SESSION["file_info"][$file_id] = $fileName;
echo "FILEID:" . $idproduct.'/'.$fileName;


$postI['name'] = $fileName;
$postI['alias'] = '';
$postI['parent'] = $idproduct;
$postI['published'] = 1;
$postI['ordering'] = 0;
$postI['type'] = $fileExt;
$postI['name_image'] = '';
$datenow =& JFactory::getDate();			
$postI['date'] = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
$postI['uid'] = $user->id;


$path = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$idproduct;
$paththumbs = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.'thumbs'.DS.$idproduct;
		
	
	if(!JFolder::exists($path))
		{
		JFolder::create($path,0777);
		}
	if(!JFolder::exists($paththumbs))
		{
		JFolder::create($paththumbs,0777);
		}


$imagenGuardada = $uploadPath;
$thumb=	$paththumbs.DS.$fileName;
$this->CambiarTamano($imagenGuardada,200,150,$thumb);

if ($model->store($postI)) { }



	}





	
	
}