<?php
$maintenance=true;
require_once "../db/maintenanceFunctions.php";
require_once '../tool/projeqtor.php';
Sql::$maintenanceMode=true;
// TODO : Read zip files in plugin Directory : for each file call load

// TEST
load('translationFrench');


function load($plugin) {
  // TODO : unzip plugIn files
  $descriptorFileName="../plugin/$plugin/pluginDescriptor.xml";
  if (! is_file($descriptorFileName)) {
  	errorLog("cannot find file $descriptorFileName for plugin $plugin");
  	echo "cannot find descriptor for plugin $plugin";
  	exit;
  }
  $descriptorXml=file_get_contents($descriptorFileName);
  $parse = xml_parser_create();
  xml_parse_into_struct($parse, $descriptorXml, $value, $index);
  xml_parser_free($parse);
  
  foreach($value as $prop) {
  	if ($prop['tag']=='PROPERTY') {
  		//print_r($prop);
  		$name=$prop['attributes']['NAME'];
  		$value=$prop['attributes']['VALUE'];
  		$$name=$value;
  	}
  }
  
  if (isset($sql)) {
  	$sqlfile="../plugin/$plugin/$sql";
  	if (! is_file($sqlfile)) {
  		errorLog("cannot find file $sqlfile for plugin $plugin");
  		echo "cannot find Sql file for plugin $plugin";
  		exit;
  	}
  	//$enforceUTF8=true;
  	//Sql::query("SET NAMES utf8");
  	runScript(null,$sqlfile);
  }
  // TODO : delete zip file (in the end when all is OK
}