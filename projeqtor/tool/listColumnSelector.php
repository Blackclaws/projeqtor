<?php
/** ===========================================================================
 * Display the column selector div
 */

require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/listColumnSelector');
//echo "$objectClass<br/>";
//$columns=Parameter::getPlanningColumnOrder();
//$columnsAll=Parameter::getPlanningColumnOrder(true);
$listColumns=ColumnSelector::getColumnsList($objectClass);
//echo "<textarea>$listColumns</textarea>";
//asort($columns);
//$pe=new ProjectPlanningElement();
//$pe->setVisibility();
//$workVisibility=$pe->_workVisibility;
//$costVisibility=$pe->_costVisibility;    
foreach ($listColumns as $col) {
	if ( ! SqlElement::isVisibleField($col->_name) ) {
		// nothing 
	} else {
		echo '<div class="dojoDndItem" id="listColumnSelectorId'.$col->id.'" dndType="planningColumn">';
		echo '<span class="dojoDndHandle handleCursor"><img style="width:6px" src="css/images/iconDrag.gif" />&nbsp;&nbsp;</span>';
	  echo '<span dojoType="dijit.form.CheckBox" type="checkbox" id="checkListColumnSelectorId'.$col->id.'" ' 
	    . ((! $col->hidden)?' checked="checked" ':'')
	    . (( $col->_name=='id')?' disabled="disabled" ':'') 
	    . ' onChange="changeListColumn(\'' . $col->id . '\',this.checked,\'' . $col->sortOrder . '\')" '
	    . '></span><label for="checkColumnSelector'.$col->_name.'" class="checkLabel">';
	  echo '&nbsp;';
	  echo $col->_displayName . "</label>";
	  echo '</div>';
	}
}

?>