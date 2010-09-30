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
$projectsColor=array();
$resources=array();
$realDays=array();
foreach ($lstWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Resource', $work->idResource);
    $result[$work->idResource]=array();
    $realDays[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
    $projectsColor[$work->idProject]=SqlList::getFieldFromId('Project', $work->idProject, 'color');
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource])) {
    $result[$work->idResource][$work->idProject]=array();
  }
  if (! array_key_exists($work->day,$result[$work->idResource][$work->idProject])) {
    $result[$work->idResource][$work->idProject][$work->day]=0;
    $realDays[$work->idResource][$work->day]='real';
  } 
  $result[$work->idResource][$work->idProject][$work->day]+=$work->work;
}
$planWork=new PlannedWork();
$lstPlanWork=$planWork->getSqlElementsFromCriteria(null,false, $where, $order);
foreach ($lstPlanWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Resource', $work->idResource);
    $result[$work->idResource]=array();
    $realDays[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
    $projectsColor[$work->idProject]=SqlList::getFieldFromId('Project', $work->idProject, 'color');
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource])) {
    $result[$work->idResource][$work->idProject]=array();
  }
  if (! array_key_exists($work->day,$result[$work->idResource][$work->idProject])) {
    $result[$work->idResource][$work->idProject][$work->day]=0;
  }
  if (! array_key_exists($work->day,$realDays[$work->idResource])) { // Do not add planned if real exists 
    $result[$work->idResource][$work->idProject][$work->day]+=$work->work;
  }
}

if ($periodType=='month') {
  $startDate=$periodValue. "01";
  $time=mktime(0, 0, 0, $paramMonth, 1, $paramYear);
  $header=strftime("%B %Y", $time);
  $nbDays=date("t", $time);
}
$weekendBGColor='#cfcfcf';
$weekendFrontColor='#555555';
$weekendStyle=' style="background-color:' . $weekendBGColor . '; color:' . $weekendFrontColor . '" ';
$plannedBGColor='#FFFFDD';
$plannedFrontColor='#777777';
$plannedStyle=' style="text-align:center;background-color:' . $plannedBGColor . '; color: ' . $plannedFrontColor . ';" ';

echo "<table width='95%' align='center'><tr>";
echo "<td class='reportTableDataFull' width='20px' style='text-align:center;'>";
echo "1";
echo "</td><td width='100px' class='legend'>" . i18n('colRealWork') . "</td>";
echo "<td width='5px'>&nbsp;&nbsp;&nbsp;</td>";
echo '<td class="reportTableDataFull" ' . $plannedStyle . '>';
echo "<i>1</i>";
echo "</td><td width='100px' class='legend'>" . i18n('colPlannedWork') . "</td>";
echo "<td>&nbsp;</td>";
echo "</tr></table>";
echo "<br/>";

// title
echo '<table width="95%" align="center"><tr>';
echo '<td class="reportTableHeader" rowspan="2">' . i18n('Resource') . '</td>';
echo '<td class="reportTableHeader" rowspan="2">' . i18n('Project') . '</td>';
echo '<td colspan="' . ($nbDays+1) . '" class="reportTableHeader">' . $header . '</td>';
echo '</tr><tr>';
$days=array();
for($i=1; $i<=$nbDays;$i++) {
  if ($periodType=='month') {
    $day=(($i<10)?'0':'') . $i;
    if (isOffDay(substr($periodValue,0,4) . "-" . substr($periodValue,4,2) . "-" . $day)) {
      $days[$periodValue . $day]="off";
      $style=$weekendStyle;
    } else {
      $days[$periodValue . $day]="open";
      $style='';
    }
    echo '<td class="reportTableColumnHeader" ' . $style . '>' . $day . '</td>';
  }  
}
echo '<td class="reportTableHeader" >' . i18n('sum'). '</td>';
echo '</tr>';

$globalSum=array();
for ($i=1; $i<=$nbDays;$i++) {
  $globalSum[$startDate+$i-1]='';
}
foreach ($resources as $idR=>$nameR) {
  $sum=array();
  for ($i=1; $i<=$nbDays;$i++) {
    $sum[$startDate+$i-1]='';
  }
  echo '<tr height="20px"><td class="reportTableLineHeader" rowspan="'. (count($result[$idR])+1) . '">' . $nameR . '</td>';
  foreach ($result[$idR] as $idP=>$proj) {
    if (array_key_exists($idP, $projects)) {
      echo '<td class="reportTableData" style="text-align: left;">' . $projects[$idP] . '</td>';
      $lineSum='';
      for ($i=1; $i<=$nbDays;$i++) {
        $day=$startDate+$i-1;
        $style="";
        $ital=false;
        if ($days[$day]=="off") {
          $style=$weekendStyle;
        } else {
          if (! array_key_exists($day, $realDays[$idR]) 
          and array_key_exists($day,$result[$idR][$idP])) {
            $style=$plannedStyle;
            $ital=true;
          }
        }
        echo '<td class="reportTableData" ' . $style . ' valign="top">';
        if (array_key_exists($day,$result[$idR][$idP])) {
          echo ($ital)?'<i>':'';
          echo $result[$idR][$idP][$day];
          echo ($ital)?'</i>':'';
          $sum[$day]+=$result[$idR][$idP][$day];
          $globalSum[$day]+=$result[$idR][$idP][$day];
          $lineSum+=$result[$idR][$idP][$day];
        }
        echo '</td>';
      }
      echo '<td class="reportTableColumnHeader">' . $lineSum . '</td>';
      echo '</tr>';
    }
  }
  echo '<tr><td class="reportTableLineHeader" >' . i18n('sum') . '</td>';
  $lineSum='';
  for ($i=1; $i<=$nbDays;$i++) {
    $style='';
    $day=$startDate+$i-1;
    if ($days[$day]=="off") {
          $style=$weekendStyle;
    }
    echo '<td class="reportTableColumnHeader" ' . $style . ' >' . $sum[$startDate+$i-1] . '</td>';
    $lineSum+=$sum[$startDate+$i-1];
  }
  echo '<td class="reportTableHeader">' . $lineSum . '</td>';
  echo '</tr>';
  
}
echo "<tr><td>&nbsp;</td></tr>";
echo '<tr><td class="reportTableHeader" colspan="2">' . i18n('sum') . '</td>';
$lineSum='';
for ($i=1; $i<=$nbDays;$i++) {
  $style='';
  $day=$startDate+$i-1;
  if ($days[$day]=="off") {
    $style=$weekendStyle;
  }
  echo '<td class="reportTableHeader" ' . $style . '>' . $globalSum[$startDate+$i-1] . '</td>';
  $lineSum+=$globalSum[$startDate+$i-1];
}
echo '<td class="reportTableHeader">' . $lineSum . '</td>';
echo '</tr>';
echo '</table>';