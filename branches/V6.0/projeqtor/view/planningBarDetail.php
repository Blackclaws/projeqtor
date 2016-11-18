<?php
include_once "../tool/projeqtor.php";

$class=null;
if (isset($_REQUEST['class'])) {
  $class=$_REQUEST['class'];
}
Security::checkValidClass($class);

$id=null;
if (isset($_REQUEST['id'])) {
  $id=$_REQUEST['id'];
}
Security::checkValidId($id);

$dates=array();
$work=array();

$crit=array('refType'=>$class,'refId'=>$id);

$pe=SqlElement::getSingleSqlElementFromCriteria($class, $critArray);


$wk=new Work();
$wkLst=$wk->getSqlElementsFromCriteria($crit);
foreach($wkLst as $wk) {
  $dates[$wk->workDate]=$wk->workDate;
  if (! isset($work[$wk->idAssignment])) $work[$wk->idAssignment]=array();
  if (! isset($work[$wk->idAssignment]['ressource'])) $work[$wk->idAssignment]['ressource']=SqlList::getNameFromId('Resource', $wk->idResource);
  $work[$wk->idAssignment][$wk->workDate]=array('work'=>$wk->work,'type'=>'real');
}

$wk=new PlannedWork();
$wkLst=$wk->getSqlElementsFromCriteria($crit);
foreach($wkLst as $wk) {
  $dates[$wk->workDate]=$wk->workDate;
  if (! isset($work[$wk->idAssignment])) $work[$wk->idAssignment]=array();
  if (! isset($work[$wk->idAssignment]['resource'])) $work[$wk->idAssignment]['ressource']=SqlList::getNameFromId('Resource', $wk->idResource);
  if (! isset($work[$wk->idAssignment][$wk->workDate]) ) {
    $work[$wk->idAssignment][$wk->workDate]=array('work'=>$wk->work,'type'=>'planned');
  }
}
ksort($dates);
echo '<table>';
foreach ($work as $res) {
  echo '<tr style="height:20px">';
  echo '<td><div style="width:200px; max-width:200px;overflow:hidden">'.$res['resource'].'</div></td>';
  foreach ($dates as $dt) {
    $color="#ffffff";
    $height=0;
    if (isset($res[$dt])) {
      $height=$res[$dt][$work]
    }
    echo '<td style="width:20px"><div style"width:100%;height:'.$height.'%;color:'.$color.'"></div></td>'
  }
  echo '</tr>';
}
echo '</table>';