<?php 
/* ============================================================================
 * Connnexion page of application.
 */
   require_once "../tool/projector.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/login.php'); 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="css/projector.css" />
  <script type="text/javascript" src="js/projector.js" ></script>
  <script type="text/javascript" src="js/projectorDialog.js" ></script>
  <script type="text/javascript" src="../external/dojo/dojo.js"
    djConfig='modulePaths: {i18n: "../../tool/i18n"},
              parseOnLoad: true, 
              isDebug: <?php echo getBooleanValueAsString($paramDebugMode);?>'></script>
  <script type="text/javascript" src="../external/dojo/projectorDojo.js"></script>
  <script type="text/javascript"> 
    dojo.require("dojo.parser");
    dojo.require("dojo.i18n");
    dojo.require("dijit.Dialog"); 
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.Button");
    dojo.require("dijit.form.Form");
    dojo.require("dijit.form.FilteringSelect");
    var fadeLoading=<?php echo getBooleanValueAsString($paramFadeLoadingMode);?>;
    dojo.addOnLoad(function(){
      currentLocale="<?php echo $currentLocale?>";
      saveResolutionToSession();
      saveBrowserLocaleToSession();
      dijit.Tooltip.defaultPosition=["below","right"];
      dojo.byId('login').focus();
      <?php 
        //echo "dojo.byId('body').className='" . getTheme() . "';";
      ?>
      var changePassword=false;
      hideWait();
    }); 
  </script>
</head>

<body class="<?php echo getTheme();?>" onLoad="hideWait();" style="overflow: auto; ">
  <div id="waitLogin" >
  </div> 
  <table align="center" width="100%" height="100%" class="background"><tr height="100%"><td width="100%">
  <table  align="center" >
    <tr >
      <td  rowspan="2" width="140px" valign="top">
        <img src="img/logoFull.gif">
      </td>
      <td  width="550px">
        <img src="img/titleFull.gif">
      </td>
    <tr  height="250px">
      <td align="left" valign="middle">
        <div  id="formDiv" dojoType="dijit.layout.ContentPane" region="center" >
          <form  dojoType="dijit.form.Form" id="loginForm" jsId="loginForm" name="loginForm" encType="multipart/form-data" action="" method="" >
             <script type="dojo/method" event="onSubmit" >
              dojo.byId('login').focus();
              changePassword=false;
    		  loadContent("../tool/loginCheck.php","loginResultDiv", "loginForm");
    		  return false;        
            </script>
            <table>
              <tr>     
                <td class="label"><label><?php echo i18n('login');?>&nbsp;:&nbsp;</label></td>
                <td><input tabindex="1" id="login" name="login" style="width:200px" type="text"  dojoType="dijit.form.TextBox" /></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label"><label><?php echo i18n('password');?>&nbsp;:&nbsp;</label></td>
                <td><input tabindex="2" id="password" name="password" style="width:200px" type="password"  dojoType="dijit.form.TextBox" /></td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label"><label>&nbsp;</label></td>
                <td>
                  <button tabindex="3" type="submit" id="loginButton" dojoType="dijit.form.Button" showlabel="true">OK
                    <script type="dojo/connect" event="onClick" args="evt">
                	  return false;
                    </script>
                  </button>
                </td>
              </tr>
<?php 
$showPassword=true;
if (isset($lockPassword)) {
  if (getBooleanValue($lockPassword)) {
    $showPassword=false;
  }
}
if ($showPassword) { 
?>              
              <tr>
                <td class="label"><label>&nbsp;</label></td>
                <td>  
                   <button tabindex="4" id="passwordButton" dojoType="dijit.form.Button" showlabel="true">
                     <?php echo i18n('buttonChangePassword') ?>
                     <script type="dojo/connect" event="onClick" args="evt">
                       dojo.byId('login').focus();
                       changePassword=true;
                       loadContent("../tool/loginCheck.php?resetPassword=true","loginResultDiv","loginForm");
                    </script>
                  </button>  
                </td>
              </tr>
<?php }?>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td class="label"><label>&nbsp;</label></td>
                <td>
                  <div id="loginResultDiv" dojoType="dijit.layout.ContentPane" region="center" >
                  </div>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </td>
    </tr>
  </table>
  </td></tr></table>
</body>
</html>
