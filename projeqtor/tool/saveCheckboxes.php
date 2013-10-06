<?php
/** ===========================================================================
 * This script stores checkboxes' states
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/saveCheckboxes.php');
header("Content-Type: text/plain"); 
$toStore = (isset($_GET["toStore"])) ? $_GET["toStore"] : NULL;
$toStore=explode(";",$toStore);

Sql::beginTransaction();
if(count($toStore)>1){
	$objClass = $toStore[0];
	$user=$_SESSION['user'];
	$idUser = $user->id;
	unset($toStore[0]);
	unset($toStore[1]);
	$cs=new ColumnSelector();
	$cs->purge("scope='export' and idUser=$idUser and objectClass='$objClass'");
    foreach ($toStore as $store) {
		$cs=new ColumnSelector();
		$cs->scope='export';
		$cs->idUser=$idUser;
		$cs->objectClass=$objClass;
		$cs->field=$store;
		$cs->hidden=1;
		$res=$cs->save();
debugLog($res);
	}
}
Sql::commitTransaction();

?>
