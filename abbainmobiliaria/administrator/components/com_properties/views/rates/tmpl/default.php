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

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');
$productid = JRequest::getVar('productid');
JHTML::_('behavior.tooltip');
	$ordering = ($this->lists['order'] == 'ordering');
?>

<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>

<table width="100%">
	<tr>
		<td align="left" width="20%" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>

		</td>
        <td align="left" width="80%" valign="top">
        
<div style="width:100px; float:left;border: 1px solid #CCCCCC;">
<table>
	<tr>
    	<td align="center">
<?php $linkReturn = JRoute::_( 'index.php?option='.$option.'&view=products&layout=form&task=edit&cid[]='. $productid);?>
        <a href="<?php echo $linkReturn;  ?>"><?php echo JText::_('Return Property'); ?></a> 

		</td>        
	</tr>
</table>
</div>      
<div style="clear:both"></div>

<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100%">
			<?php echo JText::_( 'Filter' ); ?>:
			<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		<td nowrap="nowrap">
			<?php echo $this->lists['state']; ?>
		</td>
        
        
        
        
        
        
        
        
        <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterProductComments( $this->items[0],'products','products' ); ?>
            </td>
            
            <td nowrap="nowrap">
        
        <?php 
		
		global $mainframe, $option;

$filter_product_comment		= $mainframe->getUserStateFromRequest( "$option.filter_product_comment",		'filter_product_comment',		'',		'int' );
		
		
		if($filter_product_comment){?>
         <?php
			 $link 		= JRoute::_( 'index.php?option=com_properties&controller=rates&task=addWeekRange&productid='.$filter_product_comment.'&return=rates'. $row->id);	
			  echo '<a href="'.$link.'" >'.JText::_( 'Add Week Range' ).'</a>';?> 
        
         <?php }?>
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
				<?php echo JHTML::_('grid.sort',   'Property', 'product_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'Rate Title', 'title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'From', 'validfrom', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'To', 'validto', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Rate x day', 'rateperday', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Week Only', 'weekonly', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'week', 'week', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Rate x week', 'rateperweek', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'Published', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>	
           	<th width="100px" nowrap="nowrap">
            <?php echo JHTML::_('grid.sort',   'Order by', 'ordering', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				<?php if ($ordering) echo JHTML::_('grid.order',  $this->items ); ?>
              </th>  				
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
    
    
<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
$link 		= JRoute::_( 'index.php?option='.$option.'&view='.$view.'&layout=form&task=edit&cid[]='. $row->id);	

		
		$checked 	= JHTML::_('grid.id',  $i, $row->id );
		$published 	= JHTML::_('grid.published', $row, $i );
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td align="center">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td align="center">
				<?php echo $checked; ?>
			</td>
            <td align="center">
				<?php echo $row->productid;?>
			</td>
			<td>

				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Country' );?>::<?php echo $row->name; ?>">
				<a href="<?php echo $link  ?>">
					<?php echo $row->title; ?></a></span>
				<?php
			//}
			?>
			</td>            
            <td align="center">
				<?php echo $row->validfrom;?>
			</td>
            <td align="center">
				<?php echo $row->validto;?>
			</td>
            <td align="center">
				<?php echo $row->rateperday;?>
			</td>
            <td align="center">
				<?php echo $row->weekonly;?>
			</td>
            <td align="center">
				<?php echo $row->week;?>
			</td>
            <td align="center">
            
            <input size="5" type="text" name="price[<?php echo $row->id; ?>]" id="price[<?php echo $row->id; ?>]" value="<?php echo $row->rateperweek; ?>" />
            
            
				<?php //echo $row->rateperweek;?>
			</td>
			<td align="center">
				<?php echo $published;?>
			</td>	
            
            <td class="order" nowrap="nowrap">            
				<span><?php echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', $ordering ); ?></span>
					<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>             
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>                
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
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
<input type="hidden" name="controller" value="rates" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
</td>
	</tr>	
		</table>