<?php
defined('_JEXEC') or die;
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';
$firstTimeAccess=true;
if (isset($_SESSION['firstTimeAccess'])) {
	$firstTimeAccess=false;
} else {
	$_SESSION['firstTimeAccess']=false;
}
// Create alias for $this object reference:
$document = & $this;
// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;
// Initialize $view:
$view = $this->artx = new ArtxPage($this);
$view->componentWrapper();
$app                = JFactory::getApplication();
$templateparams     = $app->getTemplate(true)->params;
// logo text var
$show_header                = ($this->params->get("showHeader", 1)  == 0)?"false":"true";
$show_logo                  = ($this->params->get("showLogo", 1)  == 0)?"false":"true";
$logoText = (trim($this->params->get('textoflogo'))=='') ? $config->sitename :  $this->params->get('textoflogo');
$sloganText = (trim($this->params->get('textofslogan'))=='') ? $config->sitename :  $this->params->get('textofslogan');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $document->language; ?>"
	lang="<?php echo $document->language; ?>" dir="ltr">
<head>
	  <link rel="shortcut icon" href="logo.ico" type="image/x-icon" />
	  <link rel="icon" href="logo.ico" type="image/x-icon" />
	  <jdoc:include type="head" />
	  <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css"	type="text/css" />
	  <link rel="stylesheet" 	href="<?php echo $document->baseurl; ?>/templates/system/css/general.css"	type="text/css" />
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
    <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" type="text/css" media="screen" /><![endif]-->
    <script type="text/javascript">if ('undefined' != typeof jQuery) document._artxJQueryBackup = jQuery;</script>
    <script type="text/javascript"
	    src="<?php echo $templateUrl; ?>/jquery.js">
	  </script>
    <script type="text/javascript">jq=jQuery.noConflict();</script>
    <script type="text/javascript"
	   src="<?php echo $templateUrl; ?>/script.js">
	  </script>
    <script type="text/javascript">if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>
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
			    if (document.getElementById("leftAd")) {
				  document.getElementById("leftAd").style.display='none';
				}
			  }
			  if (<?php echo date('m');?>==1) {
				showNewYearNow(500,0);
			  }
			}
			
			function slideImage() {
				jq('#imageslider').fadeOut(fadeTimer, function() {
					var urlImage='url('+urlImageStart+'/'+slideArray[slideIndex]+')';
					jq('#imageslider').css('background-image',urlImage);
					//alert(jq('#imageslider').css('background-image'));
					setTimeout("slideImageShow();",fadePause);
				});
			}	
			function slideImageShow() {
				jq('#imageslider').fadeIn(fadeTimer, function() {
				   slideIndex++;
				   if (slideIndex>=slideArray.length) slideIndex=0;
				   setTimeout("slideImage();",slideTimer);					
				});
			}
			slideTimer=3000;
			fadeTimer=1500;
			fadePause=500;
			slideIndex=0;
			slideArray=new Array("planning.png","tickets.png","today.png");
			var urlImageStart='<?PHP echo $_SERVER['REQUEST_URI'];?>';
		    if (urlImageStart.indexOf("/index.php")>0) {urlImageStart=urlImageStart.substring(0,urlImageStart.indexOf("index.php"));}
			urlImageStart=urlImageStart+'images/header';
		</script>
    <script type="text/javascript">
			jq(document).ready(function(){
			  setTimeout("slideImage();",fadeTimer*2);
			  setTimeout("jq('#welcomeDiv').fadeOut(fadeTimer, function() { });",fadeTimer);
			});
		</script>
</head>
<body style="" onLoad="loadBody();">
	<div style="position: fixed !important; left: 10px; top: 60px; z-index: 999999;">
		<g:plusone></g:plusone>
	</div>
	<?PHP if ($firstTimeAccess) {?>
	<div style="display: block; position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; 
		text-align: center; vertical-align: middle; background-color: #fafafa; color: #545281; z-index:9998;"
		id="welcomeDiv" onClick="hideWelcome();">
		<div style="height:100px"></div>
		<img style="top:20%" width="400px" src="images/logoBig.png" />
		<div style="font-size: 30pt; font-family: Segoe Print, Verdana, Arial;">Welcome
			to ProjeQtOr</div>
		<div>
			<i>Enlighten your projects with Quality based Project Organizer</i>
		</div>
	</div>

	
	<div
		style="z-index:9999;display: none; position: fixed; left: 25%; top: 25%; width: 50%; height: 50%; text-align: center; vertical-align: middle; background-color: #545281; border-radius: 30px; -moz-border-radius: 30px;"
		id="newyeardiv" onClick="hideNewYearNow(10,0)">
		<div
			style="top: 25%; width: 100%; height: 50%; font-size: 50px; color: white;">
			<br /> <br /> <I>HAPPY NEW YEAR <?PHP echo date('Y');?> </I><br /> <br />
		</DIV>
		<div
			style="top: 25%; width: 100%; height: 30%; font-size: 30px; color: white;">
			<br /> <br />May you succeed in all your projects !
		</div>
		<div style="width: 100%; height: 5%; font-size: 10pt; color: grey;">
			<br /> <br />Click on this message to hde it instantly
		</div>
	</div>
	<?PHP }?>
	<!-- RIGHT : floating -->
	<?php if ($view->containsModules('right')) : ?>
	<div class="td-layout-cell td-sidebar1"
		style="position: absolute; top: 0px; right: 0px; width: 240px; z-index: 0;">
		<?php echo $view->position('right', 'td-block'); ?>
		<div class="cleared"></div>
	</div>
	<?php endif; ?>
	<div class="cleared reset-box"></div>

	<!-- MAIN MENU, EXTRA1, EXTRA2 -->
	<?php if ($view->containsModules('mainmenu', 'extra1', 'extra2')) : ?>
	<div class="td-fix" style="position: fixed">
		<div class="td-bar td-nav  metal linear">
			<div class="td-nav-outer">
				<div class="td-nav-wrapper">
					<div class="td-nav-inner">
					<?php echo $view->position('mainmenu'); ?>
					<?php   if ($view->containsModules('extra1')) : ?>
						<div class="td-hmenu-extra1">
						<?php echo $view->position('extra1'); ?>
						</div>
						<?php   endif; ?>
						<?php   if ($view->containsModules('extra2')) : ?>
						<div class="td-hmenu-extra2">
						<?php echo $view->position('extra2'); ?>
						</div>
						<?php   endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="td-main metal linear"></div>
	<div class="cleared reset-box"></div>
	<?php endif; ?>

	<!-- HEADER -->
	<?php if($templateparams->get('show-header',1)) :?>
	<!-- ANIMATION -->
	<?php   if (JRequest::getVar('view') == 'featured') : ?>
		  <div style="position:absolute; top:40px; left:5px">
		  <a href="http://project-management-software.findthebest.com/l/167/Project-Or-RIA?utm_source=direct&utm_medium=badge&utm_campaign=projeqtor_projects&utm_term=smart_choice_custom" target="_blank">
      <img src="http://img3.findthebest.com/sites/default/files/220/media/images/_1375800.png" height="180" style="max-width: 262px" alt="Best of FindTheBest" border="0" />
      </a>
    </div> 	
	<div class="td-header" style="z-index: -1">
		<div id="imageslider" width="100%" height="200px"
			style="height: 250px;"></div>
		<!-- <object type="application/x-shockwave-flash" data="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/header.swf" width="100%" height="250">
					<param name="wmode" value="transparent" />
				    <param name="movie" value="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/header.swf" />
				</object>-->
		<!-- LOGO -->
			<?php     if($templateparams->get('logoType')=='image'):?> 
		<div
			style="font-family: Segoe Print, Segoe UI, Brush Script MT, cursive; color: #545281; position: absolute; left: 350px; top: 50px; z-index: -10;">
			<div style="font-size: 500%; font-weight: bold">
				<i>ProjeQtOr</i>
			</div>
			<div style="font-size: 200%;">Enlighten your projects</div>
			<div style="font-size: 200%;">with Quality based Project Organizer</div>
		</div>
		<div id="logo">
			<a href="index.php"><img
				src="<?php echo $templateUrl; ?>/images/logo.png" alt=""
				height="230px" /> </a>
		</div>
		<!-- TEXT -->
		<?php     else: ?>
		<div class="td-logo">
			<h1 class="td-logo-name">
				<a href="<?php echo $document->baseurl; ?>/"><?php echo $this->params->get('textoflogo'); ?>
				</a>
			</h1>
			<h2 class="td-logo-text">
			<?php echo $this->params->get('textofslogan'); ?>
			</h2>
		</div>
		<?php     endif; ?>
		<!-- END: LOGO -->
	</div>

	<?php   endif; ?>

	<?php endif; ?>
	<div class="cleared reset-box"></div>
	<div class="td-box td-sheet">
		<div class="td-box-body td-sheet-body">
		<?php echo $view->position('banner1', 'td-nostyle'); ?>
		<?php echo $view->positions(array('top1' => 33, 'top2' => 33, 'top3' => 34), 'td-block'); ?>
			<div class="td-layout-wrapper">
				<div class="td-content-layout">
					<div class="td-content-layout-row">
						<div class="td-layout-cell td-content">

						<?php
						echo $view->position('banner2', 'td-nostyle');
						if ($view->containsModules('breadcrumb'))
						echo artxPost($view->position('breadcrumb'));
						echo $view->positions(array('user1' => 50, 'user2' => 50), 'td-article');
						echo $view->position('banner3', 'td-nostyle');
						if ($view->hasMessages())
						echo artxPost('<jdoc:include type="message" />');
						echo '<jdoc:include type="component" />';
						echo $view->position('user3', 'td-block');
						echo $view->positions(array('user4' => 50, 'user5' => 50), 'td-article');
						echo $view->position('banner5', 'td-nostyle');
						?>

							<div class="cleared"></div>
						</div>


					</div>
				</div>
			</div>
			<div class="cleared"></div>


			<?php echo $view->positions(array('user7' => 33, 'user8' => 33, 'user9' => 34), 'td-block'); ?>
			<?php //echo $view->position('banner6', 'td-nostyle'); ?>


			<div class="cleared"></div>
		</div>
	</div>
	<div class="cleared"></div>
	<p class="td-page-footer"></p>

	<div class="cleared"></div>
	</div>

	<?php echo $view->position('debug'); ?>
</body>
</html>
