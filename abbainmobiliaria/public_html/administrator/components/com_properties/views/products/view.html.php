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

class PropertiesViewProducts extends JView{
	
	function display($tpl = null)
	{

	global $mainframe;
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/com_properties/includes/css/products.css');
	$option = JRequest::getVar('option');
	$component = JComponentHelper::getComponent( 'com_properties' );
	$params = new JParameter( $component->params );
	$UploadImagesSystem=$params->get('UploadImagesSystem');
	if(JRequest::getVar('task')=='edit' or JRequest::getVar('task')=='add')
	{	
	$array = JRequest::getVar('cid',  0, '', 'array');
	$id=(int)$array[0];
	$product =& $this->get('Product');
	$isNew = ($id < 1);
		
		if (!$isNew)  {
		

if ($UploadImagesSystem==1)  {	
$mainframe->addCustomHeadTag('
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
');
$mainframe->addCustomHeadTag('
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
   ');  		
	
$mainframe->addCustomHeadTag('
<link rel="stylesheet" href="components/com_properties/includes/SWFUpload/css/default.css" type="text/css" media="screen" />');

$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/SWFUpload/swfupload/swfupload.js"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/SWFUpload/swfupload/swfupload.queue.js"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/SWFUpload/js/fileprogress.js"></script>');
$mainframe->addCustomHeadTag('<script type="text/javascript" src="components/com_properties/includes/SWFUpload/js/handlers.js"></script>');


$session = & JFactory::getSession();
$myItemObject->id=62;

$mainframe->addCustomHeadTag('
<script type="text/javascript">
		var upload1;

		
			window.onload = function() {
			var settings = {
			upload_url: "index.php",	

					
				post_params: 
        {
                "option" : "com_properties",
                "controller" : "images",
                "task" : "swfupload_files",
                "idproduct" : "'.$product->id.'",
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
				button_image_url : "components/com_properties/includes/SWFUpload/images/XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder1",
				button_width: 61,
				button_height: 22,
		//		button_text: \'<span class="theFont">Choose Files</span>\',
       // button_text_style: ".theFont { font-size: 13; }",
       // button_text_left_padding: 5,
       // button_text_top_padding: 5,
				flash_url : "'.JURI::base().'components/com_properties/includes/SWFUpload/swfupload/swfupload.swf",
				flash9_url : "'.JURI::base().'components/com_properties/includes/SWFUpload/swfupload/swfupload_fp9.swf",	



				custom_settings : {
					upload_target : "divFileProgressContainer",
					progressTarget : "fsUploadProgress1",
					cancelButtonId : "btnCancel1",
					thumbnail_url: "'.JURI::root().'images/properties/images/",
					thumbnail_height: '.$params->get('HeightImage',480).',
					thumbnail_width: '.$params->get('WidthImage',640).',
					thumbnail_quality: 100
				},	
				debug: false
				};			
				
				
				upload1 = new SWFUpload(settings);
			};
	     
	</script>
');

	}
		
		$rates=$this->getRates($product->id);	
		$this->assignRef('rates',		$rates);	
		$Images=$this->getImages($product->id);
		$this->assignRef('Images',		$Images);
		
		$ParentProduct=$this->getParentProduct($product->parent);
		$this->assignRef('ParentProduct',		$ParentProduct);
		
		}else{

		//$product = new JObject();
		//$product->id = null;

		}
		
		$this->assignRef('datos',		$product);

		
			
		$text = $isNew ? JText::_( 'New' ) : $product->name ;
		
		JToolBarHelper::title('&nbsp; &nbsp;'.'<small><small>[ '.$text.' ]</small></small>', 'products.png' );
		
		
		//JToolBarHelper::custom('exportxml', 'export.png', 'export.png', 'Export XML', false);
		JToolBarHelper::custom('gosendmail', 'new.png', 'new_f2.png', 'Send mail', false);
		JToolBarHelper::divider();
		JToolBarHelper::custom('save2new', 'new.png', 'new_f2.png', 'Save and new', false);
		JToolBarHelper::apply();
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}			
		
		
		
		
		
		
		parent::display();
		
		}else{
		$context			= 'com_properties.productsview';
		$this->filter_state		= $mainframe->getUserStateFromRequest( "$context.filter_state",	'filter_state',	'',	'word' );
		if($this->filter_state)
			{
		$imgTop = '<img src="components/com_properties/includes/img/icon-48-'.$this->filter_state.'.png" alt="Published" border="0">';
			}else{
			$imgTop = '';
			}
		JToolBarHelper::title('&nbsp; &nbsp;'.$imgTop.JText::_('Products'), 'products.png');
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		
		JToolBarHelper::divider();
		if($this->filter_state == 'T')
			{
			JToolBarHelper::deleteList();
			}else{
			JToolBarHelper::trash('trash','TRASH');
			}
		
		
		JToolBarHelper::divider();
		
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		
		
		
		
		//$filter_state 	= Helper::filterState( $this->filter_state );
		/*
		
		$state	= $this->get('State');	
		if ($state->get('filter.published') == -2 && $canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'products.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.manage.product')) {
			JToolBarHelper::divider();
			JToolBarHelper::trash('products.trash','JTOOLBAR_TRASH');
		}
		*/
		
		
		
		

$lists = & $this->get('List');
		$this->assignRef('lists', $lists);		
		
		$items		= & $this->get( 'Data');
		
		
		$pagination =& $this->get('Pagination');
		$this->assignRef('pagination', $pagination);	


foreach($items as $item){

$Images[$item->id]=$this->getImages($item->id);
		$this->assignRef('Images',		$Images);
		
		
		
}		
$this->assignRef('items',		$items);

		
		parent::display( $tpl );
		
	}
	
	
	}
	
	
	function getParentProduct($id)
		{
		
	$db 	=& JFactory::getDBO();	
	$query = ' SELECT p.*  '						
			. ' FROM #__properties_products AS p'
			. ' WHERE p.id = '.$id
			;		
        $db->setQuery($query);   

		$Menus = $db->loadObject();

	return $Menus;
	
		}
		
		
	function getRates($id)
		{
		
	$db 	=& JFactory::getDBO();	
	$query = ' SELECT r.*'			
			. ' FROM #__properties_rates as r'			
			. ' WHERE r.productid = '.$id		
			. ' order by r.validfrom '
			;		
        $db->setQuery($query);   

		$Menus = $db->loadObjectList();

	return $Menus;
	
		}
		
		
function getImages($id,$total=1)
	{	
	
	$db 	=& JFactory::getDBO();	
	$query = ' SELECT i.* '			
			. ' FROM #__properties_images as i '					
			. ' WHERE i.published = 1 AND i.parent = '.$id			
			. ' order by i.ordering ';		
        $db->setQuery($query);   

		$Images = $db->loadObjectList();

	return $Images;
	}
	
}