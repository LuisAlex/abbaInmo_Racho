<?php
/**
* @copyright	Copyright(C) 2008-2010 Fabio Esteban Uzeltinger
* @license 		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @email		admin@com-property.com
**/
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');
class PropertiesControllerAjaxlivesearch extends JController
{		
	function display()
	{
	JError::raiseError(500, JText::_( 'Problem with url', true ) );	
	}
	
	function showref()
	{	
	JRequest::checkToken() or jexit(JText::_('JInvalid_Token'));
	$post=JRequest::get('post');	
	$cParams = JComponentHelper::getParams('com_properties');
	$app	= JFactory::getApplication();
		$db		= JFactory::getDbo();
		$lang =& JFactory::getLanguage();
		$thisLang = $lang->getTag();
		$useTranslations=$cParams->get('useTranslations','0');
		$model = JModel::getInstance('Property', 'PropertiesModel', array('ignore_request' => true));
		
		$ref = $post['fieldsearch'];
		
		$db = &JFactory::getDBO();     
        $query = 'SELECT p.* FROM #__properties_products AS p WHERE p.ref = '.$db->quote($ref);	
		
		$query = 'SELECT p.*,c.name as name_category,t.name as name_type,cy.name as name_country,s.name as name_state,l.name as name_locality '
		.' FROM #__properties_products AS p '
		. ' LEFT JOIN #__properties_category AS c ON c.id = p.cid '
				. ' LEFT JOIN #__properties_country AS cy ON cy.id = p.cyid '				
				. ' LEFT JOIN #__properties_state AS s ON s.id = p.sid '
				. ' LEFT JOIN #__properties_locality AS l ON l.id = p.lid '
				. ' LEFT JOIN #__properties_type AS t ON t.id = p.type '
		.' WHERE p.ref = '.$db->quote($ref);	
		
		$db->setQuery($query);	
		$item = $db->loadObject();
					
if($item){	
		
		$rout_image = 'images/properties/images';
		$rout_large = $rout_image.'/'.$item->id.'/';
		$rout_thumb = $rout_image.'/thumbs/'.$item->id.'/';
		
			$item->imagename = $this->getItemImages($item->id);

			if($item->imagename)
				{
				$item->image = $rout_thumb.'/'.$item->imagename;
				}else{
				$item->image =$rout_image.'/no-photo-available.jpg';
				}
				
			$item->slug = $item->id.':'.$item->alias;		
			$item->link = $link = LinkHelper::getLinkProperty($item->id,$item->alias);
			$item->linkText =  $post['butontext'];			
		
	
		
		
$widthThumb='50px';
$heightThumb='60px';
?>
<div class="modproplivesearch">
<div class="modproplivesearch-title">
<a href="<?php echo $item->link; ?>" title="<?php echo str_replace('"',' ',$item->name); ?>">
<?php
echo '<h4>';
echo $item->name;
echo '</h4>';
?>
</a>
</div>
<div class="modproplivesearch-image">
<a href="<?php echo $item->link; ?>" title="<?php echo str_replace('"',' ',$item->name); ?>">
<img class="img" src="<?php echo $item->image; ?>" alt="<?php echo str_replace('"',' ',$item->name); ?>" width="<?php echo $widthThumb; ?>" height="<?php echo $heightThumb; ?>" />
</a>
</div>

<div class="modproplivesearch-detail">
<?php 
if($item->address){
echo $item->address.'<br> '.$item->name_state.', '.$item->name_locality.'.'; 

echo '<br> '.$item->name_type.' '.$item->name_category;
}else{
echo '<br>'; 
}
?>
</div>
<div class="modproplivesearch-viewdetail">
<a class="viewdetail" href="<?php echo $item->link; ?>" title="<?php echo str_replace('"',' ',$item->name); ?>">
<?php echo $row->linkText; ?>
</a>
</div>


</div>
<div style="clear:both"></div>
<?php
}		
}

		function getItemImages($parent)
			{
			$db 	=& JFactory::getDBO();	
			$query = ' SELECT i.name '			
			. ' FROM #__properties_images as i '					
			. ' WHERE i.published = 1 AND i.parent = '.$parent
			. ' order by i.ordering LIMIT 1';		
        	$db->setQuery($query);
			$Images = $db->loadResult();
			return $Images;
			}
			
	
}
