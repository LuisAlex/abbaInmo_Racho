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
global $mainframe;
JRequest::setVar('tmpl','component');
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/detail'.$DetailLayout.'.css" type="text/css" media="print" />');
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/detail'.$DetailLayout.'.css" type="text/css" media="screen" />');
$document =& JFactory::getDocument();
$this->lang =& JFactory::getLanguage();
$user =& JFactory::getUser();
$Product=$this->Product;
$component = JComponentHelper::getComponent( 'com_properties' );
$this->params = new JParameter( $component->params );

$mainframe->addCustomHeadTag('
<script type="text/javascript">	
	window.addEvent(\'domready\', function(){ 
	window.print();
	});
</script>
');	

?>

<?php
$Product=$this->Product;

$rout_image = 'images/properties/images/'.$Product->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$Product->id.'/';

if($Product->price!=0){
$number = $Product->price;
$currencyformat=$this->params->get('FormatPrice');
$SimbolPrice=$this->params->get('SimbolPrice');
		if ($currencyformat==0) {
			$formatted_price = number_format($number);
		} else if ($currencyformat==1) {
			$formatted_price = number_format($number, 2,".",",");
		} else if ($currencyformat==2) {
			$formatted_price = number_format($number, 0,",",".");
		} else if ($currencyformat==3) {			
			$formatted_price = number_format($number, 2,",",".");
		}
if($PositionPrice==0){
$showprice = '<tr><td align="left">'.JText::_('Price') .' : '. $SimbolPrice.' '. $formatted_price.'</td></tr>'; 
}else{
$showprice = '<tr><td align="left">'.JText::_('Price') .' : '. $formatted_price .' '. $SimbolPrice.'</td></tr>';
}
}

if($this->ImagesProduct[0]->name!=NULL){ 
$image1 = $this->ImagesProduct[0]->name;
}else{
$rout_image = 'images/properties/images/';
$image1='noimage.jpg';
}
?>

<div id="property_details">

<div class="topdetail">
		<div class="ProductTitle">
<?php echo '<h1>'.$Product->name_type.' '.$Product->name_category.', '.$Product->postcode . ' ' . $Product->name_locality.' '.$Product->name_state . ' ' . $Product->name_country . '.</h1>'; ?>   
		</div>
		<div class="clearfix"></div>
		<div class="image_detail">        
		<img src="<?php echo $rout_image.$image1;?>" alt="<?php echo $Product->image1desc;?>" />
		</div>
		<div class="text_details">               
<?php
echo '<span>'.JText::_('Abba Inmobiliaria').'</span><br />';

//echo '<span>'.JText::_('Reference').' : '.$Product->ref.'</span><br />';
echo '<span>'.JText::_('Category').' : '.JText::_($Product->name_category).'</span><br />';
echo '<span>'.JText::_('Type').' : '.JText::_($Product->name_type).'</span><br />';
echo '<span>'.JText::_('Country').' : '.JText::_($Product->name_country).'</span><br />';
echo '<span>'.JText::_('State').' : '.JText::_($Product->name_state).'</span><br />';
echo '<span>'.JText::_('Locality').' : '.JText::_($Product->name_locality).'</span><br />';
if($Product->bedrooms){
echo '<span>'.JText::_('Bedrooms').' : '.JText::_($Product->bedrooms).'</span><br />';
}
if($showprice){echo '<div class="text_detail">'.$showprice.''. $showprice_dolar. '.</div>';}
echo '<br /><span>'.JText::_('www.abbainmobiliaria.com.mx').'</span>';
?>


<?php 
$showAllDetails=null;
if($showAllDetails){
echo '<table>';
?>
<?php if($Product->years){echo '<tr><td align="left">'.JText::_('Years') .' :</td><td align="left"> '. $Product->years.'</td></tr>';} ?>
<?php if($Product->bedrooms){echo '<tr><td align="left">'.JText::_('Bedrooms') .' :</td><td align="left"> '. $Product->bedrooms.'</td></tr>';} ?>
<?php if($Product->bathrooms){echo '<tr><td align="left">'.JText::_('Bathrooms') .' :</td><td align="left"> '. $Product->bathrooms.'</td></tr>';} ?>
<?php if($Product->garage){echo '<tr><td align="left">'.JText::_('Garage') .' :</td><td align="left"> '. $Product->garage.'</td></tr>';} ?>
<?php if($Product->area){echo '<tr><td align="left">'.JText::_('Total Area') .' :</td><td align="left"> '. $Product->area.' '.JText::sprintf('Simbol Metric').'</td></tr>';} ?>
<?php if($Product->covered_area){echo '<tr><td align="left">'.JText::_('Covered Area') .' :</td><td align="left"> '. $Product->covered_area.' '.JText::sprintf('Simbol Metric').'</td></tr>';} ?>
<?php if($Product->available){echo '<tr><td align="left">'.JText::_('DETAILS MARKET').' :</td><td align="left"> '.JText::_('DETAILS_MARKET'.$Product->available).'</td></tr>';} ?>
<?php 
echo '</table>';
}
?>			  
	
        </div>


		<div class="buttons_details">





<div class="tools_image3">
<?php
$statusp = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no';
$linkp = LinkHelper::getLink('property','printproperty','',$Product->CYslug,$Product->Sslug,$Product->Lslug,$Product->Cslug,$Product->Tslug,$Product->Pslug);
?>
<a href="javascript:;" onclick="window.print(); return false" title="<?php echo JText::_('Print'); ?>">
<img id="printImage" src="<?php echo JURI::root().'components/com_properties/includes/img/icon-48-print.png'; ?>" alt="<?php echo JText::_('Print'); ?>" />
</a>
</div>

<!--
<div class="tools_image2">
 <?php $rutaF= JURI::base().'index.php?option=com_properties&view=property&task=recommend&tmpl=component&id='.$Product->id;
?>
<a href="<?php echo $rutaF ;?>" class="modal" rel="{handler: 'iframe', size: {x: 500, y: 600}}" title="<?php echo JText::_('Send to a friend');?>">
<img src="<?php echo JURI::root().'components/com_properties/includes/img/icon-48-send.png'; ?>" alt="<?php echo JText::_('Send to a friend'); ?>" />
</a>
</div>


<div class="tools_image1">
<?php
JHTML::_('behavior.modal'); 
$rutaC= JURI::base().'index.php?option=com_properties&view=form1&tmpl=component&id='.$Product->id;
?>
<a href="<?php echo $rutaC ;?>" class="modal" rel="{handler: 'iframe', size: {x: 500, y: 600}}" title="<?php echo JText::_('Contact'); ?>">
<img src="<?php echo JURI::root().'components/com_properties/includes/img/icon-48-read-privatemessage.png'; ?>" alt="<?php echo JText::_('Contact'); ?>" />
</a>
</div>
-->



        </div>
<div class="clearfix"></div>


</div>













<div style="width:100%; height:10px;"></div>

<table class="general_details" width="100%" border="0">
<tr>
<td class="titleExtras">
<?php echo JText::_('Details');?>
</td>
</tr>
<tr>
<td colspan="6" class="titleExtrasSeparator">
</td>
</tr>
<tr>
<td align="justify">
<?php echo $Product->text; ?><br />
</td>
</tr>
</table>

<div style="width:100%; height:10px;"></div>




<table class="general_features" width="100%" border="0">
<tr>
<td colspan="6" class="titleExtras">
<?php echo JText::_('General Features');?>
</td>
</tr>

<tr>
<td colspan="6" class="titleExtrasSeparator">
</td>
</tr>

<tr>
<td width="3%"></td>
<td width="30%"></td>
<td width="3%"></td>
<td width="30%"></td>
<td width="3%"></td>
<td width="30%"></td>
</tr>

<tr>
<?php 
$celda=0;
if($Product->extra2){
if($celda%3==0){echo '';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra2') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra3){
if($celda%3==0){echo '';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra3') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra4){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra4') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra5){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra5') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra6){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra6') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra7){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra7') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra8){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra8') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra9){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra9') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra10){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra10') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra11){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra11') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra12){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra12') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra13){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra13') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra14){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra14') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra15){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra15') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra16){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra16') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra17){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra17') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra18){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra18') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra19){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra19') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra20){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra20') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra21){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra21') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra22){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra22') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra23){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra23') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra24){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra24') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra25){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra25') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra26){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra26') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra27){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra27') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra28){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra28') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra29){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra29') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra30){
if($celda%3==0){echo '</tr><tr>';}
$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
echo '<td align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra30') .'</td>';
$celda++;
} 
?>

</tr>
</table>










 <div style="clear:both"></div>

 <div style="width:100%; height:10px;"></div>


<?php  
$watermark=JText::_('DETAILS_MARKET'.$Product->available).'-'.$this->lang->getTag().'.png';
$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'peques'.DS.'peque_';
$WidthThumbsDetail=$this->params->get('WidthThumbsDetail');
$HeightThumbsDetail=$this->params->get('HeightThumbsDetail');      

$ShowImagesSystemDetail = $this->params->get('ShowImagesSystemDetail');

if($ShowImagesSystemDetail){
?>
<div style="clear: both;"></div>
<div style="width:100%; height:10px;"></div>
<table class="general_details" width="100%" border="0">
<tr>
<td colspan="6" class="titleExtras">
<?php echo JText::_('Images');?>
</td>
</tr>
<tr>
<td colspan="6" class="titleExtrasSeparator">
</td>
</tr>
<tr>
<td width="100%">
<div class="imgslimbox"> 
<div class="gallery clearfix">   
<?php
jimport('joomla.filesystem.file');
$rout_image = 'images/properties/images/'.$Product->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$Product->id.'/';
foreach($this->ImagesProduct as $image){
if(JFile::exists($rout_thumb.$image->name)){
$ThumbsInAccordionShowing++;
?>
<a href="<?php echo $rout_image.$image->name; ?>" title="<?php echo str_replace('"',' ',$image->text); ?>" >
<img width="<?php echo $WidthThumbsDetail; ?>" height="<?php echo $HeightThumbsDetail; ?>" src="<?php echo $rout_thumb.$image->name; ?>" alt="<?php echo str_replace('"',' ',$image->text); ?>" /></a>
<?php 
if($image->sector){echo JText::_('image_sector_'.$image->sector); }
?>
<?php
}}
?>
</div>
</div>
</td></tr></table>
<?php  
}//END SLIMBOX
?>


<div style="clear: both;"></div>
<div style="width:100%; height:10px;"></div> 
<!--END IMAGE TABLE-->	  
    
   


<?php
if($this->params->get('ActiveMapaInPrint')){

$distancia=$this->params->get('distancia');
$apikey=$this->params->get('apikey');
$distancia=$this->params->get('distancia');
$lat = $Product->lat;
$lng = $Product->lng;

/*var map = new GMap2(document.getElementById("map"),{size:new GSize(700,420)}); */
?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $apikey;?>"
      type="text/javascript"></script> 
 
 <script type="text/javascript"> 
  function loadmap() { 
      if (GBrowserIsCompatible()) { 
	  
	   var baseIcon = new GIcon();
        baseIcon.shadow = "<?php echo JURI::base();?>components/com_properties/includes/img/house-shadow.png";
        baseIcon.iconSize = new GSize(32, 32);
        baseIcon.shadowSize = new GSize(59, 32);
        baseIcon.iconAnchor = new GPoint(20, 20);
        baseIcon.infoWindowAnchor = new GPoint(20, 20);
		
var base_Icon = new GIcon(baseIcon);		
		
base_Icon.image = "<?php echo JURI::base();?>components/com_properties/includes/img/house.png";		

markerOptions = { icon:base_Icon };



        var map = new GMap2(document.getElementById("map")); 
        map.setCenter(new GLatLng(<?php echo $lat;?>, <?php echo $lng;?>), <?php echo $distancia;?>);
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		var marker = new GMarker(new GLatLng(<?php echo $lat;?>, <?php echo $lng;?>), markerOptions);
		map.addOverlay(marker);		
		}
    }
</script> 


<div id="map" style="width: 700px; height: 420px;margin:0px;padding:0px;">
</div>
<script type="text/javascript">  loadmap();  </script>
<div style="clear: both;"></div>

<?php

?>

<?php

}/*Final if ActivarMapa*/

?>




















    
        
<?php
if($this->MyAgent)
	{
//print_r($this->MyAgent);
?>

<div style="width:100%; height:10px;"></div>

<div class="contact_data">
<div class="tools_agent">  
<table width="100%">
<tr>
<td colspan="2" width="100%">
<span class="tools_company"><?php echo $this->MyAgent->name;?></span><br />
</td>
</tr>
<tr>
<td valign="bottom">
<img class="agent" align="left" src="<?php echo JURI::root().'images/properties/profiles/'.$this->MyAgent->image;?>" />
</td>
<td>
<div style="float:left; width:190px;">
<img style="margin-right:5px;" align="left" src="<?php echo JURI::root().'components/com_properties/includes/img/phone-icon.png'; ?>" width="20" height="20">
<?php echo $this->MyAgent->phone;?>
</div>
<div style="float:left; width:190px;">
<img style="margin-right:5px;" align="left" src="<?php echo JURI::root().'components/com_properties/includes/img/fax-icon.png'; ?>" width="20" height="20">
<?php echo $this->MyAgent->fax;?>
</div>
<div style="float:left; width:190px;">
<img style="margin-right:5px;" align="left" src="<?php echo JURI::root().'components/com_properties/includes/img/2email-icon.png'; ?>" width="20" height="20">
<?php 
$atimg='<img src="'.JURI::root().'components/com_properties/includes/img/at.png" border="0" style="border: 0; vertical-align: middle;" />';
$mail=str_replace('@',$atimg,$this->MyAgent->email);?>
<?php echo $mail;?>
</div>
</td>
</tr>
</table>
</div><!-- tools_agent -->
</div>




<div style="clear:both"></div>



<div style="width:100%; height:10px;"></div>

<?php } ?>


</div><!-- all-->

