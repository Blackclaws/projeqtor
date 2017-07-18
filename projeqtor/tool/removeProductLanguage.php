<?php
/*
 * 	@author: qCazelles
 */
require_once "../tool/projeqtor.php";

$productLanguageId=null;
if (array_key_exists('productLanguageId',$_REQUEST)) {
	$productLanguageId=$_REQUEST['productLanguageId'];
	Security::checkValidId($productLanguageId);
}
$productLanguageId=trim($productLanguageId);
if ($productLanguageId=='') {
	$productLanguageId=null;
}
if ($productLanguageId==null) {
	throwError('language id parameter not found in REQUEST');
}
Sql::beginTransaction();
$result='';

$obj=new ProductLanguage($productLanguageId);
$result=$obj->delete();

// Message of correct saving
displayLastOperationStatus($result);

?>