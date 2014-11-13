<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$approverItemId=null;
if (array_key_exists('approverItemId',$_REQUEST)) {
  $approverItemId=$_REQUEST['approverItemId'];
}
$approverItemId=trim($approverItemId);
if ($approverItemId=='') {
  $approverItemId=null;
} 
if ($approverItemId==null) {
  throwError('linkId parameter not found in REQUEST');
}
$obj=new Approver($approverItemId);
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