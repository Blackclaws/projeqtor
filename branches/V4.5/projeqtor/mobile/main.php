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
 * Main page of application.
 * This page includes Frame definitions and framework requirements.
 * All the other pages are included into this one, in divs, using Ajax.
 * 
 *  Remarks for deployment :
 *    - set isDebug:false in djConfig
 */
$mobile=true;
require_once "../tool/projeqtor.php";
header ('Content-Type: text/html; charset=UTF-8');
scriptLog('   ->/mobile/main.php');
if (Sql::getDbVersion()!=$version) {
	//Here difference of version is an important issue => disconnect and get back to login page.
	//session_destroy();
	Audit::finishSession();
	include_once 'login.php';
	exit;
}
$currency=Parameter::getGlobalParameter('currency');
$currencyPosition=Parameter::getGlobalParameter('currencyPosition');
checkVersion(); 
// Set Project & Planning element as cachable : will not change during operation
SqlElement::$_cachedQuery['Project']=array();
SqlElement::$_cachedQuery['ProjectPlanningElement']=array();
SqlElement::$_cachedQuery['PlanningElement']=array();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="keywork" content="projeqtor, project management" />
  <meta name="author" content="projeqtor" />
  <meta name="Copyright" content="Pascal BERNARD" />
  <title><?php echo (Parameter::getGlobalParameter('paramDbDisplayName'))?Parameter::getGlobalParameter('paramDbDisplayName'):i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="css/projeqtor.css" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="../external/CryptoJS/rollups/md5.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/CryptoJS/rollups/sha256.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/phpAES/aes.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/dojo/dojo.js?version=<?php echo $version.'.'.$build;?>"
    djConfig='modulePaths: {"i18n":"../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString(Parameter::getGlobalParameter('paramDebugMode'));?>'></script>
  <script type="text/javascript"> 
    dojo.require("dojo.parser");
    var aesLoginHash="<?php echo md5(session_id());?>";
    var paramCurrency='<?php echo $currency;?>';
    var paramCurrencyPosition='<?php echo $currencyPosition;?>';
    var paramWorkUnit='<?php echo Parameter::getGlobalParameter('workUnit');?>';
    if (! paramWorkUnit) paramWorkUnit='days';
    var paramHoursPerDay='<?php echo Parameter::getGlobalParameter('dayTime');?>';
    if (! paramHoursPerDay) paramHoursPerDay=8;
    dojo.byId("loadingDiv").style.visibility="hidden";
    dojo.byId("loadingDiv").style.display="none";
    dojo.byId("mainDiv").style.visibility="visible";
  </script>
</head>
<body id="body" style='background-color: #000000'>
<div id="loadingDiv"
 style="position:relative; visibility: visible; display:block; width:100%; height:100%; margin:0; padding:0; border:0">  
  <table align="center" width="100%" height="100%" class="loginBackground">
    <tr height="100%">
      <td width="100%" align="center">
        <div class="position: relative; background loginFrame" >
        <table align="center" >
          <tr style="height:10px;" >
            <td align="left" style="height: 1%;" valign="top">
              <div style="position: relative; left: -5px;width: 300px; height: 54px; background-size: contain; background-repeat: no-repeat;
              background-image: url(<?php echo (file_exists("../logo.gif"))?'../logo.gif':'../view/img/titleSmall.png';?>);">
              </div>
            </td>
          </tr>
          <tr style="height:100%" height="100%">
            <td style="height:99%" align="left" valign="middle">
              <div dojoType="dijit.layout.ContentPane" region="center" style="width: 470px; height:210px;overflow:hidden;text-align:center;">
              <br/><br/>Loading ...
              <div id="waitLogin"></div>               
              </div>
            </td>
          </tr>
        </table>
        </div>
      </td>
    </tr>
  </table>
</div>
<div id="mainDiv" style="visibility: hidden;">
  <div id="wait" >
  </div>
</div>
  
</body>
</html>
