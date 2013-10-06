<?php
/** ===========================================================================
 * This script stores checkboxes' states
 */
require_once "../tool/projector.php";
scriptLog('   ->/tool/saveCheckboxes.php');
header("Content-Type: text/plain"); 
$toStore = (isset($_GET["toStore"])) ? $_GET["toStore"] : NULL;
$toStore=explode(";",$toStore);

if(count($toStore)>1){
	$objClass = $toStore[0];
	$idUser = $toStore[1];
	unset($toStore[0]);
	unset($toStore[1]);
	if(count($toStore)==0) {
		$toStore='';
	} else {
		$toStore=implode(";",$toStore);
	}
	$query='SELECT objclass FROM '.$paramDbPrefix.'printcheckbox WHERE objclass="'.$objClass.'" AND idUser="'.$idUser.'";';
	$result=Sql::query($query);

	$line = Sql::fetchLine($result);
	$checkboxDB=array();
	while($line) {
		$checkboxDB[]=$line;
		$line = Sql::fetchLine($result);
	}

	if(count($checkboxDB)>0){
		$query ="UPDATE '.$paramDbPrefix.'printcheckbox set checkboxes='".$toStore."' WHERE objclass='".$objClass."' AND idUser='".$idUser."';";
	} else {
		$query ="INSERT INTO '.$paramDbPrefix.'printcheckbox (`objclass`,`checkboxes`,`idUser`) VALUES('".$objClass."','".$toStore."','".$idUser."')";
	}
	$result=Sql::query($query);


}

?>
