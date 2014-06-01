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

$TableName = 'order_bookings';
JHTML::_('behavior.tooltip');
//print_r($this->items);	
?>

<form action="index.php" method="post" name="adminForm">
<table>
	<tr>
		<td align="left" width="100">				
			<button onclick="document.getElementById('filter_cities_b').value='0';this.form.getElementById('filter_residence_b').value='0';this.form.getElementById('filter_property_b').value='0';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		
       		<td nowrap="nowrap" align="left">
            <?php //echo Filter::FilterLocalityBookings( $this->items[0],'locality','bookings' ); ?>
            
            <?php //echo Filter::FilterResidenceBookings( $this->items[0],'property','bookings' ); ?>
            
            <?php //echo Filter::FilterPropertyBookings( $this->items[0],'property','bookings' ); ?>
            </td>
            
            <td></td>
       		<td nowrap="nowrap" align="right" width="100%">
            <?php //echo Filter::FilterAgency( $this->items[0],'agency','bookings' ); ?>
           
            <?php //echo Filter::FilterPeriod( $this->items[0],'period','bookings' ); ?>
            
            <?php //echo Filter::FilterPartenza( $this->items[0],'period','bookings' ); ?>
            
            <?php //echo Filter::FilterConfirmed( $this->items[0],'confirmed','bookings' ); ?>
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
           
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'Product', 'ob_id_property', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                    
           <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Name', 'ob_name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Creation Date', 'ob_created', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'From', 'ob_from', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>  
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'To', 'ob_to', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'Price', 'ob_price', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Confirmed', 'ob_confirmed', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
              
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'ob_id_order', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>                    			
		</tr>
	</thead> 
<tbody>
	<?php
	//print_r($this->items);
	$k = 0;
	$total_price='';
	if(isset($this->items) and isset($this->items[0]->ob_id_order)){
	//if($this->items[0]->ob_id_order){
	
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
$link 		= JRoute::_( 'index.php?option=com_properties&view=bookings&layout=form&task=edit&cid[]='. $row->ob_id_order);
		
		$checked 	= JHTML::_('grid.id',  $i, $row->ob_id_order );
		$published 	= JHTML::_('grid.published', $row, $i );
		$total_price=$total_price+$row->ob_price;
		
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            
           
            
            
<td>
<?php $img_path = JURI::root().'images/properties/'.$row->image1;?>
<span class="editlinktip hasTip" title="<?php echo $row->name;?>::
<table border=&quot;0&quot; width=&quot;206&quot; ><tr><td>Id : <?php echo $row->id;?></td></tr><tr><td>Ref : <?php echo $row->ref;?></td></tr><tr><td></td></tr><tr><td></td></tr></table>">
<a href="<?php echo $link; ?>"><?php echo $row->name;?></a></span>
</td>

<?php
$conf[0] = JText::_( 'New Booking' );
$conf[1] = JText::_( 'Received' );
$conf[2] =  JText::_( 'Pending' ) ;
$conf[3] =  JText::_( 'Accepted' ) ;
$conf[4] =  JText::_( 'Canceled' ) ;
$conf[5] =  JText::_( 'Contract' ) ;

$color[0]='#000000';	
$color[1]='#FF9900';
$color[2]='#3366FF';
$color[3]='#33CC33';
$color[4]='#FF0000';
$color[5]='#FFCC00';
?>

<td align="center"><?php echo $row->ob_name; ?></td>
<td align="center"><?php echo date('d-m-Y',strtotime($row->ob_created));?></td>
<td align="center"><?php echo date('d - m',strtotime($row->ob_from));?></td>
<td align="center"><?php echo date('d - m',strtotime($row->ob_to));?></td>
<td align="center"><?php echo $row->ob_price;?></td>
<td align="center"><span style=" font-weight:bold;color:  <?php echo $color[$row->ob_confirmed];?>"><?php echo $conf[$row->ob_confirmed];?></span>
</td>

<td align="center"><?php echo $row->ob_id_order; ?></td>   			


		
		</tr>
		<?php
			$k = 1 - $k;
		}
		}
		?>
        <tr>
        <td colspan="7">
        </td>
        <td align="center"><?php echo $total_price; ?>
        </td>
        <td colspan="2">
        </td>
        
        </tr>
	</tbody>
    <tfoot>
    <tr>
      <td colspan="14"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  </tfoot>
	</table>
</div>

	<input type="hidden" name="option" value="com_properties" />
    <input type="hidden" name="table" value="order_bookings" />
    <input type="hidden" name="view" value="bookings" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="controller" value="bookings" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	
<?php 
jimport( 'joomla.application.application' );
global $mainframe, $option;
$mainframe->setUserState("$option.filter_order", NULL);
?>