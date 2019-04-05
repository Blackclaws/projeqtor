<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : Eliott LEGRAND (from Salto Consulting - 2018) 
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
/**
 * Save a leaveTypeOfEmploymentContractType object from the form sent by dynamicDialogOfEmpContractType.php
 */
// MTY - GENERIC DAY OFF
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/saveGenericBankOffDays.php');

if (! array_key_exists('idGenericBankOffDays',$_REQUEST)) {
  throwError('idGenericBankOffDays parameter not found in REQUEST');
}
$id = $_REQUEST['idGenericBankOffDays'];

if (! array_key_exists('idGenCalendarDefinition',$_REQUEST)) {
  throwError('idGenCalendarDefinition parameter not found in REQUEST');
}
$idCalendarDefinition = $_REQUEST['idGenCalendarDefinition'];

if (! array_key_exists('genericBankOffDayName',$_REQUEST)) {
  throwError('genericBankOffDayName parameter not found in REQUEST');
}
$name = $_REQUEST['genericBankOffDayName'];

if (! array_key_exists('genericBankOffDayMonth',$_REQUEST)) {
  throwError('genericBankOffDayMonth parameter not found in REQUEST');
}
$month = $_REQUEST['genericBankOffDayMonth'];

if (! array_key_exists('genericBankOffDayDay',$_REQUEST)) {
  throwError('genericBankOffDayDay parameter not found in REQUEST');
}
$day = $_REQUEST['genericBankOffDayDay'];

if (! array_key_exists('genericBankOffDayEasterDay',$_REQUEST)) {
  throwError('genericBankOffDayEasterDay parameter not found in REQUEST');
}
$easterDay = $_REQUEST['genericBankOffDayEasterDay'];

Sql::beginTransaction();
$calendarBankOffDays = new CalendarBankOffDays();
$calendarBankOffDays->id = $id;
$calendarBankOffDays->idCalendarDefinition=$idCalendarDefinition;
$calendarBankOffDays->name=$name;
$calendarBankOffDays->month=($month==0?null:$month);
$calendarBankOffDays->day=$day;
$calendarBankOffDays->easterDay=($easterDay==3?null:$easterDay);
$result=$calendarBankOffDays->save();
displayLastOperationStatus($result);