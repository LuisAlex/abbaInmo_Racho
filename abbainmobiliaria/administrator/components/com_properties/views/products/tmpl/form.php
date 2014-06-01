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


require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'select.php' );

JHTML::_('behavior.switcher');
JHTML::_('behavior.formvalidation');
//require_once( JPATH_COMPONENT.DS.'helpers'.DS.'calendar.php' );
$tab=JRequest::getVar('tab');
/*
jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset'=>$tab)); 
*/
$component = JComponentHelper::getComponent( 'com_properties' );
$params = new JParameter( $component->params );
$UseCountry=$params->get('UseCountry');
$UseCountryDefault=$params->get('UseCountryDefault');
$UseState=$params->get('UseState');
$UseStateDefault=$params->get('UseStateDefault');
$UseLocality=$params->get('UseLocality');
$UseLocalityDefault=$params->get('UseLocalityDefault');

$UploadImagesSystem=$params->get('UploadImagesSystem');
$prodMultipleCats=$params->get('prodMultipleCats','0');

if(!isset($this->datos->cyid) or !$this->datos->cyid){
$this->datos->cyid=$UseCountryDefault;
}
if(!isset($this->datos->sid) or !$this->datos->sid){
$this->datos->sid=$UseStateDefault;
}
if(!isset($this->datos->lid) or !$this->datos->lid){
$this->datos->lid=$UseLocalityDefault;
}


?>
<script language="javascript" type="text/javascript">
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;

	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	if ( document.getElementById('name').value == "") {
		alert( "Item must have a Title" );
	}
				else if( document.getElementById('cid').value == 0 ){
 		alert( "Please select a Category" );
	} 			
				else if( document.getElementById('type').value == 0 ){
 		alert( "Please select a Type" );
	} 
				else if( document.getElementById('cyid').value == 0 ){
 		alert( "Please select a Country" );
	} 
				else if( document.getElementById('sid').value == 0 ){
 		alert( "Please select a State" );
	} 
				else if( document.getElementById('lid').value == 0 ){
 		alert( "Please select a Locality" );
	} 
				
 else {
		submitform( pressbutton );
	}
}
//-->
</script>

<script language="javascript" type="text/javascript">
<!--
function submitFromTo(task) {
	
var from = document.getElementById('from').value;
var to = document.getElementById('to').value;	
var url = 'index.php?option=com_properties&controller=availables&task='+task+'&id=<?PHP echo $this->datos->id;?>&from='+from+'&to='+to;
window.location.href=url;	
	
}
//-->
</script>
<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>
<script type="text/javascript">
function ChangeState(a){
var progressS = $('progressL');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=ajax&format=raw&task=ChangeState",
{method: 'get',
onRequest: function(){progressS.setStyle('visibility', 'visible');},
onComplete: function(){progressS.setStyle('visibility', 'hidden');},
update: $('AjaxState'), 
data: 'Country_id='+a}).request();
			}	
			
function ChangeLocality(a){
var progressL = $('progressL');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=ajax&format=raw&task=ChangeLocality",
{method: 'get',
onRequest: function(){progressL.setStyle('visibility', 'visible');},
onComplete: function(){progressL.setStyle('visibility', 'hidden');},
update: $('AjaxLocality'), 
data: 'State_id='+a}).request();
			}
	
	
	function ChangeType(a){
var progressT = $('progressL');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=ajax&format=raw&task=ChangeType",
{method: 'get',
onRequest: function(){progressT.setStyle('visibility', 'visible');},
onComplete: function(){progressT.setStyle('visibility', 'hidden');},
update: $('AjaxType'), 
data: 'Category_id='+a}).request();
			}				
</script>

<script type="text/javascript">

function jSelectArticle(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			
			document.getElementById('parent').value = id;
			
			document.getElementById('sbox-window').close();
		}
function jSelectCoord(lat,lng) {
			document.getElementById('lat').value = lat;
			document.getElementById('lng').value = lng;			
			document.getElementById('sbox-window').close();
		}		
</script>

<div id="progressSLR"></div>
<div id="progressSAR"></div>
<div id="progressAR"></div>






        
   
   <?php
   // Build the component's submenu
		$contents = '';
		$tmplpath = dirname(__FILE__).DS.'tmpl';
		ob_start();
?>
   <div class="submenu-box">
	<div class="submenu-pad">
		<ul id="submenu" class="configuration">            
            <li><a id="data" class="active"><?php echo JText::_('Data'); ?></a></li>
					<li><a id="details"><?php echo JText::_('Details'); ?></a></li>
					<li><a id="description"><?php echo JText::_('Description'); ?></a></li>
					<li><a id="images"><?php echo JText::_('Images'); ?></a></li> 
                    <li><a id="map"><?php echo JText::_('Map'); ?></a></li> 
                    <li><a id="calendar"><?php echo JText::_('Calendar'); ?></a></li> 
                    <li><a id="rates"><?php echo JText::_('Rates'); ?></a></li>  
                    <li><a id="params"><?php echo JText::_('Extras'); ?></a></li>    
		</ul>
		<div class="clr"></div>
	</div>
</div>
<div class="clr"></div>
   <?php
		$contents = ob_get_contents();
		ob_end_clean();

		// Set document data
		$document =& JFactory::getDocument();
		$document->setBuffer($contents, 'modules', 'submenu');
?>
   
   

   
   
   
   
 <div id="config-document">  

    
<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<div class="col width-100 propertyform" style="width:100%;">

<div id="page-data" class="tab">
<div class="noshow">

<?php //if($this->datos->agent_id){$agent_id = $this->datos->agent_id;}else{$agent_id =$this->user->id;}?>
<input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>" />
<?php //if($this->datos->agent){$agent_name = $this->datos->agent;}else{$agent_name =$this->user->username;}?>
<input type="hidden" id="agent" name="agent" value="<?php echo $this->user->username; ?>" />
<?php 
if($this->datos->listdate){$listdate = $this->datos->listdate;}else{$listdate =date("Y-m-d");}
$refresh_time =date("Y-m-d H:i:s");
//$listdate = $this->datos->listdate ? date("Y-m-d") : $this->datos->listdate;
?>
<input type="hidden" id="refresh_time" name="refresh_time" value="<?php echo $refresh_time; ?>" />

<input type="hidden" id="listdate" name="listdate" value="<?php echo $listdate; ?>" />



<?php /*
echo $pane->startPane( 'pane' );
echo $pane->startPanel( 'Details', 'panel1' );
*/ ?>
	<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Data' ); ?></legend>
    <div style="width:50%; float:left">
    <fieldset class="adminform">    
	<legend></legend>
			<table class="admintable" border="0" width="100%"> 
				<tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Reference' ); ?>:</label></td>
					<td>
						<input class="text_area" type="text" name="ref" id="ref" size="60" maxlength="255" value="<?php echo $this->datos->ref; ?>" />                    </td>
			      </tr>
                <tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Title' ); ?>:</label></td>
					<td>
                        
                        
                        <input class="text_area required" type="text" name="name" id="name" size="60" maxlength="250" value="<?php echo $this->datos->name;?>" />                    </td>
			   </tr>
                  
             
                
        <tr>        
<td align="right" class="key">
		<label for="name"><?php echo JText::_( 'Category' ); ?>:</label>			</td>
<td>
<?php echo SelectHelper::ParentCategoryType( $this->datos,'category','products' ); ?></td>
                </tr>                 
                
                <tr>
					<td class="key"><label for="name"><?php echo JText::_( 'Type' ); ?>:</label></td>
					<td width="260" >
                     <?php //echo SelectHelper::SelectType( $this->datos,'type',$this->datos->type); ?>	
                     
 					<div id="AjaxType" style="float:left">
                    
                    <?php 
		  $row->id=0;
		  $row->parent = $this->datos->cid;
		  $row->type = $this->datos->type;
		  echo SelectHelper::SelectType( $row,'type','form_products' ); 
		  ?>              
              		</div>
              		                   </td>
				</tr>
   		<?php if ( $prodMultipleCats )
				{
		?>		
        <tr>        
			<td align="right" class="key">
				<label for="name"><?php echo JText::_( 'Categories' ); ?>:</label>			</td>
			<td>
				<?php echo SelectHelper::MultiParent( $this->datos,'category' ); ?>
            </td>		
   		</tr>   
        <?php } ?>   
	<tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Country' ); ?>:</label></td>
					<td>
                    <?php echo SelectHelper::SelectAjaxPaises( $this->datos,'country',$this->datos->cyid); ?>                      </td> 
            
            <td rowspan="3" width="30">
             
            
            <div id="progressL"></div> 
            
            </td> 
             
			</tr>	   
	<tr>                
      <td class="key"><label for="catid"><?php echo JText::_( 'State' ); ?>:</label></td>
		<td>
          <div id="AjaxState" style="float:left">
          
          <?php 
		  $row->id=0;
		  $row->cyid = $this->datos->cyid;
		  $row->sid = $this->datos->sid;
		  echo SelectHelper::SelectAjaxStates( $row,'states',$this->datos->sid ); 
		  ?>
              </div>
              </td>
</tr>
				<tr><td class="key"><?php echo JText::_( 'Locality' ); ?>:</td>
					<td>
	      <div id="AjaxLocality" style="float:left">     
          <?php 
		  $row->id=0;
		  $row->cyid = $this->datos->cyid;
		  $row->sid = $this->datos->sid;
		  $row->lid = $this->datos->lid;
		  echo SelectHelper::SelectAjaxLocalities( $row,'localities','form_products' ); 
		  ?>
          </div>
          
                   	</td>
            </tr>
                <tr><td class="key"><?php echo JText::_( 'Address' ); ?>:</td>
					<td>
						<input class="text_area" type="text" name="address" id="address" size="60" maxlength="255" value="<?php echo $this->datos->address; ?>" />                        </td>
			      </tr>
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Zip Code' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="postcode" id="postcode" size="10" maxlength="255" value="<?php echo $this->datos->postcode; ?>" />                    </td>
                </tr>
  
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Featured' ); ?>:</label></td>
					<td >
<?php $chequeado0 = $this->datos->featured ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->datos->featured ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="featured" id="featured0" value="0" <?php echo $chequeado0;?> type="radio">
	<label for="featured0"><?php echo JText::_( 'No' ); ?></label>
	<input name="featured" id="featured1" value="1" <?php echo $chequeado1;?> type="radio">
	<label for="featured1"><?php echo JText::_( 'Yes' ); ?></label>					</td>
                </tr>
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Published' ); ?>:</label></td>
					<td >
<?php $chequeado0 = $this->datos->published ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $chequeado1 = $this->datos->published ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="published" id="published0" value="0" <?php echo $chequeado0;?> type="radio">
	<label for="published0"><?php echo JText::_( 'No' ); ?></label>
	<input name="published" id="published1" value="1" <?php echo $chequeado1;?> type="radio">
	<label for="published1"><?php echo JText::_( 'Yes' ); ?></label>					</td>
                </tr>
                
                
               
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Details Market' ); ?>:</label></td>
					<td >
                                       
<?php 
if($this->datos->available == 0){$select0 = JText::_( 'selected="selected"' );}
if($this->datos->available == 1){$select1 = JText::_( 'selected="selected"' );}
if($this->datos->available == 2){$select2 = JText::_( 'selected="selected"' );}
if($this->datos->available == 3){$select3 = JText::_( 'selected="selected"' );}
if($this->datos->available == 4){$select4 = JText::_( 'selected="selected"' );}
if($this->datos->available == 5){$select5 = JText::_( 'selected="selected"' );}
if($this->datos->available == 6){$select6 = JText::_( 'selected="selected"' );}
?>
                   
         <select name="available" style="width:150px;"> 
			<option <?php echo $select0;?> value="0"><?php echo JText::_( 'DETAILS_MARKET0' ); ?></option>
            <option <?php echo $select1;?> value="1"><?php echo JText::_( 'DETAILS_MARKET1' ); ?></option>
            <option <?php echo $select2;?> value="2"><?php echo JText::_( 'DETAILS_MARKET2' ); ?></option>
            <option <?php echo $select3;?> value="3"><?php echo JText::_( 'DETAILS_MARKET3' ); ?></option>
            <option <?php echo $select4;?> value="4"><?php echo JText::_( 'DETAILS_MARKET4' ); ?></option>
            <option <?php echo $select5;?> value="5"><?php echo JText::_( 'DETAILS_MARKET5' ); ?></option>
            <option <?php echo $select6;?> value="6"><?php echo JText::_( 'DETAILS_MARKET6' ); ?></option>
         </select>					</td>
				    
                </tr>
             
                		 <tr>
	<td class="key"><label for="extra"><?php echo JText::_( 'Video' ); ?>:</label></td>
	<td><textarea name="video" id="video" rows="4" cols="30"><?php echo $this->datos->video;?></textarea></td>
   
</tr>


				<?php
				if ($this->datos->id) {
					?>
					<tr>
						<td class="key">
							<label>
								<?php echo JText::_( 'ID' ); ?>:							</label>						</td>
						<td>
							<strong><?php echo $this->datos->id;?></strong>						</td>
					</tr> 
					<?php
				}
				?>
              

<tr>
					<td  class="key"><label for="name"><?php echo JText::_( 'Agent' ); ?>:</label></td>
					<td>
           <?php echo $this->datos->agent_id;?> : <?php echo SelectHelper::SelectAgent($this->datos->agent_id); ?>                      </td>
</tr>  
		</table>
                
          </fieldset>      
		</div>
		<div style="width:50%; float:left">
          <fieldset class="adminform">    
				<legend></legend>
			<table class="admintable" width="100%" border="0">             
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Price' ); ?>:</label></td>
					<td >
                    <input class="text_area_price" type="text" name="price" id="price" size="20" maxlength="255" value="<?php echo (int)$this->datos->price; ?>" />		
                    
                    <?php 				
					echo SelectHelper::SelectCurrency( $this->datos->currency,'currency' ); 
					?>
                    				
					</td>
				</tr>                
                                
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Years' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="years" id="years" size="3" maxlength="255" value="<?php echo $this->datos->years; ?>" />						
					</td>
				</tr>
                 <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Bedrooms' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="bedrooms" id="bedrooms" size="3" maxlength="255" value="<?php echo $this->datos->bedrooms; ?>" />						
					</td>
				</tr>
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Bathrooms' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="bathrooms" id="bathrooms" size="3" maxlength="255" value="<?php echo $this->datos->bathrooms; ?>" />						
					</td>
				</tr>
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Garage' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="garage" id="garage" size="3" maxlength="255" value="<?php echo $this->datos->garage; ?>" />						
					</td>
                   
				</tr>     
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Total Area' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="area" id="area" size="3" maxlength="255" value="<?php echo $this->datos->area; ?>" />						
					</td>
				</tr>
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Covered Area' ); ?>:</label></td>
					<td>
                    <input class="text_area" type="text" name="covered_area" id="covered_area" size="3" maxlength="255" value="<?php echo $this->datos->covered_area; ?>" />						
					</td>
				</tr> 
               
                </table>
                </fieldset>
                <fieldset class="adminform">    
				<legend></legend>
    
                 <table class="admintable" width="100%" border="0">       
        		<tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Url Alias' ); ?>:</label></td>
                    <td>
                    <input class="text_area" type="text" name="alias" id="alias" size="60" maxlength="250" value="<?php echo $this->datos->alias;?>" />					
                    </td>                   
				</tr>
                <tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Meta Title' ); ?>:</label></td>
                    <td>
                    <input class="text_area" type="text" name="metatitle" id="metatitle" size="60" maxlength="250" value="<?php echo $this->datos->metatitle;?>" />					
                    </td>                   
				</tr>
				<tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Meta Description' ); ?>:</label></td>					<td>
                    <textarea class="text_area" name="metadesc" id="metadesc"><?php echo $this->datos->metadesc; ?></textarea>						
                    </td>                   
				</tr>
                <tr>
					<td width="100" class="key"><label for="name"><?php echo JText::_( 'Meta Keywords' ); ?>:</label></td>					<td>
                    <textarea class="text_area" name="metakey" id="metakey"><?php echo $this->datos->metakey; ?></textarea>						
                    </td>                   
				</tr>
			</table>
            </fieldset> 
		</div>                  
                  
  </fieldset>  
<?php 
/*
echo $pane->endPanel();
echo $pane->startPanel( 'Features', 'panel2' );
*/
?>




</div><!--noshow-->    
</div><!--page-data-->  

        
<div id="page-details" class="tab">
<div class="noshow">



	<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Details' ); ?></legend>
<table class="admintable" width="100%">
<tr>
<td valign="top" width="50%">
<table class="admintable2">                            
       
        <!-- use select in extra         
		<tr>
			<td class="key"><label for="user_id"><?php echo JText::_( 'extra1' ); ?>:</label></td>
			<td>              
               <?php 
    for($ext=0;$ext<10;$ext++)
		{	
		$extraArray[] = JHTML::_('select.option', $ext, $ext.' '.JText::_( 'Persons' ) );
		}
		echo JHTML::_('select.genericlist',   $extraArray, 'extra1', 'class="inputbox" size="1" ', 'value', 'text', $this->datos->extra1 );  
        ?>
  			</td>
		</tr>
        -->           
                
                               
<?php
$extra[1]=$this->datos->extra1;
$extra[2]=$this->datos->extra2;
$extra[3]=$this->datos->extra3;
$extra[4]=$this->datos->extra4;
$extra[5]=$this->datos->extra5;
$extra[6]=$this->datos->extra6;
$extra[7]=$this->datos->extra7;
$extra[8]=$this->datos->extra8;
$extra[9]=$this->datos->extra9;
$extra[10]=$this->datos->extra10;
$extra[11]=$this->datos->extra11;
$extra[12]=$this->datos->extra12;
$extra[13]=$this->datos->extra13;
$extra[14]=$this->datos->extra14;
$extra[15]=$this->datos->extra15;
$extra[16]=$this->datos->extra16;
$extra[17]=$this->datos->extra17;
$extra[18]=$this->datos->extra18;
$extra[19]=$this->datos->extra19;
$extra[20]=$this->datos->extra20;
$extra[21]=$this->datos->extra21;
$extra[22]=$this->datos->extra22;
$extra[23]=$this->datos->extra23;
$extra[24]=$this->datos->extra24;
$extra[25]=$this->datos->extra25;
$extra[26]=$this->datos->extra26;
$extra[27]=$this->datos->extra27;
$extra[28]=$this->datos->extra28;
$extra[29]=$this->datos->extra29;  
$extra[30]=$this->datos->extra30; 
$extra[31]=$this->datos->extra31;
$extra[32]=$this->datos->extra32;
$extra[33]=$this->datos->extra33;
$extra[34]=$this->datos->extra34;
$extra[35]=$this->datos->extra35;
$extra[36]=$this->datos->extra36;
$extra[37]=$this->datos->extra37;
$extra[38]=$this->datos->extra38;
$extra[39]=$this->datos->extra39;  
$extra[40]=$this->datos->extra40; 



?>
<script language="javascript">
	function changeColor(este){
	var ById= 'div_'+este.id;
	if(este.checked){
			document.getElementById(ById).className = "divmychecks mychecked";    
		}else{
  			document.getElementById(ById).className = "divmychecks myunchecked";		
	}	
}
</script>
<?php 
for ($x=1;$x<41;$x++){
if(JText::_('extra'.$x)!='HIDE'){
$chequeado = $extra[$x] ? JText::_( 'checked="checked"' ) : JText::_( '' );
$class = $extra[$x] ? JText::_( 'class="divmychecks mychecked"' ) : JText::_( 'class="divmychecks myunchecked"' );
echo '<div '.$class.' id="div_checkbox_'.$x.'">';
echo '<input type="checkbox" id="checkbox_'.$x.'" name="extra'.$x.'" value="1" onclick="changeColor(this);" '.$chequeado.' />';
echo'<label class="mylabel" for="checkbox_'.$x.'">'.JText::_( 'extra'.$x ).'</label>';
echo'</div>';
}
}

?>
</table>
</td>
</tr>
</table>
			</fieldset> 


</div><!--noshow-->    
</div><!--page-details--> 



<div id="page-images" class="tab">
<div class="noshow">

<?php
$img_path = $mainframe->getSiteURL().'images/properties/';
$peque_path = $mainframe->getSiteURL().'images/properties/peques/';
?>

<?php if($this->datos->id){ 

if($UploadImagesSystem==1){ ?>

   <script type="text/javascript">
	jQuery.noConflict();
	
	jQuery(function() {
		jQuery("#thumbnails").sortable({update: function(){ 
		/*var order = jQuery(this).sortable("serialize");*/
		var resultado = jQuery('#thumbnails').sortable('toArray');
		var mostrar = '';
		var x = 0;
		var myorden = new Array();
		for(x=0;x<resultado.length;x++)
			{
			mostrar = mostrar+resultado[x];
			myorden[x]=resultado[x];
			}
		document.getElementById("myOrden").value=myorden;
		/*ordenar(resultado);*/
		/*jQuery("#contentRight").html(mostrar); */
		} });
		jQuery("#thumbnails").disableSelection();
	});
	
	
	
	
	function removeImgElement(divNum) {
  var d = document.getElementById('thumbnails');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}
	</script>
 
      <script type="text/javascript">
    <!--

    jQuery(function () {
        jQuery('.bubbleInfo').each(function () {
            var distance = 10;
            var time = 250;
            var hideDelay = 500;

            var hideDelayTimer = null;

            var beingShown = false;
            var shown = false;
            var trigger = jQuery('.trigger', this);
            var info = jQuery('.popup', this).css('opacity', 0);


            jQuery([trigger.get(0), info.get(0)]).mouseover(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                if (beingShown || shown) {
                    // don't trigger the animation again
                    return;
                } else {
                    // reset position of info box
                    beingShown = true;

                    info.css({
                        top: -20,
                        left: -20,
						right: -20,
                        display: 'block'
                    }).animate({
                        top: '-=' + distance + 'px',
                        opacity: 1
                    }, time, 'swing', function() {
                        beingShown = false;
                        shown = true;
                    });
                }

                return false;
            }).mouseout(function () {
                if (hideDelayTimer) clearTimeout(hideDelayTimer);
                hideDelayTimer = setTimeout(function () {
                    hideDelayTimer = null;
                    info.animate({
                        top: '-=' + distance + 'px',
                        opacity: 0
                    }, time, 'swing', function () {
                        shown = false;
                        info.css('display', 'none');
                    });

                }, hideDelay);

                return false;
            });
        });
    });
 
    //-->
    </script>
  
    
     

<fieldset class="adminform">
		<legend><?php echo JText::_( 'Images' ); ?></legend>
    
<?php

$img_path = JURI::root().'images/properties/images/'.$this->datos->id.'/';
$peque_path = JURI::root().'images/properties/images/thumbs/'.$this->datos->id.'/';

//print_r($this->Images);

?>
<div class="div_thumbs_all">                  
  <div id="thumbnails">
<?php  
  
if($this->Images){

foreach ($this->Images as $Image) {				
//					echo '<a id="' . $Image->name . '" class="no_modal je_thumbnail" href="'.JURI::root().'images/com_properties/gallery/' . $this->Gallery->id . '/' . $Image->name . '" target="_blank"> ';
echo '<div class="thumb bubbleInfo" id="' . $Image->name . '">';
echo '<div>';
					echo '<img width="100px" height="75px" class="trigger" id="22' . $Image->name . '" src="'.JURI::root().'images/properties/images/thumbs/' . $this->datos->id . '/' . $Image->name . '" />';
echo '</div>';

?>

<table style="opacity: 0; top: -110px; left: -33px; display: none;" id="dpop" class="popup">
        	<tbody><tr>
        		<td id="topleft" class="corner"></td>
        		<td class="top"></td>
        		<td id="topright" class="corner"></td>
        	</tr>

        	<tr>
        		<td class="left"></td>
        		<td><table class="popup-contents">
        			<tbody>
                    <tr class="borrarr">
        				<th>
                        <input type="checkbox" name="deleteimage[<?php echo $Image->name;?>]" id="deleteimage<?php echo $Image->name;?>"  />
                        </th>
        				<td>
                  <?php echo JText::_('Select to delete this image');?>
                     </td>
        			 </tr>   
                     								
        			
        		</tbody></table>

        		</td>
        		<td class="right"></td>    
        	</tr>

        	<tr>
        		<td class="corner" id="bottomleft"></td>
        		<td class="bottom"><img alt="popup tail" src="components/com_properties/includes/img/bubble-tail2.png" width="30" height="29"></td>
        		<td id="bottomright" class="corner"></td>
        	</tr>
        </tbody></table>

<?php	
					
echo '</div>';
//					echo '</a>';
				
			}



}
?>
	</div> 
 </div>  


<div style="clear:both"></div>


 <div id="form_swfupload">


		
					<div>
						<div class="fieldset flash" id="fsUploadProgress1">
							<span class="legend"><?php echo JText::_( 'Upload Images' ); ?></span>
						</div>
						<div style="padding-left: 5px;">
							<span id="spanButtonPlaceholder1"></span>
							<input id="btnCancel1" type="button" value="<?php echo JText::_( 'Cancel Uploads' ); ?>" onClick="cancelQueue(upload1);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
							<br />
						</div>
					</div>
				

</div>

<div id="divFileProgressContainer" style="height: 75px;"></div>

</fieldset>



<?php }else{?>

<fieldset class="adminform">
		<legend><?php echo JText::_( 'Images' ); ?></legend>
<?php $linkI = JRoute::_( 'index.php?option='.$option.'&view=images&product_id='. $this->datos->id);?>
 <div style="width:100%;">
 <a href="<?php echo $linkI;  ?>"><?php echo JText::_('Edit Images'); ?></a>        
 </div>       
<?php

$img_path = JURI::root().'images/properties/images/'.$this->datos->id.'/';
$peque_path = JURI::root().'images/properties/images/thumbs/'.$this->datos->id.'/';

//print_r($this->Images);
if($this->Images){
foreach($this->Images as $image){
echo '<img width="100px" style="padding: 2px; border: 1px solid #CCCCCC; margin:5px;" src="'.$peque_path.$image->name.'" />';
}
}
?>


</fieldset>


<?php } ?>

<?php } ?>







 
</div><!--noshow-->    
</div><!--page-descrption-->        
        
        
        
        
            
<div id="page-description" class="tab">
<div class="noshow">


<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Short Description' ); ?></legend>

<table class="adminform">
<tr><td>
<?php
		$editors = &JFactory::getEditor();		
echo $editors->display('short_text', $this->datos->description, '100%', '200', '60', '20');
?>
</td></tr>
</table>
</fieldset>
<fieldset class="adminform">    
	<legend><?php echo JText::_( 'FULL Description' ); ?></legend>
<table class="adminform">
<tr>
<td>
<?php
		$editor = &JFactory::getEditor();		
echo $editor->display('text', $this->datos->text, '100%', '400', '60', '20');
?>
</td>
</tr>

</table>
</fieldset>





</div><!--noshow-->  
</div><!--page-description-->    
        
        
        
<div id="page-map" class="tab">
<div class="noshow">
<?php 
/*
echo $pane->endPanel();
echo $pane->startPanel( 'Map', 'panel4' );
*/
?>
<fieldset class="adminform">
				<legend><?php echo JText::_( 'Coordinates' ); ?></legend>


                
                
<table class="admintable">
				<tr>
						<td class="key">
							<label>
								<?php echo JText::_( 'Map Published' ); ?>:
							</label>
						</td>
						<td>
							<strong><?php echo JText::_( 'Change from Preferences' ); ?></strong>
						</td>
                         <td></td>
					</tr> 
                
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Latitude' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="lat" id="lat" size="60" maxlength="255" value="<?php echo $this->datos->lat; ?>" />
						
					</td>
                    <td></td>
				</tr>
                
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Longitude' ); ?>:</label></td>
					<td >
                    <input class="text_area" type="text" name="lng" id="lng" size="60" maxlength="255" value="<?php echo $this->datos->lng; ?>" />
						
					</td>
                    
				</tr>
                 <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Get' ); ?> API Key:</label></td>
					<td >
                   <strong><a href="http://code.google.com/apis/maps/signup.html" target="_blank"><?php echo JText::_( 'GET' ); ?> API Key</a></strong>
						
					</td>
                    <td></td>
				</tr>
                
                
                <tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Get Coord' ); ?>:</label></td>
					<td >
                   <strong>
                   
                   <a class="modal" title="<?php echo JText::_( 'GET COORD' ); ?>" href="<?php //echo JURI::root();?>index.php?option=com_properties&view=properties&task=mapgetcoord&id=<?php echo $this->datos->id;?>" rel="{handler: 'iframe', size: {x: 750, y: 475}}"><?php echo JText::_( 'GET COORD' ); ?></a>
                   
 <!--                  <a href="http://maps.google.com/maps?ll=40.418103,-3.713722&spn=0.015683,0.027466&z=15&key=ABQIAAAAFHktBEXrHnX108wOdzd3aBRcHlBTpYb_p9Hgr3VvSklsWletSxRtPnaBg-v2NXy9jFYSYS_aNOHN1Q&oi=map_misc&ct=api_logo" target="_blank" title="mapa" >  <?php echo JText::_( 'GET COORD' ); ?></a></strong>
-->						
					</td>
                    <td></td>
				</tr>
              
</table>


 
 
</fieldset>











</div><!--noshow-->  
</div><!--page-map-->    


 
 
 
<div id="page-calendar" class="tab">
<div class="noshow">







<?php				            	
/*
echo $pane->endPanel();

echo $pane->startPanel( 'Available', 'panel6' );
*/
?>
<table class="admintable">
<tr>
					<td class="key"><label for="user_id"><?php echo JText::_( 'Use Booking System' ); ?>:</label></td>
					<td >
<?php $use_booking0 = $this->datos->use_booking ? JText::_( '' ) : JText::_( 'checked="checked"' );?>
<?php $use_booking1 = $this->datos->use_booking ? JText::_( 'checked="checked"' ) : JText::_( '' );?>
                    <input name="use_booking" id="use_booking0" value="0" <?php echo $use_booking0;?> type="radio">
	<label for="use_booking0"><?php echo JText::_( 'No' ); ?></label>
	<input name="use_booking" id="use_booking1" value="1" <?php echo $use_booking1;?> type="radio">
	<label for="use_booking1"><?php echo JText::_( 'Yes' ); ?></label>					</td>
				    <td >&nbsp;</td>
                </tr>
                <tr><td></td></tr>
</table>

<?php if($this->datos->use_booking){?>

<div class="calendarios">

<table class="select_calendar" border="0"><tr><td>
      <?php echo JText::_('From'); ?> 
  </td><td>      
      <?php echo JHTML::_('calendar', $this->datos->fecha, 'from', 'from', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>      
 </td><td>     
      <?php echo JText::_('To'); ?> 
    </td><td>    
      <?php echo JHTML::_('calendar', $this->datos->fecha, 'to', 'to', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'20',  'maxlength'=>'19')); ?>
</td><td>        
	
<a href="#" onclick="javascript: submitFromTo('FromToA')" class="toolbar">
<span class="icon-32-apply" title="Apply"></span>
<?php echo JText::_('Available'); ?>
</a>
<a href="#" onclick="javascript: submitFromTo('FromToUna')" class="toolbar">
<span class="icon-32-apply" title="Apply"></span>
<?php echo JText::_('Unavailable'); ?>
</a>
</td></tr></table>

 </div>		
 
 
 

<table class="admintable" width="100%">
	<tr>
		<td>
    <?php  //echo Calendar::ShowCalendar( $this->datos,'category','products' );        
    
    
$AmountMonthsCalendar=$params->get('AmountMonthsCalendar',12);
$PeriodOnlyWeeks=$params->get('PeriodOnlyWeeks',0);
$PeriodAmount=$params->get('PeriodAmount',3);
$PeriodStartDay=$params->get('PeriodStartDay',6);
$StartMonthCalendar=$params->get('StartMonthCalendar',date('n'));

 require_once( JPATH_COMPONENT.DS.'helpers'.DS.'CalendarClass.php' );
 
$cal = new Calendar; 
$cal->setStartMonth($StartMonthCalendar);
$cal->setAmountMonths($AmountMonthsCalendar);
$cal->setPropertyId($this->datos->id);
echo $cal->getCurrentYearView();  
    
    ?> 
    
    
    
        </td>
	</tr>
</table>

<?php } ?>


</div><!--noshow-->  
</div><!--page-calendar-->  









<div id="page-rates" class="tab">
<div class="noshow">

<fieldset class="adminform">    
	<legend><?php echo JText::_( 'Rates' ); ?></legend>
    
<?php
	if(!$this->datos->id)
		{
		echo JText::_('First Save Property');
		}else{
		?>
<script language="javascript" type="text/javascript">
<!--
function RefreshRatesList() {
var productid= <?php echo $this->datos->id;?>;
var progressRRL = $('progressRRL');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=productrates&format=raw&task=RefreshRatesList",
{method: 'get',
onRequest: function(){progressRRL.setStyle('visibility', 'visible');},
onComplete: function(){progressRRL.setStyle('visibility', 'hidden');},
/*onComplete: function(){this.evalScripts();},*/
evalScripts: true, 
update: $('RefreshRatesList'), 
data: '&productid='+productid}).request();
}

function publishAjax(a,b){

var progressPA = $('progressPA');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=productrates&format=raw&task=publishAjax",
{method: 'get',
onRequest: function(){progressPA.setStyle('visibility', 'visible');},
onComplete: function(){progressPA.setStyle('visibility', 'hidden');},
update: $('publishAjax'+a),
data: '&rateid='+a+'&change='+b}).request();
}
	
	
	function orderAjax(a,b){
var productid= <?php echo $this->datos->id;?>;
var progressOA = $('progressOA');
new Ajax("<?php echo JURI::base();?>index.php?option=com_properties&controller=productrates&format=raw&task=orderAjax",
{method: 'get',
onRequest: function(){progressOA.setStyle('visibility', 'visible');},
onComplete: function(){progressOA.setStyle('visibility', 'hidden');},
evalScripts: true, 
update: $('RefreshRatesList'), 
data: '&productid='+productid+'&rateid='+a+'&change='+b}).request();
}
		
-->
</script>



<div id="RefreshRatesList">
    <div id="product_ratesaddlist">




  <table width="100%" border="0" cellpadding="2" cellspacing="2">
    <tr>
    <th><?php echo JText::_( 'Rate Title' ); ?></th>
    <th><?php echo JText::_( 'From' ); ?></th>
    <th><?php echo JText::_( 'To' ); ?></th>  
    <th><?php echo JText::_( 'Day Price' ); ?></th>
    <th><?php echo JText::_( 'Week Price' ); ?></th>
    <th><?php echo JText::_( 'Published' ); ?></th>
    <th><?php echo JText::_( 'Order' ); ?></th>
    <th><?php echo JText::_( 'Id' ); ?></th>
    <th colspan="3"></th>
    </tr>
   

<?php 
if($this->rates){
//print_r($this->ProgramRates);
$x=0;

foreach($this->rates as $attach)
	{
	$c=$x%2;
	$x++;
	$link_edit='index.php?option=com_properties&view=rates&layout=modal&task=edit&productid='.$this->datos->id.'&tmpl=component&cid[]='.$attach->id;
	$icon_url_edit = 'components/com_properties/includes/img/pencil.gif';
    $attachment_txt_edit = JText::_('Edit');
    $ehead = '<a class="modal" type="button" href="' . $link_edit . '" ';
    $ehead .= "rel=\"{handler: 'iframe', size: {x: 750, y: 400}}\">";
    $linke = "$ehead<img src=\"$icon_url_edit\" alt=\"$attachment_txt_edit\" /></a>";
    
	

	
	$link_delete='index.php?option=com_properties&view=rates&layout=delete&task=edit&productid='.$this->datos->id.'&tmpl=component&cid[]='.$attach->id;
	$icon_url_delete = 'components/com_properties/includes/img/delete.gif';
    $attachment_txt_delete = JText::_('Delete');
    $dhead = '<a class="modal" type="button" href="' . $link_delete . '" ';
    $dhead .= "rel=\"{handler: 'iframe', size: {x: 750, y: 400}}\">";
    $linkd = "$dhead<img src=\"$icon_url_delete\" alt=\"$attachment_txt_delete\" /></a>";
	
	
	
	
	

	
?>	
	
	<tr>  
    
    <td valign="middle" class="td<?php echo $c;?>"><?php echo $attach->title;?></td>
    <td class="td<?php echo $c;?>"><?php echo $attach->validfrom;?></td>
    <td class="td<?php echo $c;?>"><?php echo $attach->validto;?></td>
    <td class="td<?php echo $c;?>"><?php echo $attach->rateperday;?></td>
    <td class="td<?php echo $c;?>"><?php echo $attach->rateperweek;?></td>
    
    <td class="td<?php echo $c;?>">
	
	<div id="progressPA"></div>
            <div id="publishAjax<?php echo $attach->id;?>">            
            <?php
		
		$img = $attach->published ? 'tick.png' : 'publish_x.png';		
			
			 echo '<a href="#" onclick="publishAjax('.$attach->id.','.$attach->published.')"><img src="'.JURI::base().'images/'.$img.'" /></a>';?>	
            
				
            </div>			
            
    </td>
    <td class="td<?php echo $c;?>" align="center">
    <div class="orderAjaxorder">
    <div id="progressOA"></div>
    <div id="orderAjax<?php echo $attach->id;?>">
    <table cellpadding="0" cellspacing="0" border="0" style="border: none; padding:0px!important; margin:0px!important;"><tr>    
	<?php 	
	$img_down = 'downarrow.png';
	$img_down = 'uparrow.png';	
	echo '<td align="right"><a href="#" onclick="orderAjax('.$attach->id.',\'orderdown\')"><img src="'.JURI::base().'images/downarrow.png" /></a></td>';	
	echo '<td width="30px" align="center">'.$attach->ordering.'</td>';
	echo '<td align="left"><a href="#" onclick="orderAjax('.$attach->id.',\'orderup\')"><img src="'.JURI::base().'images/uparrow.png" /></a></td>';	
	?>  
    </tr>
    </table>    
    </div>  
    </div>
    </td>
    <td class="td<?php echo $c;?>"><?php echo $attach->id;?></td>
    <td class="td<?php echo $c;?>"><?php echo $linke;?></td>
    <td class="td<?php echo $c;?>"><?php echo $linkd;?></td>
    
    </tr>
	
<?php 	
	}
}
?>
    </table>
    
    
    
    
    
    
    

    </div>
</div>  <!--RefreshRatesList-->
<div id="progressRRL"></div>   <!--progressFCM-->




<div style="height:20px; float:left; width:300px; "></div>
<div style="clear:both"></div>
<?php
    $url = "index.php?option=com_properties&view=rates&layout=modal&task=edit&productid=".$this->datos->id."&cid[]="."&tmpl=component";
    if ( isset($from) ) {       
        $url .= "&from=closeme";
        }
		
    $url = JRoute::_($url);
    $icon_url = 'components/com_properties/includes/img/t_rates_add.png';
    $add_attachment_txt = ' '.JText::_('Add Price');
    $ahead = '<a class="modal-button" type="button" href="' . $url . '" ';
    $ahead .= "rel=\"{handler: 'iframe', size: {x: 750, y: 400}}\">";
    $links = "$ahead<img valign=\"center\" src=\"$icon_url\" alt=\"$add_attachment_txt\" /></a>";
    $links .= $ahead.$add_attachment_txt."</a>";
    echo "\n<div class=\"addattach\">$links</div>\n";
  ?>  
  
  
  


<?php } /*if(!$this->program->id)*/?>
</fieldset> 




</div><!--noshow-->  
</div><!--page-rates-->  






<div id="page-params" class="tab">
<div class="noshow">
<table class="adminform"><tr><td>
 <?php		
			
		$form = new JParameter('', JPATH_COMPONENT.DS.'models'.DS.'productextras.xml');				
		$form->loadINI($this->datos->params);
		
		echo $form->render('params', 'extras');
				
echo '</td></tr></table>'.JText::_('Params Examples').'<table class="adminform"><tr><td>';			
			
		echo $form->render('params', 'advanced');					
							
?>
</td></tr></table>
</div><!--noshow-->  
</div><!--page-params-->  

 









</div>


<div class="clr"></div>
<input type="hidden" name="myOrden" id="myOrden" value="" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="table" value="<?php echo $TableName; ?>" />
<input type="hidden" name="id" value="<?php echo $this->datos->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="products" />

<?php echo JHTML::_( 'form.token' ); ?>
</form>
  
<?php				            	
/*
echo $pane->endPanel();
echo $pane->endPane();
*/
?>








     
</div><!-- id="config-document" -->
<div class="clr"></div>
