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

class PropertiesControllerAvailables extends JController
{	 
	
function __construct()
	{
		parent::__construct();		
		$this->registerTask( 'FromToUna', 	'FromToA');	
	}		
	
	function FromToA()
	{
	$db 	=& JFactory::getDBO();
	$model = $this->getModel('availables');
	$id		= JRequest::getVar( 'id' );
	$from		= JRequest::getVar( 'from' );
	$to		= JRequest::getVar( 'to' );	
	
	$task=JRequest::getVar( 'task' );
	$this->publish	= ( $task == 'FromToA' ? 1 : 9 );
	
		$d = new DateTime();
		$month = $d->format('m');
		$year = $d->format('Y');
				
		$d = new DateTime($from);
		$next_day = $d->format('Y-m-d'); 
		
		while ($next_day<$to)
			{	
			
		
		$query = 'SELECT * FROM #__properties_available_product '
		. ' WHERE id_product = '. $id 
		. ' AND date = \''.$next_day.'\'' ;	
		
		$db->setQuery( $query );
		if (!$db->query())
			{
			JError::raiseError(500, $db->getErrorMsg() );
			}
		
		$existe = $db->loadObject();		
		
	if($existe)
	{	

		$existe->available = (int) $this->publish;		
		$model->store($existe,'available_product');

	}else{	
			
			$data['id_product']=$id;
			$data['date']=$next_day;
			$data['available']=$this->publish;
			
			$model->store($data,'available_product'); 	
			
	}
	
	$d->modify('+1 day');
	$next_day = $d->format('Y-m-d');	
	
	}//end while	
		
	$link = 'index.php?option=com_properties&view=products&layout=form&task=edit&cid[]='.$id.'&tab=5';
		$this->setRedirect($link, $msg);
	}	

}