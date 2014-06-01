<?php
/*------------------------------------------------------------------------
# JF TEXTURIA - JOOMFREAK.COM JOOMLA 1.5.0 TEMPLATE 12-2011
# ------------------------------------------------------------------------
# COPYRIGHT: (C) 2011 JOOMFREAK.COM / KREATIF MULTIMEDIA GMBH
# LICENSE: Creative Commons Attribution
# AUTHOR: JOOMFREAK.COM
# WEBSITE:  http://www.joomfreak.com - http://www.kreatif-multimedia.com
# EMAIL:  info@joomfreak.com
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

include_once (dirname(__FILE__).DS.'/scripts/php/mainmenu.php');
$menuname = 'mainmenu';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
<script type="text/javascript">jQuery.noConflict();</script>
<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/jf_texturia/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/jf_texturia/css/ArchitectsDaughter/stylesheet.css" type="text/css" />
<!--[if lte IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body id="jf-body">
  <div id="jf-wrap"><div id="jf-bottom-bg">
	<div id="jf-wrapper">
		<div id="jf-topleft"><jdoc:include type="modules" name="headleft" /></div>
		<div id="jf-topright"><jdoc:include type="modules" name="headright" /></div>
		<div class="clr"></div>
		<!-- Header module -->
		<div id="jf-header">
			<div id="jf-logo">
				<a href="index.php"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/logo.png" alt="JF Texturia"/></a>
			</div>
			<!-- Main menu module -->
			<div id="jf-mainmenu">
				<?php  mosShowListMenu($menuname); ?>
				<div id="jf-submenu"><jdoc:include type="modules" name="submenu" /></div>
			</div>
		</div>
		<!-- Slideshow module -->
		<?php if($this->countModules('slideshow')) : ?>
			<div id="jf-slideshow">
				<jdoc:include type="modules" name="slideshow" />
			</div>
		<?php endif; ?>
		<!-- Main page -->
		<div id="jf-main-page">
			<jdoc:include type="message" />
			<div id="jf-main">
				<!-- Top module -->
				<?php if($this->countModules('top-content')) : ?>
					<div id="jf-topmodule">
						<jdoc:include type="modules" name="top-content" style="jfrounded" />
					</div>
				<?php endif; ?>
				<div id="jf-content">
					<jdoc:include type="component" />
				</div>
			</div>
			<!-- right -->
			<div id="jf-right">
				<?php if($this->countModules('user4')) : ?>
					<div id="jf-user4">
						<jdoc:include type="modules" name="user4" style="none" />
					</div>
				<?php endif; ?>
				<jdoc:include type="modules" name="right" style="jfrounded2" />
			</div>
			<div class="clr"></div>
			<!-- user1 + user5 -->
			<?php if($this->countModules('user1')) : ?>
				<div id="jf-user1">
					<jdoc:include type="modules" name="user1" style="jfrounded" />
				</div>
			<?php endif; ?>
			<?php if($this->countModules('user5')) : ?>
				<div id="jf-user5">
					<jdoc:include type="modules" name="user5" style="jfrounded" />
				</div>
			<?php endif; ?>
			<div class="clr"></div>
		</div>
	<!-- Footer modules -->
	<div id="jf-footer">
	    <!-- bottom content -->
			<?php if($this->countModules('bottom')) : ?>
	            <div id="jf-bottom">
					<jdoc:include type="modules" name="bottom" style="jfrounded" />
				</div>
			<?php endif; ?>
		<!-- breadcrumbs -->
			<?php if($this->countModules('breadcrumb')) : ?>
	            <div id="jf-breadcrumbs">
					<jdoc:include type="modules" name="breadcrumb" style="none" />
				</div>
			<?php endif; ?>
			<!-- footer module -->
			<?php if($this->countModules('footer')) : ?>
	            <div id="jf-footermodule">
					<jdoc:include type="modules" name="footer" style="none" />
				</div>
			<?php endif; ?>
		<div id="jf-copyright">
					</div>
		<div id="jf-footermenu"><jdoc:include type="modules" name="footermenu" /></div>
		<div class="clr"></div>
		<div id="jf-joomfreak"><a href="http://www.niobox.com" target="_blank" rel="follow"><img src="http://www.los8mejores.com/8mejores.png" alt="Copyright © 2012 abbainmobiliaria. Todos los derechos reservados"/></a></div>
	</div>
   </div></div>
 </div>
</body>
</html>