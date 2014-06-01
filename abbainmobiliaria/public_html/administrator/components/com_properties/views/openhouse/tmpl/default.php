<?php defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$view = JRequest::getVar('view');
JHTML::_('behavior.tooltip');
	$ordering = ($this->lists['order'] == 'ordering');
	
?>

<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>
<table width="100%">
	<tr>
		<td align="left" width="200" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>

		</td>
        <td align="left" valign="top">
        
        
<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td nowrap="nowrap" align="right" width="50%">	    </td>
        
        
		<td nowrap="nowrap" align="right" width="50%">		
            <?php echo $this->FilterLocality; ?>            
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
			<th  width="5%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'Product Name', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
           
           <th  class="title">
				<?php echo JHTML::_('grid.sort',   'From', 'from', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'To', 'to', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
           
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'Published', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>	
            <th width="100px" nowrap="nowrap" >
						<?php echo JHTML::_('grid.sort',   'Order by', 'ordering', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						<?php echo JHTML::_('grid.order',  $this->items ); ?>
			</th>
					
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
    
    
<tbody>
	<?php
	$k = 0;
	//print_r($this->items);
	
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
$link 		= JRoute::_( 'index.php?option=com_properties&view=openhouse&layout=form&task=edit&cid[]='. $row->id);	

		
		$checked 	= JHTML::_('grid.id',  $i, $row->id );
		$published 	= JHTML::_('grid.published', $row, $i );
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td width="5%">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td width="5%">
				<?php echo $checked; ?>
			</td>
			<td>

				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit offer' );?>::<?php echo $row->name; ?>">
				<a href="<?php echo $link  ?>">
					<?php echo $row->name; ?></a></span>
				<?php
			//}
			?>
			</td>
            
            <td align="center">
				<?php				
				echo JHTML::_('date', $row->from, '%Y-%m-%d %H:%M:%S');
				?>
			</td>
            
            <td align="center">
				<?php echo JHTML::_('date', $row->to, '%Y-%m-%d %H:%M:%S');?> 
			</td>
          
            
            
			<td align="center">
				<?php echo $published;?>
			</td>	
            
            <td class="order">
					<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', $ordering ); ?></span>
					<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
                    <input type="hidden" name="itemid[]" value="<?php echo $row->id;?>" />
				</td>
                		
			<td align="center">
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
			$k = 1 - $k;
		}
		?>
	</tbody>     

<tfoot>
    <tr>
      <td colspan="13"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  </tfoot>
</table>
</div>
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
     <input type="hidden" name="view" value="<?php echo $view; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<input type="hidden" name="controller" value="openhouse" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</td>
	</tr>	
		</table>