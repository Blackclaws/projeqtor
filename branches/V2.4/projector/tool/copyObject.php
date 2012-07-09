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
/* @var SqlElement $obj */
if (! is_object($obj)) {
  throwError('last saved object is not a real object');
}

// Get the object class from request
if (! array_key_exists('className',$_REQUEST)) {
  throwError('className parameter not found in REQUEST');
}
$className=$_REQUEST['className'];

// compare expected class with object class
if ($className!=get_class($obj)) {
  throwError('last saved object (' . get_class($obj) . ') is not of the expected class (' . $className . ').'); 
}

// copy from existing object
$newObj=$obj->copy();
// save the new object to session (modified status)
$result=$newObj->_copyResult;
unset($newObj->_copyResult);
$_SESSION['currentObject']=$newObj;
// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>