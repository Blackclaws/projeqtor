<?php
/*
 * @author : qCazelles
 */
require_once "../tool/projeqtor.php";

// Get the link info
if (! array_key_exists('productLanguageObjectClass',$_REQUEST)) {
	throwError('productLanguageObjectClass parameter not found in REQUEST');
}
$objectClass=$_REQUEST['productLanguageObjectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('productLanguageObjectId',$_REQUEST)) {
	throwError('productLanguageObjectId parameter not found in REQUEST');
}
$objectId=$_REQUEST['productLanguageObjectId'];
Security::checkValidId($objectId);

if (! array_key_exists('productLanguageListId',$_REQUEST)) {
	throwError('productLanguageListId parameter not found in REQUEST');
}
$listId=$_REQUEST['productLanguageListId'];

$arrayId=array();
if (is_array($listId)) {
	$arrayId=$listId;
} else {
	$arrayId[]=$listId;
}

Sql::beginTransaction();
$result="";

foreach ($arrayId as $id) {
	$str=new ProductLanguage();
	$str->idProduct=$objectId;
	$str->idLanguage=$id;
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