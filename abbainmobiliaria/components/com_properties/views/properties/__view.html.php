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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view' );
class PropertiesViewProperties extends JView
{	
	function display($tpl = null)
	{	
	
	global $mainframe;
	$this->lang =& JFactory::getLanguage();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$ThumbsInAccordion=$params->get('ThumbsInAccordion',5);
	$useTranslations=$params->get('useTranslations','0');
	$Listlayout=$params->get('Listlayout');
	$items		= & $this->get( 'Data');
	$pagination =& $this->get('Pagination');

	if($Listlayout=='dafault')
	{
	$ThumbsInAccordion=1;
	}
	
	$this->assignRef('pagination', $pagination);
	$layout = JRequest::getVar('layout');
	
	if($useTranslations)
		{
		require_once( JPATH_COMPONENT.DS.'helpers'.DS.'translation.php' );			
		}
		
	for ($i=0, $n=count( $items ); $i < $n; $i++)	
    	{
		$row = $items[$i];
		
		if($useTranslations)
		{		
		
		$translation = TranslationHelper::getTranslations($row);
			
		if($translation['country'])
			{
			$items[$i]->name_country=$translation['country'];			
			}
		if($translation['state'])
			{
			$items[$i]->name_state=$translation['state'];			
			}	
		if($translation['locality'])
			{
			$items[$i]->name_locality=$translation['locality'];			
			}	
		if($translation['category'])
			{
			$items[$i]->name_category=$translation['category'];			
			}	
		if($translation['type'])
			{
			$items[$i]->name_type=$translation['type'];			
			}	
		$productTranslation = TranslationHelper::getProductTranslations($row);
			
		if($productTranslation->pt_name)
			{
			$items[$i]->name=$productTranslation->pt_name;			
			}			
		if($productTranslation->pt_alias)
			{
			$items[$i]->alias=$productTranslation->pt_alias;			
			}			
		if($productTranslation->pt_address)
			{
			$items[$i]->address=$productTranslation->pt_address;			
			}	
			
			if($Listlayout=='slide')
				{				
				if($productTranslation->pt_description)
					{
					$items[$i]->description=$productTranslation->pt_description;			
					}
				if($productTranslation->pt_text)
					{
					$items[$i]->text=$productTranslation->pt_text;			
					}	
				if($productTranslation->pt_metatitle)
					{
					$items[$i]->metatitle=$productTranslation->pt_metatitle;			
					}	
				if($productTranslation->pt_metadesc)
					{
					$items[$i]->metadesc=$productTranslation->pt_metadesc;			
					}	
				if($productTranslation->pt_metakey)
					{
					$items[$i]->metakey=$productTranslation->pt_metakey;			
					}					
				}
		}	
	
		$this->Images[$row->id]		=$this->getImages($row->id,$ThumbsInAccordion);			
		}		
		$this->assignRef('items',		$items);
		
		
		
		
		
		
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/'.$Listlayout.'_list_'.$this->lang->getTag().'.css" type="text/css" />');
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/'.$Listlayout.'_list.css" type="text/css" />');

if($Listlayout=='slide')
	{	
$mainframe->addCustomHeadTag('<script type="text/javascript">
window.addEvent(\'domready\', function() {
var myToggler = $$(\'div.arrow_drop\');
	var myAccordion = new Accordion($(\'accordion\'), \'div.toggler\', \'div.element\', {			  
		display: 100,
    alwaysHide: true,	
	onActive: function(myToggler){
						myToggler.removeClass(\'arrowImageRight\').addClass(\'arrowImageDown\');
						myToggler.innerHTML = \''.JText::_('BUTTON_CLOSE').'\';
					},
				onBackground: function(myToggler){
						myToggler.removeClass(\'arrowImageDown\').addClass(\'arrowImageRight\');
						myToggler.innerHTML = \''.JText::_('BUTTON_OPEN').'\';
					}
	});	
});
</script>');
	}
		
		
		$ShowImagesSystem=$params->get('ShowImagesSystem');
		$ShowImagesSystemDetail=$params->get('ShowImagesSystemDetail');

		if($ShowImagesSystemDetail == 1){

		}

		if($ShowImagesSystemDetail == 2){
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/colorbox/colorbox.css" type="text/css" media="screen"  />');
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/colorbox/colorbox-custom.css" type="text/css" media="screen" />');     
/*
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_portafolio/includes/colorbox/colorbox-custom-ie.css" type="text/css" />');
	*/		
/*
$mainframe->addCustomHeadTag('<script type="text/javascript" src="http://www.google.com/jsapi"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript">google.load("jquery", "1.3.2");</script>');
*/
		$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/colorbox/jquery-1.3.2.js"></script>');
		$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/colorbox/jquery.colorbox.js"></script>');        
        
		$mainframe->addCustomHeadTag('
<script type="text/javascript">	
	jQuery.noConflict();
			document.write("<style type=\'text/css\'>.hidden{display:none;}<\/style>");			
			jQuery(document).ready(function(){
			
				//Examples of Global Changes
				jQuery.fn.colorbox.settings.bgOpacity = "0.9";

				//Examples of how to assign the ColorBox event to elements.
				jQuery("a[rel=\'jack\']").colorbox({transition:"fade"});
				jQuery("a[rel=\'dogs0\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs1\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs2\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs3\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs4\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs5\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs6\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs7\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs8\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs9\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				jQuery("a[rel=\'dogs10\']").colorbox({transition:"elastic", contentCurrent:"{current} / {total}"});
				
				jQuery("a[title=\'Contactar\']").colorbox();				
				jQuery("#imprimir").colorbox({});

			});
		</script>
');

		}

		if($ShowImagesSystemDetail == 3){
		$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/js/jquery.js"></script>');
		$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/prettyPhoto_30/js/jquery.prettyPhoto.js"></script>');
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/prettyPhoto_30/css/prettyPhoto.css" type="text/css" media="screen"  />');
		$mainframe->addCustomHeadTag('
<script type="text/javascript">	
	jQuery.noConflict();
		</script>
');	
		}		








			
		parent::display();			
	}
	

	
	function getImages($id,$total)
	{		
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT i.* '			
			. ' FROM #__properties_images as i '					
			. ' WHERE i.published = 1 AND i.parent = '.$id			
			. ' order by i.ordering LIMIT '.($total);		
        $db->setQuery($query);
		$Images = $db->loadObjectList();
	return $Images;
	}
	
}