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
if (! array_key_exists('filterValue',$_REQUEST)) {
  throwError('filterValue parameter not found in REQUEST');
}
$filterValue=$_REQUEST['filterValue'];
if (array_key_exists('filterValueList',$_REQUEST)) {
  $filterValueList=$_REQUEST['filterValueList'];
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
    if ($dataType=='date') {
      $arrayDisp["value"]="'" . htmlFormatDate($filterValueDate) . "'";
      $arraySql["value"]="'" . $filterValueDate . "'";
    } else if ($dataType=='int') {
      if ($dataLength==1) {
        $arrayDisp["value"]=($filterValueCheckbox)?i18n("displayYes"):i18n("displayNo");
        $arraySql["value"]=($filterValueCheckbox)?1:0;
      } else {
        $arrayDisp["value"]="'" . htmlFormatDate($filterValueDate) . "'";
        $arraySql["value"]="'" . $filterValueDate . "'";
      }
    } else {
      $arrayDisp["value"]="'" . $filterValue . "'";
      $arraySql["value"]="'" . $filterValue . "'";
    }
  } else if ($idFilterOperator=="LIKE") {
    $arrayDisp["operator"]=i18n("contains");
    $arraySql["operator"]=$idFilterOperator;
    $arrayDisp["value"]="'" . $filterValue . "'";
    $arraySql["value"]="'%" . $filterValue . "%'";
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
    $arraySql["value"]=")";
    
  } else {
     htmlGetErrorMessage(i18n('incorrectOperator'));
     exit;
  }  
  $filterArray[]=array("disp"=>$arrayDisp,"sql"=>$arraySql);
  $user->_arrayFilters[$filterObjectClass]=$filterArray;
}

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