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


$option = JRequest::getCmd('option');
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');
$productid = JRequest::getVar('productid');
$returnproductid = JRequest::getVar('productid');
$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 
//print_r($this->rate);
?>

<script type="text/javascript">
function ChangeShowRatesList(a){
var progressS = $('progressS');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=ajax&format=raw&task=ChangeShowRatesList",
{method: 'get',
onRequest: function(){progressS.setStyle('visibility', 'visible');},
onComplete: function(){progressS.setStyle('visibility', 'hidden');},
update: $('AjaxChangeShowRatesList'), 
data: 'ratelistid='+a}).request();
			}	
</script>			
<?php

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'select.php' );
?>

  <div style="width:100%; float:left;border: 1px solid #CCCCCC;">
<table>
	<tr>
    	<td align="center">
<?php $linkReturn = JRoute::_( 'index.php?option='.$option.'&view=products&layout=form&task=edit&cid[]='. $productid);?>
        <a href="<?php echo $linkReturn;  ?>"><?php echo JText::_('Return Property'); ?></a> 

		</td>        
	</tr>
</table>
</div>

<table width="100%">
	<tr>
		<td align="left" width="20%" valign="top">
<?php 
if(!$productid){
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
echo MenuLeft::ShowMenuLeft();
}
?>

		</td>
        <td align="left" width="80%" valign="top">
        
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Rate Details' ); ?></legend>
		<table class="admintable">


			<tr>
               					<td align="right" class="key">
								<label for="name"><?php echo JText::_( 'Product' ); ?>:</label>
								</td>
								<td>
								<?php 
								if($productid){$this->rate->productid=$productid;}
								echo SelectHelper::SelectProduct( $this->rate,'products' ); ?>
								</td>
			</tr>  
                            
                            
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Rate Title' ); ?>:
						</label>
			</td>
			<td>            
            <textarea class="text_area" type="text" name="title" id="title"   cols="34" rows="1"><?php echo $this->rate->title; ?></textarea>
				
			</td>
		</tr>    
 
 
 
		<tr>
        	<td width="100" align="right" class="key">
      <label for="from"><?php echo JText::_('From'); ?> :</label>
  			</td><td>      
      <?php echo JHTML::_('calendar', $this->rate->validfrom, 'validfrom', 'validfrom', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>      
 			</td><td>
		</tr>
        <tr>
        	<td width="100" align="right" class="key">  
      <label for="to"><?php echo JText::_('To'); ?> :</label>
    		</td><td>    
      <?php echo JHTML::_('calendar', $this->rate->validto, 'validto', 'validto', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>
			</td>
        </tr>
       
        <tr>
			<td width="100" align="right" class="key">
				<label for="rateperday">
							<?php echo JText::_( 'x Day' ); ?>:
						</label>
			</td>
			<td>
				<input class="text_area" type="text" name="rateperday" id="rateperday" size="3" maxlength="250" value="<?php echo $this->rate->rateperday;?>" />
			</td>
		</tr>   
        
         <tr>    
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Week Only' ); ?>:
						</label>
					</td>
                    					<td>
<?php $weekonly0 = $this->rate->weekonly ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $weekonly1 = $this->rate->weekonly ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="weekonly" id="weekonly0" value="0" <?php echo $weekonly0;?> type="radio">
	<label for="weekonly0"><?php echo JText::_( 'No' ); ?></label>
	<input name="weekonly" id="pweekonly1" value="1" <?php echo $weekonly1;?> type="radio">
	<label for="weekonly"><?php echo JText::_( 'Yes' ); ?></label>  
					</td>
				</tr>    
                
                
        <tr>
					<td class="key">
						<label for="week">
							<?php echo JText::_( 'Week' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="week" id="week" size="3" maxlength="5" value="<?php echo $this->rate->week; ?>" />
					</td>
				</tr>   
                
                <tr>
					<td class="key">
						<label for="rateperweek">
							<?php echo JText::_( 'x Week' ); ?>:
						</label>
					</td>
					<td >
						<input class="text_area" type="text" name="rateperweek" id="rateperweek" size="3" maxlength="5" value="<?php echo $this->rate->rateperweek; ?>" />
					</td>
				</tr>  

        <tr>    
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Published' ); ?>:
						</label>
					</td>
                    					<td>
<?php $chequeado0 = $this->rate->published ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->rate->published ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="published" id="published0" value="0" <?php echo $chequeado0;?> type="radio">
	<label for="published0"><?php echo JText::_( 'No' ); ?></label>
	<input name="published" id="published1" value="1" <?php echo $chequeado1;?> type="radio">
	<label for="published1"><?php echo JText::_( 'Yes' ); ?></label>  
					</td>
				</tr>       
           <tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'Ordering' ); ?>:
						</label>
					</td>
					<td>
                    <?php if($this->rate->ordering){$order_value=$this->rate->ordering;}else{$order_value='';} ?>
                    
						<input class="text_area" type="text" name="ordering" id="ordring" style="width:220px;" size="20" maxlength="255" value="<?php echo $order_value; ?>" />
					</td>
				</tr>            
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->rate->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="rates" />
<input type="hidden" name="returnproductid" value="<?php echo $returnproductid; ?>" />
</form>




<form action="index.php" method="post" name="adminFormRateList" id="adminFormRateList">
<div style="width:50%; float:left;">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Add Rates List' ); ?></legend>
		<table class="admintable">
			<tr>
               					<td align="right" class="key">
								<label for="name"><?php echo JText::_( 'Product' ); ?>:</label>
								</td>
								<td>
								<?php 
								if($productid){$this->rate->productid=$productid;}
								echo SelectHelper::SelectProduct( $this->rate,'products' ); ?>
								</td>
			</tr>
            <tr>
               					<td align="right" class="key">
								<label for="name"><?php echo JText::_( 'Rates List' ); ?>:</label>
								</td>
								<td>
								<?php 
								
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
$dir = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_properties'.DS. 'rates_list' . DS;								
								
	if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				$j=0; // counter for directories
				//$k=0; // counter for images
				while (($file = readdir($dh)) !== false) {
					if ($file != '.' && $file != '..' && $file != 'thumb') {
						$file_type = filetype($dir.$file);
						//$mime_type = $this->getMimeType($dir.$file);
						
						$mime_type =  JFile::getExt($dir.$file);
						
						if ($file_type == 'dir') {
							$this->subdirectories[$j] = $file;
							$j++;
						}
						elseif ($mime_type == 'txt') {
							$this->filerate[] = $file;							
							//$this->filerate[]['file_size'] = number_format((filesize($dir.$file)/1024), 2).' Kb';
							//$this->filerate[]['date_modified'] = date("d-m-y", filemtime($dir.$file));
							$k++;
						}
					}
				}
				closedir($dh);
			}
		}							
								
								
								
	/*print_r($this->filerate);	*/						
	
	
	
		?>
<select name="ratelistid" id="ratelistid" class="inputbox" style="width: 258px;" size="1" onchange="ChangeShowRatesList(this.value)">	
        <?php 
		asort($this->filerate);
		echo  '<option value="0">'.JText::_('Select rate list .txt').'</option>';                       					
foreach($this->filerate as $filerate)
	{
	echo  '<option value="'.$filerate.'">'.$filerate.'</option>';
	}								
		?>							
  </select> 								
								
								
                               
                                                             
								</td>
			</tr>
            <tr>
            <td></td><td>
            <input type="submit" name="save" value="save"  />
            </td>
            </tr>
            
        </table>
        
        </div>
        
        <div id="AjaxChangeShowRatesList" style="width:48%; float:left;">
        <div id="progressS"></div>
        
        </div>
        
</fieldset>
 <input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->rate->id; ?>" />
<input type="hidden" name="task" value="addrateslist" />
<input type="hidden" name="controller" value="rates" />
<input type="hidden" name="returnproductid" value="<?php echo $returnproductid; ?>" />
</form>           
            
            
            
            
            
            
            
	</td>
		</tr>
			</table> 