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
$idReport = getSessionValue('idReport');
$yearSpinner = RequestHandler::getValue('yearSpinner');
$monthSpinner = RequestHandler::getValue('monthSpinner');
$weekSpinner = RequestHandler::getValue('weekSpinner');
if($destination != ''){
  $user = new Resource($destination, true);
  $destination = $user->email;
}
if($otherDestination != '' and $destination != ''){
  $destination = $destination.','.$otherDestination;
}else{
  $destination = $user->email;
}
if($idReport != ''){
	$report = new Report($idReport, true);
	$param = TodayParameter::returnReportParameters($report, true);
	$arrayParam = array();
	foreach ($param as $type=>$value){
	  if($type != 'periodValue' and $type != 'yearSpinner' and $type != 'monthSpinner' and $type != 'weekSpinner'){
	    $arrayParam[$type] = $value;
	  }
	}
	foreach ($arrayParam as $type=>$value){
	  if($type == 'periodType' and $value == 'year'){
	    if (Parameter::getGlobalParameter("reportStartMonth")!='NO') {
  	    $arrayParam['periodValue'] = $yearSpinner;
  	    $arrayParam['yearSpinner'] = $yearSpinner;
  	    $arrayParam['monthSpinner'] = $monthSpinner;
	    }else{
	      $arrayParam['periodValue'] = $yearSpinner;
	      $arrayParam['yearSpinner'] = $yearSpinner;
	    }
	  }
	  if($type == 'periodType' and $value == 'month'){
	  	$arrayParam['periodValue'] = $yearSpinner.$monthSpinner;
	  	$arrayParam['monthSpinner'] = $monthSpinner;
	  	$arrayParam['yearSpinner'] = $yearSpinner;
	  }
	  if($type == 'periodType' and $value == 'week'){
	  	$arrayParam['periodValue'] = $yearSpinner.$weekSpinner;
	  	$arrayParam['weekSpinner'] = $weekSpinner;
	  	$arrayParam['yearSpinner'] = $yearSpinner;
	  }
	}
	$param = json_encode($arrayParam);
}

//open transaction bdd
Sql::beginTransaction();

$autoSendReport = new AutoSendReport();
$autoSendReport->idReport = $report->id;
$autoSendReport->idResource = getCurrentUserId();
if($name != ''){
  $autoSendReport->name = $name;
}else{
  $autoSendReport->name = $report->name.'_'.$sendFrequency;
}
$autoSendReport->email = $destination;
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

// commit
Sql::commitTransaction();
?>