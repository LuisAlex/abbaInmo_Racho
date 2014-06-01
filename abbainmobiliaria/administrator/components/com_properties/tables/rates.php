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

class Tablerates extends JTable
{    
var $id = null;
var $title = null;
var $description = null;
var $validfrom = null;
var $validto = null;
var $rateperday = null;
var $rateperweek = null;
var $weekonly = null;
var $productid = null;
var $published = null;
var $ordering = null;

   function __construct(&$db)
  {
    parent::__construct( '#__properties_rates', 'id', $db );
  }
    
}
?>