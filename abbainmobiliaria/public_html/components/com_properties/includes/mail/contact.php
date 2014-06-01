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

$data = '
<table cellpadding="5" cellspacing="5">	
	<tr>
		<td class="field">'.JText::_( 'Producto').'</td><td class="field_send">'.$product->ref.' [ <a href="'.$product->link.'" target="_blank">'.$product->name.'</a> ]</td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Name').'</td><td class="field_send">'.$post['name'].'</td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Email').'</td><td class="field_send">'.$post['email'].'</td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Phone').'</td><td class="field_send">'.$post['phone'].'</td>		
	</tr>
	';

$data .= '		
	<tr>
		<td class="field">'.JText::_( 'Message').'</td><td class="field_send">'.$post['text'].'</td>		
	</tr>
</table>';
$body =	$data;

$agentData='
<table cellpadding="5" cellspacing="5">	
	<tr>
		<td class="field">'.JText::_( 'Agent Data').'</td><td class="field_send"></td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Name').'</td><td class="field_send">'.$agent->name.'</td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Email').'</td><td class="field_send">'.$agent->email.'</td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Phone').'</td><td class="field_send">'.$agent->phone.'</td>		
	</tr>
	<tr>
		<td class="field">'.JText::_( 'Mobile').'</td><td class="field_send">'.$agent->mobile.'</td>		
	</tr>
</table>';
?>
