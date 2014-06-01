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
class TranslationHelper
{	
	function getTranslations($Product)
	{		
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
	
		$db 	=& JFactory::getDBO();	
			
			$query = ' SELECT t.t_value,t.t_table '			
			. ' FROM #__properties_translations as t '					
			. ' WHERE t.published = 1 '
			. ' AND t.t_languagecode = \''.$thisLang.'\''
			. ' AND ((t.t_table = "country"	AND t_fieldid = '.$Product->cyid.' )'
			. ' OR (t.t_table = "state"	AND t_fieldid = '.$Product->sid.' )'
			. ' OR (t.t_table = "locality"	AND t_fieldid = '.$Product->lid.' )'
			. ' OR (t.t_table = "category"	AND t_fieldid = '.$Product->cid.' )'
			. ' OR (t.t_table = "type"	AND t_fieldid = '.$Product->type.'))'
			;				
							
        $db->setQuery($query);
		//echo str_replace('#_','jos',$query);			
		$Translations = $db->loadObjectList();
				
		$translation= array();
		if($Translations)
			{
			foreach($Translations as $t)
				{
				$translation[$t->t_table]=$t->t_value;
				}				
			}	
		return $translation;	
		/*
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT t.t_fieldid,t.t_value,t.t_table '			
			. ' FROM #__properties_translations as t '					
			. ' WHERE t.t_published = 1 '
			. ' AND t.t_languagecode = \''.$thisLang.'\''		
			;					
        $db->setQuery($query);
		$Translations = $db->loadObjectList();
		foreach($Translations as $t)
			{
			$translation[$t->t_table][$t->t_fieldid]=$t->t_value;
			}					
		return $translation;
		*/	
	}	
	
	function getProductTranslations($Product)
	{		
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();	
		$db 	=& JFactory::getDBO();				
			$query = ' SELECT pt.* '			
			. ' FROM #__properties_products_translations as pt '					
			. ' WHERE pt.pt_pid = '.$Product->id
			. ' AND pt_langcode = \''.$thisLang.'\''
			;				
							
        $db->setQuery($query);
		//echo str_replace('#_','jos',$query);
		$Translation = new JObject();
		$Translation = $db->loadObject();					
				
		return $Translation;	
	}	
}