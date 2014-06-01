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
JHTML::_('behavior.tooltip');
		$ordering = ($this->lists['order'] == 't.ordering');	
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
		<td align="left" width="100%">			
		</td>
		<td nowrap="nowrap">
			    
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
			<th width="5">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>      
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Property', 'property_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>      
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Date', 'date', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Mail', 'email', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Message', 'text', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>            
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'form_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th width="1%" nowrap="nowrap">
				
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$k = 0;
	$i=0;
	$rows = &$this->items;
	if($rows){
	foreach ($rows as $row) :		
$link 		= JRoute::_( 'index.php?option='.$option.'&view='.$view.'&layout=form&task=edit&cid[]='. $row->id);		
		$checked 	= JHTML::_('grid.id',  $i, $row->id );
		//$published 	= JHTML::_('grid.published', $row, $i );		
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td width="5">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td width="5">
				<?php echo $checked; ?>
			</td>		
            <td>
   			 <?php echo ' '.$row->product_ref.' : '.$row->product_name; ?>
    		</td>	
            <td align="center">
				<?php echo $row->date; ?>
			</td>			
            
            <td align="center">
				<?php echo $row->email; ?>
			</td>             
            <td align="center">
            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Texto del mensaje' );?>::<?php echo $row->text; ?>"><?php echo substr($row->text,0,50); ?></span>
			</td>  						
			<td align="center">
				<?php echo $row->id; ?>
			</td>
            <td align="center">
            <a href="<?php echo $link; ?>">Ver Formulario</a>            
            </td>
		</tr>
		<?php
			$k = 1 - $k;
			$i++;
		//}
		?>
		<?php endforeach; }?>		
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
	<input type="hidden" name="controller" value="contacts" />    
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	
<?php 
jimport( 'joomla.application.application' );
global $mainframe, $option;
$mainframe->setUserState("$option.filter_order", NULL);
?>
	</td>
		</tr>
			</table> 