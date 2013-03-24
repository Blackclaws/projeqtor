<?php
include_once '../tool/projector.php';
if (! array_key_exists('dialog', $_REQUEST)) {
	throwError('dialog parameter not found in REQUEST');
}
$dialog=$_REQUEST['dialog'];
//echo "<br/>".$dialog."<br/>";
if ($dialog=="dialogTodayParameters") {
	$today=new Today();
  $crit=array('idUser'=>$user->id, 'idle'=>'0');
  $todayList=$today->getSqlElementsFromCriteria($crit, false, 'sortOrder asc');
  $user=$_SESSION['user'];
  $profile=SqlList::getFieldFromId('Profile', $user->idProfile, 'profileCode');
  echo '<form dojoType="dijit.form.Form" id="todayParametersForm" name="todayParametersForm" onSubmit="return false;">';
	echo '<table>';
	foreach ($todayList as $todayItem) {
		if ($todayItem->scope!="static" or $todayItem->staticSection!="ProjectsTasks" or $profile=='PL') {
			echo '<tr>';
			echo '<td style="width:16px">';
			if ($todayItem->scope!='static') {
				echo '<img src="../view/css/images/smallButtonRemove.png" onClick="" />';
			}
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