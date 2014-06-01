<?php
/**
* @version		$Id: article.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementMultilocalities extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Locality';
	var $locality_name =  null;

	function fetchElement($name, $value, &$node, $control_name)
	{
		global $mainframe;
		
		if($value)
			{
		$db			=& JFactory::getDBO();
		
		$query = ' SELECT l.name'
				. ' FROM #__properties_locality AS l '
				. ' WHERE l.id IN ('.$value.')';
		$db->setQuery($query); 
		$locality_name = $db->loadResult();
		}
		
		
		$doc 		=& JFactory::getDocument();
		$template 	= $mainframe->getTemplate();
		$fieldName	= $control_name.'['.$name.']';

		if ($value) {
			$article->title = $value;
		} else {
			$article->title = JText::_('Select an Localities');
		}

		$js = "
		function jSelectLocality(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
		}";
		$doc->addScriptDeclaration($js);

		$link = 'index.php?option=com_properties&amp;view=localities&amp;layout=multimodal&amp;tmpl=component&amp;object='.$name.'&amp;value='.$value;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$name.'_name" value="'.htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
//		$html .= "\n &nbsp; <input class=\"inputbox modal-button\" type=\"button\" value=\"".JText::_('Select')."\" />";
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('Select an Locality').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 750, y: 475}}">'.JText::_('Select').'</a></div></div>'."\n";
		$html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.$value.'" />';

		return $html;
	}
}
