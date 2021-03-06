<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$dependencyId=null;
if (array_key_exists('dependencyId',$_REQUEST)) {
  $dependencyId=$_REQUEST['dependencyId'];
}
$dependencyId=trim($dependencyId);
if ($dependencyId=='') {
  $dependencyId=null;
} 
if ($dependencyId==null) {
  throwError('dependencyId parameter not found in REQUEST');
}
$obj=new Dependency($dependencyId);
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