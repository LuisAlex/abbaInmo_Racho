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
 
JHTML::_('behavior.tooltip');
$option = JRequest::getVar('option');

?>
<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>
<table width="100%">
	<tr>
		<td align="left" width="200px" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>

		</td>
        <td align="left" valign="top" style="padding-left:10px;">
        
        
<table>
<tr>
<td colspan="2"><font color="green">Language actual : <?php echo JRequest::getVar('client') ? ' '. JText::_( 'Administrator' ) .'' : ''. JText::_( 'Site' ) .'' ?> / <?php echo $this->lang; ?></font></td>
</tr>
<tr>
<?php
if (JRequest::getVar('client',0) == 1) {
?>
<td width="100px;" align="center" valign="top"><a style="font-weight:bold;" href="<?php echo JRoute::_('index.php?option='.$option.'&view=languages&client=0');?>"><?php echo JText::_( 'Site' );?></a></td>
<td width="100px;" align="center" bgcolor="#F4F4F4" background="#CCCCCC"><a style="font-weight:bold; color: red;" href="<?php echo JRoute::_('index.php?option='.$option.'&view=languages&client=1');?>"><?php echo JText::_( 'Administrator' );?></a>

<?php 
foreach ($this->dirs as $dirs)
	{
	echo '<br><a href="'.JRoute::_('index.php?option='.$option.'&view=languages&client=1&id='.$dirs).'">'.$dirs.'</a>';
	}
echo '</td>';	
} else { 
?>

<td width="100px;" align="center" bgcolor="#F4F4F4"><a style="font-weight:bold; color: red;" href="<?php echo JRoute::_('index.php?option='.$option.'&view=languages&client=0');?>"><?php echo JText::_( 'Site' );?></a>
<?php 
foreach ($this->dirs as $dirs)
	{
	if(strlen($dirs)==5){
	echo '<br><a href="'.JRoute::_('index.php?option='.$option.'&view=languages&client=0&id='.$dirs).'">'.$dirs.'</a>';
	}
	}
echo '</td>';
?>
<td width="100px;" align="center" valign="top"><a style="font-weight:bold;" href="<?php echo JRoute::_('index.php?option='.$option.'&view=languages&client=1');?>"><?php echo JText::_( 'Administrator' );?></a></td>


<?php }?>

<?php ?>

</tr>

</table>       
 <form action="index.php" method="post" name="adminForm">

		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="220">
				<span class="componentheading">&nbsp;</span>
			</td>
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="5%" align="left">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="85%" align="left">
				<?php 
				$t_dir = $this->dir;
				echo $t_dir; ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Writable' ); ?>/<?php echo JText::_( 'Unwritable' ); ?>
			</th>
		</tr>
		<?php

		$k = 0;
		$t_files = $this->files;
		for ($i = 0, $n = count($t_files); $i < $n; $i++) {
			$file = & $t_files[$i];
?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td width="5%">
					<input type="radio" id="cb<?php echo $i;?>" name="filename" value="<?php echo htmlspecialchars( $file, ENT_COMPAT, 'UTF-8' ); ?>" onClick="isChecked(this.checked);" />
				</td>
				<td width="85%">
					<?php 
					$this_file_component=$this->lang.'.'.$option.'.ini';
					if($file==$this_file_component){
					echo '<font color="red" size="+1">'.$file.'</font>';
					}else{					
					echo $file; 
					}
					?>
				</td>
				<td width="10%">
					<?php echo is_writable($t_dir.DS.$file) ? '<font color="green"> '. JText::_( 'Writable' ) .'</font>' : '<font color="red"> '. JText::_( 'Unwritable' ) .'</font>' ?>
				</td>
			</tr>
		<?php

			$k = 1 - $k;
		}
?>
		</table>
		<input type="hidden" name="id" value="<?php echo $this->lang; ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $this->lang; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="client" value="<?php echo $this->client->id;?>" />
        <input type="hidden" name="controller" value="languages" />
		</form>
        
               
        
        
        
        
        
        </td>
	</tr>
</table>