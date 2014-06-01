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

class Tableimages extends JTable
{    
	var $id = null;
	var $name = null;	
	var $parent = null;
	var $published = null;
	var $ordering = null;
	var $type = null;
	var $path = null;
	var $rout = null;	
	var $date = null;
	var $uid = null;
	var $product_id = null;	
	var $sector = null;
	var $text = null;
   function __construct(&$db)
  {
    parent::__construct( '#__properties_images', 'id', $db );
  }
  
 
}
?>