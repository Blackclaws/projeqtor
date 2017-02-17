<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2016 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

//$parametersLocation = "/var/wwwFiles/projectorria/track/config/parameters.php";
//include_once $parametersLocation;
$versionPath="http://projeqtor.org/version/";
$dir="/var/www/version";
$lastStable="V5.5.3";

$arrayVersion=array();
if (! is_dir($dir)) {
	traceLog ("getInstallableVersion.php - directory '$dir' does not exist");
	return;
}
$handle = opendir($dir);
if (! is_resource($handle)) {
	traceLog ("getInstallableVersion.php - Unable to open directory '$dir' ");
	return;
}
while (($file = readdir($handle)) !== false) {
	if ($file == '.' || $file == '..') {
		continue;
	}
	$filepath = $dir == '.' ? $file : $dir . '/' . $file;
	if (is_link($filepath)) {
		continue;
	}
	if (is_file($filepath)) {
	  $info=pathinfo($filepath);
	  if ($info['extension']!='zip') continue;
	  $file=$info['basename'];
	  $vers='V'.explode('V',$info['filename'])[1];
	  $size=filesize($filepath);
	  $arrayVersion[$vers]=array(
	    'name'=>$vers, 
		'stable'=>'N', 
		'lastStable'=>'N', 
		'last'=>'N', 
		'file'=>$file, 
		'size'=>$size);
	}
}
closedir($handle);
uksort ($arrayVersion,'sortVersion');
$cpt=0;
$stVers=''; // Version without patch
foreach ($arrayVersion as $key=>$vers) {
	if ($cpt==0) $vers['last']='Y';
    if ($key==$lastStable) {
		$vers['lastStable']='Y';
	    $vers['stable']='Y';
    }
	$split=explode('.',substr($key,1));
	$curVers=$split[0].'.'.$split[1];
	if ($curVers!=$stVers and $stVers!='') $vers['stable']='Y';
	$cpt++;
	$stVers=$curVers;
	$arrayVersion[$key]=$vers;
}

$currentVersion=null;
if (isset($_REQUEST['currentVersion'])) {
  $currentVersion=$_REQUEST['currentVersion'];
}
$nb=0;
//echo '{"identifier":"id",' ;
//echo '"label": "name",';
echo '{';
//echo ' "items":';
foreach ($arrayVersion as $vers) {
  if ($currentVersion and version_compare($currentVersion,$vers['name'])>=0) continue;
  if ($nb>0) echo ',';
  $nb++;
  echo '"'.$vers['name'].'":{';
  echo '"name":"'.$vers['name'].'"';
  echo ',"stable":"'.$vers['stable'].'"';
  echo ',"lastStable":"'.$vers['lastStable'].'"';
  echo ',"last":"'.$vers['last'].'"';
  echo ',"url":"'.$versionPath.$vers['file'].'"';
  echo ',"size":"'.$vers['size'].'"';
  echo '}';
}
echo '}';

function sortVersion($a,$b) {
	return version_compare($b,$a);
}