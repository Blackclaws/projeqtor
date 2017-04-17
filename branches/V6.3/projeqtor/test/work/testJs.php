<?php
/* ============================================================================
 * TESTS
 */
   require_once "../tool/projeqtor.php";
   header ('Content-Type: text/html; charset=UTF-8');
   //scriptLog('   ->/test/testJs.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="../../view/css/jsgantt.css" />
  <link rel="stylesheet" type="text/css" href="../../view/css/projeqtor.css" />
  <link rel="shortcut icon" href="../../view/img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="../../view/img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="../../view/js/jsgantt.js"></script>
  <script type="text/javascript" src="../../view/js/projeqtor.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../../view/js/projeqtorWork.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../../view/js/projeqtorDialog.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../../view/js/projeqtorFormatter.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString($paramDebugMode);?>'></script>
  <script type="text/javascript" src="../../external/dojo/projeqtorDojo.js"></script>
  <script type="text/javascript"> 
    dojo.require("dojo.data.ItemFileWriteStore");
    dojo.require("dojo.date");
    dojo.require("dojo.i18n");
    dojo.require("dojo.parser");
    dojo.require("dijit.Dialog"); 
    dojo.require("dijit.layout.BorderContainer");
    dojo.require("dijit.layout.ContentPane");
    dojo.require("dijit.Menu"); 
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.form.Textarea");
    dojo.require("dijit.form.ComboBox");
    dojo.require("dijit.form.CheckBox");
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
      currentLocale="<?php echo $currentLocale;?>";
      <?php 
      if (sessionValueExists('hideMenu')) {
        if (getSessionValue('hideMenu')!='NO') {
          echo "menuHidden=true;";
          echo "menuShowMode='" . getSessionValue('hideMenu') . "';";
        }
      }
      if (sessionValueExists('switchedMode')) {
        if (getSessionValue('switchedMode')!='NO') {
          echo "switchedMode=true;";
          echo "switchListMode='" . getSessionValue('switchedMode') . "';";
        }
      }
      ?>
      dijit.Tooltip.defaultPosition=["below", "right"];
      saveResolutionToSession();
      userBrowserLocaleForDates="";
      saveBrowserLocaleToSession();
    }); 
  </script>

<body class="blue">
<script>
 document.write("<b>TEST</b><br/><br/>");
 for (i=1; i<=31; i++) {
	 document.write("week for " + i + "/01/2011 = " + getWeek(i,01,2011) + '<br/>');
   
 }
</script>

</body>
</html>