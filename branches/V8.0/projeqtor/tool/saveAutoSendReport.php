<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Save real work allocation.
 */

require_once "../tool/projeqtor.php";

//parameter
$sendFrequency = RequestHandler::getValue('sendFrequency');
$week = RequestHandler::getValue('week');
$monthDay = RequestHandler::getValue('month');
$destination = RequestHandler::getValue('destination');
$otherDestination = RequestHandler::getValue('otherDestination');
$name = RequestHandler::getValue('name');
$sendTime = RequestHandler::getValue('sendTime');
$hours = substr($sendTime, 0, 2);
$minutes = substr($sendTime, 3);
$idReport = RequestHandler::getId('idReport');
$yearParam = RequestHandler::getValue('yearParam');
$monthParam = RequestHandler::getValue('monthParam');
$weekParam = RequestHandler::getValue('weekParam');
$idle = RequestHandler::getValue('idle');
$action = RequestHandler::getValue('action');
$idSendReport = RequestHandler::getId('idSendReport');
$param = array();

//open transaction bdd
Sql::beginTransaction();

if($action == "changeStatus"){
  $autoSendReport = new AutoSendReport($idSendReport, true);
  if($idle == "false"){
    $autoSendReport->idle = 1;
  }else{
    $autoSendReport->idle = 0;
  }
  // save
  $autoSendReport->save();
}
if($action == "delete"){
  $autoSendReport = new AutoSendReport($idSendReport, true);
  $autoSendReport->delete();
}
if($action == ''){
  if(sessionValueExists('reportParametersForDialog')){
  	$param = getSessionValue('reportParametersForDialog');
  }
  $report = new Report($idReport, true);
  $arrayParam = array();
  foreach ($param as $paramName=>$paramValue){
    if($paramName != 'yearSpinner' and $paramName != 'monthSpinner' and $paramName != 'weekSpinner' and $paramName != 'startDate' and $paramName != 'periodValue'){
        $arrayParam[$paramName] = $paramValue;
    }
  }
  foreach ($param as $paramName=>$paramValue){
    if($paramName == 'yearSpinner'){
      $arrayParam[$paramName] = $yearParam;
    }
    if($paramName == 'monthSpinner'){
    	$arrayParam[$paramName] = $monthParam;
    }
    if($paramName == 'weekSpinner'){
    	$arrayParam[$paramName] = $weekParam;
    }
    if($paramName == 'startDate' and $paramValue == date('Y-m-d')){
    	$arrayParam[$paramName] = 'currentDate';
    }else if($paramName == 'startDate' and $paramValue != date('Y-m-d')){
      $arrayParam[$paramName] = $paramValue;
    }
    if($paramName == 'periodType' and $paramValue == 'year'){
      $arrayParam['periodValue'] = $yearParam.'Year';
    }
    if ($paramName == 'periodType' and $paramValue == 'month'){
      $arrayParam['periodValue'] = $yearParam.'Year-'.$monthParam.'Month';
    }
    if ($paramName == 'periodType' and $paramValue == 'week'){
      $arrayParam['periodValue'] = $yearParam.'Year-'.$weekParam.'Week';
    }
  }
  $param = json_encode($arrayParam);
  
  $autoSendReport = new AutoSendReport();
  $autoSendReport->idReport = $report->id;
  $autoSendReport->idResource = getCurrentUserId();
  $autoSendReport->idReceiver = $destination;
  if($name != ''){
    $autoSendReport->name = $name;
  }else{
    $autoSendReport->name = $report->name.'_'.$sendFrequency;
  }
  $autoSendReport->otherReceiver = $otherDestination;
  $autoSendReport->sendFrequency = $sendFrequency;
  $cron = '';
  if($sendTime != ''){
    $cron .= $minutes.' '.$hours.' ';
  }else{
    $cron .= '* * ';
  }
  if($sendFrequency == 'everyMonths'){
    $cron .= $monthDay.' ';
    $cron .= '* ';
  }else{
    $cron .= '* * ';
  }
  if($sendFrequency == 'everyWeeks'){
    $cron .= $week;
  }else{
    $cron .= '*';
  }
  $autoSendReport->cron = $cron;
  $autoSendReport->reportParameter = $param;
  // save
  $autoSendReport->save();
}

// commit
Sql::commitTransaction();
?>