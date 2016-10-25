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

$base=new Baseline();
$crit=array("idUser"=>getSessionUser()->id);
$proj=null;
if (array_key_exists('project',$_SESSION)) {
  $proj=$_SESSION['project'];
}
$mode="add";
$idBaseline=null;
if (array_key_exists('editMode',$_REQUEST)) {
  $mode="edit";
  if (! array_key_exists('baselineId',$_REQUEST)) {
    throwError("parameter baselineId not found in request");
    exit;
  }
  $idBaseline=$_REQUEST['baselineId'];
}

$currentBaseline=new Baseline($idBaseline);
if ($mode=='edit') {
  $proj=$currentBaseline->idProject;
}

if ($proj=="*" or ! $proj) {
  $proj=null;
} else {
  $crit['idProject']=$proj;
}
$listeBase=$base->getSqlElementsFromCriteria($crit,false, null, 'idProject asc, baselineNumber desc');

$crit=array('idProject'=>$proj,'baselineDate'=>date('Y-m-d'));
$listCtrlDate=$base->getSqlElementsFromCriteria($crit);

?>
<table width="500px">
    <tr><td style="width:100%;background-color:#F0F0F0;font-weight:bold;text-align:center;padding:10px;"><?php echo i18n($mode."Baseline");?></td></tr>
    <tr><td >&nbsp;</td></tr>
    <tr>
      <td width="100%">
       <form dojoType="dijit.form.Form" id='dialogPlanBaselineForm' name='dialogPlanBaselineForm' onSubmit="return false;">
         <input type="hidden" name="idBaselinePlanBaseline" value="<?php echo $currentBaseline->id;?>" /> 
         <table width="100%" >
           <tr>
             <td class="dialogLabel"  >
               <label for="idProjectPlanBaseline" ><?php echo i18n("colIdProject") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
               <?php echo autoOpenFilteringSelect(); 
               if ($mode=='edit') echo 'readonly';?>
                id="idProjectPlanBaseline" name="idProjectPlanBaseline" 
                class="input required" required >
                 <?php 
                    htmlDrawOptionForReference('idProject', $proj, null, false);
                 ?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="namePlanBaseline" ><?php echo i18n("colName") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="namePlanBaseline" name="namePlanBaseline" dojoType="dijit.form.ValidationTextBox" 
                 class="input required" required value="<?php echo $currentBaseline->name;?>" />
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="datePlanBaseline" ><?php echo i18n("colDate") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div dojoType="dijit.form.DateTextBox" 
                 id="datePlanBaseline" name="datePlanBaseline" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 invalidMessage="<?php echo i18n('messageInvalidDate')?>" 
                 type="text" maxlength="10"
                 style="width:100px; text-align: center;" class="input"
                 hasDownArrow="true"
                 readonly
                 value="<?php echo ($mode=='edit')?$currentBaseline->baselineDate:date('Y-m-d');?>" >
               </div>
             </td>
           </tr>
           <?php if ($mode=="edit"){?>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="numberBaseline" ><?php echo i18n("colLineNumber") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div dojoType="dijit.form.NumberTextBox" 
                 id="numberBaseline" name="numberBaseline" 
                 type="text" style="width:50px; class="input"
                 readonly value="<?php echo $currentBaseline->baselineNumber;?>" >
               </div>
             </td>
           </tr>
           <?php }?>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr><td colspan="2">
            <table width="100%"><tr height="25px">
            <td width="33%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="planBaselinePrivacyPublic"><?php echo i18n('public');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="planBaselinePrivacy" id="planBaselinePrivacyPublic" value="1" <?php if ($currentBaseline->idPrivacy==1 or !$currentBaseline->id) echo "checked";?> />
            </td>
            <td width="34%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="planBaselinePrivacyTeam"><?php echo i18n('team');?>&nbsp;</label>
              <?php $res=new Resource(getSessionUser()->id);
                    $hasTeam=($res->id and $res->idTeam)?true:false;
              ?>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="planBaselinePrivacy" id="planBaselinePrivacyTeam" value="2" <?php if ($currentBaseline->idPrivacy==2) echo "checked"; if (!$hasTeam) echo ' disabled ';?> />
            </td>
            <td width="33%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="planBaselinePrivacyPrivate"><?php echo i18n('private');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="planBaselinePrivacy" id="planBaselinePrivacyPrivate" value="3" <?php if ($currentBaseline->idPrivacy==3) echo "checked";?> />
            </td>
          </tr></table>
          </td></tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <?php if ($mode=='edit') {?>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogPlanBaselineCancel">
        <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogPlanBaseline').hide();showPlanningBaseline();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogPlanBaselineSubmit" onclick="protectDblClick(this);savePlanningBaseline();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
    <?php } else {
      if (count($listCtrlDate)>0) {?>
    <tr><td><div style="text-align:center" class="messageINVALID"><?php echo i18n('saveNewBaselineAlreadyExists')?></div></td></tr>  
    <tr><td >&nbsp;</td></tr>
    <?php }?>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogPlanBaselineCancel">
        <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogPlanBaseline').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogPlanBaselineSubmit" onclick="protectDblClick(this);savePlanningBaseline();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
    <tr><td >&nbsp;</td></tr>
    <tr><td style="width:100%;background-color:#F0F0F0;font-weight:bold;text-align:center;padding:10px;"><?php echo i18n("existingBaselines");?></td></tr>
    <?php if (count($listeBase)==0) {?>
    <tr><td style="width:100%;padding:10px;text-align:center;"><?php echo i18n("noBaseline");?></td></tr>
    <?php } else {?>
    <tr><td style="width:100%;">
      <br/>
      <table width="100%">
      <?php
        echo '<table style="width:100%">';
        echo "<tr><td class='noteHeader' style='width:15%'>".i18n("colId")."</td>"
                ."<td class='noteHeader' style='width:25%'>".i18n("colIdProject")."</td>"
                ."<td class='noteHeader' style='width:5%'>".i18n("colLineNumber")."</td>"
                ."<td class='noteHeader' style='width:15%'>".i18n("colDate")."</td>"
                ."<td class='noteHeader' style='width:40%'>".i18n("colName")."</td></tr>";
        foreach($listeBase as $base) {
          echo '<tr><td class="noteData"><table><tr><td style="width:50%" class="smallButtonsGroup">';
          if ($base->idUser==getSessionUser()->id) {
            echo ' <a onClick="editBaseline(' . htmlEncode($base->id) .');" title="' . i18n('editBaseline') . '" > '.formatSmallButton('Edit').'</a>';
            echo ' <a onClick="removeBaseline(' . htmlEncode($base->id) . ');" title="' . i18n('removeBaseline') . '" > '.formatSmallButton('Remove').'</a>';
          }
          echo '&nbsp;</td><td>#'.$base->id.'</td></tr></table></td>'
                  .'<td class="noteData">'.SqlList::getNameFromId('Project', $base->idProject).'</td>'
                  .'<td class="noteData" style="text-align:center">'.$base->baselineNumber.'</td>'
                  .'<td class="noteData" style="text-align:center">'.htmlFormatDate($base->baselineDate).'</td>'
                  .'<td class="noteData">'.$base->name.'</td></tr>';
        }
        echo '</table>';
      ?>
      </table>
    </td></tr>
    <?php }?>
    <tr><td >&nbsp;</td></tr>
    <?php }?>
  </table>