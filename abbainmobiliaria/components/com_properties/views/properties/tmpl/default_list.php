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

	if($PositionPrice==0)
	{
		$showprice = JText::_('Price').': '.$SimbolPrice.' '. $formatted_price.''; 
	}else{
		$showprice = JText::_('Price').': '.$formatted_price .' '. $SimbolPrice.'';
	}

}else{
$showprice = '<b><font color="#FF0000"> '. JTEXT::_('Call for price').'</font></b><br />';
$showprice = '';
}

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
	?>	
        
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
		<div class="data" style="float:left; width:32%;">
<?php
if($this->params->get('ShowReferenceInList')){
echo '<span>'.JText::_('Reference').' : '.$row->ref.'</span><br />';
}

if(JRequest::getInt('cid')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
echo JText::_('Category').' : '.JText::_($row->name_category).'</span><br />';

if(JRequest::getInt('tid')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
echo JText::_('Type').' : '.JText::_($row->name_type).'</span><br />';

if(JRequest::getInt('cyid')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
echo JText::_('Country').' : '.JText::_($row->name_country).'</span><br />';

if(JRequest::getInt('sid')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
echo JText::_('State').' : '.JText::_($row->name_state).'</span><br />';

if(JRequest::getInt('lid')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
echo JText::_('Locality').' : '.JText::_($row->name_locality).'</span><br />';

if($this->params->get('ShowAddressInList')){
if($row->address){
echo '<span>'.JText::_('Address').' : '.JText::_($row->address).'</span><br />';
}
}
?>
		</div>
        
        
        
        
        
        
        
 		<div class="data" style="float:left;width:20%;">
        
<?php
$moduleSearchAjax = JModuleHelper::getModule( 'prop_search_ajax' );
	$paramsModuleSearchAjax = new JParameter( $moduleSearchAjax->params );

	$AreaToSearch = $paramsModuleSearchAjax->get( 'AreaToSearch','area' ) ;
	
	
if(JRequest::getInt('bedrooms')){echo '<span style="color:#FF0000">';}else{echo '<span>';}

echo JText::_('Bedrooms').' : '.$row->bedrooms.'</span><br />';

if(JRequest::getInt('bathrooms')){echo '<span style="color:#FF0000">';}else{echo '<span>';}

echo JText::_('Bathrooms').' : '.$row->bathrooms.'</span><br />';

if(JRequest::getInt('parking')){echo '<span style="color:#FF0000">';}else{echo '<span>';}

echo JText::_('Garage').' : '.$row->garage.'</span><br />';

if(JRequest::getInt('minprice') or JRequest::getInt('maxprice')){echo '<span style="color:#FF0000">';}else{echo '<span>';}

echo JText::_('Price').' : '.(int)$row->price.'</span><br />';

if((JRequest::getInt('minarea') or JRequest::getInt('maxarea')) and $AreaToSearch=='area'){echo '<span style="color:#FF0000">';}else{echo '<span>';}

echo JText::_('Area').' : '.$row->area.'</span><br />';

if((JRequest::getInt('minarea') or JRequest::getInt('maxarea')) and $AreaToSearch=='covered_area'){echo '<span style="color:#FF0000">';}else{echo '<span>';}

echo JText::_('Covered Area').' : '.$row->covered_area.'</span><br />';

?>
		</div>
        
        
        
  <div class="data" style="float:right;width:24%;">      
    <?php    
	if(JRequest::getInt('e1')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra1').' : '.$row->extra1.'</span><br />'; 
	if(JRequest::getInt('e2')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra2').' : '.$row->extra2.'</span><br />';
	if(JRequest::getInt('e3')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra3').' : '.$row->extra3.'</span><br />';
	if(JRequest::getInt('e4')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra4').' : '.$row->extra4.'</span><br />';
	if(JRequest::getInt('e5')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra5').' : '.$row->extra5.'</span><br />';
	if(JRequest::getInt('e6')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra6').' : '.$row->extra6.'</span><br />';
	if(JRequest::getInt('e7')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra7').' : '.$row->extra7.'</span><br />';
	if(JRequest::getInt('e8')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra8').' : '.$row->extra8.'</span><br />';
	if(JRequest::getInt('e9')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra9').' : '.$row->extra9.'</span><br />';
	if(JRequest::getInt('e10')){echo '<span style="color:#FF0000">';}else{echo '<span>';}
	echo JText::_('extra10').' : '.$row->extra10.'</span><br />';  
    ?>    
    </div>    
        
               
	</div> 


	<div style="clear:both"></div>


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
