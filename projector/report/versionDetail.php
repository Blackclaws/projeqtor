<?php
include_once '../tool/projector.php';
//echo 'versionReport.php';

$paramProject='';
if (array_key_exists('idProject',$_REQUEST)) {
  $paramProject=trim($_REQUEST['idProject']);
};
  
$paramResponsible='';
if (array_key_exists('responsible',$_REQUEST)) {
  $paramResponsible=trim($_REQUEST['responsible']);
};
$paramVersion='';
if (array_key_exists('idVersion',$_REQUEST)) {
  $paramVersion=trim($_REQUEST['idVersion']);
};

$user=$_SESSION['user'];
  
  // Header
$headerParameters="";
if ($paramProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $paramProject) . '<br/>';
}
if ($paramResponsible!="") {
  $headerParameters.= i18n("colResponsible") . ' : ' . SqlList::getNameFromId('Resource', $paramResponsible) . '<br/>';
}
if ($paramVersion!="") {
  $headerParameters.= i18n("colVersion") . ' : ' . SqlList::getNameFromId('Version', $paramVersion) . '<br/>';
}
include "header.php";

$where=getAccesResctictionClause('Ticket',false);

$order="";

if ($paramVersion) {
  $lstVersion=array($paramVersion=>SqlList::getNameFromId('Version',$paramVersion));
} else {
  $lstVersion=SqlList::getList('Version');
  $lstVersion[0]='<i>'.i18n('undefinedValue').'</i>';
}

if (checkNoData($lstVersion)) exit;

$lstObj=array(new Ticket(), new Activity());

foreach ($lstVersion as $versId=>$versName) {
  echo '<table width="95%" align="center">';
  echo '<tr>';
  echo '<td class="reportTableHeader" colspan="3">' . $versName . '</td>';
  echo '<td class="reportTableLineHeader" width="10%" style="text-align:center;" rowspan="2">' . i18n('colIdStatus') . '</td>';
  echo '<td class="reportTableLineHeader" width="10%" style="text-align:center;" rowspan="2">' . i18n('colResponsible') . '</td>';
  echo '<td class="reportTableLineHeader" width="10%" style="text-align:center;" rowspan="2">' . i18n('colIdPriority') . '</td>';
  echo '<td class="reportTableLineHeader" colspan="4" style="text-align:center;">' . i18n('colWork') . '</td>';
  echo '<td class="reportTableLineHeader" width="5%" style="text-align:center;" rowspan="2">' . i18n('colHandled') . '</td>';
  echo '<td class="reportTableLineHeader" width="5%" style="text-align:center;" rowspan="2">' . i18n('colDone') . '</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td class="reportTableLineHeader" width="10%" style="text-align:center;">' . i18n('colId') . '</td>';
  echo '<td class="reportTableLineHeader" width="10%" style="text-align:center;">' . i18n('colType') . '</td>';
  echo '<td class="reportTableLineHeader" width="20%" style="text-align:center;">' . i18n('colName') . '</td>';
  echo '<td class="reportTableLineHeader" width="5%" style="text-align:center;">' . i18n('colInitial') . '</td>';
  echo '<td class="reportTableLineHeader" width="5%" style="text-align:center;">' . i18n('colReal') . '</td>';
  echo '<td class="reportTableLineHeader" width="5%" style="text-align:center;">' . i18n('colLeft') . '</td>';
  echo '<td class="reportTableLineHeader" width="5%" style="text-align:center;">' . strtolower(i18n('sum')) . '</td>';
  echo '</tr>';
  $sumInitial='';
  $sumReal='';
  $sumLeft='';
  $sumPlanned='';
  $sumHandled='';
  $sumDone='';
  $cpt=0;
  $crit=array('idTargetVersion'=>$versId);
  if ($paramResponsible) {
    $crit['idResource']=$paramResponsible;
  }
  if ($paramProject) {
    $crit['idProject']=$paramProject;
  }
	foreach ($lstObj as $obj) {
    $lst=$obj->getSqlElementsFromCriteria($crit);
    $type='id'.get_class($obj).'Type';
    foreach ($lst as $item) {
      $class=get_class($item);
      $item=new $class($item->id);
      $initial=0;
      $real='';
      $left='';
      $planned='';
      $cpt++;
      $pe=get_class($item).'PlanningElement';
      if (isset($item->WorkElement)) {
        $initial=$item->WorkElement->plannedWork;
        $real=$item->WorkElement->realWork;
        $left=$item->WorkElement->leftWork;
        $planned=$real+$left;
      } else if (isset($item->$pe)) {
        $initial=$item->$pe->assignedWork;
        $real=$item->$pe->realWork;
        $left=$item->$pe->leftWork;
        $planned=$real+$left;
      }
      echo '<tr>';
      echo '<td class="reportTableData">' . i18n(get_class($item)) . ' #' . $item->id . '</td>';
      echo '<td class="reportTableData">' . SqlList::getNameFromId('Type',$item->$type) . '</td>';
      echo '<td class="reportTableData" style="text-align:left;">' . $item->name . '</td>';
      echo '<td class="reportTableData">' .formatColor('Status', $item->idStatus) . '</td>';
      echo '<td class="reportTableData">' . SqlList::getNameFromId('Resource',$item->idResource) . '</td>';
      echo '<td class="reportTableData">' . ((isset($item->idPriority))?formatColor('Priority', $item->idPriority):'') . '</td>';
      echo '<td class="reportTableData">' .  Work::displayWorkWithUnit($initial) . '</td>';
      echo '<td class="reportTableData">' .  Work::displayWorkWithUnit($real) . '</td>';
      echo '<td class="reportTableData">' .  Work::displayWorkWithUnit($left) . '</td>';
      echo '<td class="reportTableData">' .  Work::displayWorkWithUnit($planned) . '</td>';
      echo '<td class="reportTableData"><img src="../view/img/checked' . (($item->handled)?'OK':'KO') . '.png" /></td>';
      echo '<td class="reportTableData"><img src="../view/img/checked' . (($item->done)?'OK':'KO') . '.png" /></td>';
      echo '</tr>';
      $sumInitial+=$initial;
      $sumReal+=$real;
      $sumLeft+=$left;
      $sumPlanned+=$planned;
      $sumHandled+=($item->handled)?1:0;
      $sumDone+=($item->done)?1:0;
    }
  }
  $progress=0;
  if ($sumPlanned>0) {
    $progress=round($sumReal/$sumPlanned*100,0);
  }
  echo '<tr>';
  echo '<td class="reportTableHeader" colspan="2">' . i18n('sum') . '</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . $cpt . '</td>';
  echo '<td class="reportTableLineHeader" colspan="3" style="text-align:center;">' . i18n('progress') . ' : ' . $progress . '%</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . Work::displayWorkWithUnit($sumInitial) . '</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . Work::displayWorkWithUnit($sumReal) . '</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . Work::displayWorkWithUnit($sumLeft) . '</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . Work::displayWorkWithUnit($sumPlanned) . '</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . $sumHandled . '</td>';
  echo '<td class="reportTableLineHeader" style="text-align:center;">' . $sumDone . '</td>';
  echo '</tr>';
  echo '</table>';
  echo '<br/>';
}