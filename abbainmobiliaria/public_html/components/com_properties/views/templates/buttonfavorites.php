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

?>
<script language="javascript" type="text/javascript">
function addToFavorites(i){
var divUpdate = 'ajaxAddToFavorites'+i;
var formData = 'addtofavorites'+i;
var progress = $('progressFavorites');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=favorites&format=raw&task=addToFavorites",
{method: 'post',
onRequest: function(){	
	document.getElementById('buttonAddToFavorites'+i).innerHTML = '<?php echo JText::_('Adding Favorite'); ?>';
	},
onComplete: function(){},
evalScripts: true, 
update: $(divUpdate), 
data: $(formData)}).request();
}
</script>

<script language="javascript" type="text/javascript">
function removeFavorites(i){
var divUpdate = 'ajaxAddToFavorites'+i;
var formData = 'addtofavorites'+i;
var progress = $('progressFavorites');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=favorites&format=raw&task=removeFavorites",
{method: 'post',
onRequest: function(){	
	document.getElementById('buttonAddToFavorites'+i).innerHTML = '<?php echo JText::_('Deleting Favorite'); ?>';
	},
onComplete: function(){},
evalScripts: true, 
update: $(divUpdate), 
data: $(formData)}).request();
}
</script>

<?php

class buttonFavoritesHelper
{	
	
	function showButtonFavorites( $pid, $thisView, $favorites )
	{	
		
		if($thisView == 'favorites')
		{
		?>
			<div class="favoritebuttoninlist">	
				<form action="index.php" name="addtofavorites<?php echo $pid;?>" id="addtofavorites<?php echo $pid;?>" method="post">        	
   					<div class="ajaxAddToFavorites" id="ajaxAddToFavorites<?php echo $pid;?>">   
    					<button type="button" class="ListButtonsLink" id="buttonAddToFavorites<?php echo $pid;?>" onclick="removeFavorites('<?php echo $pid;?>')"><?php echo JText::_('Remove favorite');?></button>
            		</div>  
            		<input type="hidden" name="pid" id="pid" value="<?php echo $pid;?>" />          
            		<?php echo JHTML::_('form.token'); ?>
    			</form>        
			</div>
		<?php		
		}else{
		if(in_array($pid,$favorites))
			{
			?>
			<div class="favoritebuttoninlist">
        	<?php 
			//echo JText::_('In favorites');
			$link = LinkHelper::getLink('favorites');
	
			echo '<a class="ListButtonsLink" href="'.$link.'">'.JText::_('In Favorites').'</a>';
			?>
        	</div>
			<?php
			}else{		
			?>
			<div class="favoritebuttoninlist">	
				<form action="index.php" name="addtofavorites<?php echo $pid;?>" id="addtofavorites<?php echo $pid;?>" method="post">        	
   					<div class="ajaxAddToFavorites" id="ajaxAddToFavorites<?php echo $pid;?>">   
    					<button type="button" class="ListButtonsLink" id="buttonAddToFavorites<?php echo $pid;?>" onclick="addToFavorites('<?php echo $pid;?>')"><?php echo JText::_('Favoritos +');?></button>
            		</div>  
            		<input type="hidden" name="pid" id="pid" value="<?php echo $pid;?>" />          
            		<?php echo JHTML::_('form.token'); ?>
    			</form>        
			</div>
		<?php } ?>
<?php 
		}
		
	}	
}		
?>

