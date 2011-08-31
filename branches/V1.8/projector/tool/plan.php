<?php
/** ===========================================================================
 * Run planning
 */
require_once "../tool/projector.php";

if (! array_key_exists('idProjectPlan',$_REQUEST)) {
  throwError('idProjectPlan parameter not found in REQUEST');
}
$idProjectPlan=$_REQUEST['idProjectPlan'];
if (! array_key_exists('startDatePlan',$_REQUEST)) {
  throwError('startDatePlan parameter not found in REQUEST');
}
$startDatePlan=$_REQUEST['startDatePlan'];

set_time_limit(600);
$result=PlannedWork::plan($idProjectPlan, $startDatePlan);

// Message of correct saving
if (stripos($result,'id="lastPlanStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastPlanStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>