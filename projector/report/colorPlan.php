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
foreach ($lstWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Resource', $work->idResource);
    $result[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
    $projectsColor[$work->idProject]=SqlList::getFieldFromId('Project', $work->idProject, 'color');
  }
  if (! array_key_exists($work->day,$result[$work->idResource])) {
    $result[$work->idResource][$work->day]=array();
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource][$work->day])) {
    $result[$work->idResource][$work->day][$work->idProject]=0;
    $result[$work->idResource][$work->day]['real']=true;
  } 
  $result[$work->idResource][$work->day][$work->idProject]+=$work->work;
  //echo "work : " . $work->day . " / " . $work->idProject . " / " . $work->idResource . " / " . $work->work . "<br/>";
}
$planWork=new PlannedWork();
$lstPlanWork=$planWork->getSqlElementsFromCriteria(null,false, $where, $order);
foreach ($lstPlanWork as $work) {
  if (! array_key_exists($work->idResource,$resources)) {
    $resources[$work->idResource]=SqlList::getNameFromId('Resource', $work->idResource);
    $result[$work->idResource]=array();
  }
  if (! array_key_exists($work->idProject,$projects)) {
    $projects[$work->idProject]=SqlList::getNameFromId('Project', $work->idProject);
    $projectsColor[$work->idProject]=SqlList::getFieldFromId('Project', $work->idProject, 'color');
  }
  if (! array_key_exists($work->day,$result[$work->idResource])) {
    $result[$work->idResource][$work->day]=array();
  }
  if (! array_key_exists($work->idProject,$result[$work->idResource][$work->day])) {
    $result[$work->idResource][$work->day][$work->idProject]=0;
  }
  if (! array_key_exists('real',$result[$work->idResource][$work->day])) { // Do not add planned if real exists 
    $result[$work->idResource][$work->day][$work->idProject]+=$work->work;
  }
}

if ($periodType=='month') {
  $startDate=$periodValue. "01";
  $time=mktime(0, 0, 0, $paramMonth, 1, $paramYear);
  $header=strftime("%B %Y", $time);
  $nbDays=date("t", $time);
}

echo "<table width='95%' align='center'><tr>";
echo "<td class='reportTableDataFull' width='20px'>";
echo "<div style='height:20px;width:20px;position:relative;background-color:#DDDDDD;'>&nbsp;";
echo "<div style='position:absolute;top:3px;left:5px;color:#000000;'>R</div>";
echo "<div style='position:absolute;top:2px;left:6px;color:#FFFFFF;'>R</div>";
echo "</div>";
echo "</td><td width='100px'>" . i18n('colRealWork') . "</td>";
echo "<td width='5px'>&nbsp;&nbsp;&nbsp;</td>";
echo "<td class='reportTableDataFull' width='20px'>";
echo "<div style='height:20px;width:20px;position:relative;background-color:#DDDDDD;'>&nbsp;";
//echo "<div style='position:absolute;top:3px;left:5px;color:#EEEEEE;'>P</div>";
//echo "<div style='position:absolute;top:2px;left:6px;color:#000000;'>P</div>";
echo "</div>";
echo "</td><td width='100px'>" . i18n('colPlannedWork') . "</td>";
echo "<td>&nbsp;</td>";
echo "</tr></table>";
echo "<br/>";
echo "<table width='95%' align='center'><tr>";
foreach($projects as $idP=>$nameP) {
  echo "<td width='20px'>";
  echo "<div style='border:1px solid #AAAAAA ;height:20px;width:20px;position:relative;background-color:" . $projectsColor[$idP] . ";'>&nbsp;";
  echo "</div>";
  echo "</td><td width='100px'>" . $nameP . "</td>";
  echo "<td width='5px'>&nbsp;&nbsp;&nbsp;</td>";
}
echo "<td>&nbsp;</td></tr></table>";
echo "<br/>";
// title
echo '<table width="95%" align="center"><tr><td class="reportTableHeader" rowspan="2">' . i18n('Resource') . '</td>';
echo '<td colspan="' . $nbDays . '" class="reportTableHeader">' . $header . '</td>';
echo '</tr><tr>';
for($i=1; $i<=$nbDays;$i++) {
  if ($periodType=='month') {
    echo '<td class="reportTableColumnHeader">' . (($i<10)?'0':'') . $i . '</td>';
  }  
}

echo '</tr>';

foreach ($resources as $idR=>$nameR) {
  echo '<tr height="20px"><td class="reportTableLineHeader">' . $nameR . '</td>';
  for ($i=1; $i<=$nbDays;$i++) {
    echo '<td class="reportTableDataFull" valign="top">';
    $day=$startDate+$i-1;
    if (array_key_exists($day,$result[$idR])) {
      echo "<div style='position:relative;'>";
      $real=false;
      foreach ($result[$idR][$day] as $idP=>$val) {
        if ($idP=='real') {
          $real=true;
        } else {
          $height=20*$val;
          echo "<div style='position:relative;height:" . $height . "px; background-color:" . $projectsColor[$idP] . ";' ></div>";
        }
      }
      if ($real) {
        echo "<div style='position:absolute;top:3px;left:5px;color:#000000;'>R</div>";
        echo "<div style='position:absolute;top:2px;left:6px;color:#FFFFFF;'>R</div>";
      }
      echo "</div>";
    
    }
    echo '</td>';
  }
  echo '</tr>';
}

echo '</table>';