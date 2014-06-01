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
global $mainframe;

JHTML::_('behavior.mootools');
JHTML::_('behavior.formvalidation');
	
JRequest::setVar('tmpl','component');
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/contactform.css" type="text/css" media="screen"  />');
$document =& JFactory::getDocument();
$this->lang =& JFactory::getLanguage();
$user =& JFactory::getUser();
$Product=$this->Product;
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );

$send = JRequest::getVar('send', 0, '', 'int');
if($send == 1){
?>
<link rel="stylesheet" href="<?php echo JURI::base();?>templates/system/css/system.css" type="text/css" />
<?php
}else{
?>

<style type="text/css">
<!--
.invalid {
font-weight:bold;
color: red;
}
-->
</style>




<div style="padding:10px;" >
<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Formulario de Contacto' ); ?></legend>
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" id="josForm2" name="josForm2" class="form-validate">
<input type="hidden" name="popup" value="" />

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="100%" colspan="2">
	
		</td>
	</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="top"> 
  		<td height="20" class="texto">&nbsp;</td>
  		<td class="texto">&nbsp; </td>
	</tr> 
                            
	<tr>
		<td width="30%" height="40">
		<label id="namemsg" for="name"><?php echo JText::_( 'Name' ); ?>: </label>
		</td>
  		<td><input type="text" name="name" id="name" size="40" value="<?php echo $user->name;?>" class="inputbox required" maxlength="50" /></td>
	</tr>


	<tr>
		<td height="40">
		<label id="emailmsg" for="email"><?php echo JText::_( 'Email' ); ?>: </label>
		</td>
		<td><input type="text" id="email" name="email" size="40" value="<?php echo $user->email;?>" class="inputbox required validate-email" maxlength="100" /></td>
	</tr>


	<tr>
		<td width="30%" height="40">
		<label id="namemsg" for="phone"><?php echo JText::_( 'Phone' ); ?>: </label>
		</td>
 	 	<td><input type="text" name="phone" id="phone" size="40" value="<?php //echo $this->user->get( 'name' );?>" class="inputbox required" maxlength="50" /></td>
	</tr>



	<tr>
		<td height="40">
		<label id="textmsg" for="text">
			<?php echo JText::_( 'Message' ); ?>:
		</label>
		</td>
		<td>
 	   <textarea name="text" id="text" cols="40" rows="3"></textarea>
		</td>
	</tr>
	 
    
    
    
    
    
    
<tr>
	<td colspan="2">

<?php $dispatcher = &JDispatcher::getInstance();
			//JPluginHelper::importPlugin('system');
			$results = $dispatcher->trigger( 'onCaptchaRequired', array( 'user.contact' ) );
			if ($results[0]){?>		
<table>
<tr><td align="center" colspan="2">
<span><?php echo JText::_( 'CAPTCHACODE_FORM_TITLE' ) ?></span>	
</td>
<td colspan="2"></td>
</tr>
<tr>
<?php 	
			
				$dispatcher->trigger( 'onCaptchaView', array( 'user.contact', 0, '', '' ) ); 
?>
<td width="20px">
<div id="ValidateCaptcha" style="float:left;"></div>
</td>
<td>
<div style="float:right">      
<a style="cursor:pointer;" onclick="ValidateCaptcha(document.getElementById('captchacode1').value,document.getElementById('captchasuffix').value,document.getElementById('captchasessionid').value)"><?php echo JText::_('Test Code'); ?></a>
</div> 
</td>
</tr>
<tr>
    <td colspan="3"><div id="progressvc" style="float:left;"></div> </td>
  </tr>
</table>	
<?php } ?>
</td>
</tr>         
</table>
<div align="center" style="margin-bottom:20px;">
 
	<button class="button validate" type="submit"><?php echo JText::_('Send'); ?></button>
  
    </div>
    <input type="hidden" name="option" value="com_properties" />    
    <input type="hidden" name="controller" value="contact" />
	<input type="hidden" name="task" value="send_contact" />
    <input type="hidden" name="product_id" value="<?php echo $Product->id;?>" />   
    <input type="hidden" name="agent_id" value="<?php echo JRequest::getVar('aid');?>" />
    
    <?php 	
	$u =& JFactory::getURI();
	/*echo '<pre>';
	print_r($u);
	echo '</pre>';	
	echo $u->_uri;require('a');	*/
	?>    
    <input type="hidden" name="return" value="<?php echo $u->_uri;?>" />
    
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>


<?php if(JText::_('FIELDAREREQUIRED')!='FIELDAREREQUIRED'){echo JText::_('FIELDAREREQUIRED');} ?>
<?php if(JText::_('SENDMAILTO')!='SENDMAILTO'){echo JText::_('SENDMAILTO');} ?>
<?php if(JText::_('OURPHONE')!='OURPHONE'){echo JText::_('OURPHONE');} ?>

</fieldset>
</div>


<?php	}?>  
