<?php
/** ===========================================================================
 * Save a checklistdefinition line : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projeqtor.php";
if (! array_key_exists('checklistDefinitionId',$_REQUEST)) {
	throwError('checklistDefinitionId parameter not found in REQUEST');
}
$checklistDefinitionId=trim($_REQUEST['checklistDefinitionId']);
if (! array_key_exists('checklistId',$_REQUEST)) {
	throwError('checklistId parameter not found in REQUEST');
}
$checklistId=trim($_REQUEST['checklistId']);
if (! array_key_exists('checklistObjectClass',$_REQUEST)) {
	throwError('checklistObjectClass parameter not found in REQUEST');
}
$checklistObjectClass=$_REQUEST['checklistObjectClass'];
if (! array_key_exists('checklistObjectId',$_REQUEST)) {
	throwError('checklistObjectId parameter not found in REQUEST');
}
$checklistObjectId=trim($_REQUEST['checklistObjectId']);

$checklistDefinition=new ChecklistDefinition($checklistDefinitionId);
$checklist=new Checklist($checklistId);
$cl=new ChecklistLine();
$linesTmp=$cl->getSqlElementsFromCriteria(array('idChecklist'=>$checklist->id));
$linesVal=array();
foreach ($linesTmp as $line) {
	$linesVal[$line->idChecklistDefinitionLine]=$line;
}

Sql::beginTransaction();
$checklist->refType=$checklistObjectClass;
$checklist->refId=$checklistObjectId;
$checklist->idChecklistDefinition=$checklistDefinitionId;
$result=$checklist->save();

foreach($checklistDefinition->_ChecklistDefinitionLine as $line) {
	if (isset($linesVal[$line->id])) {
		$valLine=$linesVal[$line->id];
	} else {
		$valLine=new ChecklistLine();
	}
	$valLine->idChecklist=$checklist->id;
	$valLine->idChecklistDefinitionLine=$line->id;
	$valLine->checkTime=date('Y-m-d H:i:s');
	$valLine->idChecklistDefinitionLine=$line->id;
	
	$checkedCpt=0;
	for ($i=1; $i<=5; $i++) {
		$checkName="check_".$line->id."_".$i;
		$valueName="value0".$i;
		if (isset($_REQUEST[$checkName])) {
			$checkedCpt+=1;
			if (! $valLine->$valueName) {
				$valLine->idUser=$_SESSION['user']->id;
			  $valLine->checkTime=date('Y-m-d H:i:s');
			}
		}
	}
	if ($checkedCpt==0) {
		if ($valLine->id) {
			$valLine->delete();
		}
	} else {
		$resultLine=$valLine->save();
	}
}


// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
	Sql::rollbackTransaction();
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
	Sql::commitTransaction();
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
	Sql::rollbackTransaction();
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>