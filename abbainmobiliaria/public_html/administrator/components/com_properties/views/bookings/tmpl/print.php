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

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');
JHTML::_('behavior.tooltip');

	?>
    
<style type="text/css">

table.adminlist {
width: 100%;
	border-spacing: 0px;
/*	background-color: #666666;
	border:1px solid #000000;*/
}
table.adminlist th{
border:1px solid #000000!important;
color: #000000!important;

}
table.adminlist td{
border:1px solid #000000!important;
color: #000000!important;

}

</style>    
    <table>
    <tr>
    <td align="right">
    <a href="javascript:;" onclick="window.print(); return false">
	<img src="components/com_properties/includes/img/imprimir.png" alt="stampa" />
    </a>    
    </td>
    </tr>
    </table>
    
    
<fieldset class="adminform">
		<legend><?php echo JText::_( 'Bookings List' ); ?></legend>       
        
<table class="adminlist">

			    <th class="title" align="center">
				<?php echo JText::_( 'Property' ); ?>			</th>                
                 				
                <th  class="title" align="center">
				<?php echo JText::_( 'Name'); ?>			</th>
                
                <th align="center" th width="40px" class="title" >
			    <?php echo JText::_( 'From'); ?>        </th>  
                
                <th align="center" th width="40px" class="title">
				<?php echo JText::_( 'To'); ?>			</th>                
                
                <th align="center">
				<?php echo JText::_( 'Price'); ?>			</th>     
                        
                <th align="center">
				<?php echo JText::_( 'ID'); ?>			</th>     

<tbody>   
    
    <?php
	
	print_r($rows);
	$rows = &$this->items;
	
	foreach ($rows as $row)
	{	
		
	?>
<tr>
<td><?php echo $row->name;?></td>
<td><?php echo $row->ob_name; ?></td>
<td align="center"><?php echo date('d/m',strtotime($row->ob_from));?></td>
<td align="center"><?php echo date('d/m',strtotime($row->ob_to));?></td>  
<td align="center"><?php echo $row->ob_price; ?></td> 
      
<td align="center"><?php echo $row->ob_id_order; ?></td>             
</tr>    
    <?php  }?>	
</tbody>
</table>

	</fieldset>    
    
    