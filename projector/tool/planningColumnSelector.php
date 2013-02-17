<?php
/** ===========================================================================
 * Display the column selector div
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/planningColumnSelector');

$columns=Parameter::getPlanningColumnOrder();
$columnsAll=Parameter::getPlanningColumnOrder(true);
//asort($columns);
foreach ($columnsAll as $order=>$col) {
	if (!isset($resourcePlanning) or ($col!='ValidatedWork' and $col!='Resource' )) {
		echo '<div class="dojoDndItem">';
		echo '<span class="dojoDndHandle handleCursor"><img style="width:6px" src="css/images/iconDrag.gif" />&nbsp;&nbsp;</span>';
	  echo '<span dojoType="dijit.form.CheckBox" type="checkbox" id="col'.$col.'Selector" ' 
	    . (($columns[$order])?' checked="checked" ':'') 
	    . ' onChange="changePlanningColumn(\'' . $col . '\',this.checked,\'' . $order . '\')" '
	    . '></span><label for="col'.$col.'Selector" class="checkLabel">';
	  echo '&nbsp;';
	  echo i18n('col' . $col) . "</label>";
	  echo '</div>';
	}
}

?>