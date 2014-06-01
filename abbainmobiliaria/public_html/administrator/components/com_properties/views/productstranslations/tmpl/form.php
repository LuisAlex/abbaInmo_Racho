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
JHTML::_('behavior.switcher');
JHTML::_('behavior.formvalidation');
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$UseCountry=$params->get('UseCountry');
?>
<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	if ( document.getElementById('pt_name').value == "") {
		alert( "Item must have a Title" );
	}				
 else {
		submitform( pressbutton );
	}
}
//-->
</script>

   
   <?php
		$contents = '';
		$tmplpath = dirname(__FILE__).DS.'tmpl';
		ob_start();
?>
   <div class="submenu-box">
	<div class="submenu-pad">
		<ul id="submenu" class="configuration">            
            <li><a id="data" class="active"><?php echo JText::_('Data'); ?></a></li>					
					<li><a id="description"><?php echo JText::_('Description'); ?></a></li>					    
		</ul>
		<div class="clr"></div>
	</div>
</div>
<div class="clr"></div>
   <?php
		$contents = ob_get_contents();
		ob_end_clean();

		// Set document data
		$document =& JFactory::getDocument();
		$document->setBuffer($contents, 'modules', 'submenu');
?>
   
 <div id="config-document">  
    
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<div class="col width-100 propertyform" style="width:100%;">

<div id="page-data" class="tab">
<div class="noshow">

	<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Data' ); ?></legend>
    <div style="width:50%; float:left">
			<table class="admintable" border="0" width="100%"> 
				<tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Reference' ); ?>:</label></td>
					<td>
						<?php echo $this->datos->ref; ?>
                    </td>                   
			      </tr>
                <tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Title' ); ?>:</label></td>
					<td>                        
                        <?php echo $this->datos->name;?>
                    
                    <br />
                    <input class="text_area" type="text" name="pt_name" id="pt_name" size="60" maxlength="255" value="<?php echo $this->datos->pt_name; ?>" />	
                     </td>           
				</tr>       
				<tr>
               		<td class="key"><?php echo JText::_( 'Address' ); ?>:</td>
                    <td>                        
                        <?php echo $this->datos->address;?>
                   
					<br />
						<input class="text_area" type="text" name="pt_address" id="pt_address" size="60" maxlength="255" value="<?php echo $this->datos->pt_address; ?>" />	
                     </td>
			      </tr>
               
				<?php
				if ($this->datos->id) {
					?>
					<tr>
						<td class="key">
							<label>
								<?php echo JText::_( 'ID' ); ?>:							</label>						</td>
						<td>
							<strong><?php echo $this->datos->id;?></strong>						</td>
					   
					</tr> 
					<?php
				}
				?>
     
		</table>
                
                
		</div>
		<div style="width:50%; float:left">
			<table class="admintable" width="100%" border="0">        
        		<tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Url Alias' ); ?>:</label></td>
                    <td>
                    <?php echo $this->datos->alias;?>
                    <br />
                    <input class="text_area" type="text" name="pt_alias" id="pt_alias" size="60" maxlength="250" value="<?php echo $this->datos->pt_alias;?>" />				
                    </td>                   
				</tr>
                <tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Meta Title' ); ?>:</label></td>
                    <td>
                    <?php echo $this->datos->metatitle;?>
                    <br />
                    <input class="text_area" type="text" name="pt_metatitle" id="pt_metatitle" size="60" maxlength="250" value="<?php echo $this->datos->pt_metatitle;?>" />					
                    </td>                   
				</tr>
				<tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Meta Description' ); ?>:</label></td>					<td>
                    <?php echo $this->datos->metadesc; ?>
                    <br />
                    <textarea class="text_area" name="pt_metadesc" id="pt_metadesc"><?php echo $this->datos->pt_metadesc; ?></textarea>						
                    </td>                   
				</tr>
                <tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Meta Keywords' ); ?>:</label></td>
                    <td>
                    <?php echo $this->datos->metakey; ?>
                    <br />
                    <textarea class="text_area" name="pt_metakey" id="pt_metakey"><?php echo $this->datos->pt_metakey; ?></textarea>						
                    </td>                   
				</tr>
			</table>
		</div>                  
                  
  </fieldset>  


</div><!--noshow-->    
</div><!--page-data-->          
        
            
<div id="page-description" class="tab">
<div class="noshow">

<fieldset class="adminform"> 
<legend><?php echo JText::_( 'Original Short Description' ); ?></legend>
<table class="adminform">
<tr>
<td>
<textarea name="nosave1" style="width:100%; height:100px;"><?php  echo $this->datos->description;?></textarea>
</td>
</tr>
</table>
</fieldset>

<fieldset class="adminform"> 
<legend><?php echo JText::_( 'Short Description' ); ?></legend>

<table class="adminform">
<tr><td><?php echo JText::_( 'Short Description' ); ?></td></tr>
<tr><td>
<?php
$editors = &JFactory::getEditor();		
echo $editors->display('pt_description', $this->datos->pt_description, '100%', '200', '60', '20');
?>
</td></tr>
</table>
</fieldset>


<fieldset class="adminform"> 
<legend><?php echo JText::_( 'Original Full Description' ); ?></legend>
<table class="adminform">
<tr>
<td>
<textarea name="nosave1" style="width:100%; height:100px;"><?php  echo $this->datos->text;?></textarea>
</td>
</tr>
</table>
</fieldset>



<fieldset class="adminform"> 
<legend><?php echo JText::_( 'Full Description' ); ?></legend>
<table class="adminform">
<tr><td><?php echo JText::_( 'Full Description' ); ?></td></tr>
<tr>
<td>
<?php
$editor = &JFactory::getEditor();		
echo $editor->display('pt_text', $this->datos->pt_text, '100%', '400', '60', '20');
?>
</td>
</tr>
</table>
</fieldset>
</div><!--noshow-->  
</div><!--page-description--> 

</div>
<div class="clr"></div>

        
<input type="hidden" name="pt_langcode" value="<?php echo $this->filter_translation_language; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->datos->id; ?>" />
<input type="hidden" name="pt_id" value="<?php echo $this->datos->pt_id; ?>" />
<input type="hidden" name="pt_pid" value="<?php echo $this->datos->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="productstranslations" />

<?php echo JHTML::_( 'form.token' ); ?>
</form>
     
</div><!-- id="config-document" -->
<div class="clr"></div>