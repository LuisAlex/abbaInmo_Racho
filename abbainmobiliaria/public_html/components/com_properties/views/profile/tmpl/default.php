<?php defined('_JEXEC') or die('Restricted access'); 
$TableName = JRequest::getVar('table');
$option = JRequest::getCmd('option');
JHTML::_('behavior.tooltip');
$user =& JFactory::getUser();
global $mainframe;
?>

<form action="<?php echo JRoute::_('index.php?option=com_properties&view=profile&Itemid='.LinkHelper::getItemid('profile'))?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<div class="titulo" style="float:left"><H3><?php echo JText::_('My Profile'); ?></H3></div>


<div class="toolbar" id="toolbar">
<table class="toolbar"><tbody><tr>
<td class="button" id="toolbar-apply">
<button type="button" onclick="javascript: submitbutton('apply')">
<span class="icon-32-apply" title="<?php echo JText::_('Apply');?>">
</span>
<?php echo JText::_('Apply');?>
</button>
</td>
</tr></tbody></table>
</div>

<div style="clear:both"></div>

<div class="profileform">

<table class="admintable" width="100%">
	<tr>
    	<td valign="top">
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table>   
         <tr>
					<td  class="key"><label for="name"><?php echo JText::_( 'Client' ); ?>:</label></td>
					<td>
                   <?php echo  $user->name; ?>  </td>
				</tr>  
        <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="name" id="name"  maxlength="255" value="<?php echo $this->datos->name; ?>" />
					</td>
				</tr>               
                
             <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Reference' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="info" id="info"  maxlength="255" value="<?php echo $this->datos->info; ?>" />
					</td>
				</tr>    
                
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Company' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="company" id="company"  maxlength="255" value="<?php echo $this->datos->company; ?>" />
					</td>
				</tr> 
                
             <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address' ).' 1'; ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="address1" id="address1"  maxlength="255" value="<?php echo $this->datos->address1; ?>" />
					</td>
				</tr>    
                             <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Address' ).' 2'; ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="address2" id="address2"  maxlength="255" value="<?php echo $this->datos->address2; ?>" />
					</td>
				</tr>
              <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Locality' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="locality" id="locality"  maxlength="255" value="<?php echo $this->datos->locality; ?>" />
					</td>
				</tr>   
                
              <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Post Code' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="pcode" id="pcode"  maxlength="255" value="<?php echo $this->datos->pcode; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'State' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="state" id="state"  maxlength="255" value="<?php echo $this->datos->state; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Country' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="country" id="country"  maxlength="255" value="<?php echo $this->datos->country; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Mail' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="email" id="email"  maxlength="255" value="<?php echo $this->datos->email; ?>" />
					</td>
				</tr>   
               
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Phone' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="phone" id="phone"  maxlength="255" value="<?php echo $this->datos->phone; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Fax' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="fax" id="fax"  maxlength="255" value="<?php echo $this->datos->fax; ?>" />
					</td>
				</tr>   
                <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Mobile' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="mobile" id="mobile"  maxlength="255" value="<?php echo $this->datos->mobile; ?>" />
					</td>
				</tr> 
	</table>
	</fieldset>
  </td>
  <td valign="top"> 
   <fieldset class="adminform">
   	<legend><?php echo JText::_( 'Images' ); ?></legend>  
    
<?php
                    $profile_path = JURI::base().'images/properties/profiles/';
                    ?>   
		<table>  	         
                <tr>
                    <td class="key"><label><?php echo JText::_( 'Image' ); ?>:</label></td>
                    <td>                    
                    <img src="<?php echo $profile_path.$this->datos->image; ?>" /><br />
                      <?php if($this->datos->image) {?>
                    <input type="checkbox" name="deleteimage[image]" value="<?php echo $this->datos->image; ?>" />
                     <?php echo JText::_('Select to delete this image');}?>
                     </td>
                </tr>				
                <tr>
                    <td class="key"><label><?php echo JText::_( 'Change Image' ); ?>:</label>
                    	<br />  Max. 140x200 
                    </td>
                    <td>
                    <input class="input_box" id="image" name="image" type="file" />
                    </td>              
                </tr>
				             
               <tr>
                    <td class="key"><label><?php echo JText::_( 'Logo Image' ); ?>:</label></td>
                    <td>                    
                    <img src="<?php echo $profile_path.$this->datos->logo_image; ?>" /><br />
                    <?php if($this->datos->logo_image) {?>
                    <input type="checkbox" name="deleteimage[logo_image]" value="<?php echo $this->datos->logo_image; ?>" />
                    <?php echo JText::_('Select to delete this image');}?>
                    </td>
                </tr>				
                <tr>
                    <td class="key"><label><?php echo JText::_( 'Change Logo Image' ); ?>:
                          <br />  Max. 140x45</label>
                    </td>
                    <td>
                    <input class="input_box" id="logo_image" name="logo_image" type="file" />
                    </td>              
                </tr>
				<tr>
                    <td colspan="2">                    
                    <img src="<?php echo $profile_path.$this->datos->logo_image_large; ?>" width="400" /><br />
                    <?php if($this->datos->logo_image_large) {?>
                    <input type="checkbox" name="deleteimage[logo_image_large]" value="<?php echo $this->datos->logo_image_large; ?>" />
                     <?php echo JText::_('Select to delete this image');	}?>
                     </td>
                </tr>				
                <tr>
                    <td class="key"><label><?php echo JText::_( 'Change Logo Image Large' ); ?>:</label>
                             <br />  Max. 500x160
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

<div style="clear:both;"></div>
<input type="hidden" name="option" value="com_properties" />
<input type="hidden" name="id" value="<?php echo $this->datos->id; ?>" />
<input type="hidden" name="task" id="task" value="ProfileApply" />
<input type="hidden" name="controller" value="profile" />
<input type="hidden" id="mid" name="mid" value="<?php echo $user->id; ?>" />
<input type="hidden" id="agent" name="agent" value="<?php echo $user->username; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
