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
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
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
		alert( "Item must have a Name" );
	//}else if( document.getElementById('email').value == '' ){
 	//	alert( "Please add Email" );	 	
	}else{
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
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">

		<table class="admintable">
<tr><td valign="top">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
<table>   
         <tr>
					<td  class="key"><label for="name"><?php echo JText::_( 'User' ); ?>:</label></td>
					<td>
                    <div style="float:left;">
						 <?php echo SelectHelper::SelectJoomlaUser( $this->profile); ?>
                        </div>                         
					<div style="float:left; margin-left:10px; " id="AjaxCliente">                   
                    </div><div id="progressR"></div>  </td>
				</tr>  
        <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="name" id="name" size="20" maxlength="255" value="<?php echo $this->profile->name; ?>" />
					</td>
				</tr>                
                			<tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Alias' ); ?>:
						</label>
			</td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="60" maxlength="250" value="<?php echo $this->profile->alias;?>" />
			</td>
		</tr>                
             
                
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Company' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="company" id="company" size="20" maxlength="255" value="<?php echo $this->profile->company; ?>" />
					</td>
				</tr>                
             	<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Reference' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="info" id="info" size="20" maxlength="255" value="<?php echo $this->profile->info; ?>" />
					</td>
				</tr>                
            	<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address 1' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="address1" id="address1" size="20" maxlength="255" value="<?php echo $this->profile->address1; ?>" />
					</td>
				</tr>    
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address 2' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="address2" id="address2" size="20" maxlength="255" value="<?php echo $this->profile->address2; ?>" />
					</td>
				</tr>
              	<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Locality' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="locality" id="locality" size="20" maxlength="255" value="<?php echo $this->profile->locality; ?>" />
					</td>
				</tr>
              	<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Post Code' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="pcode" id="pcode" size="20" maxlength="255" value="<?php echo $this->profile->pcode; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'State' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="state" id="state" size="20" maxlength="255" value="<?php echo $this->profile->state; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Country' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="country" id="country" size="20" maxlength="255" value="<?php echo $this->profile->country; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Mail' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="email" id="email" size="20" maxlength="255" value="<?php echo $this->profile->email; ?>" />
					</td>
				</tr>               
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Phone' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="phone" id="phone" size="20" maxlength="255" value="<?php echo $this->profile->phone; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Fax' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="fax" id="fax" size="20" maxlength="255" value="<?php echo $this->profile->fax; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Mobile' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="mobile" id="mobile" size="20" maxlength="255" value="<?php echo $this->profile->mobile; ?>" />
					</td>
				</tr>             
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'show' ); ?>:
						</label>
					</td>
					<td >
                    <?php $chequeado0 = $this->profile->show ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->profile->show ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="show" id="show0" value="0" <?php echo $chequeado0;?> type="radio">
	<label for="show0"><?php echo JText::_( 'No' ); ?></label>
	<input name="show" id="show1" value="1" <?php echo $chequeado1;?> type="radio">
	<label for="show1"><?php echo JText::_( 'Yes' ); ?></label>						
					</td>
				</tr>   
        		<tr>    
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Published' ); ?>:
						</label>
					</td>
                    <td>
<?php $chequeado0 = $this->profile->published ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->profile->published ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
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
						<input class="text_area" type="text" name="ordering" id="ordering" size="20" maxlength="255" value="<?php echo $this->profile->ordering; ?>" />
					</td>
				</tr>            
	</table>
	</fieldset>
  </td>
  <td valign="top"> 
   <fieldset class="adminform">
   	<legend><?php echo JText::_( 'Images' ); ?></legend>  
    
<?php
                    $profile_path = $mainframe->getSiteURL().'images/properties/profiles/';
                    ?>   
		<table>  	         
                <tr>
                    <td class="key"><label>
								<?php echo JText::_( 'Agent Image' ); ?>:
							</label></td>
                    <td>                    
                     <?php if($this->profile->image) {?>
                    <img src="<?php echo $profile_path.$this->profile->image; ?>" /><br />
                   
                     <input type="checkbox" name="deleteimage[image]" value="<?php echo $this->profile->image; ?>" />
                     <?php echo JText::_('Select to delete this image');}?>
                     
                </tr>				
                <tr>
                    <td class="key"><label><br />  Max. 140x200</label>
                             
                    </td>
                    <td>
                    <input class="input_box" id="image" name="image" type="file" />
                    </td>              
                </tr>
				<tr>                
                    <td class="key"><label>
								<?php echo JText::_( 'Agent Logo Image' ); ?>:
                              
							</label></td>
                    <td>
                    <?php if($this->profile->logo_image) {?>
                    <img src="<?php echo $profile_path.$this->profile->logo_image; ?>" /><br />                    
                    <input type="checkbox" name="deleteimage[logo_image]" value="<?php echo $this->profile->logo_image; ?>" />
                    <?php echo JText::_('Select to delete this image');}?>
                    </td>
                </tr>				
                <tr>
                    <td class="key"><label><br />  Max. 140x45</label></td>
                    <td>
                    <input class="input_box" id="logo_image" name="logo_image" type="file" />
                    </td>              
                </tr>
				<tr>
                
                                <tr>
                    <td class="key"><label>
								<?php echo JText::_( 'Agent Banner Image' ); ?>:
							</label></td>
                    <td>
                   
                    <?php if($this->profile->logo_image_large) {?>
                    <img src="<?php echo $profile_path.$this->profile->logo_image_large; ?>" /><br />                    
                     <input type="checkbox" name="deleteimage[logo_image_large]" value="<?php echo $this->profile->logo_image_large; ?>" />
                     <?php echo JText::_('Select to delete this image');}?>
                     
                    </td>
                </tr>				
                <tr>
                    <td class="key"><label><br />  Max. 500x160</label>
                             </td>
                    <td>
                    <input class="input_box" id="logo_image_large" name="logo_image_large" type="file" />
                    </td>              
                </tr>
           
	</table> 
    </fieldset>
       
 </td>
				</tr>            
	</table>       
       
        
</div>

<div class="clr"></div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->profile->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="profiles" />
</form>
	</td>
		</tr>
			</table> 