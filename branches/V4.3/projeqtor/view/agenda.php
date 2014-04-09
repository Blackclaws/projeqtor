<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/agenda.php');  
  
  if (! isset($period)) {
  	$period=htmlentities($_REQUEST['period']);
    $year=htmlentities($_REQUEST['year']);
    $month=htmlentities($_REQUEST['month']);
    $week=htmlentities($_REQUEST['week']);
  }
  $weekDay=1;
  $end=false;
  $day=0;
  $maxDay=date('t',strtotime($year.'-'.$month.'-01'));
  echo '<TABLE style="width:100%; height: 100%; border: 1px solid blue;">';
  echo '<tr height="10px">';
  for ($i=1; $i<=7;$i++) {
  	echo '<td style="width: 14%; border: 1px solid red;background-color:#AAAAFF">'.i18n('colWeekday' . $i).'</td>';
  }
  echo '</tr>';
  echo '<tr height="20%">';
  while (! $end) {
  	if (! $day) {
  		$dTest=mktime(0, 0, 0, $month, '01', $year);
  		if (date("N",$dTest)==$weekDay) {
  			$day=1;
  		}
  	}
  	if (! $day or $day>$maxDay) {
  		echo '<td style="width: 14%; border: 1px solid red;background-color:grey">&nbsp;</td>';
  	} else {
  		echo '<td style="width: 14%; border: 1px solid red;background-color:white">'.$day.'</td>';
  		$day++;
  	}
  	
  	$weekDay+=1;
  	if ($weekDay>7) { 
  		if ($day>=$maxDay) {
  		  $end=true;
  	  } else {
  	  	echo '</tr><tr height="20%">';
  	  	$weekDay=1;
  	  }
  	}
  }
  echo '</tr></TABLE>';
  ?>

