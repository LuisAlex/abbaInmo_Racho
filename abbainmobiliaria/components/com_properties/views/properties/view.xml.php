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

jimport( 'joomla.application.component.view');

class PropertiesViewProperties extends JView
{
	function display($tpl = null)
	{	
		global $mainframe;
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');
		
		$db			=& JFactory::getDBO();

		$query = ' SELECT p.*,c.name as name_category,t.name as name_type,cy.name as name_country,s.name as name_state,l.name as name_locality,l.alias as locality_alias,pf.name as name_profile, '
		. ' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as Pslug,'
		. ' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as Cslug,'
		. ' CASE WHEN CHAR_LENGTH(cy.alias) THEN CONCAT_WS(":", cy.id, cy.alias) ELSE cy.id END as CYslug,'
		. ' CASE WHEN CHAR_LENGTH(s.alias) THEN CONCAT_WS(":", s.id, s.alias) ELSE s.id END as Sslug,'		
		. ' CASE WHEN CHAR_LENGTH(l.alias) THEN CONCAT_WS(":", l.id, l.alias) ELSE l.id END as Lslug, '	
		. ' CASE WHEN CHAR_LENGTH(t.alias) THEN CONCAT_WS(":", t.id, t.alias) ELSE t.id END as Tslug '			
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_profiles AS pf ON pf.mid = p.agent_id '				
				. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
				. ' WHERE p.published = 1 '			
				.' ORDER BY p.id asc '	
				;				
				$db->setQuery( $query );				
				$items = $db->loadObjectList();
				
				
				
				
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
			
				if($productTranslation->pt_description)
					{
					$items[$i]->description=$productTranslation->pt_description;			
					}
				if($productTranslation->pt_text)
					{
					$items[$i]->text=$productTranslation->pt_text;			
					}										
				
			}	
			
		}			
				
				
			$this->products = $items;	
				

	$document = &JFactory::getDocument();
	$document->setMimeEncoding('text/xml');		
	//header ("content-type: text/xml");

	switch(JRequest::getVar('feed'))
		{	
		case 'showmetext' :	
		$this->showmetext();
		break;
		default :
		$this->defaultFeed();
		break;
		}
	}
	
	
	function Images($id)
	{		
	$db 	=& JFactory::getDBO();	
	$query = ' SELECT i.* '			
			. ' FROM #__properties_images as i '					
			. ' WHERE i.published = 1 AND i.parent = '.$id			
			. ' order by i.ordering ASC LIMIT 10';		
        $db->setQuery($query);
		$Images = $db->loadObjectList();
	return $Images;
	}
		
	

	function defaultFeed()
	{
	
	 $db =& JFactory::getDBO();        
        $db->setQuery('SHOW COLUMNS FROM #__properties_products');
        $columns = $db->loadObjectList('Field');

	$crlf="\n";
	$line =  '<?xml version="1.0" encoding="utf-8"?>' . $crlf;	
	$line.='<properties total="'.count($this->products).'">'. $crlf;	

	foreach ( $this->products as $row  )
		{			
			$imageBaseUrl = JURI::root().'images/properties/images/';		
			$imageUrl = $imageBaseUrl.$row->id.'/';
			$images=$this->Images($row->id);
			$url = substr(JURI::base(), 0, -1);		
			
			$link = LinkHelper::getLinkProperty($row->id,$row->alias,'',$row->Cslug);
		
	$line .='	<property>'. $crlf;	
	if($row->id)
	{
	$line .='		<id>'.$row->id.'</id>' . $crlf;	
	}
if($row->name)
	{
	$line .='		<name>'.$row->name.'</name>' . $crlf;	
	}
if($row->alias)
	{
	$line .='		<alias>'.$row->alias.'</alias>' . $crlf;	
	}
if($row->parent)
	{
	$line .='		<parent>'.$row->parent.'</parent>' . $crlf;	
	}
if($row->agent_id)
	{
	$line .='		<agent_id>'.$row->agent_id.'</agent_id>' . $crlf;	
	}
if($row->agent)
	{
	$line .='		<agent>'.$row->agent.'</agent>' . $crlf;	
	}
if($row->ref)
	{
	$line .='		<ref>'.$row->ref.'</ref>' . $crlf;	
	}
if($row->type)
	{
	$line .='		<type>'.$row->type.'</type>' . $crlf;	
	}
if($row->cid)
	{
	$line .='		<cid>'.$row->cid.'</cid>' . $crlf;	
	}
if($row->lid)
	{
	$line .='		<lid>'.$row->lid.'</lid>' . $crlf;	
	}
if($row->sid)
	{
	$line .='		<sid>'.$row->sid.'</sid>' . $crlf;	
	}
if($row->cyid)
	{
	$line .='		<cyid>'.$row->cyid.'</cyid>' . $crlf;	
	}
if($row->postcode)
	{
	$line .='		<postcode>'.$row->postcode.'</postcode>' . $crlf;	
	}
if($row->address)
	{
	$line .='		<address>'.$row->address.'</address>' . $crlf;	
	}
if($row->description)
	{
	$line .='		<description><![CDATA['.strip_tags($row->description).']]></description>' . $crlf;	
	}
if($row->text)
	{
	$line .='		<text><![CDATA['.strip_tags($row->text).']]></text>' . $crlf;	
	}
if($row->price)
	{
	$line .='		<price>'.$row->price.'</price>' . $crlf;	
	}
if($row->published)
	{
	$line .='		<published>'.$row->published.'</published>' . $crlf;	
	}
if($row->use_booking)
	{
	$line .='		<use_booking>'.$row->use_booking.'</use_booking>' . $crlf;	
	}
if($row->ordering)
	{
	$line .='		<ordering>'.$row->ordering.'</ordering>' . $crlf;	
	}
if($row->panoramic)
	{
	$line .='		<panoramic>'.$row->panoramic.'</panoramic>' . $crlf;	
	}
if($row->video)
	{
	$line .='		<video>'.$row->video.'</video>' . $crlf;	
	}
if($row->lat)
	{
	$line .='		<lat>'.$row->lat.'</lat>' . $crlf;	
	}
if($row->lng)
	{
	$line .='		<lng>'.$row->lng.'</lng>' . $crlf;	
	}
if($row->available)
	{
	$line .='		<available>'.$row->available.'</available>' . $crlf;	
	}
if($row->featured)
	{
	$line .='		<featured>'.$row->featured.'</featured>' . $crlf;	
	}
if($row->years)
	{
	$line .='		<years>'.$row->years.'</years>' . $crlf;	
	}
if($row->capacity)
	{
	$line .='		<capacity>'.$row->capacity.'</capacity>' . $crlf;	
	}
if($row->bedrooms)
	{
	$line .='		<bedrooms>'.$row->bedrooms.'</bedrooms>' . $crlf;	
	}
if($row->bathrooms)
	{
	$line .='		<bathrooms>'.$row->bathrooms.'</bathrooms>' . $crlf;	
	}
if($row->garage)
	{
	$line .='		<garage>'.$row->garage.'</garage>' . $crlf;	
	}
if($row->area)
	{
	$line .='		<area>'.$row->area.'</area>' . $crlf;	
	}
if($row->covered_area)
	{
	$line .='		<covered_area>'.$row->covered_area.'</covered_area>' . $crlf;	
	}
if($row->hits)
	{
	$line .='		<hits>'.$row->hits.'</hits>' . $crlf;	
	}
if($row->listdate)
	{
	$line .='		<listdate>'.$row->listdate.'</listdate>' . $crlf;	
	}
if($row->refresh_time)
	{
	$line .='		<refresh_time>'.$row->refresh_time.'</refresh_time>' . $crlf;	
	}
if($row->checked_out)
	{
	$line .='		<checked_out>'.$row->checked_out.'</checked_out>' . $crlf;	
	}
if($row->checked_out_time)
	{
	$line .='		<checked_out_time>'.$row->checked_out_time.'</checked_out_time>' . $crlf;	
	}
if($row->language)
	{
	$line .='		<language>'.$row->language.'</language>' . $crlf;	
	}
if($row->access)
	{
	$line .='		<access>'.$row->access.'</access>' . $crlf;	
	}
if($row->params)
	{
	$line .='		<params>'.$row->params.'</params>' . $crlf;	
	}
if($row->metatitle)
	{
	$line .='		<metatitle>'.$row->metatitle.'</metatitle>' . $crlf;	
	}
if($row->metadesc)
	{
	$line .='		<metadesc>'.$row->metadesc.'</metadesc>' . $crlf;	
	}
if($row->metakey)
	{
	$line .='		<metakey>'.$row->metakey.'</metakey>' . $crlf;	
	}
if($row->layout)
	{
	$line .='		<layout>'.$row->layout.'</layout>' . $crlf;	
	}
if($row->extra1)
	{
	$line .='		<extra1>'.$row->extra1.'</extra1>' . $crlf;	
	}
if($row->extra2)
	{
	$line .='		<extra2>'.$row->extra2.'</extra2>' . $crlf;	
	}
if($row->extra3)
	{
	$line .='		<extra3>'.$row->extra3.'</extra3>' . $crlf;	
	}
if($row->extra4)
	{
	$line .='		<extra4>'.$row->extra4.'</extra4>' . $crlf;	
	}
if($row->extra5)
	{
	$line .='		<extra5>'.$row->extra5.'</extra5>' . $crlf;	
	}
if($row->extra6)
	{
	$line .='		<extra6>'.$row->extra6.'</extra6>' . $crlf;	
	}
if($row->extra7)
	{
	$line .='		<extra7>'.$row->extra7.'</extra7>' . $crlf;	
	}
if($row->extra8)
	{
	$line .='		<extra8>'.$row->extra8.'</extra8>' . $crlf;	
	}
if($row->extra9)
	{
	$line .='		<extra9>'.$row->extra9.'</extra9>' . $crlf;	
	}
if($row->extra10)
	{
	$line .='		<extra10>'.$row->extra10.'</extra10>' . $crlf;	
	}
if($row->extra11)
	{
	$line .='		<extra11>'.$row->extra11.'</extra11>' . $crlf;	
	}
if($row->extra12)
	{
	$line .='		<extra12>'.$row->extra12.'</extra12>' . $crlf;	
	}
if($row->extra13)
	{
	$line .='		<extra13>'.$row->extra13.'</extra13>' . $crlf;	
	}
if($row->extra14)
	{
	$line .='		<extra14>'.$row->extra14.'</extra14>' . $crlf;	
	}
if($row->extra15)
	{
	$line .='		<extra15>'.$row->extra15.'</extra15>' . $crlf;	
	}
if($row->extra16)
	{
	$line .='		<extra16>'.$row->extra16.'</extra16>' . $crlf;	
	}
if($row->extra17)
	{
	$line .='		<extra17>'.$row->extra17.'</extra17>' . $crlf;	
	}
if($row->extra18)
	{
	$line .='		<extra18>'.$row->extra18.'</extra18>' . $crlf;	
	}
if($row->extra19)
	{
	$line .='		<extra19>'.$row->extra19.'</extra19>' . $crlf;	
	}
if($row->extra20)
	{
	$line .='		<extra20>'.$row->extra20.'</extra20>' . $crlf;	
	}
if($row->extra21)
	{
	$line .='		<extra21>'.$row->extra21.'</extra21>' . $crlf;	
	}
if($row->extra22)
	{
	$line .='		<extra22>'.$row->extra22.'</extra22>' . $crlf;	
	}
if($row->extra23)
	{
	$line .='		<extra23>'.$row->extra23.'</extra23>' . $crlf;	
	}
if($row->extra24)
	{
	$line .='		<extra24>'.$row->extra24.'</extra24>' . $crlf;	
	}
if($row->extra25)
	{
	$line .='		<extra25>'.$row->extra25.'</extra25>' . $crlf;	
	}
if($row->extra26)
	{
	$line .='		<extra26>'.$row->extra26.'</extra26>' . $crlf;	
	}
if($row->extra27)
	{
	$line .='		<extra27>'.$row->extra27.'</extra27>' . $crlf;	
	}
if($row->extra28)
	{
	$line .='		<extra28>'.$row->extra28.'</extra28>' . $crlf;	
	}
if($row->extra29)
	{
	$line .='		<extra29>'.$row->extra29.'</extra29>' . $crlf;	
	}
if($row->extra30)
	{
	$line .='		<extra30>'.$row->extra30.'</extra30>' . $crlf;	
	}
if($row->extra31)
	{
	$line .='		<extra31>'.$row->extra31.'</extra31>' . $crlf;	
	}
if($row->extra32)
	{
	$line .='		<extra32>'.$row->extra32.'</extra32>' . $crlf;	
	}
if($row->extra33)
	{
	$line .='		<extra33>'.$row->extra33.'</extra33>' . $crlf;	
	}
if($row->extra34)
	{
	$line .='		<extra34>'.$row->extra34.'</extra34>' . $crlf;	
	}
if($row->extra35)
	{
	$line .='		<extra35>'.$row->extra35.'</extra35>' . $crlf;	
	}
if($row->extra36)
	{
	$line .='		<extra36>'.$row->extra36.'</extra36>' . $crlf;	
	}
if($row->extra37)
	{
	$line .='		<extra37>'.$row->extra37.'</extra37>' . $crlf;	
	}
if($row->extra38)
	{
	$line .='		<extra38>'.$row->extra38.'</extra38>' . $crlf;	
	}
if($row->extra39)
	{
	$line .='		<extra39>'.$row->extra39.'</extra39>' . $crlf;	
	}
if($row->extra40)
	{
	$line .='		<extra40>'.$row->extra40.'</extra40>' . $crlf;	
	}
	
	
	
	$line .='	<images>' . $crlf;		
	foreach($images as $img)
	{	
	$line .='		<image>' . $crlf;	
	$line .='			<url>'.$imageUrl.$img->name.'</url>' . $crlf;	
	$line .='		</image>' . $crlf;
	}			
	$line .='	</images>' . $crlf;	
	
	
	
	$line .='	</property>'. $crlf;
		}
	$line.='</properties>'. $crlf;	
echo $line;		
	//$this->generateXmlFile($line);
	}
	
	
	function showmetext()
	{
	$crlf="\n";
	$line =  '<?xml version="1.0" encoding="utf-8"?>' . $crlf;	
	$line.='<properties>'. $crlf;	
	$line .='<total>'.count($this->products).'</total>' . $crlf;	
		foreach ( $this->products as $row )
		{			
	$line .='	<property>'. $crlf;	
	$line .='		<id>'.$row->id.'</id>' . $crlf;	
	$line .='		<description><![CDATA['.strip_tags($row->text).']]></description>' . $crlf;		
	$line .='	</property>'. $crlf;
		}
	$line.='</properties>'. $crlf;	
echo $line;		
	//$this->generateXmlFile($line);
	
	}	
	
	function generateXmlFile($line)
		{
		jimport('joomla.filesystem.file');
		$saveAs=JPATH_SITE.DS.'XML'.DS.'kyerofeed.xml';
		JFile::write($saveAs,$line);	
		}
		
	
}
?>