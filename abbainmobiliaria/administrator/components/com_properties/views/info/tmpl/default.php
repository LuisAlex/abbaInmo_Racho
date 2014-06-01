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
					<legend><?php echo JText::_( 'Info' ); ?></legend>  
                    
                    
                    
<table>
	<tr>
		<td>
			<?php echo JText::_( 'Products' ).': '; ?>
		</td>
		<td align="left">
			<strong><?php echo $this->Totalproducts; ?></strong>
		</td>
	</tr>    
<?php 
foreach($this->Category as $c)
	{
	echo '<tr><td>'.$c['name'].'</td><td><strong>'.$c['products'].'</strong></td></tr>';
	}	
foreach($this->Type as $t)
	{
	echo '<tr><td>'.$t['name'].'</td><td><strong>'.$t['products'].'</strong></td></tr>';
	}		
?>  
</table> 

       		 	</fieldset>
    		</div>    	
		</td>
	</tr>
</table> 