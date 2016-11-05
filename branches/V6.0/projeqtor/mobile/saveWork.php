<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2014 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 *
 * This file is a plugIn for ProjeQtOr.
 * This plugIn in not Open Source.
 * You must have bought the licence from Copyrigth owner to use this plgIn.
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Save real work for mobile application
 * Converts planned work to real work
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/mobile/saveWork.php');  
 
  $refType=$_REQUEST['refType'];
  $refId=$_REQUEST['refId'];
  $workDate=$_REQUEST['day'];
  $day=str_replace('-','',$workDate);
  $user=getSessionUser();
  $obj=new $refType($refId);
  
  $pw=SqlElement::getSingleSqlElementFromCriteria('PlannedWork', array('idResource'=>$user->id,'refType'=>$refType,'refId'=>$refId,'day'=>$day));
  $ass=new Assignment($pw->idAssignment);
  
  $status="";
  $finalResult="";
  if (! $pw->id or ! $ass->id) {
  	$status=='ERROR';
  	$finalResult="ERROR - no planned work found or no assignment found";
  }
  Sql::beginTransaction();
  if ($status!='ERROR') {
		$work=new Work();
	  $work->work=$pw->work;
	  $work->idResource=$user->id;
	  $work->idProject=$pw->idProject;
	  $work->refType=$refType;
	  $work->refId=$refId;
	  $work->idAssignment=$ass->id;
	  $work->setDates($workDate);
	  $result=$work->save();
	  if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
	  	$status='ERROR';
	  	$finalResult=$result;
	  	break;
	  } else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
	  	$status='OK';
	  } else {
	  	if ($finalResult=="") {
	  		$finalResult=$result;
	  	}
	  }
  }
  if ($status!='ERROR') {
  	$ass->leftWork=$ass->leftWork-$pw->work;
  	if ($ass->leftWork<0) $ass->leftWork=0;
  	$resultAss=$ass->saveWithRefresh();
	  if (stripos($resultAss,'id="lastOperationStatus" value="OK"')>0 ) {
	  	$status='OK';
	  } else if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ){
	  	$status='ERROR';
	  	$finalResult=$resultAss;
	  	break;
	  }
  }
  if ($status!='ERROR') {
  	$resPw=$pw->delete();
  }
  
  if ($status=='ERROR') {
  	Sql::rollbackTransaction();
  	echo '<span class="messageERROR" >' . $finalResult . '</span>';
  } else if ($status=='OK'){
  	Sql::commitTransaction();
  	echo '<span class="messageOK" >' . i18n('messageImputationSaved') . '</span>';
  } else {
  	Sql::rollbackTransaction();
  	echo '<span class="messageWARNING" >' . i18n('messageNoImputationChange') . '</span>';
  }
  echo '<input type="hidden" id="lastOperation" name="lastOperation" value="save">';
  echo '<input type="hidden" id="lastOperationStatus" name="lastOperationStatus" value="' . $status .'">';

?>

