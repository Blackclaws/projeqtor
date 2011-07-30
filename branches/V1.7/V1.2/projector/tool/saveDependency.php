<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projector.php";

// Get the link info
if (! array_key_exists('dependencyRefType',$_REQUEST)) {
  throwError('dependencyRefType parameter not found in REQUEST');
}
$dependencyRefType=$_REQUEST['dependencyRefType'];

if (! array_key_exists('dependencyRefId',$_REQUEST)) {
  throwError('dependencyRefId parameter not found in REQUEST');
}
$dependencyRefId=$_REQUEST['dependencyRefId'];

if (! array_key_exists('dependencyType',$_REQUEST)) {
  throwError('dependencyType parameter not found in REQUEST');
}
$dependencyType=$_REQUEST['dependencyType'];

if (! array_key_exists('dependencyRefTypeDep',$_REQUEST)) {
  throwError('dependencyRefTypeDep parameter not found in REQUEST');
}
$dependencyRefTypeDep=SqlList::getNameFromId('Dependable', $_REQUEST['dependencyRefTypeDep']);

if (! array_key_exists('dependencyRefIdDep',$_REQUEST)) {
  throwError('dependencyRefIdDep parameter not found in REQUEST');
}
$dependencyRefIdDep=$_REQUEST['dependencyRefIdDep'];

if ($dependencyType=="Successor") {
  $critPredecessor=array("refType"=>$dependencyRefType,"refId"=>$dependencyRefId);
  $critSuccessor=array("refType"=>$dependencyRefTypeDep,"refId"=>$dependencyRefIdDep);
} else if ($dependencyType=="Predecessor") {  
  $critSuccessor=array("refType"=>$dependencyRefType,"refId"=>$dependencyRefId);
  $critPredecessor=array("refType"=>$dependencyRefTypeDep,"refId"=>$dependencyRefIdDep);  
} else {
  throwError('unknown dependency type : \'' . $dependencyType . '\'');
}

$successor=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',$critSuccessor);
$predecessor=SqlElement::getSingleSqlElementFromCriteria('PlanningElement',$critPredecessor);;

$dependencyId=null;
$dep=new Dependency($dependencyId);
$dep->successorId=$successor->id;
$dep->successorRefType=$successor->refType;
$dep->successorRefId=$successor->refId;
$dep->predecessorId=$predecessor->id;
$dep->predecessorRefType=$predecessor->refType;
$dep->predecessorRefId=$predecessor->refId;
$dep->dependencyType='E-S';
$dep->dependencyDelay=0;

$result=$dep->save();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>