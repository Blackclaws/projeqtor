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

/*
 * ============================================================================ Presents an object.
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog ( '   ->/view/objectStream.php' );
global $print, $user;
$user = getSessionUser ();

//var_dump($_REQUEST);

if (RequestHandler::isCodeSet('activityStreamNumberElement')) {
	$activityStreamNumberElement=RequestHandler::getValue("activityStreamNumberElement");
	Parameter::storeUserParameter("activityStreamNumberElement", $activityStreamNumberElement);
} else {
	$activityStreamNumberElement=Parameter::getUserParameter("activityStreamNumberElement");
}

if (RequestHandler::isCodeSet('activityStreamAuthorFilter')) {
	$paramAuthorFilter=RequestHandler::getId("activityStreamAuthorFilter");
	Parameter::storeUserParameter("activityStreamAuthorFilter", $paramAuthorFilter);
} else {
	$paramAuthorFilter=Parameter::getUserParameter("activityStreamAuthorFilter");
}

if (RequestHandler::isCodeSet('activityStreamTypeNote')) {
  $paramTypeNote=RequestHandler::getId("activityStreamTypeNote");
  Parameter::storeUserParameter("activityStreamElementType", $paramTypeNote);
} else {
  $paramTypeNote=Parameter::getUserParameter("activityStreamElementType");
}
$typeNote = SqlList::getNameFromId('Linkable', $paramTypeNote);

if (RequestHandler::isCodeSet('activityStreamIdNote')) {
  $paramStreamIdNote=RequestHandler::getId("activityStreamIdNote");
  Parameter::storeUserParameter("activityStreamIdNote", $paramStreamIdNote);
} else {
  $paramStreamIdNote=Parameter::getUserParameter("activityStreamIdNote");
}

if (RequestHandler::isCodeSet('activityStreamNumberDays')) {
  $activityStreamNumberDays=RequestHandler::getNumeric("activityStreamNumberDays");
  Parameter::storeUserParameter("activityStreamNumberDays", $activityStreamNumberDays);
} else {
  $activityStreamNumberDays=Parameter::getUserParameter("activityStreamNumberDays");
}

if (RequestHandler::isCodeSet('activityStreamShowClosed')) {
  $activityStreamShowClosed=RequestHandler::getValue("activityStreamShowClosed");
  Parameter::storeUserParameter("activityStreamShowClosed", $activityStreamShowClosed);
} else {
  $activityStreamShowClosed=Parameter::getUserParameter("activityStreamShowClosed");
}

$activityStreamAddedRecently=null;
  if (RequestHandler::isCodeSet('activityStreamAddedRecently')) {
    $activityStreamAddedRecently=RequestHandler::getValue("activityStreamAddedRecently");
    Parameter::storeUserParameter("activityStreamAddedRecently", $activityStreamAddedRecently);
  } else {
    $activityStreamAddedRecently=Parameter::getUserParameter("activityStreamAddedRecently");
  }

$activityStreamUpdatedRecently=null;
// TODO : $activityStreamUpdatedRecently

$paramProject=getSessionValue('project');

$note = new Note ();
$critWhere="1=1";
if (trim($paramAuthorFilter)!="") {
	$critWhere.=" and idUser=$paramAuthorFilter";
}

if (trim($paramTypeNote)!="") {
  $critWhere.=" and refType='$typeNote'";
}

if (trim($paramStreamIdNote)!="") {
  $critWhere.=" and refId=$paramStreamIdNote";
}

if ($paramProject!='*') {
	$critWhere.=" and idProject in ".getVisibleProjectsList(true);
} else {
	$critWhere.=" and idProject in ".getVisibleProjectsList($paramProject);
}

if ($activityStreamNumberDays){
  if ($activityStreamAddedRecently and $activityStreamUpdatedRecently) {
    $critWhere.=" and ( creationDate>=ADDDATE(NOW(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
    $critWhere.=" or updateDate>=ADDDATE(NOW(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) )";
  } else if ($activityStreamAddedRecently=="added" && trim($activityStreamNumberDays)!=""){
    $critWhere.=" and creationDate>=ADDDATE(NOW(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
  } else if ($activityStreamNumberDays=="updated"){
    $critWhere.=" and updateDate>=ADDDATE(NOW(), INTERVAL (-" . intval($activityStreamNumberDays) . ") DAY) ";
  }
}

//SELECT * FROM `note` WHERE `creationDate`>=ADDDATE(NOW(), INTERVAL (-5) DAY)

// TODO : activate when idle added in Notes
//if ($activityStreamShowClosed!='1') {
//	$critWhere.=" and idle=0";
//}

/*if($paramAllItems=="3"){
  $critWhere.=" ORDER BY creationDate DESC";
}

if($paramAllItems=="2"){
  $critWhere.=" ORDER BY creationDate ASC";
}

if($paramAllItems=="1" && trim($idStreamNote)!=""){
  $critWhere.=" and refId=". $idStreamNote;
}

if($paramAllItems=="5" && $limitElement){
  $critWhere.=" LIMIT ". $limitElement;
}

if($paramAllItems=="4" && trim($paramTypeNote)!=""){
  $critWhere.=" and refType='$typeNote'";
}*/
echo '<br/>';
//var_dump($critWhere);
$notes=$note->getSqlElementsFromCriteria(null,false,$critWhere,null,null,null,$activityStreamNumberElement);

$countIdNote = count ( $notes );
if ($countIdNote == 0) {
  echo i18n ( "noNote" );
  exit ();
}
$onlyCenter = (RequestHandler::getValue ( 'onlyCenter' ) == 'true') ? true : false;
var_dump($_REQUEST);
?>
<div dojo-type="dijit.layout.BorderContainer" class="container" style="overflow-y:auto;">
	<table id="objectStream" style="width: 100%;"> 
	<?php 
	  foreach ($notes as $note) {
	   	// TODO : desactivate when idle added in Notes
      if ($activityStreamShowClosed!='1') {
      	$objType=$note->refType;
      	$obj=new $objType($note->refId);
      	if (property_exists($objType, 'idle') and $obj->idle==1) {
      		continue;
      	}
      }
      activityStreamDisplayNote($note,"activityStream");
	  }?>
	</table>
	<div id="scrollToBottom" type="hidden"></div>
</div>