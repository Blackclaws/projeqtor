<?php
// Get browser info
$navigator_user_agent = ' ' . strtolower($_SERVER['HTTP_USER_AGENT']);
$_browserPlatform='Else';
if (strpos($navigator_user_agent, 'android')) :
	$_browserPlatform= 'Android';
elseif (strpos($navigator_user_agent, 'linux')) :
	$_browserPlatform= 'Linux';
elseif (strpos($navigator_user_agent, 'mac')) :
	$_browserPlatform = 'Mac';
elseif (strpos($navigator_user_agent, 'win')) :
	$_browserPlatform = 'Windows';
endif;
defined('_JEXEC') or die;
// JPlugin::loadLanguage( 'tpl_SG1' );
JHTML::_('behavior.mootools');
define( 'Jmasterframework', dirname(__FILE__) );
require( Jmasterframework.DS."config.php");
$path = $this->baseurl.'/templates/'.$this->template;
$app = JFactory::getApplication();
$app->getCfg('sitename');
$siteName = $this->params->get('siteName');
$sidecol_width = $this->params->get('sidecol_width');
$col_pos = $this->params->get('col_pos');
$bg_state = $this->params->get('bg_state');
$templateparams	= $app->getTemplate(true)->params;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<link rel="shortcut icon" href="logo.ico" type="image/x-icon" />
  <link rel="icon" href="logo.ico" type="image/x-icon" />
<jdoc:include type="head" />
<link rel="stylesheet" href="templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/sidepanel.css" type="text/css" />
<link rel="stylesheet" href="templates/<?php echo $this->template ?>/css/<?php echo $this->params->get('colorStyle'); ?>.css" type="text/css" />
  <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-11059781-2");
      pageTracker._setDomainName(".toolware.fr");
      <?php $pageTackerPageName=(strlen($_SERVER['REQUEST_URI'])<11)?'menu_home_en':substr($_SERVER['REQUEST_URI'],11);?>
      pageTracker._trackPageview("<?php echo $pageTackerPageName;?>");
      //pageTracker._trackPageview();
    } catch(err) {
    }
  </script>       
  
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/UvumiDropdown.js"></script>
<script type="text/javascript">
	var menu = new UvumiDropdown('moomenu');
</script>
<script type="text/javascript">
function hideNewYearNow(delay,current) {
  current+=10;
  if (current>=delay) {
    document.getElementById('newyeardiv').style.display='none';
  } else {
    opacity=Math.round((delay-current)/delay*100);
	document.getElementById('newyeardiv').style.opacity=opacity/100;
	document.getElementById('newyeardiv').style.filter = 'alpha(opacity=' + opacity + ')';
	setTimeout("hideNewYearNow("+delay+","+current+");",10);
  }
}
function showNewYearNow(delay,current) {
  current+=10;
  if (current>=delay) {
    hideNewYear();
  } else {
    opacity=100-Math.round((delay-current)/delay*100);
	document.getElementById('newyeardiv').style.opacity=opacity/100;
	document.getElementById('newyeardiv').style.filter = 'alpha(opacity=' + opacity + ')';
	setTimeout("showNewYearNow("+delay+","+current+");",10);
	document.getElementById('newyeardiv').style.display='block';
  }
}

function hideNewYear() {
  setTimeout("hideNewYearNow(1000,0);",3000);
}
function loadBody() {
  if (screen.width<1200) {
    document.getElementById("leftAd").style.display='none';
  }
  if (<?php echo date('m');?>==1) {
    showNewYearNow(500,0);
  }
}
</script>

<style type="text/css">
#sidecol {width: <?php echo ($sidecol_width); ?>px }
#content80 {width: <?php echo 865 - $sidecol_width ?>px }
		
<?php if($this->params->get('col_pos') == 'col_l') : ?>
#content80 {float:right; padding-right:25px; padding-left:0px;}
#sidecol {float:left; padding:0 0px 0 25px;}
<?php else : ?>
#content80 {float:left; padding-right:0px; padding-left:25px;}
#sidecol {float:right; padding:0 25px 0 0px;}
<?php endif; ?>

<?php if($this->params->get('bg_state') == 'bg_scroll') : ?>
#body_bg {background-attachment: scroll !important;}
<?php else : ?>
#body_bg {background-attachment: fixed !important;}
<?php endif; ?>
</style>

</head>

<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/ie7.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
window.addEvent('domready', function(){
   var menu_li_els = document.getElementById('hornav').firstChild.childNodes;
   for(var i=0;i<menu_li_els.length; i++) {
      menu_li_els[i].insertBefore(document.createElement('div'), menu_li_els[i].lastChild);
   }
});
</script>
<![endif]-->

<!--[if IE 6]>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/fix-png-ie6.js"></script>
<script type="text/javascript" >
	DD_belatedPNG.fix('.png, img.png, #header, #base_bg');
</script>
<script type="text/javascript">
window.addEvent('domready', function(){
   var menu_li_els = document.getElementById('hornav').firstChild.childNodes;
   for(var i=0;i<menu_li_els.length; i++) {
      menu_li_els[i].insertBefore(document.createElement('div'), menu_li_els[i].lastChild);
   }
});
</script>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/css/ie6.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/js/ie6/warning.js"></script><script>window.onload=function(){e("<?php echo $this->baseurl ?>/templates/<?php echo $this->template?>/js/ie6/")}</script>
<![endif]-->

<?php
if($this->countModules('sidecolumn') == 0) $contentwidth = "100";
if($this->countModules('sidecolumn') >= 1) $contentwidth = "80";
?> 

<body onLoad="loadBody();"> 

<div style="position: fixed; left: 50px; top: 20px; ">
<g:plusone></g:plusone>
</div>
 <?PHP if (! isset($_REQUEST['Itemid']) or $_REQUEST['Itemid']=='101') {?>
<div style="display:none;position: fixed; left: 25%; top: 25%; width:50%; height:50%; text-align: center; vertical-align: middle;
            background-color:#545281; border-radius: 30px; -moz-border-radius: 30px;" id="newyeardiv"
 onClick="hideNewYearNow(10,0)">
<div style="top: 25% ;width:100%; height: 50%; font-size:50px ;color: white;"><br/><br/><I>HAPPY NEW YEAR <?PHP echo date('Y');?></I><br/><br/></DIV>
<div style="top: 25% ;width:100%; height: 30%; font-size:30px;color: white;"><br/><br/>May you succeed in all your projects !</div>
<div style="width:100%; height: 5%; font-size:10pt;color: grey;"><br/><br/>Click on this message to hde it instantly</div>
</div>
<?PHP }?>
<div id="body_bg">
<div id="wrapper">

	<div id="header"> 
		<div class="logo_container">		
			<?php if($this->params->get('logoType') == 'image') : ?>
			<h1 class="logo"> <a href="index.php" title="<?php echo $siteName; ?>"><span>
			  <?php echo $siteName; ?>
			  </span></a> </h1>
				<?php else : ?>

			<h1 class="logo-text"> <a href="index.php" title="<?php echo $this->params->get('siteName'); ?>"><span>
			  <?php echo $this->params->get('logoText'); ?>
			  </span></a> </h1>
				<p class="site-slogan"><?php echo $this->params->get('sloganText'); ?></p>
			<?php endif; ?>
		</div> 
	</div>
	
	<div id="top">	
			<div id="hornav" style="width:100%;">
				<jdoc:include type="modules" name="hornav" />
			</div>	
	</div>

	<div id="content_wrapper">
		<div class="content_wrapper">
			<?php if ($this->countModules( 'showcase' )) : ?>
				<div id="showcase" style="background-color:#ececec">
						<jdoc:include type="modules" name="showcase" style="none" />
				</div>
					
			<?php endif; ?>
	
		<?php if ($this->countModules( 'breadcrumb' )) : ?>
		<div id="breadcrumbs" style="width:100%; background:#d3d4d9;" ><H2>
				<jdoc:include type="module" name="breadcrumbs" style="none" />
		</H2></div>
		<?php endif; ?>
	
			<!-- Modules USER 7,8,9,10,11,12-->
				<?php if ($this->countModules('user7') || $this->countModules('user8') || $this->countModules('user9') || $this->countModules('user10') || $this->countModules('user11') || $this->countModules('user12')) { ?>
					<div class="spacer">&nbsp;</div>
					<div class="wrapper_moduleblock2">
						<div class="wrapper_mb2_padding">
						<?php if ($this->countModules('user7')) { ?>
						<div class="moduleblock2" style="width:<?php echo $modules_789_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user7"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user8')) { ?>
						<div class="moduleblock2" style="width:<?php echo $modules_789_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user8"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user9')) { ?>
						<div class="moduleblock2" style="width:<?php echo $modules_789_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user9"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user10')) { ?>
						<div class="moduleblock2" style="width:<?php echo $modules_789_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user10"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user11')) { ?>
						<div class="moduleblock2" style="width:<?php echo $modules_789_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user11"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user12')) { ?>
						<div class="moduleblock2" style="width:<?php echo $modules_789_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user12"  style="j51_module"/></div></div><?php } ?>
					</div>
					</div>
				<?php } ?>
			<!--End Modules USER 7,8,9,10,11,12-->
			

	
		<?php if ($this->countModules( 'sidecolumn' )) : ?>
		<div id="sidecol">
			<div class="sidecol_block">
			  <jdoc:include type="modules" name="sidecolumn" style="j51_module" />
			</div>
		</div>
		<?php endif; ?>
	
		  <div id="content<?php echo $contentwidth; ?>">
	
		<div class="inside">
	
			   <!--Modules USER 1,2,3-->
			<?php if ($this->countModules('user1') || $this->countModules('user2') || $this->countModules('user3')) { ?>
				<div class="wrapper_moduleblock1">
				  <?php if ($this->countModules('user1')) { ?>
							<div class="moduleblock1" style="width:90px; position: fixed; right: 1px; top: 0px;"><div class="module_padding"><jdoc:include type="modules" name="user1"  style="j51_module"/></div></div><?php } ?>
							<?php if ($this->countModules('user2')) { ?>
							<div class="moduleblock1" style="width:150px; color: #FFFFFF !important; position: fixed; right: 1px; top: 200px;background: #d8d8d8;"><div class="module_padding"  style="color: #FFFFFF !important;"><jdoc:include type="modules" name="user2"  style="j51_module"/></div></div><?php } ?>
							<?php if ($this->countModules('user3')) { ?>
							<div class="moduleblock1" style="width:<?php echo $modules_123_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user3"  style="j51_module"/></div></div><?php } ?>
				
			</div>
		
				<?php } ?>
				<!--End Modules USER 1,2,3-->
<div class="spacer">&nbsp;</div>
			<div class="maincontent">
				<div class="message">
					<?php if ($this->getBuffer( 'message' )) : ?>
					<jdoc:include type="message" />
					<?php endif; ?>
				</div>
			  <jdoc:include type="component" /> 
			  </div> 
			<div class="both"><!-- --></div>
			<div class="spacer">&nbsp;</div>
			<!-- Modules USER 4,5,6-->
				<?php if ($this->countModules('user4') || $this->countModules('user5') || $this->countModules('user6')) { ?>
					<div class="wrapper_moduleblock1">
						<?php if ($this->countModules('user4')) { ?>
						<div class="moduleblock1" style="width:<?php echo $modules_456_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user4"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user5')) { ?>
						<div class="moduleblock1" style="width:<?php echo $modules_456_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user5"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user6')) { ?>
						<div class="moduleblock1" style="width:<?php echo $modules_456_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user6"  style="j51_module"/></div></div><?php } ?>
					</div>
				<?php } ?>
			<!--End Modules USER 4,5,6-->
	
		</div>
		</div>
		<div class="both"><!-- --></div>
			<!-- Modules USER 7,8,9,10,11,12-->
				<?php if ($this->countModules('user13') || $this->countModules('user14') || $this->countModules('user15') || $this->countModules('user16') || $this->countModules('user17') || $this->countModules('user18')) { ?>
					<div class="wrapper_moduleblock3">
						<div class="wrapper_mb3_padding">
						<?php if ($this->countModules('user13')) { ?>
						<div class="moduleblock3" style="width:<?php echo $modules_1314_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user13"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user14')) { ?>
						<div class="moduleblock3" style="width:<?php echo $modules_1314_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user14"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user15')) { ?>
						<div class="moduleblock3" style="width:<?php echo $modules_1314_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user15"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user16')) { ?>
						<div class="moduleblock3" style="width:<?php echo $modules_1314_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user16"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user17')) { ?>
						<div class="moduleblock3" style="width:<?php echo $modules_1314_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user17"  style="j51_module"/></div></div><?php } ?>
						<?php if ($this->countModules('user18')) { ?>
						<div class="moduleblock3" style="width:<?php echo $modules_1314_width ?>;"><div class="module_padding"><jdoc:include type="modules" name="user18"  style="j51_module"/></div></div><?php } ?>
					</div>
					</div>
				<?php } ?>
			<!--End Modules USER 13,14,15,16,17,18-->

			<div id="base">&nbsp;</div>
		<div id="base">&nbsp;</div>
	
		</div>
	</div>
<div id="base_bg">&nbsp;</div>
<div id="leftAd" style="position: fixed; left: 20px; bottom: 20px;<?php if ($_browserPlatform=='Android') {echo 'display: none;';}?>">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6625680287977173";
/* ProjectOr small */
google_ad_slot = "4521011948";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>		
<div class="inside" style="text-align: center;">
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-6625680287977173";
	/* Projector */
	google_ad_slot = "6744381586";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>
<div id="base_wrapper">

			<div id="base">&nbsp;</div>
<?php if ($this->countModules( 'banner' )) : ?>
		<div id="banner">
			<div class="inside">
			  <jdoc:include type="modules" name="banner" style="none" />
			</div>
		</div>
<?php endif; ?>
</div>

<?php if ($this->countModules( 'footer' )) : ?>
	  <div id="footer">
			<div class="inside">
			  <jdoc:include type="modules" name="footer" style="none" />
			</div>
	  </div>	
<?php endif; ?>


<!-- Footer Copyright - Do Not Remove -->
<?php
/**
 * This Joomla template is released under the Creative Commons Attribution 3.0 license.. 
 * This means that it can be used for private and commercial purposes, edited freely or 
 * redistributed as long as you keep the link back to Joomla51.
 * 
 * If you would like to remove this link, please purchase a license. The license price 
 * for this template is €10.00/$14.00 made payable via Paypal to info@joomla51.com
 * 
 * Please state the intended URL of your website in the comment section of your payment.
 * 
 * The license may be used for a single website only.
 *
 */
?>
<center><p><a href="http://www.joomla51.com"><strong>Joomla Templates</strong></a> by Joomla51.com</p></center>
<!--end of Footer Copyright -->


<jdoc:include type="modules" name="debug" />
</body> 
</html>