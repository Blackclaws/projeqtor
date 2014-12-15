<?php
include_once '../tool/projector.php';
$paramYear='';
if (array_key_exists('yearSpinner',$_REQUEST)) {
  $paramYear=$_REQUEST['yearSpinner'];
};

$paramMonth='';
if (array_key_exists('monthSpinner',$_REQUEST)) {
  $paramMonth=$_REQUEST['monthSpinner'];
};

$paramWeek='';
if (array_key_exists('weekSpinner',$_REQUEST)) {
  $paramWeek=$_REQUEST['weekSpinner'];
};

$user=$_SESSION['user'];
$lstProj=$user->getVisibleProjects();

$periodType=$_REQUEST['periodType'];
$periodValue=$_REQUEST['periodValue'];

// Header
$headerParameters="";
if ($periodType=='year' or $periodType=='month' or $periodType=='week') {
  $headerParameters.= i18n("year") . ' : ' . $paramYear . '<br/>';
  
}
if ($periodType=='month') {
  $headerParameters.= i18n("month") . ' : ' . $paramMonth . '<br/>';
}
if ( $periodType=='week') {
  $headerParameters.= i18n("week") . ' : ' . $paramWeek . '<br/>';
}
include "header.php";

//$where="idProject in " . transformListIntoInClause($user->getVisibleProjects());
$where="1=1 ";
$where.=($periodType=='week')?" and week='" . $periodValue . "'":'';
$where.=($periodType=='month')?" and month='" . $periodValue . "'":'';
$where.=($periodType=='year')?" and year='" . $periodValue . "'":'';
$order="";
//echo $where;
$work=new Work();
$lstWork=$work->getSqlElementsFromCriteria(null,false, $where, $order);
$result=array();
$projects=array();
$resources=array();
$sumProj=array();
foreach ($lstWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Resource', $work->idResource);
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
  }
  if (! array_key_exists($work->idResource,$result)) {
    $result[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource])) {
    $result[$work->idResource][$work->idProject]=0;
  } 
  $result[$work->idResource][$work->idProject]+=$work->work;

}
// title
echo '<table width="95%" align="center"><tr><td class="reportTableHeader" rowspan="2">' . i18n('Resource') . '</td>';
echo '<td colspan="' . count($projects) . '" class="reportTableHeader">' . i18n('Project') . '</td>';
echo '<td class="reportTableHeader" rowspan="2">' . i18n('sum') . '</td>';
echo '</tr><tr>';
foreach ($projects as $id=>$name) {
  echo '<td class="reportTableColumnHeader">' . $name . '</td>';
  $sumProj[$id]=0;  
}

echo '</tr>';

$sum=0;
foreach ($resources as $idR=>$nameR) {
  $sumRes=0;
  echo '<tr><td class="reportTableLineHeader">' . $nameR . '</td>';
  foreach ($projects as $idP=>$nameP) {
    echo '<td class="reportTableData reportTableDataCenter">';
    if (array_key_exists($idR, $result)) {
      if (array_key_exists($idP, $result[$idR])) {
        $val=$result[$idR][$idP];
        echo $val;
        $sumProj[$idP]+=$val; 
        $sumRes+=$val; 
        $sum+=$val;
      } 
    }
    echo '</td>';
  }
  echo '<td class="reportTableColumnHeader">' . $sumRes . '</td>';
  echo '</tr>';
}
echo '<tr><td class="reportTableHeader">' . i18n('sum') . '</td>';
foreach ($projects as $id=>$name) {
  echo '<td class="reportTableColumnHeader">' . $sumProj[$id] . '</td>';
}
echo '<td class="reportTableHeader">' . $sum . '</td></tr>';
echo '</table>';