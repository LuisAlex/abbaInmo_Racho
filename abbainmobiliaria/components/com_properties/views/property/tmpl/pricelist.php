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
global $mainframe;
JRequest::setVar('tmpl','component');
$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/pricelist.css" type="text/css" media="screen"  />');
$document =& JFactory::getDocument();
$this->lang =& JFactory::getLanguage();
$user =& JFactory::getUser();
$Product=$this->Product;
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$rates = $this->Rates;
//	print_r($rates);
?>

<div style="padding:10px;">
	<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Price List' ); ?></legend>	
    <table class="rateslist" border="0" cellpadding="0" cellspacing="2">
    <tr>    
    <td class="title"><?php echo JText::_( 'From' ); ?></td>
    <td class="title"><?php echo JText::_( 'To' ); ?></td>  
    <td class="title"><?php echo JText::_( 'Price' ); ?></td>
    </tr>    
    <?php
	foreach($rates as $rate)
	{
				echo '<tr>';
				echo '<td class="period">'.JHTML::_('date',$rate->validfrom, JText::_('DATE_FORMAT_LC3')).'</td>';
				echo '<td class="period">'.JHTML::_('date',$rate->validto, JText::_('DATE_FORMAT_LC3')).'</td>';
				echo '<td align="center"><div style="width:50px;"><div style="float:left;width:50%">'.$SimbolPrice.'</div> <div style="float:right;width:50%;text-align:right;">'.$rate->rateperday.'</div></div></td>';
				echo '</tr>';
	}
	?>
    </table>
    </fieldset>
</div>