-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 14-09-2011 a las 10:01:34
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `com-property_20110914`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `jos_components`
-- 

CREATE TABLE `jos_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- 
-- Volcar la base de datos para la tabla `jos_components`
-- 

INSERT INTO `jos_components` VALUES 
(34, 'Properties', 'option=com_properties', 0, 0, 'option=com_properties', 'Properties', 'com_properties', 0, 'components/com_properties/includes/img/menu_properties.png', 0, 'Listlayout=default\nWidthList=100%\nWidthThumbs=100\nHeightThumbs=75\nWidthImage=640\nHeightImage=480\nShowImagesSystem=1\nShowOrderBy=0\nShowOrderByDefault=ordering\nShowOrderDefault=ASC\nShowLogoAgent=1\nShowReferenceInList=1\nShowCategoryInList=1\nShowTypeInList=1\nShowCountryInList=1\nShowStateInList=1\nShowLocalityInList=1\nShowAddressInList=1\nShowPriceInList=1\nShowContactLink=1\nShowPriceList=1\nShowMapLink=1\nShowViewPropertiesAgentLink=1\nshowFavorites=1\nThumbsInAccordion=5\nWidthThumbsAccordion=100\nHeightThumbsAccordion=75\nShowFeaturesInList=1\nDetailLayout=0\nActivarTabs=0\nWidthDetail=100%\nShowImagesSystemDetail=1\npretty_photo_style=light_rounded\nWidthThumbsDetail=120\nHeightThumbsDetail=90\nShowRecommendLink=0\nAmountMonthsCalendar=3\nStartYearCalendar=2009\nStartMonthCalendar=\nPeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=\nPeriodStartBookings=\nPeriodEndBookings=\nversion=2011-09-12\nuseTranslations=0\nprodMultipleCats=0\ncategoryInUrl=0\nlinkToPropertyView=1\nUseCountryDefault=1\nUseStateDefault=1\nUseLocalityDefault=1\ncantidad_productos=5\nActiveMapa=1\napikey=ABQIAAAAFHktBEXrHnX108wOdzd3aBTupK1kJuoJNBHuh0laPBvYXhjzZxR0qkeXcGC_0Dxf4UMhkR7ZNb04dQ\ndistancia=15\nDefaultLat=30.062438\nDefaultLng=31.248207\nAutoCoord=1\nWidthMap=100%\nHeightMap=300px\nSimbolPrice=$\nPositionPrice=0\nFormatPrice=0\nSaveContactForm=0\nSaveContactFile=0\nmail_contact=\nSendContactForm=1\nSaveSearchResults=0\nUploadImagesSystem=1\n\n', 1);
