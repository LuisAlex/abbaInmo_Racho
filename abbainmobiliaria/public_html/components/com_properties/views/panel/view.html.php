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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view' );
class PropertiesViewPanel extends JView
{	
	function display($tpl = null)
	{	
	
	global $mainframe;
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );	
	$this->params=$params;
	$user =& JFactory::getUser();
	$joomlaUserId = $user->get('id');
	$agent = $this->get('DataAgent');
	$task = JRequest::getCmd('task');
	
$post = JRequest::get('post');

//print_r($post);
	$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/panel.css" type="text/css" />');	
	$mainframe->addCustomHeadTag('<link rel="stylesheet" href="administrator/templates/khepri/css/icon.css" type="text/css" />');	
	$mainframe->addCustomHeadTag('<link rel="stylesheet" href="administrator/components/com_properties/includes/css/products.css" type="text/css" />');	
	
	require_once( JPATH_ADMINISTRATOR .DS.'includes'.DS.'toolbar.php' );	
		$myToolBar = JToolBar::getInstance();
	
	switch($task)
		{
		case 'add' :
		
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/panel_form.css" type="text/css" />');
		JToolBarHelper::title('&nbsp; &nbsp;'.'Propiedades '.' [ Nuevo ]', 'products.png' );
		
		break;
		case 'edit' : case 'apply' :
		
		$mainframe->addCustomHeadTag('<link rel="stylesheet" href="components/com_properties/includes/css/panel_form.css" type="text/css" />');
		$ProductEdit		=& $this->get('ProductEdit');		
			
		if($ProductEdit)
		{
		$this->assignRef('datos',		$ProductEdit);
		$Images= $this->getImages($ProductEdit->id);
		$this->assignRef('Images', $Images);
		$this->loadImagesHeader($ProductEdit);
		JToolBarHelper::title('&nbsp; &nbsp;'.'Propiedades '.' [ '.$ProductEdit->name.' ]', 'products.png' );
		}else{
		JError::raiseError(500, JText::_( 'Problem with your product', true ) );
		}
		break;		
		default :
		$items		= & $this->get( 'DataPanel');
		$pagination =& $this->get('PaginationPanel');
		$lists = & $this->get('List');
		
		JToolBarHelper::title('&nbsp; &nbsp;'.'Propiedades '.'[ '.$this->get( 'TotalProducts' ).' ]', 'products.png' );
		
		if($items)
			{
			foreach($items as $item)
				{
				$Images[$item->id]= $this->getImages($item->id);
				}
			}
		$this->assignRef('lists', $lists);	
		$this->assignRef('pagination', $pagination);	
		$this->assignRef('Images', $Images);
		$this->assignRef('items', $items);

		break;
		
		}
	
		$this->assignRef('agent', $agent);		
			
		//echo $myToolBar->render();
		//echo $mainframe->get('JComponentTitle', $html); 
		//$showToolBar = $myToolBar->render();
		$showToolBarTitle = $mainframe->get('JComponentTitle', $html); 
		$this->assignRef('showToolBarTitle', $showToolBarTitle);	
		parent::display();		
	}	
	
	function getImages($pid)
	{	
		$query = ' SELECT i.*  '			
			. ' FROM #__properties_images as i'
			. ' WHERE i.parent = '.$pid
			. ' order by i.ordering '
			;	
	    $db 	=& JFactory::getDBO();
	    $db->setQuery($query);
		$IMG = $db->loadObjectList();
	
	return $IMG;	
	}
	
	
	
	
	function loadImagesHeader($ProductEdit)
		{
		global $mainframe;
$mainframe->addCustomHeadTag('
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
');
$mainframe->addCustomHeadTag('
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
   ');         
            

$mainframe->addCustomHeadTag('
<link rel="stylesheet" href="administrator/components/com_properties/includes/SWFUpload/css/default.css" type="text/css" media="screen" />');

$mainframe->addCustomHeadTag('<script type="text/javascript" src="administrator/components/com_properties/includes/SWFUpload/swfupload/swfupload.js"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="administrator/components/com_properties/includes/SWFUpload/swfupload/swfupload.queue.js"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="administrator/components/com_properties/includes/SWFUpload/js/fileprogress.js"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="administrator/components/com_properties/includes/SWFUpload/js/handlers.js"></script>');


$session = & JFactory::getSession();
$myItemObject->id=62;

$mainframe->addCustomHeadTag('
<script type="text/javascript">
		var upload1;

		
			window.onload = function() {
			var settings = {
			upload_url: "index.php?option=com_properties&controller=images&view=images&task=swfupload_files",	

					
				post_params: 
        {
                "option" : "com_properties",
				"view" : "images",
                "controller" : "images",
                "task" : "swfupload_files",
                "idproduct" : "'.$ProductEdit->id.'",
                "'.$session->getName().'" : "'.$session->getId().'",
                "format" : "raw"
        }, 
				
				file_size_limit : "102400",	// 100MB
				file_types : "*.jpg;*.jpeg;*.gif;*.png",
				file_types_description : "All Files",
				file_upload_limit : 0,
				file_post_name : "Filedata",
						
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_dialog_start_handler : fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				button_image_url : "'.JURI::base().'administrator/components/com_properties/includes/SWFUpload/images/XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder1",
				button_width: 61,
				button_height: 22,
		//		button_text: \'<span class="theFont">Choose Files</span>\',
       // button_text_style: ".theFont { font-size: 13; }",
       // button_text_left_padding: 5,
       // button_text_top_padding: 5,
				flash_url : "'.JURI::base().'administrator/components/com_properties/includes/SWFUpload/swfupload/swfupload.swf",
				flash9_url : "'.JURI::base().'administrator/components/com_properties/includes/SWFUpload/swfupload/swfupload_fp9.swf",	



				custom_settings : {
					upload_target : "divFileProgressContainer",
					progressTarget : "fsUploadProgress1",
					cancelButtonId : "btnCancel1",
					thumbnail_url: "'.JURI::root().'images/properties/images/",
					thumbnail_height: 600,
					thumbnail_width: 800,
					thumbnail_quality: 100
				},	
				debug: false
				};			
				
				
				upload1 = new SWFUpload(settings);
			};
	     
	</script>
');
		}
		
		
		
		
	
	
}
