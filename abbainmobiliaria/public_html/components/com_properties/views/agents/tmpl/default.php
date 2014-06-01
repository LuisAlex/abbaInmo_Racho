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
JHTML::_('behavior.tooltip');
jimport('joomla.filesystem.file');
$document =& JFactory::getDocument();

$user =& JFactory::getUser();
$menus = &JSite::getMenu();
		$menu  = $menus->getActive();
		$menu_params = new JParameter( $menu->params );
		
		if($menu_params->get('show_page_title') & $menu_params->get('page_title'))
		{
			$title=$menu_params->get('page_title');		
		}elseif($menu_params->get('titlepage')){
			$title = $menu_params->get('titlepage');			
		}else{
			$title = $mainframe->getCfg( 'sitename' );
		}			
		
		if($menu_params->get('description')){
			$description = $menu_params->get('description');		
		}else{
			$description = $mainframe->getCfg( 'MetaDesc' );	
		}			
			
		if($menu_params->get('keywords')){
			$keywords = $menu_params->get('keywords');	
		}else{
			$keywords = $mainframe->getCfg( 'MetaKeys' );	
		}
			
			$document->setTitle( $title );
			$document->setDescription($description);
			$document->setMetadata('keywords',$keywords);

$component = JComponentHelper::getComponent( 'com_properties' );
$this->params = new JParameter( $component->params );
$ShowOrderBy=$this->params->get('ShowOrderBy');
$Listlayout=$this->params->get('Listlayout');
JHTML::_('behavior.modal');

	//echo $this->loadTemplate('list');	
//require_once( JPATH_COMPONENT.DS.'views'.DS.'templates'.DS.$Listlayout.'_list'.'.php' );
?>









<div id="agents">
<?php

$ItemID=LinkHelper::getItemid('agentlistings');
$link = '#';
    $k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	
    {
$row = &$this->items[$i];
if($ItemID)
{
$link = JRoute::_( 'index.php?option=com_properties&amp;view=agentlistings&amp;aid='.$row->id.':'.$row->alias.'&amp;Itemid='.$ItemID);
}
?>
        
<div class="agent">        
         
<?php
if($row->image!=NULL){ $img=$row->image;}else{$img='noimage.jpg';}
$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties'.DS.'profiles'.DS.$img;
if (JFile::exists($destino_imagen)){
$imgTag='<img class="agentimage" src="images/properties/profiles/'.$img.'" alt="'. str_replace('"',' ',$row->alias) .'" />'; 
 }else{
 $imgTag='<img src="images/properties/profiles/noimage.jpg" />';}
?>
<div class="details">
<div class="agentimage">
<a href="<?php echo $link; ?>">
<?php echo $imgTag;?>
</a>
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


                 
<a href="<?php echo $link;?>"><?php echo JText::_('View Properties from this Agent'); ?></a><br />
</div><!--data2 -->
<div class="rightdata">
	<div class="logoagent">
	<img src="images/properties/profiles/<?php echo $row->logo_image;?>" alt="<?php echo $agent->alias;?>" />
	</div>
</div>    
</div> <!--details -->

</div>  <!--agent -->
  
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


</div><!-- agents-->