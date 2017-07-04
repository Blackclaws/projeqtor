<?php
/*
 * @author: qCazelles 
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/jsonVersionsPlanning.php');

//ob_start();

echo '{"identifier":"id", "items":[';

$pvsArray = array();

if (isset($_REQUEST['productVersionsListId'])) {
	$pvsArray = $_REQUEST['productVersionsListId'];
}
else {
	for ($i = 0; $i < $_REQUEST['nbPvs']; $i++) {
		$pvsArray[$i] = $_REQUEST['pvNo'.$i];
	}
}

foreach ($pvsArray as $key => $idProductVersion) {
	$productVersion = new ProductVersion($idProductVersion);
	$productVersion->displayVersion();
	
	foreach (ProductVersionStructure::getComposition($productVersion->id) as $key => $idComponentVersion) {
		$componentVersion = new ComponentVersion($idComponentVersion);
		$componentVersion->treatmentVersionPlanning($productVersion);
	}
}

echo ']}';
