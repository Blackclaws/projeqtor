<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : 
 *  => g.miraillet : Fix #1502
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
 * Save some information about subscription so item.
 */
require_once "../tool/projeqtor.php";

$mode=RequestHandler::getExpected('mode',true,array('on','off'));
$class=RequestHandler::getClass('objectClass',true);
$id=RequestHandler::getId('objectId',true);
$userId=RequestHandler::getId('userId',true);
// debugLog("class : ".$class);
// debugLog("id : ".$id);
// debugLog("user id : ".$userId);

$result='OK';
$sub=SqlElement::getSingleSqlElementFromCriteria('Subscription', array('refType'=>$class,'refId'=>$id,'idAffectable'=>$userId));
$prj = new Project($id);
$pe=new PlanningElement();
$we = new WorkElement();
$crit = array('idProject'=>$id);
$prjChildPe = $pe->getSqlElementsFromCriteria($crit);
$prjChildWe = $we->getSqlElementsFromCriteria($crit);
$arrayPeWe = array_merge($prjChildPe,$prjChildWe);
if ($mode=='on' && $class == "Project") {
  foreach ($arrayPeWe as $arrayLst){
      $sub->id = null;
      $sub->idAffectable=$userId;
      $sub->refType=$arrayLst->refType;
      $sub->refId=$arrayLst->refId;
      $sub->idUser=getSessionUser()->id;
      $sub->creationDateTime=date('Y-m-d H:i:s');
      $sub->idProject = $id;
      $message=$sub->save();
      $result=getLastOperationStatus($message);   
  }
} else if ($mode=='off' && $class == "Project") {
  if ($sub->id) {
    $subscription = new Subscription();
    $crit1 = array('idProject'=>$id);
    $subLst = $subscription->getSqlElementsFromCriteria($crit1);
    foreach ($subLst as $subList){
      $subList->delete();
    }
    $message=$sub->delete();
    $result=getLastOperationStatus($message);
  } else {
    $result="ERROR";
    $message=i18n('messageDeleted',array($class));
  }
} else if ($mode=='on' && $class != "Project") {
  if (!$sub->id) {
    debugLog("je passe ici 4");
    $sub->idAffectable=$userId;
    $sub->refType=$class;
    $sub->refId=$id;
    $sub->idUser=getSessionUser()->id;
    $sub->creationDateTime=date('Y-m-d H:i:s');
    $message=$sub->save();
    $result=getLastOperationStatus($message);
  } else {
    $result="ERROR";
    $message=i18n('errorDuplicateLink');
  }
} else if ($mode=='off' && $class != "Project") {
  if ($sub->id) {
    $message=$sub->delete();
    $result=getLastOperationStatus($message);
  } else {
    $result="ERROR";
    $message=i18n('messageDeleted',array($class));
  }
 } else {
  $result="ERROR";
  $message='invalid mode (on/off)';
}
$itemLabel=i18n($class).' #'.$id;
$posTag=strpos($message,'<');
if ($posTag) $message=substr($message,0,$posTag);
$usr=new Affectable($userId);
$userName=($usr->name)?$usr->name:$usr->userName;
echo '{"result":"'.$result.'","itemLabel":"'.$itemLabel.'","objectClass":"'.$class.'","objectId":"'.$id.'", "message":"'.$message.'", "userName":"'.$userName.'", "userId":"'.$userId.'","currentUserId":"'.getSessionUser()->id.'"}';
?>