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
 
$TableName = 'contacts';
JHTML::_('behavior.tooltip');
		//$ordering = ($this->lists['order'] == 't.ordering');	
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
          
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">      
 <fieldset class="adminform">
		<legend><?php echo JText::_( 'Datos del formulario enviado' ); ?></legend>       
        
<table class="adminlist">

<tr>
	<td width="30%" height="40">
		<label id="FormularioID" for="FormularioID"><?php echo JText::_( 'Formulario ID' ); ?>: </label>
	</td>
  	<td>
    <?php echo $this->contact->id; ?>
    </td>
</tr>   

<tr>
	<td width="30%" height="40">
		<label id="date" for="date"><?php echo JText::_( 'Date' ); ?>: </label>
	</td>
  	<td>
    <?php echo $this->contact->date; ?>
    </td>
</tr>   

<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="name"><?php echo JText::_( 'Property' ); ?>: </label>
	</td>
  	<td>
    <?php echo ' '.$this->contact->product_ref.' : '.$this->contact->product_name; ?>
    </td>
</tr>
                         
<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="name"><?php echo JText::_( 'Name' ); ?>: </label>
	</td>
  	<td>
    <?php echo $this->contact->name; ?>
    </td>
</tr>
<tr>
	<td height="40">
		<label id="emailmsg" for="email"><?php echo JText::_( 'Email' ); ?>: </label>
	</td>
	<td>
    <?php echo $this->contact->email; ?>
    </td>
</tr>
<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="phone"><?php echo JText::_( 'Phone' ); ?>: </label>
	</td>
  	<td>
    <?php echo $this->contact->phone; ?>
    </td>
</tr>

<tr>
	<td height="40">
		<label id="emailmsg" for="text">
			<?php echo JText::_( 'Message' ); ?>:
		</label>
	</td>
	<td>    
    <?php echo $this->contact->text; ?>    
	</td>
</tr>
</table>
	</fieldset>    
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->contact->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="<?php echo $TableName; ?>" />
<input type="hidden" name="controller" value="contacts" />
<input type="hidden" name="boxchecked" value="1" />
<input type="hidden" name="cid[0]" value="<?php echo $this->contact->id; ?>" />
</form>
	</td>
		</tr>
			</table> 