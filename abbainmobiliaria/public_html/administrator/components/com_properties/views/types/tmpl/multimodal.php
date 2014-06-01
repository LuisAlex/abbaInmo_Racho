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

       
<form action="index.php?option=com_properties&amp;view=types&amp;layout=modal&amp;tmpl=component&amp;object=<?php echo JRequest::getVar('object');?>&amp;value=<?php echo JRequest::getVar('value'); ?>" method="post" name="adminForm">
<button type="button" onclick="javascript:areChecked();"><?php echo JText::_( 'Save List' ); ?></button>	
<br />
<div id="editcell">
	<table class="adminlist">
<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th  width="5">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'Type Name', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>			
			<th width="5" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                            
		</tr>
        <tr><td>
        <input type="hidden" value="<?php echo JRequest::getVar('value'); ?>" name="valores" id="valores" />
        </td></tr>
	</thead>
	<tbody>
    <script type="text/javascript">
	function checkMePls(control)
		{
		document.getElementById(control).checked = true;
		}	
 	</script>     
	<?php
	$k = 0;
	$i=0;
	$rows = &$this->items;	
	$value=JRequest::getVar('value');
	$valuesArray = explode(',',$value);

	foreach ($rows as $row) :			
		
		$checked 	= JHTML::_('grid.id',  $i, $row->id );
		$published 	= JHTML::_('grid.published', $row, $i );
		
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td width="5">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td width="5">
				<?php echo $checked; ?>
			</td>
            
 <?php if(in_array($row->id,$valuesArray)){  ?>            
 <script type="text/javascript">
 var  control = 'cb'+'<?php echo $i;?>';
 checkMePls(control);
 </script>     
<?php } ?>
			<td>             
            <span class="editlinktip hasTip" title="<?php echo JText::_( 'Select Type' );?>::<?php echo $row->name; ?>">
			<a style="cursor: pointer;" onclick="window.parent.jSelectType('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');">
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
		<?php endforeach;		
		?>
        
         <script type="text/javascript">
		 function areChecked()
			{
			var a=0;
			var saveValue = '';
			var entre=null;
			for(a==0;a<<?php echo $i;?>;++a)
				{
				control = 'cb'+a;
				if(document.getElementById(control).checked == true)
					{
					if(entre)
						{						
						saveValue =  saveValue + ',' +  document.getElementById(control).value ;
						}else{
						saveValue =  document.getElementById(control).value ;						
						}
					entre=true;
					}
				}
			 document.getElementById('valores').value = saveValue;
			 window.parent.jSelectType(saveValue, saveValue, '<?php echo JRequest::getVar('object'); ?>');
			}		 
         </script> 	
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

