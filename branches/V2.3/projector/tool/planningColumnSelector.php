<?php
/** ===========================================================================
 * Display the column selector div
 */

require_once "../tool/projector.php";
scriptLog('   ->/tool/planningColumnSelector');

$columns=Parameter::getPlanningColumnOrder();
//asort($columns);
foreach ($columns as $col=>$order) {
	echo '<div dojoType="dijit.form.CheckBox" type="checkbox" ' . (($order>0)?' checked="checked" ':'') . '></div>';
	echo '&nbsp;';
	echo i18n('col' . $col) . "<br/>";
}

?>