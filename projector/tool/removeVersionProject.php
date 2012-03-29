<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$versionProjectId=null;
if (array_key_exists('versionProjectId',$_REQUEST)) {
  $versionProjectId=$_REQUEST['versionProjectId'];
}
$versionProjectId=trim($versionProjectId);
if ($versionProjectId=='') {
  $versionProjectId=null;
} 
if ($versionProjectId==null) {
  throwError('versionProjectId parameter not found in REQUEST');
}
$obj=new VersionProject($versionProjectId);
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