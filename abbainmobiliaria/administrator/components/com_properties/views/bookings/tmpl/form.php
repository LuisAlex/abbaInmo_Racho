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

$TableName = 'order_bookings';
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
//print_r($this->Order);
$user =& JFactory::getUser();


?>
<script type="text/javascript">

/*
function Confirm_booking(book_id,send_email){
var progressS = $('progressS');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=bookings&format=raw&task=confirm_booking",
{method: 'get',
//onRequest: function(){progressS.setStyle('visibility', 'visible');},
//onComplete: function(){progressS.setStyle('visibility', 'hidden');},
update: $('AjaxConfirm'), 
data: '&book_id='+book_id+'&send_email='+send_email}).request();
//alert('&book_id='+book_id+'&send_email='+send_email);
			}	
*/			
			
			



			
			
						
			
			function jSelectArticle(id, title, object) {
			
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;			
			document.getElementById('ob_id_property').value = id;			
			document.getElementById('sbox-window').close();
			/*ShowListAvailables(id);*/
			
		}
		


function CambiarCustomerData(customerid){
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=bookings&format=raw&task=CambiarCustomerData",
{method: 'get',
onComplete: function(){this.evalScripts();},
evalScripts: true, 
update: $('div_ShowListPrice'), 
data: '&customerid='+customerid}).request();



}




function ShowListPrice(a,b,c,d){
//alert(a+b+c+d);
var progressSLP = $('progressSLP');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=bookings&format=raw&task=ShowListPrice",
{method: 'get',
onRequest: function(){progressSLP.setStyle('visibility', 'visible');},
onComplete: function(){progressSLP.setStyle('visibility', 'hidden');this.evalScripts();},
update: $('div_ShowListPrice'), 
evalScripts: true,
data: '&productid='+a+'&agenzia_type='+b+'&ob_from='+c+'&ob_to='+d}).request();
			}	
			
function CalcularPrecio(){



var productid=document.getElementById('ob_id_property').value;
var agenzia_type=document.getElementById('agenzia_type').value;
var ob_from=document.getElementById('ob_from').value;
var ob_to=document.getElementById('ob_to').value;

//alert(property_id+agenzia_type+ob_from+ob_to);

	ShowListPrice(productid,agenzia_type,ob_from,ob_to);
	
	
}				
					
function ShowListAvailables(a){
var progressSLA = $('progressSLA');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=bookings&format=raw&task=ShowListAvailables",
{method: 'get',
onRequest: function(){progressSLA.setStyle('visibility', 'visible');},
onComplete: function(){progressSLA.setStyle('visibility', 'hidden');},
update: $('div_ShowListAvailables'), 
data: '&productid='+a}).request();
			}			



		

function submitbutton(pressbutton) {
	var form = document.adminForm;
	/*var type = form.type.value;*/

	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	if ( document.getElementById('ob_id_property').value == "") {
		alert( "Item must have a Property" );
	}
				else if( document.getElementById('ob_name').value == '' ){
 		alert( "Please select a Name" );
	} 			
//				else if( document.getElementById('type').value == 0 ){
// 		alert( "Please select a Type" );
//	} 
/*				else if( document.getElementById('cyid').value == 0 ){
 		alert( "Please select a Country" );
	} 
				else if( document.getElementById('sid').value == 0 ){
 		alert( "Please select a State" );
	} 
				else if( document.getElementById('lid').value == 0 ){
 		alert( "Please select a Locality" );
	} 
*/				
 else {
		submitform( pressbutton );
	}
}
//-->
</script>
<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>
<table width="100%">
	<tr>
		<td align="left" width="200" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>

		</td>
        <td align="left" width="100%" valign="top">
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Order Details' ); ?></legend>
		<table class="admintable" border="0">
		<tr>
        <td>
        
        <table border="0">
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Order id' ); ?>:
						</label>
			</td>
			<td>
       
				<?php echo $this->Order->ob_id_order;?>
			</td>
		</tr> 
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Product Name' ); ?>:
						</label>
			</td>
				
    
	<td class="paramlist_value">
	<div style="float: left;">
		<input style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;" id="id_name" value=" <?php echo '['.$this->Order->property_id.'] '.$this->Order->property_name;?>" type="text" size="60">
	</div>
	
    <div class="button2-left">
    	<div class="blank">
        	<a class="modal" title="<?php echo JText::_( 'Select Parent Product' ); ?>" href="index.php?option=com_properties&amp;view=products&amp;layout=modal&amp;tmpl=component&amp;object=id" rel="{handler: 'iframe', size: {x: 1050, y: 675}}"><?php echo JText::_( 'Select' ); ?></a>
	</div>
		</div>
        
        
 	<input id="id_id" name="urlparams[id]" value="0" type="hidden">

	<input id="ob_id_property" name="ob_id_property" value="<?php echo $this->Order->ob_id_property;?>" type="hidden">       
        


			</td>
		</tr> 
        
        
        
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Name Lastname' ); ?>:
						</label>
			</td>
			<td>
   <input class="text_area" type="text" name="ob_name" id="ob_name" size="60" maxlength="250" value="<?php echo $this->Order->ob_name;?>" />
				
			</td>
		</tr>  
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Mail' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_mail" id="ob_mail" size="60" maxlength="250" value="<?php echo $this->Order->ob_mail;?>" />
				
			</td>
		</tr>  
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Address' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_address" id="ob_address" size="60" maxlength="250" value="<?php echo $this->Order->ob_address;?>" />


			</td>
		</tr>  
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Post Code' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_postcode" id="ob_postcode" size="60" maxlength="250" value="<?php echo $this->Order->ob_postcode;?>" />
				
			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'City' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_city" id="ob_city" size="60" maxlength="250" value="<?php echo $this->Order->ob_city;?>" />
				
			</td>
		</tr>  
        
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'State' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_state" id="ob_state" size="60" maxlength="250" value="<?php echo $this->Order->ob_state;?>" />

			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Country' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_country" id="ob_country" size="60" maxlength="250" value="<?php echo $this->Order->ob_country;?>" />

			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Phone' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_phone" id="ob_phone" size="60" maxlength="250" value="<?php echo $this->Order->ob_phone;?>" />

			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Text message' ); ?>:
						</label>
			</td>
			<td>
<textarea class="text_area" type="text" name="ob_text" id="ob_text"   cols="34" rows="1"><?php echo $this->Order->ob_text; ?></textarea>
			
			</td>
		</tr>  
                   
           <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Price' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_price" id="ob_price" size="10" maxlength="250" value="<?php echo $this->Order->ob_price;?>" />



			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Adults' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_adults" id="ob_adults" size="60" maxlength="250" value="<?php echo $this->Order->ob_adults;?>" />

			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Boys' ); ?>:
						</label>
			</td>
			<td>
<input class="text_area" type="text" name="ob_boys" id="ob_boys" size="60" maxlength="250" value="<?php echo $this->Order->ob_boys;?>" />

			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Babies' ); ?>:
						</label>
			</td>
			<td>
<input class="inputbox" type="text" name="ob_babies" id="ob_babies" size="60" maxlength="250" value="<?php echo $this->Order->ob_babies;?>" />
			</td>
		</tr>  
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Deposit' ); ?>:
						</label>
			</td>
			<td>
	
    
    
 <?php   
 /*
 $deposit=($this->Order->ob_price*30/100);
 $deposit=round($deposit/10,0)*10;
 
 if(!$this->Order->ob_deposit_amount)
 	{
	$this->Order->ob_deposit_amount='';
	}
 */
    	?>		
 <input class="inputbox" type="text" name="ob_deposit_amount" id="ob_deposit_amount" size="10" maxlength="250" value="<?php echo $this->Order->ob_deposit_amount;?>" />




 <?php 
			
			if($this->Order->ob_deposit)
				{
				$deposit_date = date('d-m-Y',strtotime($this->Order->ob_deposit));
				}			
             
             echo JHTML::_('calendar', $deposit_date, 'ob_deposit', 'ob_deposit', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
			 
			 ?> 
            
			</td>
		</tr>  
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							
						</label>
			</td>
			<td>
           
			</td>
		</tr>  
        
        
        
        
       
				
		 <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							---------------
						</label>
			</td>
			<td>		
		</td>
		</tr>
				
         <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Created' ); ?>:
						</label>
			</td>
			<td>            
				<?php 
				
	/*			
	if($this->Order->ob_created & $this->Order->ob_created!='0000-00-00 00:00:00')
	{
	$created=$this->Order->ob_created;
	}else{
	$created=$datenow->toFormat("%Y-%m-%d %H:%m:%S");
	}	
	*/
	//echo $this->Order->ob_created;
	if($this->Order->ob_created and $this->Order->ob_created!='0000-00-00 00:00:00')
				{
				$ob_created = date('d-m-Y',strtotime($this->Order->ob_created));
				//echo $ob_created;
				}else{
				$datenow =& JFactory::getDate();
	$_date=$datenow->toFormat("%Y-%m-%d");
	$ob_created = date('d-m-Y',strtotime($_date));
	echo $ob_created;
				}
			             
             echo JHTML::_('calendar', $ob_created, 'ob_created', 'ob_created', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
			 
			 
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
            if($this->Order->ob_from)
				{
				$ob_from = $this->Order->ob_from;
				}
			
             
             echo JHTML::_('calendar', $ob_from, 'ob_from', 'ob_from', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
             
            //echo SelectDatesHelper::DatesSelect( 'ob_from',$this->Order->ob_from ); ?>


			</td>
		</tr> 
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'To' ); ?>:
						</label>
			</td>
			<td>
<?php 

if($this->Order->ob_to)
				{
				$ob_to = $this->Order->ob_to;
				}
			
             
             echo JHTML::_('calendar', $ob_to, 'ob_to', 'ob_to', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
             
			 
			 
			 
			 //echo SelectDatesHelper::DatesSelect( 'ob_to',$this->Order->ob_to ); ?>
			</td>
		</tr>  
        
        
          <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Language' ); ?>:
						</label>
			</td>
			<td>
				<?php 
				
				global $mainframe;
				
				$client		=& JApplicationHelper::getClientInfo(0);

				$language =& JFactory::getLanguage();
				jimport('joomla.filesystem.folder');
	$path = JLanguage::getLanguagePath($client->path);
	$dirs = JFolder::folders( $path );
		
	foreach ($dirs as $dir)
	{
				
	if(strlen($dir)==5){
	$Lang_array[] = JHTML::_('select.option', $dir, $dir);
	}			
	}			
	echo JHTML::_('select.genericlist',  $Lang_array, 'ob_language',' class="inputbox" size="1" ', 'value', 'text', $this->Order->ob_language);			
				
			?>
			</td>
		</tr>  
        
            
                
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Date Confirmed' ); ?>:
						</label>
			</td>
			<td>
             <?php 
			 
			 
			 

	
	
	
	
			 if($this->Order->ob_confirmed_date)
				{
				$confirmed_date = date('d-m-Y',strtotime($this->Order->ob_confirmed_date));
				}
			
             
             echo JHTML::_('calendar', $confirmed_date, 'ob_confirmed_date', 'ob_confirmed_date', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); 
			
	
		
	 ?>
				
			</td>
		</tr>
        
              
        
        
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Confirmed by' ); ?>:
						</label>
			</td>
			<td>
            
				<?php echo $this->Order->ob_confirmed_by;?>
			</td>
		</tr>
        
        
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="name">
							<?php echo JText::_( 'Confirm booking and send email to customer' ); ?>:
						</label>
			</td>
            <td>
<?php	
 
$conf[0] = JText::_( 'New Booking' );
$conf[1] = JText::_( 'Received' );
$conf[2] =  JText::_( 'Pending' ) ;
$conf[3] =  JText::_( 'Accepted' ) ;
$conf[4] =  JText::_( 'Canceled' ) ;
//$conf[5] =  JText::_( 'Contract' ) ;

$color[0]='#000000';	
$color[1]='#FF9900';
$color[2]='#3366FF';
$color[3]='#33CC33';
$color[4]='#FF0000';
$color[5]='#FFCC00';

$selected[0]='';
$selected[1]='';
$selected[2]='';
$selected[3]='';
$selected[4]='';
$selected[5]='';

$selected[$this->Order->ob_confirmed]='selected="selected"';
?>



<?php if($this->Order->ob_id_order){ ?>
<select style="font-weight: bold;color: <?php echo $color[$this->Order->ob_confirmed];?>" id="confirmed" name="confirmed" >
<?php
for($s=0;$s<5;$s++)
	{
	echo '<option style="font-weight: bold;color: '.$color[$s].'" value="'.$s.'" '.$selected[$s].'>'.$conf[$s].'</option>';
	}
?>
</select>

<!--
<button id="confirmar_y_mail" class="boton_confirmar" onclick="javascript: submitbutton('confirm_y_mail')"><?php echo JText::_('Confirm and Send Email'); ?></button>

<button id="confirmar" class="boton_confirmar" onclick="javascript: submitbutton('confirm')"><?php echo JText::_('Confirm NO MAIL'); ?></button>
-->


 <?php }	?>           

		</td>
            
            
            
            
		</tr>
        
        
        
  
  
  
  
  
  
  
  
  
  
  
  
  
       
  
  
  
	</table>
    </td>
    <td width="40%" valign="top">
    <div style="width:100%; float:right; margin-bottom:10px;">
    <a style="float:right;border: 1px solid green; padding:3px; color:green; font-weight:bold;" href="index.php?option=com_properties&view=products&layout=form&task=edit&cid[]=<?php echo $this->Order->ob_id_property;?>" target="_blank"><?php echo JText::_( 'Property details' ); ?></a>
    <br />
    </div>
    <br />
    <div style=" width:100%; float:right; margin-bottom:10px;">

   </div>
    
    
    <div style="margin-top:40px;" id="div_ShowListAvailables"></div>
    <div id="progressSLA"></div>
    
    
    
    <div style="margin-top:40px;" id="div_ShowListPrice"></div>
    <div id="progressSLP"></div>
    </td>
    </tr>
   
   
   
   
   
 
  
  
  
    </table>
    

	</fieldset>
</div>
<div class="clr"></div>
<?php
/*
$datenow =& JFactory::getDate();
if($this->Order->ob_confirmed_date)
	{
	$confirmado=$this->Order->ob_confirmed_date;
	}else{
	$confirmado=$datenow->toFormat("%Y-%m-%d");
	}
	
	


if(!$this->Order->ob_confirmed_date)
	{
	$confirmed_date=$datenow->toFormat("%Y-%m-%d");
	$confirmed_by=$user->id;
	}else{
	$confirmed_date=$this->Order->ob_confirmed_date;
	$confirmed_by=$this->Order->ob_confirmed_by;
	}
*/	

?>


<!--
<input type="hidden" name="ob_confirmed_date" value="<?php echo $confirmed_date;?>" />
-->
<input type="hidden" name="ob_confirmed_by" value="<?php echo $confirmed_by; ?>" />
<input type="hidden" name="option" value="com_properties" />
<input type="hidden" name="view" value="bookings" />
<input type="hidden" name="table" value="order_bookings" />
<input type="hidden" name="ob_id_order" value="<?php echo $this->Order->ob_id_order; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="bookings" />
</form>
</td>
	</tr>	
		</table>
<?php 
jimport( 'joomla.application.application' );
global $mainframe, $option;
$mainframe->setUserState("$option.filter_order", NULL);
?>