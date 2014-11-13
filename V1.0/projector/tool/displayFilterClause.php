<?php
/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projector.php";

$user=$_SESSION['user'];

if (! $user->_arrayFilters) {
  $user->_arrayFilters=array();
}

if (! array_key_exists('filterObjectClass',$_REQUEST)) {
  throwError('filterObjectClass parameter not found in REQUEST');
}
$filterObjectClass=$_REQUEST['filterObjectClass'];

// Get existing filter info
if (array_key_exists($filterObjectClass,$user->_arrayFilters)) {
  $filterArray=$user->_arrayFilters[$filterObjectClass];
} else {
  $filterArray=array();
}

$name="";
if (array_key_exists($filterObjectClass . "FilterName", $user->_arrayFilters)) {
  $name=$user->_arrayFilters[$filterObjectClass . "FilterName"];
}

htmlDisplayFilterCriteria($filterArray,$name); 

?>