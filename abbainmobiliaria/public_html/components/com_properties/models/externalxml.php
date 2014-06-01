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

jimport( 'joomla.application.component.model' );

class PropertiesModelExternalxml extends JModel
{
	var $_data;
	var $_total = null;
	var $_pagination = null;

function __construct()
  {
 	parent::__construct();
	global $mainframe, $option;

$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$this->Mostrar = $params->get( 'cantidad_productos' ) ;

if(!JRequest::getVar('limitstart', 0, '', 'int')){
	$this->setState('limit', $this->Mostrar);
	$this->setState('limitstart', 0);
}else{
	$limit = $this->Mostrar;
	$this->setState('limit', $this->Mostrar);
	
$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
$this->setState('limitstart', $limitstart);	

$start = JRequest::getVar('start', 0, '', 'int');
$this->setState('start', $start);	
}
$ShowOrderByDefault=$params->get('ShowOrderByDefault');
$ShowOrderDefault=$params->get('ShowOrderDefault');

$this->filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order",		'filter_order',	$ShowOrderByDefault ,	'cmd' );
$this->filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	$ShowOrderDefault,		'word' );

$menus = &JSite::getMenu();
$menu  = $menus->getActive();
$menu_params = new JParameter( $menu->params );

$xmlurl=$menu_params->get( 'xmlurl');

$this->xmlurl = $xmlurl;

  }


	


	
function getData() 
  {  
 	//echo $this->xmlurl;
	
	
	$Base_url=$this->xmlurl;
	$xml = simplexml_load_file($Base_url); 
//$return_data = new JObject();	
	$x=0;
	foreach($xml as $key0 => $value){
$return_data[$x] = new JObject();	
$return_data[$x]->id = $value->uniqueID;
$return_data[$x]->price = $value->price;

$return_data[$x]->address = $value->address->streetNumber;
$return_data[$x]->address .= ' '.$value->address->street;
$return_data[$x]->name_locality = $value->address->suburb;
$return_data[$x]->name_state = $value->address->state;
$return_data[$x]->postcode = $value->address->postcode;
$return_data[$x]->name_category = $value->category->attributes()->name;

$return_data[$x]->text = $value->description;









echo '<br />--------';
echo '<br />';
echo '<br />';


echo '<br />modTime: ';
echo $value->attributes()->modTime;
echo '<br />status: ';
echo $value->attributes()->status;
echo '<br />';

echo '<br />agentID: ';
echo $value->agentID;

echo '<br />uniqueID: ';
echo $value->uniqueID;

echo '<br />auhority: ';
echo $value->authority->attributes()->value;

echo '<br />underOffer: ';
echo $value->underOffer->attributes()->value;


echo '<br />listingAgent id: ';
echo $value->listingAgent->attributes()->id;

echo '<br />listingAgent name: ';
echo $value->listingAgent->name;

echo '<br />listingAgent phones: ';

echo '<br />listingAgent phone mobile: ';
echo $value->listingAgent->telephone[0];

echo '<br />listingAgent phone BH : ';
echo $value->listingAgent->telephone[1];

echo '<br />listingAgent email: ';
echo $value->listingAgent->email;


echo '<br /> price: ';
echo $value->price;

echo '<br /> priceView: ';
echo $value->priceView;

echo '<br /> address : display : ';
echo $value->address->attributes()->display;


echo '<br /> address : streetNumber : ';
echo $value->address->streetNumber;

echo '<br /> address : street : ';
echo $value->address->street;

echo '<br /> address : suburb : ';
echo $value->address->suburb;

echo '<br /> address : state : ';
echo $value->address->state;

echo '<br /> address : postcode : ';
echo $value->address->postcode;




echo '<br />category : name : ';
echo $value->category->attributes()->name;


echo '<br />description :  ';
echo $value->description;

echo '<br />features :  ';

echo '<br />bedrooms :  ';
echo $value->features->bedrooms;

echo '<br />bathrooms :  ';
echo $value->features->bathrooms;

echo '<br />garages :  ';
echo $value->features->garages;

echo '<br />carports :  ';
echo $value->features->carports;

echo '<br />airConditioning :  ';
echo $value->features->airConditioning;

echo '<br />pool :  ';
echo $value->features->pool;

echo '<br />alarmSystem :  ';
echo $value->features->alarmSystem;

echo '<br />openSpaces :  ';
echo $value->features->openSpaces;

echo '<br />otherFeatures :  ';
//echo $value->features->otherFeatures;



echo '<br />images :  ';
//echo $value->images->otherFeatures;

foreach($value->images->img as $img)
	{
	if($img->attributes()->url)
		{
		echo '<br />image :  ';
		echo '<br /> ---------  '.$img->attributes()->id;
		echo '<br /> ---------  '.$img->attributes()->modTime;
		echo '<br /> ---------  '.$img->attributes()->url;
		$urlimgages[]=$img->attributes()->url;
		}
	}







echo '<br />';
echo '<br />----';
echo '<br />';

$x++;
}	

	
	


	print_r($return_data);
 	return $return_data;
  }
  
  
function getTotal()
  {
 	// Load the content if it doesn't already exist
 	
 	    $this->_total = 100;	
 	
 	return $this->_total;
  }


function getPagination()
  {
 	    $this->_pagination = '';			
 	
 	return $this->_pagination;
  }

  
}//fin clase