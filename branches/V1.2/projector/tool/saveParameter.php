<?php
/** ============================================================================
 * Save some information to session (remotely).
 */
require_once "../tool/projector.php";

$status="NO_CHANGE";
$errors="";
$type=$_REQUEST['parameterType'];
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
  }
  Habilitation::correctUpdates(); // Call correct updates 3 times, to assure all level updates
  Habilitation::correctUpdates();
  Habilitation::correctUpdates();
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
} else {
   $errors="Save not implemented";
   $status='ERROR';
}
if ($status=='ERROR') {
  echo '<span class="messageERROR" >' . $errors . '</span>';
} else if ($status=='OK'){ 
  echo '<span class="messageOK" >' . i18n('messageParametersSaved') . '</span>';
} else {
  echo '<span class="messageWARNING" >' . i18n('messageParametersNoChangeSaved') . '</span>';
}
echo '<input type="hidden" id="lastOperation" name="lastOperation" value="save">';
echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="' . $status .'">';

?>