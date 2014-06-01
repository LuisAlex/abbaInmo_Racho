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


		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Edit Preferences') );
		JHTML::_('behavior.tooltip');
		$option=JRequest::getVar('option');
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
        
        
<form action="index.php" method="post" name="adminForm" autocomplete="off">

					 
		<table width="100%" border="0">			
            <tr>            
				<td width="48%" rowspan="2" valign="top">
                <fieldset>
				<legend>
					<?php echo JText::_( 'Properties List' );?>
                </legend>
                
      			<?php
				echo $this->params->render( 'params', 'list' );
				?>      
          		</fieldset>                
                </td>
           
           
           		<td width="48%" valign="top">              	     
            	<fieldset>
				<legend>
					<?php echo JText::_( 'Property Details' );?>
                </legend>
                
      			<?php
				echo $this->params->render( 'params', 'details' );
				?>      
          		</fieldset>   
                <fieldset>
				<legend>
					<?php echo JText::_( 'Calendar' );?>
                </legend>
                
      			<?php
				echo $this->params->render( 'params', 'booking' );
				?>      
          		</fieldset>         
          		 </td>
           </tr>            
</table>
<table width="100%" border="0">			
            <tr>            
				<td width="100%" valign="top">
        		<fieldset>
				<legend>
				<?php echo JText::_( 'Configuration' );?>
                </legend>
				<?php
				echo $this->params->render( 'params','config' );
				?>
           		</fieldset>            
          				</td>
                        </tr>                   
                </table>                

	
		<input type="hidden" name="id" value="<?php echo $this->component->id;?>" />
		<input type="hidden" name="component" value="<?php echo $this->component->option;?>" />		
		<input type="hidden" name="option" value="<?php echo $option; ?>" />       
		<input type="hidden" name="task" value="saveconfig" />
		<?php echo JHTML::_( 'form.token' ); ?>


	</form>
    </td>
		</tr>
			</table> 