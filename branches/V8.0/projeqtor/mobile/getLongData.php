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
 * retrives long fields (description, result) for consulted item
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/mobile/getLongData.php');  
 
  $class=$_REQUEST['class'];
  $id=$_REQUEST['id'];
  $obj=new $class($id);
  $sep='##!##!##!##!##';
  echo $obj->description;
  echo $sep;
  echo $obj->result;
  $note=new Note();
  $notes=$note->getSqlElementsFromCriteria(array('refType'=>$class,'refId'=>$id),false,null,'id desc');
  $user=getSessionUser();
  $ress=new Resource($user->id);
  foreach ($notes as $note) {
  	if ($user->id==$note->idUser or $note->idPrivacy==1 or ($note->idPrivacy==2 and $ress->idTeam==$note->idTeam)) {
	  	echo $sep;
	  	echo htmlEncode($note->note,'html');
  	}
  }

?>

