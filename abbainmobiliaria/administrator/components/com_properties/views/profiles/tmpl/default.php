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
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$currencyformat=$params->get('FormatPrice');	
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
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
				<?php echo JHTML::_('grid.sort',   'Name', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
             <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Company', 'company', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Ref', 'info', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>           
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Type', 'type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Locality', 'locality', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>            
			<th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'Published', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>	
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'Show', 'show', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>		
            <th width="5%" align="center">
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
		$show = Helper::Show( $row, $i);
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
<td>
          <?php $img_path = JURI::root().'images/properties/profiles/'.$row->image;?>
<span class="editlinktip hasTip" title="<?php echo $row->name;?>::
<img border=&quot;1&quot; src=&quot;<?php echo $img_path; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available'.$img_path ); ?>&quot; width=&quot;206&quot; height=&quot;145&quot; />">
<a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></span>
</td>
<td align="center"><?php echo $row->company; ?></td>
<td align="center"><?php echo $row->info; ?></td>
<td align="center"><?php echo $row->type; ?></td>
<td align="center"><?php echo $row->locality; ?></td>
<td align="center"><?php echo $published;?></td>
<td align="center"><?php echo $show;?></td>
<td align="center"><?php echo $row->id; ?></td>   			
 		
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
	<input type="hidden" name="controller" value="profiles" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	
	</td>
		</tr>
			</table> 