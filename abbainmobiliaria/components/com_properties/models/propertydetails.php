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

jimport( 'joomla.application.component.model' );

class PropertiesModelPropertydetails extends JModel
{
	var $_id = null;	
	var $_data = null;
	
	function __construct()
	{
		parent::__construct();
		global $mainframe, $option;
		$id = JRequest::getVar('id');	
		$this->setId($id);		
	}
	
	function getProduct($params)
		{
		$productId = JRequest::getVar('id');
		$db 	=& JFactory::getDBO(); 

			$menu =& JSite::getMenu();
			$menuitem =& $menu->getActive();
			if(($menuitem->query['id']) != 0)
				{
				$and = ' AND p.id = '.$menuitem->query['id'];
				}elseif($productId){		
				$badchars = array('#','>','<','\\');
				$productId = trim(str_replace($badchars, '', $productId));
				$pId = $this->getId($productId);
				$and = ' AND p.id = '.$pId;
				}
	
		$query = ' SELECT p.*, c.cat_currency, c.name as name_category,cy.name as name_country,s.name as name_state,l.name as name_locality,pf.name as name_profile,pf.logo_image as logo_image_profile,t.name as name_type, '
		. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as Pslug,'
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as Cslug,'
		. ' CASE WHEN CHAR_LENGTH(t.alias) THEN CONCAT_WS(":", t.id, t.alias) ELSE t.id END as Tslug,'
		. ' CASE WHEN CHAR_LENGTH(cy.alias) THEN CONCAT_WS(":", cy.id, cy.alias) ELSE cy.id END as CYslug,'
		. ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as Sslug,'		
		. ' CASE WHEN CHAR_LENGTH(l.alias) THEN CONCAT_WS(":", l.id, l.alias) ELSE l.id END as Lslug '				
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_profiles AS pf ON pf.mid = p.agent_id '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
				. ' WHERE p.published = 1 '	
				. $and;
			$db->setQuery($query);        
			$Product = $db->loadObject();				
			//echo str_replace('#_','jos',$query);
			$this->AddHit($Product->hits);	
			return $Product;
		}
		
		
		
		function getId($id)
		{
		// Set weblink id and wipe data
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
		$db = JFactory::getDBO();	
		
			
		$config	= new JConfig();
		
		
		
		if($config->sef)
			{
			$id=str_replace(':','-',$id);
			if($useTranslations)
				{
				$query = 'SELECT p.id FROM #__properties_products as p '.		
				' LEFT JOIN #__properties_products_translations AS pt ON pt.pt_pid = p.id '.		
				' WHERE alias = '.$db->Quote($id).' OR pt_alias = '.$db->Quote($id)	
				;			
				$db->setQuery($query);
				$productid = $db->loadResult();					
				}else{
				$query = 'SELECT p.id FROM #__properties_products as p '.					
				' WHERE alias = '.$db->Quote($id)
				;			
				$db->setQuery($query);
				$productid = $db->loadResult();
				}
			}else{
			$productid = (int) $id;
			}	
			
		return $productid;		
		}
		
	function setMeta($Product)
		{	
			global $mainframe;	
			$app	= JFactory::getApplication();
			$document =& JFactory::getDocument();
			$document->setTitle($Product->metatitle);	
			$document->setMetadata('keywords',$Product->metakey);
			$metaDesc=strip_tags($Product->description);	
			$document->setDescription( $Product->metadesc);
		}
		
	function getRates($id)
		{	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT r.* '			
			. ' FROM #__properties_rates as r '					
			. ' WHERE r.published = 1 AND r.productid = '.$id			
			. ' order by r.ordering ';		
        $db->setQuery($query);
		$Rates = $db->loadObjectList();
		return $Rates;
		}
		
	function getMyAgent($aid)
		{	
			$user =& JFactory::getUser();
			$db 	=& JFactory::getDBO(); 
			$query = 'SELECT pf.* FROM #__properties_profiles as pf WHERE pf.show = 1 AND pf.mid = '.$aid;		
        	$db->setQuery($query);        
			$Agent = $db->loadObject();	
			return $Agent;			
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
		
	function getPdfs($id)
		{	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT r.* '			
			. ' FROM #__properties_pdfs as r '					
			. ' WHERE r.published = 1 AND r.parent = '.$id			
			. ' order by r.ordering ';		
        $db->setQuery($query);
		$Pdfs = $db->loadObjectList();
		return $Pdfs;
		}
	
	function getOpenHouse($id)
		{	
		$db 	=& JFactory::getDBO();	
		$query = ' SELECT oh.* '			
			. ' FROM #__properties_openhouse as oh '					
			. ' WHERE oh.published = 1 AND oh.pid = '.$id			
			. ' order by oh.ordering ';		
        $db->setQuery($query);
		$OpenHouse = $db->loadObject();
		return $OpenHouse;
		}
				
	function getItemTranslated($Product,$params)
		{
		require_once( JPATH_COMPONENT.DS.'helpers'.DS.'translation.php' );
		if($translation = TranslationHelper::getTranslations($Product))
		{
		
		if($translation['country'])
			{
			$Product->name_country=$translation['country'];			
			}
		if($translation['state'])
			{
			$Product->name_state=$translation['state'];			
			}	
		if($translation['locality'])
			{
			$Product->name_locality=$translation['locality'];			
			}	
		if($translation['category'])
			{
			$Product->name_category=$translation['category'];			
			}	
		if($translation['type'])
			{
			$Product->name_type=$translation['type'];			
			}		
		}
		if($productTranslation = TranslationHelper::getProductTranslations($Product))
		{
			
		if($productTranslation->pt_name)
			{
			$Product->name=$productTranslation->pt_name;			
			}
			
		if($productTranslation->pt_alias)
			{
			$Product->alias=$productTranslation->pt_alias;			
			}
			
		if($productTranslation->pt_address)
			{
			$Product->address=$productTranslation->pt_address;			
			}	
			
		if($productTranslation->pt_description)
			{
			$Product->description=$productTranslation->pt_description;			
			}
		if($productTranslation->pt_text)
			{
			$Product->text=$productTranslation->pt_text;			
			}	
		if($productTranslation->pt_metatitle)
			{
			$Product->metatitle=$productTranslation->pt_metatitle;			
			}	
		if($productTranslation->pt_metadesc)
			{
			$Product->metadesc=$productTranslation->pt_metadesc;			
			}	
		if($productTranslation->pt_metakey)
			{
			$Product->metakey=$productTranslation->pt_metakey;			
			}	
		}
				
		return $Product;
		
		}

		
		
	function setId($id)
	{

		// Set weblink id and wipe data
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
		$db = JFactory::getDBO();		
		$config	= new JConfig();
		if($config->sef)
		{
			if($useTranslations)
			{
			$query = 'SELECT p.id FROM #__properties_products as p '.		
			' LEFT JOIN #__properties_products_translations AS pt ON pt.pt_pid = p.id '.		
			' WHERE alias = '.$db->Quote($id).' OR pt_alias = '.$db->Quote($id)	
			;			
			$db->setQuery($query);
			$productid = $db->loadResult();					
			}else{
			$query = 'SELECT p.id FROM #__properties_products as p '.					
				' WHERE alias = '.$db->Quote($id)
				;			
				$db->setQuery($query);
				$productid = $db->loadResult();
			}
		}else{
		$productid = $id;
		}			
		
		$this->_id	= $productid;
		//echo $this->_id;
		//require('a');		
		$this->_data	= null;
	}



	function AddHit($hit)
		{
		$user =& JFactory::getUser();	
		if($user->id!=62)
			{	
		$query = 'UPDATE #__properties_products'
		. ' SET hits = ' . ($hit+1)
		. ' WHERE id = '. (int) $this->_id;			
			
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
			if (!$db->query())
				{
				JError::raiseError(500, $db->getErrorMsg() );
				}		
			}	
		
		}		
			
}//fin clase