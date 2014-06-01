<?php defined('_JEXEC') or die('Restricted access'); // no direct access ?>
<?php 
jimport('joomla.filesystem.file');
require_once( JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'helpers'.DS.'link.php' );
?>
<div align="center">
<div class="NewsTicker" style="width:<?php echo $widthDiv; ?>px; height:<?php echo $heightDiv; ?>px;">
 <!-- <h1>What's news? Visit <a href="http://woork.blogspot.com/">Woork.blogspot.com</a></h1>-->
	<div class="NewsVertical" style="height:<?php echo $heightDiv; ?>px;">
	  <ul id="TickerVertical<?php echo $module->id; ?>" class="TickerVertical">
     
<?php
jimport('joomla.filesystem.file');
$k = 0;
	for ($i=0, $n=count( $items ); $i < $n; $i++)	
    {
$row = $items[$i];	
	
$link = LinkHelper::getLinkProperty($row->id,$row->alias);

if($row->imagename!=NULL){ $img=$row->imagename;}else{$img='noimage.jpg';}

$watermark=''; 
	if($ShowWaterMark and $row->available > 0)
		{	
		$watermark='detailsmarket'.$row->available.'-'.$lang->getTag().'.png'; 
		} 
		
		
?>		
        <li style="width:<?php echo $widthItem; ?>px;">


<div class="watermark_box">
         <a href="<?php echo $link; ?>">
        <img src="images/properties/images/thumbs/<?php echo $row->id; ?>/<?php echo $img;?>" border="0" class="NewsImg" alt="<?php echo $row->name;?>" width="<?php echo $widthThumb; ?>" height="<?php echo $heightThumb; ?>" />
        </a>
        
<?php 
				if($watermark)
				{
				if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_properties'.DS.'includes'.DS.'img'.DS.$watermark)){
				?>
					<img src="<?php echo JURI::base().'components/'.'com_properties/'.'includes/'.'img/'.$watermark; ?>" class="prop_carrousel_watermark" alt="<?php echo JText::_('DETAILS_MARKET'.$row->available); ?>"  />
				<?php 
				} 
				}				
				?>
 </div>               
                
                
                  
 <?php if ($showName) { ?>
<span class="NewsTitle"><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></span>
<?php } ?>
      
           
<?php if ($showCategory) { ?>
<?php echo JText::_('Category'); ?>: <?php echo $row->name_category; ?><br />
<?php } ?>  
<?php if ($showType) { ?>
<?php echo JText::_('Type'); ?>: <?php echo $row->name_type; ?><br />
<?php } ?>  
<?php if ($showState) { ?>
<?php echo JText::_('State'); ?>: <?php echo $row->name_state; ?><br />
<?php } ?> 
<?php if ($showLocality) { ?>
<?php echo JText::_('Locality'); ?>: <?php echo $row->name_locality; ?><br />
<?php } ?>  
<?php if ($showHits) { ?>
<?php echo JText::_('Visits').' : '. $row->hits; ?><br />
<?php } ?> 
<?php
if ($showPrice) {
if($row->price!=0){
$priceText = PropertiesHelper::getPriceText($row->price,$row->currency,$row->cat_currency);
}
echo $priceText.'<br />';
}
?>

      </li>             
<?php
}
?>
    </ul>
  </div>
</div>
<div style="clear:both"></div>
</div>

<script language="javascript" type="text/javascript">

			var Ticker<?php echo $module->id; ?> = new Class({
				setOptions: function(options) {
					this.options = Object.extend({
						speed: 5000,
						delay: 5000,
						direction: 'horizontal',
						onComplete: Class.empty,
						onStart: Class.empty
					}, options || {});
				},
				initialize: function(el,options){
					this.setOptions(options);
					this.el = $(el);
					this.items = this.el.getElements('li');
					var w = 0;
					var h = 0;
					if(this.options.direction.toLowerCase()=='horizontal') {
						h = this.el.getSize().size.y;
						this.items.each(function(li,index) {
							w += li.getSize().size.x;
						});
					} else {
						w = this.el.getSize().size.x;
						this.items.each(function(li,index) {
							h += li.getSize().size.y;
						});
					}
					this.el.setStyles({
						position: 'absolute',
						top: 0,
						left: 0,
						width: w,
						height: h
					});
					this.fx = new Fx.Styles(this.el,{duration:this.options.speed,onComplete:function() {
						var i = (this.current==0)?this.items.length:this.current;
						this.items[i-1].injectInside(this.el);
						this.el.setStyles({
							left:0,
							top:0
						});
					}.bind(this)});
					this.current = 0;
					this.next();
				},
				next: function() {
					this.current++;
					if (this.current >= this.items.length) this.current = 0;
					var pos = this.items[this.current];
					this.fx.start({
						top: -pos.offsetTop,
						left: -pos.offsetLeft
					});
					this.next.bind(this).delay(this.options.delay+this.options.speed);
				}
			});

			var hor = new Ticker<?php echo $module->id; ?>('TickerVertical<?php echo $module->id; ?>',{speed:1000,delay:4000,direction:'horizontal'});
		</script>