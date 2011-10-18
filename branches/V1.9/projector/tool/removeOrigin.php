<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$originId=null;
if (array_key_exists('originId',$_REQUEST)) {
  $originId=$_REQUEST['originId'];
}
$originId=trim($originId);
if ($originId=='') {
  $originId=null;
} 
if ($originId==null) {
  throwError('originId parameter not found in REQUEST');
}
$obj=new Origin($originId);
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