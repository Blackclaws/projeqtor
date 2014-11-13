<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projector.php";

// Get the note info
if (! array_key_exists('noteRefType',$_REQUEST)) {
  throwError('noteRefType parameter not found in REQUEST');
}
$refType=$_REQUEST['noteRefType'];
if (! array_key_exists('noteRefId',$_REQUEST)) {
  throwError('noteRefId parameter not found in REQUEST');
}
$refId=$_REQUEST['noteRefId'];
if (! array_key_exists('noteNote',$_REQUEST)) {
  throwError('noteNote parameter not found in REQUEST');
}
$noteNote=$_REQUEST['noteNote'];

$noteId=null;
if (array_key_exists('noteId',$_REQUEST)) {
  $noteId=$_REQUEST['noteId'];
}
$noteId=trim($noteId);
if ($noteId=='') {
  $noteId=null;
} 

// get the modifications (from request)
$note=new Note($noteId);

if ($note->idUser==null) {
  $note->idUser=$user->id;
}
$note->refId=$refId;
$note->refType=$refType;
if ($note->creationDate==null) {
  $note->creationDate=date("Y-m-d H:i:s");
} else if ($note->note!=$noteNote) {
    $note->updateDate=date("Y-m-d H:i:s");
}
$note->note=$noteNote;

$result=$note->save();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>