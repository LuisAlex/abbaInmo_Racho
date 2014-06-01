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
	
function PropertiesBuildRoute( &$query )
{
    $segments = array();	  
	$menu = &JSite::getMenu();
	
	if (empty($query['Itemid'])) {
		$menuItem = &$menu->getActive();		
	} else {
		$menuItemid = &$menu->getItem($query['Itemid']);
	}
 	
	$Mview=$menuItemid->query['view'];	
//echo '<br><b>Mview : '.$Mview.'<br></b>';
	unset( $query['view'] );	
		
		if($Mview=='properties')
			{
			if(isset($query['limitstart']))
       			{	   				
                $segments[] = $query['limitstart'];
                unset( $query['limitstart'] );		
	   			}
			if(isset($query['start']))
       			{	   				
                $segments[] = $query['start'];
                unset( $query['start'] );	
				}	
			
			if(isset($query['id']))
       		{	   				
                $segments[] = $query['id'];
                unset( $query['id'] );				
       		}	
				
			if(isset($query['layout']))
      		 {
              $segments[] = $query['layout'];
           unset( $query['layout'] );
       		}	
				
			
				
				
						
			return $segments;	
			}
			
		
		if($Mview=='state')
			{
			unset( $query['sid'] );
			}
		if($Mview=='locality')
			{
			unset( $query['lid'] );
			}
			
		if($Mview=='location')
			{
			if(isset($query['cyid']))
       			{
                $segments[] = $query['cyid'];
                unset( $query['cyid'] );
       			}	
			if(isset($query['sid']))
       			{
                $segments[] = $query['sid'];
                unset( $query['sid'] );
       			}		
			if(isset($query['lid']))
       			{
                $segments[] = $query['lid'];
                unset( $query['lid'] );
       			}		
			if(isset($query['task']))
       			{
                $segments[] = $query['task'];
                unset( $query['task'] );
       			}	
			if(isset($query['id']))
       			{
                $segments[] = $query['id'];
                unset( $query['id'] );
       			}		
				
			if(isset($query['start']))
       			{	   				
                $segments[] = $query['start'];
                unset( $query['start'] );	
				}	   
	  		if(isset($query['limitstart']))
       			{	   				
                $segments[] = $query['limitstart'];
                unset( $query['limitstart'] );		
	   			}	
			return $segments;	
				
						
			}	

	if(isset($query['cid']))
       {
                $segments[] = $query['cid'];
                unset( $query['cid'] );
       }
	  
	if(isset($query['tid']))
       {
                $segments[] = $query['tid'];
                unset( $query['tid'] );
       }	 
	      
	if(isset($query['id']))
       {	   				
                $segments[] = $query['id'];
                unset( $query['id'] );				
       }
	if(isset($query['aid']))
       {	   				
                $segments[] = $query['aid'];
                unset( $query['aid'] );				
       }   
	if(isset($query['layout']))
       {
              $segments[] = $query['layout'];
           unset( $query['layout'] );
       }
						 		
	if(isset($query['format']))
       {	   				
         /*          $segments[] = $query['start'];*/
                unset( $query['format'] );	
		}
	
	   if(isset($query['start']))
       {	   				
                $segments[] = $query['start'];
                unset( $query['start'] );	
		}
	   
	  if(isset($query['limitstart']))
       {	   				
                $segments[] = $query['limitstart'];
                unset( $query['limitstart'] );	
		
	   }
/* 
print_r($segments);
*/
 
	   
       return $segments;
}


function PropertiesParseRoute( $segments)
{	
	global $mainframe;
	$config	= new JConfig();
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
			
	//$paramsModule = $params;
	$categoryInUrl=$params->get('categoryInUrl');	
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();   	
    $vars = array();	   
	$count = count( $segments );
	$menuItemid = $item->id;
	$Mview=$item->query['view'];


	switch($item->query['view'])
		{
		case 'property':		
				$vars['view'] = $Mview;
				
			if(($item->query['id']) == 0)
				{				
				
					$alias = str_replace(':', '-',$segments[0]);								
				
				if(isset($segments[1]))
					{					
					switch($segments[1])
						{
						case 'contact' : case 'pricelist' : case 'map' : case 'print' :	case 'recommend' :	
							$vars['layout'] = $segments[1];
							$vars['id']	= str_replace(':', '-',$segments[0]);	
						break;
						default :							
							$vars['id']	= str_replace(':', '-',$segments[0]);	
						break;
						}											
					}else{
						$vars['id']	= $alias;	
					}						
				}else{
								
				}				  				 
		break;
								
		case 'properties':
			$vars['view'] = 'properties';
			if(isset($segments[0]))
				{
				if(is_numeric($segments[0]))
					{
					$vars['limitstart'] = $segments[0];
					}else{
					
					$alias = str_replace(':', '-',$segments[0]);
					
					if(isset($segments[1]))
					{					
					switch($segments[1])
						{
						case 'contact' : case 'pricelist' : case 'map' : case 'print' :	case 'recommend' :	
							$vars['layout'] = $segments[1];
							$vars['id']	= str_replace(':', '-',$segments[0]);	
						break;
						default :							
							$vars['id']	= str_replace(':', '-',$segments[0]);	
						break;
						}											
					}else{
						$vars['id']	= $alias;	
					}	
					
					
					}
				}			
						
		break;
		case 'favorites':
			$vars['view'] = 'favorites';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'status':
			$vars['view'] = 'status';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'category':
			$vars['view'] = 'category';
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}
								
		break;	
		case 'type':
			$vars['view'] = 'type';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'country':
			$vars['view'] = 'country';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'state':
			$vars['view'] = 'state';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'locality':
			$vars['view'] = 'locality';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'region':
			$vars['view'] = 'region';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'selection':
			$vars['view'] = 'selection';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['id'] = $segments[0];	
				}						
		break;
		case 'location':
			$vars['view'] = 'location';
			
			if(is_numeric($segments[$count - 1]))
				{
				$vars['limitstart'] = $segments[$count - 1];
				unset( $segments[$count - 1] );	
				}
				
			switch(count($segments))
				{
				case 1 :
				$vars['cyid'] = $segments[0];
				break;
				case 2 :
				$vars['cyid'] = $segments[0];
				$vars['sid'] = $segments[1];
				break;
				case 3 :
				$vars['cyid'] = $segments[0];
				$vars['sid'] = $segments[1];
				$vars['lid'] = $segments[2];
				break;
				case 4 :
				$vars['cyid'] = $segments[0];
				$vars['sid'] = $segments[1];
				$vars['lid'] = $segments[2];				
				$vars['id'] = $segments[3];
				break;
				}				
		break;		
			
			
			
			
		case 'panel':		
			$vars['view'] = 'panel';				
			$vars['id']	= $segments[0];							
			$vars['layout'] = $segments[1];													  				 
		break;
		
		case 'agents':
			$vars['view'] = 'agents';			
			if(is_numeric($segments[0]))
				{
				$vars['limitstart'] = $segments[0];	
				}else{
				$vars['aid'] = $segments[0];	
				}						
		break;
		
		case 'agentlistings':
			$vars['view'] = 'agentlistings';
			$vars['aid'] = $segments[0];
			if(isset($segments[1]))
				{
				$vars['limitstart'] = $segments[1];		
				}
				
								
		break;
				
		default:				
		break;                                      
       }	 
	   

	   
/*  
print_r($segments);
print_r($vars);
echo '<br>itemId: '. $menuItemid;
 */
       return $vars;
}

	function getProductId($alias)
		{
		$component = JComponentHelper::getComponent( 'com_properties' );
		$params = new JParameter( $component->params );
		$useTranslations=$params->get('useTranslations','0');
		
		$db = JFactory::getDBO();
		if($useTranslations222)
			{
			$query = 'SELECT p.id FROM #__properties_products as p '.		
			' LEFT JOIN #__properties_products_translations AS pt ON pt.pt_pid = p.id '.		
			' WHERE alias = '.$db->Quote($alias)		
			.' OR pt_alias = '.$db->Quote($alias)		
			;
			}else{
			$query = 'SELECT p.* FROM #__properties_products as p '				
			.' WHERE alias = '.$db->Quote($alias)		
			;
			}
			$db->setQuery($query);
			$product = $db->loadObject();
			//print_r($product);
			
				echo $query;
				//require('a');
				
				
		return $product->id;
		}