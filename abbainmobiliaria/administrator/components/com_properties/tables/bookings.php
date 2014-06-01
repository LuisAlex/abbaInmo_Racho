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

class Tablebookings extends JTable
{    
var $ob_id_order = null;
var $ob_id_property = null;
var $ob_name = null;
var $ob_address = null;
var $ob_postcode = null;
var $ob_city = null;
var $ob_state = null;
var $ob_country = null;
var $ob_phone = null;
var $ob_text = null;
var $ob_mail = null;
var $ob_created = null;
var $ob_from = null;
var $ob_to = null;
var $ob_price = null;
var $ob_adults = null;
var $ob_boys = null;
var $ob_babies = null;
var $ob_deposit = null;
var $ob_deposit_amount = null;
var $ob_confirmed = null;
var $ob_confirmed_date = null;
var $ob_confirmed_by = null;
var $ob_send_mail = null;
var $ob_text_mail = null;
var $ob_language = null;
var $ob_contract_name = null;
var $ob_contract_send = null;

   function __construct(&$db)
  {
    parent::__construct( '#__properties_bookings', 'ob_id_order', $db );
  }
  
  
}
?>





