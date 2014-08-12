<?php   
   require_once "../tool/projeqtor.php";
   header ('Content-Type: text/html; charset=UTF-8');
   //scriptLog('   ->/view/dnd.php'); 
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  <link rel="stylesheet" type="text/css" href="../../view/css/jsgantt.css" />
  <link rel="stylesheet" type="text/css" href="../../view/css/projeqtor.css" />
  <script type="text/javascript" src="../../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString($paramDebugMode);?>'></script>
  <script language="javascript">
    dojo.require("dojo.dnd.Container");
    dojo.require("dojo.dnd.Manager");
    dojo.require("dojo.dnd.Source");
 
    dojo.subscribe("/dnd/drop", function(source, nodes, copy, target){
      moved= source.current;
    	obj = target.current;
      console.debug("drop de ",nodes[0].id,"sur:", obj.id);
    });
  </script>
</head>

<body>
<table dojoType="dojo.dnd.Source" class="dndContainer">
    <tr><td>Ordre</td><td>Libelle</td></tr>
    <tr id="dojoUnique1" class="dojoDndItem"><td>1</td><td>Item 1</td></tr>
    <tr id="dojoUnique2" class="dojoDndItem"><td>2</td><td>Item 2</td></tr>
    <tr id="dojoUnique3" class="dojoDndItem"><td>3</td><td>Item 3</td></tr>
    <tr id="dojoUnique4" class="dojoDndItem"><td>4</td><td>Item 4</td></tr>
</table>
</body>
</html>