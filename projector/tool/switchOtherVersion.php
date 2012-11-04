<?php
/** ===========================================================================
 * Delete the current object : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$id=null;
if (array_key_exists('otherVersionId',$_REQUEST)) {
  $id=$_REQUEST['otherVersionId'];
}
$id=trim($id);
if ($id=='') {
  $id=null;
} 
if ($id==null) {
  throwError('linkId parameter not found in REQUEST');
}
Sql::beginTransaction();
$vers=new OtherVersion($id);
$refType=$vers->refType;
$refId=$vers->refId;
$fld='id'.$vers->scope;
$fldArray='_Other'.$vers->scope;
$obj=new $refType($refId);
$mainVers=$obj->$fld;
$otherVers=$vers->idVersion;
foreach ($obj->$fldArray as $vers) {
	if ($vers->id==$id) {
		$vers->idVersion=$mainVers;
	}
}
$obj->$fld=$otherVers;
$result=$obj->save();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
	Sql::rollbackTransaction();
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
	Sql::commitTransaction();
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
	Sql::rollbackTransaction();
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>