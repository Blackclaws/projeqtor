<?php
/* ============================================================================
 * Print page of application.
 */
   require_once "../tool/projector.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/print.php'); 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="css/jsgantt.css" />
  <link rel="stylesheet" type="text/css" href="css/projectorPrint.css" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString($paramDebugMode);?>'></script>
  <script type="text/javascript" src="../external/dojo/projectorDojo.js"></script>
  <script type="text/javascript"> 
    dojo.require("dojo.parser");
    dojo.require("dojo.i18n");
    //dojo.require("dojo.date.locale");
    dojo.addOnLoad(function(){
      //fnc = function() {
      <?php if (array_key_exists('directPrint', $_REQUEST)) {?>
        window.print();
        //window.close();
        <?php }?>
        //alert('tmp');
        //top.dojo.byId('printPreview').hide();
        //alert('done');
      //};
      //setTimeout(fnc,1000);
    }); 
  </script>
</head>

<body id="bodyPrint" class="white" onload="top.hideWait();";>
  <?php 
  $includeFile=$_REQUEST['page'];
  if (! substr($_REQUEST['page'],0,3)=='../') {
    $includeFile.='../view/';
  }
  if (strpos($includeFile,'?')>0) {
    $params=substr($includeFile,strpos($includeFile,'?')+1);
    $includeFile=substr($includeFile,0,strpos($includeFile,'?'));
    $paramArray=explode('&',$params);
    foreach ($paramArray as $param) {
      $par=explode('=',$param);
      $_REQUEST[$par[0]]=$par[1];
    }
  }
  include $includeFile;
  ?>
</body>
</html>
