<?php
/*
 * @author : qCazelles
 */
require_once "../tool/projeqtor.php";

// Get the link info
if (! array_key_exists('productContextObjectClass',$_REQUEST)) {
	throwError('productContextObjectClass parameter not found in REQUEST');
}
$objectClass=$_REQUEST['productContextObjectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('productContextObjectId',$_REQUEST)) {
	throwError('productContextObjectId parameter not found in REQUEST');
}
$objectId=$_REQUEST['productContextObjectId'];
Security::checkValidId($objectId);

if (! array_key_exists('productContextListId',$_REQUEST)) {
	throwError('productContextListId parameter not found in REQUEST');
}
$listId=$_REQUEST['productContextListId'];

$arrayId=array();
if (is_array($listId)) {
	$arrayId=$listId;
} else {
	$arrayId[]=$listId;
}

Sql::beginTransaction();
$result="";

foreach ($arrayId as $id) {
	$str=new ProductContext();
	$str->idProduct=$objectId;
	$str->idContext=$id;
	$str->idUser=$user->id;
	$str->creationDate=date("Y-m-d");
	$res=$str->save();
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

// Message of correct saving
displayLastOperationStatus($result);

?>