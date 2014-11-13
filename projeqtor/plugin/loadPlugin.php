<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2014 Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * Most of properties are extracted from Dojo Framework.
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

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