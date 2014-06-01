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
?>  
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" id="josForm2" name="josForm2" class="form-validate">
<input type="hidden" name="popup" value="" />
<?php
	$listorderby = $this->params->get('ShowOrderBy');
	
	$session =& JFactory::getSession();		
	$listorderby = $session->get('listorderby', '', 'com_properties');
	echo JText::_('Order by').' '; 

		$limits = array ();
		//$limits[] = JHTML::_('select.option', '0',JText::_('Featured'));
		$limits[] = JHTML::_('select.option', '1:ASC',JText::_('Price').' '.JText::_('ORDERBY_ASC'));
		$limits[] = JHTML::_('select.option', '1:DESC',JText::_('Price').' '.JText::_('ORDERBY_DESC'));
		$limits[] = JHTML::_('select.option', '2:ASC',JText::_('Category').' '.JText::_('ORDERBY_ASC'));
		$limits[] = JHTML::_('select.option', '2:DESC',JText::_('Category').' '.JText::_('ORDERBY_DESC'));
		$limits[] = JHTML::_('select.option', '3:ASC',JText::_('Type').' '.JText::_('ORDERBY_ASC'));
		$limits[] = JHTML::_('select.option', '3:DESC',JText::_('Type').' '.JText::_('ORDERBY_DESC'));

		// Build the select list
		$javascript='onchange="submit();"';
$html = JHTML::_('select.genericlist',  $limits, 'listorderby',$javascript.' class="inputbox" size="1" ', 'value', 'text', $listorderby);

		echo $html;
					
	$u =& JFactory::getURI();
	?>    
    <input type="hidden" name="return" value="<?php echo $u->_uri;?>" />    
    <input type="hidden" name="option" value="com_properties" />     
	<input type="hidden" name="task" value="listorderby" />   
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>

