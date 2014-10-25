<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/*
 * ============================================================================ Connnexion page of application.
 */
require_once "../tool/projeqtor.php";
header ( 'Content-Type: text/html; charset=UTF-8' );
scriptLog ( '   ->/view/login.php' );
$_SESSION ['application'] = "PROJEQTOR";
$title = (Parameter::getGlobalParameter ( 'paramDbDisplayName' )) ? Parameter::getGlobalParameter ( 'paramDbDisplayName' ) : i18n ( "applicationTitle" );
$title = htmlEncode ( $title, 'quotes' );
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
		parseOnLoad: false 
    };
  </script>
<!-- dojo bootstrap -->
<script type="text/javascript" src="../external/dojo/dojo.js"></script>
<!-- dojo application code -->
<script type="text/javascript">
    require([
    		"dojox/mobile/parser",
    		"dojox/mobile/compat",
    		"dojo/domReady!",
    		"dojox/mobile/ScrollableView",
    		"dojox/mobile/Heading",
    		"dojox/mobile/RoundRect",
    		"dojox/mobile/ListItem",
    		"dojox/mobile/Switch",
    		"dojox/mobile/RoundRectCategory",
    		"dojox/mobile/FormLayout",
    		"dojox/mobile/TextBox",
    		"dojox/mobile/ToolBarButton",
    		"dojox/mobile/ProgressIndicator",
    		"dojox/mobile/ContentPane"
      ], function (parser) {
        // now parse the page for widgets
    	  parser.parse();
    });
    var aesLoginHash="<?php echo md5(session_id());?>";
  </script>
  <script type="text/javascript" src="js/projeqtorMobile.js"></script>
</head>
<body style="visibility: hidden;">

	<div id="settings" data-dojo-type="dojox/mobile/ScrollableView">
		<div data-dojo-type="dojox/mobile/Heading" 
			data-dojo-props="fixed: 'top', label: '<?php echo $title;?>'">
			<span id="doneButton" data-dojo-type="dojox/mobile/ToolBarButton"
				onClick="connect(false);"
				data-dojo-props="label:'OK', moveTo:'#', transition:'none'"
				style="float: right;"></span>
		    <span style="float: left;"><img src="../view/img/logoMedium.png" style="height:40px" /></span>
		</div>
		<div  valign="middle" center="true" 
		  style="text-align: center;visibility: hidden; display:none;" 
		  id="loginResultDiv" data-dojo-type='dojox.mobile.RoundRect' shadow='true'></div>
		  
		<div data-dojo-type="dojox/mobile/RoundRect">
			<form id="loginForm" jsId="loginForm" name="loginForm"
				encType="multipart/form-data" action="" method="">
				<script type="dojo/method" event="onSubmit">             
          connect(false);
    	</script>
				<div data-dojo-type="dojox/mobile/FormLayout"
					data-dojo-props="columns:'two'">
					<div>
						<label for="login"><span style="float: right;"><?php i18nMobile('login');?></span></label>
						<fieldset>
							<input type="text" id="login"
								data-dojo-type="dojox/mobile/TextBox"
								data-dojo-props="value:'',placeHolder: '<?php i18nMobile('login');?>'">
							<input type="hidden" id="hashStringLogin" name="login"
								style="width: 200px" value="" />
						</fieldset>
					</div>
					<div>
						<label for="password"><span style="float: right;"><?php i18nMobile('password');?></span></label>
						<fieldset>
							<input type="password" id="password"
								data-dojo-type="dojox/mobile/TextBox"
								data-dojo-props="value:'',placeHolder: '<?php i18nMobile('password');?>'"> <input
								type="hidden" id="hashStringPassword" name="password"
								style="width: 200px" value="" />
						</fieldset>
					</div>
					<div>
						<label for="rememberme"><span style="float: right;"><?php i18nMobile('rememberMe');?></span></label>
						<fieldset>
							<input type="checkbox" id="rememberMe" name="rememberMe"
								data-dojo-type="dojox/mobile/Switch" value="on" leftLabel="<?php i18nMobile('buttonYes');?>"
								rightLabel="<?php i18nMobile('buttonNo');?>">
						</fieldset>
					</div>

				</div>
		    </form>
		</div>
		
	</div>
	<div id="wait" data-dojo-type="dojox.mobile.ProgressIndicator" startSpinning="true" size="50" 
	 valign="middle" center="true" class="mblProgWhite" style="position:absolute;top: 45%;visibility: hidden;"></div>
	
</body>
</html>
