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


?>
<div class="agentdata">        
         
<?php
$row=$this->agent;
$ItemID=LinkHelper::getItemid('agentlistings');
$link = JRoute::_( 'index.php?option=com_properties&amp;view=agentlistings&amp;aid='.$row->id.':'.$row->alias.'&amp;Itemid='.$ItemID);

if($row->image!=NULL){ $img=$row->image;}else{$img='noimage.jpg';}
$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS.$img;
if (JFile::exists($destino_imagen)){
$imgTag='<img class="agentimage" src="images/properties/profiles/'.$img.'" alt="'. str_replace('"',' ',$row->alias) .'" />'; 
 }else{
 $imgTag='<img src="images/properties/profiles/noimage.jpg" />';}
?>
<div class="details">
<div class="agentimage">
<?php echo $imgTag;?>
</div>

<div class="data">
<a href="<?php echo $link; ?>"><?php echo $row->name; ?></a><br />
<?php if($row->company){echo JText::_('Company') .' : '. $row->company.'<br />';} ?>
<?php if($row->country){echo $row->country.' ('.$row->state.') ,'.$row->locality.'<br />';} ?>

<?php if($row->address1){echo  $row->address1.'<br />';} ?>
<?php if($row->address2){echo JText::_('Address2') .' : '. $row->address2.'<br />';} ?>

<?php if($row->email){echo JText::_('Email') .' : '. $row->email.'<br />';} ?>
<?php if($row->phone){echo JText::_('Phone') .' : '. $row->phone.'<br />';} ?>
<?php if($row->fax){echo JText::_('Fax') .' : '. $row->fax.'<br />';} ?>
<?php if($row->mobile){echo JText::_('Mobile') .' : '. $row->mobile.'<br />';} ?>

</div><!--data -->

<div class="rightdata">
	<div class="logoag">
	<img src="images/properties/profiles/<?php echo $row->logo_image;?>" alt="<?php echo $row->alias;?>" />
	</div>
</div>  

</div> <!--details -->



</div>  <!--agent -->
<div style="clear:both"></div>
 <!---->