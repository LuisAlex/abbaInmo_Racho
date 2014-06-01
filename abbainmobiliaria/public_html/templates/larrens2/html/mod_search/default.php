<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

	<a class="search-switch" href="<?php echo JRoute::_("index.php?option=com_search");?>" onclick="this.blur();showBox('gl-search','mod_search_searchword',this);return false;">
	
	</a>
	
	<!--SEARCH content-->
			<div id="gl-search">

				<form action="index.php" method="post">
					<div class="search<?php echo $params->get('moduleclass_sfx') ?>">
						<?php 
						    //$output = '<input name="searchword" id="mod_search_searchword" maxlength="20" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
						    $output = '<input name="searchword" id="mod_search_searchword" maxlength="20" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="" />';
											
							if ($button) : 
							    if ($imagebutton) :
							        $button = '<input type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$img.'"/>';
							    else :
							        $button = '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.'"/>';
							    endif;
							endif;
							
							switch ($button_pos) :
							    case 'top' :
								    $button = $button.'<br/>';
								    $output = $button.$output;
								    break;
				
							    case 'bottom' :
								    $button = '<br/>'.$button;
								    $output = $output.$button;
								    break;
				
							    case 'right' :
								    $output = $output.$button;
								    break;
				
							    case 'left' :
							    default :
								    $output = $button.$output;
								    break;
							endswitch;
							
							echo $output;
						?>
					</div>
					<input type="hidden" name="task"   value="search" />
					<input type="hidden" name="option" value="com_search" />
				</form>
        </div>
