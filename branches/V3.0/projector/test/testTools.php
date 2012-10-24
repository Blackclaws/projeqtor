<?php
$cptTest=0;
$cptOK=0;
$cptKO=0;
$last='';
function testHeader($title){
	echo '<table style="font-family:arial;border:1px solid #000000;border-collapse:collapse;">';
	echo '<tr style="background-color:#ffffff;fonct-weight:bold" colspan="3">'.$title.'</tr>';  
}
function testFooter(){
	echo '</table>';
}
function testTitle($title){
	global $last;
  echo '<tr style="border:1px solid #000000;"><td style="width:200px">'.$title.'</td>';
  $last='title';
}
function testSubTitle($title){
	global $last;
	if ($last=='sublevel') {
		echo '<td></td></tr><tr style="border:1px solid #000000;"><td></td>';
	} else {
		if ($last=='result'){
			echo '<tr style="border:1px solid #000000;"><td></td>';
		}
	}
  echo '<td style="width:200px">'.$title.'</td>';
  $last='subtitle';
}
function testResult($msg,$type){
	global $last,$cptTest, $cptOK, $cptKO;
	$cptTest+=1;
	if ($type=='OK') {$cptOK+=1;} else {$cptKO+=1;}
  echo '<td style="width:300px;background-color:'.(($type=='OK')?'#AAFFAA':'#FFAAAA').'">'.$msg.'</td></tr>';
  $last='result';
}

function testCheck($result,$test) {
	//$cptTest+=1;
	  if (stripos($result,$test)>0 and stripos($result,'id="lastOperationStatus" value="OK"')>0) {
			//$ctpOK+=1;
			return 'OK';
		} else {
			//$cptOK+=1;
			return 'KO';
		}
}