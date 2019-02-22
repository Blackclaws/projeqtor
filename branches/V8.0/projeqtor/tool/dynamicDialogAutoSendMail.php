<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

scriptLog('dynamicDialogAutoSendMail.php');

$user = new Resource(getCurrentUserId());
$userProfile = new Profile($user->idProfile);
$currentDay = date('Y-m-d');
if(sessionValueExists('sendFrequency')){
  $sendFrequency = getSessionValue('sendFrequency');
}else{
  $sendFrequency = 'showAllDays';
}
$destination = getSessionValue('destination');
$otherDestination = getSessionValue('otherDestination');
$idReport = getSessionValue('idReport');
?>
  <table>
    <tr>
      <td>
        <form dojoType="dijit.form.Form" id='autoSendMailForm' name='autoSendMailForm' onSubmit="return false;">
          <table style="white-space:nowrap">
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="showAllDays" name="sendFrequency" value="0" <?php if($sendFrequency == 'showAllDays'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'showAllDays', false):'';showDialogAutoSendMail();"/>
                <label for="showAllDays" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllDays');?></label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="showAllOpenDays" name="sendFrequency" value="0" <?php if($sendFrequency == 'showAllOpenDays'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'showAllOpenDays', false):'';showDialogAutoSendMail();"/>
                <label for="showAllOpenDays" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllOpenDays');?></label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="showAllWeeks" name="sendFrequency" value="0" <?php if($sendFrequency == 'showAllWeeks'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'showAllWeeks', false):'';showDialogAutoSendMail();"/>&nbsp;&nbsp;
                <label for="showAllWeeks" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllWeeks');?> :</label>
                <div dojoType="dijit.form.DateTextBox"
                  <?php if (sessionValueExists('browserLocaleDateFormatJs')) {
    							echo ' constraints="{datePattern:\''.getSessionValue('browserLocaleDateFormatJs').'\'}" ';
    						 }?>
                 id="weekFrequency" name="weekFrequency"
                 invalidMessage="<?php echo i18n('messageInvalidDate')?>"
                 type="text" maxlength="10"
                 style="width:100px; text-align: center;" class="input roundedLeft"
                 hasDownArrow="true"
                 value="<?php echo $currentDay;?>" <?php if($sendFrequency != 'showAllWeeks'){?> readonly <?php }?>>
                 <script type="dojo/method" event="onChange">
    						   
                 </script>
               </div>
              </td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="showAllMonths" name="sendFrequency" value="0"  <?php if($sendFrequency == 'showAllMonths'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'showAllMonths', false):'';showDialogAutoSendMail();"/>&nbsp;&nbsp;
                <label for="showAllMonths" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllMonths');?> :</label>
                <div dojoType="dijit.form.DateTextBox"
                  <?php if (sessionValueExists('browserLocaleDateFormatJs')) {
    							echo ' constraints="{datePattern:\''.getSessionValue('browserLocaleDateFormatJs').'\'}" ';
    						 }?>
                 id="monthFrequency" name="monthFrequency"
                 invalidMessage="<?php echo i18n('messageInvalidDate')?>"
                 type="text" maxlength="10"
                 style="width:100px; text-align: center;" class="input roundedLeft"
                 hasDownArrow="true"
                 value="<?php echo $currentDay;?>" <?php if($sendFrequency != 'showAllMonths'){?> readonly <?php }?>>
                 <script type="dojo/method" event="onChange">
    						   
                 </script>
               </div>
              </td>
            </tr>
            <tr>
              <td></br></td>
            </tr>
            <tr>
              <td>
                <label for="destinationInput" class="dialogLabel" style="text-align:left;"><?php echo i18n('sectionReceivers');?>  :</label>
                <input dojoType="dijit.form.TextBox" 
  				          id="destinationInput" name="destinationInput"
  				          style="width: 300px;"
  				          maxlength="4000" onChange="saveDataToSession('destination', this.value, false);"
  				          class="input" <?php if($userProfile->profileCode != 'ADM'){ ?> readonly <?php }?> 
  				          value="<?php if(sessionValueExists('destination')){ echo $destination;}else {echo $user->email;}?>"/>
  				    </td>
            </tr>
            <tr>
              <td>
                <label for="otherDestinationInput" class="dialogLabel" style="text-align:left;"><?php echo i18n('colOtherReceivers');?> :</label>
                <textarea type="text" dojoType="dijit.form.Textarea" 
  				          id="otherDestinationInput" name="otherDestinationInput"
  				          style="width: 302px;"
  				          maxlength="4000"
  				          class="input" onChange="saveDataToSession('otherDestination', this.value, false);"><?php if(sessionValueExists('otherDestination')){ echo $otherDestination;}?></textarea>
  				    </td>
            </tr>
          </table>
        </form>
     </td>
   </tr>
   <tr>
     <td></br></td>
   </tr>
    <tr>
      <td align="center">
        <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAutoSendMail').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" id="dialogMailSubmit" 
        onclick="saveAutoSendMail('<?php echo $sendFrequency;?>', dojo.byId('weekFrequency').value, dojo.byId('monthFrequency').value, dojo.byId('destinationInput').value, dojo.byId('otherDestinationInput').value);">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>    