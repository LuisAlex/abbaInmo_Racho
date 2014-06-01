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

$TableName = 'order_bookings';
JHTML::_('behavior.tooltip');
//print_r($this->Order);
$user =& JFactory::getUser();

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
		<table class="admintable">
		
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Order id' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->id_order;?>
			</td>
		</tr> 
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Product Name' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->name_property;?>
			</td>
		</tr> 
        
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'User Name' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->id;?> : (<?php echo $this->Order->username;?>) : <?php echo $this->Order->name;?> : <?php echo $this->Order->email;?>
			</td>
		</tr>  
           
           <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Form Mail' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->ob_mail;?>
			</td>
		</tr>  
        
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'From' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->date_from;?>
			</td>
		</tr> 
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'To' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->date_to;?>
			</td>
		</tr>  
          
        
        
        <tr>    
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Confirmed' ); ?>:
						</label>
					</td>
                    					<td>
<?php $chequeado0 = $this->Order->confirmed ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->Order->confirmed ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="confirmed" id="confirmed0" value="0" <?php echo $chequeado0;?> type="radio">
	<label for="published0"><?php echo JText::_( 'No' ); ?></label>
	<input name="confirmed" id="confirmed1" value="1" <?php echo $chequeado1;?> type="radio">
	<label for="published1"><?php echo JText::_( 'Yes' ); ?></label>  
					</td>
				</tr>       
                
                
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Date Confirmed' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->confirmed_date;?>
			</td>
		</tr>
        
        
        
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Confirmed by' ); ?>:
						</label>
			</td>
			<td>
				<?php echo $this->Order->confirmed_by;?>
			</td>
		</tr>
        
        
             
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<?php
$datenow =& JFactory::getDate();
?>
<input type="hidden" name="confirmed_date" value="<?php echo $datenow->toFormat("%Y-%m-%d"); ?>" />
<input type="hidden" name="confirmed_by" value="<?php echo $user->id; ?>" />
<input type="hidden" name="option" value="com_properties" />
<input type="hidden" name="view" value="bookings" />
<input type="hidden" name="table" value="order_bookings" />
<input type="hidden" name="id_order" value="<?php echo $this->Order->id_order; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="bookings" />
</form>
<?php
     
    
	

?>