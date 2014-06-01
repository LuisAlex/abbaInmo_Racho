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
$params=$this->params;
$Product=$this->Product;
$rout_image = 'images/properties/images/'.$Product->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$Product->id.'/';
if($Product->price!=0){
$showprice = PropertiesHelper::getPriceText($Product->price,$Product->currency,$Product->cat_currency);
}


if($this->ImagesProduct[0]->name!=NULL){ 
$image1 = $this->ImagesProduct[0]->name;
}else{
$rout_image = 'images/properties/images/';
$image1='noimage.jpg';
}
?>

<div id="property_details" style=" width:<?php echo $params->get('WidthDetail','100%');?>;">
	<div id="property_details_inner">
		<div class="topdetail">
			<div class="ProductTitle">
			<?php /*echo '<h1>'.$Product->name_type.' '.$Product->name_category.', '.$Product->postcode . ' ' . $Product->name_locality.' '.$Product->name_state . ' ' . $Product->name_country . '.</h1>';*/ ?>   
			<?php echo '<h1>'.$Product->name.'</h1>'; ?>
            
            </div>
    <?php        if($showprice)
	{
	echo '<div class="priceindetail">'.$showprice.'</div>';
	}
	?>
    		<div class="clearfix"></div>
            
			<div class="image_detail">        
			<img src="<?php echo $rout_image.$image1;?>" alt="<?php echo $Product->image1desc;?>" />
			</div>
            
			<div class="text_details">               
<?php
echo '<span>'.JText::_('Reference').' : '.$Product->ref.'</span><br />';

	if(isset($Product->multiplecats))
	{		
	echo '<span>'.JText::_('Category').' : '.$Product->multiplecats.'</span><br />';
	}else{
	echo '<span>'.JText::_('Category').' : '.JText::_($Product->name_category).'</span><br />';
	}
		
echo '<span>'.JText::_('Type').' : '.JText::_($Product->name_type).'</span><br />';
echo '<span>'.JText::_('Country').' : '.JText::_($Product->name_country).'</span><br />';
echo '<span>'.JText::_('State').' : '.JText::_($Product->name_state).'</span><br />';
echo '<span>'.JText::_('Locality').' : '.JText::_($Product->name_locality).'</span><br />';
if($Product->bedrooms){
echo '<span>'.JText::_('Bedrooms').' : '.JText::_($Product->bedrooms).'</span><br />';
}
/*
if($this->priceConverted)
	{
	foreach($this->priceConverted as $pcc => $pcv)
		{
		echo '<div class="text_detail">' . $pcv . ' '. $pcc . '.</div>';
		}	
	}
*/
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
	
			</div><!-- text_details -->


			<div class="buttons_details">

				<div class="tools_image3">
<?php
$statusp = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=600,directories=no,location=no';
$linkp = LinkHelper::getLinkProperty($Product->id,$Product->alias,'print');
?>
<a href="javascript:void(0)" onclick="window.open('<?php echo $linkp;?>','win2','<?php echo $statusp; ?>');" title="<?php echo JText::_('Print'); ?>">
<img src="<?php echo JURI::root().'components/com_properties/includes/img/icon-48-print.png'; ?>" alt="<?php echo JText::_('Print'); ?>" />
</a>
</div>

<?php if($this->params->get('ShowRecommendLink'))
	{
?>	
<div class="tools_image2">
 <?php 
 $rutaF= LinkHelper::getLinkProperty($Product->id,$Product->alias,'recommend');
?>
<a href="<?php echo $rutaF ;?>" class="modal" rel="{handler: 'iframe', size: {x: 500, y: 600}}" title="<?php echo JText::_('Send to a friend');?>">
<img src="<?php echo JURI::root().'components/com_properties/includes/img/icon-48-send.png'; ?>" alt="<?php echo JText::_('Send to a friend'); ?>" />
</a>
</div>
<?php }?>
<!--
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



       			</div><!-- tools_image3 -->
			<div class="clearfix"></div>


			</div><!-- buttons_details -->




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

<?php
if($this->pVideo->text)
	{
?>	
	<table class="general_details" width="100%" border="0">
		<tr>
			<td class="titleExtras">
			<?php echo JText::_('Video');?>
			</td>
		</tr>
		<tr>
			<td colspan="6" class="titleExtrasSeparator">
			</td>
		</tr>
		<tr>
			<td align="justify">
			<?php echo $this->pVideo->text; ?><br />
			</td>
		</tr>
	</table>
	<div style="width:100%; height:10px;"></div>
<?php }?>


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
//$extraimg='<img src="'.JURI::base().'components/com_properties/includes/img/icon-16-checkin.png" />';
$extraimg='';
$tdClass = ' class="chekin"';
//$tdClass = '';
$celda=0;
if($Product->extra2){
if($celda%3==0){echo '';}
echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra2') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra3){
if($celda%3==0){echo '';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra3') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra4){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra4') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra5){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra5') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra6){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra6') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra7){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra7') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra8){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra8') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra9){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra9') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra10){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra10') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra11){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra11') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra12){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra12') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra13){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra13') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra14){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra14') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra15){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra15') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra16){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra16') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra17){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra17') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra18){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra18') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra19){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra19') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra20){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra20') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra21){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra21') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra22){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra22') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra23){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra23') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra24){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra24') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra25){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra25') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra26){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra26') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra27){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra27') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra28){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra28') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra29){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra29') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra30){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra30') .'</td>';
$celda++;
} 
?>

<?php 
if($Product->extra31){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra31') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra32){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra32') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra33){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra33') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra34){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra34') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra35){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra35') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra36){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra36') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra37){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra37') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra38){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra38') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra39){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra39') .'</td>';
$celda++;
} 
?>


<?php 
if($Product->extra40){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra40') .'</td>';
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
$WidthThumbsDetail=$params->get('WidthThumbsDetail');
$HeightThumbsDetail=$params->get('HeightThumbsDetail');      

$ShowImagesSystemDetail = $this->params->get('ShowImagesSystemDetail');
$galleryClass='';
if($ShowImagesSystemDetail == 2){
$rel='rel="dogs0"';
}elseif($ShowImagesSystemDetail == 1){
$rel='';
$galleryClass='modal';
}elseif($ShowImagesSystemDetail == 3){
$rel='rel="prettyPhoto[gallery1]"';
}

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
$rout_image = 'images/properties/images/'.$Product->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$Product->id.'/';
foreach($this->ImagesProduct as $image){
if(JFile::exists($rout_thumb.$image->name)){

?>
<a class="<?php echo $galleryClass;?>" href="<?php echo $rout_image.$image->name; ?>" <?php echo $rel; ?> title="<?php echo str_replace('"',' ',$image->text); ?>" >
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

<?php
if($ShowImagesSystemDetail == 3){
?>
<script type="text/javascript" charset="utf-8">
jQuery.noConflict();
		jQuery(document).ready(function(){
			jQuery(".gallery a[rel^='prettyPhoto']").prettyPhoto({theme:'<?php echo $this->params->get('pretty_photo_style','facebook');?>'});
		});
		//dark_rounded facebook dark_square light_rounded light_square
		</script>
 <?php  
}
?>   
			<div style="clear: both;"></div>
			<div style="width:100%; height:10px;"></div> 
<!--END IMAGE TABLE-->	  












<?php if($Product->use_booking){?>

<div style="width:100%; height:10px;"></div>

<table class="general_details" width="100%" border="0">
<tr>
<td class="titleExtras">
<?php echo JText::_('Calendar');?>
</td>
</tr>
<tr>
<td class="titleExtrasSeparator">
</td>
</tr>
<tr>
<td align="justify">
<table class="admintable" width="100%" border="0">
	<tr>
		<td>
    <?php    
$AmountMonthsCalendar=$this->params->get('AmountMonthsCalendar',12);
$PeriodOnlyWeeks=$this->params->get('PeriodOnlyWeeks',0);
$PeriodAmount=$this->params->get('PeriodAmount',3);
$PeriodStartDay=$this->params->get('PeriodStartDay',6);
$StartMonthCalendar=$this->params->get('StartMonthCalendar',date('n'));
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'CalendarClass.php' ); 
$cal = new Calendar; 
$cal->setStartMonth($StartMonthCalendar);
$cal->setAmountMonths($AmountMonthsCalendar);
$cal->setPropertyId($Product->id);
echo $cal->getCurrentYearView();      
    ?>     
        </td>
	</tr>
</table>
</td>
</tr>
</table>
<?php } ?>













<?php
if($this->params->get('ActiveMapa')){

$distancia=$params->get('distancia');
$apikey=$params->get('apikey');
$distancia=$params->get('distancia');
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


<div id="map" style=" width:<?php echo $params->get('WidthMap','100%');?>; height:<?php echo $params->get('HeightMap','300px');?>;margin:0px;padding:0px;"></div>
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

<table class="general_details" width="100%" border="0">
<tr>
<td class="titleExtras">
<?php echo JText::_('Agent Contact Data');?>
</td>
</tr>
<tr>
<td class="titleExtrasSeparator">
</td>
</tr>
<tr>
<td>
<div class="tools_agent_form"> 

<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" id="josForm2" name="josForm2" class="form-validate">
<input type="hidden" name="popup" value="" />
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
	                            
	<tr>
		<td width="30%" height="30">
		<label id="namemsg" for="name">*<?php echo JText::_( 'Name' ); ?>: </label>
		<input type="text" name="name" id="name" value="<?php echo $user->name;?>" class="inputbox required" maxlength="50" /></td>
	</tr>


	<tr>
		<td height="30">
		<label id="emailmsg" for="email">*<?php echo JText::_( 'Email' ); ?>: </label>
		<input type="text" id="email" name="email" value="<?php echo $user->email;?>" class="inputbox required validate-email" maxlength="100" /></td>
	</tr>


	<tr>
		<td width="30%" height="30">
		<label id="namemsg" for="phone"><?php echo JText::_( 'Phone' ); ?>: </label>
		<input type="text" name="phone" id="phone" value="<?php //echo $this->user->get( 'name' );?>" class="inputbox required" maxlength="50" /></td>
	</tr>
	<tr>
		<td height="30">
		<label id="textmsg" for="text">
			<?php echo JText::_( 'Message' ); ?>:
		</label>
		
 	   <textarea name="text" id="text" rows="3"></textarea>
		</td>
	</tr>   
    
    
<tr>
	<td colspan="2">

<?php $dispatcher = &JDispatcher::getInstance();
			//JPluginHelper::importPlugin('system');
			$results = $dispatcher->trigger( 'onCaptchaRequired', array( 'user.contact' ) );
			if ($results[0]){?>		
<table>
<tr><td align="center" colspan="2">
<span><?php echo JText::_( 'CAPTCHACODE_FORM_TITLE' ) ?></span>	
</td>
<td colspan="2"></td>
</tr>
<tr>
<?php 	
			
				$dispatcher->trigger( 'onCaptchaView', array( 'user.contact', 0, '', '' ) ); 
?>
<td width="20px">
<div id="ValidateCaptcha" style="float:left;"></div>
</td>
<td>
<div style="float:right">      
<a style="cursor:pointer;" onclick="ValidateCaptcha(document.getElementById('captchacode1').value,document.getElementById('captchasuffix').value,document.getElementById('captchasessionid').value)"><?php echo JText::_('Test Code'); ?></a>
</div> 
</td>
</tr>
<tr>
    <td colspan="3"><div id="progressvc" style="float:left;"></div> </td>
  </tr>
</table>	
<?php } ?>
</td>
</tr>         
</table>
<div align="center" style="margin-bottom:10px;">
 
	<button class="button validate" type="submit"><?php echo JText::_('Send'); ?></button>
  
    </div>
    
    <?php 	
	$u =& JFactory::getURI();
	?>    
    <input type="hidden" name="return" value="<?php echo $u->_uri;?>" />
    
    <input type="hidden" name="option" value="com_properties" />    
    <input type="hidden" name="controller" value="contact" />
	<input type="hidden" name="task" value="send_contact" />
    <input type="hidden" name="product_id" value="<?php echo $Product->id;?>" />    
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>



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





</td>
</tr>
</table>





<div style="width:100%; height:10px;"></div>

<?php } ?>





<a href="" onclick="history.go(-1);return false;"><?php echo JText::_('Return'); ?></a>
</div><!-- property_details_inner-->
</div><!-- property_details-->
