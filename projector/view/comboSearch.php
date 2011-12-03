<?php
/* ============================================================================
 * Print page of application.
 */
   require_once "../tool/projector.php";
   ob_start();
   scriptLog('   ->/view/comboSearch.php'); 
   $comboDetail=true;
   $mode="";
   if (array_key_exists('mode', $_REQUEST)) {
     $mode=$_REQUEST['mode'];
   }
 ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="css/projector.css" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="js/projector.js" ></script>
  <script type="text/javascript" src="js/projectorWork.js" ></script>
  <script type="text/javascript" src="js/projectorDialog.js" ></script>
  <script type="text/javascript" src="js/projectorFormatter.js" ></script>
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString($paramDebugMode);?>'></script>
  <script type="text/javascript" src="../external/dojo/projectorDojo.js"></script>
  <script type="text/javascript"> 
    dojo.require("dojo.data.ItemFileWriteStore");
    dojo.require("dojo.date");
    dojo.require("dojo.i18n");
    dojo.require("dojo.parser");
    dojo.require("dijit.Dialog"); 
    dojo.require("dijit.Tooltip");
    dojo.require("dijit.layout.BorderContainer");
    dojo.require("dijit.layout.ContentPane");
    dojo.require("dijit.Menu"); 
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.form.Textarea");
    dojo.require("dijit.form.ComboBox");
    dojo.require("dijit.form.CheckBox");
    dojo.require("dijit.form.RadioButton");
    dojo.require("dijit.form.DateTextBox");
    dojo.require("dijit.form.TimeTextBox");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.NumberTextBox");
    dojo.require("dijit.form.Button");
    dojo.require("dijit.ColorPalette");
    dojo.require("dijit.form.Form");
    dojo.require("dijit.form.FilteringSelect");
    dojo.require("dijit.form.MultiSelect");
    dojo.require("dijit.form.NumberSpinner");
    dojo.require("dijit.Tree"); 
    dojo.require("dijit.TitlePane");
    dojo.require("dojox.grid.DataGrid");
    dojo.require("dojox.form.FileInput");
    dojo.require("dojo.dnd.Container");
    dojo.require("dojo.dnd.Manager");
    dojo.require("dojo.dnd.Source");
    dojo.addOnLoad(function(){

    });
  </script>
</head>
<body id="body" class="<?php echo getTheme();?>" onload="top.hideWait();";>
  <input type="hidden" id="comboDetail" name="comboDetail" value="true" />
  <input type="hidden" id="comboDetailId" name="comboDetailId" value="" />
  <input type="hidden" id="comboDetailName" name="comboDetailName" value="" />
  <?php 
  if ($mode=='search') {
    echo '<div id="listDiv" style="height:100%" dojoType="dijit.layout.ContentPane" region="top" splitter="true">';
    include 'objectList.php';
    echo '</div>';
  } else if ($mode=='new'){
    echo '<div id="detailDiv" style="height:100%" dojoType="dijit.layout.ContentPane" region="center" splitter="false">';
    include 'objectDetail.php';
    echo '</div>';    
  }
  ?>
</body>
</html>