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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
class PropertiesController extends JController
{
function __construct()
	{
		parent::__construct();
	}		
	
	function display()
	{
		$document =& JFactory::getDocument();
		$viewName	= JRequest::getVar('view');
		$viewType	= $document->getType();
		$views = array();
		$views[]='favorites';
		$views[]='status';
		$views[]='location';
		$views[]='category';
		$views[]='type';		
		$views[]='country';
		$views[]='state';
		$views[]='locality';
		$views[]='region';
		$views[]='selection';
		//$views[]='agentlistings';
		if(in_array($viewName,$views))
		{
		$view = &$this->getView($viewName, $viewType);
		
			$modelList	= &$this->getModel( 'propertieslist' );
			
			$view->setModel( $modelList , true );
			
			$view->display();
		}else{
		parent::display();
		}		
	}
	
	function listorderby()
	{
	global $mainframe,$option;
	JRequest::checkToken() or jexit( 'Invalid Token' );	
	$msg='';
	$session =& JFactory::getSession();
	$post = JRequest::get( 'post' );
	$listorderby = JRequest::getString( 'listorderby','','post' );
	if($listorderby)
		{
		$setOrder=explode(':',$listorderby);
		}	
	$orderDir=$setOrder[1];
	switch($setOrder[0])
		{
		case 1 : 
		$orderby='p.price';		
		break;
		case 2 : 		
		$orderby='c.name';		
		break;		
		case 3 : 
		$orderby='t.name';		
		break;		
		default :
		$orderby='';
		$orderDir='';
		break;
		}
	
	$session->set('listorderby', $listorderby, 'com_properties');
	$mainframe->setUserState( "$option.filter_order",$orderby);
	$mainframe->setUserState( "$option.filter_order_Dir",$orderDir);
	$link =  JRequest::getVar( 'return','','post' );
	$this->setRedirect($link, $msg);
	}
	
	

}
