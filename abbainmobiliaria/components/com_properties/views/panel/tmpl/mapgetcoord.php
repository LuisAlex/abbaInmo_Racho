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
	$user =& JFactory::getUser();
	$query = 'SELECT p.*,t.name AS name_category '
				. ' FROM #__properties_products AS p '
				. 'LEFT JOIN #__properties_category AS t ON t.id = p.cid '	
				. 'WHERE p.id = '.$Pid 
				. ' AND p.agent_id = '.$user->id;
		$db->setQuery($query);	        
		$Prod = $db->loadObject();
if($Prod)
	{
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
<?php 
	}
	?>