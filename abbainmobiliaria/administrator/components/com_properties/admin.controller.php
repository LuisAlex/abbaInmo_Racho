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
jimport('joomla.application.component.controller');
class PropertiesController extends JController
{
	function __construct( $default = array())
		{	
		parent::__construct( $default );
		}
	function display()
		{
		parent::display();
		}	
	function saveconfig()
		{
		$array=JRequest::getVar('params');

		global $mainframe;
		$db		= & JFactory::getDBO();

		$model = $this->getModel('configuration');
		$data = JRequest::get( 'post' );
		if ($model->storeconfig($data)) 
			{
			$this->setRedirect( 'index.php?option=com_properties&view=configuration');
			}
	}
	
	function update_sql() 
		{
		$db =& JFactory::getDBO();
		
        $sql = 'data';
		jimport('joomla.filesystem.file');
		$sql_file = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_properties'.DS. 'updates' . DS . $sql . '.sql';
		$sql_query = JFile::read($sql_file);

		$db->setQuery($sql_query);
		if (!$db->queryBatch()){
			echo $db->stderr() . '<br/>';
		} else {
			$msg = '<table bgcolor="#d9f9e2" width ="100%"><tr style="height:30px"><td>';
			$msg = '<td><b>' . JText::_('SQL EXECUTED SUCESS!') . ' ' . $sql . '</b></font></td></tr></table>';
			echo $msg;
		}
		
        $db->setQuery('SHOW COLUMNS FROM #__properties_category');
        $columns = $db->loadObjectList('Field');		
		
		if(!isset($columns['checked_out']) && !isset($columns['checked_out_time'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `checked_out` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `ordering`, '
                   . 'ADD `checked_out_time` datetime NOT NULL default \'0000-00-00 00:00:00\' AFTER `checked_out` ';
            $db->setQuery($query);
            $db->query();
        }		
		if(!isset($columns['access'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `access` tinyint(3) NOT NULL AFTER `checked_out_time`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['params'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `params` text NOT NULL AFTER `access`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['metadesc'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `metadesc` varchar(1024) NOT NULL AFTER `params`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['metakey'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `metakey` varchar(1024) NOT NULL AFTER `metadesc`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['layout'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `layout` VARCHAR( 100 ) NOT NULL AFTER `metakey`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['cat_currency'])){
            $query = 'ALTER TABLE `#__properties_category` '
                   . 'ADD `cat_currency` INT( 2 ) NOT NULL AFTER `layout`; ';
            $db->setQuery($query);
            $db->query();
        }else{		
		$query = 'ALTER TABLE `#__properties_category` '
                   . 'CHANGE `cat_currency` `cat_currency` INT( 2 ) NOT NULL; ';
            $db->setQuery($query);
            $db->query();
		}
		
		
		$db->setQuery('SHOW COLUMNS FROM #__properties_products');
        $columns = $db->loadObjectList('Field');		
		if(!isset($columns['language'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `language` TINYINT( 1 ) NOT NULL AFTER `checked_out_time`; ';
            $db->setQuery($query);
            $db->query();
        }		
		if(!isset($columns['access'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `access` TINYINT( 3 ) NOT NULL AFTER `language`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['params'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `params` TEXT NOT NULL AFTER `access`; ';
            $db->setQuery($query);
            $db->query();
        }		
		if(!isset($columns['metatitle'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `metatitle` VARCHAR( 255 ) NOT NULL AFTER `params`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['metadesc'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `metadesc` VARCHAR( 1024 ) NOT NULL AFTER `metatitle`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['metakey'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `metakey` VARCHAR( 1024 ) NOT NULL AFTER `metadesc`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['layout'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `layout` VARCHAR( 100 ) NOT NULL AFTER `metakey`; ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['capacity'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `capacity` INT( 2 ) NOT NULL AFTER `years`; ';
            $db->setQuery($query);
            $db->query();
        }		
		if(!isset($columns['currency'])){
            $query = 'ALTER TABLE `#__properties_products` '
                   . 'ADD `currency` INT( 2 ) NOT NULL AFTER `price`; ';
            $db->setQuery($query);
            $db->query();
        }else{
			$query = 'ALTER TABLE `#__properties_products` '
                   . 'CHANGE `currency` `currency` INT( 2 ) NOT NULL; ';
            $db->setQuery($query);
            $db->query();
		}
		
		
		
		
		$db->setQuery('SHOW COLUMNS FROM #__properties_country');
        $columns = $db->loadObjectList('Field');
		if(!isset($columns['checked_out']) && !isset($columns['checked_out_time'])){
            $query = 'ALTER TABLE `#__properties_country` '
                   . 'ADD `checked_out` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `ordering`, '
                   . 'ADD `checked_out_time` datetime NOT NULL default \'0000-00-00 00:00:00\' AFTER `checked_out` ';
            $db->setQuery($query);
            $db->query();
        }
		if(!isset($columns['mid'])){
           $query = 'ALTER TABLE `#__properties_country` '
                   . 'ADD `mid` INT(5) NOT NULL AFTER `published`; ';
            $db->setQuery($query);
            $db->query();
        }
		
		
		
		
		$db->setQuery('SHOW COLUMNS FROM #__properties_profiles');
        $columns = $db->loadObjectList('Field');		
        if(!isset($columns['language'])){
            $query = 'ALTER TABLE `#__properties_profiles` '
					. 'ADD `language` char(7) NOT NULL ';                  
            $db->setQuery($query);
            $db->query();
        }
		
		if(!isset($columns['canaddproperties'])){
            $query = 'ALTER TABLE `#__properties_profiles` '
					. 'ADD `canaddproperties` INT( 3 ) NOT NULL ,'
					. 'ADD `canaddimages` INT( 2 ) NOT NULL';             
            $db->setQuery($query);
            $db->query();
        }
			
		
	}
	
	
	
	
	
	
	function saveconfigdefault()
	{
	$component = JComponentHelper::getComponent( 'com_properties' );
		$compid=$component->id;
	$db =& JFactory::getDBO();
$sql_query = "UPDATE #__components SET `params` ='Listlayout=slide\nWidthList=100%\nWidthThumbs=100\nHeightThumbs=75\nWidthImage=640\nHeightImage=480\nShowImagesSystem=1\nShowOrderBy=0\nShowOrderByDefault=ordering\nShowOrderDefault=ASC\nShowLogoAgent=1\nShowReferenceInList=1\nShowCategoryInList=1\nShowTypeInList=1\nShowCountryInList=1\nShowStateInList=1\nShowLocalityInList=1\nShowAddressInList=1\nShowPriceInList=1\nShowContactLink=1\nShowPriceList=1\nShowMapLink=1\nShowViewPropertiesAgentLink=1\nshowFavorites=1\nThumbsInAccordion=5\nWidthThumbsAccordion=100\nHeightThumbsAccordion=75\nShowFeaturesInList=1\nDetailLayout=0\nActivarTabs=0\nWidthDetail=100%\nShowImagesSystemDetail=1\npretty_photo_style=light_rounded\nWidthThumbsDetail=120\nHeightThumbsDetail=90\nShowRecommendLink=0\nAmountMonthsCalendar=3\nStartYearCalendar=2009\nStartMonthCalendar=\nPeriodOnlyWeeks=0\nPeriodAmount=3\nPeriodStartDay=\nPeriodStartBookings=\nPeriodEndBookings=\nversion=2011-09-12\nuseTranslations=0\nprodMultipleCats=0\ncategoryInUrl=0\nlinkToPropertyView=1\nUseCountryDefault=1\nUseStateDefault=1\nUseLocalityDefault=1\ncantidad_productos=5\nActiveMapa=1\napikey=ABQIAAAAFHktBEXrHnX108wOdzd3aBTupK1kJuoJNBHuh0laPBvYXhjzZxR0qkeXcGC_0Dxf4UMhkR7ZNb04dQ\ndistancia=15\nDefaultLat=30.062438\nDefaultLng=31.248207\nAutoCoord=1\nWidthMap=100%\nHeightMap=300px\nSimbolPrice=$\nPositionPrice=0\nFormatPrice=0\nSaveContactForm=0\nSaveContactFile=0\nmail_contact=\nSendContactForm=1\nSaveSearchResults=0\nUploadImagesSystem=1\n\n' WHERE #__components.id =".$compid." LIMIT 1 ;";		
		//JError::raiseError(500, $sql_query );
		
		$db->setQuery($sql_query);
		if (!$db->queryBatch()){
			echo $db->stderr() . '<br/>';
		}
	}
	
	
	
	function truncatedb()
	{
	$db =& JFactory::getDBO();
	$sqlfile = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_properties'.DS.'updates'.DS.'truncate.sql';	
	//$sqlfile = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_properties'.DS.'updates'.DS.'users_sample_data.sql';
		if( !($buffer = file_get_contents($sqlfile)) )
		{
			echo 'no Done!';require('a');
		}
		

		$queries = $this->splitSql($buffer);
		unset($queries[0]);
		

		foreach ($queries as $query)
		{
			$query = trim($query);
			if ($query != '' && $query {0} != '#')
			{
				$db->setQuery($query);
				
				$db->query() or die($db->getErrorMsg());
//echo $query .'<br />';
				$this->getDBErrors($errors, $db );
			}
		}
		//return count($errors);
		echo 'Done!';
	}
	
	
	
	
	
	
	
	
	
	
	function installsampledata()
	{
	$db =& JFactory::getDBO();
	$sqlfile = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_properties'.DS.'updates'.DS.'properties_sample_data.sql';	
	//$sqlfile = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_properties'.DS.'updates'.DS.'users_sample_data.sql';
		if( !($buffer = file_get_contents($sqlfile)) )
		{
			echo 'no Done!';require('a');
		}
		

		$queries = $this->splitSql($buffer);
		unset($queries[0]);
		

		foreach ($queries as $query)
		{
			$query = trim($query);
			if ($query != '' && $query {0} != '#')
			{
				$db->setQuery($query);
				
				$db->query() or die($db->getErrorMsg());
//echo $query .'<br />';
				$this->getDBErrors($errors, $db );
			}
		}
		//return count($errors);
		echo 'Done!';
	}
	
	
	function splitSql($sql)
	{
		$sql = trim($sql);
		$sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);
		$buffer = array ();
		$ret = array ();
		$in_string = false;

		for ($i = 0; $i < strlen($sql) - 1; $i ++) {
			if ($sql[$i] == ";" && !$in_string)
			{
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i +1);
				$i = 0;
			}

			if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\")
			{
				$in_string = false;
			}
			elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\"))
			{
				$in_string = $sql[$i];
			}
			if (isset ($buffer[1]))
			{
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		if (!empty ($sql))
		{
			$ret[] = $sql;
		}
		return ($ret);
	}
	
	
	function getDBErrors( & $errors, $db )
	{
		if ($db->getErrorNum() > 0)
		{
			$errors[] = array('msg' => $db->getErrorMsg(), 'sql' => $db->_sql);
		}
	}
	
	
	
	function unzip()
	{			
		
	jimport('joomla.filesystem.*');
    jimport('joomla.filesystem.archive');
	
	
	$folder="";
	$pathImages="propertiesSampleDataImages_J15_com-properties_4_basic_20110920.zip";
	$pathUpdate="FILEStoUPLOAD.zip";
	$fullPath = JPATH_SITE.DS.$pathUpdate;
 echo $fullPath;
 
 $pathdir = JPATH_SITE; 

	JArchive::extract($fullPath, $pathdir);
	
		}
	
	function menus()
	{
		global $mainframe;
		$component = JComponentHelper::getComponent( 'com_properties' );
		$compid=$component->id;
		$db 	=& JFactory::getDBO();
		
		$q="INSERT IGNORE INTO #__menu VALUES 
('', 'mainmenu', 'Properties List', 'properties-list', 'index.php?option=com_properties&view=properties', 'component', 1, 0, ".$compid.", 0, 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'titlepage=Properties List\ndescription=Description for Properties List\nkeywords=Keywords, for, Properties, List\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0);
";

		$db->setQuery( $q );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}
		
		$q="SELECT id FROM 	#__menu_types WHERE menutype = 'propertiesHidde'";
		$db->setQuery( $q );
		$id_menu_types = $db->loadResult();
		
		if ($id_menu_types)
			{
			
			$q2= "DELETE FROM #__menu_types WHERE menutype = 'propertiesHidde'";
			$db->setQuery( $q2 );
			if (!$db->query())
				{
				JError::raiseError(500, $db->getErrorMsg() );
				}
			$q3= "DELETE FROM #__menu WHERE menutype = 'propertiesHidde'";
			$db->setQuery( $q3 );
			if (!$db->query())
				{
				JError::raiseError(500, $db->getErrorMsg() );
				}
		
			$msg="Can't duplicate menutype propertiesHidde! I delete this menu and try again." ;
		}	
				
		$qHidde="INSERT IGNORE INTO #__menu_types VALUES ('', 'propertiesHidde', 'propertiesHidde', 'propertiesHidde');";

		$db->setQuery( $qHidde );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}		

		$qHidde="INSERT IGNORE INTO #__menu VALUES 
('', 'propertiesHidde', 'Property', 'property', 'index.php?option=com_properties&view=property&id=0', 'component', 1, 0, ".$compid.", 0, 6, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'page_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0);
";

		$db->setQuery( $qHidde );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}		
		
		$qHidde="INSERT IGNORE INTO #__menu VALUES 
('', 'propertiesHidde', 'Agentlistings', 'agentlistings', 'index.php?option=com_properties&view=agentlistings', 'component', 1, 0, ".$compid.", 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'page_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0);
";
		
		$db->setQuery( $qHidde );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}		
			
	$msg="menus created!" ;			
	$link = 'index.php?option=com_properties';
		$this->setRedirect($link, $msg);		
	}
	
	
	
	
function mapgetcoord()
	{ 	
jimport( 'joomla.application.component.helper' );
JRequest::setVar( 'tmpl', 'component'  );
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$apikey    = $params->get( 'apikey' );
$distancia= $params->get( 'distancia' );
$DefaultLat= $params->get( 'DefaultLat' );
$DefaultLng= $params->get( 'DefaultLng' );
$Pid 		= JRequest::getInt( 'id');
$db 	=& JFactory::getDBO();
$query = 'SELECT p.*,t.name AS name_category '
				. ' FROM #__properties_products AS p '
				. 'LEFT JOIN #__properties_category AS t ON t.id = p.cid '	
				. 'WHERE p.id = '.$Pid ;
$db->setQuery($query);	        
		$Prod = $db->loadObject();



$lat=$Prod->lat!=0 ? $Prod->lat : $DefaultLat;
$lng=$Prod->lng!=0 ? $Prod->lng : $DefaultLng;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
    <title>Google Maps JavaScript API Example</title> 
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $apikey;?>"
      type="text/javascript"></script> 
   
  </head> 
<body style="width: 750px; height: 400px; padding:0px; margin:0px;"> 
<div id="map" style="width: 750px; height: 400px;"></div>  
<form action="" name="formgetcoord" method="post">
<input type="text" id="getlat" name="getlat" value="<?php echo $lat;?>" />
<input type="text" id="getlng" name="getlng" value="<?php echo $lng;?>" />

<button onclick="window.parent.jSelectCoord(document.getElementById('getlat').value,document.getElementById('getlng').value)" value="<?php echo JText::_( 'Add Coord' );?>"><?php echo JText::_( 'Add Coord' );?></button>



</form>  


    <script type="text/javascript"> 

   var map = new GMap2(document.getElementById("map")); 
        map.setCenter(new GLatLng(<?php echo $lat;?>, <?php echo $lng;?>), <?php echo $distancia;?>); 
	<!--map.setMapType(G_HYBRID_MAP); -->
 
	map.addControl(new GSmallMapControl()); 
	/*map.addControl(new GScaleControl()); */
	map.addControl(new GMapTypeControl()); 
/*	map.addControl(new GOverviewMapControl());*/ 
 
	var marker = new GMarker(new GLatLng(<?php echo $lat;?>, <?php echo $lng;?>)); 
	map.addOverlay(marker); 
	
GEvent.addListener(map, 'click', function(overlay, point) {
			if (overlay) {
				map.removeOverlay(overlay);
			} else if (point) {
				/*map.recenterOrPanToLatLng(point);*/
				var marker = new GMarker(point);
				map.addOverlay(marker);
				var matchll = /\(([-.\d]*), ([-.\d]*)/.exec( point );
				if ( matchll ) { 
					var lat = parseFloat( matchll[1] );
					var lon = parseFloat( matchll[2] );
					lat = lat.toFixed(6);
					lon = lon.toFixed(6);
					var message = "lat=" + lat + "<br>lon=" + lon + " "; 
					var messageRoboGEO = lat + ";" + lon + ""; 
				} else { 
					var message = "<b>Error extracting info from</b>:" + point + ""; 
					var messagRoboGEO = message;
				}

				marker.openInfoWindowHtml(message);

				document.getElementById("getlat").value = lat;
				document.getElementById("getlng").value = lon;

			}
		});
		
			/*
document.getElementById("frmLat").value = setLat;
		document.getElementById("frmLon").value = setLon;
        */
        
        
    </script> 
</body> 
</html> 
<?php }

}
?>