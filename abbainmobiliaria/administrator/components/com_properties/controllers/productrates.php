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
jimport('joomla.application.component.controller');
class PropertiesControllerProductrates extends JController
{ 
	function __construct()
	{
		parent::__construct();
		
		$this->cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($this->cid, array(0));
/*
		if(JRequest::getCmd('task') == 'orderup'){
		$this->orderSection( $this->cid[0], -1);
		}elseif(JRequest::getCmd('task') == 'orderdown'){
		$this->orderSection( $this->cid[0], 1);
		}	
*/	
	}	

	
function orderAjax()
	{
$productid	= JRequest::getVar( 'productid' );	
$rateid	= JRequest::getVar( 'rateid' );
$change		= JRequest::getVar( 'change' );	

$change_order	= ( $change == 'orderdown' ? 1 : -1 );

echo $rateid.' '.$productid.' '.$change.' '.$change_order;
	
	$model =& $this->getModel( 'rates' );
		
		$model->orderItem($rateid, $change_order);
		
	echo "<script language=\"javascript\" type=\"text/javascript\">RefreshRatesList()</script>";
	
	}

function publishAjax()
	{
$rateid	= JRequest::getVar( 'rateid' );
$change		= JRequest::getVar( 'change' );
$this->publish	= ( $change == 0 ? 1 : 0 );
		
		$query = 'UPDATE #__properties_rates'
		. ' SET published = ' . (int) $this->publish
		. ' WHERE id IN ( '. $rateid .' )'		
		;		
		
		$db 	=& JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query())
		{
			JError::raiseError(500, $db->getErrorMsg() );
		}	
	$img 	= $change ? 'publish_x.png' : 'tick.png';			
	echo '<a href="#" onclick="publishAjax('.$rateid.','.$this->publish.')"><img src="'.JURI::base().'images/'.$img.'" /></a>';	 
	}
	
	
	
	


	function save()
	{
	jimport('joomla.filesystem.folder');	
	$model = $this->getModel('rates');				
	$post = JRequest::get( 'post' );
	$post['published']=1;		
	if ($model->store($post,'rates')) {	
	
	$LastModif = $model->getLastModif();	
	if(JRequest::getVar('id')){ $id = JRequest::getVar('id');}else{$id = $LastModif;}
	if(JRequest::getVar('product_id')){ $product_id = JRequest::getVar('product_id');}	
	echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.RefreshRatesList()</script>";
	echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.document.getElementById('sbox-window').close()</script>";	
	}
	}
	
	function RefreshRatesList()
		{
				
		global $mainframe;
		
		$eid=JRequest::getVar('productid');
		
		
		$db 	=& JFactory::getDBO();		
		$query = ' SELECT r.*,p.name as p_name '					
			. ' FROM #__properties_rates AS r'	
			. ' LEFT JOIN #__properties_products as p ON p.id = r.productid '
			. ' WHERE r.productid = '.$eid	
			. ' order by r.ordering '		
			;			
			
	  
	    $db->setQuery($query);
		$att = $db->loadObjectList();
		
echo '
  <script type="text/javascript">

		window.addEvent(\'domready\', function() {

			SqueezeBox.initialize({});

			$$(\'a.modalajax\').each(function(el) {
				el.addEvent(\'click\', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
  </script>		
';
      ?>  		    
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
if($att){
//print_r($this->ProgramRates);
$x=0;

foreach($att as $attach)
	{
	$c=$x%2;
	$x++;
	$link_edit='index.php?option=com_properties&view=rates&layout=modal&task=edit&productid='.$eid.'&tmpl=component&cid[]='.$attach->id;
	$icon_url_edit = 'components/com_properties/includes/img/pencil.gif';
    $attachment_txt_edit = JText::_('Edit');
    $ehead = '<a class="modalajax" type="button" href="' . $link_edit . '" ';
    $ehead .= "rel=\"{handler: 'iframe', size: {x: 750, y: 400}}\">";
    $linke = "$ehead<img src=\"$icon_url_edit\" alt=\"$attachment_txt_edit\" /></a>";    
	
$link_delete='index.php?option=com_properties&view=rates&layout=delete&task=edit&productid='.$eid.'&tmpl=component&cid[]='.$attach->id;
	$icon_url_delete = 'components/com_properties/includes/img/delete.gif';
    $attachment_txt_delete = JText::_('Delete');
    $dhead = '<a class="modalajax" type="button" href="' . $link_delete . '" ';
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
		$img 	= $attach->published ? 'tick.png' : 'publish_x.png';			
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
    
 <?php    
 echo "<script language=\"javascript\" type=\"text/javascript\">document.getElementById('sbox-window').close()</script>";   
    
		}







/** remove record(s)	 */
	function removeModal()
	{
	
		$model = $this->getModel('rates');
		
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Greetings Could not be Deleted' );
		} else {
$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
foreach($cids as $cid) {

			$msg .= JText::_( 'Borrado type : '.$cid );
			
}			
		}

		echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.RefreshRatesList()</script>";
echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.document.getElementById('sbox-window').close()</script>";

	}



}
?>