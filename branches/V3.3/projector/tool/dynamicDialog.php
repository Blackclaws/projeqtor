<?php
include_once '../tool/projector.php';
if (! array_key_exists('dialog', $_REQUEST)) {
	throwError('dialog parameter not found in REQUEST');
}
$dialog=$_REQUEST['dialog'];
//echo "<br/>".$dialog."<br/>";
if ($dialog=="dialogTodayParameters") {
	$today=new Today();
  $crit=array('idUser'=>$user->id);
  $todayList=$today->getSqlElementsFromCriteria($crit, false, 'sortOrder asc');
  $cptStatic=0;
  foreach ($todayList as $todayItem) {
  	if ($todayItem->scope=='static') {$cptStatic+=1;}
  }
  if ($cptStatic!=count(Today::$staticList)) {
  	Today::insertStaticItems();
  	$todayList=$today->getSqlElementsFromCriteria($crit, false, 'sortOrder asc');
  }
  $user=$_SESSION['user'];
  $profile=SqlList::getFieldFromId('Profile', $user->idProfile, 'profileCode');
  echo '<form dojoType="dijit.form.Form" id="todayParametersForm" name="todayParametersForm" onSubmit="return false;">';
	echo '<table>';
	foreach ($todayList as $todayItem) {
		if ($todayItem->scope!="static" or $todayItem->staticSection!="ProjectsTasks" or $profile=='PL') {
			echo '<tr id="dialogTodayParametersRow' . $todayItem->id. '">';
			echo '<td style="width:16px">';
			if ($todayItem->scope!='static') {
				echo '<img src="../view/css/images/smallButtonRemove.png" onClick="setTodayParameterDeleted(' . $todayItem->id. ');" />';
			}
			echo '<input type="hidden" name="dialogTodayParametersDelete' . $todayItem->id. '" id="dialogTodayParametersDelete' . $todayItem->id. '" value="0" />';
			echo '</td>';
			echo '<td style="width:16px"><div name="dialogTodayParametersIdle' . $todayItem->id. '" 
			           dojoType="dijit.form.CheckBox" type="checkbox" '.(($todayItem->idle=='0')?' checked="checked"':'').'>
			          </div>'.'</td>';
			echo '<td>';
			if ($todayItem->scope=="static") {
				echo i18n('today'.$todayItem->staticSection);
			} else {
				echo $todayItem->scope."|".$todayItem->staticSection;
			}
			echo '</td>';
			echo '</tr>';
		}
	}
	echo '</table>'; 
	echo '<br/>';
	echo '<table width="100%">';
	echo '  <tr>';
  echo '    <td align="center">';
  echo '      <button dojoType="dijit.form.Button" onclick="dijit.byId(\'dialogTodayParameters\').hide();">';
  echo          i18n("buttonCancel");
  echo '      </button>';
  echo '      <button dojoType="dijit.form.Button" type="submit" id=dialogTodayParametersSubmit" onclick="saveTodayParameters();return false;">';
  echo          i18n("buttonOK");
  echo '      </button>';
  echo '    </td>';
  echo '  </tr>';
  echo '</table>';
	echo '</form>';
} else {
	echo "ERROR dialog=".$dialog." is not an expected dialog";
}