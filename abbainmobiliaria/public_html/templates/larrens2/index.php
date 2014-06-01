<?php
/****************************************************
#####################################################
##-------------------------------------------------##
##           LARRENS2- Version 2.0.0               ##
##-------------------------------------------------##
## Copyright = globbersthemes.com- 2010            ##
## Date      = decembre 2010                       ##
## License   = free template                       ##
## Author    = globbers                            ##
## Websites  = http://www.globbersthemes.com       ##
##                                                 ##
#####################################################
****************************************************/
// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo _LANGUAGE; ?>" xml:lang="<?php echo _LANGUAGE; ?>">

<head>
<?php JHTML::_('behavior.mootools'); ?>

	<jdoc:include type="head" />
	<?php if($my->id) initEditor(); ?>
	<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/larrens2/css/tdefaut.css" type="text/css" media="all" />
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/scroll.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/script.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/mootools.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/accordeon.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/Bauhaus_93_400.font.js"></script>
<link rel="icon" type="image/gif" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/favicon.ico" />

<!--[if IE 6]>
<link href="templates/<?php echo $this->template ?>/css/ie6.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	img,#header,#bulle,a.login-switch,a.register-switch,a.search-switch,div.moduletable h3,div.moduletable_menu h3 ,div.moduletable_text h3,.ombre,.calendar,#footer,.box { behavior: url(<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc); } 
	</style>
<![endif]-->

<!--[if IE 7]>
<link href="templates/<?php echo $this->template ?>/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->


<?php   //main width
$mod_left = $this->countModules( 'left' );
$mod_right = $this->countModules( 'right' );
if ( $mod_left && $mod_right ) {
 
	$width = '';
} elseif ( ($mod_left || $mod_right) ) {
 
	$width = '-mid';
} else {
  
	$width = '-full';
}
?>


</head>
<body>
    <div id="header">
        <div class="pagewidth">
		    <div class="ombre">
			</div>
		    <div id="sitename">
                <a href="index.php"><img src="templates/<?php echo $this->template ?>/images/logo.png" width="313" height="73" alt="logotype" /></a>
            </div>
			    <div id="social-links">
			        <div id="twitter">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/twitter.png" width="31" height="33"  alt="twitter" /></a>
                    </div>
					
				    <div id="facebook">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/facebook.png" width="31" height="33"  alt="facebook" /></a>
                    </div>
					
					<div id="myspace">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/myspace.png" width="31" height="33"  alt="myspace" /></a>
                    </div>
					
					<div id="linkedin">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/linkedin.png" width="31" height="33"  alt="linkedin" /></a>
                    </div>
					
					<div id="stumbleupon">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/stumbleupon.png" width="31" height="33"  alt="stumbleupon" /></a>
                    </div>
					
					<div id="youtube">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/youtube.png" width="31" height="33"  alt="youtube" /></a>
                    </div>
					
					<div id="technorati">
                        <a href="#"><img src="templates/<?php echo $this->template ?>/images/technorati.png" width="31" height="33"  alt="technorati" /></a>
                    </div>
				</div>
					<div id="bulle">
					</div> 
		</div>
	</div>
	     <div class="pagewidth">
		    <div id="tool"><!--mod_login-form-->
			    <jdoc:include type="modules" name="login" /> 
				<!--module search-->			
    			<?php if($this->countModules('user4')) : ?>
    			<jdoc:include type="modules" name="user4" />
    			<?php endif; ?>
			</div>
			
			







<div id="mod-slide">
					<div id="slide-container">
						<ul id="accordion">
							<li>
								<div class="stretcher">
			<img src="templates/<?php echo $this->template ?>/images/slide_show_it_20_1.jpg" alt="" class="tab" style="visibility:hidden" />
									<img src="templates/<?php echo $this->template ?>/images/slide_show_it_20_2.jpg" alt="" class="tab"   />
									    <div style="padding-left:41px;">
											<img src="templates/<?php echo $this->template ?>/images/slide_im_3.jpg" alt="" class="img" />
										</div>
                                </div>

							</li>

									
							<li>
								<div class="stretcher">
								<img src="templates/<?php echo $this->template ?>/images/slide_show_it_21_1.jpg" alt="" class="tab" style="visibility:hidde"  />
									<img src="templates/<?php echo $this->template ?>/images/slide_show_it_21_2.jpg" alt="" class="tab"  />
										<div style="padding-left:41px;">
											<img src="templates/<?php echo $this->template ?>/images/slide_im_7.jpg" alt=" " class="img" />
										</div>
								</div>
							</li>

							<li>
								<div class="stretcher" style="width:680px;">
								<img src="templates/<?php echo $this->template ?>/images/slide_show_it_22_1.jpg" alt="" class="tab" style="visibility:hidden"  />
									<img src="templates/<?php echo $this->template ?>/images/slide_show_it_22_2.jpg" alt="" class="tab"  />
										<div style="padding-left:41px;">
											<img src="templates/<?php echo $this->template ?>/images/slide_im_6.jpg" alt=" " class="img" />
									    </div>
								</div>
							</li>
									
							<li>
							    <div class="stretcher">
								<img src="templates/<?php echo $this->template ?>/images/slide_show_it_23_1.jpg" alt="" class="tab" style="visibility:hidden"  />
									<img src="templates/<?php echo $this->template ?>/images/slide_show_it_23_2.jpg" alt="" class="tab"  />
										<div style="padding-left:41px;">
											<img src="templates/<?php echo $this->template ?>/images/slide_im_8.jpg" alt=" " class="img" />
										</div>
								</div>
							</li>
	<li>
							    <div class="stretcher">
								<img src="templates/<?php echo $this->template ?>/images/slide_show_it_24_1.jpg" alt="" class="tab" style="visibility:hidden"  />
									<img src="templates/<?php echo $this->template ?>/images/slide_show_it_24_2.jpg" alt="" class="tab"  />
										<div style="padding-left:41px;">
											<img src="templates/<?php echo $this->template ?>/images/slide_im_9.jpg" alt=" " class="img" />
										</div>
								</div>
							</li>
										  
						</ul>
					</div>
				</div>
			
			   



 <?php if($this->countModules('left')) : ?>
			    <div id="left">
				    	<jdoc:include type="modules" name="left" style="xhtml" />
				</div>
				<?php endif; ?>
				
				    <div id="main<?php echo $width; ?>">
				    <div id="pathway"><p><?// Tu estas aqui:?>
				        <jdoc:include type="modules" name="breadcrumb" /></p>
			        </div>
				    <div id="contentmain">
				        <jdoc:include type="component" />
				    </div>
				</div>
				
				 <?php if($this->countModules('right')) : ?>
				    <div id="right">
				    	<jdoc:include type="modules" name="right" style="xhtml" />
				</div>
				<?php endif; ?>	
		 </div>
		    <div id="footer">
		        <div class="pagewidth">
				    <div id="footer-content">
					    <div class="box">
						    <jdoc:include type="modules" name="user1" style="xhtml" />
						</div>
						<div class="box">
						 <jdoc:include type="modules" name="user2" style="xhtml" />
						</div>
						<div class="box">
						 <jdoc:include type="modules" name="user3" style="xhtml" />
						</div>
						<div class="newsflash">
						     <jdoc:include type="modules" name="user5" style="xhtml" />
						</div>
					</div>
				 </div>   	
			</div>
			    <div id="footer-bottom">
				  <div class="pagewidth">
				    <div id="footer_tm">
                        <div class="ftb">
                            Copyright&copy; <?php echo date( '2011 - Y' ); ?>&nbsp;<?php echo $mainframe->getCfg('sitename');?>&nbsp;&nbsp;|
                                <?php if ($this->params->get('show_footertext')) : ?>
                                <?php echo $this->params->get("footertext"); ?>
                                <?php endif; ?>
                        </div>
                    </div>
                        <div id="top">
                            <div class="top_button">
                                <a href="#" onclick="scrollToTop();return false;">
									<img src="templates/<?php echo $this->template ?>/images/gotop.png" width="26" height="25" alt="gotop" /></a>
                            </div>
                        </div>
		            
				</div>
			</div>
</body>
</html>
