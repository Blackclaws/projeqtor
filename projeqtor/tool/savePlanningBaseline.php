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

/** ===========================================================================
 * Run planning
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/savePlanningBaseline.php');
if (! array_key_exists('idProjectPlanBaseline',$_REQUEST)) {
  throwError('idProjectPlanBaseline parameter not found in REQUEST');
}
$idProject=$_REQUEST['idProjectPlanBaseline']; // validated to be numeric in SqlElement base constructor
Security::checkValidId($idProject);

if (! array_key_exists('namePlanBaseline',$_REQUEST)) {
  throwError('namePlanBaseline parameter not found in REQUEST');
}
$name=$_REQUEST['namePlanBaseline']; // validated to be numeric in SqlElement base constructor
$name=htmlEncode($name);

if (! array_key_exists('datePlanBaseline',$_REQUEST)) {
  throwError('datePlanBaseline parameter not found in REQUEST');
}
$date=$_REQUEST['datePlanBaseline']; // validated to be numeric in SqlElement base constructor
Security::checkValidDateTime($date);

if (! array_key_exists('planBaselinePrivacy',$_REQUEST)) {
  throwError('planBaselinePrivacy parameter not found in REQUEST');
}
$privacy=$_REQUEST['planBaselinePrivacy']; // validated to be numeric in SqlElement base constructor
Security::checkValidInteger($privacy);

$baseline=new Baseline();
$baseline->idProject=$idProject;
$baseline->baselineNumber=null;
$baseline->name=$name;
$baseline->baselineDate=$date;
$baseline->idUser=getSessionUser()->id;
$baseline->creationDateTime=date('Y-m-d H:i:s');
$baseline->idPrivacy=$privacy;
$res=new Resource(getSessionUser()->id);
$baseline->idTeam=$res->idTeam;

projeqtor_set_time_limit(600);
Sql::beginTransaction();
$result=$baseline->saveWithPlanning();
$result.= '<input type="hidden" id="lastPlanStatus" value="OK" />';
// return $result;
// Message of correct saving
displayLastOperationStatus($result);

// Once long treatment has been done (and after commit), define Number
$max=$baseline->countSqlElementsFromCriteria(array('idProject'=>$idProject));
$baseline->baselineNumber=$max;
$baseline->save();


?>