<?php
/** ===========================================================================
 * Delete the current documentVersion : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$documentVersionId=null;
if (array_key_exists('documentVersionId',$_REQUEST)) {
  $documentVersionId=$_REQUEST['documentVersionId'];
}
$documentVersionId=trim($documentVersionId);
if ($documentVersionId=='') {
  $documentVersionId=null;
} 
if ($documentVersionId==null) {
  throwError('documentVersionId parameter not found in REQUEST');
}
$obj=new DocumentVersion($documentVersionId);
$file=$obj->getUploadFileName();
if (file_exists($file)) {
  unlink($file);
}
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