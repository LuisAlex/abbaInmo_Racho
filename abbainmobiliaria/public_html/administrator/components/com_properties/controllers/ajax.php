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

class PropertiesControllerAjax extends JController
{ 
    function display()
    {
        parent::display();
    }
	


function ChangeState() {
global $mainframe;
$datos = null;
$db 	=& JFactory::getDBO();
$Country_id = JRequest::getVar('Country_id');
$query = 	"SELECT * from #__properties_state where published = 1 and parent = ".$Country_id;
$db->setQuery( $query );				
$provincias = $db->loadObjectList();
$nP = count($provincias);
$mitems[0]->id=0;
$mitems[0]->name='State';
		foreach ( $provincias as $item ) {
			$mitems[] = $item;
		}
$javascript = 'onChange="ChangeLocality(this.value)"';
$Comboprovincias        = JHTML::_('select.genericlist',   $mitems, 'sid', 'class="inputbox select" size="1" '.$javascript,'id', 'name',  0); 
echo $Comboprovincias;

}


function ChangeLocality() {
global $mainframe;
$datos = null;
$db 	=& JFactory::getDBO();
$State_id = JRequest::getVar('State_id');
$query = 	"SELECT * from #__properties_locality where published = 1 and parent = ".$State_id;
$db->setQuery( $query );				
$ciudades = $db->loadObjectList();
$nP = count($ciudades);
$mitems[0]->id=0;
$mitems[0]->name='Locality';
		foreach ( $ciudades as $item ) {
			$mitems[] = $item;
		}
$javascript = '';
$Combociudades        = JHTML::_('select.genericlist',   $mitems, 'lid', 'class="inputbox select" size="1" '.$javascript,'id', 'name',  0); 
echo $Combociudades;

}

	function ChangeAgent()
	{	
	global $mainframe;
$datos = null;
$db 	=& JFactory::getDBO();
$agent_id = JRequest::getVar('agent_id');

	$query = 	"SELECT * from #__properties_profiles WHERE mid = ".$agent_id;
$db->setQuery( $query );			
$agent = $db->loadObjectList();


echo '<input class="text_area" type="text" name="agent" id="agent" size="20" maxlength="255" value="'.$agent[0]->name.'" /><br>';
echo 'Id: '.$agent[0]->id.' UsrId: '.$agent[0]->mid;
//}

	
	}
	
	
	
function ChangeType() {

global $mainframe;
$datos = null;
$db 	=& JFactory::getDBO();
$Category_id = JRequest::getVar('Category_id');
$query = 	"SELECT * from #__properties_type where published = 1 and parent = ".$Category_id." OR parent = 0";
$db->setQuery( $query );				
$types = $db->loadObjectList();
$nP = count($types);
$mitems[0]->id=0;
$mitems[0]->name='Type';
		foreach ( $types as $item ) {
			$mitems[] = $item;
		}
$javascript = '';
$Combotypes        = JHTML::_('select.genericlist',   $mitems, 'type', 'class="inputbox select" size="1" '.$javascript,'id', 'name',  0); 
echo $Combotypes;

}



}
?>