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
	$ordering = ($this->lists['order'] == 'ordering');	
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$currencyformat=$params->get('FormatPrice');	
$expireDays=$params->get('expireDays');
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'filter.php' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>



<table width="100%">
	<tr>
		<td align="left" width="200" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>
		</td>
        <td align="left" valign="top">        
   
<form action="index.php" method="post" name="adminForm">
<table width="100%">
	<tr>
		<td align="left"  width="100%">
			
		</td>
		        <td></td>       
            <td nowrap="nowrap">
            <?php echo Filter::FilterTranslationTables(); ?>
            </td>   
            <td nowrap="nowrap">
            <?php echo Filter::FilterTranslationLanguages(); ?>
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
             <th  class="img">
				<?php echo JHTML::_('grid.sort',   'Name', 'p.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'Alias', 'p.alias', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Translation Name', 't_value', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
 <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Translation Alias', 't_alias', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Lang', 't_languagecode', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Published', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'ID', 't_id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>            

		</tr>
	</thead> 
<tbody>
	<?php
	if($this->items[0]->id)
	{
	$k = 0;
	
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
$link 		= JRoute::_( 'index.php?option='.$option.'&view='.$view.'&layout=form&task=edit&cid[]='. $row->t_id);	
		
		$checked 	= JHTML::_('grid.id',  $i, $row->t_id );
		//$row->published=$row->t_published;
		$published 	= JHTML::_('grid.published', $row, $i );
		$destacado = Helper::Destacado( $row, $i);
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
          
            
<td><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></td>
<td align="center"><?php echo $row->alias; ?></td>


<td align="center">
            <input type="hidden" name="fid[<?php echo $row->id; ?>]" id="fid<?php echo $row->id; ?>" value="<?php echo $row->id; ?>"  />            
            <input type="hidden" name="tid[<?php echo $row->id; ?>]" id="tid<?php echo $row->id; ?>" value="<?php echo $row->t_id; ?>"  />
            <input type="hidden" name="tfieldid[<?php echo $row->id; ?>]" id="tfieldid<?php echo $row->id; ?>" value="<?php echo $row->t_fieldid; ?>"  />            
            <input type="text" name="tvalue[<?php echo $row->id; ?>]" id="tvalue<?php echo $row->id; ?>" value="<?php echo $row->t_value; ?>"  />
</td>
     
      <td>
            <input type="text" name="talias[<?php echo $row->id; ?>]" id="talias<?php echo $row->id; ?>" value="<?php echo $row->t_alias; ?>"  />
            <input type="hidden" name="originalnames[<?php echo $row->id; ?>]" id="originalnames<?php echo $row->id; ?>" value="<?php echo $row->name; ?>"  />            
           
            </td>
     
            
            
<td align="center"><?php echo $row->t_languagecode; ?></td>
<td align="center"><?php echo $published;?></td>
<td align="center"><?php echo $row->t_id; ?></td>
 
        
        
		</tr>
		<?php
			$k = 1 - $k;
			}
		}
		?>
	</tbody>
    <tfoot>
    <tr>
      <td colspan="19"><?php echo $this->pagination->getListFooter(); ?></td>
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
	<input type="hidden" name="controller" value="translations" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	
</td>
	</tr>	
		</table>