<?php defined('_JEXEC') or die('Restricted access'); 
JHTML::_('behavior.tooltip');
JHTML::_('behavior.formvalidation');
$document =& JFactory::getDocument();
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$ActivarContactar=$params->get('ActivarContactar');
?>
<style type="text/css">
<!--
.invalid {
font-weight:bold;
color: red;
}
-->
</style>




<div style="width:100%; background:#E6E6C6; text-align:center;">
<div>
<br /><br />
<p style="font-size:18px;">
<?php echo ' '.JRequest::getVar('msg');?>
 </p>
<br /><br />
<?php

?>
<a href="#" onclick="window.close()"><?php echo JText::_('Close Window'); ?></a><br /><br />
<?php

?>
</div>
</div>






