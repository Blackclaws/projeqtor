<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$lineId=null;
if (array_key_exists('billLineId',$_REQUEST)) {
  $lineId=$_REQUEST['billLineId'];
}
$lineId=trim($lineId);
if ($lineId=='') {
  $lineId=null;
} 
if ($lineId==null) {
  throwError('billLineId parameter not found in REQUEST');
}
$obj=new BillLine($lineId);
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