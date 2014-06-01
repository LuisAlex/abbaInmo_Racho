<?php defined('_JEXEC') or die('Restricted access'); // no direct access 
/*
    * ROADMAP displays the normal, default 2D tiles of Google Maps.
    * SATELLITE displays photographic tiles.
    * HYBRID displays a mix of photographic tiles and a tile layer for prominent features (roads, city names).
    * TERRAIN displays physical relief tiles for displaying elevation and water features (mountains, rivers, etc.).

*/
?>
    
<script src="http://www.google.com/jsapi"></script>	

    <script type="text/javascript">
      google.load('maps', '3', {
        other_params: 'sensor=false'
      });
      google.setOnLoadCallback(initialize);
      var map = null;	  
      function refreshMap() {        
        var markers = [];
		var htmls = [];       		
<?php
echo 'var ptooltip=new Array();';
echo 'var showhtml=new Array();';
if($items)
	{
$p=0;
foreach ($items as $item) 
{ 
$item->name=str_replace("'","\'",$item->name);
echo "\n"."ptooltip[".$p."]=new Array( '".$item->id."','".$item->ref."','".$item->name."','".$link."');"."\n";

$link = LinkHelper::getModuleLinkProperty($item->id,$item->alias);
	
/*property details*/
if($item->imagename!=NULL){ $img=$item->imagename;}else{$img='noimage.jpg';}
$myHtml='';
$myHtml.='<div id="propertydetail"><div class="title"><a href="'. $link.'" title="'.str_replace('"',' ',$item->name).'">'.$item->name.'</a></div><div class="image"><img src="images/properties/images/thumbs/'.$item->id.'/'.$img.'" alt="'.str_replace('"',' ',$item->name).'" width="100" height="75"></div><div class="text">';	
 if ($item->name_type) { 
$myHtml.=JText::_($item->name_type).'<br />';
} 
if ($item->name_category) { 
$myHtml.=JText::_($item->name_category).'<br />';
}  
if ($item->name_locality) { 
$myHtml.=JText::_($item->name_locality).'<br />';
} 
if ($item->address) {
$myHtml.=JText::_($item->address).'<br />';
}
$myHtml.='</div>';
$myHtml.='<div class="property_button">';
$myHtml.='<a class="BottomlnkDetail" href="'.$link.'" title="'.$item->id.'">Detalles</a>';
$myHtml.='</div>';
$myHtml.='</div>';
$htmls[$p]=$myHtml;
echo "\n"."showhtml[".$p."]='".$myHtml."';"."\n";
$myHtml='';
/*end property details*/
$p++;
}
	}
?>

base_Icon = '<?php echo JURI::base();?>modules/mod_prop_googlemap/img/house.png';	
shadow_Icon = '<?php echo JURI::base();?>modules/mod_prop_googlemap/img/house-shadow.png';
	
<?php	
if($items)
	{
	$x=0;
	foreach ($items as $item) 
		{ 	
		?>
		addMarkerNew(<?php echo $item->lat;?>,<?php echo $item->lng;?>,<?php echo $item->type;?>,'<?php echo $item->name;?>',<?php echo $x;?>);
		<?php	
		$x++;
		}	
	}	
?>	

function addMarkerNew(m_lat, m_lng, m_type, m_name, m_x ) 
	{
	var myLatlng = new google.maps.LatLng(m_lat,m_lng);
var marker = new google.maps.Marker({
      position: myLatlng, 
      map: map,	
	  shadow: shadow_Icon,
	  icon: base_Icon 
  });	
  marker.setTitle(m_name);
  attachSecretMessage(marker, m_x);
  markers.push(marker);
	}	
	
	function attachSecretMessage(marker, number) {  
  var infowindow = new google.maps.InfoWindow(
      { content: showhtml[number],
	 /* disableAutoPan: true,*/
        size: new google.maps.Size(50,50)
      });
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
	/*showInContentWindow(showhtml[number]);*/
  });
  
  }		
        
      }

      function initialize() {
        map = new google.maps.Map(document.getElementById('mapaa'), {
          zoom: <?php echo $MapDistance;?>,
          center: new google.maps.LatLng(<?php echo $DefaultLat;?>, <?php echo $DefaultLng;?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        refreshMap();
      }
    </script>
<div id="map-container"><div id="mapaa"></div></div>