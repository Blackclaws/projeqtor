<?php
include_once '../tool/projeqtor.php';

$before=9; // Number of hours before change
$after=10; // Number of hours after change
$ratio=$before/$after;

set_time_limit(300);

Sql::beginTransaction();

echo "PlanningElements - Start".'<br/>';
$pe=new PlanningElement();
$peList=$pe->getSqlElementsFromCriteria(array());
echo "PlanningElements - To do : ".count($peList).'<br/>';
foreach($peList as $pe) {
	$pe->validatedWork=$pe->validatedWork*$ratio;
	$pe->save();
	echo "  PlanningElements - id : ".$pe->id.'<br/>';
}
echo "PlanningElements - End".'<br/>';

echo "Assignment - Start".'<br/>';
$ass=new Assignment();
$assList=$ass->getSqlElementsFromCriteria(array());
echo "Assignment - To do : ".count($assList.'<br/>');
foreach ($assList as $ass) {
	$ass->assignedWork=$ass->assignedWork*$ratio;
	$ass->leftWork=$ass->leftWork*$ratio;
	$ass->save();
	echo "  Assignment - id : ".$ass->id.'<br/>';
}
echo "Assignment - End".'<br/>';

echo "Work - Start".'<br/>';
$work=new Work();
$workList=$work->getSqlElementsFromCriteria(array());
echo "Work - To do : ".count($workList).'<br/>';
foreach ($workList as $work) {
	$work->work=$work->work*$ratio;
	$work->save();
	echo "  Work - id : ".$work->id.'<br/>';
}
echo "Work - End".'<br/>';

Sql::commitTransaction();
