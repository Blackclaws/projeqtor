<?php 
// Header
include_once '../tool/projector.php';

$refType="";
if (array_key_exists('refType',$_REQUEST) and trim($_REQUEST['refType'])!="") {
  $refType=trim($_REQUEST['refType']);
}
$refId="";
if (array_key_exists('refId',$_REQUEST)) {
  $refId=trim($_REQUEST['refId']);
}
$scope=$_REQUEST['scope'];
$headerParameters="";

if ($refType!="") {
  $headerParameters.= i18n("colElement") . ' : ' . i18n($refType) . ' #' . $refId . '<br/>';
}
include "header.php";

$accessRightRead=securityGetAccessRight('menuProject', 'read');
  
$where='';
if ($scope=="deleted") {
  $where.= ($where=='')?'':' and ';
  $where.= " operation='delete' ";
  $where.= " and refType in ('Ticket','Activity','Milestone', 'Risk', 'Action', 'Issue', 'Meeting', 'Decision', 'Question', 'Project' )";
} else {
  $where = " refType='$refType' and refId='$refId'";
  $obj=new $refType($refId);
}

$order = ' operationDate desc, id asc';
$hist=new History();
$historyList=$hist->getSqlElementsFromCriteria(null,false,$where,$order);

if (checkNoData($historyList)) exit;

echo '<table width="95%" align="center">';
echo '<tr>';
if ($scope=='deleted') {
  echo '<td class="historyHeader" width="30%">' . i18n('colDate') . '</td>';
  echo '<td class="historyHeader" width="30%">' . i18n('colUser'). '</td>';
  echo '<td class="historyHeader" width="40%">' . i18n('colElement'). '</td>';
} else {
  echo '<td class="historyHeader" width="20%">' . i18n('colDate') . '</td>';
  echo '<td class="historyHeader" width="15%">' . i18n('colUser'). '</td>';
  echo '<td class="historyHeader" width="10%">' . i18n('colOperation'). '</td>';
  echo '<td class="historyHeader" width="15%">' . i18n('colColumn'). '</td>';
  echo '<td class="historyHeader" width="20%">' . i18n('colValueBefore'). '</td>';
  echo '<td class="historyHeader" width="20%">' . i18n('colValueAfter'). '</td>';
}
echo '</tr>';
$stockDate=null;
$stockUser=null;
$stockOper=null;
foreach($historyList as $hist) {
  $colName=($hist->colName==null)?'':$hist->colName;
  $curObj=null; $dataType=""; $dataLength=0;
  $hide=false;
  $oper=i18n('operation' . ucfirst($hist->operation) );
  $user=$hist->idUser;
  $user=SqlList::getNameFromId('User',$user);
  $date=htmlFormatDateTime($hist->operationDate);
  $class="NewOperation";
  if ($stockDate==$hist->operationDate 
  and $stockUser==$hist->idUser
  and $stockOper==$hist->operation) {
    $oper="";
    $user="";
    $date="";
    $class="ContinueOperation";
  }
  if ($colName!='') {
    $curObj=new $hist->refType();
    if ($curObj) {
      $colCaption=$curObj->getColCaption($hist->colName);
      $dataType=$obj->getDataType($colName);
      $dataLength=$obj->getDataLength($colName);
      if (strpos($curObj->getFieldAttributes($colName), 'hidden')!==false) {
        $hide=true;
      }
    }
  } else {
    $colCaption='';
  }
  if (substr($hist->refType,-15)=='PlanningElement' and $hist->operation=='insert') {
    $hide=true;
  }
  if (! $hide) {
    echo '<tr>';
    echo '<td class="historyData'. $class .'">' . $date . '</td>';
    echo '<td class="historyData'. $class .'">' . $user . '</td>';
    if ($scope=='deleted') {
      echo '<td class="historyData'. $class .'">' . i18n($hist->refType) . ' #' . $hist->refId . '</td>';
    } else {
      echo '<td class="historyData'. $class .'">' . $oper . '</td>';
      
      echo '<td class="historyData">' . $colCaption . '</td>';
      $oldValue=$hist->oldValue;
      $newValue=$hist->newValue;
      if ($dataType=='int' and $dataLength==1) { // boolean
        $oldValue=htmlDisplayCheckbox($oldValue);
        $newValue=htmlDisplayCheckbox($newValue);
      } else if (substr($colName,0,2)=='id' and strlen($colName)>2
                 and strtoupper(substr($colName,2,1))==substr($colName,2,1)) {
        if ($oldValue!=null and $oldValue!='') {
          $oldValue=SqlList::getNameFromId(substr($colName,2),$oldValue);
        }
        if ($newValue!=null and $newValue!='') {
          $newValue=SqlList::getNameFromId(substr($colName,2),$newValue);
        }
      } else if ($colName=="color") {
        $oldValue=htmlDisplayColored("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$oldValue);
        $newValue=htmlDisplayColored("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$newValue);
      } else {
        $oldValue=htmlEncode($oldValue,'print');
        $newValue=htmlEncode($newValue,'print');
      }
      
      echo '<td class="historyData">' . $oldValue . '</td>';
      echo '<td class="historyData">' . $newValue . '</td>';
    }
    echo '</tr>';
    $stockDate=$hist->operationDate;
    $stockUser=$hist->idUser;
    $stockOper=$hist->operation;
  }
}
echo '<tr>';
echo '<td class="historyDataClosetable">&nbsp;</td>';
echo '<td class="historyDataClosetable">&nbsp;</td>';
echo '<td class="historyDataClosetable">&nbsp;</td>';
echo '<td class="historyDataClosetable">&nbsp;</td>';
echo '<td class="historyDataClosetable">&nbsp;</td>';
echo '<td class="historyDataClosetable">&nbsp;</td>';
echo '</tr>';
echo '</table>';

?>
