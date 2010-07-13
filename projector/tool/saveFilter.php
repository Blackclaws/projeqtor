<?php
/** ===========================================================================
 * Save a filter : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

require_once "../tool/projector.php";

$user=$_SESSION['user'];

if (! $user->_arrayFilters) {
  $user->_arrayFilters=array();
}

// Get the filter info
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
if (array_key_exists('filterName',$_REQUEST)) {
  $name=$_REQUEST['filterName'];
}
trim($name);
if (! $name) {
  echo htmlGetErrorMessage((i18n("messageMandatory", array(i18n("filterName")))));
} else {
  $crit=array("refType"=>$filterObjectClass, "name"=>$name, "idUser"=>$user->id);
  $filter=SqlElement::getSingleSqlElementFromCriteria("Filter", $crit);
  if (! $filter->id) {
    $filter->refType=$filterObjectClass;
    $filter->name=$name;
    $filter->idUser=$user->id;
  }
  $filter->save();
  $criteria=new FilterCriteria();
  $criteria->purge("idFilter='" . $filter->id . "'");
  foreach ($filterArray as $filterCriteria) {
    $criteria=new FilterCriteria();
    $criteria->idFilter=$filter->id;
    $criteria->dispAttribute=$filterCriteria["disp"]["attribute"];
    $criteria->dispOperator=$filterCriteria["disp"]["operator"];
    $criteria->dispValue=$filterCriteria["disp"]["value"];
    $criteria->sqlAttribute=$filterCriteria["sql"]["attribute"];
    $criteria->sqlOperator=$filterCriteria["sql"]["operator"];
    $criteria->sqlValue=$filterCriteria["sql"]["value"];
    $criteria->save();
  }
}

$flt=new Filter();
$crit=array('idUser'=> $user->id, 'refType'=>$filterObjectClass );
$filterList=$flt->getSqlElementsFromCriteria($crit, false);
htmlDisplayStoredFilter($filterList);


?>