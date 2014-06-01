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
        
<?php 
$content=JRequest::getVar('content');
//print_r($content);   
$ftp=JRequest::getVar( 'ftp');
$lang=JRequest::getVar('lang');
$filename=JRequest::getVar('filename');
$client	=JRequest::getVar('client');
echo JText::_('Editando').' : <font color="green">'.JText::_($client->name).'</font>  '.JText::_('Language').' : <font color="green">'.$lang.'  </font>'.JText::_('Archivo').' : <font color="green">'.$filename.'</font>';
   
?>        

		


		<form action="index.php" method="post" name="adminForm">

		<?php if($ftp): ?>
		<fieldset title="<?php echo JText::_('DESCFTPTITLE'); ?>">
			<legend><?php echo JText::_('DESCFTPTITLE'); ?></legend>

			<?php echo JText::_('DESCFTP'); ?>

			<?php if(JError::isError($ftp)): ?>
				<p><?php echo JText::_($ftp->message); ?></p>
			<?php endif; ?>

			<table class="adminform nospace">
			<tbody>
			<tr>
				<td width="120">
					<label for="username"><?php echo JText::_('Username'); ?>:</label>
				</td>
				<td>
					<input type="text" id="username" name="username" class="input_box" size="70" value="" />
				</td>
			</tr>
			<tr>
				<td width="120">
					<label for="password"><?php echo JText::_('Password'); ?>:</label>
				</td>
				<td>
					<input type="password" id="password" name="password" class="input_box" size="70" value="" />
				</td>
			</tr>
			</tbody>
			</table>
		</fieldset>
		<?php endif; ?>

		<table class="adminform">
		<tr>
			<th>
				<?php echo $css_path; ?>
			</th>
		</tr>
		<tr>
			<td>
				<textarea style="width:100%;height:500px" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $content; ?></textarea>
			</td>
		</tr>
		</table>

		
		<input type="hidden" name="filename" value="<?php echo $filename; ?>" />        
		<input type="hidden" name="id" value="<?php echo $lang; ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $lang; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="client" value="<?php echo $client->id;?>" />
        <input type="hidden" name="controller" value="languages" />

        <?php echo JHTML::_( 'form.token' ); ?>
		</form>
               
        
        
        
        
        
        </td>
	</tr>
</table>