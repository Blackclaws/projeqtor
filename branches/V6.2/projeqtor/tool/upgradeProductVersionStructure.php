<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
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

/** ===========================================================================
 * Save a note : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */
require_once "../tool/projeqtor.php";

// Get the link info
if (! array_key_exists('objectClass',$_REQUEST)) {
  throwError('objectClass parameter not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('objectId',$_REQUEST)) {
  throwError('objectId parameter not found in REQUEST');
}
$objectId=$_REQUEST['objectId'];
Security::checkValidId($objectId);

if (! array_key_exists('confirm',$_REQUEST)) {
  throwError('confirm parameter not found in REQUEST');
}
$confirm=Security::checkValidBoolean($_REQUEST['confirm']);

$str=new ProductVersionStructure();
$strList=$str->getSqlElementsFromCriteria(array('idProductVersion'=>$objectId));
Sql::beginTransaction();
$result="";
//Retrieve the existing list of versions 
// and for each version, find the next version for the component
if (!$confirm) {
	echo '<b>'.i18n('upgradeProductVersionStructure').'</b><br/><br/>';
	echo '<table style="width:100%">';
	echo '<tr><td class="noteHeader">'.i18n('colValueBefore').'</td><td class="noteHeader">'.i18n('colValueAfter').'</td></tr>';
}
foreach ($strList as $str) {
	$vers=new ComponentVersion($str->idComponentVersion);
	$oldLabel=$vers->name;
	$newLabel='<i>'.i18n('noChange').'</i>';
	$change=false;
	if ($vers->isEis) $oldLabel.=' <i>('.htmlFormatDate($vers->realEisDate).')</i>';
	$crit="idProduct=$vers->idComponent and isEis=1 and realEisDate is not null";
	$lstCompVers=$vers->getSqlElementsFromCriteria(null,false,$crit,'realEisDate desc');
	if (count($lstCompVers)>0) {
		$new=reset($lstCompVers);
		if ($new->id!=$vers->id) {
			$change=true;
			$str->idComponentVersion=$new->id;
			$newLabel=$new->name.' <i>('.htmlFormatDate($new->realEisDate).')</i>';
		}
	}
	if ($confirm) {
	  $res=$str->save();
	} else {
		echo '<tr><td class="noteData">'.$oldLabel.'</td><td class="noteData">'.$newLabel.'</td></tr>';
	}
	if ($confirm) {
	  if (!$result) {
	    $result=$res;
	  } else if (stripos($res,'id="lastOperationStatus" value="OK"')>0 ) {
	  	if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
	  		$deb=stripos($res,'#');
	  		$fin=stripos($res,' ',$deb);
	  		$resId=substr($res,$deb, $fin-$deb);
	  		$deb=stripos($result,'#');
	      $fin=stripos($result,' ',$deb);
	      $result=substr($result, 0, $fin).','.$resId.substr($result,$fin);
	  	} else {
	  	  $result=$res;
	  	} 
	  }
	}
}
if (!$confirm) {
	echo "</table>";
	echo '<br/>'.i18n("messageConfirmationNeeded").'<br/><br/>';
}
// Message of correct saving
if ($confirm) displayLastOperationStatus($result);
?>