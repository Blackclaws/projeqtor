<?php
$cptTest=0;
$cptOK=0;
$cptKO=0;
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
	// debugLog to keep
	if ($debugTrace)debugLog("=>$title"); 
  echo '<tr style="border:1px solid #000000;">';
  echo '<td style="width:100px">'.date('H:i:s').'</td>';
  echo '<td style="width:200px">'.$title.'</td>';
  $last='title';
  //$microtime=microtime();
}
function testSubTitle($title){	
	global $last, $microtime, $debugTrace;
	// debugLog to keep
  if ($debugTrace)debugLog("   =>$title");
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
	global $last,$cptTest, $cptOK, $cptKO, $microtime;
	$cptTest+=1;
	$delay=round((microtime(true)-$microtime)*1000,0);
	if ($type=='OK') {$cptOK+=1;} else {$cptKO+=1;}
	echo '<td style="width:100px;">'.$delay.' ms</td>';
  echo '<td style="width:300px;background-color:'.(($type=='OK')?'#AAFFAA':'#FFAAAA').'">'.$msg.'</td></tr>';
  $last='result';
  //$microtime=microtime();
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

function testSummary() {
	global $startTime, $cptOK, $cptKO, $cptTest;
	echo '<div style="position:fixed; right: 10px; top: 10px; width: 150px; font-family:arial;';
	echo 'background-color:'.(($cptKO==0)?'#AAFFAA':'#FFAAAA').'; border: 1px solid #000000">';
	echo '<b>Tests run : </b>'.$cptTest.'<br/>';
	echo '<b>Tests OK : </b>'.$cptOK.'<br/>';
	echo '<b>Tests KO : </b>'.$cptKO.'<br/>';
	echo '<b>Duration : </b>'. (round(microtime(true)-$startTime)). ' s'.'<br/>';
	echo '</div>';
}