<?php
/** ===========================================================================
 * Save filter from User to Session to be able to restore it
 * Retores it if cancel is set
 * Cleans it if clean is set
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projector.php";
traceLog("backupFilter.php");

$user=$_SESSION['user'];

if (! $user->_arrayFilters) {
  $user->_arrayFilters=array();
}

// Get the filter info
$cancel=false;
if (array_key_exists('cancel',$_REQUEST)) {
  $cancel=true;
}
$clean=false;
if (array_key_exists('clean',$_REQUEST)) {
  $clean=true;
}
$valid=false;
if (array_key_exists('valid',$_REQUEST)) {
  $valid=true;
}
if (! array_key_exists('filterObjectClass',$_REQUEST)) {
  throwError('filterObjectClass parameter not found in REQUEST');
}
$filterObjectClass=$_REQUEST['filterObjectClass'];
$name="";
if (array_key_exists('filterName',$_REQUEST)) {
  $name=$_REQUEST['filterName'];
}

$filterName='stockFilter' . $filterObjectClass;
if ($cancel) {
  if (array_key_exists($filterName,$_SESSION)) {
    $user->_arrayFilters[$filterObjectClass]=$_SESSION[$filterName];
    $_SESSION['user']=$user;
  } else {
    if (array_key_exists($filterObjectClass, $user->_arrayFilters)) {
      unset($user->_arrayFilters[$filterObjectClass]);
      $_SESSION['user']=$user;
    }
  }
} 
if ($clean or $cancel or $valid) {
   if (array_key_exists($filterName,$_SESSION)) {
     unset($_SESSION[$filterName]);
   }
}
if ( ! $clean and ! $cancel and !$valid) {
  if (array_key_exists($filterObjectClass,$user->_arrayFilters)) {
    $_SESSION[$filterName]= $user->_arrayFilters[$filterObjectClass];
  } else {
    $_SESSION[$filterName]=array();
  }
}

if ($valid or $cancel) {
  $user->_arrayFilters[$filterObjectClass . "FilterName"]=$name;
  $_SESSION['user']=$user;
}
?>