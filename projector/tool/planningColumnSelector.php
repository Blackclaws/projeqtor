<?php
/** ===========================================================================
 * Display the column selector div
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/planningColumnSelector');

$columns=Parameter::getPlanningColumnOrder();
//asort($columns);
foreach ($columns as $order=>$col) {
	if (!isset($resourcePlanning) or ($col!='ValidatedWork' and $col!='Resource' )) {
	  echo '<div dojoType="dijit.form.CheckBox" type="checkbox" ' . (($order>0)?' checked="checked" ':'') 
	    . ' onChange="changePlanningColumn(\'' . $col . '\',this.checked,\'' . $order . '\')" '
	    . '></div>';
	  echo '&nbsp;';
	  echo i18n('col' . $col) . "<br/>";
	}
}

?>