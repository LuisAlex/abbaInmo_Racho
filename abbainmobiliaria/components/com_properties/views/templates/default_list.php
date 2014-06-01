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
echo '<span>'.JText::_('Reference').' : '.$row->ref.'</span><br />';
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
    </div>


<div style="clear:both"></div>
                    
</div>  <!--producto -->   
 
 
<?php
$k = 1 - $k;
}
 ?>


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
</div><!-- propiedades-->
