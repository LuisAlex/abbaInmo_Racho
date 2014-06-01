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
	$badchars = array('#','>','<','\\'); 
		
		$urlVars['option'] = $post['option'];		
		$urlVars['view'] = 'search';
				
		if($country = JRequest::getInt('cyid', '', 'post'))
			{	
			$urlVars['cyid'] = $country;
			}			
		if($state = JRequest::getInt('sid', 0, 'post'))
			{	
			$urlVars['sid'] = $state;
			}
		if($locality = JRequest::getInt('lid', 0, 'post'))
			{		
			$urlVars['lid'] = $locality;
			}		
		
		if($category = JRequest::getInt('cid', 0, 'post'))
			{		
			$urlVars['cid'] = $category;
			}	
			
		if($type = JRequest::getInt('tid', 0, 'post'))
			{		
			$urlVars['tid'] = $type;
			}	
			
		if($bedrooms = JRequest::getInt('bedrooms', 0, 'post'))
			{		
			$urlVars['bedrooms'] = $bedrooms;
			}	
			
		if($bathrooms = JRequest::getInt('bathrooms', 0, 'post'))
			{		
			$urlVars['bathrooms'] = $bathrooms;
			}	
			
		if($parking = JRequest::getInt('parking', 0, 'post'))
			{		
			$urlVars['parking'] = $parking;
			}	

		$signs = array('#','>','<','\\',',','.'); 

		if($minprice = JRequest::getVar('minprice', 0, 'post'))
			{		
			$minprice = trim(str_replace($signs, '', $minprice));
			$urlVars['minprice'] = (int)$minprice;
			}
		
		if($maxprice = JRequest::getVar('maxprice', 0, 'post'))
			{		
			$maxprice = trim(str_replace($signs, '', $maxprice));
			$urlVars['maxprice'] = (int)$maxprice;
			}									
		
		if($currency = JRequest::getVar('currency', 0, 'post'))
			{		
			$currency = trim(str_replace($signs, '', $currency));
			$urlVars['currency'] = $currency;
			}	
					
		if($minarea = JRequest::getInt('minarea', 0, 'post'))
			{
			$urlVars['minarea'] = $minarea;	
			}	
							
		if($maxarea = JRequest::getInt('maxarea', 0, 'post'))
			{
			$urlVars['maxarea'] = $maxarea;	
			}
		if($minareacov = JRequest::getInt('minareacov', 0, 'post'))
			{
			$urlVars['minareacov'] = $minareacov;	
			}	
							
		if($maxareacov = JRequest::getInt('maxareacov', 0, 'post'))
			{
			$urlVars['maxareacov'] = $maxareacov;	
			}
		
		if($extra1 = JRequest::getInt('e1', 0, 'post'))
			{
			$urlVars['e1'] = $extra1;	
			}
		if($extra2 = JRequest::getInt('e2', 0, 'post'))
			{
			$urlVars['e2'] = $extra2;	
			}
		if($extra3 = JRequest::getInt('e3', 0, 'post'))
			{
			$urlVars['e3'] = $extra3;	
			}	
		if($extra4 = JRequest::getInt('e4', 0, 'post'))
			{
			$urlVars['e4'] = $extra4;	
			}	
		if($extra5 = JRequest::getInt('e5', 0, 'post'))
			{
			$urlVars['e5'] = $extra5;	
			}
		if($extra6 = JRequest::getInt('e6', 0, 'post'))
			{
			$urlVars['e6'] = $extra6;	
			}	
		if($extra7 = JRequest::getInt('e7', 0, 'post'))
			{
			$urlVars['e7'] = $extra7;	
			}	
		if($extra8 = JRequest::getInt('e8', 0, 'post'))
			{
			$urlVars['e8'] = $extra8;	
			}	
		if($extra9 = JRequest::getInt('e9', 0, 'post'))
			{
			$urlVars['e9'] = $extra9;	
			}	
		if($extra10 = JRequest::getInt('e10', 0, 'post'))
			{
			$urlVars['e10'] = $extra10;	
			}	
			
			
			
		
		$textsearch = trim(str_replace($badchars, '', JRequest::getString('textsearch', null, 'post')));
		if($textsearch)
			{
			$urlVars['textsearch'] = $textsearch;	
			}	
			
			
			
			
				
				
			$menu = &JSite::getMenu();
			$items	= $menu->getItems('link', 'index.php?option=com_properties&view=search');
			
			if(isset($items[0])) {
				$urlVars['Itemid'] = $items[0]->id;
				$urlVars['view'] = 'search';	
			}else{			
			$items	= $menu->getItems('link', 'index.php?option=com_properties&view=properties');
			$urlVars['Itemid'] = $items[0]->id;		
			$urlVars['view'] = 'properties';				
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
//parent::display();

echo $uri->toString(array('query', 'fragment'));
//require('a');

$this->setRedirect(JRoute::_('index.php'.$uri->toString(array('query', 'fragment')), false));	
		
		//$this->setRedirect('index.php'.$uri->toString(array('query', 'fragment')));		
	
	}
	
	function ModuleSearchAjax()
	{		
	JRequest::checkToken() or jexit( 'Invalid Token' );	
	require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
	$language =& JFactory::getLanguage();
	$language->load('mod_prop_search_ajax', JPATH_SITE, $language->getTag(), true);
	jimport( 'joomla.application.component.helper' );
	jimport( 'joomla.application.module.helper' );
	$db 	=& JFactory::getDBO();
	$lang =& JFactory::getLanguage();
	$thisLang = $lang->getTag();
	$badchars = array('#','>','<','\\'); 
	
	$component = JComponentHelper::getComponent( 'com_properties' );
	$paramsC = new JParameter( $component->params );			
	$currencyformat		=	$paramsC->get('FormatPrice');
	$PositionPrice		=	$paramsC->get('PositionPrice');
	$SimbolPrice		=	$paramsC->get('SimbolPrice');
	$useTranslations	=	$paramsC->get('useTranslations','0');
	$Itemid = JRequest::getInt('Itemid');

	$moduleSearch = JModuleHelper::getModule( 'prop_search_ajax' );

		$params = new JParameter( $moduleSearch->params );

	$showSelectCountry 	=	$params->get( 'showSelectCountry' ) ;
	$idCountryDefault	=	$params->get( 'idCountryDefault' ) ;
	$showSelectState 	=	$params->get( 'showSelectState',1 ) ;
	$idStateDefault		=	$params->get( 'idStateDefault' ) ;
	$showSelectLocality =	$params->get( 'showSelectLocality',1 ) ;
	$idLocalityDefault	=	$params->get( 'idLocalityDefault' ) ;
	$showSelectCategory =	$params->get( 'showSelectCategory',1 ) ;
	$showSelectType 	=	$params->get( 'showSelectType',1 ) ;
	$showParentType   	=	$params->get( 'showParentType',0 );
	
	$showSelectBedrooms =	$params->get( 'showSelectBedrooms',1 ) ;
	$exactBedrooms =	$params->get( 'exactBedrooms',1 ) ;
	$showSelectBathrooms=	$params->get( 'showSelectBathrooms',1 ) ;
	$exactBathrooms =	$params->get( 'exactBathrooms',1 ) ;
	$showSelectParking 	=	$params->get( 'showSelectParking',1 ) ;
	$showSelectArea 	=	$params->get( 'showSelectArea',1 ) ;
	$ms_area 			=	$params->get( 'ms_area',0 ) ;
	$RangeAreaMin			=	$params->get( 'RangeAreaMin' ) ;
	$RangeAreaMax			=	$params->get( 'RangeAreaMax' ) ;
	$AreaToSearch		=	$params->get( 'AreaToSearch','area' ) ;	
	$showTextCoveredArea	=	$params->get( 'showTextCoveredArea','0' ) ;	
	
	$showCurrency		=	$params->get( 'showCurrency',0 ) ;
	$showTextPrice		=	$params->get( 'showTextPrice',1 ) ;
	$showSelectPrice	=	$params->get( 'showSelectPrice',0 ) ;
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
	
	$showExtra1		=	$params->get( 'showExtra1',0 );
	$showExtra2		=	$params->get( 'showExtra2',0 );
	$showExtra3		=	$params->get( 'showExtra3',0 );
	$showExtra4		=	$params->get( 'showExtra4',0 );
	$showExtra5		=	$params->get( 'showExtra5',0 );
	$showExtra6		=	$params->get( 'showExtra6',0 );
	$showExtra7		=	$params->get( 'showExtra7',0 );
	$showExtra8		=	$params->get( 'showExtra8',0 );
	$showExtra9		=	$params->get( 'showExtra9',0 );
	$showExtra10	=	$params->get( 'showExtra10',0 );
	
	$ShowTextSearch	=	$params->get( 'ShowTextSearch',0 );

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
	
	}elseif(!$showSelectCountry){
	
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



		
if($cyid>0 or (!$showSelectCountry and !$idCountryDefault) ){
if(!$showSelectState and $idStateDefault>0){
$sid=$idStateDefault;
echo '<input type="hidden" name="sid" value="'.$sid.'" />';

}elseif(!$showSelectState){

}else{
$sid = JRequest::getInt('sid');
	if($cyid>0)
		{
		$query = 'SELECT * FROM #__properties_state WHERE published = 1 AND parent = '.$cyid.' ORDER BY name';	
		}else{
		$query = 'SELECT * FROM #__properties_state WHERE published = 1 ORDER BY name';	
		}
	
		
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
		
if($sid>0 or (!$showSelectState and !$idStateDefault) ){

if(!$showSelectLocality and $idLocalityDefault>0){
$lid=$idLocalityDefault;
echo '<input type="hidden" name="lid" value="'.$lid.'" />';
}else{
$lid = JRequest::getInt('lid');
$LocalityExists = false;
	if($sid>0)
		{
		$query = 'SELECT * FROM #__properties_locality WHERE published = 1 AND parent = '.$sid.' ORDER BY name';
		}else{
		$query = 'SELECT * FROM #__properties_locality WHERE published = 1 ORDER BY name';
		}	
		
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
$or_more=$exactBedrooms ? '' : 'o mas ';
$Md[0]->id_dormitorios='';
$Md[0]->dormitorios=JText::_('BEDROOMS');
$Md[1]->id_dormitorios=1;
$Md[1]->dormitorios='1 '.JText::_($or_more.'recamaras');
$Md[2]->id_dormitorios=2;
$Md[2]->dormitorios='2 '.JText::_($or_more.'recamaras');
$Md[3]->id_dormitorios=3;
$Md[3]->dormitorios='3 '.JText::_($or_more.'recamaras');
$Md[4]->id_dormitorios=4;
$Md[4]->dormitorios='4 '.JText::_($or_more.'recamaras');
$Md[5]->id_dormitorios=5;
$Md[5]->dormitorios='5 '.JText::_('o mas recamaras');

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
$or_more=$exactBathrooms ? '' : 'o mas ';
$Mb[0]->id_bathrooms='';
$Mb[0]->bathrooms=JText::_('Baños');
$Mb[1]->id_bathrooms=1;
$Mb[1]->bathrooms='1 '.JText::_($or_more.'Baños');
$Mb[2]->id_bathrooms=2;
$Mb[2]->bathrooms='2 '.JText::_($or_more.'Baños');
$Mb[3]->id_bathrooms=3;
$Mb[3]->bathrooms='3 '.JText::_($or_more.'Baños');
$Mb[4]->id_bathrooms=4;
$Mb[4]->bathrooms='4 '.JText::_($or_more.'Baños');


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


if ($showTextPrice){

if($var['minprice']>0)
	{
	$defPriceMin = $var['minprice'];
	}
if($var['maxprice']>0)
	{
	$defPriceMax = $var['maxprice'];
	}
	
	

?>
<div class="price_search">
<div class="price_title">
<?php echo JText::_('Price');?>
</div>

<!--<label class="price_min"><?php echo JText::_('Min');?></label>-->
<input type="text" class="input_price" name="minprice" id="minprice" value="<?php echo $defPriceMin;?>" />

<label class="price_max"><?php echo JText::_('DIVISOR_INPUT_PRICES');?></label>
<input type="text" class="input_price" name="maxprice" id="maxprice" value="<?php echo $defPriceMax;?>" />

</div>
<?php


}elseif($showSelectPrice){
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





	if($showCurrency)
		{		
		if($ShowTotalResult==1)
			{			
			$javascript = 'onChange="ModuleSearchAjax()"';
			}else{
			$javascript = '';
			}

	$var['currency'] = trim(str_replace($badchars, '', JRequest::getString('currency', null)));	

	$currencies = PropertiesHelper::getCurrencies();

	$options = array ();

	//$options[] = JHTML::_('select.option', 0, $SimbolPrice);
		foreach ($currencies as $option)
		{
			$options[] = JHTML::_('select.option', $option->id, $option->currency);
		}
		
		if($showCurrency==1)
			{
			echo JHTML::_('select.genericlist',   $options, 'currency', 'class="select_search_minarea"'. $javascript, 'value', 'text', $var['currency'] );
			}elseif($showCurrency==2)
			{
			echo JHTML::_('select.radiolist', $options, 'currency', $javascript, 'value', 'text', $var['currency'], 'currency' );
			}
		echo '<div class="separator_search_vertical" style="height:5px;"></div>' ;
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
		$minitems[] 	= JHTML::_('select.option',  '', JText::_( 'Min Area' ) );
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

	$ComboSearchareaMin = JHTML::_('select.genericlist',   $minitems, 'minarea', 'class="select_search_minarea"'. $javascript, 'value', 'text', $minarea );
	
	
	
		$maxitems 	= array();
		$maxitems[] 	= JHTML::_('select.option',  '', JText::_( 'Max Area' ) );
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
	
	
	
	$ComboSearchareaMax = JHTML::_('select.genericlist',   $maxitems, 'maxarea', 'class="select_search_maxarea"'. $javascript, 'value', 'text', $maxarea );
	
	echo '<div class="area_title">'.JText::_('Terreno:').'</div>';
	
	echo '<div class="combo_minarea">'.$ComboSearchareaMin.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
	
	
	echo '<div class="combo_maxarea">'.$ComboSearchareaMax.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
	
	
	
	
	
	
	

	if(showTextCoveredArea)
		{		
		$minareacov=JRequest::getInt('minareacov');
		$maxareacov=JRequest::getInt('maxareacov');
		
		$ComboSearchareaCov = JHTML::_('select.genericlist',   $minitems, 'minareacov', 'class="select_search_minareacov"'. $javascript, 'value', 'text', $minareacov );
	echo '<div class="area_title">'.JText::_('Contruccion:').'</div>';
	echo '<div class="combo_minareacov">'.$ComboSearchareaCov.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
	
		$ComboSearchareaCov = JHTML::_('select.genericlist',   $maxitems, 'maxareacov', 'class="select_search_maxareacov"'. $javascript, 'value', 'text', $maxareacov );
	echo '<div class="combo_maxareacov">'.$ComboSearchareaCov.'</div>' ;
	echo '<div class="separator_search_vertical"></div>' ;
		
		

		}
		
		
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	

if($ms_area==2)
	{
	$minarea=JRequest::getInt('minarea')?JRequest::getInt('minarea'):'';
	$maxarea=JRequest::getInt('maxarea')?JRequest::getInt('maxarea'):'';	
?>
<div class="area_search">
<div class="area_title">
<?php echo JText::_('Default Area');?>
</div>

<!--<label class="area_min"><?php echo JText::_('Min');?></label>-->
<input type="text" class="input_area" name="minarea" id="minarea" value="<?php echo $minarea;?>" />

<label class="area_max"><?php echo JText::_('DIVISOR_INPUT_AREA');?></label>
<input type="text" class="input_area" name="maxarea" id="maxarea" value="<?php echo $maxarea;?>" />

</div>
<?php

	if(showTextCoveredArea)
		{
		$minareacov=JRequest::getInt('minareacov')?JRequest::getInt('minareacov'):'';
		$maxareacov=JRequest::getInt('maxareacov')?JRequest::getInt('maxareacov'):'';	
?>
		<div class="area_search">
		<div class="area_title">
		<?php echo JText::_('Covered Area');?>
		</div>

		<!--<label class="area_min"><?php echo JText::_('Min');?></label>-->
		<input type="text" class="input_area" name="minareacov" id="minareacov" value="<?php echo $minareacov;?>" />

		<label class="area_max"><?php echo JText::_('DIVISOR_INPUT_AREA');?></label>
		<input type="text" class="input_area" name="maxareacov" id="maxareacov" value="<?php echo $maxareacov;?>" />

		</div>
<?php
		}
  	}  



echo '<div class="separator_search_vertical" style="width:100%; clear:both;"></div>' ;

$e1 = JRequest::getInt('e1',0);
$e2 = JRequest::getInt('e2',0);
$e3 = JRequest::getInt('e3',0);
$e4 = JRequest::getInt('e4',0);
$e5 = JRequest::getInt('e5',0);
$e6 = JRequest::getInt('e6',0);
$e7 = JRequest::getInt('e7',0);
$e8 = JRequest::getInt('e8',0);
$e9 = JRequest::getInt('e9',0);
$e10 = JRequest::getInt('e10',0);

	if($ShowTotalResult==1)
	{
	$javascriptcheck = 'onclick="ModuleSearchAjax()"';
	}else{
	$javascriptcheck = '';
	}
	
	
if($showExtra1)
	{	
	$checked = JRequest::getInt('e1') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e1" name="e1" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA1').'</label></div>';
	}	
if($showExtra2)
	{	
	$checked = JRequest::getInt('e2') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e2" name="e2" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA2').'</label></div>';
	}	
if($showExtra1)
	{	
	$checked = JRequest::getInt('e3') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e3" name="e3" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA3').'</label></div>';
	}

if($showExtra1)
	{	
	$checked = JRequest::getInt('e4') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e4" name="e4" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA4').'</label></div>';
	}	
if($showExtra1)
	{	
	$checked = JRequest::getInt('e5') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e5" name="e5" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA5').'</label></div>';
	}
if($showExtra1)
	{	
	$checked = JRequest::getInt('e6') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e6" name="e6" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA6').'</label></div>';
	}
if($showExtra1)
	{	
	$checked = JRequest::getInt('e7') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e7" name="e7" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA7').'</label></div>';
	}
if($showExtra1)
	{	
	$checked = JRequest::getInt('e8') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e8" name="e8" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA8').'</label></div>';
	}
if($showExtra1)
	{	
	$checked = JRequest::getInt('e9') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e9" name="e9" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA9').'</label></div>';
	}
if($showExtra10)
	{	
	$checked = JRequest::getInt('e10') ? 'checked="checked"' : '';
	echo '<div class="search_label"><label>';
	echo '<input type="checkbox" id="e10" name="e10" value="1" '.$javascriptcheck.' '.$checked.' />';
	echo ''.JText::_('EXTRA10').'</label></div>';
	}
	
echo '<div class="search_label_last">&nbsp;</div>';	




if(isset($ShowTextSearch) and $ShowTextSearch == 1){

		$textsearch = trim(str_replace($badchars, '', JRequest::getString('textsearch', null)));
		
echo '<div class="search_textsearch">';
echo '<div class="text_title">'.JText::_('Text to Search').'</div>';	
echo '<input type="text" id="textsearch" name="textsearch" value="'.$textsearch.'" class="textsearch" />';
echo '</div>';	
echo '<div class="search_label_last">&nbsp;</div>';	
}




if($ShowTotalResult==1)
	{
	$where = array();
	$where[] = 'p.published = 1';

		
		if ( $cyid>0 & $showSelectCountry)
		{			
				$where[] = 'p.cyid = '.$cyid;			
		}
		if ( $sid>0 & $showSelectState)
		{			
				$where[] = 'p.sid = '.$sid;			
		}
		if ( $lid>0 & $showSelectLocality)
		{			
				$where[] = 'p.lid = '.$lid;			
		}
		if ( $cid>0 & $showSelectCategory)
		{			
				$where[] = '(p.cid = '.$cid.' OR pc.categoryid = '.$cid.')';
		}
		if ( $tid>0 & $showSelectType)
		{			
				$where[] = 'p.type = '.$tid;			
		}
		
		if ( $var['bedrooms']>0 )
		{		
			if ( $var['bedrooms']==5 )
				{	
				$where[] = 'p.bedrooms >= '.$var['bedrooms'];	
				}else{
				$where[] = $exactBedrooms ? 'p.bedrooms = '.$var['bedrooms'] : 'p.bedrooms >= '.$var['bedrooms'];	
				}	
		}
		
		if ( $var['bathrooms']>0 )
		{			
			if ( $var['bathrooms']==5 )
				{
				$where[] = 'p.bathrooms >= '.$var['bathrooms'];
				}else{		
				$where[] = $exactBathrooms ? 'p.bathrooms = '.$var['bathrooms'] : 'p.bathrooms >= '.$var['bathrooms'];
				}
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
		
		if($e1)
			{
			$where[] = 'p.extra1 = 1';	
			}
		if($e2)
			{
			$where[] = 'p.extra2 = 1';	
			}
		if($e3)
			{
			$where[] = 'p.extra3 = 1';	
			}
		if($e4)
			{
			$where[] = 'p.extra4 = 1';	
			}
		if($e5)
			{
			$where[] = 'p.extra5 = 1';	
			}
		if($e6)
			{
			$where[] = 'p.extra6 = 1';	
			}
		if($e7)
			{
			$where[] = 'p.extra7 = 1';	
			}
		if($e8)
			{
			$where[] = 'p.extra8 = 1';	
			}
		if($e9)
			{
			$where[] = 'p.extra9 = 1';	
			}
		if($e10)
			{
			$where[] = 'p.extra10 = 1';	
			}
		
		if ( $var['currency'] )
		{			
				$where[] = 'p.currency = '.$db->Quote( $db->getEscaped( $var['currency'], true ), false );	
						
		}	
			
		if($textsearch)
			{
			$text		= $db->Quote( '%'.$db->getEscaped( $textsearch, true ).'%', false );
			$wheres2 	= array();
			$wheres2[] 	= 'p.name LIKE '.$text;
			$wheres2[] 	= 'p.text LIKE '.$text;
			$wheres2[] 	= 'p.description LIKE '.$text;
			$where[] 		= '((' . implode( ') OR (', $wheres2 ) . '))';
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
//echo str_replace('#_','jos',$queryS);
	if($Total)
	{
	$buttonText = JText::_('Show').': '.$Total.' '.JText::_('Results');
	}else{
	$buttonText = JText::_('Sin Resultados');
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
