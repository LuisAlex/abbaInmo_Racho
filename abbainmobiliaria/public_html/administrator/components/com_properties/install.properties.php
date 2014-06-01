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

function com_install() 
{  
global $mainframe;
jimport('joomla.filesystem.file');
$destino_imagen = JPATH_SITE.DS.'images'.DS.'properties';
JFolder::create($destino_imagen,0755);
JFolder::create($destino_imagen.DS.'images',0755);
JFolder::create($destino_imagen.DS.'images'.DS.'thumbs',0755);
JFolder::create($destino_imagen.DS.'pdfs',0755);
JFolder::create($destino_imagen.DS.'panoramics',0755);
JFolder::create($destino_imagen.DS.'tools',0755);
JFolder::create($destino_imagen.DS.'profiles',0755);
		
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_properties'.DS.'admin.controller.php' );		
	PropertiesController::update_sql();
			
?>
	<h2>Successfully installed Property!</h2> <BR> 
     <a href="index.php?option=com_properties&task=installsampledata">Install Sample Data</a>   <BR>
     Warning, this option will be deleted tables jos_properties_XXXXX
<?php
 }	
	
?>