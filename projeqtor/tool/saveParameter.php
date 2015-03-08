<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
 * Contributors : 
 *  => g.miraillet : Fix #1502
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

/** ============================================================================
 * Save some information to session (remotely).
 */
require_once "../tool/projeqtor.php";

$status="NO_CHANGE";
$errors="";
$type=$_REQUEST['parameterType'];
Sql::beginTransaction();
if ($type=='habilitation') {
  $crosTable=htmlGetCrossTable('menu', 'profile', 'habilitation') ;
  foreach($crosTable as $lineId => $line) {
    foreach($line as $colId => $val) {
      $crit['idMenu']=$lineId;
      $crit['idProfile']=$colId;
      $obj=SqlElement::getSingleSqlElementFromCriteria('Habilitation', $crit);
      $obj->allowAccess=($val)?1:0;
      $result=$obj->save();
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }
    resetUser();
  }
  Habilitation::correctUpdates(); // Call correct updates 3 times, to assure all level updates
  Habilitation::correctUpdates();
  Habilitation::correctUpdates();
} else if ($type=='habilitationReport') {
  $crosTable=htmlGetCrossTable('report', 'profile', 'habilitationReport') ;
  foreach($crosTable as $lineId => $line) {
    foreach($line as $colId => $val) {
      $crit['idReport']=$lineId;
      $crit['idProfile']=$colId;
      $obj=SqlElement::getSingleSqlElementFromCriteria('HabilitationReport', $crit);
      $obj->allowAccess=($val)?1:0;
      $result=$obj->save();
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }
  }
} else if ($type=='habilitationOther') {
  $crosTable=htmlGetCrossTable(array('imputation'=>i18n('imputationAccess'),
                                     'workValid'=>i18n('workValidate'),
  		                               'diary'=>i18n('diaryAccess'),
                                     'work'=>i18n('workAccess'),
                                     'cost'=>i18n('costAccess'),
  		                               'assignmentView'=>i18n('assignmentViewRight'),
  		                               'assignmentEdit'=>i18n('assignmentEditRight'),
                                     'combo'=>i18n('comboDetailAccess'),
  		                               'checklist'=>i18n('checklistAccess'),
                                     'planning'=>i18n('planningRight'),
  																	 'resourcePlanning'=>i18n('resourcePlanningRight'),
                                     'document'=>i18n('documentUnlockRight'),
                                     'requirement'=>i18n('requirementUnlockRight'),
                                     'reportResourceAll'=>i18n('reportResourceAll')), 
                               'profile', 
                               'habilitationOther') ;
  foreach($crosTable as $lineId => $line) {
    foreach($line as $colId => $val) {
      $crit['scope']=$lineId;
      $crit['idProfile']=$colId;
      $obj=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther', $crit);
      $obj->rightAccess=($val)?$val:0;
      $result=$obj->save();
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }
  }
} else if ($type=='accessRight') {
  $crosTable=htmlGetCrossTable('menuProject', 'profile', 'accessRight') ;
  foreach($crosTable as $lineId => $line) {
    foreach($line as $colId => $val) {
      $crit['idMenu']=$lineId;
      $crit['idProfile']=$colId;
      $obj=SqlElement::getSingleSqlElementFromCriteria('AccessRight', $crit);
      $obj->idAccessProfile=$val;
      $result=$obj->save();
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }
    resetUser();
  }
} else if ($type=='userParameter') {
  $parameterList=Parameter::getParamtersList($type);
  foreach($_REQUEST as $fld => $val) {
    if (array_key_exists($fld, $parameterList)) {
      $user=$_SESSION['user'];
      $crit['idUser']=$user->id;
      $crit['idProject']=null;
      $crit['parameterCode']=$fld;
      $obj=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);
      $obj->parameterValue=$val;
      $result=$obj->save();
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }
  }
} else if ($type=='globalParameter') {
  $parameterList=Parameter::getParamtersList($type);
  foreach($_REQUEST as $fld => $val) {
    if (array_key_exists($fld, $parameterList)) {
      $crit['parameterCode']=$fld;
      $crit['idUser']=null;
      $crit['idProject']=null;
      $obj=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);
      if ($parameterList[$fld]=='time') {
      	$val=substr($val,1,5);
      }
      $val=str_replace('#comma#',',',$val); 
      $obj->parameterValue=$val;
      $obj->idUser=null;
      $obj->idProject=null;
      $result=$obj->save();
      $paramCode='globalParameter_'.$fld;
      $_SESSION[$paramCode]=$val;
      $isSaveOK=strpos($result, 'id="lastOperationStatus" value="OK"');
      $isSaveNO_CHANGE=strpos($result, 'id="lastOperationStatus" value="NO_CHANGE"');
      if ($isSaveNO_CHANGE===false) {
        if ($isSaveOK===false) {
          $status="ERROR";
          $errors=$result;
        } else if ($status=="NO_CHANGE") {
          $status="OK";
        }
      }
    }
  }
  Parameter::clearGlobalParameters();// force refresh 
} else {
   $errors="Save not implemented";
   $status='ERROR';
}
if ($status=='ERROR') {
	Sql::rollbackTransaction();
  echo '<span class="messageERROR" >' . $errors . '</span>';
} else if ($status=='OK'){ 
	Sql::commitTransaction();
  echo '<span class="messageOK" >' . i18n('messageParametersSaved') . '</span>';
} else {
	Sql::rollbackTransaction();
  echo '<span class="messageWARNING" >' . i18n('messageParametersNoChangeSaved') . '</span>';
}
echo '<input type="hidden" id="lastOperation" name="lastOperation" value="save">';
echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="' . $status .'">';

function resetUser() {
	$user=$_SESSION['user'];
  $user->reset();
	$_SESSION['user']=$user;
}
?>