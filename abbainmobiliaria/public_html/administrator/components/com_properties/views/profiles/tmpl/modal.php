<?php 
/**
* @copyright	Copyright(C) 2008-2010 Fabio Esteban Uzeltinger
* @license 		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @email		admin@com-property.com
**/
defined('_JEXEC') or die('Restricted access'); 
$option = JRequest::getVar('option');
$view = JRequest::getVar('view');

JHTML::_('behavior.tooltip');
		$this->ordering = ($this->lists['order'] == 'ordering');	
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'filter.php' );
?>

       
<form action="index.php?option=com_properties&amp;view=profiles&amp;layout=modal&amp;tmpl=component&amp;object=<?php echo JRequest::getVar('object');?>" method="post" name="adminForm">

<div id="editcell">
	<table class="adminlist">
<thead>
		<tr>
			
			
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'Agent Name', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>			
			<th width="5" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                            
		</tr>
	</thead>
	<tbody>
	<?php
	$k = 0;
	$i=0;
	$rows = &$this->items;	
	foreach ($rows as $row) :			
		
		$checked 	= JHTML::_('grid.id',  $i, $row->id );
		$published 	= JHTML::_('grid.published', $row, $i );
		
	?>
		<tr class="<?php echo "row$k"; ?>">
			
			<td>  
            
            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Select Agent' );?>::<?php echo $row->name; ?>">
			<a style="cursor: pointer;" onclick="window.parent.jSelectAgent('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');">
			<?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?>
            </a>
            </span>
				
			</td>
					
					
			<td align="center">
				<?php echo $row->id; ?>
			</td>            
            
		</tr>
		<?php
			$k = 1 - $k;
			$i++;		
		?>
		<?php endforeach; ?>
		
	</tbody>
    <tfoot>
    <tr>
      <td colspan="13"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  </tfoot>
	</table>
</div>

	<input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="table" value="<?php echo $TableName; ?>" />
    <input type="hidden" name="view" value="<?php echo $view; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="controller" value="<?php echo $view; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	

