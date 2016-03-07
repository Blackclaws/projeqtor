<?php
/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projector.php";

$status="NO_CHANGE";
$errors="";
$finalResult="";

$rangeType=$_REQUEST['rangeType'];
$rangeValue=$_REQUEST['rangeValue'];
$userId=$_REQUEST['userId'];
$nbLines=$_REQUEST['nbLines'];
if ($rangeType=='week') {
  $nbDays=7;
}

for ($i=1; $i<=$nbLines; $i++) {
  $imputable=$_REQUEST['imputable_' . $i];
  if ($imputable) {
    $line=new ImputationLine();
    $line->refType=$_REQUEST['refType_' . $i];
    $line->refId=$_REQUEST['refId_' . $i];
    $line->idAssignment=$_REQUEST['idAssignment_' . $i];
    $line->idResource=$userId;
    $line->leftWork=$_REQUEST['leftWork_' . $i];;
    $line->imputable=$imputable;
    $arrayWork=array();
    for ($j=1; $j<$nbDays; $j++) {
      $workId=$_REQUEST['workId_' . $i . '_' . $j];
      $workValue=$_REQUEST['workValue_' . $i . '_' . $j];
      $arrayWork[$j]=new Work($workId);
      $arrayWork[$j]->work=$workValue;
      $arrayWork[$j]->idResource=$userId;
      $arrayWork[$j]->idProject=$_REQUEST['idProject_' . $i];;
      $arrayWork[$j]->refType=$line->refType;
      $arrayWork[$j]->refId=$line->refId;
      $arrayWork[$j]->idAssignment=$line->idAssignment;
      $workDate=$_REQUEST['day_' . $j];
      $arrayWork[$j]->setDates($workDate);
    }
    $line->arrayWork=$arrayWork;
    $result=$line->save();
    if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
      $status='ERROR';
      $finalResult=$result;
      break;
    } else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
      $status='OK';
      $finalResult=$result;
    } else { 
      if ($finalResult=="") {
        $finalResult=$result;
      }
    }
    $ass=new Assignment($line->idAssignment);
    $ass->leftWork=$line->leftWork;
    $ass->saveWithRefresh();
  }
}

if ($status=='ERROR') {
  echo '<span class="messageERROR" >' . $finalResult . '</span>';
} else if ($status=='OK'){ 
  echo '<span class="messageOK" >' . i18n('messageImputationSaved') . '</span>';
} else {
  echo '<span class="messageWARNING" >' . i18n('messageNoImputationChange') . '</span>';
}
echo '<input type="hidden" id="lastOperation" name="lastOperation" value="save">';
echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="' . $status .'">';

?>