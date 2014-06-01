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
$params		= JComponentHelper::getParams('com_properties');
$Version=$params->get('version');
$pane	=& JPane::getInstance('sliders');	
?>
<?php
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'menu_left.php' );
?>
<table width="100%">
	<tr>
		<td align="left" width="200" valign="top">
<?php echo MenuLeft::ShowMenuLeft();?>
		</td>
        <td align="left" valign="top">                
        
<table width="100%" border="0">
	<tr>
		<td width="100%" valign="top">
			<div id="cpanel">
            	<?php echo $this->addIcon('configuration.png','configuration', JText::_('Configuration'));?>
				<?php echo $this->addIcon('categories.png','categories', JText::_('Categories'));?>
				<?php echo $this->addIcon('types.png','types', JText::_('Types'));?>
				<?php echo $this->addIcon('products.png','products', JText::_('Products'));?>
				<?php echo $this->addIcon('countries.png','countries', JText::_('Countries'));?>
				<?php echo $this->addIcon('states.png','states', JText::_('States'));?>
				<?php echo $this->addIcon('localities.png','localities', JText::_('Localities'));?>
                <?php echo $this->addIcon('currencies.png','currencies', JText::_('Currencies'));?>
				<?php echo $this->addIcon('profiles.png','profiles', JText::_('Agents Profiles'));?>                
                <?php echo $this->addIcon('contacts.png','contacts', JText::_('Contact forms sent'));?>
				<?php echo $this->addIcon('languages.png','languages', JText::_('languages'));?>
				<?php echo $this->addIcon('help.png','manual', JText::_('Help'));?>
                <?php echo $this->addIcon('icon-48-article.png','menus&task=menus', JText::_('Create Menus'));?>
                <?php echo $this->addIcon('icon-48-article.png','db&&task=installsampledata', JText::_('Delete DataBase and Install Samples Data'));?>
                
                <?php echo $this->addIcon('icon-48-article.png','sql&task=update_sql&sql=data', JText::_('Update SQL'));?>
			</div>
		</td>
	</tr>
</table>
</td>





<td width="200" valign="top">
			<?php
				echo $pane->startPane( 'stat-pane' );
				echo $pane->startPanel( JText::_('Configuration is ok?') , 'welcome' );
			?>
			<table class="adminlist">
				<tr>
					<td>
						<div style="font-weight:700;">
							<?php echo JText::_('Version').' : '.$Version;?> 
						</div>
                        <table>
						<?php
						 if(!$Version)
						 	{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Save Configuration</td></tr>';
							}
						
                        if($Countries = $this->getTotals('country'))
							{
							echo '<tr><td style="color: #009900">Countries: </td><td>'.$Countries.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Country for Properties</td></tr>';
							}
                        ?> 
						<?php
                        if($States = $this->getTotals('state'))
							{
							echo '<tr><td style="color: #009900">States: </td><td>'.$States.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need States for Properties</td></tr>';
							}
                        ?>
                        <?php
                        if($Localities = $this->getTotals('locality'))
							{
							echo '<tr><td style="color: #009900">Localities: </td><td>'.$Localities.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Localities for Properties</td></tr>';
							}
                        ?>
                        <?php
                        if($Categories = $this->getTotals('category'))
							{
							echo '<tr><td style="color: #009900">Categories: </td><td>'.$Categories.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Categories for Properties</td></tr>';
							}
                        ?>
                        <?php
                        if($Types = $this->getTotals('type'))
							{
							echo '<tr><td style="color: #009900">Types: </td><td>'.$Types.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Types for Properties</td></tr>';
							}
                        ?>
                        <?php
                        if($Products = $this->getTotals('products'))
							{
							echo '<tr><td style="color: #009900">Products: </td><td>'.$Products.'</td></tr>';
							}
                        ?>
                       
                        <?php
                        if($PropertiesMenu = $this->getItemid('properties'))
							{
							echo '<tr><td style="color: #009900">ID Menu Properties: </td><td>'.$PropertiesMenu.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Menu for Properties List</td></tr>';
							}
                        ?>
                        <?php
                        if($PropertyMenu = $this->getItemid('property'))
							{
							echo '<tr><td style="color: #009900">ID Menu Property: </td><td>'.$PropertyMenu.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Menu for Property Details</td></tr>';
							}
                        ?>
                         <?php
                        if($PropertyMenu = $this->getItemid('agentlistings'))
							{
							echo '<tr><td style="color: #009900">ID Menu agentlistings: </td><td>'.$PropertyMenu.'</td></tr>';
							}else{
							echo '<tr><td colspan="2" style="color:#CC0000">Need Menu for agentlistings</td></tr>';
							}
                        ?>
                        
                        
                        
                        </table>
					<a href="http://www.com-property.com" target="_blank">http://www.com-property.com/</a>
						
					</td>
				</tr>
			</table>
			<?php
				echo $pane->endPanel();
				
				echo $pane->endPane();
			?>
</td>
</tr></table>