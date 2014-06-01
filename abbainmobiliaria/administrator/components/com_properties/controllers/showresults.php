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

jimport('joomla.application.component.controller');
class PropertiesControllerShowresults extends JController
{
	function __construct()
	{
		parent::__construct();
		
	
		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));

		
		
	}	

	
	/** remove record(s)	 */
	function remove()
	{
	$option = JRequest::getVar('option');	
		$model = $this->getModel('showresults');
		if(!$model->delete()) {
		
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
			
		} else {
		
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {
			$msg .= JText::_( 'deleted showresults : '.$cid );			
}
		
		}

		$this->setRedirect( 'index.php?option='.$option.'&view=showresults', $msg );
	}




}