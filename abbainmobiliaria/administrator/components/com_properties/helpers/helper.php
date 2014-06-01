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

class Helper
{	

	function Destacado( &$row, $i,  $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='' )
	{
		//$i=$row->id;
		$img 	= $row->featured ? $imgY : $imgX;
		$task 	= $row->featured ? 'nodestacado' : 'destacado';
		$alt 	= $row->featured ? JText::_( 'destacado' ) : JText::_( 'nodestacado' );
		$action = $row->featured ? JText::_( 'nodestacado' ) : JText::_( 'destacado' );

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">
		<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
		;

		return $href;
	}	
	
	function Show( &$row, $i,  $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='' )
	{
		//$i=$row->id;
		$img 	= $row->show ? $imgY : $imgX;
		$task 	= $row->show ? 'unshow' : 'show';
		$alt 	= $row->show ? JText::_( 'Show' ) : JText::_( 'Unshow' );
		$action = $row->show ? JText::_( 'Unshow' ) : JText::_( 'Show' );

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">
		<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
		;

		return $href;
	}		
	
	
	function Published( &$row, $i, $imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='' )
	{
		
		switch($row->published)
			{
			case 1 : $imgsrc = '<img src="images/'. $imgY .'" border="0" alt="'. JText::_( 'Published' ) .'" />' ;	
				$task 	= 'unpublish';	
				$action = JText::_( 'Unpublish Item' );	
			break;
			case 0 : $imgsrc = '<img src="images/'. $imgX .'" border="0" alt="'. JText::_( 'Unpublished' ) .'" />' ;
				$task 	= 'publish';	
				$action = JText::_( 'Publish item' );		
			break;			
			case -2 : $imgsrc = '<img src="components/com_properties/includes/img/icon-16-trash.png" border="0" alt="'. JText::_( 'Trashed' ) .'" />' ;	 ;	
				$task 	= 'publish';	
				$action = JText::_( 'Publish item' );	
			break;
			}
		

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">
		'. $imgsrc .'</a>'
		;

		return $href;
	}
	
		
}