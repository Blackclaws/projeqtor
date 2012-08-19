<?php
/** ===========================================================================
 * Copy an object as a new one (of the same class) : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

// Get the object from session(last status before change)
if (! array_key_exists('currentObject',$_SESSION)) {
  throwError('currentObject parameter not found in SESSION');
}
$obj=$_SESSION['currentObject'];
if (! is_object($obj)) {
  throwError('last saved object is not a real object');
}

// Get the object class from request
if (! array_key_exists('copyClass',$_REQUEST)) {
  throwError('copyClass parameter not found in REQUEST');
}
$className=$_REQUEST['copyClass'];

// compare expected class with object class
if ($className!=get_class($obj)) {
  throwError('last save object (' . get_class($obj) . ') is not of the expected class (' . $className . ').'); 
}
if (! array_key_exists('copyToClass',$_REQUEST)) {
  throwError('copyToClass parameter not found in REQUEST');
}
$toClassNameObj=new Copyable($_REQUEST['copyToClass']);
$toClassName=$toClassNameObj->name;
if (! array_key_exists('copyToName',$_REQUEST)) {
  throwError('copyToName parameter not found in REQUEST');
}
$toName=$_REQUEST['copyToName'];
$copyToOrigin=false;
if (array_key_exists('copyToOrigin',$_REQUEST)) {
  $copyToOrigin=true;
}
if (! array_key_exists('copyToType',$_REQUEST)) {
  throwError('copyToType parameter not found in REQUEST');
}
$toType=$_REQUEST['copyToType'];

Sql::beginTransaction();
// copy from existing object
$newObj=$obj->copyTo($toClassName,$toType, $toName, $copyToOrigin);
// save the new object to session (modified status)
$result=$newObj->_copyResult;
unset($newObj->_copyResult);
$_SESSION['currentObject']=$newObj;

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
	Sql::rollbackTransaction();
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
	Sql::commitTransaction();
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
	Sql::commitTransaction();
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>