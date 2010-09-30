<?php
/* ============================================================================
 * Main page of application.
 * This page includes Frame definitions and framework requirements.
 * All the other pages are included into this one, in divs, using Ajax.
 * 
 *  Remarks for deployment :
 *    - set isDebug:false in djConfig
 */
   require_once "../tool/projector.php";
   header ('Content-Type: text/html; charset=UTF-8');
   scriptLog('   ->/view/main.php'); 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  
  <title><?php echo i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="css/projector.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="css/projectorPrint.css" media="print" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="../external/jsgantt/jsgantt.css" />
  <script language="javascript" src="../external/jsgantt/jsgantt.js"></script>
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
    //dojo.require("dojo.dnd.Source");
    
    var fadeLoading=<?php echo getBooleanValueAsString($paramFadeLoadingMode);?>;
    //var refreshUpdates="<?php echo (array_key_exists('refreshUpdates',$_SESSION))?$_SESSION['refreshUpdates']:'YES';?>";
    var refreshUpdates="YES";
    dojo.addOnLoad(function(){
      currentLocale="<?php echo $currentLocale;?>";
      dijit.Tooltip.defaultPosition=["below", "right"];
      addMessage("<?php echo i18n('welcomeMessage');?>");
      <?php 
      if (array_key_exists('theme',$_SESSION) ) {
        echo "dojo.byId('body').className='" . $_SESSION['theme'] . "';";
      }
      ?>
      saveResolutionToSession();
      saveBrowserLocaleToSession();
      loadContent("today.php","centerDiv");
      hideWait();
    }); 
  </script>
</head>

<body id="body" class="blue" onbeforeunload="return beforequit();" onUnload="quit();">
<div id="mainDiv" >
  <div id="wait" >
  </div> 
  <div class="container" dojoType="dijit.layout.BorderContainer">    
    <div id="toolBarDiv" dojoType="dijit.layout.ContentPane" region="top" >
     <!-- Menu -->
    </div>    
    <div id="leftDiv" dojoType="dijit.layout.ContentPane" region="left" splitter="true">
      <div class="container" dojoType="dijit.layout.BorderContainer" >
        <div id="logoDiv" dojoType="dijit.layout.ContentPane" region="top">
          <script> 
            aboutMessage="<?php echo $aboutMessage;?>";
            aboutMessage+='Dojo '+dojo.version+'<br/><br/>';
          </script>
          <?php 
            $width=300;
            if (array_key_exists('screenWidth',$_SESSION)) {
              $width = $_SESSION['screenWidth'] * 0.2;
            }
            $zoom=round($width/300*100, 0);  
          ?>
          <div id="logoTitleDiv" onclick="showAbout(aboutMessage);" title="<?php echo i18n('aboutMessage');?>" > 
          </div>
        </div>
        <div id="mapDiv" dojoType="dijit.layout.ContentPane" region="center">
          <?php include "menuTree.php"; ?>
        </div>
        <div id="messageDiv" dojoType="dijit.layout.ContentPane" region="bottom" splitter="true">
        </div>
      </div> 
    </div>    
    <div id="centerDiv" dojoType="dijit.layout.ContentPane" region="center" >      
    </div>
    <div id="statusBarDiv" dojoType="dijit.layout.ContentPane" region="bottom">
      <table width="100%">
        <tr>
          <td width="20%" title="<?php echo i18n('disconnectMessage');?>" onclick="disconnect();" style="vertical-align: middle; text-align: left; cursor: pointer; ">
            <table>
              <tr>
                <td>
                  <img src="img/disconnect.gif" />
                </td>
                <td>
                  &nbsp;<?php echo i18n('disconnect') . '&nbsp;[' . $_SESSION["user"]->name . ']'; ?>
                </td>
              </tr>
            </table>         
          </td>
          <!-- <td width="30%" >
            <div id="statusBarProgressDiv" style="text-align: left;">           
            </div>
          </td> -->
          <td width="60%" >
            <div id="statusBarMessageDiv" style="text-align: left">
              <?php htmlDisplayDatabaseInfos();?>
            </div>
          </td>
          <td width="20%" title="<?php echo i18n('infoMessage');?>" > 
            <div width="100%" id="statusBarInfoDiv" style="text-align: right;">
              <?php htmlDisplayInfos();?>
            </div>
          </td>
        </tr>
      </table>  
    </div>    
  </div>
</div>

<div id="dialogInfo" dojoType="dijit.Dialog" title="<?php echo i18n("dialogInformation");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/info.png" />
      </td>
      <td>
        <div id="dialogInfoMessage">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <br/>
        <button dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogInfo').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogError" dojoType="dijit.Dialog" title="<?php echo i18n("dialogError");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/error.png" />
      </td>
      <td>
        <div id="dialogErrorMessage" class="messageERROR">
        </div>
      </td>
    </tr>
    <tr height="50px">
      <td colspan="2" align="center">
        <?php echo i18n("contactAdministrator");?>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <button dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogError').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogAlert" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAlert");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/alert.png" />
      </td>
      <td>
        <div id="dialogAlertMessage">
        </div>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <button dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogAlert').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogQuestion" dojoType="dijit.Dialog" title="<?php echo i18n("dialogQuestion");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/confirm.png" />
      </td>
      <td>
        <div id="dialogQuestionMessage"></div>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogQuestion').acceptCallbackNo();dijit.byId('dialogQuestion').hide();">
          <?php echo i18n("buttonNo");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogQuestion').acceptCallbackYes();dijit.byId('dialogQuestion').hide();">
          <?php echo i18n("buttonYes");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogConfirm" dojoType="dijit.Dialog" title="<?php echo i18n("dialogConfirm");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/alert.png" />
      </td>
      <td>
        <div id="dialogConfirmMessage"></div>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" id="dialogConfirmAction">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogConfirm').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogConfirm').acceptCallback();dijit.byId('dialogConfirm').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogPrint" dojoType="dijit.Dialog" title="<?php echo i18n("dialogPrint");?>">
  <?php 
    $printHeight=600;
    $printWidth=900;
    if (array_key_exists('screenHeight',$_SESSION)) {
      $printHeight=round($_SESSION['screenHeight']*0.65);
    }
  ?> 
  <div id="printPreview" dojoType="dijit.layout.ContentPane" region="center">
    <table>
      <tr>
        <td width="300px" align="right">
          <button id="sendToPrinter" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('sendToPrinter');?>" 
            iconClass="dijitEditorIcon dijitEditorIconPrint" >
            <script type="dojo/connect" event="onClick" args="evt">
              sendFrameToPrinter();
            </script>
          </button>
        </td>
        <td align="left" width="<?php echo $printWidth - 300;?>px">
          &nbsp;<b><i><?php echo i18n('sendToPrinter')?></i></b>
        </td>
      </tr>
      <tr>
        <td colspan="2">   
          <iframe width="100%" height="<?php echo $printHeight;?>px" 
            scrolling="auto" frameborder="0px" name="printFrame" id="printFrame" src="preparePreview.php">
          </iframe>
        </td>
      </tr>
    </table>
  </div>
</div>
 
<div id="dialogNote" dojoType="dijit.Dialog" title="<?php echo i18n("dialogNote");?>">
  <table>
    <tr>
      <td>
       <form id='noteForm' name='noteForm' onSubmit="return false;">
         <input id="noteId" name="noteId" type="hidden" value="" />
         <input id="noteRefType" name="noteRefType" type="hidden" value="" />
         <input id="noteRefId" name="noteRefId" type="hidden" value="" />
         <textarea dojoType="dijit.form.Textarea" 
          id="noteNote" name="noteNote"
          style="width: 500px;"
          maxlength="4000"
          class="input"
          onClick="dijit.byId('noteNote').setAttribute('class','');">  
          </textarea>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogNoteAction">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogNote').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" onclick="saveNote();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogLink" dojoType="dijit.Dialog" title="<?php echo i18n("dialogLink");?>">
  <table>
    <tr>
      <td>
       <form id='linkForm' name='linkForm' onSubmit="return false;">
         <input id="linkFixedClass" name="linkFixedClass" type="hidden" value="" />
         <input id="linkId" name="linkId" type="hidden" value="" />
         <input id="linkRef1Type" name="linkRef1Type" type="hidden" value="" />
         <input id="linkRef1Id" name="linkRef1Id" type="hidden" value="" />
         <table>
           <tr>
             <td class="white"  >
               <label for="linkRef2Type" ><?php echo i18n("linkType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="linkRef2Type" name="linkRef2Type" 
                onchange="refreshLinkList();"
                class="input" value="" >
                 <?php htmlDrawOptionForReference('idLinkable', null, null, true);?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="white label" >
               <label for="linkRef2Id" ><?php echo i18n("linkElement") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="dialogLinkList" dojoType="dijit.layout.ContentPane" region="center">
                 <input id="linkRef2Id" name="linkRef2Id" type="hidden" value="" />
               </div>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogLinkAction">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogLink').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogLinkSubmit" onclick="saveLink();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogAttachement" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAttachement");?>">
  <form id='attachementForm' name='attachementForm' 
  ENCTYPE="multipart/form-data" method=POST
  action="../tool/saveAttachement.php"
  target="resultPost"
  onSubmit="return saveAttachement();" >
    <input id="attachementId" name="attachementId" type="hidden" value="" />
    <input id="attachementRefType" name="attachementRefType" type="hidden" value="" />
    <input id="attachementRefId" name="attachementRefId" type="hidden" value="" />
    <table>
      <tr height="30px"> 
        <td class="white" >
         <label for="attachementFile" ><?php echo i18n("colFile");?>&nbsp;:&nbsp;</label>
        </td>
        <td>
         <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $paramAttachementMaxSize;?>" />     
         <input MAX_FILE_SIZE="<?php echo $paramAttachementMaxSize;?>"
          dojoType="dojox.form.FileInput" type="file" 
          name="attachementFile" id="attachementFile" 
          cancelText="<?php echo i18n("buttonReset");?>"
          label="<?php echo i18n("buttonBrowse");?>"
          title="<?php echo i18n("helpSelectFile");?>" />
        </td>
      </tr>
      
      <tr> 
        <td class="white" >
         <label for="attachementDescription" ><?php echo i18n("colDescription");?>&nbsp;:&nbsp;</label>
        </td>
        <td> 
         <textarea dojoType="dijit.form.Textarea" 
          id="attachementDescription" name="attachementDescription"
          style="width: 350px;"
          maxlength="4000"
          class="input">  
         </textarea>
         <textarea style="display:none" id="resultAck" name="resultAck"></textarea>      
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="hidden" id="dialogAttachementAction">
          <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogAttachement').hide();">
            <?php echo i18n("buttonCancel");?>
          </button>
          <button id="submitUpload" dojoType="dijit.form.Button" type="submit">
            <?php echo i18n("buttonOK");?>
          </button>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
         <div style="display:none">
           <iframe name="resultPost" id="resultPost"></iframe>
         </div>
        </td>
      </tr>
    </table>
  </form>
</div>
 
<div id="dialogAssignment" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAssignment");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='assignmentForm' jsid='assignmentForm' name='assignmentForm' onSubmit="return false;">
         <input id="assignmentId" name="assignmentId" type="hidden" value="" />
         <input id="assignmentRefType" name="assignmentRefType" type="hidden" value="" />
         <input id="assignmentRefId" name="assignmentRefId" type="hidden" value="" />
         <table>
           <tr>
             <td class="white" >
               <label for="assignmentIdResource" ><?php echo i18n("colIdResource");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div dojoType="dojo.data.ItemFileReadStore" jsId="resourceStore" url="../tool/jsonList.php?listType=empty" searchAttr="name" >
               </div>
              <select dojoType="dijit.form.FilteringSelect" 
                id="assignmentIdResource" name="assignmentIdResource"
                class="input" value="" store="resourceStore">
                 <?php htmlDrawOptionForReference('idResource', null, null, true);?>
               </select>  
             </td>
           </tr>
           <tr>
             <td class="white" >
               <label for="assignmentRate" ><?php echo i18n("colRate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentRate" name="assignmentRate" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:999}" 
                 style="width:97px" 
                 required="true" />
             </td>
           </tr>
           <tr>
             <td class="white" >
               <label for="assignmentAssignedWork" ><?php echo i18n("colAssignedWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentAssignedWork" name="assignmentAssignedWork" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 style="width:97px"
                 onchange="assignmentUpdateLeftWork('assignment');" />
               <input type="hidden" id="assignmentAssignedWorkInit" name="assignmentAssignedWorkInit" value="" 
                 style="width:97px"/>  
             </td>    
           </tr>
           <tr>
             <td class="white" >
               <label for="assignmentRealWork" ><?php echo i18n("colRealWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentRealWork" name="assignmentRealWork" value=""  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 style="width:97px" readonly />
             </td>
           </tr>
           <tr>
             <td class="white" >
               <label for="assignmentLeftWork" ><?php echo i18n("colLeftWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentLeftWork" name="assignmentLeftWork" value=""  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 onchange="assignmentUpdatePlannedWork('assignment');" 
                 style="width:97px" />
               <input type="hidden" id="assignmentLeftWorkInit" name="assignmentLeftWorkInit" value="" 
                 style="width:97px"/>  
             </td>
           </tr>
           <tr>
             <td class="white" >
               <label for="assignmentPlannedWork" ><?php echo i18n("colPlannedWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentPlannedWork" name="assignmentPlannedWork" value=""  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 style="width:97px" readonly /> 
             </td>
           </tr>
           <tr>
             <td class="white" >
               <label for="assignmentComment" ><?php echo i18n("colComment");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentComment" name="assignmentComment" value=""  
                 dojoType="dijit.form.Textarea"
                 class="input" 
                 /> 
             </td>
           </tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogAssignmentAction">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogAssignment').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" onclick="saveAssignment();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogPlan" dojoType="dijit.Dialog" title="<?php echo i18n("dialogPlan");?>">
  <table>
    <tr>
      <td>
       <form id='dialogPlanForm' name='dialogPlanForm' onSubmit="return false;">
         <table>
           <tr>
             <td class="white"  >
               <label for="idProjectPlan" ><?php echo i18n("colIdProject") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="idProjectPlan" name="idProjectPlan" 
                class="input" value="" >
                 <?php 
                    $proj=null; 
                    if (array_key_exists('project',$_SESSION)) {
                        $proj=$_SESSION['project'];
                    }
                    htmlDrawOptionForReference('idProject', $proj, null, true);
                 ?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="white"  >
               <label for="startDatePlan" ><?php echo i18n("colStartDate") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div dojoType="dijit.form.DateTextBox" 
                 id="startDatePlan" name="startDatePlan" 
                 invalidMessage="<?php echo i18n('messageInvalidDate')?>" 
                 type="text" maxlength="10"
                 style="width:100px; text-align: center;" class="input"
                 value="<?php echo date('Y-m-d');?>" >
               </div>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogPlanAction">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogPlan').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogPlanSubmit" onclick="plan();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>


<div id="dialogDependency" dojoType="dijit.Dialog" title="<?php echo i18n("dialogDependency");?>">
  <table>
    <tr>
      <td>
       <form id='dependencyForm' name='dependencyForm' onSubmit="return false;">
         <input id="dependencyId" name="dependencyId" type="hidden" value="" />
         <input id="dependencyRefType" name="dependencyRefType" type="hidden" value="" />
         <input id="dependencyRefId" name="dependencyRefId" type="hidden" value="" />
         <input id="dependencyType" name="dependencyType" type="hidden" value="" />
         <table>
           <tr>
             <td class="white"  >
               <label for="dependencyRefTypeDep" ><?php echo i18n("linkType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="dependencyRefTypeDep" name="dependencyRefTypeDep" 
                onchange="refreshDependencyList();"
                class="input" value="" >
                 <?php htmlDrawOptionForReference('idDependable', null, null, true);?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="white label" >
               <label for="dependencyRefIdDep" ><?php echo i18n("linkElement") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="dialogDependencyList" dojoType="dijit.layout.ContentPane" region="center">
                 <input id="dependencyRefIdDep" name="dependencyRefIdDep" type="hidden" value="" />
                  OK
               </div>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogDependencyAction">
        <button dojoType="dijit.form.Button" onclick="dijit.byId('dialogDependency').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogDependencySubmit" onclick="saveDependency();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>


<div id="dialogFilter" dojoType="dijit.Dialog" title="<?php echo i18n("dialogFilter");?>" style="top: 100px;">
  <table style="border: 1px solid grey;">
    <tr>
     <td class="section"><?php echo i18n("sectionActiveFilter");?></td>
    </tr>
    <tr>
      <td style="margin: 2px;"> 
        <div id='listFilterClauses' dojoType="dijit.layout.ContentPane" region="center" style="overflow: hidden"></div>
         
        <form id='dialogFilterForm' name='dialogFilterForm' onSubmit="return false;">
         <input type="hidden" id="filterObjectClass" name="filterObjectClass" />
         <input type="hidden" id="filterClauseId" name="filterClauseId" />
         <input type="hidden" id="filterDataType" name="filterDataType" />
         <input type="hidden" id="filterName" name="filterName" />
         <table width="100%" style="border: 1px solid grey;">
           <tr><td colspan="4" class="filterHeader"><?php echo i18n("addFilterClauseTitle");?></td></tr>
           <tr style="vertical-align: top;">
             <td class="white" style="width: 210px;" >
               <div dojoType="dojo.data.ItemFileReadStore" jsId="attributeStore" url="../tool/jsonList.php?listType=empty" searchAttr="name" >
               </div>
               <select dojoType="dijit.form.FilteringSelect" 
                id="idFilterAttribute" name="idFilterAttribute" 
                class="input" value="" style="width: 200px;" store="attributeStore">
                  <script type="dojo/method" event="onChange" >
                    filterSelectAtribute(this.value);
                  </script>              
               </select>
             </td>
             <td style="width: 110px;">
               <div dojoType="dojo.data.ItemFileReadStore" jsId="operatorStore" url="../tool/jsonList.php?listType=empty" searchAttr="name" >
               </div>
               <select dojoType="dijit.form.FilteringSelect" 
                id="idFilterOperator" name="idFilterOperator" 
                class="input" value="" style="width: 100px;" store="operatorStore">
               </select>
             </td>
             <td style="width:210px;">
               <input id="filterValue" name="filterValue" value=""  
                 dojoType="dijit.form.TextBox" 
                 style="width:200px" />
               <select id="filterValueList" name="filterValueList[]" value=""  
                 dojoType="dijit.form.MultiSelect" multiple
                 style="width:200px" size="10" class="input"></select>
                <input type="checkbox" id="filterValueCheckbox" name="filterValueCheckbox" value=""  
                 dojoType="dijit.form.CheckBox" 
                 /> 
                <input id="filterValueDate" name="filterValueDate" value=""  
                 dojoType="dijit.form.DateTextBox" 
                 style="width:200px" /> 
             </td>
             <td style="width:25px; text-align: center;" align="center">
               <img src="css/images/smallButtonAdd.png" onClick="addfilterClause();" title="<?php echo i18n('addFilterClause');?>" class="smallButton"/> 
             </td>
           </tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <button dojoType="dijit.form.Button" onclick="clearFilter();">
          <?php echo i18n("buttonClear");?>
        </button>
        <button dojoType="dijit.form.Button" onclick="cancelFilter();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogFilterSubmit" onclick="selectFilter();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
  <table>
    <tr><td>&nbsp;</td></tr>
    <tr>
     <td class="section"><?php echo i18n("sectionStoredFilters");?></td>
    </tr>
    <tr>
      <td>
        <div id='listStoredFilters' dojoType="dijit.layout.ContentPane" region="center"></div>
      </td>
    </tr>
  </table>
</div>

</body>
</html>
