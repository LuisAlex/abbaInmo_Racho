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
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

$showprice = '';

if($this->params->get('showFavorites'))
	{
	require_once( JPATH_COMPONENT.DS.'views'.DS.'templates'.DS.'buttonfavorites.php' );
	$thisView = JRequest::getVar('view');
	$session =& JFactory::getSession();
	$favorites = $session->get('favorites', array(), 'com_properties');
	}
if($this->params->get('ShowLogoAgent'))
	{
	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'agentdata.php' );
	}
?>
<div id="PropertiesList" style=" width:<?php echo $this->params->get('WidthList','100%');?>;">
<?php
if($this->params->get('ShowOrderBy'))
	{
	echo '<div class="orderbylist">';	
	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'orderby.php' );	
	echo '</div>   ';
	}
?>
<div id="accordion">
<?php
    $k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	
    {
$row = &$this->items[$i];

$rout_image = 'images/properties/images/'.$row->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$row->id.'/';	
if($this->Images[$row->id][0]->name!=NULL)
	{ 
		$img=$this->Images[$row->id][0]->name;
	}else{
		$img='noimage.jpg';
	}
if($row->available > 1)
{	
$watermark='detailsmarket'.$row->available.'-'.$this->lang->getTag().'.png';
}else{
$watermark='';
}
$imgTag='<img src="'.$rout_thumb.$img.'" alt="'. str_replace('"',' ',$row->name) .'" width="'.$this->params->get('WidthThumbs',150).'" height="'.$this->params->get('HeightThumbs',100).'" />'; 	


$showprice = PropertiesHelper::getPriceText($row->price,$row->currency,$row->cat_currency);

/*
if($row->price!=0){
$number = $row->price;
$currencyformat=$this->params->get('FormatPrice');
$SimbolPrice=$this->params->get('SimbolPrice');
$PositionPrice=$this->params->get('PositionPrice');
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
$showprice = JText::_('Price').': '.$SimbolPrice.' '. $formatted_price.''; 
}else{
$showprice = JText::_('Price').': '.$formatted_price .' '. $SimbolPrice.'';
}
}else{
$showprice = '<b><font color="#FF0000"> '. JTEXT::_('Call for price').'</font></b><br />';
$showprice = '';
}
*/
/*
$link = LinkHelper::getLinkRef('property','','','',$row->ref);
$link = LinkHelper::getLink('property','','',$row->CYslug,$row->Sslug,$row->Lslug,$row->Cslug,$row->Tslug,$row->Pslug);
*/

$link = $this->getPropertyViewLink($row);

if($row->featured==1){$featclass=' featured';}else{$featclass='';}
?>
<div class="product<?php echo $featclass;?>">

	<div class="title"><a href="<?php echo $link;?>"><?php echo $row->name;?></a></div>
    
<?php
	if($showprice)
	{
	echo '<div class="priceinlist">'.$showprice.'</div>';
	}


if($this->params->get('showFavorites'))
	{
	echo buttonFavoritesHelper::showButtonFavorites( $row->id, $thisView, $favorites );
	}
	
	
	
if($this->params->get('ShowLogoAgent'))
	{
	if($agent = AgentDataHelper::getAgent($row->agent_id))
	{
	if($agent->logo_image)
	{
?>
	<div class="logoagent">
	<img src="images/properties/profiles/<?php echo $agent->logo_image;?>" alt="<?php echo $agent->alias;?>" />
	</div>
<?php	}}}?> 


	<div class="details">
		<div class="imagedetails">
			<div class="watermark_box">
				<a href="<?php echo $link; ?>">
				<?php echo $imgTag;?>
				<?php 
				if($watermark)
				{
				if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'img'.DS.$watermark)){
				?>
					<img src="<?php echo JURI::base().'components/'.'com_properties/'.'includes/'.'img/'.$watermark; ?>" class="watermark" alt="<?php echo JText::_('DETAILS_MARKET'.$row->available); ?>"  />
				<?php 
				} 
				}
				?>
				</a>
			</div>
		</div>
		<div class="data">

<?php

if($this->params->get('ShowReferenceInList')){
echo '<span>'.JText::_('Reference333333333').' : '.$row->ref.'</span><br />';
}
if($this->params->get('ShowCategoryInList')){
echo '<span>'.JText::_('Category').' : '.JText::_($row->name_category).'</span><br />';
}
if($this->params->get('ShowTypeInList')){
echo '<span>'.JText::_('Type').' : '.JText::_($row->name_type).'</span><br />';
}
if($this->params->get('ShowCountryInList')){
echo '<span>'.JText::_('Country').' : '.JText::_($row->name_country).'</span><br />';
}
if($this->params->get('ShowStateInList')){
echo '<span>'.JText::_('State').' : '.JText::_($row->name_state).'</span><br />';
}
if($this->params->get('ShowLocalityInList')){
echo '<span>'.JText::_('Locality').' : '.JText::_($row->name_locality).'</span><br />';
}
if($this->params->get('ShowAddressInList')){
if($row->address){
echo '<span>'.JText::_('Address').' : '.JText::_($row->address).'</span><br />';
}
}

$showAllDetails=false;
if($showAllDetails){
echo '<span>'.JText::_('YEAR OF BUILDING').' : '.$row->years.'</span><br />';
echo '<span>'.JText::_('bedrooms').' : '.$row->bedrooms.'</span><br />';
echo '<span>'.JText::_('bathrooms').' : '.$row->bathrooms.'</span><br />';
echo '<span>'.JText::_('garage').' : '.$row->garage.'</span><br />';
echo '<span>'.JText::_('Total Area').' : '.$row->area.' '.JText::_('Simbol Metric').'</span><br />';
echo '<span>'.JText::_('Covered Area').' : '.$row->covered_area.' '.JText::_('Simbol Metric').'</span><br />';
echo '<span>'.JText::_('DETAILS MARKET').' : '.JText::_('DETAILS_MARKET'.$row->available).'</span><br />';
}





if($this->params->get('showOpenHouse')){
if($OpenHouse = $this->getOpenHouse($row->id)){
echo '<span class="openhouse">'.JText::_('Open House').' : ';
echo date('D',strtotime($OpenHouse->date)).' '.date('d',strtotime($OpenHouse->date)).' '.JText::_(date('F',strtotime($OpenHouse->date)).'_SHORT').' '.', '.substr($OpenHouse->from,0,5).' to '.substr($OpenHouse->to,0,5).' Hs.'.'</span><br />';
}
}


?>
<?php //echo JText::_('Hits') .' : '. $row->hits; ?>

		</div>
	</div> 


 

	<div style="clear:both"></div>

	<div class="ListButtons">
		<div style="float: right; padding-top: 2px;">
<?php if($this->params->get('ShowContactLink')){
$rutaC = LinkHelper::getLinkProperty($row->id,$row->alias,'contact');
?> 
<a title="<?php echo JText::_('BUTTON_CONTACT'); ?>" class="modal ListButtonsLink" rel="{handler: 'iframe', size: {x: 750, y: 500}}" href="<?php echo $rutaC ;?>"><?php echo JText::_('BUTTON_CONTACT'); ?></a>                   
<?php
}
if($this->params->get('ActiveMapa')){
$rutaG = LinkHelper::getLinkProperty($row->id,$row->alias,'map');
?>
<?php if($this->params->get('ShowMapLink')){?>
<a title="<?php echo JText::_('BUTTON_VIEW_MAP'); ?>" class="modal ListButtonsLink" rel="{handler: 'iframe', size: {x: 750, y: 495}}" href="<?php echo $rutaG ;?>"><?php echo JText::_('BUTTON_VIEW_MAP'); ?></a>
<?php }?>
<?php }?>
<?php
if($this->params->get('ShowPriceList')){
$rutaP = LinkHelper::getLinkProperty($row->id,$row->alias,'pricelist');
?>
<a title="<?php echo JText::_('BUTTON_VIEW_PRICE_LIST'); ?>" class="modal ListButtonsLink" rel="{handler: 'iframe', size: {x: 750, y: 495}}" href="<?php echo $rutaP ;?>"><?php echo JText::_('BUTTON_VIEW_PRICE_LIST'); ?></a>
<?php }?>  
<a class="ListButtonsLink" href="<?php echo $link ;?>"><?php echo JText::_('BUTTON_VIEW_DETAILS'); ?></a>
		</div>        
       <div class="toggler"></div> 
    </div>
    


<div style="clear:both"></div>  
  
	<div class="element">
		<div class="innerelement">
        
 <?php       
if($showAllDetails){
echo '<span>'.JText::_('Reference').' : '.$row->ref.'</span><br />';
echo '<span>'.JText::_('Category').' : '.JText::_($row->name_category).'</span><br />';
echo '<span>'.JText::_('Type').' : '.JText::_($row->name_type).'</span><br />';
echo '<span>'.JText::_('Country').' : '.JText::_($row->name_country).'</span><br />';
echo '<span>'.JText::_('State').' : '.JText::_($row->name_state).'</span><br />';
echo '<span>'.JText::_('Locality').' : '.JText::_($row->name_locality).'</span><br />';
echo '<span>'.JText::_('Address').' : '.JText::_($row->address).'</span><br />';
echo '<span>'.JText::_('YEAR OF BUILDING').' : '.$row->years.'</span><br />';
echo '<span>'.JText::_('bedrooms').' : '.$row->bedrooms.'</span><br />';
echo '<span>'.JText::_('bathrooms').' : '.$row->bathrooms.'</span><br />';
echo '<span>'.JText::_('garage').' : '.$row->garage.'</span><br />';
echo '<span>'.JText::_('Total Area').' : '.$row->area.' '.JText::_('Simbol Metric').'</span><br />';
echo '<span>'.JText::_('Covered Area').' : '.$row->covered_area.' '.JText::_('Simbol Metric').'</span><br />';
echo '<span>'.JText::_('DETAILS MARKET').' : '.JText::_('DETAILS_MARKET'.$row->available).'</span><br />';
}      
?>        
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
				<?php echo $row->text; ?><br />
				</td>
			</tr>
		</table>



<div style="width:100%; height:10px;"></div>



<table class="general_details" width="100%" border="0">
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
if($row->extra2){
if($celda%3==0){echo '';}
echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra2') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra3){
if($celda%3==0){echo '';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra3') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra4){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra4') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra5){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra5') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra6){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra6') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra7){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra7') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra8){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra8') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra9){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra9') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra10){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra10') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra11){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra11') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra12){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra12') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra13){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra13') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra14){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra14') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra15){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra15') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra16){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra16') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra17){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra17') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra18){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra18') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra19){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra19') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra20){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra20') .'</td>';
$celda++;
} 
?>

<?php 
if($row->extra21){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra21') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra22){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra22') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra23){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra23') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra24){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra24') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra25){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra25') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra26){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra26') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra27){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra27') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra28){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra28') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra29){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra29') .'</td>';
$celda++;
} 
?>


<?php 
if($row->extra30){
if($celda%3==0){echo '</tr><tr>';}

echo '<td'.$tdClass.' align="left">'.$extraimg.'</td><td align="left">'.JText::_('extra30') .'</td>';
$celda++;
} 
?>

</tr>
</table>



            <div style="width:100%; height:10px;"></div>


<?php  
$watermark=JText::_('DETAILS_MARKET'.$Product->available).'-'.$this->lang->getTag().'.png';

$WidthThumbsDetail=$this->params->get('WidthThumbsDetail');
$HeightThumbsDetail=$this->params->get('HeightThumbsDetail');      

$ShowImagesSystemDetail = $this->params->get('ShowImagesSystemDetail');
$galleryClass='';
if($ShowImagesSystemDetail == 2){
$rel='rel="dogs0"';
}elseif($ShowImagesSystemDetail == 1){
$rel='';
$galleryClass='modal';
}elseif($ShowImagesSystemDetail == 3){
$rel='rel="prettyPhoto[gallery'.$row->id.']"';
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
$rout_image = 'images/properties/images/'.$row->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$row->id.'/';
$WidthThumbsAccordion=$this->params->get('WidthThumbsAccordion',120);
$HeightThumbsAccordion=$this->params->get('HeightThumbsAccordion',90);
foreach($this->Images[$row->id] as $image){
if(JFile::exists($rout_thumb.$image->name)){
$ThumbsInAccordionShowing++;
?>
<a class="<?php echo $galleryClass;?>" href="<?php echo $rout_image.$image->name; ?>" <?php echo $rel; ?> title="<?php echo str_replace('"',' ',$image->text); ?>" >
<img width="<?php echo $WidthThumbsAccordion; ?>" height="<?php echo $HeightThumbsAccordion; ?>" src="<?php echo $rout_thumb.$image->name; ?>" alt="<?php echo str_replace('"',' ',$image->text); ?>" /></a>
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










		


		</div>
	</div>                  
</div>  <!--producto -->   
 
 
<?php
$k = 1 - $k;
}
 ?>

</div><!-- acordeon-->

<?php
if($this->pagination){
?>
<div id="pagination">
<?php echo $this->pagination->getPagesLinks(); ?>
	<div id="ResultsCounter">
	<?php echo $this->pagination->getResultsCounter().'.  '.$this->pagination->getPagesCounter(); ?>
	</div>           
<div style="clear: both;"></div> 
</div><!-- paginacion--> 
<?php
}
?>
</div><!-- PropertiesList -->
