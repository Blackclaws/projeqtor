<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projector.php";

if (! array_key_exists('approverId',$_REQUEST)) {
  throwError('approverId parameter not found in REQUEST');
}
$approverId=$_REQUEST['approverId'];

$approver=new Approver($approverId);
$approver->approved=1;
$approver->approvedDate=date('Y-m-d H:i');
$result=$approver->save();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . i18n('approved') . '<div style="display:none;">' . $result . '</div></span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>