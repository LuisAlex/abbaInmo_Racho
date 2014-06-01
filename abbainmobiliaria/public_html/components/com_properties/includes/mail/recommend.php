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
		<td class="field">'.JText::_( 'Producto').'</td><td class="field_send">'.$product->ref.' [ '.$product->name.' ]</td>		
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
?>
