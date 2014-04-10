<?php 
/* ============================================================================
 * Presents an object. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/diary.php');  
  
  if (! isset($period)) {
  	$period=htmlentities($_REQUEST['period']);
    $year=htmlentities($_REQUEST['year']);
    $month=htmlentities($_REQUEST['month']);
    $week=htmlentities($_REQUEST['week']);
  }
  $idRessource=$_SESSION['user']->id;
  
  $weekDaysCaption=array(
  		1=>i18n("Monday"),
  		2=>i18n("Tuesday"),
  		3=>i18n("Wednesday"),
  		4=>i18n("Thursday"),
  		5=>i18n("Friday"),
  		6=>i18n("Saturday"),
  		7=>i18n("Sunday"),
  );
  $weekDay=1;
  $end=false;
  $day=0;
  $projectColorArray=array();
  $maxDay=date('t',strtotime($year.'-'.$month.'-01'));
  if ($period=="month") {
    $week=weekNumber($year.'-'.$month.'-01');
  }
  $currentDay=date('Y-m-d',firstDayofWeek($week,$year));
  echo '<TABLE style="width:100%; height: 100%; border: 1px solid blue;">';
  echo '<tr height="10px">';
  for ($i=1; $i<=7;$i++) {
  	echo '<td class="section" style="width: 14%;">'.$weekDaysCaption[$i].'</td>';
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
  		echo '<td style="width: 14%; border: 1px solid white;background-color:transparent">';
  		drawDay($currentDay,$idRessource,false); 
  		echo '</td>';
  	} else {
  		echo '<td style="width: 14%; border: 1px solid #AAAAAA;background-color:white">';
  		$dayx=($day>9)?$day:'0'.$day;
  		drawDay("$year-$month-$dayx",$idRessource,true); 
  		echo '</td>';
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
  	$currentDay=addDaysToDate($currentDay, 1);
  }
  echo '</tr></TABLE>';
  
function drawDay($date,$ress,$inScopeDay) {
	echo '<table style="width:100%; height: 100%">';
	echo '<tr style="height:10px">';
	echo '<td class="reportHeader" '.((!$inScopeDay)?' style="color:#AAAAAA"':'').'>';
	//echo $date.'/';
	echo substr($date,8,2);
	echo '</td>';
	echo '</tr>';
	echo '<tr >';
	echo '<td style="backgroud-color:red; vertical-align:top">';
	echo '<div style="overflow-y: auto; overflow-y:none; height:100%;">';
	echo '<table style="width:100%">';
	$lst=getActivity($date,$ress);
	foreach ($lst as $item) {
		echo '<tr>';
		echo '<td style="padding: 3px 3px 0px 3px; width:100%">';
		echo '<div style="border:1px solid: #EEEEEE; box-shadow: 2px 2px 4px #AAAAAA; width: 100%;background-color:'.$item['color'].'">';
		echo '<table><tr><td>';
		echo '<img src="../view/css/images/icon'.$item['type'].'16.png"/></td><td style="width:1px">';
		echo '</td><td style="color:#555555">';
		echo '<div style="cursor:pointer;color:'.getForeColor($item['color']).'" onClick="gotoElement(\''.$item['type'].'\', '.$item['id'].', false);" >'.$item['display'].'</div>';
		echo '</td></tr></table>';
		echo '</div>';
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';	
	echo '</div>';
	echo '</td>';		
	echo '</tr>';
	echo '</table>';
}

function getActivity($date,$ress) {
	global $projectColorArray;
	$pw=new PlannedWork();
	$result=array();
	$crit=array('idResource'=>$ress,'workDate'=>$date);
	$pwList=$pw->getSqlElementsFromCriteria($crit);
	foreach ($pwList as $pw) {
		$item=new $pw->refType($pw->refId);
		if ($pw->refType=='Meeting') {
			$display=substr($item->meetingStartTime,0,5).' - '.htmlEncode($item->name);
		} else {
		  $display='<i>('.Work::displayWorkWithUnit($pw->work).')</i> '.htmlEncode($item->name);
		}
		if (array_key_exists($item->idProject,$projectColorArray)) {
			$color=$projectColorArray[$item->idProject];
		} else {
			$pro=new Project($item->idProject);
			$color=$pro->color;
			$projectColorArray[$item->idProject]=$color;
		}
		$result[$pw->refType.'#'.$pw->refId]=array(
				'type'=>$pw->refType,
		    'id'=>$pw->refId,
				'work'=>$pw->work,
				'name'=>$item->name,
				'color'=>$color,
				'display'=>$display
		);
	}
	return $result;
}
  ?>

