<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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
 * Management of PlugIns
 */
  require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
  scriptLog('   ->/view/pluginManagement.php');
  $isIE=false;
  if (array_key_exists('isIE',$_REQUEST)) {
    $isIE=$_REQUEST['isIE'];
  }
  $user=getSessionUser();
  $collapsedList=Collapsed::getCollaspedList();
?>  
<input type="hidden" name="objectClassManual" id="objectClassManual" value="Plugin" />
<div class="container" dojoType="dijit.layout.BorderContainer">
  <div id="pluginButtonDiv" class="listTitle" dojoType="dijit.layout.ContentPane" region="top" style="z-index:3;overflow:visible">
    <div id="resultDiv" dojoType="dijit.layout.ContentPane"
      region="top" style="padding:5px;max-height:100px;padding-left:300px;z-index:999"></div>
    <table width="100%">
      <tr height="100%" style="vertical-align: middle;">
        <td width="50px" align="center">
          <img src="css/images/iconPlugin32.png" width="32" height="32" />
        </td>
        <td><span class="title"><?php echo i18n("menuPlugin");?>&nbsp;</span>        
        </td>
        <td width="10px" >&nbsp;
        </td>
        <td width="50px"> 
        </td>
        <td>      
        </td>
      </tr>
    </table>
  </div>
  <div id="formPluginDiv" dojoType="dijit.layout.ContentPane" region="center" style="overflow-y:auto;"> 
    <form dojoType="dijit.form.Form" id="pluginForm" jsId="pluginForm" name="pluginForm" encType="multipart/form-data" method="POST" 
    <?php if ($isIE and $isIE<=9) {?>
    action="../tool/uploadPlugin.php?isIE=<?php echo $isIE;?>"
    target="pluginPost"
    onSubmit="return true; //uploadPlugin();"
    <?php }?> 
    >
      <table style="width:97%;margin:10px;padding: 10px;vertical-align:top;">
        <tr style="">
          <td style="width:49%;vertical-align:top;">
            <?php $titlePane="Plugin_installed"; ?> 
            <div dojoType="dijit.TitlePane" 
             open="<?php echo ( array_key_exists($titlePane, $collapsedList)?'false':'true');?>"
             id="<?php echo $titlePane;?>" 
             onHide="saveCollapsed('<?php echo $titlePane;?>');"
             onShow="saveExpanded('<?php echo $titlePane;?>');"       
             title="<?php echo i18n('pluginInstalled');?>">
            <table style="width:100%;">            
              <?php displayInstalledPlugin();?>
            </table>
            </div><br/>
          </td>
          <td style="width:10px">&nbsp;</td>
          <td style="width:49%;vertical-align:top;">
            <?php $titlePane="Plugin_available_local"; ?> 
            <div dojoType="dijit.TitlePane"
             open="<?php echo ( array_key_exists($titlePane, $collapsedList)?'false':'true');?>"
             id="<?php echo $titlePane;?>" 
             onHide="saveCollapsed('<?php echo $titlePane;?>');"
             onShow="saveExpanded('<?php echo $titlePane;?>');"
             title="<?php echo i18n('pluginAvailableLocal');?>">
            <table style="width:100%;">
              <tr height="30px"> 
              <td colspan="6"><table><tr>
                <td class="dialogLabel" >
                  <label for="uploadPlugin" ><?php echo i18n("colFile");?>&nbsp;:&nbsp;</label>
                </td>
                <td>
                 <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo Parameter::getGlobalParameter('paramAttachmentMaxSize');?>" />     
                 <?php  if ($isIE and $isIE<=9) {?>
                 <input MAX_FILE_SIZE="<?php echo Parameter::getGlobalParameter('paramAttachmentMaxSize');?>"
                  dojoType="dojox.form.FileInput" type="file" 
                  name="pluginFile" id="pluginFile" 
                  cancelText="<?php echo i18n("buttonReset");?>"
                  label="<?php echo i18n("buttonBrowse");?>"
                  title="<?php echo i18n("helpSelectFile");?>" />
                 <?php } else {?>  
                 <input MAX_FILE_SIZE="<?php echo Parameter::getGlobalParameter('paramAttachmentMaxSize');?>"
                  dojoType="dojox.form.Uploader" type="file" 
                  url="../tool/uploadPlugin.php"
                  name="pluginFile" id="pluginFile" 
                  cancelText="<?php echo i18n("buttonReset");?>"
                  multiple="false" 
                  onBegin="uploadFile();"
                  onChange="changePluginFile(this.getFileList());"
                  onError="dojo.style(dojo.byId('downloadProgress'), {display:'none'});"
                  label="<?php echo i18n("buttonBrowse");?>"
                  title="<?php echo i18n("helpSelectFile");?>"  />
                 <?php }?>
                 <i><span name="pluginFileName" id="pluginFileName"></span></i> 
                </td>
              </tr>
              <tr>
        <td colspan="2" align="center">
         <div style="display:none">
           <iframe name="pluginPost" id="pluginPost"></iframe>
         </div>
        </td>
      </tr>
              </table></td>
              </tr>        
              <tr>
                <td class="display" colspan="6">
                 <?php echo i18n('pluginDir',array(Plugin::unrelativeDir(Plugin::getDir()) ));?>
                <br/><br/></td>
              </tr>
              <?php displayPluginList('local');?>
            </table><br/></div><br/>
            <?php $titlePane="Plugin_available_remote"; ?> 
            <div dojoType="dijit.TitlePane"
             open="<?php echo ( array_key_exists($titlePane, $collapsedList)?'false':'true');?>"
             id="<?php echo $titlePane;?>" 
             onHide="saveCollapsed('<?php echo $titlePane;?>');"
             onShow="saveExpanded('<?php echo $titlePane;?>');"
             title="<?php echo i18n('pluginAvailableRemote');?>">
            <table style="width:100%;">
              <tr>
                <td class="display" width="100%" colspan="2" style="text-align:center">
                  <br/><i><?php echo i18n("featureNotAvailable");?></i>
                </td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
            </table></div>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php 
function displayPluginList($location) {
  if ($location=='local') {
    $files=Plugin::getZipList();
  } else if ($location=='remote') {
    $files=array();
  } else {
    return; // unknown location
  }
  if (count($files)==0) {
    echo '<tr><td class="display" width="100%" colspan="6" style="text-align:center">';
    echo '<br/><i>'.i18n("noPluginAvailable").'</i></td></tr>';
  } else {
    echo '<tr>';
    echo '<td style="width:5%">&nbsp;</td>';
    echo '<td style="width:10%" class="noteHeader smallButtonsGroup"></td>';
    echo '<td class="noteHeader">'.i18n("colFile").'</td>';
    echo '<td style="width:15%" class="noteHeader">'.i18n("colDate").'</td>';
    echo '<td style="width:10%" class="noteHeader">'.i18n("colSize").'</td>';
    echo '<td style="width:5%">&nbsp;</td>';
    echo '</tr>';
    foreach ($files as $file) {
      echo '<tr>';
      echo '<td></td>';
      echo '<td class="noteData" style="text-align:center"  >';
      echo ' <img class="roundedButtonSmall" src="css/images/smallButtonAdd.png" '
        .' onClick="installPlugin(\''.$file['name'].'\');" title="' . i18n('installPlugin') . '" /> ';
      echo ' <img class="roundedButtonSmall" src="css/images/display.png" title="'.i18n('dialogPluginInfo').'"'
          .' onClick="loadDialog(\'dialogPluginInfo\', null, true, \'&filename='.$file['name'].'\', true);" /> ';
       
      echo '</td>';
      echo '<td class="noteData">'.$file['name'].'</td>';
      echo '<td class="noteData" style="text-align:center">'.htmlFormatDate(substr($file['date'],0,10),true).'</td>';
      echo '<td class="noteData" style="text-align:center">'.htmlGetFileSize($file['size']).'</td>';
      echo '<td></td>';
      echo '</tr>';
    } 
  }
}

function displayInstalledPlugin() {
  $pl=new Plugin();
  $plList=$pl->getSqlElementsFromCriteria(array('isDeployed'=>'1','idle'=>'0'),false,null,'name asc');
  if (count($plList)==0) {
    echo '<tr><td class="display" width="100%" colspan="6" style="text-align:center">';
    echo '<br/><i>'.i18n("noPluginAvailable").'</i></td></tr>';
  } else {
    echo '<tr>';
    echo '<td style="width:20%" class="noteHeader">'.i18n("colName").'</td>';
    echo '<td style="width:40%" class="noteHeader">'.i18n("colDescription").'</td>';
    echo '<td style="width:10%" class="noteHeader">'.i18n("colVersion").'</td>';
    echo '<td style="width:10%" class="noteHeader">'.i18n("colDeploymentDate").'</td>';
    echo '<td style="width:10%" class="noteHeader">'.i18n("colDeploymentVersion").'</td>';
    echo '<td style="width:10%" class="noteHeader">'.i18n("colCompatibilityVersion").'</td>';
    echo '</tr>';
    foreach ($plList as $plugin) {
      echo '<tr>';
      echo '<td class="noteData">'.$plugin->name.'</td>';
      echo '<td class="noteData">'.$plugin->description.'</td>';
      echo '<td class="noteData">V'.$plugin->pluginVersion.'</td>';
      echo '<td class="noteData" style="text-align:center">'.htmlFormatDate($plugin->deploymentDate,true).'</td>';
      echo '<td class="noteData" style="text-align:center">'.$plugin->deploymentVersion.'</td>';
      echo '<td class="noteData" style="text-align:center">'.$plugin->compatibilityVersion.'</td>';
      echo '</tr>';
    }
  }

}
?>