<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$id=null;
if (array_key_exists('resourceCostId',$_REQUEST)) {
  $id=$_REQUEST['resourceCostId'];
}
$id=trim($id);
if ($id=='') {
  $id=null;
} 
if ($id==null) {
  throwError('resourceCostId parameter not found in REQUEST');
}
$obj=new ResourceCost($id);
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