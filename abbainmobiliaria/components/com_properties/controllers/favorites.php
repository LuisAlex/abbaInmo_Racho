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

class PropertiesControllerFavorites extends JController
{	
		
	function addToFavorites()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );	
	$post = JRequest::get( 'post' );				
	$pid = JRequest::getInt('pid', 0, 'post');
	$session =& JFactory::getSession();	
	if($pid)
		{
		$favorites = $session->get('favorites', array(), 'com_properties');
		$favorites[$pid] = $pid;
		//$favorites = '';
		$session->set('favorites', $favorites, 'com_properties');		
	}
	$link = LinkHelper::getLink('favorites');
	
		echo '<a class="ListButtonsLink" href="'.$link.'">'.JText::_('In Favorites').'</a>';
	}
	
	
	function removeFavorites()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );	
	$post = JRequest::get( 'post' );				
	$pid = JRequest::getInt('pid', 0, 'post');	
	$session =& JFactory::getSession();	
	if($pid)
		{
		$favorites = $session->get('favorites', array(), 'com_properties');
		unset($favorites[$pid]);
		$session->set('favorites', $favorites, 'com_properties');		
	}
	
		echo JText::_('Favorite Deleted');
	}
	
	
}
?>