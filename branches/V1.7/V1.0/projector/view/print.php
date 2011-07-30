<?php
/* ============================================================================
 * Print page of application.
 */
   require_once "../tool/projector.php";
   scriptLog('   ->/view/print.php'); 
   header ('Content-Type: text/html; charset=UTF-8');
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="css/projectorPrint.css" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo $paramDebugMode;?>'></script>
  <script type="text/javascript" src="../external/dojo/projectorDojo.js"></script>
  <script type="text/javascript"> 
    dojo.require("dojo.parser");
    dojo.require("dojo.i18n");
    //dojo.require("dojo.date.locale");
    dojo.addOnLoad(function(){
      //fnc = function() {
        //window.print();
        //alert('tmp');
        //top.dojo.byId('printPreview').hide();
        //alert('done');
      //};
      //setTimeout(fnc,1000);
    }); 
  </script>
</head>

<body id="body" >
  <div >
  <?php 
    include '../view/' . $_REQUEST['page']; 
  ?>
  </div>
</body>
</html>
