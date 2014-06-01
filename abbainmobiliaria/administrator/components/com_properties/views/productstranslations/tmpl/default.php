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

global $mainframe;
		$filter_translation_language	= $mainframe->getUserStateFromRequest( "$option.filter_translation_language",'filter_translation_language','','string' );
	
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
			<?php echo JText::_( 'Filter' ); ?>:
			<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
			<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
		</td>
		        <td></td>       
            <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterCountry( $this->items[0],'country','products' ); ?>
            </td>
            <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterSid( $this->items[0],'sid','products' ); ?>
            </td>
            <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterLocality( $this->items[0],'locality','products' ); ?>
            </td>	
           
            </tr>
            <tr>
            <td><?php echo Filter::FilterTranslationLanguages(); ?></td>
            <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterCategory( $this->items[0],'category','products' ); ?>
            </td>
            <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterType( $this->items[0],'type','products' ); ?>
            </td>
            <td nowrap="nowrap" align="right">
			<?php echo $this->lists['state']; ?>
            </td> 
             <td nowrap="nowrap" align="right">
            <?php echo Filter::FilterFeatured( $this->items[0],'featured','products' ); ?>
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
				<?php echo JHTML::_('grid.sort',   'img', 'img', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  class="title">
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
				<?php echo JHTML::_('grid.sort',   'Country', 'cyid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
                        <th  class="title">
				<?php echo JHTML::_('grid.sort',   'State', 'sid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
            <th  class="title">
				<?php echo JHTML::_('grid.sort',   'Locality', 'lid', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>            
                  
            <th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
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
		
		if($this->productTranslation[$row->id])
					{
				$checked 	= JHTML::_('grid.id',  $i, $this->productTranslation[$row->id]->pt_id );
					}else{
				$checked 	= JHTML::_('grid.id',  $i, 0 );		
					}
		$published 	= JHTML::_('grid.published', $row, $i );
		$destacado = Helper::Destacado( $row, $i);
	?>
		<tr class="<?php echo "row0"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            
            <td>
            <?php  $img_path = JURI::root().'images/properties/images/thumbs/'.$row->id.'/'.$this->Images[$row->id][0]->name;?>
            <span class="editlinktip hasTip" title="<?php echo $row->name;?>::
<img border=&quot;1&quot; src=&quot;<?php echo $img_path; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available'.$img_path ); ?>&quot; width=&quot;200&quot; height=&quot;150&quot; />">
				<img width="30" src="<?php echo $img_path;?>" />
                </span>
                
			</td>
            
<td>
         <?php echo $row->name; ?>
</td>
<td align="center"><?php echo $row->ref; ?></td>
<td align="center"><?php echo $row->cid.':'.$row->name_category; ?></td>
<td align="center"><?php echo $row->name_type; ?></td>
<td align="center"><?php echo $row->name_country; ?></td>
<td align="center"><?php echo $row->name_state; ?></td>
<td align="center"><?php echo $row->name_locality; ?></td>
<td align="center"><?php echo $row->id; ?></td>         
		</tr>
		<?php
			
			
			
			if($filter_translation_language)
				{
				if($this->productTranslation[$row->id])
					{
					$pt = $this->productTranslation[$row->id];					
$link = JRoute::_( 'index.php?option='.$option.'&view=productstranslations&layout=form&task=edit&cid[]='.$row->id);										
					$buttonEdit = '<span class="editlinktip hasTip" title="Edit Translation::'.$pt->pt_name.'"><a href="'.$link.'">'.JText::_('Edit').' : '.$pt->pt_name.'</a></span>';
									
					}else{
					$buttonEdit = 'Add Translation';
					$link = JRoute::_( 'index.php?option='.$option.'&view=productstranslations&layout=form&task=edit&cid[]='.$row->id);										
					$buttonEdit = '<span class="editlinktip hasTip" title="Add Translation::"><a href="'.$link.'">'.JText::_('Add Translation').'</a></span>';
					}
					?>
                    
                    



                    <tr class="<?php echo "row1"; ?>">
                    <td align="center"></td> 
                    <td align="center"></td> 
                    <td align="center"></td> 
                    <td align="center"><?php echo $buttonEdit; ?></td>
                    <td align="center" colspan="7"></td>					
                    </tr>
                    <?php	
					
					
					
				
				}
				
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
	<input type="hidden" name="controller" value="productstranslations" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	
	</td>
		</tr>
			</table> 