<?php defined('_JEXEC') or die('Restricted access'); 
global $mainframe;
JHTML::_('behavior.tooltip');
JHTML::_('behavior.formvalidation');
$document =& JFactory::getDocument();
JRequest::setVar('tmpl','component');
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/recommendform.css" type="text/css" media="screen"  />');

$params=$this->params;
$Product=$this->Product;

$id = $Product->id;



$send = JRequest::getVar('send', 0, '', 'int');
if($send == 1){
?>
<link rel="stylesheet" href="<?php echo JURI::base();?>templates/system/css/system.css" type="text/css" />
<br /><br />
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

<div id="recommend">

<?php
	if(isset($this->message)){
		$this->display('message');
	}
?>
<div style="padding:10px;" >
<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Recommend this Property' ); ?></legend>
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">
<input type="hidden" name="subject" value="<?php echo JRequest::getVar('id'); ?>" />

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
	<td width="30%" height="40">
		<label id="namemsg" for="name"><?php echo JText::_( 'Your Name' ); ?>: </label>
	</td>
  	<td>
    <input type="text" name="name" id="name" size="40" value="" class="inputbox required" maxlength="50" />
    </td>
</tr>

<tr>
	<td height="40">
		<label id="emailmsg" for="emailFrom"><?php echo JText::_( 'Your Mail' ); ?>: </label>
	</td>
	<td>
    <input type="text" id="emailFrom" name="emailFrom" size="40" value="" class="inputbox required validate-email" maxlength="100" />
    </td>
</tr>



<tr>
	<td height="40">
		<label id="emailmsg" for="emailTo"><?php echo JText::_( 'To Mail' ); ?>: </label>
	</td>
	<td>
    <input type="text" id="emailTo" name="emailTo" size="40" value="" class="inputbox required validate-email" maxlength="100" />
    </td>
</tr>

<tr>
	<td height="40">
		<label id="emailmsg" for="text">
			<?php echo JText::_( 'Message' ); ?>:
		</label>
	</td>
	<td>
<textarea name="message" id="message" rows="4" cols="30" class="inputbox required"></textarea>
	</td>
</tr>
           
</table>
  <div align="center" style="margin-bottom:20px;">
	<button class="button validate" type="submit"><?php echo JText::_('Send'); ?></button>
    </div>
	
	<?php 	
	$u =& JFactory::getURI();
	?>    
    <input type="hidden" name="return" value="<?php echo $u->_uri;?>" />
    <input type="hidden" name="url" value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>" />
    <input type="hidden" name="option" value="com_properties" />
    <input type="hidden" name="controller" value="recommend" />
	<input type="hidden" name="task" value="send_recommend" />
    <input type="hidden" name="id" value="<?php echo $this->Product->id;?>" />
    <input type="hidden" name="agent_id" value="<?php echo $this->Product->agent_id;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</fieldset>
</div>

<?php } ?>

