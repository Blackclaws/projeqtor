<?php
/** ===========================================================================
 * Move task (from before to)
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/indentTask.php');
if (! array_key_exists('objectClass',$_REQUEST)) {
  throwError('objectClass parameter not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];

if (! array_key_exists('objectId',$_REQUEST)) {
  throwError('objectId parameter not found in REQUEST');
}
$objectId=$_REQUEST['objectId'];

if (! array_key_exists('way',$_REQUEST)) {
  throwError('way parameter not found in REQUEST');
}
$way=$_REQUEST['way'];
if ($way!='increase' and $way!='decrease') {
  $way='increase';
}

$result=i18n('moveCancelled');
$status="ERROR";

Sql::beginTransaction();
$task=new $objectClass($objectId);
$pe=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', array('refType'=>$objectClass,'refId'=>$objectId));
if ($pe and $pe->id) {
	//$pe=new PlanningElement();
	if ($way=="decrease") {
		$top=null;
		if (property_exists($task, 'idActivity') and $task->idActivity) {
			$top=new Activity($task->idActivity);
		} else if (property_exists($task, 'idProject') and $task->idProject) {
			$top=new Project($task->idProject);
		}
		if ($top and property_exists($top, 'idActivity') and $top->idActivity) {
			$task->idActivity=$top->idActivity;
			$task->save();
			$result=i18n('moveDone');
			$status="OK";
		} else if ($top and property_exists($top, 'idProject') and ($top->idProject or $objectClass=='Project') ) {
			if (property_exists($task, 'idActivity') and $task->idActivity) {
				$task->idActivity=null;
			}
			$task->idProject=$top->idProject;
			$task->save();
			$result=i18n('moveDone');
			$status="OK";
		}
	} else { // $way=="increase"
		$precs=$pe->getSqlElementsFromCriteria(null,false,"wbsSortable<'".$pe->wbsSortable."'","wbsSortable desc");
		if (count($precs)>0) {
			foreach ($precs as $pp) {
				if (strlen($pp->wbsSortable)<=strlen($pe->wbsSortable)) {
					$prec=$pp;
					break;
				}
			}
			if ($prec->refType=='Project' and $prec->refId!=$task->idProject) {
				$task->idProject=$prec->refId;
				$task->save();
				$result=i18n('moveDone');
				$status="OK";
			} else if ($prec->refType=='Activity' and property_exists($task, 'idActivity') and $task->idActivity!=$prec->refId) {
				$task->idActivity=$prec->refId;
				$task->save();
				$result=i18n('moveDone');
				$status="OK";
			} else {
				// Cannot move
			}
		}
	}
}

//$result=i18n('moveDone');
//$status="OK";

$result .= '<input type="hidden" id="lastOperation" value="move" />';
$result .= '<input type="hidden" id="lastOperationStatus" value="' . $status . '" />';
$result .= '<input type="hidden" id="lastPlanStatus" value="OK" />';

//$result=$task->moveTo($idTo,$mode);
//$result.=" " . $idFrom . '->' . $idTo .'(' . $mode . ')';
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
	Sql::rollbackTransaction();
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
	Sql::commitTransaction();
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
	Sql::commitTransaction();
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>