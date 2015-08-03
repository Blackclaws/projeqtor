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
  scriptLog('   ->/view/pluginManagement.php');

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
    <form dojoType="dijit.form.Form" id="pluginForm" jsId="pluginForm" name="pluginForm" encType="multipart/form-data" action="" method="" >
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
              <tr>
                <td class="label"><?php echo i18n("cronStatus"). "&nbsp;:&nbsp;";?></td>
                <td class="display">
                </td>
              </tr>
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
              <tr>
                <td class="display" >
                 <?php echo i18n('pluginDir',array(Plugin::getDir()));?>
                </td>
              </tr>
              <tr>
                <?php displayPluginList('local');?>
              </tr>
            </table></div><br/>
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

<?php function displayPluginList($location) {
  if ($location=='local') {
    $files=Plugin::getZipList();
  } else if ($location=='remote') {
    $files=array();
  } else {
    return; // uncknown location
  }
  foreach ($files as $file) {
    echo '<tr>';
    echo '<td>'.$file['name'].'</td>';
    echo '</tr>';
  } 

}
?>