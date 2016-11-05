<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

include_once '../tool/projeqtor.php';
$class=$_REQUEST['class'];
$from=$_REQUEST['statusFrom'];
$to=$_REQUEST['statusTo'];

$obj=new $class();

projeqtor_set_time_limit(600);
$crit=array('idStatus'=>$from);
$lst=$obj->getSqlElementsFromCriteria($crit);
foreach ($lst as $obj) {
	Sql::beginTransaction();
	$obj->idStatus=$to;
	$obj->save();
	echo $class . " #" . $obj->id . " - ". $obj->name . '<br>';
	Sql::commitTransaction();
}
