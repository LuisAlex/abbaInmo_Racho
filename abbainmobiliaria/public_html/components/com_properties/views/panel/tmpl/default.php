<?php defined('_JEXEC') or die('Restricted access'); 
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
JHTML::_('behavior.formvalidation');
$document =& JFactory::getDocument();
jimport('joomla.filesystem.file');
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$RegisteredAutoPublish=$params->get('RegisteredAutoPublish',1);
?>

	<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform(pressbutton);		
	} else {
		submitform(pressbutton);		
	}
}		
//-->
</script>
    
<form action="<?php echo JRoute::_('index.php?option=com_properties&view=panel&Itemid='.LinkHelper::getItemid('panel'))?>" method="post" name="adminForm" id="adminForm">
                
<div class="toolbar" id="toolbar">
<table class="toolbar"><tr>
<td class="button" id="toolbar-edit">
<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Por favor, selecciona la propiedad que deses editar');}else{  submitbutton('edit')}">
<span class="icon-32-edit" title="<?php echo JText::_('Edit');?>">
</span>
<?php echo JText::_('Edit');?>
</button>
</td>
<td class="button" id="toolbar-new">
<button type="button" onclick="submitbutton('add')">
<span class="icon-32-new" title="<?php echo JText::_('New');?>">
</span>
<?php echo JText::_('New');?>
</button>
</td>
<td class="button" id="toolbar-delete">
<button type="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Por favor, selecciona la propiedad que deses borrar');}else{  submitbutton('remove')}">
<span class="icon-32-delete" title="<?php echo JText::_('Delete');?>">
</span>
<?php echo JText::_('Delete');?>
</button>
</td>
</tr></table>
</div>      
                
<?php echo $this->showToolBarTitle;?>

<table>
	
            <tr>            
            <td nowrap="nowrap" align="right">
            <?php //echo Filter::FilterCategory( $this->items[0],'category','products' ); ?>
            </td>
            <td nowrap="nowrap" align="right">
            <?php //echo Filter::FilterType( $this->items[0],'type','products' ); ?>
            </td>           
             <td nowrap="nowrap" align="right">
            <?php //echo Filter::FilterFeatured( $this->items[0],'featured','products' ); ?>
            </td>
            	
	</tr>
</table>
<div id="editcell">
<table class="adminlist">
<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
             <th align="center" colspan="2" class="title">
				
				<?php echo JHTML::_('grid.sort',   'Title', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Ref', 'ref', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Category', 'cid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Type', 'type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>                        
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Locality', 'lid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>              
			<th width="5%" align="center" class="title">
				<?php echo JHTML::_('grid.sort',   'Hits', 'hits', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th width="5%" align="center" class="title">
				<?php echo JHTML::_('grid.sort',   'Publ', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>        
		</tr>
	</thead> 
<tbody>
	<?php



	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];

$link = JRoute::_( 'index.php?option=com_properties&view=panel&task=edit&id='.$row->id.'&Itemid='.$Itemid);		
		$checked 	= JHTML::_('grid.id',  $i, $row->id );
	?> 
    
<?php
$rout_image = 'images/properties/images/'.$row->id.'/';
$rout_thumb = 'images/properties/images/thumbs/'.$row->id.'/';

if($this->Images[$row->id][0]->name!=NULL){ 
$img=$this->Images[$row->id][0]->name;
}else{
$img='noimage.jpg';
}
?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            
            <td>
            <?php $img_path = JURI::root().'images/properties/peques/peque_'.$row->image1;?>
            <span class="editlinktip hasTip" title="<?php echo $row->name;?>::
<img border=&quot;1&quot; src=&quot;<?php echo $rout_thumb.$img; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'Vista previa no disponible'.$img_path ); ?>&quot; width=&quot;200&quot; height=&quot;150&quot; />">
				<img width="30" src="<?php echo JURI::root().$rout_thumb.$img;?>" />
                </span>
                
			</td>
            
<td>
          <?php $img_path = JURI::root().'images/properties/'.$row->image1;?>
<span class="editlinktip hasTip" title="Edit::
<?php echo $row->name; ?> ">
<button class="buttonpropname" type="button" onclick="javascript:document.getElementById('cb<?php echo $i;?>').checked=true;submitbutton('edit')">
<?php echo $row->name; ?>
</button>
</span>

</td>
<td align="center"><?php echo $row->ref; ?></td>
<td align="center"><?php echo $row->name_category; ?></td>
<td align="center"><?php echo $row->name_type; ?></td>
<td align="center"><?php echo $row->name_locality; ?></td>
<td align="center"><?php echo $row->hits; ?></td>  
<td align="center">
<?php 
$img 	= $row->published ? 'tick.png' : 'publish_y.png';
$alt 	= $row->published ? JText::_( 'Publicado' ) : JText::_( 'No publicado' );
echo '<img src="components/com_properties/includes/img/panel/'. $img .'" border="0" alt="'. $alt .'" />';

?>
</td>		
 		
		</tr>
		<?php
			$k = 1 - $k;
		}
		?>
	</tbody>
    <tfoot>
    <tr>
      <td colspan="16"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  </tfoot>
	</table>
</div>

	<input type="hidden" name="option" value="com_properties" />
    <input type="hidden" name="view" value="panel" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="controller" value="panel" />
    <input type="hidden" name="Itemid" value="<?php echo LinkHelper::getItemid('panel'); ?>" />

	<?php echo JHTML::_( 'form.token' ); ?>
</form>	
<div style="clear:both;"></div>
<?php 
jimport( 'joomla.application.application' );
global $mainframe, $option;
$mainframe->setUserState("$option.filter_order", NULL);
?>


