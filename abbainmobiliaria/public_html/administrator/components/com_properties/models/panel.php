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

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
class PropertiesModelPanel extends JModel
{
	function __construct()
	{
	
		parent::__construct();		
	}	
	
	function getConfig()
	{
	global $mainframe;
	$params		= JComponentHelper::getParams('com_properties');
	$Version=$params->get('version');
	if(!$Version)
		{
		$component = JComponentHelper::getComponent( 'com_properties' );
		$compid=$component->id;
		$db =& JFactory::getDBO();
		$sql_query = "UPDATE #__components SET `params` ='Listlayout=slide\nWidthList=100%\nWidthThumbs=100\nHeightThumbs=75\nWidthImage=640\nHeightImage=480\nShowImagesSystem=1\nShowOrderBy=0\nShowOrderByDefault=ordering\nShowOrderDefault=ASC\nShowLogoAgent=1\nShowReferenceInList=1\nShowCategoryInList=1\nShowTypeInList=1\nShowCountryInList=1\nShowStateInList=1\nShowLocalityInList=1\nShowAddressInList=1\nShowPriceInList=1\nShowContactLink=1\nShowPriceList=1\nShowMapLink=1\nShowViewPropertiesAgentLink=1\nshowFavorites=1\nThumbsInAccordion=5\nWidthThumbsAccordion=100\nHeightThumbsAccordion=75\nShowFeaturesInList=1\nDetailLayout=0\nActivarTabs=0\nWidthDetail=100%\nShowImagesSystemDetail=1\npretty_photo_style=light_rounded\nWidthThumbsDetail=120\nHeightThumbsDetail=90\nShowRecommendLink=0\nAmountMonthsCalendar=3\nStartYearCalendar=2009\nStartMonthCalendar=\nPeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=\nPeriodStartBookings=\nPeriodEndBookings=\nversion=2011-09-12\nuseTranslations=0\nprodMultipleCats=0\ncategoryInUrl=0\nlinkToPropertyView=1\nUseCountryDefault=1\nUseStateDefault=1\nUseLocalityDefault=1\ncantidad_productos=5\nActiveMapa=1\napikey=ABQIAAAAFHktBEXrHnX108wOdzd3aBTupK1kJuoJNBHuh0laPBvYXhjzZxR0qkeXcGC_0Dxf4UMhkR7ZNb04dQ\ndistancia=15\nDefaultLat=30.062438\nDefaultLng=31.248207\nAutoCoord=1\nWidthMap=100%\nHeightMap=300px\nSimbolPrice=$\nPositionPrice=0\nFormatPrice=0\nSaveContactForm=0\nSaveContactFile=0\nmail_contact=\nSendContactForm=1\nSaveSearchResults=0\nUploadImagesSystem=1\n\n' WHERE #__components.id =".$compid." LIMIT 1 ;";		
		
		$db->setQuery($sql_query);
		if (!$db->queryBatch()){
			echo $db->stderr() . '<br/>';
		}
		
		}
	
	}
	
	function storeconfig($data)
	{	
		global $mainframe;
		$db		= & JFactory::getDBO();
		$row = & JTable::getInstance('component');		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());			
			return false;
		}		
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());						
			return false;
		}		
		if (!$row->store()) {
			$this->setError( $this->_db->getErrorMsg() );			
			return false;
		}
		return true;
	}		
}