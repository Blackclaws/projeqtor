<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$assignmentId=null;
if (array_key_exists('assignmentId',$_REQUEST)) {
  $assignmentId=$_REQUEST['assignmentId'];
}
$assignmentId=trim($assignmentId);
if ($assignmentId=='') {
  $assignmentId=null;
} 
if ($assignmentId==null) {
  throwError('assignmentId parameter not found in REQUEST');
}
$obj=new Assignment($assignmentId);
$result=$obj->delete();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>