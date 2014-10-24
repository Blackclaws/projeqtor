<?php
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
<link rel="stylesheet" type="text/css"
	href="../external/dojox/mobile/themes/custom/custom.css"></link>
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
    		"dojox/mobile/View",
    		"dojox/mobile/Heading",
    		"dojox/mobile/RoundRect",
    		"dojox/mobile/ListItem",
    		"dojox/mobile/Switch",
    		"dojox/mobile/RoundRectCategory",
    		"dojox/mobile/FormLayout",
    		"dojox/mobile/TextBox",
    		"dojox/mobile/Button",
    		"dojox/mobile/ToolBarButton",
    		"dojox/mobile/ProgressIndicator",
    		"dojox/mobile/ContentPane"
      ], function (parser) {
        // now parse the page for widgets
    	  parser.parse();
    	  loadItems("<?php echo date('Ymd');?>");
    });
  </script>
  <script type="text/javascript" src="js/projeqtorMobile.js"></script>
</head>
<body  style="visibility: hidden;">

	<div id="list" data-dojo-type="dojox/mobile/ScrollableView" data-dojo-props="selected:true">
		<div data-dojo-type="dojox/mobile/Heading" 
			data-dojo-props="fixed: 'top', label: '<?php echo $title;?>'">
			<span id="menuButton" data-dojo-type="dojox/mobile/ToolBarButton"
				data-dojo-props="label:'Menu', moveTo:'menu', transition:'slide'"
				style="float: right;"></span>
		    <span style="float: left;"><img src="../view/img/logoMedium.png" style="height:40px" /></span>	
		</div>

		<div  valign="middle" center="true" 
		  style="text-align: center;visibility: hidden; display:none;" 
		  id="resultDiv" data-dojo-type='dojox.mobile.RoundRect' shadow='true'></div>
	</div>
	
	<div id="menu" data-dojo-type="dojox/mobile/ScrollableView">
		<div data-dojo-type="dojox/mobile/Heading" 
		   data-dojo-props="fixed: 'top', back:'retour', moveTo:'list'">Menu</div>
		    
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
