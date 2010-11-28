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
if (! array_key_exists('idFilterAttribute',$_REQUEST)) {
  throwError('idFilterAttribute parameter not found in REQUEST');
}
$idFilterAttribute=$_REQUEST['idFilterAttribute'];
if (! array_key_exists('idFilterOperator',$_REQUEST)) {
  throwError('idFilterOperator parameter not found in REQUEST');
}
$idFilterOperator=$_REQUEST['idFilterOperator'];
if (! array_key_exists('filterDataType',$_REQUEST)) {
  throwError('filterDataType parameter not found in REQUEST');
}
$filterDataType=$_REQUEST['filterDataType'];
if (! array_key_exists('filterValue',$_REQUEST)) {
  throwError('filterValue parameter not found in REQUEST');
}
$filterValue=$_REQUEST['filterValue'];
if (array_key_exists('filterValueList',$_REQUEST)) {
  $filterValueList=$_REQUEST['filterValueList'];
} else {
  $filterValueList=array();
}

if (! array_key_exists('filterValueDate',$_REQUEST)) {
  throwError('filterValueDate parameter not found in REQUEST');
}
$filterValueDate=$_REQUEST['filterValueDate'];
if (! array_key_exists('filterValueCheckbox',$_REQUEST)) {
  $filterValueCheckbox=false;
} else {
  $filterValueCheckbox=true;
}
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

$obj=new $filterObjectClass();
// Add new filter
if ($idFilterAttribute and $idFilterOperator) {
  $arrayDisp=array();
  $arraySql=array();
  $dataType=$obj->getDataType($idFilterAttribute);
  $dataLength=$obj->getDataLength($idFilterAttribute);
  $arrayDisp["attribute"]=$obj->getColCaption($idFilterAttribute);
  $arraySql["attribute"]=$idFilterAttribute;
  if ($idFilterOperator=="=" or $idFilterOperator==">=" or $idFilterOperator=="<=") {
    $arrayDisp["operator"]=$idFilterOperator;
    $arraySql["operator"]=$idFilterOperator;
    if ($filterDataType=='date') {
      $arrayDisp["value"]="'" . htmlFormatDate($filterValueDate) . "'";
      $arraySql["value"]="'" . $filterValueDate . "'";
    } else if ($filterDataType=='bool') {
        $arrayDisp["value"]=($filterValueCheckbox)?i18n("displayYes"):i18n("displayNo");
        $arraySql["value"]=($filterValueCheckbox)?1:0;
    } else {
      $arrayDisp["value"]="'" . htmlEncode($filterValue) . "'";
      $arraySql["value"]="'" . htmlEncode($filterValue) . "'";
    }
  } else if ($idFilterOperator=="LIKE") {
    $arrayDisp["operator"]=i18n("contains");
    $arraySql["operator"]=$idFilterOperator;
    $arrayDisp["value"]="'" . htmlEncode($filterValue) . "'";
    $arraySql["value"]="'%" . htmlEncode($filterValue) . "%'";
  } else if ($idFilterOperator=="IN") {
    $arrayDisp["operator"]=i18n("amongst");
    $arraySql["operator"]=$idFilterOperator;
    $arrayDisp["value"]="";
    $arraySql["value"]="(";
    foreach ($filterValueList as $key=>$val) {
      $arrayDisp["value"].=($key==0)?"":", ";
      $arraySql["value"].=($key==0)?"":", ";
      $arrayDisp["value"].="'" . SqlList::getNameFromId(substr($idFilterAttribute,2),$val) . "'";
      $arraySql["value"].= $val ;
    }
    //$arrayDisp["value"].=")";
    $arraySql["value"].=")";
    
  } else {
     htmlGetErrorMessage(i18n('incorrectOperator'));
     exit;
  } 
  $filterArray[]=array("disp"=>$arrayDisp,"sql"=>$arraySql);
  $user->_arrayFilters[$filterObjectClass]=$filterArray;
}

$user->_arrayFilters[$filterObjectClass . "FilterName"]=$name;

htmlDisplayFilterCriteria($filterArray,$name); 

// save user (for filter saving)
$_SESSION['user']=$user;


?>