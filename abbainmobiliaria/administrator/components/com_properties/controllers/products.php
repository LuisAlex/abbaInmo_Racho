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

class PropertiesControllerProducts extends PropertiesController
{	 
	function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask('save2new',		'save');
		$this->registerTask( 'unpublish', 	'publish');	
		$this->registerTask( 'unshow', 	'show');	
		$this->registerTask( 'nodestacado', 	'destacado');	
		$this->TableName = JRequest::getCmd('table');		

		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));

		if(JRequest::getCmd('task') == 'orderup'){
		$this->orderSection( $this->cid[0], -1);
		}elseif(JRequest::getCmd('task') == 'orderdown'){
		$this->orderSection( $this->cid[0], 1);
		}
		
	}	
	

	function publish()
	{
$this->TableName = 'products';	
$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
$this->publish	= ( $this->getTask() == 'publish' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $publish ? 'publish' : 'unpublish';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		
		$query  = 'UPDATE #__properties_products'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $this->cids .' )'		
		;		
			
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		$link = 'index.php?option=com_properties&view=products';
		$this->setRedirect($link, $msg);		
	}


	
	function destacado()
	{
$this->TableName = 'products';	
$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
$this->destacado	= ( $this->getTask() == 'destacado' ? 1 : 0 );		
	
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1)		{
			$action = $destacado ? 'destacado' : 'nodestacado';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		$this->cids = implode( ',', $cid );
		$query =' UPDATE #__properties_products'
		. ' SET `featured` = ' . (int) $this->destacado
		. ' WHERE id IN ( '. $this->cids .' )'		
		;			
		
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		
		
		$link = 'index.php?option=com_properties&view=products';
		$this->setRedirect($link, $msg);		
	}
	
		
	function saveorder(  )
	{		
		$this->TableName = JRequest::getVar('table');
	$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );	
	JArrayHelper::toInteger($cid, array(0));
	//$this->cids = implode( ',', $cid );
	$order		= JRequest::getVar( 'order', array(0), 'post', 'array' );
	//$itemid		= JRequest::getVar( 'itemid', array(0), 'post', 'array' );
	foreach($cid as $cids=>$c){
	$query = 'UPDATE #__properties_products'
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

		$link = 'index.php?option=com_properties&view=products';
		$this->setRedirect($link, $msg);
}
	

	function orderSection( $uid, $inc)
	{	
	$this->TableName = 'products';
	global $mainframe;	
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$model = $this->getModel('products');		
	$db			=& JFactory::getDBO();
	$row		=& JTable::getInstance($this->TableName,'Table');
	$row->load( $uid );
	$row->move( $inc );			
	
	$link = 'index.php?option=com_properties&view=products';
		$this->setRedirect($link, $msg);
	}

	/**	 * display the edit form	 */
	
	function edit()
	{
		JRequest::setVar( 'view', 'products' );
		JRequest::setVar( 'layout', 'form' );		
		parent::display();
	}

	function gosendmail()
	{
	$post = JRequest::get( 'post' );	
	$id = $post['id'];
		$this->setRedirect( 'index.php?option=com_properties&view=sendmail&layout=form&task=edit&cid[]='.$id);
		$msg = JText::_( 'Form to send email to agent' );	
		$this->setMessage( JText::_( $msg ) );

	}
	/**
	 * save a record (and redirect to main page)	 */
	function save()
	{
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	$this->TableName = 'products';
	$model = $this->getModel('products');	
	$component_name = 'properties';			
	$post = JRequest::get( 'post' );
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$AutoCoord=$params->get('AutoCoord',0);
	
	$db 	=& JFactory::getDBO();

		if($AutoCoord){
			if(!$post['lat']){
				$coord=$this->GetCoord();
				$ll=explode(',',$coord);
				if($ll[0]!=0){$post['lat']=$ll[0];}
				if($ll[1]!=0){$post['lng']=$ll[1];}
			}
		}	

		if(JRequest::getVar('id')){ $id_imagen = JRequest::getVar('id');}else{$id_imagen = $nextAutoIndex->Auto_increment;}

for ($ex=1;$ex<41;$ex++){
$extra='extra'.$ex;
if(!$post[$extra]){$post[$extra]='0';}
}

	$text = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$text		= str_replace( '<br>', '<br />', $text );		
		$post['text'] = $text;

	$description = JRequest::getVar( 'short_text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$description		= str_replace( '<br>', '<br />', $description );		
		$post['description'] = $description;
	
	$video = JRequest::getVar( 'video', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$video		= str_replace( '<br>', '<br />', $video );		
		$post['video'] = $video;

$product_params		= JRequest::getVar( 'params', null, 'post', 'array' );
		if (is_array($product_params))
		{
			$txt = array ();
			foreach ($product_params as $k => $v) {
				$txt[] = "$k=$v";
			}
			$post['params'] = implode("\n", $txt);
		}
			
	if ($model->store($post)) {	
$msg = 	JText::_('Saved').' ( '.$post['name'].' ) ';
		$LastModif = $model->getLastModif();

		
			$model->storeProductCategory($post,$LastModif);
		
		

	
		if(JRequest::getVar('id')){ $id = JRequest::getVar('id');}else{$id = $LastModif;}

if(JRequest::getVar('myOrden')){
$this->ChangeImageOrder(JRequest::getVar('myOrden'));
}

	
	$deleteimage	= JRequest::getVar( 'deleteimage', array(), 'post', 'array');	
if($deleteimage)
	{	
	$photo = JPATH_SITE.DS."images".DS."properties".DS."images".DS.$id.DS;	
	$thumb = JPATH_SITE.DS."images".DS."properties".DS."images".DS."thumbs".DS.$id.DS;

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
	

$path = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.$id;
$paththumbs = JPATH_SITE.DS.'images'.DS.'properties'.DS.'images'.DS.'thumbs'.DS.$id;
		
	
	if(!JFolder::exists($path))
		{
		JFolder::create($path,0777);
		}
	if(!JFolder::exists($paththumbs))
		{
		JFolder::create($paththumbs,0777);
		}
			switch (JRequest::getCmd( 'task' ))
			{
				case 'apply':
					$this->setRedirect( 'index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id);	
				break;
				case 'save':
					$this->setRedirect( 'index.php?option=com_properties&view=products');	
				break;		
				
			case 'save2new':
				$this->setRedirect(JRoute::_('index.php?option=com_properties&view=products&layout=form&task=edit', false));
	$msg.='. '.JText::_('You can add new Product');
				break;						
			}

				
			
	} else {
			$msg = JText::_( 'Error Saving Greeting' );
			$msg .=  'err'.$this->Err;
	}
$this->setMessage( JText::_( $msg ) );

	}



function ChangeImageOrder($array)
		{
		
		$db 	=& JFactory::getDBO();
		
		$myOrden=explode(',',$array);
		
		
		
		for($x=0;$x<count($myOrden);$x++)
			{
			$image_id=explode('_',$myOrden[$x]);
			$CambiarOrden[$image_id[0]]=$x;
			//echo $myOrden[$x];
			
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
		
	/** remove record(s)	 */
	function remove()
	{
	$this->TableName = 'products';
		$model = $this->getModel('products');
			if(!$model->delete()) {
				$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
			} else {
				$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
					foreach($cids as $cid) {

					$msg .= JText::_( 'Deleted product : '.$cid );
						
			
					}			
			}

		$this->setRedirect( 'index.php?option=com_properties&view=products', $msg );
	}
	
	
	
	
	function trash()
	{
	global $mainframe;
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$model = $this->getModel('products');
	
		$db		= & JFactory::getDBO();
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$msg  = JText::_( 'Trashed products : ');	
		$db			=& JFactory::getDBO();
				$row		=& JTable::getInstance('products','Table');	
		foreach($cids as $cid) 
			{
				$msg .= ' ('.$cid.') ' ;			
				$row->load($cid);
				$row->published = '-2';

				if (!$row->check()) {
					JError::raiseError( 500, $row->getError() );
					return false;
				}

				if (!$row->store()) {
					JError::raiseError( 500, $row->getError() );
					return false;
				}
		
							
			}

		$this->setRedirect( 'index.php?option=com_properties&view=products', $msg );
	}
	
	
	

	/**	 * cancel editing a record */
	function cancel()
	{
	$this->TableName = JRequest::getCmd('table');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_properties&view=products', $msg );
	}	



	/** remove record(s)	 */
	function delimg()
	{
	$this->TableName = JRequest::getCmd('table');
		$campo =  'image'.JRequest::getVar('borrar');
		$model = $this->getModel('products');
		
		if(!$model->deleteimg()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
	$id = JRequest::getVar('id');
			$msg .= JText::_( 'Borrada Imagen  : '.$campo );
		}

		$this->setRedirect( 'index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id.'&tab=2', $msg );
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

	$query1 = 'SELECT name FROM #__properties_country WHERE id = '.$post['cyid'];		
        $db->setQuery($query1);        
		$Country = $db->loadResult();
	$query2 = 'SELECT name FROM #__properties_state WHERE id = '.$post['sid'];		
        $db->setQuery($query2);        
		$State = $db->loadResult();
	$query3 = 'SELECT name FROM #__properties_locality WHERE id = '.$post['lid'];		
        $db->setQuery($query3);        
		$Locality = $db->loadResult();				
   
	$mapaddress = str_replace( " ", "%20", $post['address'].", ".$Locality.", ".$State.", ".$post['postcode'].", ".$Country );
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
	
		
	
	function CambiarTamano($nombre,$max_width,$max_height,$destinoCopia,$destinoNombre,$destino)
{

$InfoImage=getimagesize($destino.$nombre);               
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



	function clonar()
	{
$this->TableName = 'products';	
$db 	=& JFactory::getDBO();
$id		= JRequest::getVar( 'id' );	

$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
JArrayHelper::toInteger($cid);	
		if (count( $cid ) < 1)		{
			$action = $publish ? 'publish' : 'unpublish';		
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
$this->cids = implode( ',', $cid );				
		
		$query = 'SELECT * FROM #__properties_products WHERE id = '. $this->cids;		
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
				
		$existe = $db->loadObject();
		
		$existe->id='';
$model = $this->getModel('products');		
if ($model->store($existe)) { }		
		
		$link = 'index.php?option=com_properties&view='.$this->TableName;
		$this->setRedirect($link, $msg);		
	}




function exportxml()
	{
	global $mainframe;
	$db 	=& JFactory::getDBO();
	$id=JRequest::getInt('id');
	
	$query = 	"SELECT * from #__properties_products where id = ".$id;
	$db->setQuery( $query );				
	$products = $db->loadObject();
	$arr = (array)$products;
	
	$crlf="\n";
	$line  =  '<?xml version="1.0" encoding="utf-8"?>' . $crlf;
	
	$line  .=  '<properties>'. $crlf;
	$line  .=  '<property>'. $crlf;
	foreach($arr as $k => $v)
		{
			if($k==text){
			$line.='<'.$k.'><![CDATA['.$v.']]></'.$k.'>' . $crlf;
			}else{
			$line.='<'.$k.'>'.$v.'</'.$k.'>' . $crlf;
			}
		}
		$line  .=  '</property>'. $crlf;
		
		
	
	$query = 	"SELECT * from #__properties_rates where productid = ".$id;
	$db->setQuery( $query );				
	$rates = $db->loadObjectList();
	
	foreach($rates as $rate)
		{
		
		
	$ratesarr = (array)$rate;	
	$line  .=  '<rate>'. $crlf;
	foreach($ratesarr as $k => $v)
		{			
			$line.='<'.$k.'>'.$v.'</'.$k.'>' . $crlf;			
		}
	$line  .=  '</rate>'. $crlf;
		
		}
		
		
		
		
		
	$query = 	"SELECT * from #__properties_available_product where id_product = ".$id;
	$db->setQuery( $query );				
	$availables = $db->loadObjectList();
	
	foreach($availables as $available)
		{		
	$availablearr = (array)$available;	
	$line  .=  '<available_product>'. $crlf;
	foreach($availablearr as $k => $v)
		{			
			$line.='<'.$k.'>'.$v.'</'.$k.'>' . $crlf;			
		}
	$line  .=  '</available_product>'. $crlf;		
		}
		
		
		
	$line  .=  '</properties>'. $crlf;	
		
	
		
	//$archivo_xml = fopen("components/com_properties/xmlproperty.xml", "w");
	$archivo_xml = fopen(JPATH_SITE.DS."xmlproperty.xml", "w");
	fwrite($archivo_xml, $line);
	fclose($archivo_xml);	
	print_r($arr);
	$domains=array();
	
	$domains[0]='http://localhost/france_lloretvillas';
	$domains[1]='http://localhost/spain_lloretvillas';
	$xml='/index.php?option=com_properties&controller=updateproducts&task=updateproduct&id='.$id;
		
	foreach($domains as $Host)
		{
		
		$sendxml=$Host.$xml;
		$resp = $http_response_header[0];
		$resp = file_get_contents($sendxml);
		//var_dump($http_response_header[0]);
		//require('a');
		echo $resp;
		$msg.=$Host.' : '.$http_response_header[0].' : '.$resp.'  <br>';
		}
	
	$this->setRedirect( 'index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id, $msg );
	
	
	}


}