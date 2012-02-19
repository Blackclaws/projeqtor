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

// Get the filter info
if (! array_key_exists('filterClauseId',$_REQUEST)) {
  throwError('filterClauseId parameter not found in REQUEST');
}
$filterClauseId=$_REQUEST['filterClauseId'];
if (! array_key_exists('filterObjectClass',$_REQUEST)) {
  throwError('filterObjectClass parameter not found in REQUEST');
}
$filterObjectClass=$_REQUEST['filterObjectClass'];
$name="";
if (array_key_exists('filterName',$_REQUEST)) {
  $name=$_REQUEST['filterName'];
}
trim($name);

// Get existing filter info
if (array_key_exists($filterObjectClass,$user->_arrayFilters)) {
  $filterArray=$user->_arrayFilters[$filterObjectClass];
} else {
  $filterArray=array();
}

if ($filterClauseId=='all') {
  $filterArray=array();
} else {
  unset($filterArray[$filterClauseId]);
}
$user->_arrayFilters[$filterObjectClass]=$filterArray;

//$user->_arrayFilters[$filterObjectClass . "FilterName"]=$name;
$user->_arrayFilters[$filterObjectClass . "FilterName"]="";

htmlDisplayFilterCriteria($filterArray,$name);

// save user (for filter saving)
$_SESSION['user']=$user;


?>