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

class Tableavailable_product extends JTable
{    
var $id = null;
var $id_product = null;
var $date = null;
var $available = null;
var $published = null;
   function __construct(&$db)
  {
    parent::__construct( '#__properties_available_product', 'id', $db );
  }  
}
?>