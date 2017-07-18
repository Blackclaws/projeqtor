<?php
/*
 * @author : qCazelles
 */
require_once "../tool/projeqtor.php";

// Get the link info
if (! array_key_exists('businessFeatureObjectClass',$_REQUEST)) {
	throwError('businessFeatureObjectClass parameter not found in REQUEST');
}
$objectClass=$_REQUEST['businessFeatureObjectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('businessFeatureObjectId',$_REQUEST)) {
	throwError('businessFeatureObjectId parameter not found in REQUEST');
}
$objectId=$_REQUEST['businessFeatureObjectId'];
Security::checkValidId($objectId);

if (! array_key_exists('businessFeatureName',$_REQUEST)) {
	throwError('businessFeatureName parameter not found in REQUEST');
}
$businessFeatureName=$_REQUEST['businessFeatureName'];

Sql::beginTransaction();
$result="";

$str=new BusinessFeature();

$str->name=$businessFeatureName;
$str->idProduct=$objectId;
$str->creationDate=date('Y-m-d');
$str->idUser=$user->id;;

$result=$str->save();

// Message of correct saving
displayLastOperationStatus($result);