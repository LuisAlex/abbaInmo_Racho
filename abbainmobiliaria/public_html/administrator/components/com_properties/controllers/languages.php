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

class PropertiesControllerLanguages extends PropertiesController
{

	function __construct()
	{
		parent::__construct();
		$this->registerTask( 'applyLanguage',	'saveLanguage' );
		$this->TableName = JRequest::getCmd('table');	
	}
	
	function display()
	{
		
		
		parent::display();
	}
	
	function editLanguageSource()
	{
		global $mainframe;

		// Initialize some variables
		$option		= JRequest::getCmd('option');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$template	= JRequest::getVar('id', '', 'method', 'cmd');
		$file		= $client->path.DS.'templates'.DS.$template.DS.'index.php';

		// Read the source file
		jimport('joomla.filesystem.file');
		$content = JFile::read($file);

		if ($content !== false)
		{
			// Set FTP credentials, if given
			jimport('joomla.client.helper');
			$ftp =& JClientHelper::setCredentialsFromRequest('ftp');

			$content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');
			require_once (JPATH_COMPONENT.DS.'admin.templates.html.php');
			TemplatesView::editTemplateSource($template, $content, $option, $client, $ftp);
		} else {
			$msg = JText::sprintf('Operation Failed Could not open', $file);
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, $msg);
		}
	}

	function saveLanguageSource()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$option			= JRequest::getCmd('option');
		$client			=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$template		= JRequest::getVar('id', '', 'method', 'cmd');
		$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if (!$template) {
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::_('No template specified.'));
		}

		if (!$filecontent) {
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::_('Content empty.'));
		}

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

		$file = $client->path.DS.'templates'.DS.$template.DS.'index.php';

		// Try to make the template file writeable
		if (!$ftp['enabled'] && !JPath::setPermissions($file, '0755')) {
			JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the template file writable'));
		}

		jimport('joomla.filesystem.file');
		$return = JFile::write($file, $filecontent);

		// Try to make the template file unwriteable
		if (!$ftp['enabled'] && !JPath::setPermissions($file, '0555')) {
			JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the template file unwritable'));
		}

		if ($return)
		{
			$task = JRequest::getCmd('task');
			switch($task)
			{
				case 'apply_source':
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=edit_source&id='.$template, JText::_('Template source saved'));
					break;

				case 'save_source':
				default:
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=edit&cid[]='.$template, JText::_('Template source saved'));
					break;
			}
		}
		else {
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
		}
	}

	function chooseLanguage()
	{
		global $mainframe;

		// Initialize some variables
		$option 	= JRequest::getCmd('option');
		$template	= JRequest::getVar('id', '', 'method', 'cmd');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

		// Determine template CSS directory
		$dir = $client->path.DS.'templates'.DS.$template.DS.'css';

		// List template .css files
		jimport('joomla.filesystem.folder');
		$files = JFolder::files($dir, '\.css$', false, false);

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');

		require_once (JPATH_COMPONENT.DS.'admin.templates.html.php');
		TemplatesView::chooseCSSFiles($template, $dir, $files, $option, $client);
	}

	function editLanguage()
	{
		global $mainframe;

		// Initialize some variables
		$option		= JRequest::getCmd('option');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$lang	= JRequest::getVar('id', '', 'method', 'cmd');
		$filename	= JRequest::getVar('filename', '', 'method', 'cmd');

		jimport('joomla.filesystem.file');

		if (JFile::getExt($filename) !== 'ini') {
			$msg = JText::_('Wrong file type given, only CSS files can be edited.');
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=choose_css&id='.$template, $msg, 'error');
		}

		$content = JFile::read($client->path.DS.'language'.DS.$lang.DS.$filename);

		if ($content !== false)
		{
			// Set FTP credentials, if given
			jimport('joomla.client.helper');
			$ftp =& JClientHelper::setCredentialsFromRequest('ftp');

			$content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');
			
			
		//	require_once (JPATH_COMPONENT.DS.'admin.templates.html.php');
		//	TemplatesView::editCSSSource($template, $filename, $content, $option, $client, $ftp);
			
		//$TableName = JRequest::getVar('table');
		JRequest::setVar( 'client', $client );
		JRequest::setVar( 'content', $content );
		JRequest::setVar( 'ftp', $ftp );
		JRequest::setVar( 'view', 'languages' );
		JRequest::setVar( 'layout', 'edit' );
		JRequest::setVar('lang', $lang);
		JRequest::setVar('filename', $filename);
		parent::display();
		
		
		
		}
		else
		{
			$msg = JText::sprintf('Operation Failed Could not open', $client->path.$filename);
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, $msg);
		}
	}

	function saveLanguage()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$option			= JRequest::getCmd('option');
		$client			=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$lang		= JRequest::getVar('id', '', 'post', 'cmd');
		$filename		= JRequest::getVar('filename', '', 'post', 'cmd');
		$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if (!$lang) {
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::_('No template specified.'));
		}

		if (!$filecontent) {
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::_('Content empty.'));
		}

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

		$file = $client->path.DS.'language'.DS.$lang.DS.$filename;

		// Try to make the css file writeable
		if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0755')) {
			JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the css file writable'));
		}

		jimport('joomla.filesystem.file');
		$return = JFile::write($file, $filecontent);

		// Try to make the css file unwriteable
		if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0555')) {
			JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the css file unwritable'));
		}

		if ($return)
		{
			$task = JRequest::getCmd('task');
			switch($task)
			{
				case 'applyLanguage':
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&controller=languages&view=languages&task=editLanguage&lang='.$lang.'&id='.$lang.'&filename='.$filename,  JText::_('File Saved'));
					break;

				case 'saveLanguage':
				default:
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=edit&cid[]='.$template, JText::_('File Saved'));
					break;
			}
		}
		else {
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&id='.$template.'&task=choose_css', JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
		}
	}
	
	function cancel()
	{
	$option = JRequest::getVar('option');
	$view = JRequest::getVar('view');
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option='.$option.'&view=languages', $msg );
	}	
	
}
