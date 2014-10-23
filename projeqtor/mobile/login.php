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

/* ============================================================================
 * Connnexion page of application.
 */
   require_once "../tool/projeqtor.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/login.php');
   $_SESSION['application']="PROJEQTOR";
   $title=(Parameter::getGlobalParameter('paramDbDisplayName'))?Parameter::getGlobalParameter('paramDbDisplayName'):i18n("applicationTitle");
?> <html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <title><?php echo $title;?></title>
  <!-- application stylesheet will go here -->
  <!-- dynamically apply native visual theme according to the browser user agent -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/dojo/1.9.4/dojox/mobile/deviceTheme.js"></script>
  <link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/dojo/1.9.4/dojox/mobile/themes/custom/custom.css"></link>
  <!-- dojo configuration options -->
  <script type="text/javascript">
		dojoConfig = {
		  async: true,
	    parseOnLoad: false
    };
  </script>
  <!-- dojo bootstrap -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/dojo/1.9.4/dojo/dojo.js"></script>
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
    		"dojox/mobile/ToolBarButton"
      ], function (parser) {
        // now parse the page for widgets
    	  parser.parse();
    });
  </script>
</head>
<body style="visibility:hidden;">
  <div id="settings" data-dojo-type="dojox/mobile/ScrollableView">
    <div data-dojo-type="dojox/mobile/Heading" data-dojo-props="fixed: 'top', label: 'ProjeQtOr xxx'">
      <span id="doneButton" data-dojo-type="dojox/mobile/ToolBarButton" onClick="alert('TEST');"
            data-dojo-props="label:'Connect', moveTo:'#', transition:'none'" style="float:right;"></span>
    </div>
    <div data-dojo-type="dojox/mobile/RoundRect">
      <div data-dojo-type="dojox/mobile/FormLayout" data-dojo-props="columns:'two'">
        <div>
            <label for="login"><span style="float:right;">Login</span></label>
            <fieldset>
                <input type="text" id="login" data-dojo-type="dojox/mobile/TextBox" data-dojo-props="value:''">
            </fieldset>
        </div>
        <div>
            <label for="password"><span style="float:right;">Password</span></label>
            <fieldset>
                <input type="text" id="password" data-dojo-type="dojox/mobile/TextBox" data-dojo-props="value:''">
            </fieldset>
        </div>
        <div>
            <label for="rememberme"><span style="float:right;">Remember me</span></label>
            <fieldset>
                <input type="checkbox" id="rememberme" data-dojo-type="dojox/mobile/Switch" value="on" leftLabel="Yes" rightLabel="No">
            </fieldset>
        </div>
       
    </div>
</div>
</div>
</body>
</html>
