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

$option = JRequest::getCmd('option');
JHTML::_('behavior.tooltip');
$product_id=JRequest::getInt('productid');
?>        
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Rate Details' ); ?></legend>
        <div style="float: right;">
				<button type="button" onclick="submitbutton('removeModal');">
					Delete</button>
				<button type="button" id="sbox-btn-close" onclick="window.parent.document.getElementById('sbox-window').close();window.close();">
					Cancelar</button>
			</div>
		<table class="admintable">        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name"><?php echo JText::_( 'Delete' ); ?>:	</label>
			</td>
			<td>         
        </td>
		</tr>                            
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="cid" value="<?php echo $this->rate->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="productrates" />
<input type="hidden" name="modal" value="1" />
<input type="hidden" name="returnproductid" value="<?php echo $returnproductid; ?>" />
</form>