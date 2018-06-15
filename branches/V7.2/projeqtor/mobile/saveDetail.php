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
 * Save detail for mobile application
 * Restricted to some fields : result, ... 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/mobile/saveDetail.php');  
 
  $class=$_REQUEST['mobileType'];
  $id=$_REQUEST['mobileId'];
  $obj=new $class($id);
  $obj->result=$_REQUEST['mobileResult'];
  
  Sql::beginTransaction();
  $result=$obj->save();
  
	if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
		Sql::rollbackTransaction();
	  echo '<span class="messageERROR" >' . $result . '</span>';
	} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
		Sql::commitTransaction();
	  echo '<span class="messageOK" >' . $result . '</span>';
	} else { 
		Sql::rollbackTransaction();
	  echo '<span class="messageWARNING" >' . $result . '</span>';
	}
?>

