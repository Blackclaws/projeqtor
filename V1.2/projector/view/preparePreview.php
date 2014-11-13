<?php
   require_once "../tool/projector.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/preparePreview.php'); 
?> 
<html>
<head>   
  <link rel="stylesheet" type="text/css" href="css/projector.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="css/projectorPrint.css" media="print" />
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: false'></script>
  <script type="text/javascript" src="../external/dojo/projectorDojo.js"></script>
  <script type="text/javascript"> 
    //dojo.require("dojox.grid.DataGrid");
    //dojo.require("dojox.form.FileInput");
  </script>
</head>

<body id="body" class="white">
<i> <?php echo i18n("messagePreview");?></i>
</body>
</html>