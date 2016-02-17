<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2014 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 *
 * This file is a plugIn for ProjeQtOr.
 * This plugIn in not Open Source.
 * You must have bought the licence from Copyrigth owner to use this plgIn.
 *
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Main page for mobile application
 */
require_once "../tool/projeqtor.php";
header ( 'Content-Type: text/html; charset=UTF-8' );
scriptLog ( '   ->/view/login.php' );
$_SESSION ['application'] = "PROJEQTOR";
$title = (Parameter::getGlobalParameter ( 'paramDbDisplayName' )) ? Parameter::getGlobalParameter ( 'paramDbDisplayName' ) : i18n ( "applicationTitle" );
$title = htmlEncode ( $title, 'quotes' );
function i18nMobile($value) {
	echo htmlEncode ( i18n ( $value ), 'quotes' );
}
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta name="viewport"
	content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<title><?php echo $title;?></title>
<!-- application stylesheet will go here -->
  <link rel="stylesheet" type="text/css" href="css/projeqtorMobile.css"></link>
  <script type="text/javascript" src="../external/CryptoJS/rollups/md5.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/CryptoJS/rollups/sha256.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/phpAES/aes.js?version=<?php echo $version.'.'.$build;?>" ></script>
<!-- dynamically apply native visual theme according to the browser user agent -->
<script type="text/javascript"
	src="../external/dojox/mobile/deviceTheme.js"></script>

<!-- dojo configuration options -->
<script type="text/javascript">
		dojoConfig = {
				packages: [{
		            name: "dojo",
		            location: "../external/dojo"
		        }]
		async: true,
		baseUrl: './',
		mblHideAddressBar: true,
		parseOnLoad: true 
    };
  </script>
<!-- dojo bootstrap -->
<!--  <script type="text/javascript" src="../external/dojo/projeqtorMobileDojo.js"></script> -->
<script type="text/javascript" src="../external/dojo/dojo.js"></script>
<!-- dojo application code -->
<script type="text/javascript">
    require([
    		"dojox/mobile/parser",
    		"dojox/mobile/compat",
    		"dojo/domReady!",
    		"dojox/mobile/ScrollableView",
    		"dojox/mobile/View",
    		"dojox/mobile/Heading",
    		"dojox/mobile/RoundRect",
    		"dojox/mobile/RoundRectList",
    		"dojox/mobile/ListItem",
    		"dojox/mobile/Switch",
    		"dojox/mobile/RoundRectCategory",
    		"dojox/mobile/FormLayout",
    		"dojox/mobile/TextBox",
    		"dojox/mobile/TextArea",
    		"dojox/mobile/Button",
    		"dojox/mobile/ToolBarButton",
    		"dojox/mobile/ProgressIndicator",
    		"dojox/mobile/ContentPane",
    		"dojox/mobile/Badge"
      ], function (parser) {
        // now parse the page for widgets
    	  parser.parse();
    	  loadItems("<?php echo date('Y-m-d');?>");
    	  longFieldsSeparator='##!##!##!##!##';
    });
  </script>
  <script type="text/javascript" src="js/projeqtorMobile.js"></script>
</head>
<body  style="visibility: hidden;">

	<div id="list" data-dojo-type="dojox/mobile/ScrollableView" data-dojo-props="selected:true">
		<div data-dojo-type="dojox/mobile/Heading" 
			data-dojo-props="fixed: 'top', label: '<?php echo $title;?>'">
			<span id="menuButtonList" data-dojo-type="dojox/mobile/ToolBarButton"
				data-dojo-props="label:'Menu', moveTo:'menu', transition:'slide'"
				style="float: right;"></span>
		    <span style="float: left;"><img src="../view/img/logoMedium.png" style="height:40px" /></span>	
		</div>

		<div data-dojo-type="dojox/mobile/Heading" center="true" style="text-align:center">
		  <table style="width:100%" cellpadding="0" cellspacing="0"><tr>
		  <td style="width:10%">
		    <div onClick="loadItems('prev');" data-dojo-type="dojox/mobile/ToolBarButton" style="float:left">prev</div>
		  </td>
		  <td style="text-align:center">
		    <div onClick="loadItems('refresh');" id="dayCaption" data-dojo-type="dojox/mobile/ToolBarButton" center="true" style="text-align:center"></div>
		  </td>
		  <td style="width:10%;" align="right">
		    <div onClick="loadItems('next');" data-dojo-type="dojox/mobile/ToolBarButton" style="float:right">next</div>
		  </td>
		  </tr></table>
		</div>
		<div  valign="middle" center="true" 
		  style="text-align: center;visibility: hidden; display:none;" 
		  id="resultDivList" data-dojo-type='dojox.mobile.RoundRect' shadow='true'></div>
		  
	  <ul id="itemList" data-dojo-type="dojox/mobile/RoundRectList" class="roundRect roundRectList">
	    
	  </ul>
	</div>
	
	<div id="detail" data-dojo-type="dojox/mobile/ScrollableView">
		<div data-dojo-type="dojox/mobile/Heading" 
			data-dojo-props="fixed: 'top', back:'retour', moveTo:'list', label: '<?php echo $title;?>'">
			<span id="menuButtonDetail" data-dojo-type="dojox/mobile/ToolBarButton"
				data-dojo-props="label:'Sauver', moveTo:'', transition:''"
				style="float: right;" onClick="saveDetail();"></span>
		    	
	  </div>
	  <div  valign="middle" center="true" 
		  style="text-align: center;visibility: hidden; display:none;" 
		  id="resultDivDetail" data-dojo-type='dojox.mobile.RoundRect' shadow='true'></div>
	  <div data-dojo-type="dojox/mobile/RoundRect">
			<form id="detailForm" jsId="detailForm" name="detailForm"
				encType="multipart/form-data" action="" method="">
				<script type="dojo/method" event="onSubmit">             
          alert("prototype non finalisé");
    	  </script>
    	  <input type="hidden" name="mobileType" id="mobileType" />
    	  <input type="hidden" name="mobileId" id="mobileId" />
				<div data-dojo-type="dojox/mobile/FormLayout" style="width:100%;"
					data-dojo-props="columns:'two'">
					<div>
						<label for="login"><span style="float: right;"><?php i18nMobile('colIdProject');?></span></label>
						<fieldset style="width:100%;">
							<input disabled type="text" id="mobileProject" name="mobileProject	" data-dojo-type="dojox/mobile/TextBox"
								style="width:100%;" data-dojo-props="value:''" />
						</fieldset>
					</div>
					<div>
						<label for="login"><span style="float: right;"></span></label>
						<fieldset style="width:100%;">
							<input disabled type="text" id="mobileItem" name="mobileItem" data-dojo-type="dojox/mobile/TextBox"
								style="width:100%;" data-dojo-props="value:''" />
						</fieldset>
					</div>
					<div>
						<label for="mobileName"><span style="float: right;"><?php i18nMobile('colName');?></span></label>
						<fieldset>
							<input disabled type="text" id="mobileName" name="mobileName" data-dojo-type="dojox/mobile/TextBox"
								style="width:100%;" data-dojo-props="value:''" />
						</fieldset>
					</div>
					<div>
						<label for="mobileDescription"><span style="float: right;"><?php i18nMobile('colDescription');?></span></label>
						<fieldset>
							<textarea disabled id="mobileDescription" name="mobileDescription" data-dojo-type="dojox/mobile/TextArea" 
							  style="width:100%;" maxLength="400" data-dojo-props="value:''" ></textarea>
						</fieldset>
					</div>
					<div>
						<label for="mobileResult"><span style="float: right;"><?php i18nMobile('colResult');?></span></label>
						<fieldset>
							<textarea id="mobileResult" name="mobileResult" data-dojo-type="dojox/mobile/TextArea"
								style="width:100%;" maxLength="400" data-dojo-props="value:''" ></textarea>
						</fieldset>
					</div>
					
				</div>
		  </form>
		  <div style="width:100%; text-align:center"><?php i18nMobile('sectionNote');?></div>
		  <div>		 
				<ul id="mobileNotes" data-dojo-type="dojox/mobile/RoundRectList" class="roundRect roundRectList">
	      </ul>	
			</div>
		</div>
	</div>

	<div id="menu" data-dojo-type="dojox/mobile/ScrollableView">
		<div data-dojo-type="dojox/mobile/Heading" 
		   data-dojo-props="fixed: 'top', back:'retour', moveTo:'list', label: '<?php echo $title;?>'"></div>
		  <div style="margin:5px; padding:5px">
		  <button data-dojo-type="dojox/mobile/Button" center="true" class="mblGreyButton" style="width:100%"
		   data-dojo-props='label:"<?php i18nMobile("disconnect");?>", 
		   onClick:function(e){ disconnect();return true; }'>
		 </button>
		 </div>
	</div>
	
	<div id="wait" data-dojo-type="dojox/mobile/ProgressIndicator" startSpinning="true" size="50" 
	 valign="middle" center="true" class="mblProgWhite" style="position:absolute;top: 45%;visibility: hidden;"></div>
	
</body>

</html>
