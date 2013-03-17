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
		echo '<div class="dojoDndItem" id="columnSelector'.$col.'" dndType="planningColumn">';
		echo '<span class="dojoDndHandle handleCursor"><img style="width:6px" src="css/images/iconDrag.gif" />&nbsp;&nbsp;</span>';
	  echo '<span dojoType="dijit.form.CheckBox" type="checkbox" id="checkColumnSelector'.$col.'" ' 
	    . ((substr($columns[$order],0,6)!='Hidden')?' checked="checked" ':'') 
	    . ' onChange="changePlanningColumn(\'' . $col . '\',this.checked,\'' . $order . '\')" '
	    . '></span><label for="checkColumnSelector'.$col.'" class="checkLabel">';
	  echo '&nbsp;';
	  echo i18n('col' . $col) . "</label>";
	  echo '</div>';
	}
}

?>