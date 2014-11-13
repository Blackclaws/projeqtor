<?php
/* ============================================================================
 * Connnexion page of application.
 */
   require_once "../tool/projector.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/passwordChange.php'); 
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
    dojo.require("dojox.form.PasswordValidator");
    var fadeLoading=<?php echo getBooleanValueAsString($paramFadeLoadingMode);?>;
    dojo.addOnLoad(function(){
      currentLocale="<?php echo $currentLocale?>";
      hideWait();
      changePassword=false;
      dojo.byId('dojox_form__NewPWBox_0').focus();
    }); 
  </script>
</head>

<body class="<?php echo getTheme();?>" >
  <div id="wait" >
  </div> 
  <table width="100%" height="100%" class="background"><tr height="100%"><td width="100%">
  <table  align="center" >
    <tr >
      <td  rowspan="2" width="140px" valign="top">
        <img src="img/logoFull.gif" />
      </td>
      <td  width="500px">
        <img src="img/titleFull.gif" />
      </td>
    <tr  height="200px">
      <td align="left">
        <div  id="formDiv" dojoType="dijit.layout.ContentPane" region="center" >
          <form  dojoType="dijit.form.Form" id="passwordForm" jsId="passwordForm" name="passwordForm" encType="multipart/form-data" action="" method="" >
             <script type="dojo/method" event="onSubmit" >
              dojo.byId('goButton').focus();
              loadContent("../tool/changePassword.php","passwordResultDiv", "passwordForm");
    		  return false;       
            </script>     
            <div dojoType="dojox.form.PasswordValidator" name="password">
                <label class="label" style="width:200px;"><?php echo i18n('newPassword');?>&nbsp;:&nbsp;</label>
                <input type="password" pwType="new" /><br/>
                <br/>
                <label class="label" style="width:200px;"><?php echo i18n('validatePassword');?>&nbsp;:&nbsp;</label>
                <input type="password" pwType="verify" /><br/>
            </div>            
            <br/>
            <label class="label" style="width:200px;">&nbsp;</label>
            <button type="submit" style="width:200px" id="goButton" dojoType="dijit.form.Button" showlabel="true">OK
              <script type="dojo/connect" event="onClick" args="evt">
                loadContent("../tool/changePassword.php","passwordResultDiv", "passwordForm");
              </script>
            </button>
            <br/><br/>
            <?php if ( $user->password != md5($paramDefaultPassword) ) {?>
            <label class="label" style="width:200px;">&nbsp;</label>
            <button style="width:200px" id="cancelButton" dojoType="dijit.form.Button" showlabel="true"><?php echo i18n('buttonCancel');?>
              <script type="dojo/connect" event="onClick" args="evt">
                showWait(); 
                window.location=".";
              </script>
            </button>  
            <?php }?>  
          </form>
        </div>
        <br/>
        <label class="label">&nbsp;</label>
        <div id="passwordResultDiv" dojoType="dijit.layout.ContentPane" region="bottom" >
        </div>
      </td>
    </tr>
  </table>
  </td></tr></table>
</body>
</html>
