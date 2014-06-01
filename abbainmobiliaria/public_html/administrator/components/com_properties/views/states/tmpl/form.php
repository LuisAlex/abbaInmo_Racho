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
jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$UseCountry=$params->get('UseCountry');
$UseCountryDefault=$params->get('UseCountryDefault');
$UseState=$params->get('UseState');
$UseStateDefault=$params->get('UseStateDefault');
$UseLocality=$params->get('UseLocality');
$UseLocalityDefault=$params->get('UseLocalityDefault');

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'select.php' );
?>
<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>

<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;

	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	if ( document.getElementById('name').value == "") {
		alert( "Item must have a Title" );
	}else if( document.getElementById('parent').value == 0 ){
 		alert( "Please select a Country" );				
	} else {
		submitform( pressbutton );
	}
}
//-->
</script>

<table width="100%">
	<tr>
		<td align="left" width="200" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>
		</td>
        <td align="left" valign="top">
        
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'State Details' ); ?></legend>
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Parent' ); ?>:
						</label>
			</td>
			<td>
            <?php echo SelectHelper::Select( $this->state,'country',$params ); ?>				
			</td>
		</tr>                 
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'State Name' ); ?>:
						</label>
			</td>
			<td>            
          
            <input class="text_area" type="text" name="name" id="name" size="60" maxlength="250" value="<?php echo $this->state->name;?>" />		
			</td>
		</tr>        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Alias' ); ?>:
						</label>
			</td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="60" maxlength="250" value="<?php echo $this->state->alias;?>" />
			</td>
		</tr>
        <tr>    
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Published' ); ?>:
						</label>
					</td>
                    					<td>
<?php $chequeado0 = $this->state->published ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->state->published ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
<?php if($this->state->published==''){$chequeado1 = JText::_( 'checked="checked"' );}?>    
    <input name="published" id="published0" value="0" <?php echo $chequeado0;?> type="radio">
	<label for="published0"><?php echo JText::_( 'No' ); ?></label>
	<input name="published" id="published1" value="1" <?php echo $chequeado1;?> type="radio">
	<label for="published1"><?php echo JText::_( 'Yes' ); ?></label>  
					</td>
				</tr>       
           <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Ordering' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="ordering" id="ordering" size="3" maxlength="5" value="<?php echo $this->state->ordering; ?>" />
					</td>
				</tr> 
                <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Map id' ); ?>:
						</label>
			</td>
			<td>
				<input class="text_area" type="text" name="mid" id="mid" size="3" maxlength="250" value="<?php echo $this->state->mid;?>" />
			</td>
		</tr>              
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->state->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="states" />
</form>
	</td>
		</tr>
			</table> 