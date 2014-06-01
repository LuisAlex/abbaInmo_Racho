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
$productid = JRequest::getVar('productid');
$returnproductid = JRequest::getVar('productid');

//print_r($this->rate);
?>

<table width="100%">
	<tr>
		
        <td align="left" width="80%" valign="top">
        
<form action="index.php" method="post" name="adminForm" id="adminForm">
<input type="hidden" name="productid" value="<?php echo $productid; ?>" />
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Rate Details' ); ?></legend>

 <div style="float: right;">
				<button type="button" onclick="submitbutton('save');">
					Guardar</button>
				<button type="button" id="sbox-btn-close" onclick="window.parent.document.getElementById('sbox-window').close();window.close();">
					Cancelar</button>
			</div>
            		<table class="admintable">                            
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'Rate Title' ); ?>:
				</label>
			</td>
			<td>            
            <input class="text_area" type="text" name="title" id="title" value="<?php echo $this->rate->title; ?>"  />				
			</td>
		</tr> 
 
		<tr>
        	<td width="100" align="right" class="key">
      <label for="from"><?php echo JText::_('From'); ?> :</label>
  			</td><td>      
      <?php echo JHTML::_('calendar', $this->rate->validfrom, 'validfrom', 'validfrom', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>      
 			</td><td>
		</tr>
        <tr>
        	<td width="100" align="right" class="key">  
      <label for="to"><?php echo JText::_('To'); ?> :</label>
    		</td><td>    
      <?php echo JHTML::_('calendar', $this->rate->validto, 'validto', 'validto', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>
			</td>
        </tr>       
        <tr>
			<td width="100" align="right" class="key">
				<label for="rateperday">
							<?php echo JText::_( 'x Day' ); ?>:
						</label>
			</td>
			<td>
				<input class="text_area" type="text" name="rateperday" id="rateperday" size="3" maxlength="250" value="<?php echo $this->rate->rateperday;?>" />
			</td>
		</tr>   
        
         <tr>    
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Week Only' ); ?>:
						</label>
					</td>
                    					<td>
<?php $weekonly0 = $this->rate->weekonly ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $weekonly1 = $this->rate->weekonly ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="weekonly" id="weekonly0" value="0" <?php echo $weekonly0;?> type="radio">
	<label for="weekonly0"><?php echo JText::_( 'No' ); ?></label>
	<input name="weekonly" id="pweekonly1" value="1" <?php echo $weekonly1;?> type="radio">
	<label for="weekonly"><?php echo JText::_( 'Yes' ); ?></label>  
					</td>
				</tr>                  
                <tr>
					<td class="key">
						<label for="rateperweek">
							<?php echo JText::_( 'x Week' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="rateperweek" id="rateperweek" size="3" maxlength="5" value="<?php echo $this->rate->rateperweek; ?>" />
					</td>
				</tr>          
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->rate->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="productrates" />
<input type="hidden" name="returnproductid" value="<?php echo $returnproductid; ?>" />
</form>
       
	</td>
		</tr>
			</table> 