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

class PropertiesModelProperty extends JModel
{
	var $_id = null;	
	var $_data = null;
	
	function __construct()
	{
		parent::__construct();
		global $mainframe, $option;

$id = JRequest::getVar('id');	
//echo $id;
//require('a');
$this->setId($id);
		
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
		
		
		$this->_id		= $productid;
		//echo $this->_id;
		//require('a');
		
		$this->_data	= null;
	}



function AddHit($hit){

$user =& JFactory::getUser();
//echo 'user: '.$user->id;
	
if($user->id!=62){	
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

function getProduct()
	{
	
if($this->_id){
$and = ' AND p.id = '.$this->_id;
}elseif($this->_ref){
$ref = JRequest::getVar('ref', 0, '', 'ALNUM');
$and = ' AND p.ref = \''.$ref.'\'';
}else{
$and = ' AND p.id = 0';
}
	
$query = ' SELECT p.*,c.name as name_category,cy.name as name_country,s.name as name_state,l.name as name_locality,pf.name as name_profile,pf.logo_image as logo_image_profile,t.name as name_type, '
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
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			//echo '$this->_id; '.$this->_data->id;
			//echo str_replace('#_','jos',$query);
$this->AddHit($this->_data->hits);	

//JRequest::setVar('id',$this->_data->id);

//echo $this->_data->hits;
		
			return $this->_data;
	}
	

		
	
			
}//fin clase