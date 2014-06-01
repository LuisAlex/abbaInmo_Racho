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
JRequest::setVar('tmpl','component');

$document =& JFactory::getDocument();
$this->lang =& JFactory::getLanguage();
$user =& JFactory::getUser();
$Product=$this->Product;
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );

$apikey=$params->get('apikey');
$distancia=$params->get('distancia');
$lat = $Product->lat;
$lng = $Product->lng;
$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
?>

<script src="http://www.google.com/jsapi"></script>	

    <script type="text/javascript">
      google.load('maps', '3', {
        other_params: 'sensor=false&language=<?php echo $thisLang;?>'
      });
      google.setOnLoadCallback(initialize);	 
  
  function initialize() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: <?php echo $distancia;?>,
          center: new google.maps.LatLng(<?php echo $lat;?>, <?php echo $lng;?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });        
		
		base_Icon = "<?php echo JURI::base();?>components/com_properties/includes/img/house.png";		
		shadow_Icon = "<?php echo JURI::base();?>components/com_properties/includes/img/house-shadow.png";
	  
		var myLatlng = new google.maps.LatLng(<?php echo $lat;?>, <?php echo $lng;?>);
		var marker = new google.maps.Marker({
     	position: myLatlng, 
     	map: map,	
		shadow: shadow_Icon,
	 	icon: base_Icon 
		});
		
      }

</script> 

<div id="map" style="width: 730px; height: 470px;margin:0px;padding:0px;">
</div>

<div style="clear: both;"></div>

<?php

