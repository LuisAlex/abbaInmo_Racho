<?php
/**
 * @copyright   Copyright (c) 2010 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

define( 'globalflash_version',		'0.6.6' );
define( 'globalflash_debug',		false );

define( 'globalflash_rootDir',		realpath(dirname(__FILE__).DS.'..'.DS.'..'.DS) );
define( 'globalflash_frontendPath',	str_replace('\\', '/', preg_replace('/^'.preg_quote(globalflash_rootDir, '/').'(.*)/', '$1', dirname(__FILE__))) );
define( 'globalflash_rootURL',		rtrim(preg_replace('/^(.*)'.preg_quote(globalflash_frontendPath, '/').'$/', '$1', JURI::root()), '/') );

define( 'globalflash_frontendDir',	dirname(__FILE__) );
define( 'globalflash_frontendURL',	str_replace('\\', '/', str_replace(globalflash_rootDir, globalflash_rootURL, globalflash_frontendDir)) );

define( 'globalflash_imagesDir',	globalflash_rootDir.DS.'images'.DS.'globalflashgalleries' );
define( 'globalflash_imagesURL',	globalflash_rootURL.'/images/globalflashgalleries' );

if ( is_writable(JPATH_ROOT.DS.'tmp') )
{
	define( 'globalflash_tmpDir',	JPATH_ROOT.DS.'tmp'.DS.'globalflashgalleries' );
	define( 'globalflash_tmpURL',	JURI::root().'tmp/globalflashgalleries' );
}
else
{
	$config =& JFactory::getConfig();
	define( 'globalflash_tmpDir',		$config->getValue('config.tmp_path').DS.'globalflashgalleries' );
	define( 'globalflash_tmpURL',		str_replace(DS, '/', preg_replace('/^'.preg_quote(JPATH_ROOT.DS, '/').'(.*)/', JURI::root().'$1', globalflash_tmpDir)) );
}
