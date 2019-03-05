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

scriptLog('dynamicDialogAutoSendReport.php');

$user = getSessionUser();
$resourceProfile = new Profile($user->idProfile);

foreach (getUserVisibleResourcesList(true) as $id=>$name){
	if($user->id == $id){
		$userName=$name;
	}
}
$currentDay = date('Y-m-d');
$idReport = getSessionValue('idReport');

if(sessionValueExists('sendFrequency')){
  $sendFrequency = getSessionValue('sendFrequency');
}else{
  $sendFrequency = 'everyDays';
}
if(sessionValueExists('sendTime')){
	$sendTime = getSessionValue('sendTime');
}else{
	$sendTime = date('H:i');
}
if(sessionValueExists('destination')){
	$destination = getSessionValue('destination');
}else{
	$destination = $user->email;
}
if(sessionValueExists('otherDestination')){
	$otherDestination = getSessionValue('otherDestination');
}else{
	$otherDestination = '';
}
if(sessionValueExists('name')){
	$name = getSessionValue('name');
}else{
	$name = '';
}
if(sessionValueExists('yearParam')){
	$yearParam = getSessionValue('yearParam');
}else{
	$yearParam = date('Y');
}
if(sessionValueExists('monthParam')){
	$monthParam = getSessionValue('monthParam');
}else{
	$monthParam = date('m');
}
if(sessionValueExists('weekParam')){
	$weekParam = getSessionValue('weekParam');
}else{
	$weekParam = date('W');
}
?>
  <table>
    <tr>
      <td>
        <form dojoType="dijit.form.Form" id='autoSendReportForm' name='autoSendReportForm' onSubmit="return false;">
          <table style="white-space:nowrap">
            <tr>
              <td class="assignHeader"><?php echo i18n('colParameters');?></td>
            </tr>
            <tr>
              <td>
                <label for="yearParam" class="dialogLabel" style="text-align:left;"><?php echo i18n('year');?> :</label>
                <div dojoType="dijit.form.TextBox" 
                  id="yearParam" name="yearParam" type="text" maxlength="10" readonly
                  style="width:30px; text-align:center;margin-bottom:5px;margin-top:10px;"
                  value="<?php echo $yearParam;?>"></div>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;padding-bottom:5px;" 
                  onclick="dijit.byId('yearParam').set('value','<?php echo date('Y');?>');saveDataToSession('yearParam', '<?php echo date('Y');?>', false);">
                  <?php echo i18n('setToCurrentYear');?></button>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;padding-bottom:5px;" 
                  onclick="dijit.byId('yearParam').set('value','<?php echo (date('Y')-1);?>');saveDataToSession('yearParam', '<?php echo (date('Y')-1);?>', false);">
                  <?php echo i18n('setToPreviousYear');?></button>
              </td>
            </tr>
            <tr>
              <td>
                <?php //ADD qCazelles - Report fiscal year - Ticket #128 
                if (Parameter::getGlobalParameter("reportStartMonth")!='NO') {
                ?>
                <label for="monthParam" class="dialogLabel" style="text-align:left;"><?php echo i18n('startMonth');?> :</label>
                <div style="width:30px; text-align: center; color: #000000;margin-bottom:5px;" 
                   dojoType="dijit.form.NumberSpinner" 
                   constraints="{min:1,max:12,places:0,pattern:'00'}"
                   intermediateChanges="true"
                   maxlength="2"
                   value="01" smallDelta="1"
                   id="monthParam" name="monthParam" >
                 </div>
                 <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;padding-bottom:5px;" 
                  onclick="dijit.byId('monthParam').set('value','<?php echo date('m');?>');saveDataToSession('monthParam', '<?php echo date('m');?>', false);">
                  <?php echo i18n('setToCurrentMonth');?></button>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;padding-bottom:5px;" 
                  onclick="dijit.byId('monthParam').set('value','<?php echo date('m',date('m')-1);?>');saveDataToSession('monthParam', '<?php echo date('m',date('m')-1);?>', false);">
                  <?php echo i18n('setToPreviousMonth');?></button>
               <?php }else{ ?>
                <div dojoType="dijit.form.TextBox" 
                  id="monthParam" name="monthParam" type="text" maxlength="10" readonly
                  style="width:30px; text-align:center;margin-bottom:5px;"
                  value="<?php echo $monthParam;?>"></div>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;padding-bottom:5px;" 
                  onclick="dijit.byId('monthParam').set('value','<?php echo date('m');?>');saveDataToSession('monthParam', '<?php echo date('m');?>', false);">
                  <?php echo i18n('setToCurrentMonth');?></button>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;padding-bottom:5px;" 
                  onclick="dijit.byId('monthParam').set('value','<?php echo date('m',date('m')-1);?>');saveDataToSession('monthParam', '<?php echo date('m',date('m')-1);?>', false);">
                  <?php echo i18n('setToPreviousMonth');?></button>
                <?php }?>
              </td>
            </tr>
            <tr>
              <td>
                <label for="weekParam" class="dialogLabel" style="text-align:left;"><?php echo i18n('week');?> :</label>
                <div dojoType="dijit.form.TextBox" 
                  id="weekParam" name="weekParam" type="text" maxlength="10" readonly
                  style="width:30px; text-align:center;"
                  value="<?php echo $weekParam;?>"></div>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;" 
                  onclick="dijit.byId('weekParam').set('value','<?php echo date('W');?>');saveDataToSession('weekParam', '<?php echo date('W');?>', false);">
                  <?php echo i18n('setToCurrentWeek');?></button>
                <button dojoType="dijit.form.Button"
                  style="text-align:center;width:120px;height:16px;" 
                  onclick="dijit.byId('weekParam').set('value','<?php if(date('W')-1 <10){?>0<?php }echo date('W')-1; ?>');saveDataToSession('weekParam', '<?php if(date('W')-1 <10){?>0<?php }echo date('W')-1; ?>', false);">
                  <?php echo i18n('setToPreviousWeek');?></button>
              </td>
            </tr>
            <tr>
              <td></br></td>
            </tr>
            <tr>
              <td class="assignHeader"><?php echo i18n('colFrequency');?></td>
            </tr>
            <tr>
              <td></br></td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="everyDays" name="sendFrequency" value="0" <?php if($sendFrequency == 'everyDays'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'everyDays', false):'';showDialogAutoSendReport();"/>
                <label for="everyDays" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllDays');?></label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="everyOpenDays" name="sendFrequency" value="0" <?php if($sendFrequency == 'everyOpenDays'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'everyOpenDays', false):'';showDialogAutoSendReport();"/>
                <label for="everyOpenDays" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllOpenDays');?></label>
              </td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="everyWeeks" name="sendFrequency" value="0" <?php if($sendFrequency == 'everyWeeks'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'everyWeeks', false):'';showDialogAutoSendReport();"/>&nbsp;&nbsp;
                <label for="everyWeeks" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllWeeks');?> :</label>
                <select dojoType="dijit.form.FilteringSelect" class="input roundedLeft"
                  style="width:100px;" name="weekFrequency" id="weekFrequency" <?php echo autoOpenFilteringSelect();?>
                  <?php if($sendFrequency != 'everyWeeks'){?> readonly <?php }?>>>
                  <?php echo htmlReturnOptionForWeekdays(1, true);?>
                </select>
               </div>
              </td>
            </tr>
            <tr>
              <td>
                <input type="radio" data-dojo-type="dijit/form/RadioButton" 
                  id="everyMonths" name="sendFrequency" value="0"  <?php if($sendFrequency == 'everyMonths'){echo 'checked';}?>
                  onchange="this.checked?saveDataToSession('sendFrequency', 'everyMonths', false):'';showDialogAutoSendReport();"/>&nbsp;&nbsp;
                <label for="everyMonths" class="dialogLabel" style="text-align:left;"><?php echo i18n('showAllMonths');?> :</label>
                <select dojoType="dijit.form.FilteringSelect" class="input roundedLeft"
                style="width:100px;" name="monthFrequency" id="monthFrequency" <?php echo autoOpenFilteringSelect();?>
                <?php if($sendFrequency != 'everyMonths'){?> readonly <?php }?>>
                <?php echo htmlReturnOptionForMinutesHoursCron(date('d'),false,true);?>
                </select>
              </td>
            </tr>
            <tr>
              <td></br></td>
            </tr>
            <tr>
              <td>
                <label for="sendTime" class="dialogLabel" style="text-align:left;"><?php echo i18n('hours');?> :</label>
                <div dojoType="dijit.form.TimeTextBox" name="sendTime" id="sendTime"
                    invalidMessage="<?php echo i18n('messageInvalidTime')?>" 
                    type="text" maxlength="5" required="true"
                    style="width:40px; text-align: center;" class="input rounded required" required="true"
                    value="T<?php if(sessionValueExists('sendTime')){echo getSessionValue('sendTime');}else{
                    echo date('H:i');}?>" hasDownArrow="false" 
                    onchange="saveDataToSession('sendTime', dojo.byId('sendTime').value, false);showDialogAutoSendReport();">
                </div>
              </td>
            </tr>
            <tr>
              <td></br></td>
            </tr>
            <tr>
              <td class="assignHeader"><?php echo i18n('sectionReceivers');?></td>
            </tr>
            <tr>
              <td></br></td>
            </tr>
            <tr>
              <td>
                <label for="destinationInput" class="dialogLabel" style="text-align:left;"><?php echo i18n('sectionReceivers');?>  :</label>
                <select dojoType="dijit.form.FilteringSelect" class="input" xlabelType="html"
                style="width: 150px;" name="destinationInput" id="destinationInput" required="true"
                <?php echo autoOpenFilteringSelect();
                if($resourceProfile->profileCode != 'ADM'){ ?> readonly <?php }?>
                value="<?php if(sessionValueExists('destination')){echo $destination;}else{echo $user->id;}?>">
                  <script type="dojo/method" event="onChange" >
                    saveDataToSession('destination', this.value, false);
                    showDialogAutoSendReport();
                  </script>
                  <option value=""></option>
                  <?php $specific='imputation';
                   include '../tool/drawResourceListForSpecificAccess.php';?>  
                 </select>
  				    </td>
            </tr>
            <tr>
              <td>
                <label for="name" class="dialogLabel" style="text-align:left;"><?php echo i18n('colName');?>  :</label>
                <input data-dojo-type="dijit.form.TextBox"
  				          id="name" name="name"
  				          style="width: 300px;"
  				          maxlength="4000" onChange="saveDataToSession('name', this.value, false);"
  				          class="input" required="true" value="<?php if(sessionValueExists('name')){ echo $name;}?>"/>
  				    </td>
            </tr>
            <tr>
              <td>
                <label for="otherDestinationInput" class="dialogLabel" style="text-align:left;"><?php echo i18n('colOtherReceivers');?> :</label>
                <textarea type="text" dojoType="dijit.form.Textarea" 
  				          id="otherDestinationInput" name="otherDestinationInput"
  				          style="width: 302px;" maxlength="4000" class="input" 
  				          onChange="saveDataToSession('otherDestination', this.value, false);showDialogAutoSendReport();"><?php if(sessionValueExists('otherDestination')){ echo $otherDestination;}?></textarea>
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
        <button dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAutoSendReport').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button dojoType="dijit.form.Button" type="submit" 
        <?php if($sendTime == '' or ($destination == '' and $otherDestination == '')){?>disabled <?php }?>
          onclick="saveAutoSendReport('<?php echo $sendFrequency;?>');">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
  
  <?php
  function htmlReturnOptionForMinutesHoursCron($selection, $isHours=false, $isDayOfMonth=false, $required=false) {
  	$arrayWeekDay=array();
  	$max=59;
  	$start=0;
  	$modulo=5;
  	if($isHours){
  		$max=23;
  		$start=0;
  		$modulo=1;
  	}
  	if($isDayOfMonth){
  		$max=31;
  		$start=1;
  		$modulo=1;
  	}
  	for($i=$start;$i<=$max;$i++){
  		$key=$i;
  		//if($key<10)$key='0'.$key;
  		if ( $i % $modulo==0) $arrayWeekDay[$key]=$key;
  	}
  	$result="";
  	if (! $required) {
  		$result.='<option value="*" '.(($selection=='*')?'selected':'').'>'.i18n('all').'</option>';
  	}
  	foreach($arrayWeekDay as $key=>$line) {
  		$result.= '<option value="' . $key . '"';
  		if ($selection!==null and $key==$selection ) { $result.= ' SELECTED '; }
  		$result.= '>'.$line.'</option>';
  	}
  	return $result;
  }
  ?>    