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

$TableName = 'about';
JHTML::_('behavior.tooltip');
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>
<table width="100%">
	<tr>
		<td align="left" width="20%" valign="top">
		<?php echo MenuLeft::ShowMenuLeft();?>
		</td>
        <td align="left" width="80%" valign="top">    
    		<div class="col100">
				<fieldset class="adminform">
					<legend><?php echo JText::_( 'Help' ); ?></legend>        
       		 	</fieldset>
    		</div>    	
		</td>
	</tr>
</table> 
