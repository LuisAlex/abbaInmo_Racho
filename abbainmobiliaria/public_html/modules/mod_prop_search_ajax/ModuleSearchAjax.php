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
jimport('joomla.application.component.controller');

class PropertiesControllerModuleSearchAjax extends JController
{	
	function getAlias($table,$id)
		{
		$db 	=& JFactory::getDBO();
		$query = 'SELECT alias FROM #__properties_'.$table.' WHERE id = '.$id;		
        $db->setQuery($query);        
		$result = $db->loadResult();
		return $result;
		}
		
	function goSearchAjax()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );	
	$post = JRequest::get( 'post' );
	$component = JComponentHelper::getComponent( 'com_properties' );
	$paramsC = new JParameter( $component->params );			
	$SaveSearchResults		=	$paramsC->get('SaveSearchResults');
	
	
	$moduleSearchAjax = JModuleHelper::getModule( 'prop_search_ajax' );
	$params = new JParameter( $moduleSearchAjax->params );
	$showSelectCountry 	=	$params->get( 'showSelectCountry',1 ) ;
	$showSelectState 	=	$params->get( 'showSelectState',1 ) ;
	$showSelectLocality =	$params->get( 'showSelectLocality',1 ) ;
	$showSelectCategory 	=	$params->get( 'showSelectCategory',1 ) ;
	$showSelectType 	=	$params->get( 'showSelectType',1 ) ;
	$showSelectPrice =	$params->get( 'showSelectPrice',1 ) ;
	$showSelectBedrooms 	=	$params->get( 'showSelectBedrooms',1 ) ;
	$showSelectBathrooms 	=	$params->get( 'showSelectBathrooms',1 ) ;
	$showSelectParking =	$params->get( 'showSelectParking',1 ) ;	
	$ms_area 			=	$params->get( 'ms_area',0 ) ;
		
		if($showSelectCountry)
			{	
			$country = JRequest::getInt('cyid', 0, 'post');	
			}	
					
		if($showSelectState)
			{	
			$state = JRequest::getInt('sid', 0, 'post');
			}
			
		if($showSelectLocality)
			{		
			$locality = JRequest::getInt('lid', 0, 'post');
			}			
			
		if($showSelectCategory)
			{		
			$category = JRequest::getInt('cid', 0, 'post');
			}	
			
		if($showSelectType)
			{		
			$type = JRequest::getInt('tid', 0, 'post');
			}	
			
		if($showSelectBedrooms)
			{		
			$bedrooms = JRequest::getInt('bedrooms', 0, 'post');
			}	
			
		if($showSelectBathrooms)
			{		
			$bathrooms = JRequest::getInt('bathrooms', 0, 'post');
			}	
			
		if($showSelectParking)
			{		
			$parking = JRequest::getInt('parking', 0, 'post');
			}	
			
		if($showSelectPrice)
			{		
			$minprice = JRequest::getInt('minprice', 0, 'post');
			$maxprice = JRequest::getInt('maxprice', 0, 'post');
			}		
		
		if($ms_area)
			{
			$minarea = JRequest::getInt('minarea', 0, 'post');
			$maxarea = JRequest::getInt('maxarea', 0, 'post');
			}
			
		$config	= new JConfig();
		if($config->sef)
		{
		if($country)
			{
			$country = $country.'-'.$this->getAlias('country',$country);
			}		
		if($state)
			{
			$state = $state.'-'.$this->getAlias('state',$state);
			}		
		if($locality)
			{
			$locality = $locality.'-'.$this->getAlias('locality',$locality);
			}		
		if($category)
			{
			$category = $category.'-'.$this->getAlias('category',$category);
			}		
		if($type)
			{
			$type = $type.'-'.$this->getAlias('type',$type);
			}			
			
		if($bedrooms)
			{
			$bedrooms = JRequest::getInt('bedrooms', 0, 'post').'-bedrooms';
			}	
			
		if($bathrooms)
			{
			$bathrooms = JRequest::getInt('bathrooms', 0, 'post').'-bathrooms';
			}
			
		if($parking)
			{
			$parking = JRequest::getInt('parking', 0, 'post').'-parking';
			}	
			
		if($minprice)
			{
			$minprice = JRequest::getInt('minprice', 0, 'post').'-minprice';
			}				

		if($maxprice)
			{
			$maxprice = JRequest::getInt('maxprice', 0, 'post').'-maxprice';	
			}
		
		if($ms_area)
			{
			$minarea=JRequest::getInt('minarea', 0, 'post').'-minarea';	
			$maxarea=JRequest::getInt('maxarea', 0, 'post').'-maxarea';	
			}
		}
		
		
		
		
		$urlVars['option'] = $post['option'];
		$urlVars['view'] = 'properties';
		$urlVars['task'] = 'showresults';
		
		if($showSelectCountry)
			{	
			$urlVars['cyid'] = $country;
			}			
		if($showSelectState)
			{	
			$urlVars['sid'] = $state;
			}
		if($showSelectLocality)
			{		
			$urlVars['lid'] = $locality;
			}		
		
		if($showSelectCategory)
			{		
			$urlVars['cid'] = $category;
			}	
			
		if($showSelectType)
			{		
			$urlVars['tid'] = $type;
			}	
			
		if($showSelectBedrooms)
			{		
			$urlVars['bedrooms'] = $bedrooms;
			}	
			
		if($showSelectBathrooms)
			{		
			$urlVars['bathrooms'] = $bathrooms;
			}	
			
		if($showSelectParking)
			{		
			$urlVars['parking'] = $parking;
			}	
			
		if($showSelectPrice)
			{		
			$urlVars['minprice'] = $minprice;
			$urlVars['maxprice'] = $maxprice;
			}						
		
		if($ms_area)
			{
			$urlVars['minarea'] = $minarea;	
			$urlVars['maxarea'] = $maxarea;	
			}					

			$menu = &JSite::getMenu();
			$items	= $menu->getItems('link', 'index.php?option=com_properties&view=properties');
			
			if(isset($items[0])) {
				$urlVars['Itemid'] = $items[0]->id;
			}else{
			/*
			$items	= $menu->getItems('link', 'index.php?option=com_properties&view=properties');
			$urlVars['Itemid'] = $items[0]->id;
			*/
				$urlVars['Itemid'] = 1;		
			}			
		
		$uri = JURI::getInstance();
		$uri->setQuery($urlVars);
		
		if($SaveSearchResults)
		{
		$model = $this->getModel('showresults');
		$db 	=& JFactory::getDBO();
		$query = 'SELECT id,hits FROM #__properties_showresults WHERE url = \''.JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false).'\'';		
        $db->setQuery($query);        
		$result = $db->loadObject();
		if($result)
			{
			$saveData['id']=$result->id;
			$saveData['hits']=$result->hits+1;			
			}else{		
		$saveData = $urlVars;
		unset($saveData['option']);
		unset($saveData['view']);
		unset($saveData['task']);
		$saveData['url']=JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false);
		$saveData['garage'] = $parking;
		$datenow =& JFactory::getDate();			
		$saveData['date'] = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		$saveData['hits']=1;	
			}			
			$model->store($saveData);
			}

		$this->setRedirect(JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false));		
	
	}
	
	function ModuleSearchAjax()
	{		
	JRequest::checkToken() or jexit( 'Invalid Token' );	
	$language =& JFactory::getLanguage();
	$language->load('mod_prop_search_ajax', JPATH_SITE, $language->getTag(), true);
	jimport( 'joomla.application.component.helper' );
	jimport( 'joomla.application.module.helper' );
	$db 	=& JFactory::getDBO();
	$lang =& JFactory::getLanguage();
	$thisLang = $lang->getTag();
	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$paramsC = new JParameter( $component->params );			
	$currencyformat		=	$paramsC->get('FormatPrice');
	$PositionPrice		=	$paramsC->get('PositionPrice');
	$SimbolPrice		=	$paramsC->get('SimbolPrice');
	$useTranslations	=	$paramsC->get('useTranslations','0');
	$Itemid = JRequest::getInt('Itemid');

	$moduleSearchAjax = JModuleHelper::getModule( 'prop_search_ajax' );
	$params = new JParameter( $moduleSearchAjax->params );

	$showSelectCountry 	=	$params->get( 'showSelectCountry' ) ;
	$idCountryDefault	=	$params->get( 'idCountryDefault' ) ;
	$showSelectState 	=	$params->get( 'showSelectState',1 ) ;
	$idStateDefault		=	$params->get( 'idStateDefault' ) ;
	$showSelectLocality =	$params->get( 'showSelectLocality',1 ) ;
	$idLocalityDefault	=	$params->get( 'idLocalityDefault' ) ;
	$showSelectCategory =	$params->get( 'showSelectCategory',1 ) ;
	$showSelectType 	=	$params->get( 'showSelectType',1 ) ;
	$showParentType   	=	$params->get( 'showParentType',0 );
	$showSelectPrice	=	$params->get( 'showSelectPrice',1 ) ;
	$showSelectBedrooms =	$params->get( 'showSelectBedrooms',1 ) ;
	$exactBedrooms =	$params->get( 'exactBedrooms',1 ) ;
	$showSelectBathrooms=	$params->get( 'showSelectBathrooms',1 ) ;
	$exactBathrooms =	$params->get( 'exactBathrooms',1 ) ;
	$showSelectParking 	=	$params->get( 'showSelectParking',1 ) ;
	$showSelectArea 	=	$params->get( 'showSelectArea',1 ) ;
	$ms_area 			=	$params->get( 'ms_area',0 ) ;
	$RangeAreaMin			=	$params->get( 'RangeAreaMin' ) ;
	$RangeAreaMax			=	$params->get( 'RangeAreaMax' ) ;
	$AreaToSearch = $params->get( 'AreaToSearch','area' ) ;	
	$MinPriceRentDay	=	$params->get( 'MinPriceRentDay',0 );
	$MaxPriceRentDay	=	$params->get( 'MaxPriceRentDay',0 );
	$IdCatPriceDay		=	$params->get( 'IdCatPriceDay',0 );
	$MinPriceRentMonth	=	$params->get( 'MinPriceRentMonth',0 );
	$MaxPriceRentMonth	=	$params->get( 'MaxPriceRentMonth',0 );
	$IdCatPriceMonth	=	$params->get( 'IdCatPriceMonth',0 );
	$MinPriceSell		=	$params->get( 'MinPriceSell',0 );
	$MaxPriceSell		=	$params->get( 'MaxPriceSell',0 );
	$ms_pricesell		=	$params->get( 'ms_pricesell',0 );
	
	$IdCatPriceSell		=	$params->get( 'IdCatPriceSell',0 );
	$ShowTotalResult	=	$params->get( 'ShowTotalResult',1 ) ;
	//$ShowTextSearch		=	$params->get('ShowTextSearch');

	$cyid = JRequest::getInt('cyid',0);
	$sid = JRequest::getInt('sid',0);
	$lid = JRequest::getInt('lid',0);
	$cid = JRequest::getInt('cid',0);
	$tid = JRequest::getInt('tid',0);
	//echo 'cyid'.$cyid;
	$var = array();
	$var['bedrooms']=JRequest::getInt('bedrooms','');
	$var['bathrooms']=JRequest::getInt('bathrooms','');
	$var['parking']=JRequest::getInt('parking','');
	$var['minprice']=JRequest::getInt('minprice','');
	$var['maxprice']=JRequest::getInt('maxprice','');
	$var['minarea']=JRequest::getInt('minarea','');
	$var['maxarea']=JRequest::getInt('maxarea','');

if(!$showSelectCountry and $idCountryDefault>0)
	{
	$cyid=$idCountryDefault;
	echo '<input type="hidden" name="cyid" value="'.$cyid.'" />';
	}else{
	$cyid = JRequest::getInt('cyid');
	$query = 'SELECT * FROM #__properties_country WHERE published = 1 ORDER BY name';
        $db->setQuery($query);        
		$Countries = $db->loadObjectList();		
		$cyitems 	= array();
		$cyitems[] 	= JHTML::_('select.option',  '0', JText::_( 'All Countries' ) );
		foreach ( $Countries as $cyitem ) {
			$cyitems[] = JHTML::_('select.option',  $cyitem->id, $cyitem->name );
		}
	$javascript = 'onChange="ModuleSearchAjax()"';		
	$ComboCountries = JHTML::_('select.genericlist',   $cyitems, 'cyid', 'class="select_search_vertical"'.$javascript, 'value', 'text', $cyid );	
	echo '<div class="combo_vertical">'.$ComboCountries.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
}



		
if($cyid>0){
if(!$showSelectState and $idStateDefault>0){
$sid=$idStateDefault;
echo '<input type="hidden" name="sid" value="'.$sid.'" />';
}else{
$sid = JRequest::getInt('sid');

	$query = 'SELECT * FROM #__properties_state WHERE published = 1 AND parent = '.$cyid.' ORDER BY name';		
        $db->setQuery($query);        
		$States = $db->loadObjectList();
		$sitems 	= array();
		$sitems[] 	= JHTML::_('select.option',  '0', JText::_( 'All States' ) );
			foreach ( $States as $sitem ) {
				$sitems[] = JHTML::_('select.option',  $sitem->id, $sitem->name );
			}
	

	$javascript = 'onChange="ModuleSearchAjax()"';		
	$ComboStates = JHTML::_('select.genericlist',   $sitems, 'sid', 'class="select_search_vertical"'. $javascript, 'value', 'text', $sid );	
		echo '<div class="combo_vertical">'.$ComboStates.'</div>' ;
		echo '<div class="separator_search_vertical"></div>' ;
}
}
		
if($sid){

if(!$showSelectLocality and $idLocalityDefault>0){
$lid=$idLocalityDefault;
echo '<input type="hidden" name="lid" value="'.$lid.'" />';
}else{
$lid = JRequest::getInt('lid');
$LocalityExists = false;
	$query = 'SELECT * FROM #__properties_locality WHERE published = 1 AND parent = '.$sid.' ORDER BY name';		
        $db->setQuery($query);        
		$Localities = $db->loadObjectList();
		$litems 	= array();
		$litems[] 	= JHTML::_('select.option',  '0', JText::_( 'All Localities' ) );		
			foreach ( $Localities as $litem ) {
				$litems[] = JHTML::_('select.option',  $litem->id, $litem->name );
				if($lid == $litem->id){$LocalityExists = true;}
			}	
	if(!$LocalityExists)
		{
		$lid = 0;
		}
	
	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
		
	$ComboLocalities = JHTML::_('select.genericlist',   $litems, 'lid', 'class="select_search_vertical"'. $javascript, 'value', 'text', $lid );	
		echo '<div class="combo_vertical">'.$ComboLocalities.'</div>' ;	
		echo '<div class="separator_search_vertical"></div>' ;
}	
}


		if($showSelectCategory)
			{

			$query = 'SELECT c.id,c.name ';
			if($useTranslations)
				{			
				$query .= ', CASE WHEN CHAR_LENGTH(t.t_value) THEN t.t_value ELSE c.name END as name ';
				$query .= 'FROM #__properties_category as c ';
				$query .= 'LEFT JOIN #__properties_translations as t ON t.t_fieldid = c.id AND t.t_table = "category" AND t.t_languagecode = "'.$thisLang.'" ';
				$query .= 'WHERE c.published = 1 ORDER BY c.name';				
				}else{
				$query .= 'FROM #__properties_category as c ';
				$query .= 'WHERE c.published = 1 ORDER BY c.name';
				}		
			
        	$db->setQuery($query);        
			$Categories = $db->loadObjectList();
			$citems 	= array();
			$citems[] 	= JHTML::_('select.option',  '0', JText::_( 'All Categories' ) );
			foreach ( $Categories as $citem ) 
				{
				$citems[] = JHTML::_('select.option',  $citem->id, $citem->name );
				}
			$javascript = 'onChange="ModuleSearchAjax()"';		
			$ComboCategories = JHTML::_('select.genericlist',   $citems, 'cid', 'class="select_search_vertical"'. $javascript, 'value', 'text', $cid );	
			echo '<div class="combo_vertical">'.$ComboCategories.'</div>' ;	
			echo '<div class="separator_search_vertical"></div>' ;
			
		}



		if($showSelectType){
			if($showParentType)
				{
				if($cid)
					{				
					$query = 'SELECT * FROM #__properties_type WHERE published = 1 AND parent = '.$cid.' OR parent = 0 ORDER BY name';
					}else{					
					$query = 'SELECT * FROM #__properties_type WHERE published = 1 ORDER BY name';
					}
				}else{

				//$query = 'SELECT * FROM #__properties_type WHERE published = 1 ORDER BY name';	
				$query = 'SELECT ty.id,ty.name ';
				if($useTranslations)
				{			
				$query .= ', CASE WHEN CHAR_LENGTH(t.t_value) THEN t.t_value ELSE ty.name END as name ';
				$query .= 'FROM #__properties_type as ty ';
				$query .= 'LEFT JOIN #__properties_translations as t ON t.t_fieldid = ty.id AND t.t_table = "type" AND t.t_languagecode = "'.$thisLang.'" ';
				$query .= 'WHERE ty.published = 1 ORDER BY ty.name';				
				}else{
				$query .= 'FROM #__properties_type as ty ';
				$query .= 'WHERE ty.published = 1 ORDER BY ty.name';
				}	
					
   				}  

	if($query)
		{
	    $db->setQuery($query);        
		$Types = $db->loadObjectList();	
		
		$titems 	= array();
		$titems[] 	= JHTML::_('select.option',  '0', JText::_( 'All Types' ) );
			foreach ( $Types as $titem ) {
				$titems[] = JHTML::_('select.option',  $titem->id, $titem->name );
			}
		
		if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
		
		$ComboTypes = JHTML::_('select.genericlist',   $titems, 'tid', 'class="select_search_vertical"'. $javascript, 'value', 'text', $tid );	
		echo '<div class="combo_vertical">'.$ComboTypes.'</div>' ;	
		echo '<div class="separator_search_vertical"></div>' ;
		}
	}



if ($showSelectBedrooms) {
$or_more=$exactBedrooms ? '' : ' '.JText::_('or more');
$Md[0]->id_dormitorios='';
$Md[0]->dormitorios=JText::_('Bedrooms');
$Md[1]->id_dormitorios=1;
$Md[1]->dormitorios='1 '.JText::_('Bedroom').$or_more;
$Md[2]->id_dormitorios=2;
$Md[2]->dormitorios='2 '.JText::_('Bedrooms').$or_more;
$Md[3]->id_dormitorios=3;
$Md[3]->dormitorios='3 '.JText::_('Bedrooms').$or_more;
$Md[4]->id_dormitorios=4;
$Md[4]->dormitorios='4 '.JText::_('Bedrooms').$or_more;
$Md[5]->id_dormitorios=5;
$Md[5]->dormitorios='5 '.JText::_('Bedrooms').$or_more;

	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
	
$dormitorios       = JHTML::_('select.genericlist',   $Md, 'bedrooms', 'class="select_search_vertical" '. $javascript,'id_dormitorios', 'dormitorios',  $var['bedrooms']); 
echo '<div class="combo_vertical">'.$dormitorios.'</div>' ;
echo '<div class="separator_search_vertical"></div>' ;
}

if ($showSelectBathrooms) {
$or_more=$exactBathrooms ? '' : ' '.JText::_('or more');
$Mb[0]->id_bathrooms='';
$Mb[0]->bathrooms=JText::_('Bathrooms');
$Mb[1]->id_bathrooms=1;
$Mb[1]->bathrooms='1 '.JText::_('Bathroom').$or_more;
$Mb[2]->id_bathrooms=2;
$Mb[2]->bathrooms='2 '.JText::_('Bathrooms').$or_more;
$Mb[3]->id_bathrooms=3;
$Mb[3]->bathrooms='3 '.JText::_('Bathrooms').$or_more;
$Mb[4]->id_bathrooms=4;
$Mb[4]->bathrooms='4 '.JText::_('Bathrooms').$or_more;
$Mb[5]->id_bathrooms=5;
$Mb[5]->bathrooms='5 '.JText::_('Bathrooms').$or_more;

	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
	
$bathrooms       = JHTML::_('select.genericlist',   $Mb, 'bathrooms', 'class="select_search_vertical"'. $javascript,'id_bathrooms', 'bathrooms',  $var['bathrooms']); 
echo '<div class="combo_vertical">'.$bathrooms.'</div>' ;
echo '<div class="separator_search_vertical"></div>' ;
}

if ($showSelectParking) {
$Mp[0]->id_parking='';
$Mp[0]->parking=JText::_('Car Spaces');
$Mp[1]->id_parking=1;
$Mp[1]->parking='1 '.JText::_('Car');
$Mp[2]->id_parking=2;
$Mp[2]->parking='2 '.JText::_('Cars');
$Mp[3]->id_parking=3;
$Mp[3]->parking='3 '.JText::_('Cars');
$Mp[4]->id_parking=4;
$Mp[4]->parking='4 '.JText::_('Cars');
$Mp[5]->id_parking=5;
$Mp[5]->parking='5 '.JText::_('Cars');	

	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
	
$parking       = JHTML::_('select.genericlist',   $Mp, 'parking', 'class="select_search_vertical"'. $javascript,'id_parking', 'parking',  $var['parking']); 	
echo '<div class="combo_vertical">'.$parking.'</div>' ;
echo '<div class="separator_search_vertical"></div>' ;
}



if ($showSelectPrice){
	$RP =  '';
	$Rminprice[$cid] = '';
	$RPx =  '';
	$Rmaxprice[$cid] = '';

	if ($ms_pricesell)
		{
		if($MinPriceSell)
			{
			$RP = explode(';',$MinPriceSell);
			}
		if($MaxPriceSell)
			{	
			$RPx = explode(';',$MaxPriceSell);
			}		
		}else{
		
		if($MinPriceRentDay)
			{
			$Rminprice[$IdCatPriceDay]=explode(';',$MinPriceRentDay);
			}		
		if($MaxPriceRentDay)
			{
			$Rmaxprice[$IdCatPriceDay]=explode(';',$MaxPriceRentDay);
			}
	
		if($MinPriceRentMonth)
			{
			$Rminprice[$IdCatPriceMonth]=explode(';',$MinPriceRentMonth);
			}
	
		if($MaxPriceRentMonth)
			{
			$Rmaxprice[$IdCatPriceMonth]=explode(';',$MaxPriceRentMonth);
			}
	
		if($MinPriceSell)
			{
			$Rminprice[$IdCatPriceSell]=explode(';',$MinPriceSell);
			}
	
		if($MaxPriceSell)
			{
			$Rmaxprice[$IdCatPriceSell]=explode(';',$MaxPriceSell);
			}
	
		$RP = $Rminprice[$cid];
		$RPx = $Rmaxprice[$cid];
		}
	
	$currencyformat=$paramsC->get('FormatPrice');
	$SimbolPrice=$paramsC->get('SimbolPrice');
	
	$number=1000;
	
	if ($currencyformat==0) {			
			$formatPrice = '0;.;,';
		} else if ($currencyformat==1) {			
			$formatPrice = '2;.;,';
		} else if ($currencyformat==2) {			
			$formatPrice = '0;,;.';
		} else if ($currencyformat==3) {			
			$formatPrice = '2;,;.';
		}
		$formatPriceTo = explode(';',$formatPrice);		
			
		//$showprice = $PositionPrice==0 ? JText::_('Price').': '.$SimbolPrice.' '. $formatedPrice.'' : JText::_('Price').': '.$formatedPrice .' '. $SimbolPrice.'';
		if($PositionPrice==0)
			{
			$simbolBefore = $SimbolPrice.' ';
			$simbolAfter = '';
			}else{
			$simbolBefore = '';
			$simbolAfter = ' '.$SimbolPrice;
			}
	
	if($RP)
		{
		$Trp =  count($RP);
		$minprice[0]->id_minprice='';
		$minprice[0]->minprice=JText::_('Min Price');
		
		for($p=0;$p<$Trp;$p++)
			{			
			$formatedPrice = number_format(str_replace($formatPriceTo[2],'',$RP[$p]), $formatPriceTo[0],$formatPriceTo[1],$formatPriceTo[2]);
			$minprice[$p+1]->id_minprice=str_replace($formatPriceTo[2],'',$RP[$p]);
			$minprice[$p+1]->minprice=$simbolBefore.$formatedPrice.$simbolAfter;	
			}
			
	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}

		$minprice       = JHTML::_('select.genericlist',   $minprice, 'minprice', 'class="select_search_vertical"'. $javascript,'id_minprice', 'minprice',  $var['minprice']); 

echo '<div class="combo_vertical">'.$minprice.'</div>';
echo '<div class="separator_search_vertical"></div>' ;
		}
	
	
	if($RPx)
		{		
		$Trpx =  count($RPx);
		$maxprice[0]->id_maxprice='';
		$maxprice[0]->maxprice=JText::_('Max Price');
		
		for($px=0;$px<$Trpx;$px++)
			{
			$formatedPrice = number_format(str_replace($formatPriceTo[2],'',$RPx[$px]), $formatPriceTo[0],$formatPriceTo[1],$formatPriceTo[2]);
			$maxprice[$px+1]->id_maxprice=str_replace($formatPriceTo[2],'',$RPx[$px]);
			$maxprice[$px+1]->maxprice=$simbolBefore.$formatedPrice.$simbolAfter;
			}

	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
	
		$maxprice       = JHTML::_('select.genericlist',   $maxprice, 'maxprice', 'class="select_search_vertical"'. $javascript,'id_maxprice', 'maxprice',  $var['maxprice']); 
echo '<div class="combo_vertical">'.$maxprice.'</div>' ;
echo '<div class="separator_search_vertical"></div>' ;
	}
}












if($ms_area==1)
	{
	$minarea=JRequest::getInt('minarea');
	$maxarea=JRequest::getInt('maxarea');
	
	if($RangeAreaMin and $RangeAreaMax)
		{
		$RA = explode(';',$RangeAreaMin);
		$RAX = explode(';',$RangeAreaMax);

		$minitems 	= array();
		$minitems[] 	= JHTML::_('select.option',  '', JText::_( 'Select Min Area' ) );
		for($a=0;$a<count($RA);$a++)
			{	
			$minitems[] 	= JHTML::_('select.option',  str_replace('.','',$RA[$a]), $RA[$a].' '.JText::_( 'AREA_UNIT' ) );
			}
	
	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}	

	$ComboSearcharea = JHTML::_('select.genericlist',   $minitems, 'minarea', 'class="select_search_vertical"'. $javascript, 'value', 'text', $minarea );
	echo '<div class="combo_vertical">'.$ComboSearcharea.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
	
	
		$maxitems 	= array();
		$maxitems[] 	= JHTML::_('select.option',  '', JText::_( 'Select Max Area' ) );
		for($a=0;$a<count($RAX);$a++)
			{	
			$maxitems[] 	= JHTML::_('select.option',  str_replace('.','',$RAX[$a]), $RAX[$a].' '.JText::_( 'AREA_UNIT' ) );
			}
		}
		
	if($ShowTotalResult==1)
	{
	$javascript = 'onChange="ModuleSearchAjax()"';
	}else{
	$javascript = '';
	}
	
	$ComboSearcharea = JHTML::_('select.genericlist',   $maxitems, 'maxarea', 'class="select_search_vertical"'. $javascript, 'value', 'text', $maxarea );
	echo '<div class="combo_vertical">'.$ComboSearcharea.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
	
	
	}

if($ms_area==2)
	{
	$minarea=JRequest::getInt('minarea')?JRequest::getInt('minarea'):'';
	$maxarea=JRequest::getInt('maxarea')?JRequest::getInt('maxarea'):'';
	
?>

<div class="combo_vertical">
<label class="minarea"><?php echo JText::_('Min Area');?></label>
<input type="text" class="input_area" name="minarea" id="minarea" value="<?php echo $minarea;?>" />
</div>

<div class="combo_vertical">
<label class="minarea"><?php echo JText::_('Max Area');?></label>
<input type="text" class="input_area" name="maxarea" id="maxarea" value="<?php echo $maxarea;?>" />
</div>

<?php
 
  	}  



	if($ShowTotalResult==1)
	{
	$where = array();
	$where[] = 'p.published = 1';

		
		if ( $cyid>0 )
		{			
				$where[] = 'p.cyid = '.$cyid;			
		}
		if ( $sid>0 )
		{			
				$where[] = 'p.sid = '.$sid;			
		}
		if ( $lid>0 )
		{			
				$where[] = 'p.lid = '.$lid;			
		}
		if ( $cid>0 )
		{			
				$where[] = '(p.cid = '.$cid.' OR pc.categoryid = '.$cid.')';
		}
		if ( $tid>0 )
		{			
				$where[] = 'p.type = '.$tid;			
		}
		
		
		
		if ( $var['bedrooms']>0 )
		{			
		$where[] = $exactBedrooms ? 'p.bedrooms = '.$var['bedrooms'] : 'p.bedrooms >= '.$var['bedrooms'];
				//$where[] = 'p.bedrooms = '.$var['bedrooms'];			
		}
		if ( $var['bathrooms']>0 )
		{			
		$where[] = $exactBathrooms ? 'p.bathrooms = '.$var['bathrooms'] : 'p.bathrooms >= '.$var['bathrooms'];		
				//$where[] = 'p.bathrooms = '.$var['bathrooms'];			
		}		
		
		if ( $var['parking']>0 )
		{			
				$where[] = 'p.garage = '.$var['parking'];			
		}
		if ( $var['minprice']>0 )
		{			
				$where[] = 'p.price >= '.$var['minprice'];			
		}
		if ( $var['maxprice']>0 )
		{			
				$where[] = 'p.price <= '.$var['maxprice'];			
		}
		if ( $var['minarea']>0 )
		{			
				$where[] = 'p.'.$AreaToSearch.' >= '.$var['minarea'];			
		}
		if ( $var['maxarea']>0 )
		{			
				$where[] = 'p.'.$AreaToSearch.' <= '.$var['maxarea'];			
		}


	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );

	$queryS = ' SELECT COUNT(DISTINCT p.id) AS total'							
				. ' FROM #__properties_products AS p '				
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				//. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '	
				. ' LEFT JOIN #__properties_product_category AS pc ON p.id = pc.productid '
				. ' LEFT JOIN #__properties_category AS c ON c.id = pc.categoryid '			
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '				
				. $where.' '
				. 'GROUP BY p.published'		
				;
	$db->setQuery($queryS);        
		$Total = $db->loadResult();						

	if($Total)
	{
	$buttonText = JText::_('Show').': '.$Total.' '.JText::_('Results');
	}else{
	$buttonText = JText::_('Results not found');
	}
?>
<script type="text/javascript">
document.getElementById('buttonSearch').innerHTML = '<?php echo $buttonText; ?>';
</script>
<?php

	}

}
	
}
?>
