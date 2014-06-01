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
class PropertiesViewLanguages extends JView
{	
	function display($tpl = null)
	{	
	global $mainframe;
	$option = JRequest::getVar('option');	
	
	$doc =& JFactory::getDocument();
	$doc->addStyleSheet('components/'.$option.'/includes/css/index.css');	
			
		
if(JRequest::getVar('layout')=='edit'){	
	
		JToolBarHelper::save( 'saveLanguage' );
		JToolBarHelper::apply( 'applyLanguage');
		JToolBarHelper::cancel('cancel');		
		
}else{
		
		
		JToolBarHelper::custom( 'editLanguage', 'edit.png', 'edit_f2.png', 'Edit', true );
			

		// Initialize some variables
		$option 	= JRequest::getCmd('option');		
		//$clientSite		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

$language =& JFactory::getLanguage();
		// Determine language file directory
		$lang = JRequest::getVar('id', $language->getTag(), 'method', 'cmd');
		$dir = $client->path.DS.'language'.DS.$lang;

		// List language .ini files
		jimport('joomla.filesystem.folder');
		$files = JFolder::files($dir, '\.ini$', false, false);

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		
		JClientHelper::setCredentialsFromRequest('ftp');

$this->assignRef('client', $client);
$this->assignRef('lang', $lang);
$this->assignRef('dir', $dir);
$this->assignRef('files', $files);

		
		
		
		
		
		//load folder filesystem class
	jimport('joomla.filesystem.folder');
	$path = JLanguage::getLanguagePath($client->path);
	$dirs = JFolder::folders( $path );
	$this->assignRef('dirs', $dirs);
	
	
}		
		
		
				
		parent::display($tpl);
	}
}
