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
defined('_JEXEC') or die( 'Restricted access' );

class JElementProperty extends JElement
{

	var	$_name = 'Property';
	var	$property_name = null;

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe;
		if($value)
			{
		$db			=& JFactory::getDBO();
		$query = ' SELECT p.name'
				. ' FROM #__properties_products AS p '
				. ' WHERE p.id = '.$value;
		$db->setQuery($query); 
		$property_name = $db->loadResult();
		
		}
		
		$doc 		=& JFactory::getDocument();
		$template 	= $mainframe->getTemplate();
		$fieldName	= $control_name.'['.$name.']';
		
		if ($value) {
			$article->title = $property_name;
		} else {
			$article->title = JText::_('Select Property');
		}

		$js = "
		function jSelectProperty(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
		}";
		$doc->addScriptDeclaration($js);

		$link = 'index.php?option=com_properties&amp;view=products&amp;layout=modal&amp;tmpl=component&amp;object='.$name;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$name.'_name" value="'.htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
//		$html .= "\n &nbsp; <input class=\"inputbox modal-button\" type=\"button\" value=\"".JText::_('Select')."\" />";
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('Select an Article').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 750, y: 475}}">'.JText::_('Select').'</a></div></div>'."\n";
		$html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.(int)$value.'" />';

		return $html;
	}
}