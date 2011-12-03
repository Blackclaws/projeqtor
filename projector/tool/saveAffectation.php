<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projector.php";
scriptLog('   ->/tool/saveAffectation.php');
// Get the info
if (! array_key_exists('affectationId',$_REQUEST)) {
  throwError('affectationId parameter not found in REQUEST');
}
$id=($_REQUEST['affectationId']);

if (! array_key_exists('affectationProject',$_REQUEST)) {
  throwError('affectationProject parameter not found in REQUEST');
}
$project=($_REQUEST['affectationProject']);

if (! array_key_exists('affectationResource',$_REQUEST)) {
  throwError('affectationResource parameter not found in REQUEST');
}
$resource=($_REQUEST['affectationResource']);

if (! array_key_exists('affectationRate',$_REQUEST)) {
  throwError('affectationRate parameter not found in REQUEST');
}
$rate=($_REQUEST['affectationRate']);

$idle=false;
if (array_key_exists('affectationIdle',$_REQUEST)) {
  $idle=true;
}

$affectation=new Affectation($id);

$affectation->idProject=$project;
$affectation->idResource=$resource;
$res=new Resource($resource);
$affectation->idResourceSelect=$res->id;
$usr=new User($resource);
$affectation->idUser=$usr->id;
$con=new Contact($resource);
$affectation->idContact=$con->id;
$affectation->idle=$idle;
$affectation->rate=$rate;

$result=$affectation->save();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>