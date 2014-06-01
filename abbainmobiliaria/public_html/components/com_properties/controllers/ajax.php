<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class PropertiesControllerAjax extends JController
{ 
    function display()
    {
        parent::display();
    }		
		
	function ChangeState() 
		{
		if(JRequest::getInt('Country_id')!='')
			{
			global $mainframe;
			$datos = null;
			$db 	=& JFactory::getDBO();
			$Country_id = JRequest::getInt('Country_id');
			$query = 	"SELECT * from #__properties_state where published = 1 and parent = ".$Country_id." ORDER BY name ASC";
			$db->setQuery( $query );				
			$States = $db->loadObjectList();			
			$mitems[0]->id='';
			$mitems[0]->name='State';
					foreach ( $States as $item ) 
					{
						$mitems[] = $item;
					}
			$javascript = 'onChange="ChangeLocality(this.value)"';
			$ComboStates        = JHTML::_('select.genericlist',   $mitems, 'sid', 'class="inputbox required select" size="1" '.$javascript,'id', 'name',  0); 
			echo $ComboStates;
			}
		}

	function ChangeLocality() 
		{
			$component = JComponentHelper::getComponent( 'com_properties' );
			$params = new JParameter( $component->params );			
			if(JRequest::getInt('State_id')!='')
			{
			global $mainframe;
			$datos = null;
			$db 	=& JFactory::getDBO();
			$State_id = JRequest::getInt('State_id');			
			$query = 	"SELECT * from #__properties_locality where published = 1 and parent = ".$State_id." ORDER BY name ASC";
			$db->setQuery( $query );				
			$Localities = $db->loadObjectList();			
					foreach ( $Localities as $item ) 
					{
						$mitems[] = $item;
					}
			$javascript = '';
			$ComboLocalities        = JHTML::_('select.genericlist',   $mitems, 'lid', 'class="inputbox required select" size="1" '.$javascript,'id', 'name',  $last); 
			echo $ComboLocalities;
			}
		}

		function ChangeType() 
			{
			global $mainframe;
			$datos = null;
			$db 	=& JFactory::getDBO();
			$Category_id = JRequest::getInt('Category_id');
			$query = 	"SELECT * from #__properties_type where published = 1 and parent = ".$Category_id." OR parent = 0";
			$db->setQuery( $query );				
			$types = $db->loadObjectList();			
					foreach ( $types as $item ) 
					{
						$mitems[] = $item;
					}
			$javascript = '';
			$Combotypes        = JHTML::_('select.genericlist',   $mitems, 'type', 'class="inputbox required select" size="1" '.$javascript,'id', 'name',  0); 
			echo $Combotypes;
			}
		}
?>