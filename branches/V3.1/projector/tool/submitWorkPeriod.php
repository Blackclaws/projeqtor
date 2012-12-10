<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projector.php";

if (! array_key_exists('action',$_REQUEST)) {
  throwError('action parameter not found in REQUEST');
}
$action=$_REQUEST['action'];
echo $action;

Sql::beginTransaction();
// get the modifications (from request)
$note=new Note($noteId);

$user=$_SESSION['user'];
if (! $note->id) {
  $note->idUser=$user->id;
  $ress=new Resource($user->id);
  $note->idTeam=$ress->idTeam;
}

$note->refId=$refId;
$note->refType=$refType;
if ($note->creationDate==null) {
  $note->creationDate=date("Y-m-d H:i:s");
} else if ($note->note!=$noteNote) {
    $note->updateDate=date("Y-m-d H:i:s");
}
$note->note=$noteNote;
if ($notePrivacy) {
  $note->idPrivacy=$notePrivacy;
} else if (! $note->idPrivacy) {
	$note->idPrivacy=1;
}
$result=$note->save();

if ($note->idPrivacy==1) { // send mail if new note is public
  $elt=new $refType($refId);
	$elt->sendMailIfMailable(false,false,false,true,false);
}

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