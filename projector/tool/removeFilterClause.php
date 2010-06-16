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

// Get existing filter info
if (array_key_exists($filterObjectClass,$user->_arrayFilters)) {
  $filterArray=$user->_arrayFilters[$filterObjectClass];
} else {
  $filterArray=array();
}

unset($filterArray["disp"][$filterClauseId]);
unset($filterArray["sql"][$filterClauseId]);
$user->_arrayFilters[$filterObjectClass]=$filterArray;

//echo $filterClauseId;
// Display Result
echo "<table>";
echo "<tr>";
echo "<td class='filterHeader' style='width:525px;'>" . i18n("criteria") . "</td>";
echo "<td class='filterHeader' style='width:25px;'>&nbsp;</td>";
echo "</tr>";
foreach ($filterArray as $id=>$filter) {
  echo "<tr>";
  echo "<td class='filterData'>" . 
       $filter['disp']['attribute'] . " " .
       $filter['disp']['operator'] . " " .
       $filter['disp']['value'] .
       "</td>";
  echo "<td class='filterData' style='text-align: center;'>";
  echo ' <img src="css/images/smallButtonRemove.png" onClick="removefilter(' . $id . ');" title="' . i18n('removefilter') . '" class="smallButton"/> ';
  echo "</td>";
  echo "</tr>";
}
echo "<tr><td>&nbsp;</td></tr>";
echo "</table>";


// save user (for filter saving)
$_SESSION['user']=$user;


?>