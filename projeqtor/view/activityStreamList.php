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

$paramAllItems=RequestHandler::getNumeric("activityStreamAllItems");
Parameter::storeUserParameter("activityStreamAllItems", $paramAllItems);

$paramAuthorFilter=RequestHandler::getId("activityStreamAuthorFilter");
Parameter::storeUserParameter("activityStreamAuthorFilter", $paramAuthorFilter);

$paramTypeNote=RequestHandler::getValue("activityStreamTypeNote");
debugLog($paramTypeNote);

$limitElement = RequestHandler::getNumeric("activityStreamNumberElement");

$typeNote = SqlList::getNameFromId('Linkable', $paramTypeNote);

$paramProject=getSessionValue('project');

$note = new Note ();
$critWhere="1=1";
if (trim($paramAuthorFilter)!="") {
	$critWhere.=" and idUser=$paramAuthorFilter";
}

if ($paramProject!='*') {
	$critWhere.=" and idProject in ".getVisibleProjectsList(true);
} else {
	$critWhere.=" and idProject in ".getVisibleProjectsList($paramProject);
}

if($paramAllItems=="3"){
  $critWhere.=" ORDER BY creationDate DESC";
}

if($paramAllItems=="2"){
  $critWhere.=" ORDER BY creationDate ASC";
}

if($paramAllItems=="0"){
  $critWhere.=" and refId=1";
}

if($paramAllItems=="5" && $limitElement){
  $critWhere.=" LIMIT ". $limitElement;
}

if($paramAllItems=="4" && trim($paramTypeNote)!=""){
  $critWhere.=" and refType='$typeNote'";
}

var_dump($critWhere);
$notes=$note->getSqlElementsFromCriteria(null,false,$critWhere);

$countIdNote = count ( $notes );
if ($countIdNote == 0) {
  echo i18n ( "noNote" );
  exit ();
}
$onlyCenter = (RequestHandler::getValue ( 'onlyCenter' ) == 'true') ? true : false;
?>
<div dojo-type="dijit.layout.BorderContainer" class="container" style="overflow-y:auto;">
	

<?php var_dump($_REQUEST);?>
	<!-- Titre et listes de notes -->
	<table id="objectStream" style="width: 100%;"> 
	   <?php foreach ($notes as $note) {?>
	    <?php
      $userId = $note->idUser;
      $userName = SqlList::getNameFromId ( 'User', $userId );
      $userNameFormatted = '<span style="color:blue"><strong>' . $userName . '</strong></span>';
      $idNote = '<span style="color:blue">' . $note->id . '</span>';
      $ticketName = '<span style="color:blue">' . $note->refType . ' #' . $note->refId . '</span>';
      $colCommentStream = i18n ( 'addComment', array (
          $idNote,
          $ticketName 
      ) );
      ?>
	  <tr style="height: 100%;">
			<td class="noteData" style="width: 100%;">
				<div style="float: left;">
	              <?php
      echo formatUserThumb ( $note->idUser, $userName, 'Creator', 32 );
      echo formatPrivacyThumb ( $note->idPrivacy, $note->idTeam );
      ?>
	      </div>
				<div style="overflow-x: hidden; padding-left: 4px;">
	    <?php
      $strDataHTML = nl2br ( $note->note );
      echo '<div>' . $userNameFormatted . '&nbsp' . $colCommentStream . '</div>';
      echo '<div style="color:black;margin-top:4px;word-break:break-all;min-width:188px;position:relative;">' . $strDataHTML . '</div>';
      echo '<div style="margin-top:6px;">' . formatDateThumb ( $note->creationDate, null, "left" ) . '</div>';
      echo '<div style="margin-top:11px;">' . $note->creationDate . '</div>';
      ?>
	    <?php };?>
	      </div>
			</td>
		</tr>
	</table>
	<div id="scrollToBottom" type="hidden"></div>