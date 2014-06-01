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

jimport( 'joomla.application.component.view' );

class PropertiesViewPanel extends JView
{	
	function display($tpl = null)
	{
	$option = JRequest::getVar('option');
	JToolBarHelper::title(JText::_('Panel'), 'panel.png');
	jimport('joomla.html.pane');
	$pane	=& JPane::getInstance('sliders');
	$version = $this->get('Config');
	
		parent::display( $tpl );		
	}	
	
	function getTotals($TableName)
		{
		$db = & JFactory::getDBO();
		$query = 'SELECT COUNT(*) FROM #__properties_'.$TableName;
		$db->setQuery( $query );
		$result = $db->loadResult();		
        return $result;       
		}
		
	function getItemid( $TableName )
		{
		$db =& JFactory::getDBO();	
		switch($TableName)
			{
			case 'property' :
			$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view=property&id=0"';
			break;
			default :
			$query = 'SELECT id FROM #__menu' .
				' WHERE link = "index.php?option=com_properties&view='.$TableName.'"';
			break;			
			}
				
		$db->setQuery( $query );
		$result = $db->loadResult();
		
		
				
        return $result;
		}
			
	function addIcon( $image , $view, $text )
	{
		$lang		=& JFactory::getLanguage();
		$link		= 'index.php?option=com_properties&view='.$view.'';
?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $link; ?>">
					<?php echo JHTML::_('image', 'administrator/components/com_properties/includes/img/' . $image , NULL, NULL, $text ); ?>
					<span><?php echo $text; ?></span></a>
			</div>
		</div>
<?php
	}
	
	
	
}