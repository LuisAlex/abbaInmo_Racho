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
        echo JText::_( 'ARCHIVO DEMASIADO GRANDE PARA LA BD' );
        return;
 
        case 2:
        echo JText::_( 'ARCHIVO DEMASIADO GRANDE' );
        return;
 
        case 3:
        echo JText::_( 'ERROR PARCIAL DE SUBIDA' );
        return;
 
        case 4:
        echo JText::_( 'ERROR NO EXISTE ARCHIVO' );
        return;
        }
}
 

$fileSize = $_FILES[$fieldName]['size'];
if($fileSize > 5000000)
{
    echo JText::_( 'ARCHIVO MAYOR A 5MB' );
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
        echo JText::_( 'EXTENCION INVALIDA (.jpg,png,gif)' ).$fileExt;
        return;
}


$fileTemp = $_FILES[$fieldName]['tmp_name'];

$imageinfo = getimagesize($fileTemp);



$fileName = $id_imagen.'_'.$idproduct.'.'.$fileExt;
 

$uploadPath = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$idproduct.DS.$fileName;
 
if(!JFile::upload($fileTemp, $uploadPath)) 
{
        echo JText::_( 'ERROR AL MOVER EL ARCHIVO' );
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
