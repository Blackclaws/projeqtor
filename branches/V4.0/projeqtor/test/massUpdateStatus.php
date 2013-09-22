<?php
include_once '../tool/projeqtor.php';
$class=$_REQUEST['class'];
$from=$_REQUEST['statusFrom'];
$to=$_REQUEST['statusTo'];

$obj=new $class();

set_time_limit(600);
$crit=array('idStatus'=>$from);
$lst=$obj->getSqlElementsFromCriteria($crit);
foreach ($lst as $obj) {
	Sql::beginTransaction();
	$obj->idStatus=$to;
	$obj->save();
	echo $class . " #" . $obj->id . " - ". $obj->name . '<br>';
	Sql::commitTransaction();
}
