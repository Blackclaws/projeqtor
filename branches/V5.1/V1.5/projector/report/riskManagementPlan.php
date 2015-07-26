<?php 
// Header
include_once '../tool/projector.php';
include_once('../tool/formatter.php');
$paramProject='';
if (array_key_exists('idProject',$_REQUEST)) {
  $paramProject=trim($_REQUEST['idProject']);
}
  // Header
$headerParameters="";
if ($paramProject!="") {
  $headerParameters.= i18n("colIdProject") . ' : ' . SqlList::getNameFromId('Project', $paramProject) . '<br/>';
}  
include "header.php";

if ($paramProject!="") {
  
}
$queryWhere=" idProject in " . transformListIntoInClause($user->getVisibleProjects());
if ($paramProject!="") {
  $queryWhere.=" and idProject in " . getVisibleProjectsList(true, $paramProject);
}
$queryWhere.=" and idle=0";
$clauseOrderBy=" actualEndDate asc";

echo '<table  width="95%" align="center"><tr><td style="width: 100%" class="section">';
echo i18n('Risk');
echo '</td></tr>';
echo '<tr><td>&nbsp;</td></tr>';
echo '</table>';
$obj=new Risk();
$lst=$obj->getSqlElementsFromCriteria(null, false, $queryWhere, $clauseOrderBy);
echo '<table  width="95%" align="center">';
echo '<tr>';
echo '<td class="largeReportHeader" style="width:3%">' . i18n('colId') . '</td>';
echo '<td class="largeReportHeader" style="width:7%">' . i18n('colType') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('Risk') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('colCause') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('colImpact') . '</td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colSeverityShort') . '</td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colLikelihoodShort') . '</td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colCriticalityShort') . '</td>';
echo '<td class="largeReportHeader" style="width:6%">' . i18n('colResponsible') . '</td>';
echo '<td class="largeReportHeader" style="width:6%">' . i18n('colDueDate') . '<br/><span style="font-size:75%">' . i18n('commentDueDates') . '</span></td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colIdStatus') . '</td>';
echo '<td class="largeReportHeader" style="width:3%">' . i18n('colLink') . '</td>';
echo '<td class="largeReportHeader" style="width:10%">' . i18n('colResult') . '</td>';
echo '</tr>';
foreach ($lst as $risk) {
  echo '<tr>';
  $done=($risk->done)?'Done':'';
  echo '<td class="largeReportData' . $done . '">' . 'R' . $risk->id . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '">' . SqlList::getNameFromId('RiskType', $risk->idRiskType) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $risk->name; 
  if ($risk->description and $risk->name!=$risk->description) { echo ':<br/>' . $risk->description; }
  echo '</td>';
  echo '<td class="largeReportData' . $done . '">' . $risk->cause. '</td>';
  echo '<td class="largeReportData' . $done . '">' . $risk->impact . '</td>';
  
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Severity', $risk->idSeverity) . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Likelihood', $risk->idLikelihood) . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Criticality', $risk->idCriticality) . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '">' . SqlList::getNameFromId('Resource', $risk->idResource) . '</td>';
  echo '<td class="largeReportData' . $done . '"><table width="100%">';
  if ($risk->initialEndDate!=$risk->actualEndDate) {
    echo '<tr ><td align="center" style="text-decoration: line-through;">' . htmlFormatDate($risk->initialEndDate) . '</td></tr>';
    echo '<tr><td align="center">' . htmlFormatDate($risk->actualEndDate) . '</td></tr>';
  } else {
    echo '<tr><td align="center">'. htmlFormatDate($risk->initialEndDate) . '</td></tr>';
    echo '<tr><td align="center">&nbsp;</td></tr>'; 
  }
  echo   '<tr><td align="center" style="font-weight: bold">' . htmlFormatDate($risk->doneDate) . '</td></tr>';
  
  echo '</table></td>';
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Status', $risk->idStatus) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . listLinks($risk) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $risk->result . '</td>';
  echo '</tr>';
}
unset($risk);
echo '</table><br/><br/>';
echo '</page><page>';
echo '<table  width="95%" align="center"><tr><td style="width: 100%" class="section">';
echo i18n('Issue');
echo '</td></tr>';
echo '<tr><td>&nbsp;</td></tr>';
echo '</table>';
$obj=new Issue();
$lst=$obj->getSqlElementsFromCriteria(null, false, $queryWhere, $clauseOrderBy);
echo '<table  width="95%" align="center">';
echo '<tr>';
echo '<td class="largeReportHeader" style="width:3%">' . i18n('colId') . '</td>';
echo '<td class="largeReportHeader" style="width:12%">' . i18n('colType') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('Action') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('colCause') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('colImpact') . '</td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colPriority') . '</td>';
echo '<td class="largeReportHeader" style="width:6%">' . i18n('colResponsible') . '</td>';
echo '<td class="largeReportHeader" style="width:6%">' . i18n('colDueDate') . '<br/><span style="font-size:75%">' . i18n('commentDueDates') . '</span></td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colIdStatus') . '</td>';
echo '<td class="largeReportHeader" style="width:3%">' . i18n('colLink') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('colResult') . '</td>';
echo '</tr>';
foreach ($lst as $issue) {
  echo '<tr>';
  $done=($issue->done)?'Done':'';
  echo '<td class="largeReportData' . $done . '">' . 'I' . $issue->id . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '">' . SqlList::getNameFromId('IssueType', $issue->idIssueType) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $issue->name; 
  if ($issue->description and $issue->name!=$issue->description) { echo ':<br/>' . $issue->description; }
  echo '</td>';
  echo '<td class="largeReportData' . $done . '">' . $issue->cause. '</td>';
  echo '<td class="largeReportData' . $done . '">' . $issue->impact . '</td>';
  
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Priority', $issue->idPriority) . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '">' . SqlList::getNameFromId('Resource', $issue->idResource) . '</td>';
  echo '<td class="largeReportData' . $done . '"><table width="100%">';
  if ($issue->initialEndDate!=$issue->actualEndDate) {
    echo '<tr ><td align="center" style="text-decoration: line-through;">' . htmlFormatDate($issue->initialEndDate) . '</td></tr>';
    echo '<tr><td align="center">' . htmlFormatDate($issue->actualEndDate) . '</td></tr>';
  } else {
    echo '<tr><td align="center">'. htmlFormatDate($issue->initialEndDate) . '</td></tr>';
    echo '<tr><td align="center">&nbsp;</td></tr>'; 
  }
  echo   '<tr><td align="center" style="font-weight: bold">' . htmlFormatDate($issue->doneDate) . '</td></tr>';
  
  echo '</table></td>';
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Status', $issue->idStatus) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . listLinks($issue) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $issue->result . '</td>';
  echo '</tr>';
}
echo '</table><br/><br/>';
unset ($issue);
echo '</page><page>';
echo '<table  width="95%" align="center"><tr><td style="width: 100%" class="section">';
echo i18n('Action');
echo '</td></tr>';
echo '<tr><td>&nbsp;</td></tr>';
echo '</table>';
$obj=new Action();
$clauseOrderBy=" actualDueDate asc";
$lst=$obj->getSqlElementsFromCriteria(null, false, $queryWhere, $clauseOrderBy);
echo '<table  width="95%" align="center">';
echo '<tr>';
echo '<td class="largeReportHeader" style="width:3%">' . i18n('colId') . '</td>';
echo '<td class="largeReportHeader" style="width:10%">' . i18n('colType') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('Action') . '</td>';
echo '<td class="largeReportHeader" style="width:31%">' . i18n('colDescription') . '</td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colPriority') . '</td>';
echo '<td class="largeReportHeader" style="width:7%">' . i18n('colResponsible') . '</td>';
echo '<td class="largeReportHeader" style="width:6%">' . i18n('colDueDate') . '<br/><span style="font-size:75%">' . i18n('commentDueDates') . '</span></td>';
echo '<td class="largeReportHeader" style="width:5%">' . i18n('colIdStatus') . '</td>';
echo '<td class="largeReportHeader" style="width:3%">' . i18n('colLink') . '</td>';
echo '<td class="largeReportHeader" style="width:15%">' . i18n('colResult') . '</td>';
echo '</tr>';
foreach ($lst as $action) {
  echo '<tr>';
  $done=($action->done)?'Done':'';
  echo '<td class="largeReportData' . $done . '">' . 'A' . $action->id . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '">' . SqlList::getNameFromId('ActionType', $action->idActionType) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $action->name . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $action->description . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Priority', $action->idPriority) . '</td>';
  echo '<td align="center" class="largeReportData' . $done . '">' . SqlList::getNameFromId('Resource', $action->idResource) . '</td>';
  echo '<td class="largeReportData' . $done . '"><table width="100%">';
  if ($action->initialDueDate!=$action->actualDueDate) {
    echo '<tr ><td align="center" style="text-decoration: line-through;">' . htmlFormatDate($action->initialDueDate) . '</td></tr>';
    echo '<tr><td align="center">' . htmlFormatDate($action->actualDueDate) . '</td></tr>';
  } else {
    echo '<tr><td align="center">'. htmlFormatDate($action->initialDueDate) . '</td></tr>';
    echo '<tr><td align="center">&nbsp;</td></tr>'; 
  }
  echo   '<tr><td align="center" style="font-weight: bold">' . htmlFormatDate($action->doneDate) . '</td></tr>';
  
  echo '</table></td>';
  echo '<td align="center" class="largeReportData' . $done . '" style="width:5%">' . formatColor('Status', $action->idStatus) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . listLinks($action) . '</td>';
  echo '<td class="largeReportData' . $done . '">' . $action->result . '</td>';
  echo '</tr>';
}
echo '</table><br/>';

function formatColor($type, $val) {
  $obj=new $type($val);
  $color=$obj->color;
  $foreColor='#000000';
  if (strlen($color)==7) {
    $red=substr($color,1,2);
    $green=substr($color,3,2);
    $blue=substr($color,5,2);
    $light=(0.3)*base_convert($red,16,10)+(0.6)*base_convert($green,16,10)+(0.1)*base_convert($blue,16,10);
    if ($light<128) { $foreColor='#FFFFFF'; }
  }

  $result='<div align="center" style="text-align:center; width:50px; background:' . $color . ';color:' . $foreColor . ';">' . SqlList::getNameFromId($type,$val) . '</div>';
  return $result;
}

function listLinks($obj) {
  $lst=Link::getLinksAsListForObject($obj);
  $res='<table style="width:100%; margin:0 ; spacing:0 ; padding: 0">';
  foreach ($lst as $link) {
  $obj=new $link['type']($link['id']);
  $style=($obj->done)?'style="text-decoration: line-through;"':'';
    $res.='<tr><td '. $style . '>' . substr($link['type'],0,1) . $link['id'] . '</td></tr>';
  }
  $res.='</table>';
  return $res;
}
?>
