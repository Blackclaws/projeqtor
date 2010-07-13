<?php
include_once '../tool/projector.php';
$paramYear='';
if (array_key_exists('paramYear',$_REQUEST)) {
  $paramYear=$_REQUEST['paramYear'];
};

$paramMonth='';
if (array_key_exists('paramMonth',$_REQUEST)) {
  $paramMonth=$_REQUEST['paramMonth'];
};

$paramWeek='';
if (array_key_exists('paramWeek',$_REQUEST)) {
  $paramWeek=$_REQUEST['paramWeek'];
};

$user=$_SESSION['user'];
$lstProj=$user->getVisibleProjects();

echo "Year:" . $paramYear . '<br/>';
echo "Month:" . $paramMonth . '<br/>';
echo "Week:" . $paramWeek . '<br/>';

//$where="idProject in " . transformListIntoInClause($user->getVisibleProjects());
$where="1=1 ";
$where.=($paramWeek)?" and week='" . paramWeek . "'":'';
$where.=($paramMonth)?" and month='" . $paramMonth . "'":'';
$where.=($paramYear)?" and year='" . $paramYear . "'":'';
$order="";
echo $where;
$work=new Work();
$lstWork=$work->getSqlElementsFromCriteria(null,false, $where, $order);
$result=array();
$projects=array();
$resources=array();
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
    $result[$work->idResource][$work->idProject]=$work->work;
  } else {
    $result[$work->idResource][$work->idProject]+=$work->work;
  }
}
// title
echo '<table><tr><td>' . i18n('Resource') . '</td>';
foreach ($projects as $id=>$name) {
  echo '<td>' . $name . '</td>';  
}
echo '</tr>';

foreach ($resources as $idR=>$nameR) {
  echo '<tr><td>' . $nameR . '</td>';
  foreach ($projects as $idP=>$nameP) {
    echo '<td>';
    if (array_key_exists($idR, $result)) {
      if (array_key_exists($idP, $result[$idR])) {
        echo $result[$idR][$idP];
      } 
    }
    echo '</td>';
  }
  echo '</tr>';
} 
echo '</table>';