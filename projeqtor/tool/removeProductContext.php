<?php
/*
 * 	@author: qCazelles
 */
require_once "../tool/projeqtor.php";

$productContextId=null;
if (array_key_exists('productContextId',$_REQUEST)) {
	$productContextId=$_REQUEST['productContextId'];
	Security::checkValidId($productContextId);
}
$productContextId=trim($productContextId);
if ($productContextId=='') {
	$productContextId=null;
}
if ($productContextId==null) {
	throwError('context id parameter not found in REQUEST');
}
Sql::beginTransaction();
$result='';

$obj=new ProductContext($productContextId);
$result=$obj->delete();

// Message of correct saving
displayLastOperationStatus($result);

?>