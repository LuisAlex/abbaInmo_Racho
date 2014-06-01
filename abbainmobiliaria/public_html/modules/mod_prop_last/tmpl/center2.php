<?php defined('_JEXEC') or die('Restricted access'); // no direct access ?>
<?php 
jimport('joomla.filesystem.file');
require_once( JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'link.php' );
?>
<div id="mod_prop_last_<?php echo $SpecialDesign;?>">
<?php
	foreach ($items as $item) { 	
	$link = LinkHelper::getLinkProperty($item->id,$item->alias,'',$item->Cslug);
	if($item->imagename!=NULL){ $img=$item->imagename;}else{$img='noimage.jpg';}
?>
				<div class="prop_round">              
  					<div>
    					<div>
			      			<div class="clearfix">	
	<div class="contenido">	                        
		<span class="title">
			<a href="<?php echo $link; ?>"><strong><?php echo $item->name; ?></strong></a>
		</span>
	<br />
<?php 
$watermark=''; 
if($ShowWaterMark and $item->available > 0)
{	
$watermark='detailsmarket'.$item->available.'-'.$lang->getTag().'.png';
}     
?> 
<div class="watermark_box">    
	<img class="prop_last_image" src="images/properties/images/thumbs/<?php echo $item->id; ?>/<?php echo $img;?>" alt="<?php echo str_replace('"',' ',$item->name); ?>" width="<?php echo $widthThumb; ?>" height="<?php echo $heightThumb; ?>" />

<?php 
				if($watermark)
				{
				if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'img'.DS.$watermark)){
				?>
					<img src="<?php echo JURI::base().'components/'.'com_properties/'.'includes/'.'img/'.$watermark; ?>" class="prop_last_watermark" alt="<?php echo JText::_('DETAILS_MARKET'.$item->available); ?>"  />
				<?php 
				} 
				}
				?>
                
</div>
<br />


<?php if ($showType) { ?>
<span class="prop_last_text">
<?php echo $item->name_type; ?>
</span>
<?php } ?> 
<?php if ($showCategory) { ?>
<span class="prop_last_text">
<?php echo $item->name_category; ?>
</span>
<?php } ?>  
<br />
<?php if ($showLocality) { ?>
<span class="prop_last_text">
<?php echo $item->name_locality.', '.$item->name_state; ?>
</span>
<?php } ?>  

<br />

<?php if ($showLocality) { ?>
<span class="prop_last_text">
<?php echo $item->postcode.' '.$item->address; ?>
</span>
<?php } ?>  

<br />

<?php
if ($showPrice) {
if($item->price!=0){
$priceText = PropertiesHelper::getPriceText($item->price,$item->currency,$item->cat_currency);
echo $priceText.'<br />';
}
}
?>



<a class="readon_class" href="<?php echo $link; ?>"><?php echo JText::_('VISUALIZAR');?></a>			
  <br />                        
                          
                          
                           </div>
     	 					</div>
    					</div>
  					</div>
				</div>                            
                            

<?php	
	
	}	
?>

</div>
<div style="clear:both"></div>
		
