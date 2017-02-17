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

$cptTest=0;
$cptOK=0;
$cptKO=0;
$cptCTRL=0;
$startTime=microtime(true);
$last='';
$microtime=microtime(true);
$debugTrace=false;
function testHeader($title){
	echo '<table style="font-size: 12px;font-family:arial;border:1px solid #000000;border-collapse:collapse;">';
	echo '<tr><td style="background-color:#EEEEEE;font-weight:bold; font-size:15px; text-align:center;" colspan="5">'.$title.'</td></tr>';  
}
function testFooter(){
	echo '</table>';
}
function testTitle($title){
	global $last, $microtime, $debugTrace;
	if ($debugTrace) debugTraceLog("=>$title"); 
  echo '<tr style="border:1px solid #000000;">';
  echo '<td style="width:100px">'.date('H:i:s').'</td>';
  echo '<td style="width:200px">'.$title.'</td>';
  $last='title';
  //$microtime=microtime();
}
function testSubTitle($title){	
	global $last, $microtime, $debugTrace;
  if ($debugTrace) debugTraceLog("   =>$title");
	if ($last=='sublevel') {
		echo '<td></td></tr><tr style="border:1px solid #000000;"><td></td>';
	} else {
		if ($last=='result'){
			echo '<tr style="border:1px solid #000000;">';
			echo '<td style="width:100px">'.date('H:i:s').'</td>';
			echo '<td></td>';
		}
	}
	$microtime=microtime(true);
  echo '<td style="width:100px">'.$title.'</td>';
  $last='subtitle';
}
function testResult($msg,$type){
	global $last,$cptTest, $cptOK, $cptKO, $cptCTRL, $microtime;
	$cptTest+=1;
	$delay=round((microtime(true)-$microtime)*1000,0);
	$color="#FFFFFF";
	if ($type=='OK') {
		$cptOK+=1;
		$color='#AAFFAA';
	} else if ($type=="CTRL") {
		$cptCTRL+=1;
		$color='#AAAAFF';
	} else {
		$cptKO+=1;
		$color='#FFAAAA';
	}
	echo '<td style="width:100px;">'.$delay.' ms</td>';
  echo '<td style="width:300px;background-color:'.$color.'">'.$msg.'</td></tr>';
  $last='result';
  //$microtime=microtime();
}

function testCheck($result,$test) {
	//$cptTest+=1;
	  if (stripos($result,$test)>0 and stripos($result,'id="lastOperationStatus" value="OK"')>0) {
			//$ctpOK+=1;
			return 'OK';
		} else  if (stripos($result,$test)>0 and stripos($result,'id="lastOperationStatus" value="INVALID"')>0) {
			return 'CTRL';
		} else {
			//$cptOK+=1;
			return 'KO';
		}
}

function testSummary() {
	global $startTime, $cptOK, $cptKO, $cptTest, $cptCTRL;
	echo '<div style="position:fixed; right: 10px; top: 10px; width: 150px; font-family:arial;';
	echo 'background-color:'.(($cptKO==0)?($cptCTRL==0)?'#AAFFAA':'#AAAAFF':'#FFAAAA').'; border: 1px solid #000000">';
	echo '<b>Tests run : </b>'.$cptTest.'<br/>';
	echo '<b>Tests OK : </b>'.$cptOK.'<br/>';
	echo '<b>Tests Ctrl : </b>'.$cptCTRL.'<br/>';
	echo '<b>Tests KO : </b>'.$cptKO.'<br/>';
	echo '<b>Duration : </b>'. (round(microtime(true)-$startTime)). ' s'.'<br/>';
	echo '</div>';
}