<?php defined('_JEXEC') or die('Restricted access'); 

$option = JRequest::getCmd('option');
JHTML::_('behavior.tooltip');
jimport('joomla.html.pane');

$pane =& JPane::getInstance('tabs', array('startOffset'=>0)); 

?>
<script type="text/javascript">
function jSelectProperty(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;			
			document.getElementById('pid').value = id;			
			document.getElementById('sbox-window').close();
		}

</script>		
		
<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );

//print_r($this->lastminute);
?>
<table width="100%">
	<tr>
		<td align="left" width="200" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>

		</td>
        <td align="left" valign="top">
        
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Open House Details' ); ?></legend>
		<table class="admintable" width="100%">        
               
                                <tr>
	<td class="paramlist_key" width="40%">
		<span class="editlinktip">
			<label id="urlparamsid-lbl" for="urlparamsid" class="hasTip">
				<?php echo JText::_( 'Parent Product' ); ?>
			</label>
		</span>
	</td>
    
	<td class="paramlist_value">

	
<?php
require_once( JPATH_COMPONENT.DS.'elements'.DS.'property.php' );
$node=null;
$control_name='';
echo JElementProperty::fetchElement('parent', $this->openhouse->pid, &$node, $control_name);
?>
<input type="hidden" name="pid" id="pid" value="<?php echo $this->openhouse->pid;?>" />
	</td>
</tr>
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'publish up' ); ?>:
						</label>
			</td>
			<td>            
            <?php
			if($this->openhouse->publish_up and $this->openhouse->publish_up!='0000-00-00 00:00:00')
				{
				$publish_up = $this->openhouse->publish_up;
				//echo $ob_created;
				}else{
				$datenow =& JFactory::getDate();
				$publish_up=$datenow->toFormat("%Y-%m-%d %H:%M:%S");
				}
						 
			echo JHTML::_('calendar', $publish_up, 'publish_up', 'publish_up', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
			?>
        
			</td>
		</tr>  
        
        
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Date' ); ?>:
						</label>
			</td>
			<td>            
            <?php
			if($this->openhouse->date and $this->openhouse->date!='0000-00-00')
				{
				$date = $this->openhouse->date;
				//echo $ob_created;
				}else{
				$datenow =& JFactory::getDate();
				$date=$datenow->toFormat("%Y-%m-%d");
				}
						 
			echo JHTML::_('calendar', $date, 'date', 'date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
			?>
        
			</td>
		</tr>    
			
			
			
			
        
        
        

         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'From' ); ?>:
						</label>
			</td>
			<td>            
            <?php				
			$from = explode(':',$this->openhouse->from);			
			$to = explode(':',$this->openhouse->to);
			
			for($i_h=0;$i_h<24;$i_h++)
				{
				if($i_h<10){$text='0'.$i_h;}else{$text=$i_h;}	
				$i_hora[] = JHTML::_('select.option', $text, $text );
				}
				$start_hour = JHTML::_('select.genericlist',   $i_hora, 'start_hour', 'class="" size="1" '.$javascript, 'value', 'text', $from[0] );	
				
			for($i_i=0;$i_i<6;$i_i++)
				{
				$text=$i_i.'0';
				$i_minuto[] = JHTML::_('select.option', $text, $text );
				}
				$start_minute = JHTML::_('select.genericlist',   $i_minuto, 'start_minute', 'class="" size="1" '.$javascript, 'value', 'text', $from[1] );	

				for($f_h=0;$f_h<24;$f_h++)
					{
					if($f_h<10){$text='0'.$f_h;}else{$text=$f_h;}	
					$f_hora[] = JHTML::_('select.option', $text, $text );
					}
				$end_hour = JHTML::_('select.genericlist',   $f_hora, 'end_hour', 'class="" size="1" '.$javascript, 'value', 'text', $to[0] );	

				for($f_i=0;$f_i<6;$f_i++)
					{
					$text=$f_i.'0';
					$f_minuto[] = JHTML::_('select.option', $text, $text );
					}
				$end_minute = JHTML::_('select.genericlist',   $f_minuto, 'end_minute', 'class="" size="1" '.$javascript, 'value', 'text', $to[1] );				
			?>
			<div class="calendar1"><?php echo $start_hour;?><label> : </label><?php echo $start_minute;?></div>
			</td>
		</tr>    
        
      
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'To' ); ?>:
						</label>
			</td>
			<td>            
            <div class="calendar1"><?php echo $end_hour;?><label> : </label><?php echo $end_minute;?></div>      
        
			</td>
		</tr>    
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'published' ); ?>:
						</label>
			</td>
			<td>            
            <?php
       		echo  JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $this->openhouse->published)
       	 	?>
        
			</td>
		</tr>  
        
         <tr><td colspan="2">
<?php
		$editors = &JFactory::getEditor();		
echo $editors->display('text', $this->openhouse->text, '100%', '200', '60', '20');
?>
</td></tr>  
                
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->openhouse->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="openhouse" />
</form>
	</td>
		</tr>
			</table> 