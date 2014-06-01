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
global $mainframe;
JHTML::_('behavior.tooltip'); 
JHTML::_('behavior.formvalidation');
jimport('joomla.filesystem.file');
$document =& JFactory::getDocument();
$lang =& JFactory::getLanguage();
$user =& JFactory::getUser();
$menus = &JSite::getMenu();
		$menu  = $menus->getActive();
		$menu_params = new JParameter( $menu->params );
		if($menu_params->get('show_page_title') & $menu_params->get('page_title')){
		$title=$menu_params->get('page_title');
		$Mkey.=' '.$title;
		}else{
		$title 		= $mainframe->getCfg( 'sitename' );	
		$Mkey.=' '.$title;
		}		
	$row=$this->Product;
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$AnchoMiniatura=$params->get('AnchoMiniatura');
$AltoMiniatura=$params->get('AltoMiniatura');
$ActivarDescripcion=$params->get('ActivarDescripcion');
$ActivarDetails=$params->get('ActivarDetails');
$ActivarContactar=$params->get('ActivarContactar');
$ActivarReservas=$params->get('ActivarReservas');
$ActivarMapa=$params->get('ActivarMapa');
$ActivarTabs=$params->get('ActivarTabs');
$ActivarVideo=$params->get('ActivarVideo');
$ActivarPanoramica=$params->get('ActivarPanoramica');
$SimbolPrice=$params->get('SimbolPrice');
$PositionPrice=$params->get('PositionPrice');
$currencyformat=$params->get('FormatPrice');
$ShowImagesSystem=$params->get('ShowImagesSystem');
$showComments=$params->get('showComments');
$ShowVoteRating=$params->get('ShowVoteRating');
$md_country=$params->get('md_country');
$md_state=$params->get('md_state');
$md_locality=$params->get('md_locality');
$md_category=$params->get('md_category');
$md_type=$params->get('md_type');


$WidthThumbs=$params->get('WidthThumbs');
$HeightThumbs=$params->get('HeightThumbs');

$WidthThumbsAccordion=$params->get('WidthThumbsAccordion');
$HeightThumbsAccordion=$params->get('HeightThumbsAccordion');
$ThumbsInAccordion=$params->get('ThumbsInAccordion');
$UseCountry=$params->get('UseCountry');
$UseState=$params->get('UseState');
$UseLocality=$params->get('UseLocality');
$ShowReferenceInList=$params->get('ShowReferenceInList');
$ShowLogoAgent=$params->get('ShowLogoAgent');
$ShowCategoryInList=$params->get('ShowCategoryInList');
$ShowTypeInList=$params->get('ShowTypeInList');

$ShowFeaturesInList=$params->get('ShowFeaturesInList');

$useComment2=$params->get('useComment2');
$useComment3=$params->get('useComment3');
$useComment4=$params->get('useComment4');
$useComment5=$params->get('useComment5');

$AmountMonthsCalendar=$params->get('AmountMonthsCalendar');
$PeriodOnlyWeeks=$params->get('PeriodOnlyWeeks');
$PeriodAmount=$params->get('PeriodAmount');
$PeriodStartDay=$params->get('PeriodStartDay');


	if($md_country){
		$title.=$row->name_country;
		$Mkey.=', '.$row->name_country;
	}

	if($md_state){
		$title.=' - '.$row->name_state;
		$Mkey.=', '.$row->name_state;
	}

	if($md_locality){
		$title.=' - '.$row->name_locality;
		$Mkey.=', '.$row->name_locality;
	}

	if($md_category){
		$title.=' - '.$row->name_category;
		$Mkey.=', '.$row->name_category;
	}

	if($md_type){
		$title.=' - '.$row->name_type;
		$Mkey.=', '.$row->name_type;
	}

$title.=' - '.$row->name;

$document->setTitle( $title );
$document->setMetadata('keywords',$Mkey);
$document->setDescription( $title.'.'.substr($row->description,0,200));


if(!JRequest::getVar('Itemid')){$Itemid = 0;}else{$Itemid = JRequest::getVar('Itemid');}

$view = JRequest::getVar('view');

$id = JRequest::getVar('id');
$cid = JRequest::getVar('cid', 0, '', 'int');
$tid = JRequest::getVar('tid', 0, '', 'int');

//echo 'cid: '.$cid.' tid: '.$tid.' id: '.$id.' view: '.$view.'<br>';

//echo $row->refresh_time;
//echo date('j F Y', strtotime($row->refresh_time));



if($ShowVoteRating){
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'vote.php' );
echo VoteHelper::Header();
}















?>

